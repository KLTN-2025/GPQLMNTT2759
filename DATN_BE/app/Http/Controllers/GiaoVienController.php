<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGiaoVienRequest;
use App\Http\Requests\DeleteGiaoVienRequest;
use App\Http\Requests\UpdateGiaoVienRequest;
use App\Mail\MasterMail;
use App\Models\GiaoVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class GiaoVienController extends Controller
{
    // Login
    public function login(Request $request)
    {
        $check = Auth::guard('giao_vien')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($check) {
            /** @var \App\Models\GiaoVien $user */
            $user = Auth::guard('giao_vien')->user();
            if ($user) {
                // Kiểm tra tình trạng tài khoản
                if ($user->is_block == 1) {
                    Auth::guard('giao_vien')->logout();
                    return response()->json([
                        'status' => false,
                        'message' => 'Tài khoản đã bị khóa, kiểm tra mail để biết thêm chi tiết!',
                    ]);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Đăng nhập thành công',
                    'token' => $user->createToken('token_giao_vien', ['*'])->plainTextToken,
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
        /** @var \App\Models\GiaoVien $user */
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
    public function logoutAll(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        if ($user && $user instanceof \App\Models\GiaoVien) {
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
        if ($user_login && $user_login instanceof \App\Models\GiaoVien) {
            return response()->json([
                'status'  => true,
                'ho_va_ten' => $user_login->ho_va_ten,
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
        $user = GiaoVien::where('email', $request->email)->first();

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

    // Giáo viên
    public function getData()
    {
        $id_chuc_nang = 2;
        $data = GiaoVien::join('chuc_vus', 'giao_viens.id_chuc_vu', 'chuc_vus.id')
                    ->leftJoin('lop_hocs', 'giao_viens.id', 'lop_hocs.id_giao_vien')
                    ->select(
                        'giao_viens.id',
                        'giao_viens.ho_va_ten',
                        'giao_viens.so_dien_thoai',
                        'giao_viens.avatar',
                        'giao_viens.email',
                        'giao_viens.gioi_tinh',
                        'giao_viens.trinh_do',
                        DB::raw('GROUP_CONCAT(lop_hocs.ten_lop SEPARATOR ", ") as ten_lop'),
                        'giao_viens.chuyen_mon',
                        'giao_viens.dia_chi',
                        'giao_viens.ngay_sinh',
                        'giao_viens.tinh_trang',
                        'chuc_vus.ten_chuc_vu'
                    )
                    ->where('giao_viens.id_chuc_vu', 3)
                    ->groupBy(
                        'giao_viens.id',
                        'giao_viens.ho_va_ten',
                        'giao_viens.so_dien_thoai',
                        'giao_viens.avatar',
                        'giao_viens.email',
                        'giao_viens.gioi_tinh',
                        'giao_viens.trinh_do',
                        'giao_viens.chuyen_mon',
                        'giao_viens.dia_chi',
                        'giao_viens.ngay_sinh',
                        'giao_viens.tinh_trang',
                        'chuc_vus.ten_chuc_vu'
                    )
                    ->get();

        return response()->json([
            'status' => true,
            'message' => 'Load dữ liệu giáo viên thành công',
            'id_chuc_nang' => $id_chuc_nang,
            'data' => $data,
        ]);
    }

    public function Search(Request $request)
    {
        $conditions = [
            'noi_dung'   => ['field' => 'giao_viens.ho_va_ten', 'operator' => 'like'],
            'tinh_trang' => ['field' => 'giao_viens.tinh_trang', 'operator' => '='],
            'trinh_do'   => ['field' => 'giao_viens.trinh_do', 'operator' => '='],
            'chuyen_mon' => ['field' => 'giao_viens.chuyen_mon', 'operator' => 'like'],
        ];

        $query = GiaoVien::query();

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
                'id',
                'ho_va_ten',
                'so_dien_thoai',
                'avatar',
                'email',
                'gioi_tinh',
                'trinh_do',
                'chuyen_mon',
                'dia_chi',
                'ngay_sinh',
                'tinh_trang'
            )
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Load dữ liệu giáo viên thành công',
            'data' => $data,
        ]);
    }

    public function store(CreateGiaoVienRequest $request)
    {
        GiaoVien::create([
            'ho_va_ten'     => $request->ho_va_ten,
            'so_dien_thoai' => $request->so_dien_thoai,
            'avatar'        => $request->avatar,
            'email'         => $request->email,
            'password'      => bcrypt(123456),
            'id_chuc_vu'    => 3,
            'gioi_tinh'     => $request->gioi_tinh,
            'trinh_do'      => $request->trinh_do,
            'chuyen_mon'    => $request->chuyen_mon,
            'dia_chi'       => $request->dia_chi,
            'ngay_sinh'     => $request->ngay_sinh,
            'tinh_trang'    => $request->tinh_trang,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Giáo viên " . $request->ho_va_ten . " đã được thêm mới thành công",
        ]);
    }

    public function update(UpdateGiaoVienRequest $request)
    {
        GiaoVien::where('id', $request->id)->update([
            'ho_va_ten'     => $request->ho_va_ten,
            'so_dien_thoai' => $request->so_dien_thoai,
            'avatar'        => $request->avatar,
            'email'         => $request->email,
            'gioi_tinh'     => $request->gioi_tinh,
            'trinh_do'      => $request->trinh_do,
            'chuyen_mon'    => $request->chuyen_mon,
            'dia_chi'       => $request->dia_chi,
            'ngay_sinh'     => $request->ngay_sinh,
            'tinh_trang'    => $request->tinh_trang,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Giáo viên " . $request->ho_va_ten . " đã được cập nhật thành công",
        ]);
    }

    public function destroy(DeleteGiaoVienRequest $request)
    {
        GiaoVien::where('id', $request->id)->delete();

        return response()->json([
            'status' => true,
            'message' => "Giáo viên đã được xóa thành công",
        ]);
    }

    public function changeStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:nhan_viens,id',
            'tinh_trang' => 'required|integer|in:0,1',
        ]);

        $new_tinh_trang = !$request->tinh_trang;
        GiaoVien::find($request->id)->update([
            'tinh_trang' => $new_tinh_trang,
        ]);

        $status_text = $request->tinh_trang ? 'kích hoạt' : 'vô hiệu hóa';

        return response()->json([
            'status' => true,
            'message' => "Giáo viên đã được {$status_text} thành công",
        ]);
    }
}
