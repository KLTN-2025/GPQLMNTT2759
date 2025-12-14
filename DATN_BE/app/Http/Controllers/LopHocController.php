<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLopHocRequest;
use App\Http\Requests\DeleteLopHocRequest;
use App\Http\Requests\UpdateLopHocRequest;
use App\Models\HocSinh;
use App\Models\LopHoc;
use App\Models\KhoiLop;
use App\Models\NamHoc;
use App\Models\GiaoVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LopHocController extends Controller
{

    public function getMyClasses()
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Giáo viên không tồn tại trong hệ thống!',
            ]);
        }

        $classes = LopHoc::join('khoi_lops', 'lop_hocs.id_khoi_lop', 'khoi_lops.id')
            ->join('nam_hocs', 'lop_hocs.id_nam_hoc', 'nam_hocs.id')
            ->where('lop_hocs.id_giao_vien', $user->id)
            ->select(
                'lop_hocs.id',
                'lop_hocs.ten_lop',
                'khoi_lops.ten_khoi_lop',
                'nam_hocs.ten_nam_hoc',
                'lop_hocs.so_luong'
            )
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Lấy danh sách lớp thành công',
            'data' => $classes,
        ]);
    }

    public function getDataClass()
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Giáo viên không tồn tại trong hệ thống!',
            ]);
        }
        $lopHoc = LopHoc::where('id_giao_vien', $user->id)->first();

        if (!$lopHoc) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn chưa được phân công lớp học nào!',
            ], 404);
        }
        $data = LopHoc::join('khoi_lops', 'lop_hocs.id_khoi_lop', 'khoi_lops.id')
            ->join('nam_hocs', 'lop_hocs.id_nam_hoc', 'nam_hocs.id')
            ->join('giao_viens', 'lop_hocs.id_giao_vien', 'giao_viens.id')
            ->join('hoc_sinhs', 'lop_hocs.id', 'hoc_sinhs.id_lop_hoc')
            ->leftJoin('phu_huynhs', 'hoc_sinhs.id_phu_huynh', 'phu_huynhs.id')
            ->where('lop_hocs.id_giao_vien', $user->id)
            ->select(
                'lop_hocs.id as id_lop_hoc',
                'lop_hocs.ten_lop',
                'khoi_lops.ten_khoi_lop',
                'nam_hocs.ten_nam_hoc',
                'giao_viens.ho_va_ten as ho_va_ten_giao_vien',
                'hoc_sinhs.id',
                'hoc_sinhs.ho_va_ten',
                'hoc_sinhs.gioi_tinh',
                'hoc_sinhs.avatar',
                'hoc_sinhs.ngay_sinh',
                'hoc_sinhs.dia_chi',
                'hoc_sinhs.tinh_trang',
                'hoc_sinhs.is_block',
                'phu_huynhs.id as id_phu_huynh',
                'phu_huynhs.ho_va_ten as ten_phu_huynh',
                'phu_huynhs.so_dien_thoai',
                'phu_huynhs.quan_he',
                'phu_huynhs.email',
                'phu_huynhs.gioi_tinh as gioi_tinh_phu_huynh',
                'phu_huynhs.ngay_sinh as ngay_sinh_phu_huynh',

            )
            ->orderBy('hoc_sinhs.ho_va_ten', 'asc')
            ->get();

        // Format dữ liệu để match với frontend - giữ đầy đủ các cột đã SELECT
        $formattedData = $data->map(function ($item) {
            return [
                // Thông tin lớp học
                'id_lop_hoc' => $item->id_lop_hoc,
                'ten_lop' => $item->ten_lop,
                'ten_khoi_lop' => $item->ten_khoi_lop,
                'ten_nam_hoc' => $item->ten_nam_hoc,
                'ho_va_ten_giao_vien' => $item->ho_va_ten_giao_vien,
                // Thông tin học sinh
                'id' => $item->id,
                'ho_va_ten' => $item->ho_va_ten,
                'gioi_tinh' => $item->gioi_tinh,
                'avatar' => $item->avatar,
                'ngay_sinh' => $item->ngay_sinh,
                'dia_chi' => $item->dia_chi,
                'tinh_trang' => $item->tinh_trang,
                'is_block' => $item->is_block,
                // Thông tin phụ huynh
                'id_phu_huynh' => $item->id_phu_huynh,
                'ten_phu_huynh' => $item->ten_phu_huynh ?? 'Chưa cập nhật',
                'so_dien_thoai' => $item->so_dien_thoai,
                'quan_he' => $item->quan_he,
                'email' => $item->email,
                'gioi_tinh_phu_huynh' => $item->gioi_tinh_phu_huynh,
                'ngay_sinh_phu_huynh' => $item->ngay_sinh_phu_huynh,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Load dữ liệu lớp học thành công',
            'data' => $formattedData,
            'ten_lop' => $lopHoc->ten_lop ?? '',
        ]);
    }


    /**
     * Cập nhật thông tin học sinh
     */
    public function updateHocSinh(Request $request)
    {

        $hocSinh = HocSinh::find($request->id);

        if (!$hocSinh) {
            return response()->json([
                'status' => false,
                'message' => 'Học sinh không tồn tại',
            ], 404);
        }

        $hocSinh->update([
            'ho_va_ten' => $request->ho_va_ten,
            'gioi_tinh' => $request->gioi_tinh,
            'ngay_sinh' => $request->ngay_sinh,
            'dia_chi' => $request->dia_chi,
            'tinh_trang' => $request->tinh_trang,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Học sinh đã được cập nhật thành công',
        ]);
    }

    public function destroyHocSinh(Request $request)
    {
        HocSinh::where('id', $request->id)->update([
            'id_lop_hoc' => null,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Học sinh đã được xóa khỏi lớp học thành công',
        ]);
    }

    public function searchHocSinh(Request $request) {}

    /**
     * Thay đổi trạng thái học sinh
     */
    public function changeStatusHocSinh(Request $request)
    {
        // Validation
        $request->validate([
            'id' => 'required|exists:hoc_sinhs,id',
            'tinh_trang' => 'required|integer|in:0,1',
        ]);

        try {
            // Tìm học sinh
            $hocSinh = HocSinh::find($request->id);

            if (!$hocSinh) {
                return response()->json([
                    'status' => false,
                    'message' => 'Học sinh không tồn tại',
                ], 404);
            }

            // Đảo ngược trạng thái
            $newTinhTrang = !$hocSinh->tinh_trang;
            $hocSinh->tinh_trang = $newTinhTrang;
            $hocSinh->save();

            // Xác định trạng thái để hiển thị message
            $statusText = $newTinhTrang ? 'kích hoạt' : 'vô hiệu hóa';

            return response()->json([
                'status' => true,
                'message' => "Học sinh đã được {$statusText} thành công",
                'data' => [
                    'id' => $hocSinh->id,
                    'ho_va_ten' => $hocSinh->ho_va_ten,
                    'tinh_trang' => $hocSinh->tinh_trang,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Có lỗi xảy ra khi thay đổi trạng thái học sinh: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Lấy danh sách phụ huynh theo lớp (cho modal chọn parent của teacher)
     */
    public function getDataClassPhuHuynh()
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Giáo viên không tồn tại trong hệ thống!',
            ]);
        }

        $lopHoc = LopHoc::where('id_giao_vien', $user->id)->first();

        if (!$lopHoc) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn chưa được phân công lớp học nào!',
            ], 404);
        }

        // Lấy danh sách phụ huynh với JOIN query giống getDataClass
        $data = LopHoc::join('hoc_sinhs', 'lop_hocs.id', 'hoc_sinhs.id_lop_hoc')
            ->join('phu_huynhs', 'hoc_sinhs.id_phu_huynh', 'phu_huynhs.id')
            ->where('lop_hocs.id_giao_vien', $user->id)
            ->whereNotNull('hoc_sinhs.id_phu_huynh')
            ->select(
                'phu_huynhs.id',
                'phu_huynhs.ho_va_ten',
                'phu_huynhs.email',
                'phu_huynhs.so_dien_thoai',
                'phu_huynhs.quan_he',
                'phu_huynhs.gioi_tinh',
                'phu_huynhs.ngay_sinh'
            )
            ->distinct()
            ->orderBy('phu_huynhs.ho_va_ten', 'asc')
            ->get();

        // Format dữ liệu để match với frontend
        $formattedData = $data->map(function ($item) {
            return [
                'id' => $item->id,
                'ho_ten' => $item->ho_va_ten ?? 'Phụ huynh',
                'email' => $item->email ?? '',
                'so_dien_thoai' => $item->so_dien_thoai ?? '',
                'quan_he' => $item->quan_he ?? '',
                'gioi_tinh' => $item->gioi_tinh,
                'ngay_sinh' => $item->ngay_sinh,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Lấy danh sách phụ huynh thành công',
            'data' => $formattedData,
        ]);
    }

    // Admin functions
    public function getData()
    {
        $id_chuc_nang = 5;
        $data = LopHoc::join('khoi_lops', 'lop_hocs.id_khoi_lop', 'khoi_lops.id')
            ->join('nam_hocs', 'lop_hocs.id_nam_hoc', 'nam_hocs.id')
            ->join('giao_viens', 'lop_hocs.id_giao_vien', 'giao_viens.id')
            ->leftJoin('hoc_sinhs', 'lop_hocs.id', 'hoc_sinhs.id_lop_hoc')
            ->select(
                'lop_hocs.id',
                'lop_hocs.ten_lop',
                'lop_hocs.id_khoi_lop',
                'lop_hocs.id_nam_hoc',
                'lop_hocs.id_giao_vien',
                'lop_hocs.so_luong',
                'lop_hocs.is_block',
                'khoi_lops.ten_khoi_lop',
                'khoi_lops.do_tuoi',
                'khoi_lops.mo_ta',
                'nam_hocs.ten_nam_hoc',
                'giao_viens.ho_va_ten as ten_giao_vien',
                DB::raw('COUNT(hoc_sinhs.id) as tong_hoc_sinh')
            )
            ->groupBy(
                'lop_hocs.id',
                'lop_hocs.ten_lop',
                'lop_hocs.id_khoi_lop',
                'lop_hocs.id_nam_hoc',
                'lop_hocs.id_giao_vien',
                'lop_hocs.so_luong',
                'lop_hocs.is_block',
                'khoi_lops.do_tuoi',
                'khoi_lops.ten_khoi_lop',
                'khoi_lops.mo_ta',
                'nam_hocs.ten_nam_hoc',
                'giao_viens.ho_va_ten'
            )
            ->get();
        return response()->json([
            'status' => true,
            'message' => 'Load dữ liệu lớp học thành công',
            'id_chuc_nang' => $id_chuc_nang,
            'data' => $data,
        ]);
    }

    public function getDataChiTiet(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:lop_hocs,id',
        ]);

        $id_lop_hoc = $request->id;

        // Lấy thông tin lớp học
        $lopHoc = LopHoc::join('khoi_lops', 'lop_hocs.id_khoi_lop', 'khoi_lops.id')
            ->join('nam_hocs', 'lop_hocs.id_nam_hoc', 'nam_hocs.id')
            ->join('giao_viens', 'lop_hocs.id_giao_vien', 'giao_viens.id')
            ->where('lop_hocs.id', $id_lop_hoc)
            ->select(
                'lop_hocs.id',
                'lop_hocs.ten_lop',
                'lop_hocs.id_khoi_lop',
                'lop_hocs.id_nam_hoc',
                'lop_hocs.id_giao_vien',
                'lop_hocs.so_luong',
                'lop_hocs.is_block',
                'khoi_lops.ten_khoi_lop',
                'khoi_lops.do_tuoi',
                'khoi_lops.mo_ta',
                'nam_hocs.ten_nam_hoc',
                'giao_viens.ho_va_ten as ten_giao_vien'
            )
            ->first();

        if (!$lopHoc) {
            return response()->json([
                'status' => false,
                'message' => 'Lớp học không tồn tại!',
            ], 404);
        }

        // Lấy danh sách học sinh theo lớp với thông tin phụ huynh
        $danhSachHocSinh = HocSinh::leftJoin('phu_huynhs', 'hoc_sinhs.id_phu_huynh', 'phu_huynhs.id')
            ->where('hoc_sinhs.id_lop_hoc', $id_lop_hoc)
            ->select(
                'hoc_sinhs.id',
                'hoc_sinhs.ho_va_ten as ten_hoc_sinh',
                'phu_huynhs.ho_va_ten as ten_phu_huynh',
                'phu_huynhs.quan_he',
                'phu_huynhs.so_dien_thoai',
                'phu_huynhs.dia_chi'
            )
            ->orderBy('hoc_sinhs.ho_va_ten', 'asc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Lấy chi tiết lớp học thành công',
            'data' => [
                'thong_tin_lop' => [
                    'id' => $lopHoc->id,
                    'ten_lop' => $lopHoc->ten_lop,
                    'ten_khoi_lop' => $lopHoc->ten_khoi_lop,
                    'do_tuoi' => $lopHoc->do_tuoi,
                    'mo_ta' => $lopHoc->mo_ta,
                    'ten_nam_hoc' => $lopHoc->ten_nam_hoc,
                    'ten_giao_vien' => $lopHoc->ten_giao_vien,
                    'so_luong' => $lopHoc->so_luong,
                    'is_block' => $lopHoc->is_block,
                ],
                'danh_sach_hoc_sinh' => $danhSachHocSinh
            ],
        ]);
    }

    public function search(Request $request)
    {
        $query = LopHoc::join('khoi_lops', 'lop_hocs.id_khoi_lop', 'khoi_lops.id')
            ->join('nam_hocs', 'lop_hocs.id_nam_hoc', 'nam_hocs.id')
            ->join('giao_viens', 'lop_hocs.id_giao_vien', 'giao_viens.id');

        // Tìm kiếm theo nội dung (tên lớp, mã lớp)
        if ($request->filled('noi_dung')) {
            $noiDung = $request->noi_dung;
            $query->where(function ($q) use ($noiDung) {
                $q->where('lop_hocs.ten_lop', 'like', '%' . $noiDung . '%')
                    ->orWhere('lop_hocs.id', 'like', '%' . $noiDung . '%');
            });
        }

        // Tìm kiếm theo trạng thái (is_block: 1 = Hoạt động, 0 = Tạm ngừng)
        // Frontend gửi: 1 = Hoạt động, 0 = Tạm ngừng
        // Database: is_block = 0 = Hoạt động, is_block = 1 = Tạm ngừng
        // Cần đảo ngược: frontend 1 => database 0, frontend 0 => database 1
        if ($request->filled('is_block')) {
            $isBlock = ($request->is_block == '1') ? 0 : 1;
            $query->where('lop_hocs.is_block', $isBlock);
        }

        // Tìm kiếm theo độ tuổi
        // Frontend gửi: "3-4", "4-5", "5-6"
        // Database lưu: "3-4 tuổi", "4-5 tuổi", "5-6 tuổi"
        if ($request->filled('do_tuoi')) {
            $doTuoi = $request->do_tuoi . ' tuổi';
            $query->where('khoi_lops.do_tuoi', $doTuoi);
        }

        $data = $query
            ->leftJoin('hoc_sinhs', 'lop_hocs.id', 'hoc_sinhs.id_lop_hoc')
            ->select(
                'lop_hocs.id',
                'lop_hocs.ten_lop',
                'lop_hocs.id_khoi_lop',
                'lop_hocs.id_nam_hoc',
                'lop_hocs.id_giao_vien',
                'lop_hocs.so_luong',
                'lop_hocs.is_block',
                'khoi_lops.ten_khoi_lop',
                'khoi_lops.do_tuoi',
                'nam_hocs.ten_nam_hoc',
                'giao_viens.ho_va_ten as ten_giao_vien',
                DB::raw('COUNT(hoc_sinhs.id) as tong_hoc_sinh')
            )
            ->groupBy(
                'lop_hocs.id',
                'lop_hocs.ten_lop',
                'lop_hocs.id_khoi_lop',
                'lop_hocs.id_nam_hoc',
                'lop_hocs.id_giao_vien',
                'lop_hocs.so_luong',
                'lop_hocs.is_block',
                'khoi_lops.ten_khoi_lop',
                'khoi_lops.do_tuoi',
                'nam_hocs.ten_nam_hoc',
                'giao_viens.ho_va_ten'
            )
            ->get();
        return response()->json([
            'status' => true,
            'message' => 'Load dữ liệu lớp học thành công',
            'data' => $data,
        ]);
    }

    public function store(CreateLopHocRequest $request)
    {
        LopHoc::create([
            'ten_lop' => $request->ten_lop,
            'id_khoi_lop' => $request->id_khoi_lop,
            'id_nam_hoc' => $request->id_nam_hoc,
            'id_giao_vien' => $request->id_giao_vien,
            'so_luong' => $request->so_luong,
            'is_block' => $request->is_block,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Lớp học " . $request->ten_lop . " đã được thêm mới thành công",
        ]);
    }

    public function update(UpdateLopHocRequest $request)
    {
        LopHoc::where('id', $request->id)->update([
            'ten_lop' => $request->ten_lop,
            'id_khoi_lop' => $request->id_khoi_lop,
            'id_nam_hoc' => $request->id_nam_hoc,
            'id_giao_vien' => $request->id_giao_vien,
            'so_luong' => $request->so_luong,
            'is_block' => $request->is_block,
        ]);
        return response()->json([
            'status' => true,
            'message' => "Lớp học " . $request->ten_lop . " đã được cập nhật thành công",
        ]);
    }

    public function destroy(DeleteLopHocRequest $request)
    {
        LopHoc::where('id', $request->id)->delete();
        return response()->json([
            'status' => true,
            'message' => "Lớp học đã được xóa thành công",
        ]);
    }

    public function changeStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:lop_hocs,id',
            'is_block' => 'required|integer|in:0,1',
        ]);

        $new_is_block = !$request->is_block;
        LopHoc::find($request->id)->update([
            'is_block' => $new_is_block,
        ]);
        return response()->json([
            'status' => true,
            'message' => "Lớp học đã được cập nhật trạng thái thành công",
        ]);
    }

    public function getDataChiTietHocPhi(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:lop_hocs,id',
        ]);

        $id_lop_hoc = $request->id;

        // Lấy thông tin lớp học
        $lopHoc = LopHoc::join('khoi_lops', 'lop_hocs.id_khoi_lop', 'khoi_lops.id')
            ->join('nam_hocs', 'lop_hocs.id_nam_hoc', 'nam_hocs.id')
            ->join('giao_viens', 'lop_hocs.id_giao_vien', 'giao_viens.id')
            ->where('lop_hocs.id', $id_lop_hoc)
            ->select(
                'lop_hocs.id',
                'lop_hocs.ten_lop',
                'lop_hocs.id_khoi_lop',
                'lop_hocs.id_nam_hoc',
                'lop_hocs.id_giao_vien',
                'lop_hocs.so_luong',
                'lop_hocs.is_block',
                'khoi_lops.ten_khoi_lop',
                'khoi_lops.do_tuoi',
                'khoi_lops.mo_ta',
                'nam_hocs.ten_nam_hoc',
                'giao_viens.ho_va_ten as ten_giao_vien'
            )
            ->first();

        if (!$lopHoc) {
            return response()->json([
                'status' => false,
                'message' => 'Lớp học không tồn tại!',
            ], 404);
        }

        // Lấy danh sách học sinh theo lớp với thông tin phụ huynh
        $danhSachHocSinh = HocSinh::join('phu_huynhs', 'hoc_sinhs.id_phu_huynh', 'phu_huynhs.id')
            ->where('hoc_sinhs.id_lop_hoc', $id_lop_hoc)
            ->where('hoc_sinhs.is_block', 0) // Chỉ lấy học sinh không bị khóa
            ->select(
                'hoc_sinhs.id',
                'hoc_sinhs.ho_va_ten as ten_hoc_sinh',
                'phu_huynhs.ho_va_ten as ten_phu_huynh',
                'phu_huynhs.quan_he',
                'phu_huynhs.so_dien_thoai',
                'phu_huynhs.dia_chi'
            )
            ->orderBy('hoc_sinhs.ho_va_ten', 'asc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Lấy chi tiết lớp học thành công',
            'data' => [
                'thong_tin_lop' => [
                    'id' => $lopHoc->id,
                    'ten_lop' => $lopHoc->ten_lop,
                    'ten_khoi_lop' => $lopHoc->ten_khoi_lop,
                    'do_tuoi' => $lopHoc->do_tuoi,
                    'mo_ta' => $lopHoc->mo_ta,
                    'ten_nam_hoc' => $lopHoc->ten_nam_hoc,
                    'ten_giao_vien' => $lopHoc->ten_giao_vien,
                    'so_luong' => $lopHoc->so_luong,
                    'is_block' => $lopHoc->is_block,
                ],
                'danh_sach_hoc_sinh' => $danhSachHocSinh
            ],
        ]);
    }
}
