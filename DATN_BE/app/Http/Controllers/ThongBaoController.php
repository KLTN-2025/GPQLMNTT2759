<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateThongBaoRequest;
use App\Http\Requests\DeleteThongBaoRequest;
use App\Http\Requests\UpdateThongBaoRequest;
use App\Models\ChiTietThongBao;
use App\Models\ThongBao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ThongBaoController extends Controller
{
    /**
     * Lấy danh sách tất cả thông báo
     */
    public function getData()
    {
        $data = ThongBao::join('nhan_viens', 'thong_baos.id_nhan_vien', '=', 'nhan_viens.id')
            ->leftJoin('chi_tiet_thong_baos', 'thong_baos.id', '=', 'chi_tiet_thong_baos.id_thong_bao')
            ->select(
                'thong_baos.id',
                'thong_baos.tieu_de',
                'thong_baos.noi_dung',
                'thong_baos.hinh_anh',
                'thong_baos.tep_dinh_kem',
                'thong_baos.thoi_gian_dang',
                'thong_baos.ngay_het_hieu_luc',
                'thong_baos.tinh_trang',
                'thong_baos.loai_thong_bao',
                'nhan_viens.ho_va_ten as nguoi_gui',
                'nhan_viens.avatar as avatar_nguoi_gui',
                DB::raw("
            CASE
                WHEN chi_tiet_thong_baos.id_phu_huynh IS NOT NULL THEN 'Phụ huynh'
                WHEN chi_tiet_thong_baos.id_giao_vien IS NOT NULL THEN 'Giáo viên'
                WHEN chi_tiet_thong_baos.id_lop_hoc IS NOT NULL THEN 'Lớp học'
                ELSE 'Không xác định'
            END as doi_tuong_nhan
        "),
                DB::raw('(SELECT COUNT(*) FROM chi_tiet_thong_baos WHERE chi_tiet_thong_baos.id_thong_bao = thong_baos.id) as tong_so_nguoi_nhan')
            )
            ->distinct()
            ->orderBy('thong_baos.thoi_gian_dang', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Load dữ liệu thông báo thành công',
            'data' => $data,
        ]);
    }

    /**
     * Tạo thông báo mới
     */
    public function store(CreateThongBaoRequest $request)
    {
        $user = Auth::guard('admin')->user() ?: Auth::guard('sanctum')->user();

        if (!$user || !($user instanceof \App\Models\NhanVien)) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn không có quyền tạo thông báo',
            ], 403);
        }

        DB::beginTransaction();
        try {
            // Tạo thông báo
            $thongBao = ThongBao::create([
                'tieu_de' => $request->tieu_de,
                'noi_dung' => $request->noi_dung,
                'hinh_anh' => $request->hinh_anh,
                'tep_dinh_kem' => $request->tep_dinh_kem,
                'thoi_gian_dang' => $request->thoi_gian_dang ?? now(),
                'ngay_het_hieu_luc' => $request->ngay_het_hieu_luc,
                'loai_thong_bao' => $request->loai_thong_bao,
                'tinh_trang' => $request->tinh_trang ?? 1,
                'id_nhan_vien' => $user->id,
            ]);

            // Lưu chi tiết thông báo (người nhận)
            $this->saveChiTietThongBao($thongBao->id, $request);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Gửi thông báo thành công',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Có lỗi xảy ra khi tạo thông báo: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Cập nhật thông báo
     */
    public function update(UpdateThongBaoRequest $request)
    {
        $user = Auth::guard('admin')->user() ?: Auth::guard('sanctum')->user();

        if (!$user || !($user instanceof \App\Models\NhanVien)) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn không có quyền cập nhật thông báo',
            ], 403);
        }

        DB::beginTransaction();
        try {
            // Cập nhật thông báo
            ThongBao::where('id', $request->id)->update([
                'tieu_de' => $request->tieu_de,
                'noi_dung' => $request->noi_dung,
                'hinh_anh' => $request->hinh_anh,
                'tep_dinh_kem' => $request->tep_dinh_kem,
                'thoi_gian_dang' => $request->thoi_gian_dang,
                'ngay_het_hieu_luc' => $request->ngay_het_hieu_luc,
                'loai_thong_bao' => $request->loai_thong_bao,
                'tinh_trang' => $request->tinh_trang ?? 1,
            ]);

            // Xóa chi tiết cũ
            ChiTietThongBao::where('id_thong_bao', $request->id)->delete();

            // Lưu chi tiết mới
            $this->saveChiTietThongBao($request->id, $request);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Cập nhật thông báo thành công',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật thông báo: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Xóa thông báo
     */
    public function destroy(DeleteThongBaoRequest $request)
    {
        DB::beginTransaction();
        try {
            // Xóa chi tiết thông báo
            ChiTietThongBao::where('id_thong_bao', $request->id)->delete();

            // Xóa thông báo
            ThongBao::where('id', $request->id)->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Xóa thông báo thành công',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Có lỗi xảy ra khi xóa thông báo: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Tìm kiếm thông báo
     */
    public function search(Request $request)
    {
        $query = ThongBao::join('nhan_viens', 'thong_baos.id_nhan_vien', 'nhan_viens.id')
            ->leftJoin('chi_tiet_thong_baos', 'thong_baos.id', 'chi_tiet_thong_baos.id_thong_bao')
            ->leftJoin('phu_huynhs', 'chi_tiet_thong_baos.id_phu_huynh', 'phu_huynhs.id')
            ->leftJoin('giao_viens', 'chi_tiet_thong_baos.id_giao_vien', 'giao_viens.id')
            ->leftJoin('lop_hocs', 'chi_tiet_thong_baos.id_lop_hoc', 'lop_hocs.id')
            ->select(
                'thong_baos.id',
                'thong_baos.tieu_de',
                'thong_baos.noi_dung',
                'thong_baos.hinh_anh',
                'thong_baos.tep_dinh_kem',
                'thong_baos.thoi_gian_dang',
                'thong_baos.ngay_het_hieu_luc',
                'thong_baos.tinh_trang',
                'thong_baos.loai_thong_bao',
                'nhan_viens.ho_va_ten as nguoi_gui',
                'nhan_viens.avatar as avatar_nguoi_gui',
                'phu_huynhs.ho_va_ten as nguoi_nhan_phu_huynh',
                'giao_viens.ho_va_ten as nguoi_nhan_giao_vien',
                'lop_hocs.ten_lop as nguoi_nhan_lop_hoc',
                DB::raw('(SELECT COUNT(*) FROM chi_tiet_thong_baos WHERE chi_tiet_thong_baos.id_thong_bao = thong_baos.id) as tong_so_nguoi_nhan')
            );

        // Tìm kiếm theo tiêu đề
        if ($request->filled('noi_dung')) {
            $query->where('thong_baos.tieu_de', 'like', '%' . $request->noi_dung . '%');
        }

        // Tìm kiếm theo trạng thái
        if ($request->filled('tinh_trang')) {
            $query->where('thong_baos.tinh_trang', $request->tinh_trang);
        }

        // Tìm kiếm theo loại thông báo
        if ($request->filled('loai_thong_bao')) {
            $query->where('thong_baos.loai_thong_bao', $request->loai_thong_bao);
        }

        // Tìm kiếm theo người gửi
        if ($request->filled('id_nhan_vien')) {
            $query->where('thong_baos.id_nhan_vien', $request->id_nhan_vien);
        }

        $data = $query->distinct()->orderBy('thong_baos.thoi_gian_dang', 'desc')->get();

        return response()->json([
            'status' => true,
            'message' => 'Load dữ liệu thông báo thành công',
            'data' => $data,
        ]);
    }

    /**
     * Thống kê thông báo
     */
    public function statistical()
    {
        $total = ThongBao::count();
        $totalActive = ThongBao::where('tinh_trang', 1)->count();
        $totalInactive = ThongBao::where('tinh_trang', 0)->count();

        // Thống kê theo tháng
        $byMonth = ThongBao::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Thống kê theo trạng thái
        $byStatus = ThongBao::select('tinh_trang')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('tinh_trang')
            ->get();

        // Thống kê theo loại thông báo
        $byType = ThongBao::select('loai_thong_bao')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('loai_thong_bao')
            ->get();

        // Thống kê số người nhận trung bình
        $recipientsStats = DB::table('chi_tiet_thong_baos')
            ->select('id_thong_bao', DB::raw('COUNT(*) as recipient_count'))
            ->groupBy('id_thong_bao')
            ->get();

        $avgRecipients = $recipientsStats->count() > 0
            ? round($recipientsStats->avg('recipient_count'), 2)
            : 0;

        return response()->json([
            'status' => true,
            'message' => 'Thống kê thông báo',
            'data' => [
                'total_records' => $total,
                'total_active' => $totalActive,
                'total_inactive' => $totalInactive,
                'by_month' => $byMonth,
                'by_status' => $byStatus,
                'by_type' => $byType,
                'avg_recipients' => $avgRecipients,
            ],
        ]);
    }

    /**
     * Thay đổi trạng thái thông báo
     */
    public function changeStatus(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'id' => 'required|exists:thong_baos,id',
            'tinh_trang' => 'required|integer|in:0,1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors(),
            ], 422);
        }

        ThongBao::where('id', $request->id)->update([
            'tinh_trang' => $request->tinh_trang,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Thay đổi trạng thái thành công',
        ]);
    }

    /**
     * Lưu chi tiết thông báo (người nhận)
     */
    private function saveChiTietThongBao($idThongBao, $request)
    {
        $chiTietList = [];

        // Lưu danh sách phụ huynh
        if ($request->filled('id_phu_huynh') && is_array($request->id_phu_huynh)) {
            foreach ($request->id_phu_huynh as $idPhuHuynh) {
                if ($idPhuHuynh) {
                    $chiTietList[] = [
                        'id_thong_bao' => $idThongBao,
                        'id_phu_huynh' => $idPhuHuynh,
                        'id_giao_vien' => null,
                        'id_lop_hoc' => null,
                    ];
                }
            }
        }

        // Lưu danh sách giáo viên
        if ($request->filled('id_giao_vien') && is_array($request->id_giao_vien)) {
            foreach ($request->id_giao_vien as $idGiaoVien) {
                if ($idGiaoVien) {
                    $chiTietList[] = [
                        'id_thong_bao' => $idThongBao,
                        'id_phu_huynh' => null,
                        'id_giao_vien' => $idGiaoVien,
                        'id_lop_hoc' => null,
                    ];
                }
            }
        }

        // Lưu danh sách lớp học
        if ($request->filled('id_lop_hoc') && is_array($request->id_lop_hoc)) {
            foreach ($request->id_lop_hoc as $idLopHoc) {
                if ($idLopHoc) {
                    $chiTietList[] = [
                        'id_thong_bao' => $idThongBao,
                        'id_phu_huynh' => null,
                        'id_giao_vien' => null,
                        'id_lop_hoc' => $idLopHoc,
                    ];
                }
            }
        }

        // Insert all chi tiết
        if (!empty($chiTietList)) {
            ChiTietThongBao::insert($chiTietList);
        }
    }
}
