<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePhuHuynhRequest;
use App\Http\Requests\DeletePhuHuynhRequest;
use App\Http\Requests\LoginPhuHuynhRequest;
use App\Http\Requests\UpdatePhuHuynhRequest;
use App\Mail\MasterMail;
use App\Models\HocSinh;
use App\Models\PhuHuynh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PhuHuynhController extends Controller
{
    public function login(LoginPhuHuynhRequest $request)
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

    // public function ForgotPassword(Request $request)
    // {
    //     $user = PhuHuynh::where('email', $request->email)->first();

    //     if ($user) {
    //         $key = Str::uuid();
    //         $tieu_de = "Quên mật khẩu";
    //         $view = "quenMatKhau";
    //         $noi_dung['ho_va_ten'] = $user->ho_va_ten;
    //         $noi_dung['link'] = "http://127.0.0.1:8000/admin/dat-lai-mat-khau/" . $key;

    //         $user->hash_reset = $key;
    //         $user->save();

    //         Mail::to($user->email)->send(new MasterMail($tieu_de, $view, $noi_dung));

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Vui lòng kiểm tra email để đổi mật khẩu.',
    //         ]);
    //     } else {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Tài khoản chưa được đăng ký.',
    //         ]);
    //     }
    // }


    // Cách tạo mã OTP và gửi qua email để xác thực khi quên mật khẩu 2
    // public function ForgotPassword(Request $request)
    // {
    //     $user = PhuHuynh::where('email', $request->email)->first();

    //     if ($user) {

    //         // Tạo mã OTP 6 số
    //         $otp = rand(100000, 999999);

    //         $tieu_de = "Quên mật khẩu - Mã OTP Xác Thực";
    //         $view = "quenMatKhau"; // view email mà bạn đã sửa lại

    //         $noi_dung['ho_va_ten'] = $user->ho_va_ten;
    //         $noi_dung['otp'] = $otp;   // GỬI OTP THAY CHO LINK

    //         // Lưu OTP vào DB (hash_reset hoặc bạn nên đổi tên thành otp_reset)
    //         $user->hash_reset = $otp;
    //         $user->save();

    //         // Gửi email
    //         Mail::to($user->email)->send(new MasterMail($tieu_de, $view, $noi_dung));

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Mã OTP đã được gửi vào email của bạn.',
    //         ]);
    //     } else {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Tài khoản chưa được đăng ký.',
    //         ]);
    //     }
    // }

    public function ForgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);
        $user = PhuHuynh::where('email', $request->email)->first();

        if ($user) {
            // Tạo OTP 6 số
            $otp = Str::upper(Str::random(6)); // Ví dụ: A9K3FQ
            // Chuẩn bị dữ liệu email
            $tieu_de = "Quên mật khẩu - Mã OTP Xác Thực";
            $view = "quenMatKhau";
            $noi_dung['ho_va_ten'] = $user->ho_va_ten;
            $noi_dung['otp'] = $otp;

            // Lưu OTP và thời gian hết hạn vào database
            $user->hash_reset = $otp;
            $user->otp_expires_at = now()->addMinutes(5);
            $user->save();
            // Gửi email
            try {
                Mail::to($user->email)->send(new MasterMail($tieu_de, $view, $noi_dung));
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Không thể gửi email. Vui lòng thử lại.',
                    'error' => $e->getMessage()
                ]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Mã OTP đã được gửi vào email của bạn.',
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
        // Lấy dữ liệu từ request
        $otp = $request->otp ?? null;
        $newPassword = $request->new_password ?? null;
        $confirmPassword = $request->confirm_password ?? null;

        // 1. Kiểm tra OTP
        if (!$otp || strlen($otp) != 6) {
            return response()->json([
                'status' => 0,
                'message' => 'Mã OTP không hợp lệ hoặc không được để trống.'
            ]);
        }

        // 2. Kiểm tra mật khẩu mới
        if (!$newPassword || strlen($newPassword) < 6) {
            return response()->json([
                'status' => 0,
                'message' => 'Mật khẩu mới phải có ít nhất 6 ký tự.'
            ]);
        }

        // 3. Kiểm tra xác nhận mật khẩu
        if ($newPassword !== $confirmPassword) {
            return response()->json([
                'status' => 0,
                'message' => 'Mật khẩu xác nhận không khớp.'
            ]);
        }

        // 4. Tìm user dựa trên OTP còn hiệu lực
        $user = PhuHuynh::where('hash_reset', $otp)
            ->where('otp_expires_at', '>', now())
            ->first();

        if (!$user) {
            return response()->json([
                'status' => 0,
                'message' => 'Mã OTP không hợp lệ hoặc đã hết hạn.'
            ]);
        }

        // 5. Cập nhật mật khẩu mới
        $user->password = bcrypt($newPassword); // hash mật khẩu
        $user->hash_reset = null;               // xóa OTP
        $user->otp_expires_at = null;           // xóa thời gian OTP
        $user->save();

        return response()->json([
            'status' => 1,
            'message' => 'Đổi mật khẩu thành công.'
        ]);
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
            'is_block'      => $request->is_block,
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
            'is_block'      => $request->is_block,
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
        $data = PhuHuynh::leftJoin('hoc_sinhs', 'phu_huynhs.id', '=', 'hoc_sinhs.id_phu_huynh')
            ->select(
                'phu_huynhs.id',
                'phu_huynhs.ho_va_ten',
                'phu_huynhs.so_dien_thoai',
                'phu_huynhs.avatar',
                'phu_huynhs.email',
                'phu_huynhs.nghe_nghiep',
                'phu_huynhs.gioi_tinh',
                'phu_huynhs.quan_he',
                'phu_huynhs.dia_chi',
                'phu_huynhs.ngay_sinh',
                'phu_huynhs.is_block',
                'hoc_sinhs.id as id_hoc_sinh',
                'hoc_sinhs.ho_va_ten as ten_hoc_sinh'
            )
            ->get()
            ->groupBy('id')
            ->map(function ($group) {
                $phuHuynh = $group->first();
                $hocSinhs = $group->filter(function ($item) {
                    return $item->id_hoc_sinh !== null;
                })->map(function ($item) {
                    return [
                        'id' => $item->id_hoc_sinh,
                        'ho_va_ten' => $item->ten_hoc_sinh
                    ];
                })->values();

                return [
                    'id' => $phuHuynh->id,
                    'ho_va_ten' => $phuHuynh->ho_va_ten,
                    'so_dien_thoai' => $phuHuynh->so_dien_thoai,
                    'avatar' => $phuHuynh->avatar,
                    'email' => $phuHuynh->email,
                    'nghe_nghiep' => $phuHuynh->nghe_nghiep,
                    'gioi_tinh' => $phuHuynh->gioi_tinh,
                    'quan_he' => $phuHuynh->quan_he,
                    'dia_chi' => $phuHuynh->dia_chi,
                    'ngay_sinh' => $phuHuynh->ngay_sinh,
                    'is_block' => $phuHuynh->is_block,
                    'hoc_sinhs' => $hocSinhs
                ];
            })
            ->values();

        return response()->json([
            'status' => true,
            'message' => 'Load dữ liệu phụ huynh thành công',
            'data' => $data,
        ]);
    }

    public function search(Request $request)
    {

        $query = PhuHuynh::query();

        // Tìm kiếm theo tên, email, số điện thoại
        if ($request->filled('noi_dung')) {
            $noiDung = $request->noi_dung;
            $query->where(function ($q) use ($noiDung) {
                $q->where('phu_huynhs.ho_va_ten', 'like', '%' . $noiDung . '%')
                    ->orWhere('phu_huynhs.email', 'like', '%' . $noiDung . '%')
                    ->orWhere('phu_huynhs.so_dien_thoai', 'like', '%' . $noiDung . '%');
            });
        }

        // Lọc theo trạng thái (is_block)
        if ($request->filled('is_block')) {
            $query->where('phu_huynhs.is_block', $request->is_block);
        }

        // Lọc theo quan hệ
        if ($request->filled('quan_he')) {
            $query->where('phu_huynhs.quan_he', $request->quan_he);
        }

        // Lọc theo giới tính (nếu có)
        if ($request->filled('gioi_tinh')) {
            $query->where('phu_huynhs.gioi_tinh', $request->gioi_tinh);
        }

        // Get data with relationships
        $data = $query->leftJoin('hoc_sinhs', 'phu_huynhs.id', '=', 'hoc_sinhs.id_phu_huynh')
            ->select(
                'phu_huynhs.id',
                'phu_huynhs.ho_va_ten',
                'phu_huynhs.so_dien_thoai',
                'phu_huynhs.avatar',
                'phu_huynhs.email',
                'phu_huynhs.nghe_nghiep',
                'phu_huynhs.gioi_tinh',
                'phu_huynhs.quan_he',
                'phu_huynhs.dia_chi',
                'phu_huynhs.ngay_sinh',
                'phu_huynhs.is_block',
                'hoc_sinhs.id as id_hoc_sinh',
                'hoc_sinhs.ho_va_ten as ten_hoc_sinh'
            )
            ->get()
            ->groupBy('id')
            ->map(function ($group) {
                $phuHuynh = $group->first();
                $hocSinhs = $group->filter(function ($item) {
                    return $item->id_hoc_sinh !== null;
                })->map(function ($item) {
                    return [
                        'id' => $item->id_hoc_sinh,
                        'ho_va_ten' => $item->ten_hoc_sinh
                    ];
                })->values();

                return [
                    'id' => $phuHuynh->id,
                    'ho_va_ten' => $phuHuynh->ho_va_ten,
                    'so_dien_thoai' => $phuHuynh->so_dien_thoai,
                    'avatar' => $phuHuynh->avatar,
                    'email' => $phuHuynh->email,
                    'nghe_nghiep' => $phuHuynh->nghe_nghiep,
                    'gioi_tinh' => $phuHuynh->gioi_tinh,
                    'quan_he' => $phuHuynh->quan_he,
                    'dia_chi' => $phuHuynh->dia_chi,
                    'ngay_sinh' => $phuHuynh->ngay_sinh,
                    'is_block' => $phuHuynh->is_block,
                    'hoc_sinhs' => $hocSinhs
                ];
            })
            ->values();

        return response()->json([
            'status' => true,
            'message' => 'Tìm kiếm phụ huynh thành công',
            'data' => $data,
        ]);
    }
    public function changeStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:phu_huynhs,id',
            'is_block' => 'required|integer|in:0,1',
        ]);

        $new_tinh_trang = !$request->is_block;
        PhuHuynh::find($request->id)->update([
            'is_block' => $new_tinh_trang,
        ]);
        return response()->json([
            'status' => true,
            'message' => "Phụ huynh đã được cập nhật trạng thái thành công",
        ]);
    }
    /**
     * Lấy thông tin profile phụ huynh
     */
    public function getDataProfile()
    {
        $user_login = Auth::guard('sanctum')->user();

        if ($user_login && $user_login instanceof \App\Models\PhuHuynh) {
            // Lấy thông tin phụ huynh
            $profile = PhuHuynh::select(
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
                'is_block'
            )->where('id', $user_login->id)->first();

            // Lấy danh sách con cái
            $children = HocSinh::select(
                'id',
                'ho_va_ten',
                'gioi_tinh',
                'id_lop_hoc',
                'avatar'
            )->where('id_phu_huynh', $user_login->id)->get();

            return response()->json([
                'status' => true,
                'message' => 'Lấy dữ liệu thành công',
                'data' => [
                    'profile' => $profile,    // Thông tin phụ huynh
                    'children' => $children   // Danh sách con cái (Collection)
                ]
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => "Bạn phải đăng nhập hệ thống trước!",
        ]);
    }


    /**
     * Cập nhật thông tin profile phụ huynh
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user || !($user instanceof \App\Models\PhuHuynh)) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn phải đăng nhập hệ thống trước!',
            ]);
        }

        $request->validate([
            'ho_va_ten' => 'required|string|max:255',
            'so_dien_thoai' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:phu_huynhs,email,' . $user->id,
            'gioi_tinh' => 'required|integer|in:0,1',
            'nghe_nghiep' => 'nullable|string|max:255',
            'quan_he' => 'nullable|string|max:100',
            'dia_chi' => 'nullable|string|max:500',
            'ngay_sinh' => 'nullable|date',
        ]);

        PhuHuynh::where('id', $user->id)->update([
            'ho_va_ten' => $request->ho_va_ten,
            'so_dien_thoai' => $request->so_dien_thoai,
            'email' => $request->email,
            'gioi_tinh' => $request->gioi_tinh,
            'nghe_nghiep' => $request->nghe_nghiep,
            'quan_he' => $request->quan_he,
            'dia_chi' => $request->dia_chi,
            'ngay_sinh' => $request->ngay_sinh,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật thông tin profile thành công!'
        ]);
    }

    /**
     * Cập nhật ảnh đại diện phụ huynh
     */
    public function updateAvatar(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user || !($user instanceof \App\Models\PhuHuynh)) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn phải đăng nhập hệ thống trước!',
            ]);
        }

        $request->validate([
            'hinh_anh' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();
        $file = $data['hinh_anh'];
        $file_extention = $file->getClientOriginalExtension();
        $file_name = Str::slug($user->ho_va_ten) . "." . $file_extention;
        $cho_luu = "PhuHuynhAVT\\" . $file_name;
        $file->move("PhuHuynhAVT", $file_name);
        $hinh_anh = "http://127.0.0.1:8000/" . $cho_luu;

        PhuHuynh::find($user->id)->update([
            'avatar' => $hinh_anh
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Đã đổi ảnh đại diện thành công!',
            'data' => [
                'avatar' => $hinh_anh
            ]
        ]);
    }
    /**
     * Thay đổi mật khẩu phụ huynh
     */
    public function changePassword(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user || !($user instanceof \App\Models\PhuHuynh)) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn phải đăng nhập hệ thống trước!',
            ]);
        }

        $request->validate([
            'current' => 'required|string',
            'new' => 'required|string|min:6|different:current',
            'confirm' => 'required|string|same:new',
        ]);

        if (!Hash::check($request->current, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Mật khẩu hiện tại không đúng'
            ]);
        }

        PhuHuynh::where('id', $user->id)->update([
            'password' => Hash::make($request->new)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật mật khẩu thành công'
        ]);
    }
}
