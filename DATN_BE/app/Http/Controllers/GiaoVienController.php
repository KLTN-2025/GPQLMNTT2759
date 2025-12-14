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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

/**
 * @OA\Tag(
 *     name="Admin - Giáo viên",
 *     description="API quản lý giáo viên"
 * )
 */
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

    public function getUserInfo(Request $request)
    {
        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        return response()->json([
            'status' => true,
            'data' => [
                'ho_va_ten' => $user->ho_va_ten,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'chuc_vu' => $user->chuc_vu,
            ]
        ]);
    }


    // public function ForgotPassword(Request $request)
    // {
    //     $user = GiaoVien::where('email', $request->email)->first();

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
        $user = GiaoVien::where('email', $request->email)->first();

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
        $user = GiaoVien::where('hash_reset', $otp)
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

    // Giáo viên
    /**
     * @OA\Get(
     *     path="/api/admin/giao-vien/data",
     *     summary="Lấy danh sách giáo viên",
     *     tags={"Admin - Giáo viên"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lấy danh sách giáo viên thành công (status = true)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Load dữ liệu giáo viên thành công"),
     *             @OA\Property(property="id_chuc_nang", type="integer", example=2),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="ho_va_ten", type="string", example="Nguyễn Thị B"),
     *                     @OA\Property(property="so_dien_thoai", type="string", example="0901234567"),
     *                     @OA\Property(property="avatar", type="string", nullable=true, example="avatar.jpg"),
     *                     @OA\Property(property="email", type="string", example="giaovien@example.com"),
     *                     @OA\Property(property="gioi_tinh", type="integer", example=0),
     *                     @OA\Property(property="trinh_do", type="integer", example=2),
     *                     @OA\Property(property="ten_lop", type="string", nullable=true, example="Lớp Mầm 1, Lớp Mầm 2"),
     *                     @OA\Property(property="chuyen_mon", type="string", example="Giáo dục mầm non"),
     *                     @OA\Property(property="dia_chi", type="string", example="123 Đường ABC"),
     *                     @OA\Property(property="ngay_sinh", type="string", format="date", example="1985-01-01"),
     *                     @OA\Property(property="tinh_trang", type="integer", example=1),
     *                     @OA\Property(property="ten_chuc_vu", type="string", example="Giáo viên")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/admin/giao-vien/search",
     *     summary="Tìm kiếm giáo viên",
     *     tags={"Admin - Giáo viên"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=false,
     *         description="Thông tin tìm kiếm",
     *         @OA\JsonContent(
     *             @OA\Property(property="noi_dung", type="string", example="Nguyễn", description="Tìm kiếm theo tên"),
     *             @OA\Property(property="tinh_trang", type="integer", example=1, description="Tình trạng: 0 hoặc 1"),
     *             @OA\Property(property="trinh_do", type="integer", example=2, description="Trình độ"),
     *             @OA\Property(property="chuyen_mon", type="string", example="Giáo dục", description="Chuyên môn")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tìm kiếm thành công (status = true)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Load dữ liệu giáo viên thành công"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="ho_va_ten", type="string", example="Nguyễn Thị B"),
     *                     @OA\Property(property="so_dien_thoai", type="string", example="0901234567"),
     *                     @OA\Property(property="avatar", type="string", nullable=true, example="avatar.jpg"),
     *                     @OA\Property(property="email", type="string", example="giaovien@example.com"),
     *                     @OA\Property(property="gioi_tinh", type="integer", example=0),
     *                     @OA\Property(property="trinh_do", type="integer", example=2),
     *                     @OA\Property(property="chuyen_mon", type="string", example="Giáo dục mầm non"),
     *                     @OA\Property(property="dia_chi", type="string", example="123 Đường ABC"),
     *                     @OA\Property(property="ngay_sinh", type="string", format="date", example="1985-01-01"),
     *                     @OA\Property(property="tinh_trang", type="integer", example=1)
     *                 )
     *             )
     *         )
     *     )
     * )
     */
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

    /**
     * Lấy thông tin profile giáo viên
     */
    public function getDataProfile()
    {
        $user_login = Auth::guard('sanctum')->user();
        if ($user_login && $user_login instanceof \App\Models\GiaoVien) {
            $data = GiaoVien::join('chuc_vus', 'giao_viens.id_chuc_vu', 'chuc_vus.id')
                ->leftJoin('lop_hocs', 'giao_viens.id', 'lop_hocs.id_giao_vien')
                ->where('giao_viens.id', $user_login->id)
                ->select(
                    'giao_viens.id',
                    'giao_viens.ho_va_ten',
                    'giao_viens.so_dien_thoai',
                    'giao_viens.avatar',
                    'giao_viens.email',
                    'giao_viens.id_chuc_vu',
                    'giao_viens.gioi_tinh',
                    'giao_viens.trinh_do',
                    'giao_viens.chuyen_mon',
                    'giao_viens.dia_chi',
                    'giao_viens.ngay_sinh',
                    'giao_viens.tinh_trang',
                    'chuc_vus.ten_chuc_vu',
                    DB::raw('GROUP_CONCAT(lop_hocs.ten_lop SEPARATOR ", ") as ten_lop')
                )
                ->groupBy(
                    'giao_viens.id',
                    'giao_viens.ho_va_ten',
                    'giao_viens.so_dien_thoai',
                    'giao_viens.avatar',
                    'giao_viens.email',
                    'giao_viens.id_chuc_vu',
                    'giao_viens.gioi_tinh',
                    'giao_viens.trinh_do',
                    'giao_viens.chuyen_mon',
                    'giao_viens.dia_chi',
                    'giao_viens.ngay_sinh',
                    'giao_viens.tinh_trang',
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
     * Cập nhật thông tin profile giáo viên
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user || !($user instanceof \App\Models\GiaoVien)) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn phải đăng nhập hệ thống trước!',
            ]);
        }

        $request->validate([
            'ho_va_ten' => 'required|string|max:255',
            'so_dien_thoai' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:giao_viens,email,' . $user->id,
            'gioi_tinh' => 'required|integer|in:0,1',
            'trinh_do' => 'nullable|integer',
            'chuyen_mon' => 'nullable|string|max:255',
            'dia_chi' => 'nullable|string|max:500',
            'ngay_sinh' => 'nullable|date',
        ]);

        GiaoVien::where('id', $user->id)->update([
            'ho_va_ten' => $request->ho_va_ten,
            'so_dien_thoai' => $request->so_dien_thoai,
            'email' => $request->email,
            'gioi_tinh' => $request->gioi_tinh,
            'trinh_do' => $request->trinh_do,
            'chuyen_mon' => $request->chuyen_mon,
            'dia_chi' => $request->dia_chi,
            'ngay_sinh' => $request->ngay_sinh,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật thông tin profile thành công!'
        ]);
    }

    /**
     * Đổi mật khẩu giáo viên
     */
    public function changePassword(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user || !($user instanceof \App\Models\GiaoVien)) {
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
        GiaoVien::where('id', $user->id)->update([
            'password' => bcrypt($request->new_password)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Đổi mật khẩu thành công!'
        ]);
    }

    /**
     * Cập nhật ảnh đại diện giáo viên
     */
    public function updateAvatar(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user || !($user instanceof \App\Models\GiaoVien)) {
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
        $cho_luu = "GiaoVienAVT\\" . $file_name;
        $file->move("GiaoVienAVT", $file_name);
        $hinh_anh = "http://127.0.0.1:8000/" . $cho_luu;

        GiaoVien::find($user->id)->update([
            'avatar' => $hinh_anh
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Đã đổi ảnh đại diện thành công!'
        ]);
    }
}
