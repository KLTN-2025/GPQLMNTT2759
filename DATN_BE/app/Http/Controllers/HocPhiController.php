<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateHocPhiRequest;
use App\Http\Requests\DeleteHocPhiRequest;
use App\Http\Requests\UpdateHocPhiRequest;
use App\Models\HocPhi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HocPhiController extends Controller
{
    /**
     * Lấy danh sách học phí
     */
    public function getHocPhi()
    {
        $data = HocPhi::all();

        return response()->json([
            'status' => true,
            'message' => 'Danh sách học phí',
            'data' => $data
        ]);
    }

    /**
     * Thêm mới học phí
     */
    public function createHocPhi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ten_hoc_phi' => 'required|string|max:255',
            'so_tien' => 'required|numeric|min:0',
            'ngay_bat_dau' => 'required|date',
            'ngay_ket_thuc' => 'required|date|after_or_equal:ngay_bat_dau',
            'mo_ta' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors(),
            ], 422);
        }

        $hocPhi = HocPhi::create($validator->validated());

        return response()->json([
            'status' => true,
            'message' => 'Thêm học phí thành công',
            'data' => $hocPhi
        ]);
    }

    /**
     * Cập nhật thông tin học phí
     */
    public function updateHocPhi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:hoc_phis,id',
            'ten_hoc_phi' => 'string|max:255',
            'so_tien' => 'numeric|min:0',
            'ngay_bat_dau' => 'date',
            'ngay_ket_thuc' => 'date|after_or_equal:ngay_bat_dau',
            'mo_ta' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors(),
            ], 422);
        }

        $hocPhi = HocPhi::find($request->id);
        $hocPhi->update($validator->validated());

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật học phí thành công',
            'data' => $hocPhi
        ]);
    }

    /**
     * Xóa học phí
     */
    public function deleteHocPhi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:hoc_phis,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Không tìm thấy học phí cần xóa',
                'errors' => $validator->errors(),
            ], 422);
        }

        HocPhi::destroy($request->id);

        return response()->json([
            'status' => true,
            'message' => 'Xóa học phí thành công',
        ]);
    }

    /**
     * Tìm kiếm học phí (theo tên, mô tả hoặc khoảng thời gian)
     */
    public function searchHocPhi(Request $request)
    {
        $keyword = $request->keyword ?? '';

        $data = HocPhi::query()
            ->where('ten_hoc_phi', 'like', "%$keyword%")
            ->orWhere('mo_ta', 'like', "%$keyword%")
            ->orWhere('so_tien', 'like', "%$keyword%")
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Kết quả tìm kiếm học phí',
            'data' => $data
        ]);
    }

    /**
     * Cập nhật nhanh một trường (ví dụ: tên, số tiền, mô tả)
     */
    public function changesHocPhi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:hoc_phis,id',
            'field' => 'required|string',
            'value' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors(),
            ], 422);
        }

        $hocPhi = HocPhi::find($request->id);
        $field = $request->field;

        if (!in_array($field, ['ten_hoc_phi', 'so_tien', 'ngay_bat_dau', 'ngay_ket_thuc', 'mo_ta'])) {
            return response()->json([
                'status' => false,
                'message' => 'Trường không hợp lệ để cập nhật',
            ], 400);
        }

        $hocPhi->$field = $request->value;
        $hocPhi->save();

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật nhanh học phí thành công',
            'data' => $hocPhi
        ]);
    }

    // --- Các hàm chính theo cấu trúc admin/hoc-phi ---
    public function getData()
    {
        $data = HocPhi::select(
            'hoc_phis.id',
            'hoc_phis.ten_loai_phi',
            'hoc_phis.don_gia',
            'hoc_phis.don_vi_tinh',
            'hoc_phis.ap_dung_tu_ngay',
            'hoc_phis.ap_dung_den_ngay',
            'hoc_phis.mo_ta',
            'hoc_phis.tinh_trang',
            \Illuminate\Support\Facades\DB::raw('COUNT(DISTINCT hoa_don_hoc_phis.id_hoc_sinh) as so_hoc_sinh'),
            \Illuminate\Support\Facades\DB::raw('COALESCE(SUM(chi_tiet_hoc_phis.thanh_tien), 0) as tong_so_tien'),
            \Illuminate\Support\Facades\DB::raw('COALESCE(SUM(CASE WHEN hoa_don_hoc_phis.tinh_trang = 1 THEN chi_tiet_hoc_phis.thanh_tien ELSE 0 END), 0) as da_thu'),
            \Illuminate\Support\Facades\DB::raw('COALESCE(SUM(chi_tiet_hoc_phis.thanh_tien), 0) - COALESCE(SUM(CASE WHEN hoa_don_hoc_phis.tinh_trang = 1 THEN chi_tiet_hoc_phis.thanh_tien ELSE 0 END), 0) as con_lai')
        )
            ->leftJoin('chi_tiet_hoc_phis', 'hoc_phis.id', '=', 'chi_tiet_hoc_phis.id_hoc_phi')
            ->leftJoin('hoa_don_hoc_phis', 'chi_tiet_hoc_phis.id_hoa_don_hoc_phi', '=', 'hoa_don_hoc_phis.id')
            ->groupBy(
                'hoc_phis.id',
                'hoc_phis.ten_loai_phi',
                'hoc_phis.don_gia',
                'hoc_phis.don_vi_tinh',
                'hoc_phis.ap_dung_tu_ngay',
                'hoc_phis.ap_dung_den_ngay',
                'hoc_phis.mo_ta',
                'hoc_phis.tinh_trang',
            )
            ->orderBy('hoc_phis.ap_dung_tu_ngay', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Load dữ liệu học phí thành công',
            'data' => $data,
        ]);
    }

    public function store(CreateHocPhiRequest $request)
    {
        HocPhi::create([
            'ten_loai_phi' => $request->ten_loai_phi,
            'don_gia' => $request->don_gia,
            'don_vi_tinh' => $request->don_vi_tinh,
            'ap_dung_tu_ngay' => $request->ap_dung_tu_ngay,
            'ap_dung_den_ngay' => $request->ap_dung_den_ngay,
            'mo_ta' => $request->mo_ta,
            'tinh_trang' => $request->tinh_trang ?? 1,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Loại phí " . $request->ten_loai_phi . " đã được thêm mới thành công",
        ]);
    }

    public function update(UpdateHocPhiRequest $request)
    {
        HocPhi::where('id', $request->id)->update([
            'ten_loai_phi' => $request->ten_loai_phi,
            'don_gia' => $request->don_gia,
            'don_vi_tinh' => $request->don_vi_tinh,
            'ap_dung_tu_ngay' => $request->ap_dung_tu_ngay,
            'ap_dung_den_ngay' => $request->ap_dung_den_ngay,
            'mo_ta' => $request->mo_ta,
            'tinh_trang' => $request->tinh_trang ?? 1,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Loại phí " . $request->ten_loai_phi . " đã được cập nhật thành công",
        ]);
    }

    public function destroy(DeleteHocPhiRequest $request)
    {
        // Kiểm tra xem loại phí có đang được sử dụng trong chi tiết học phí không
        $isUsed = \App\Models\ChiTietHocPhi::where('id_hoc_phi', $request->id)->exists();

        if ($isUsed) {
            return response()->json([
                'status' => false,
                'message' => 'Không thể xóa loại phí này vì đang được sử dụng trong hóa đơn',
            ], 400);
        }

        HocPhi::where('id', $request->id)->delete();

        return response()->json([
            'status' => true,
            'message' => "Loại phí đã được xóa thành công",
        ]);
    }

    public function search(Request $request)
    {
        $query = HocPhi::select(
            'hoc_phis.id',
            'hoc_phis.ten_loai_phi',
            'hoc_phis.don_gia',
            'hoc_phis.don_vi_tinh',
            'hoc_phis.ap_dung_tu_ngay',
            'hoc_phis.ap_dung_den_ngay',
            'hoc_phis.mo_ta',
            'hoc_phis.tinh_trang',
            'hoc_phis.created_at',
            'hoc_phis.updated_at',
            \Illuminate\Support\Facades\DB::raw('COUNT(DISTINCT hoa_don_hoc_phis.id_hoc_sinh) as so_hoc_sinh'),
            \Illuminate\Support\Facades\DB::raw('COALESCE(SUM(chi_tiet_hoc_phis.thanh_tien), 0) as tong_so_tien'),
            \Illuminate\Support\Facades\DB::raw('COALESCE(SUM(CASE WHEN hoa_don_hoc_phis.tinh_trang = 1 THEN chi_tiet_hoc_phis.thanh_tien ELSE 0 END), 0) as da_thu')
        )
            ->leftJoin('chi_tiet_hoc_phis', 'hoc_phis.id', '=', 'chi_tiet_hoc_phis.id_hoc_phi')
            ->leftJoin('hoa_don_hoc_phis', 'chi_tiet_hoc_phis.id_hoa_don_hoc_phi', '=', 'hoa_don_hoc_phis.id');

        // Tìm kiếm theo tên loại phí
        if ($request->filled('noi_dung')) {
            $query->where('hoc_phis.ten_loai_phi', 'like', '%' . $request->noi_dung . '%');
        }

        // Tìm kiếm theo giá
        if ($request->filled('don_gia_min')) {
            $query->where('hoc_phis.don_gia', '>=', $request->don_gia_min);
        }
        if ($request->filled('don_gia_max')) {
            $query->where('hoc_phis.don_gia', '<=', $request->don_gia_max);
        }

        // Tìm kiếm theo trạng thái
        if ($request->filled('tinh_trang')) {
            $query->where('hoc_phis.tinh_trang', $request->tinh_trang);
        }

        // Tìm kiếm theo mô tả
        if ($request->filled('mo_ta')) {
            $query->where('hoc_phis.mo_ta', 'like', '%' . $request->mo_ta . '%');
        }

        // Tìm kiếm theo ngày áp dụng
        if ($request->filled('ap_dung_tu_ngay')) {
            $query->where('hoc_phis.ap_dung_den_ngay', '>=', $request->ap_dung_tu_ngay);
        }
        if ($request->filled('ap_dung_den_ngay')) {
            $query->where('hoc_phis.ap_dung_tu_ngay', '<=', $request->ap_dung_den_ngay);
        }

        $data = $query
            ->groupBy(
                'hoc_phis.id',
                'hoc_phis.ten_loai_phi',
                'hoc_phis.don_gia',
                'hoc_phis.don_vi_tinh',
                'hoc_phis.ap_dung_tu_ngay',
                'hoc_phis.ap_dung_den_ngay',
                'hoc_phis.mo_ta',
                'hoc_phis.tinh_trang',
                'hoc_phis.created_at',
                'hoc_phis.updated_at'
            )
            ->orderBy('hoc_phis.ap_dung_tu_ngay', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Load dữ liệu học phí thành công',
            'data' => $data,
        ]);
    }

    public function statistical()
    {
        $total = HocPhi::count();
        $totalActive = HocPhi::where('tinh_trang', 1)->count();
        $totalInactive = HocPhi::where('tinh_trang', 0)->count();

        // Tổng số tiền từ tất cả chi tiết học phí
        $totalAmount = \App\Models\ChiTietHocPhi::sum('thanh_tien');

        // Tổng số tiền đã thu (từ hóa đơn đã thanh toán)
        $totalCollected = \App\Models\ChiTietHocPhi::join('hoa_don_hoc_phis', 'chi_tiet_hoc_phis.id_hoa_don_hoc_phi', '=', 'hoa_don_hoc_phis.id')
            ->where('hoa_don_hoc_phis.tinh_trang', 1)
            ->sum('chi_tiet_hoc_phis.thanh_tien');

        // Thống kê theo tháng (dựa trên ngày áp dụng)
        $byMonth = HocPhi::selectRaw('DATE_FORMAT(ap_dung_tu_ngay, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Thống kê theo trạng thái
        $byStatus = HocPhi::select('tinh_trang')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('tinh_trang')
            ->get();

        // Thống kê theo loại phí (top 10 loại phí được sử dụng nhiều nhất)
        $topFeeTypes = HocPhi::select(
            'hoc_phis.id',
            'hoc_phis.ten_loai_phi',
            \Illuminate\Support\Facades\DB::raw('COUNT(DISTINCT hoa_don_hoc_phis.id_hoc_sinh) as so_luong_su_dung'),
            \Illuminate\Support\Facades\DB::raw('COALESCE(SUM(chi_tiet_hoc_phis.thanh_tien), 0) as tong_so_tien')
        )
            ->leftJoin('chi_tiet_hoc_phis', 'hoc_phis.id', '=', 'chi_tiet_hoc_phis.id_hoc_phi')
            ->leftJoin('hoa_don_hoc_phis', 'chi_tiet_hoc_phis.id_hoa_don_hoc_phi', '=', 'hoa_don_hoc_phis.id')
            ->groupBy('hoc_phis.id', 'hoc_phis.ten_loai_phi')
            ->orderBy('so_luong_su_dung', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Thống kê học phí',
            'data' => [
                'total_records' => $total,
                'total_active' => $totalActive,
                'total_inactive' => $totalInactive,
                'total_amount' => $totalAmount,
                'total_collected' => $totalCollected,
                'total_pending' => $totalAmount - $totalCollected,
                'by_month' => $byMonth,
                'by_status' => $byStatus,
                'top_fee_types' => $topFeeTypes,
            ],
        ]);
    }
}
