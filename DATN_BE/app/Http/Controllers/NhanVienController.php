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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

/**
 * @OA\Tag(
 *     name="Admin - Xác thực",
 *     description="API xác thực cho Admin"
 * )
 */
class NhanVienController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/admin/login",
     *     summary="Đăng nhập Admin",
     *     tags={"Admin - Xác thực"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Thông tin đăng nhập",
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="admin@example.com"),
     *             @OA\Property(property="password", type="string", example="123456")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Đăng nhập thành công (status = true)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Đăng nhập thành công"),
     *             @OA\Property(property="token", type="string", example="1|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"),
     *             @OA\Property(
     *                 property="user",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="ho_va_ten", type="string", example="Nguyễn Văn A"),
     *                 @OA\Property(property="email", type="string", example="admin@example.com"),
     *                 @OA\Property(property="avatar", type="string", nullable=true, example="avatar.jpg")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Đăng nhập thất bại (status = false)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Email hoặc mật khẩu không đúng!")
     *         )
     *     )
     * )
     */
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
                        'chuc_vu' => $user->chuc_vu,    
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

    /**
     * @OA\Get(
     *     path="/api/admin/logout",
     *     summary="Đăng xuất Admin",
     *     tags={"Admin - Xác thực"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Đăng xuất thành công (status = true)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Đăng xuất thành công!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Đăng xuất thất bại (status = false)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Có lỗi xảy ra!")
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/admin/check-token",
     *     summary="Kiểm tra token Admin",
     *     tags={"Admin - Xác thực"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Token hợp lệ (status = true)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="ho_ten", type="string", example="Nguyễn Văn A"),
     *             @OA\Property(property="avatar", type="string", nullable=true, example="avatar.jpg")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Token không hợp lệ (status = false)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Bạn phải đăng nhập hệ thống trước!")
     *         )
     *     )
     * )
     */
    public function checkToken()
    {
        $user_login = Auth::guard('sanctum')->user();
        if ($user_login && $user_login instanceof \App\Models\NhanVien) {
            return response()->json([
                'status'  => true,
                'ho_va_ten' => $user_login->ho_va_ten,
                'avatar' => $user_login->avatar,
                'chuc_vu' => $user_login->chuc_vu,
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => "Bạn phải đăng nhập hệ thống trước!",
            ]);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/admin/forget-password",
     *     summary="Quên mật khẩu Admin",
     *     tags={"Admin - Xác thực"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Email để reset mật khẩu",
     *         @OA\JsonContent(
     *             required={"email"},
     *             @OA\Property(property="email", type="string", format="email", example="admin@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Gửi email reset mật khẩu thành công (status = true)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Vui lòng kiểm tra email để đổi mật khẩu.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Gửi email thất bại (status = false)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Tài khoản chưa được đăng ký.")
     *         )
     *     )
     * )
     */


    // public function ForgotPassword(Request $request)
    // {
    //     $user = NhanVien::where('email', $request->email)->first();

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
    public function ForgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);
        $user = NhanVien::where('email', $request->email)->first();

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
    }

    /**
     * @OA\Post(
     *     path="/api/admin/reset-password",
     *     summary="Đặt lại mật khẩu Admin",
     *     tags={"Admin - Xác thực"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Thông tin đặt lại mật khẩu",
     *         @OA\JsonContent(
     *             required={"password","new_password","confirm_password"},
     *             @OA\Property(property="password", type="string", example="123456"),
     *             @OA\Property(property="new_password", type="string", example="newpassword123"),
     *             @OA\Property(property="confirm_password", type="string", example="newpassword123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Đổi mật khẩu thành công (status = 1)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=1),
     *             @OA\Property(property="message", type="string", example="Đổi mật khẩu thành công.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Đổi mật khẩu thất bại (status = 0)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="integer", example=0),
     *             @OA\Property(property="message", type="string", example="Mật khẩu hiện tại không đúng. Vui lòng nhập lại.")
     *         )
     *     )
     * )
     */
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
        $user = NhanVien::where('hash_reset', $otp)
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


    /**
     * @OA\Tag(
     *     name="Admin - Profile",
     *     description="API quản lý profile Admin"
     * )
     */
    // Profile
    /**
     * @OA\Get(
     *     path="/api/admin/profile/data",
     *     summary="Lấy thông tin profile Admin",
     *     tags={"Admin - Profile"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lấy thông tin profile thành công (status = true)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="ho_va_ten", type="string", example="Nguyễn Văn A"),
     *                 @OA\Property(property="so_dien_thoai", type="string", example="0901234567"),
     *                 @OA\Property(property="avatar", type="string", nullable=true, example="avatar.jpg"),
     *                 @OA\Property(property="email", type="string", example="admin@example.com"),
     *                 @OA\Property(property="id_chuc_vu", type="integer", example=1),
     *                 @OA\Property(property="gioi_tinh", type="integer", example=1),
     *                 @OA\Property(property="dia_chi", type="string", example="123 Đường ABC"),
     *                 @OA\Property(property="ngay_sinh", type="string", format="date", example="1990-01-01"),
     *                 @OA\Property(property="tinh_trang", type="integer", example=1),
     *                 @OA\Property(property="ten_chuc_vu", type="string", example="Quản lý")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Lấy thông tin profile thất bại (status = false)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Bạn phải đăng nhập hệ thống trước!")
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/admin/profile/update",
     *     summary="Cập nhật thông tin profile Admin",
     *     tags={"Admin - Profile"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Thông tin profile cần cập nhật",
     *         @OA\JsonContent(
     *             required={"ho_va_ten","so_dien_thoai","email","gioi_tinh","dia_chi","ngay_sinh"},
     *             @OA\Property(property="ho_va_ten", type="string", example="Nguyễn Văn A"),
     *             @OA\Property(property="so_dien_thoai", type="string", example="0901234567"),
     *             @OA\Property(property="email", type="string", format="email", example="admin@example.com"),
     *             @OA\Property(property="gioi_tinh", type="integer", example=1, description="0: Nữ, 1: Nam"),
     *             @OA\Property(property="dia_chi", type="string", example="123 Đường ABC"),
     *             @OA\Property(property="ngay_sinh", type="string", format="date", example="1990-01-01")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật profile thành công (status = true)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Cập nhật thông tin profile thành công!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Cập nhật thất bại (status = false)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Bạn phải đăng nhập hệ thống trước!")
     *         )
     *     )
     * )
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user || !($user instanceof \App\Models\NhanVien)) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn phải đăng nhập hệ thống trước!',
            ]);
        }

        $request->validate([
            'ho_va_ten' => 'required|string|max:255',
            'so_dien_thoai' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:nhan_viens,email,' . $user->id,
            'gioi_tinh' => 'required|integer|in:0,1',
            'dia_chi' => 'nullable|string|max:500',
            'ngay_sinh' => 'nullable|date',
        ]);

        NhanVien::where('id', $user->id)->update([
            'ho_va_ten' => $request->ho_va_ten,
            'so_dien_thoai' => $request->so_dien_thoai,
            'email' => $request->email,
            'gioi_tinh' => $request->gioi_tinh,
            'dia_chi' => $request->dia_chi,
            'ngay_sinh' => $request->ngay_sinh,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật thông tin profile thành công!'
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/admin/profile/change-password",
     *     summary="Đổi mật khẩu Admin",
     *     tags={"Admin - Profile"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Thông tin đổi mật khẩu",
     *         @OA\JsonContent(
     *             required={"password","new_password","confirm_password"},
     *             @OA\Property(property="password", type="string", example="123456", description="Mật khẩu hiện tại"),
     *             @OA\Property(property="new_password", type="string", example="newpassword123", description="Mật khẩu mới"),
     *             @OA\Property(property="confirm_password", type="string", example="newpassword123", description="Xác nhận mật khẩu mới")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Đổi mật khẩu thành công (status = true)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Đổi mật khẩu thành công!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Đổi mật khẩu thất bại (status = false)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Mật khẩu hiện tại không đúng. Vui lòng nhập lại.")
     *         )
     *     )
     * )
     */
    public function changePassword(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user || !($user instanceof \App\Models\NhanVien)) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn phải đăng nhập hệ thống trước!',
            ]);
        }

        $request->validate([
            'password' => 'required|string',
            'new_password' => 'required|string|min:6',
            'confirm_password' => 'required|string|min:6',
        ]);

        // Kiểm tra mật khẩu hiện tại (hỗ trợ cả plain text và hashed)
        $passwordCheck = false;
        if (Hash::check($request->password, $user->password)) {
            $passwordCheck = true;
        } elseif ($user->password === $request->password) {
            // Fallback cho mật khẩu plain text (nếu hệ thống còn dùng)
            $passwordCheck = true;
        }

        if (!$passwordCheck) {
            return response()->json([
                'status' => false,
                'message' => 'Mật khẩu hiện tại không đúng. Vui lòng nhập lại.'
            ]);
        }

        // Kiểm tra mật khẩu mới và xác nhận có khớp không
        if ($request->new_password != $request->confirm_password) {
            return response()->json([
                'status' => false,
                'message' => 'Mật khẩu mới và xác nhận không khớp. Vui lòng nhập lại.'
            ]);
        }

        // Cập nhật mật khẩu mới
        NhanVien::where('id', $user->id)->update([
            'password' => bcrypt($request->new_password)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Đổi mật khẩu thành công!'
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/admin/profile/update-avatar",
     *     summary="Cập nhật ảnh đại diện Admin",
     *     tags={"Admin - Profile"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Ảnh đại diện mới",
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"hinh_anh"},
     *                 @OA\Property(property="hinh_anh", type="string", format="binary", description="File ảnh đại diện")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật ảnh đại diện thành công (status = true)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Đã đổi ảnh đại diện thành công!")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Cập nhật thất bại (status = false)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Bạn phải đăng nhập hệ thống trước!")
     *         )
     *     )
     * )
     */
    public function updateAvatar(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user || !($user instanceof \App\Models\NhanVien)) {
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
        $cho_luu = "AdminAVT\\" . $file_name;
        $file->move("AdminAVT", $file_name);
        $hinh_anh = "http://127.0.0.1:8000/" . $cho_luu;

        NhanVien::find($user->id)->update([
            'avatar' => $hinh_anh
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Đã đổi ảnh đại diện thành công!'
        ]);
    }

    /**
     * @OA\Tag(
     *     name="Admin - Nhân viên",
     *     description="API quản lý nhân viên"
     * )
     */
    // Nhan Vien
    /**
     * @OA\Get(
     *     path="/api/admin/nhan-vien/data",
     *     summary="Lấy danh sách nhân viên",
     *     tags={"Admin - Nhân viên"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lấy danh sách nhân viên thành công (status = true)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Load dữ liệu nhân viên thành công"),
     *             @OA\Property(property="id_chuc_nang", type="integer", example=1),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="ho_va_ten", type="string", example="Nguyễn Văn A"),
     *                     @OA\Property(property="so_dien_thoai", type="string", example="0901234567"),
     *                     @OA\Property(property="avatar", type="string", nullable=true, example="avatar.jpg"),
     *                     @OA\Property(property="email", type="string", example="nhanvien@example.com"),
     *                     @OA\Property(property="id_chuc_vu", type="integer", example=1),
     *                     @OA\Property(property="gioi_tinh", type="integer", example=1),
     *                     @OA\Property(property="dia_chi", type="string", example="123 Đường ABC"),
     *                     @OA\Property(property="ngay_sinh", type="string", format="date", example="1990-01-01"),
     *                     @OA\Property(property="tinh_trang", type="integer", example=1),
     *                     @OA\Property(property="ten_chuc_vu", type="string", example="Nhân viên")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/admin/nhan-vien/search",
     *     summary="Tìm kiếm nhân viên",
     *     tags={"Admin - Nhân viên"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=false,
     *         description="Thông tin tìm kiếm",
     *         @OA\JsonContent(
     *             @OA\Property(property="noi_dung", type="string", example="Nguyễn", description="Tìm kiếm theo tên"),
     *             @OA\Property(property="tinh_trang", type="integer", example=1, description="Tình trạng: 0 hoặc 1"),
     *             @OA\Property(property="id_chuc_vu", type="integer", example=1, description="ID chức vụ")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tìm kiếm thành công (status = true)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Load dữ liệu nhân viên thành công"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="ho_va_ten", type="string", example="Nguyễn Văn A"),
     *                     @OA\Property(property="so_dien_thoai", type="string", example="0901234567"),
     *                     @OA\Property(property="avatar", type="string", nullable=true, example="avatar.jpg"),
     *                     @OA\Property(property="email", type="string", example="nhanvien@example.com"),
     *                     @OA\Property(property="id_chuc_vu", type="integer", example=1),
     *                     @OA\Property(property="gioi_tinh", type="integer", example=1),
     *                     @OA\Property(property="dia_chi", type="string", example="123 Đường ABC"),
     *                     @OA\Property(property="ngay_sinh", type="string", format="date", example="1990-01-01"),
     *                     @OA\Property(property="tinh_trang", type="integer", example=1),
     *                     @OA\Property(property="ten_chuc_vu", type="string", example="Nhân viên")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
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


    /**
     * @OA\Post(
     *     path="/api/admin/nhan-vien/create",
     *     summary="Thêm mới nhân viên",
     *     tags={"Admin - Nhân viên"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Thông tin nhân viên",
     *         @OA\JsonContent(
     *             required={"ho_va_ten","so_dien_thoai","email","id_chuc_vu","gioi_tinh","ngay_sinh","tinh_trang"},
     *             @OA\Property(property="ho_va_ten", type="string", example="Nguyễn Văn A"),
     *             @OA\Property(property="so_dien_thoai", type="string", example="0901234567"),
     *             @OA\Property(property="avatar", type="string", nullable=true, example="avatar.jpg"),
     *             @OA\Property(property="email", type="string", format="email", example="nhanvien@example.com"),
     *             @OA\Property(property="id_chuc_vu", type="integer", example=1),
     *             @OA\Property(property="gioi_tinh", type="integer", example=1, description="0: Nữ, 1: Nam"),
     *             @OA\Property(property="dia_chi", type="string", example="123 Đường ABC"),
     *             @OA\Property(property="ngay_sinh", type="string", format="date", example="1990-01-01"),
     *             @OA\Property(property="tinh_trang", type="integer", example=1, description="0: Không hoạt động, 1: Hoạt động")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Thêm nhân viên thành công (status = true)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Nhân viên Nguyễn Văn A đã được thêm mới thành công")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Dữ liệu không hợp lệ (status = false)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Dữ liệu không hợp lệ")
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/admin/nhan-vien/update",
     *     summary="Cập nhật nhân viên",
     *     tags={"Admin - Nhân viên"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Thông tin nhân viên cần cập nhật",
     *         @OA\JsonContent(
     *             required={"id","ho_va_ten","so_dien_thoai","email","id_chuc_vu","gioi_tinh","ngay_sinh","tinh_trang"},
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="ho_va_ten", type="string", example="Nguyễn Văn A"),
     *             @OA\Property(property="so_dien_thoai", type="string", example="0901234567"),
     *             @OA\Property(property="avatar", type="string", nullable=true, example="avatar.jpg"),
     *             @OA\Property(property="email", type="string", format="email", example="nhanvien@example.com"),
     *             @OA\Property(property="id_chuc_vu", type="integer", example=1),
     *             @OA\Property(property="gioi_tinh", type="integer", example=1),
     *             @OA\Property(property="dia_chi", type="string", example="123 Đường ABC"),
     *             @OA\Property(property="ngay_sinh", type="string", format="date", example="1990-01-01"),
     *             @OA\Property(property="tinh_trang", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật nhân viên thành công (status = true)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Nhân viên Nguyễn Văn A đã được cập nhật thành công")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Dữ liệu không hợp lệ (status = false)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Dữ liệu không hợp lệ")
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/admin/nhan-vien/delete",
     *     summary="Xóa nhân viên",
     *     tags={"Admin - Nhân viên"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="ID nhân viên cần xóa",
     *         @OA\JsonContent(
     *             required={"id"},
     *             @OA\Property(property="id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Xóa nhân viên thành công (status = true)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Nhân viên đã được xóa thành công")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Dữ liệu không hợp lệ (status = false)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Dữ liệu không hợp lệ")
     *         )
     *     )
     * )
     */
    public function destroy(DeleteNhanVienRequest $request)
    {
        NhanVien::where('id', $request->id)->delete();
        return response()->json([
            'status' => true,
            'message' => "Nhân viên đã được xóa thành công",
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/admin/nhan-vien/change-status",
     *     summary="Thay đổi trạng thái nhân viên",
     *     tags={"Admin - Nhân viên"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Thông tin thay đổi trạng thái",
     *         @OA\JsonContent(
     *             required={"id","tinh_trang"},
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="tinh_trang", type="integer", example=1, description="0: Không hoạt động, 1: Hoạt động")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật trạng thái thành công (status = true)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Nhân viên đã được cập nhật trạng thái thành công")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Dữ liệu không hợp lệ (status = false)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Dữ liệu không hợp lệ")
     *         )
     *     )
     * )
     */
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
