<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNhanVienRequest;
use App\Http\Requests\DeleteNhanVienRequest;
use App\Http\Requests\LoginNhanVienRequest;
use App\Http\Requests\UpdateNhanVienRequest;
use App\Mail\MasterMail;
use App\Models\NhanVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class NhanVienController extends Controller
{
    // Login
    public function login(LoginNhanVienRequest $request)
    {
        $authen = Auth::guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($authen) {
            $user = Auth::guard('admin')->user();
            if ($user) {
                // Kiểm tra tình trạng tài khoản
                if ($user->is_block == 1) {
                    Auth::guard('admin')->logout();
                    return response()->json([
                        'status' => false,
                        'message' => 'Tài khoản đã bị khóa, kiểm tra mail để biết thêm chi tiết!',
                    ]);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Đăng nhập thành công',
                    'token' => $user->createToken('token_admin')->plainTextToken,
                    'user' => [
                        'id' => $user->id,
                        'ho_va_ten' => $user->ho_va_ten,
                        'email' => $user->email,
                        'avatar' => $user->avatar,
                    ]
                ]);
            }
            return response()->json([
                'status' => false,
                'message' => 'Tài khoản không tồn tại trong hệ thống!',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Email hoặc mật khẩu không đúng!",
            ]);
        }
    }

    public function logout()
    {
        $user = Auth::guard('sanctum')->user();
        if ($user) {
            DB::table('personal_access_tokens')
                ->where('id', $user->currentAccessToken()->id)
                ->delete();
            return response()->json([
                'status'  => true,
                'message' => "Đăng xuất thành công!",
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => "Có lỗi xảy ra!",
            ]);
        }
    }
    public function logoutAllAdmin(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        if ($user && $user instanceof \App\Models\NhanVien) {
            $ds_token = $user->tokens;
            foreach ($ds_token as $token) {
                $token->delete();
            }
            return response()->json([
                'status'  => true,
                'message' => 'Đã đăng xuát thành công',
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Bạn cần đăng nhập hệ thống !',
            ]);
        }
    }

    public function checkToken()
    {
        $user_login = Auth::guard('sanctum')->user();
        if ($user_login && $user_login instanceof \App\Models\NhanVien) {
            return response()->json([
                'status'  => true,
                'ho_ten' => $user_login->ho_va_ten,
                'avatar' => $user_login->avatar,
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => "Bạn phải đăng nhập hệ thống trước!",
            ]);
        }
    }

    public function ForgotPassword(Request $request)
    {
        $user = NhanVien::where('email', $request->email)->first();

        if ($user) {
            $key = Str::uuid();
            $tieu_de = "Quên mật khẩu";
            $view = "quenMatKhau";
            $noi_dung['ho_va_ten'] = $user->ho_va_ten;
            $noi_dung['link'] = "http://127.0.0.1:8000/admin/dat-lai-mat-khau/" . $key;

            $user->hash_reset = $key;
            $user->save();

            Mail::to($user->email)->send(new MasterMail($tieu_de, $view, $noi_dung));

            return response()->json([
                'status' => true,
                'message' => 'Vui lòng kiểm tra email để đổi mật khẩu.',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Tài khoản chưa được đăng ký.',
            ]);
        }
    }

    public function passwordReset(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        if ($user && $user instanceof \App\Models\NhanVien) {

            if ($user->password != $request->password) {
                return response()->json([
                    'status'    =>  0,
                    'message'   =>  'Mật khẩu hiện tại không đúng. Vui lòng nhập lại.'
                ]);
            } else {
                if ($request->new_password != $request->confirm_password) {
                    return response()->json([
                        'status'    =>  0,
                        'message'   =>  'Mật khẩu hiện mới và xác nhận không khớp. Vui lòng nhập lại.'
                    ]);
                } else {
                    $user->password = $request->new_password;
                    $user->save();

                    return response()->json([
                        'status'    =>  1,
                        'message'   =>  'Đổi mật khẩu thành công.'
                    ]);
                }
            }
        }
    }

    // Nhan Vien
    public function getData()
    {
        $id_chuc_nang = 1;
        $data = NhanVien::join('chuc_vus', 'nhan_viens.id_chuc_vu', 'chuc_vus.id')
            ->where('nhan_viens.id_chuc_vu', '!=', 3)
            ->select(
                'nhan_viens.id',
                'nhan_viens.ho_va_ten',
                'nhan_viens.so_dien_thoai',
                'nhan_viens.avatar',
                'nhan_viens.email',
                'nhan_viens.id_chuc_vu',
                'nhan_viens.gioi_tinh',
                'nhan_viens.dia_chi',
                'nhan_viens.ngay_sinh',
                'nhan_viens.tinh_trang',
                'chuc_vus.ten_chuc_vu'
            )
            ->get();
        return response()->json([
            'status' => true,
            'message' => 'Load dữ liệu nhân viên thành công',
            'id_chuc_nang' => $id_chuc_nang,
            'data' => $data,
        ]);
    }

    public function Search(Request $request)
    {
        $conditions = [
            'noi_dung'   => ['field' => 'nhan_viens.ho_va_ten', 'operator' => 'like'],
            'tinh_trang' => ['field' => 'nhan_viens.tinh_trang', 'operator' => '='],
            'id_chuc_vu' => ['field' => 'nhan_viens.id_chuc_vu', 'operator' => '='],
        ];

        $query = NhanVien::join('chuc_vus', 'nhan_viens.id_chuc_vu', '=', 'chuc_vus.id');

        foreach ($conditions as $key => $rule) {
            if ($request->filled($key)) {
                if ($rule['operator'] === 'like') {
                    $query->where($rule['field'], 'like', '%' . $request->$key . '%');
                } else {
                    $query->where($rule['field'], $request->$key);
                }
            }
        }

        $data = $query
            ->select(
                'nhan_viens.id',
                'nhan_viens.ho_va_ten',
                'nhan_viens.so_dien_thoai',
                'nhan_viens.avatar',
                'nhan_viens.email',
                'nhan_viens.id_chuc_vu',
                'nhan_viens.gioi_tinh',
                'nhan_viens.dia_chi',
                'nhan_viens.ngay_sinh',
                'nhan_viens.tinh_trang',
                'chuc_vus.ten_chuc_vu'
            )
            ->get();
        return response()->json([
            'status' => true,
            'message' => 'Load dữ liệu nhân viên thành công',
            'data' => $data,
        ]);
    }


    public function store(CreateNhanVienRequest $request)
    {
        NhanVien::create([
            'ho_va_ten'     => $request->ho_va_ten,
            'so_dien_thoai' => $request->so_dien_thoai,
            'avatar'        => $request->avatar,
            'email'         => $request->email,
            'id_chuc_vu'    => $request->id_chuc_vu,
            'password'      => bcrypt(123456),
            'gioi_tinh'     => $request->gioi_tinh,
            'dia_chi'       => $request->dia_chi,
            'ngay_sinh'     => $request->ngay_sinh,
            'tinh_trang'    => $request->tinh_trang,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Nhân viên " . $request->ho_va_ten . " đã được thêm mới thành công",
        ]);
    }

    public function update(UpdateNhanVienRequest $request)
    {
        NhanVien::where('id', $request->id)->update([
            'ho_va_ten'     => $request->ho_va_ten,
            'so_dien_thoai' => $request->so_dien_thoai,
            'avatar'        => $request->avatar,
            'email'         => $request->email,
            'id_chuc_vu'    => $request->id_chuc_vu,
            'gioi_tinh'     => $request->gioi_tinh,
            'dia_chi'       => $request->dia_chi,
            'ngay_sinh'     => $request->ngay_sinh,
            'tinh_trang'    => $request->tinh_trang,
        ]);
        return response()->json([
            'status' => true,
            'message' => "Nhân viên " . $request->ho_va_ten . " đã được cập nhật thành công",
        ]);
    }

    public function destroy(DeleteNhanVienRequest $request)
    {
        NhanVien::where('id', $request->id)->delete();
        return response()->json([
            'status' => true,
            'message' => "Nhân viên đã được xóa thành công",
        ]);
    }

    public function changeStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:nhan_viens,id',
            'tinh_trang' => 'required|integer|in:0,1',
        ]);

        $new_tinh_trang = !$request->tinh_trang;
        NhanVien::find($request->id)->update([
            'tinh_trang' => $new_tinh_trang,
        ]);
        return response()->json([
            'status' => true,
            'message' => "Nhân viên đã được cập nhật trạng thái thành công",
        ]);
    }
    // Profile
    public function getProfile()
    {
        $user_login = Auth::guard('sanctum')->user();
        if ($user_login && $user_login instanceof \App\Models\NhanVien) {
            $data = NhanVien::join('chuc_vus', 'nhan_viens.id_chuc_vu', 'chuc_vus.id')
                ->where('nhan_viens.id', $user_login->id)
                ->select(
                    'nhan_viens.id',
                    'nhan_viens.ho_va_ten',
                    'nhan_viens.so_dien_thoai',
                    'nhan_viens.avatar',
                    'nhan_viens.email',
                    'nhan_viens.id_chuc_vu',
                    'nhan_viens.gioi_tinh',
                    'nhan_viens.dia_chi',
                    'nhan_viens.ngay_sinh',
                    'nhan_viens.tinh_trang',
                    'chuc_vus.ten_chuc_vu'
                )
                ->first();
            return response()->json([
                'status'  => true,
                'data' => $data,
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => "Bạn phải đăng nhập hệ thống trước!",
            ]);
        }
    }
    //Giao Vien
    public function getDataGV()
    {
        $data = NhanVien::join('chuc_vus', 'nhan_viens.id_chuc_vu', 'chuc_vus.id')
            ->join('lop_hocs', 'nhan_viens.id',  'lop_hocs.id_giao_vien')
            ->select(
                'nhan_viens.id',
                'nhan_viens.ho_va_ten',
                'nhan_viens.so_dien_thoai',
                'nhan_viens.avatar',
                'nhan_viens.email',
                'nhan_viens.id_chuc_vu',
                'nhan_viens.gioi_tinh',
                'nhan_viens.dia_chi',
                'nhan_viens.ngay_sinh',
                'nhan_viens.tinh_trang',
                'chuc_vus.ten_chuc_vu',
                'lop_hocs.ten_lop'
            )
            ->get();
        return response()->json([
            'status' => true,
            'message' => 'Load dữ liệu giáo viên thành công',
            'data' => $data,
        ]);
    }
}
