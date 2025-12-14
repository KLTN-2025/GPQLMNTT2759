<?php

namespace App\Http\Controllers;

use App\Models\DiemDanh;
use App\Models\LopHoc;
use App\Models\HocSinh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DiemDanhController extends Controller
{
    /**
     * Lấy dữ liệu điểm danh theo ngày
     * GET /teacher/attendance/data?ngay=YYYY-MM-DD
     */
    public function getAttendanceData(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Giáo viên không tồn tại trong hệ thống!',
            ], 401);
        }

        // Lấy lớp học của giáo viên
        $lopHoc = LopHoc::where('id_giao_vien', $user->id)->first();
        if (!$lopHoc) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn chưa được phân công lớp học nào!',
            ], 404);
        }

        $ngay = $request->input('ngay', date('Y-m-d'));

        // Lấy danh sách điểm danh theo ngày
        $diemDanhs = DiemDanh::where('id_lop_hoc', $lopHoc->id)
            ->where('ngay_diem_danh', $ngay)
            ->get()
            ->keyBy('id_hoc_sinh');

        // Format dữ liệu trả về
        $data = [];
        foreach ($diemDanhs as $diemDanh) {
            $data[] = [
                'id' => $diemDanh->id,
                'id_hoc_sinh' => $diemDanh->id_hoc_sinh,
                'tinh_trang' => (int)$diemDanh->tinh_trang, // Trả về integer (0 hoặc 1)
                'ghi_chu' => $diemDanh->ghi_chu ?? '',
            ];
        }

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu điểm danh thành công',
            'data' => $data,
        ]);
    }

    /**
     * Lưu điểm danh
     * POST /teacher/attendance/save
     */
    public function saveAttendance(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Giáo viên không tồn tại trong hệ thống!',
            ], 401);
        }

        // Validate request
        $request->validate([
            'ngay' => 'required|date',
            'danh_sach' => 'required|array',
            'danh_sach.*.id_hoc_sinh' => 'required|exists:hoc_sinhs,id',
            'danh_sach.*.tinh_trang' => 'required|integer|in:0,1', // 0 = vắng, 1 = có mặt
            'danh_sach.*.ghi_chu' => 'nullable|string|max:500',
        ]);

        // Lấy lớp học của giáo viên
        $lopHoc = LopHoc::where('id_giao_vien', $user->id)->first();
        if (!$lopHoc) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn chưa được phân công lớp học nào!',
            ], 404);
        }

        $ngay = $request->input('ngay');
        $danhSach = $request->input('danh_sach', []);

        DB::beginTransaction();
        try {
            foreach ($danhSach as $item) {
                $idHocSinh = $item['id_hoc_sinh'];
                $tinhTrang = isset($item['tinh_trang']) ? (int)$item['tinh_trang'] : 1; // Mặc định là 1 (có mặt)
                $ghiChu = $item['ghi_chu'] ?? '';

                // Đảm bảo tinh_trang chỉ là 0 hoặc 1
                $tinhTrang = ($tinhTrang == 1) ? 1 : 0;

                // Kiểm tra học sinh có thuộc lớp này không
                $hocSinh = HocSinh::where('id', $idHocSinh)
                    ->where('id_lop_hoc', $lopHoc->id)
                    ->first();

                if (!$hocSinh) {
                    DB::rollBack();
                    return response()->json([
                        'status' => false,
                        'message' => "Học sinh ID {$idHocSinh} không thuộc lớp của bạn!",
                    ], 400);
                }

                // Tìm hoặc tạo bản ghi điểm danh
                $diemDanh = DiemDanh::updateOrCreate(
                    [
                        'id_lop_hoc' => $lopHoc->id,
                        'id_hoc_sinh' => $idHocSinh,
                        'ngay_diem_danh' => $ngay,
                    ],
                    [
                        'tinh_trang' => $tinhTrang,
                        'ghi_chu' => $ghiChu,
                    ]
                );
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Lưu điểm danh thành công',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Có lỗi xảy ra khi lưu điểm danh: ' . $e->getMessage(),
            ], 500);
        }
    }
}
