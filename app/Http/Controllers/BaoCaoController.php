<?php

namespace App\Http\Controllers;

use App\Models\BaoCao;
use App\Models\GiaoVien;
use App\Models\NhanVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BaoCaoController extends Controller
{
    /**
     * Mapping loại báo cáo từ frontend string sang database integer
     */
    private function mapLoaiBaoCao($loaiBaoCao)
    {
        $mapping = [
            'financial' => 1,
            'student' => 2,
            'activity' => 3,
            'attendance' => 4,
            'health' => 5,
        ];
        return $mapping[$loaiBaoCao] ?? null;
    }

    /**
     * Mapping trạng thái từ frontend string sang database integer
     */
    private function mapTrangThai($trangThai)
    {
        $mapping = [
            'completed' => 1,
            'pending' => 0,
            'failed' => 2,
        ];
        return $mapping[$trangThai] ?? null;
    }

    /**
     * Reverse mapping: database integer sang frontend string
     */
    private function reverseMapLoaiBaoCao($loaiBaoCao)
    {
        $mapping = [
            1 => 'financial',
            2 => 'student',
            3 => 'activity',
            4 => 'attendance',
            5 => 'health',
        ];
        return $mapping[$loaiBaoCao] ?? 'other';
    }

    private function reverseMapTrangThai($trangThai)
    {
        $mapping = [
            1 => 'completed',
            0 => 'pending',
            2 => 'failed',
        ];
        return $mapping[$trangThai] ?? 'pending';
    }

    /**
     * Lấy danh sách báo cáo với thông tin liên quan
     * Giáo viên chỉ xem được báo cáo của chính mình
     */
    public function getData()
    {
        // Lấy giáo viên đang đăng nhập
        $giaoVien = Auth::guard('sanctum')->user();
        
        $data = BaoCao::select(
            'bao_caos.id',
            'bao_caos.tieu_de',
            'bao_caos.duong_dan',
            'bao_caos.loai_bao_cao',
            'bao_caos.ngay_tao',
            'bao_caos.ngay_ky',
            'bao_caos.tinh_trang',
            'bao_caos.id_giao_vien',
            'bao_caos.id_nhan_vien',
            'giao_viens.ho_va_ten as ten_giao_vien',
            'nhan_viens.ho_va_ten as ten_nhan_vien'
        )
            ->leftJoin('giao_viens', 'bao_caos.id_giao_vien', '=', 'giao_viens.id')
            ->leftJoin('nhan_viens', 'bao_caos.id_nhan_vien', '=', 'nhan_viens.id')
            ->where('bao_caos.id_giao_vien', $giaoVien->id)  // Chỉ lấy báo cáo của giáo viên này
            ->orderBy('bao_caos.ngay_tao', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'ten_bao_cao' => $item->tieu_de,
                    'mo_ta' => null, // Không có trong DB, có thể thêm sau
                    'loai_bao_cao' => $this->reverseMapLoaiBaoCao($item->loai_bao_cao),
                    'duong_dan' => $item->duong_dan,
                    'ngay_tao' => $item->ngay_tao,
                    'tu_ngay' => $item->ngay_ky, // Map ngay_ky thành tu_ngay
                    'den_ngay' => $item->ngay_ky, // Map ngay_ky thành den_ngay
                    'trang_thai' => $this->reverseMapTrangThai($item->tinh_trang),
                    'id_giao_vien' => $item->id_giao_vien,
                    'id_nhan_vien' => $item->id_nhan_vien,
                    'ten_giao_vien' => $item->ten_giao_vien,
                    'ten_nhan_vien' => $item->ten_nhan_vien,
                ];
            });

        return response()->json([
            'status' => true,
            'message' => 'Load dữ liệu báo cáo thành công',
            'data' => $data,
        ]);
    }

    /**
     * Tạo mới báo cáo
     * Tự động gán id_giao_vien từ user đang đăng nhập
     */
    public function store(Request $request)
    {
        $request->validate([
            'ten_bao_cao' => 'required|string|max:255',
            'loai_bao_cao' => 'required|string|in:financial,student,activity,attendance,health',
            'duong_dan' => 'nullable|string|max:255',
            'tu_ngay' => 'nullable|date',
            'den_ngay' => 'nullable|date',
        ]);

        // Lấy giáo viên đang đăng nhập
        $giaoVien = Auth::guard('sanctum')->user();

        $loaiBaoCao = $this->mapLoaiBaoCao($request->loai_bao_cao);
        if (!$loaiBaoCao) {
            return response()->json([
                'status' => false,
                'message' => 'Loại báo cáo không hợp lệ',
            ], 400);
        }

        $baoCao = BaoCao::create([
            'tieu_de' => $request->ten_bao_cao,
            'loai_bao_cao' => $loaiBaoCao,
            'duong_dan' => $request->duong_dan ?? '',
            'ngay_tao' => now(),
            'ngay_ky' => $request->den_ngay ?? $request->tu_ngay ?? now()->format('Y-m-d'),
            'tinh_trang' => 0, // Default: pending
            'id_giao_vien' => $giaoVien->id,  // Tự động gán từ user đăng nhập
            'id_nhan_vien' => 0,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Báo cáo " . $request->ten_bao_cao . " đã được thêm mới thành công",
            'data' => $baoCao,
        ]);
    }

    /**
     * Cập nhật báo cáo
     * Chỉ cho phép cập nhật báo cáo của chính mình
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:bao_caos,id',
            'ten_bao_cao' => 'required|string|max:255',
            'loai_bao_cao' => 'nullable|string|in:financial,student,activity,attendance,health',
            'duong_dan' => 'nullable|string|max:255',
            'tu_ngay' => 'nullable|date',
            'den_ngay' => 'nullable|date',
        ]);

        // Lấy giáo viên đang đăng nhập
        $giaoVien = Auth::guard('sanctum')->user();

        // Kiểm tra quyền sở hữu
        $baoCao = BaoCao::where('id', $request->id)
            ->where('id_giao_vien', $giaoVien->id)
            ->first();

        if (!$baoCao) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn không có quyền cập nhật báo cáo này',
            ], 403);
        }

        $updateData = [
            'tieu_de' => $request->ten_bao_cao,
        ];

        if ($request->has('loai_bao_cao')) {
            $loaiBaoCao = $this->mapLoaiBaoCao($request->loai_bao_cao);
            if ($loaiBaoCao) {
                $updateData['loai_bao_cao'] = $loaiBaoCao;
            }
        }

        if ($request->has('duong_dan')) {
            $updateData['duong_dan'] = $request->duong_dan;
        }

        if ($request->has('den_ngay') || $request->has('tu_ngay')) {
            $updateData['ngay_ky'] = $request->den_ngay ?? $request->tu_ngay ?? now()->format('Y-m-d');
        }

        $baoCao->update($updateData);

        return response()->json([
            'status' => true,
            'message' => "Báo cáo đã được cập nhật thành công",
        ]);
    }

    /**
     * Xóa báo cáo
     * Chỉ cho phép xóa báo cáo của chính mình
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:bao_caos,id',
        ]);

        // Lấy giáo viên đang đăng nhập
        $giaoVien = Auth::guard('sanctum')->user();

        // Kiểm tra quyền sở hữu và xóa
        $deleted = BaoCao::where('id', $request->id)
            ->where('id_giao_vien', $giaoVien->id)
            ->delete();

        if (!$deleted) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn không có quyền xóa báo cáo này',
            ], 403);
        }

        return response()->json([
            'status' => true,
            'message' => "Báo cáo đã được xóa thành công",
        ]);
    }

    /**
     * Tìm kiếm báo cáo
     * Chỉ tìm trong báo cáo của chính mình
     */
    public function search(Request $request)
    {
        // Lấy giáo viên đang đăng nhập
        $giaoVien = Auth::guard('sanctum')->user();

        $query = BaoCao::select(
            'bao_caos.id',
            'bao_caos.tieu_de',
            'bao_caos.duong_dan',
            'bao_caos.loai_bao_cao',
            'bao_caos.ngay_tao',
            'bao_caos.ngay_ky',
            'bao_caos.tinh_trang',
            'bao_caos.id_giao_vien',
            'bao_caos.id_nhan_vien',
            'giao_viens.ho_va_ten as ten_giao_vien',
            'nhan_viens.ho_va_ten as ten_nhan_vien'
        )
            ->leftJoin('giao_viens', 'bao_caos.id_giao_vien', '=', 'giao_viens.id')
            ->leftJoin('nhan_viens', 'bao_caos.id_nhan_vien', '=', 'nhan_viens.id')
            ->where('bao_caos.id_giao_vien', $giaoVien->id);  // Chỉ tìm trong báo cáo của giáo viên này

        // Tìm kiếm theo tên báo cáo (noi_dung)
        if ($request->filled('noi_dung')) {
            $query->where('bao_caos.tieu_de', 'like', '%' . $request->noi_dung . '%');
        }

        // Tìm kiếm theo loại báo cáo
        if ($request->filled('loai_bao_cao') && $request->loai_bao_cao !== '') {
            $loaiBaoCao = $this->mapLoaiBaoCao($request->loai_bao_cao);
            if ($loaiBaoCao !== null) {
                $query->where('bao_caos.loai_bao_cao', $loaiBaoCao);
            }
        }

        // Tìm kiếm theo trạng thái
        if ($request->filled('trang_thai') && $request->trang_thai !== '') {
            $trangThai = $this->mapTrangThai($request->trang_thai);
            if ($trangThai !== null) {
                $query->where('bao_caos.tinh_trang', $trangThai);
            }
        }

        // Tìm kiếm theo khoảng thời gian (tu_ngay, den_ngay)
        if ($request->filled('tu_ngay')) {
            $query->where('bao_caos.ngay_ky', '>=', $request->tu_ngay);
        }
        if ($request->filled('den_ngay')) {
            $query->where('bao_caos.ngay_ky', '<=', $request->den_ngay);
        }

        $data = $query->orderBy('bao_caos.ngay_tao', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'ten_bao_cao' => $item->tieu_de,
                    'mo_ta' => null,
                    'loai_bao_cao' => $this->reverseMapLoaiBaoCao($item->loai_bao_cao),
                    'duong_dan' => $item->duong_dan,
                    'ngay_tao' => $item->ngay_tao,
                    'tu_ngay' => $item->ngay_ky,
                    'den_ngay' => $item->ngay_ky,
                    'trang_thai' => $this->reverseMapTrangThai($item->tinh_trang),
                    'id_giao_vien' => $item->id_giao_vien,
                    'id_nhan_vien' => $item->id_nhan_vien,
                    'ten_giao_vien' => $item->ten_giao_vien,
                    'ten_nhan_vien' => $item->ten_nhan_vien,
                ];
            });

        return response()->json([
            'status' => true,
            'message' => 'Tìm kiếm báo cáo thành công',
            'data' => $data,
        ]);
    }

    /**
     * Thống kê báo cáo
     * Chỉ thống kê báo cáo của chính mình
     */
    public function statistical()
    {
        // Lấy giáo viên đang đăng nhập
        $giaoVien = Auth::guard('sanctum')->user();

        $total = BaoCao::where('id_giao_vien', $giaoVien->id)->count();

        // Thống kê theo loại báo cáo
        $byLoaiBaoCao = BaoCao::select('loai_bao_cao', DB::raw('COUNT(*) as count'))
            ->where('id_giao_vien', $giaoVien->id)
            ->groupBy('loai_bao_cao')
            ->get()
            ->map(function ($item) {
                return [
                    'loai_bao_cao' => $this->reverseMapLoaiBaoCao($item->loai_bao_cao),
                    'count' => $item->count,
                ];
            });

        // Thống kê theo trạng thái
        $byTrangThai = BaoCao::select('tinh_trang', DB::raw('COUNT(*) as count'))
            ->where('id_giao_vien', $giaoVien->id)
            ->groupBy('tinh_trang')
            ->get()
            ->map(function ($item) {
                return [
                    'trang_thai' => $this->reverseMapTrangThai($item->tinh_trang),
                    'count' => $item->count,
                ];
            });

        // Thống kê theo tháng
        $byMonth = BaoCao::selectRaw('DATE_FORMAT(ngay_tao, "%Y-%m") as month, COUNT(*) as count')
            ->where('id_giao_vien', $giaoVien->id)
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Thống kê theo tuần (7 ngày gần nhất)
        $byWeek = BaoCao::selectRaw('DATE_FORMAT(ngay_tao, "%Y-%u") as week, COUNT(*) as count')
            ->where('id_giao_vien', $giaoVien->id)
            ->where('ngay_tao', '>=', now()->subDays(7))
            ->groupBy('week')
            ->orderBy('week', 'asc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Thống kê báo cáo',
            'data' => [
                'total_records' => $total,
                'by_loai_bao_cao' => $byLoaiBaoCao,
                'by_trang_thai' => $byTrangThai,
                'by_month' => $byMonth,
                'by_week' => $byWeek,
            ],
        ]);
    }

    /**
     * Thay đổi trạng thái báo cáo
     * Chỉ cho phép đổi trạng thái báo cáo của chính mình
     */
    public function changeStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:bao_caos,id',
            'trang_thai' => 'required|string|in:completed,pending,failed',
        ]);

        // Lấy giáo viên đang đăng nhập
        $giaoVien = Auth::guard('sanctum')->user();

        $trangThai = $this->mapTrangThai($request->trang_thai);
        if ($trangThai === null) {
            return response()->json([
                'status' => false,
                'message' => 'Trạng thái không hợp lệ',
            ], 400);
        }

        // Kiểm tra quyền sở hữu và cập nhật
        $updated = BaoCao::where('id', $request->id)
            ->where('id_giao_vien', $giaoVien->id)
            ->update([
                'tinh_trang' => $trangThai,
            ]);

        if (!$updated) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn không có quyền thay đổi trạng thái báo cáo này',
            ], 403);
        }

        return response()->json([
            'status' => true,
            'message' => "Trạng thái báo cáo đã được cập nhật thành công",
        ]);
    }
}
