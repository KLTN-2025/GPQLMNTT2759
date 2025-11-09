<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePhuHuynhRequest;
use App\Http\Requests\DeletePhuHuynhRequest;
use App\Http\Requests\LoginPhuHuynhRequest;
use App\Http\Requests\UpdatePhuHuynhRequest;
use App\Mail\MasterMail;
use App\Models\PhuHuynh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PhuHuynhController extends Controller
{
    public function  login(LoginPhuHuynhRequest $request)
    {
        $authen = Auth::guard('client')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($authen) {
            $user = Auth::guard('client')->user();
            if ($user) {
                // Kiểm tra tình trạng tài khoản
                if ($user->is_block == 1) {
                    Auth::guard('client')->logout();
                    return response()->json([
                        'status' => false,
                        'message' => 'Tài khoản đã bị khóa, kiểm tra mail để biết thêm chi tiết!',
                    ]);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Đăng nhập thành công',
                    'token' => $user->createToken('token_phu_huynh')->plainTextToken,
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
                'message' => "Đăng xuất thành công",
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => "Có lỗi xảy ra",
            ]);
        }
    }
    public function checkToken()
    {
        $user_login = Auth::guard('sanctum')->user();
        if ($user_login) {
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
        $user = PhuHuynh::where('email', $request->email)->first();

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
        if ($user && $user instanceof \App\Models\PhuHuynh) {

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

    public function store(CreatePhuHuynhRequest $request)
    {
        PhuHuynh::create([
            'ho_va_ten'     => $request->ho_va_ten,
            'so_dien_thoai' => $request->so_dien_thoai,
            'avatar'        => $request->avatar,
            'email'         => $request->email,
            'nghe_nghiep'    => $request->nghe_nghiep,
            'password'      => bcrypt(123456),
            'gioi_tinh'     => $request->gioi_tinh,
            'quan_he'     => $request->quan_he,
            'dia_chi'       => $request->dia_chi,
            'ngay_sinh'     => $request->ngay_sinh,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Phụ Huynh " . $request->ho_va_ten . " đã được thêm mới thành công",
        ]);
    }
    public function update(UpdatePhuHuynhRequest $request)
    {
        PhuHuynh::where('id', $request->id)->update([
            'ho_va_ten'     => $request->ho_va_ten,
            'so_dien_thoai' => $request->so_dien_thoai,
            'avatar'        => $request->avatar,
            'email'         => $request->email,
            'nghe_nghiep'    => $request->nghe_nghiep,
            'gioi_tinh'     => $request->gioi_tinh,
            'quan_he'     => $request->quan_he,
            'dia_chi'       => $request->dia_chi,
            'ngay_sinh'     => $request->ngay_sinh,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Phụ Huynh " . $request->ho_va_ten . " đã được cập nhật thành công",
        ]);
    }
    public function destroy(DeletePhuHuynhRequest $request)
    {
        PhuHuynh::where('id', $request->id)->delete();
        return response()->json([
            'status' => true,
            'message' => "Phụ Huynh đã được xóa thành công",
        ]);
    }

    public function getData()
    {
        $id_chuc_nang = 3;
        $data = PhuHuynh::all();
        return response()->json([
            'status' => true,
            'message' => 'Load dữ liệu phụ huynh thành công',
            'data' => $data,
        ]);
    }

    public function search(Request $request)
    {
        $conditions = [
            'noi_dung'   => ['field' => 'ho_va_ten', 'operator' => 'like'],
            'tinh_trang' => ['field' => 'tinh_trang', 'operator' => '='],
            'gioi_tinh' => ['field' => 'gioi_tinh', 'operator' => '='],
        ];

        $query = PhuHuynh::query();

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
                'nghe_nghiep',
                'gioi_tinh',
                'quan_he',
                'dia_chi',
                'ngay_sinh',
            )
            ->get();
        return response()->json([
            'status' => true,
            'message' => 'Load dữ liệu phụ huynh thành công',
            'data' => $data,
        ]);
    }

    public function changeStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:phu_huynhs,id',
            'tinh_trang' => 'required|integer|in:0,1',
        ]);

        $new_tinh_trang = !$request->tinh_trang;
        PhuHuynh::find($request->id)->update([
            'tinh_trang' => $new_tinh_trang,
        ]);
        return response()->json([
            'status' => true,
            'message' => "Phụ huynh đã được cập nhật trạng thái thành công",
        ]);
    }
}
