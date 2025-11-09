<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateThucDonRequest;
use App\Http\Requests\DeleteThucDonRequest;
use App\Http\Requests\UpdateThucDonRequest;
use App\Models\ThucDon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ThucDonController extends Controller
{
    /**
     * API: /thuc-don
     * Lấy toàn bộ dữ liệu thực đơn
     */
    public function getThucDon()
    {
        $data = ThucDon::all();

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thực đơn thành công',
            'data' => $data,
        ]);
    }

    /**
     * API: /thuc-don/create
     * Thêm mới một thực đơn
     */
    public function createThucDon(Request $request)
    {
        $request->validate([
            'ten_thuc_don' => 'required|string|max:255',
            'ngay' => 'required|date',
            'mo_ta' => 'nullable|string',
        ]);

        $thucDon = ThucDon::create([
            'ten_thuc_don' => $request->ten_thuc_don,
            'ngay' => $request->ngay,
            'mo_ta' => $request->mo_ta,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Thêm thực đơn "' . $thucDon->ten_thuc_don . '" thành công',
            'data' => $thucDon,
        ]);
    }

    /**
     * API: /thuc-don/update
     * Cập nhật thông tin thực đơn
     */
    public function updateThucDon(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:thuc_dons,id',
            'ten_thuc_don' => 'required|string|max:255',
            'ngay' => 'required|date',
            'mo_ta' => 'nullable|string',
        ]);

        $thucDon = ThucDon::find($request->id);
        $thucDon->update([
            'ten_thuc_don' => $request->ten_thuc_don,
            'ngay' => $request->ngay,
            'mo_ta' => $request->mo_ta,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật thực đơn "' . $request->ten_thuc_don . '" thành công',
        ]);
    }

    /**
     * API: /thuc-don/delete
     * Xóa một thực đơn
     */
    public function deleteThucDon(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:thuc_dons,id',
        ]);

        ThucDon::where('id', $request->id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Xóa thực đơn thành công',
        ]);
    }

    /**
     * API: /thuc-don/search
     * Tìm kiếm thực đơn theo tên hoặc ngày
     */
    public function searchThucDon(Request $request)
    {
        $query = ThucDon::query();

        if ($request->has('keyword') && $request->keyword != '') {
            $query->where('ten_thuc_don', 'like', '%' . $request->keyword . '%')
                ->orWhere('ngay', 'like', '%' . $request->keyword . '%');
        }

        $data = $query->get();

        return response()->json([
            'status' => true,
            'message' => 'Tìm kiếm thực đơn thành công',
            'data' => $data,
        ]);
    }

    /**
     * API: /thuc-don/changes
     * Thay đổi nhanh dữ liệu thực đơn (ví dụ: đổi ngày, mô tả,…)
     */
    public function changesThucDon(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:thuc_dons,id',
            'field' => 'required|string',
            'value' => 'nullable',
        ]);

        $thucDon = ThucDon::find($request->id);
        $thucDon->{$request->field} = $request->value;
        $thucDon->save();

        return response()->json([
            'status' => true,
            'message' => 'Thay đổi thông tin thực đơn thành công',
            'data' => $thucDon,
        ]);
    }

    // --- Các hàm chính theo cấu trúc admin/thuc-don ---
    /**
     * Lấy danh sách thực đơn với thống kê
     */
    public function getData()
    {
        $data = ThucDon::select(
            'thuc_dons.id',
            'thuc_dons.ten_thuc_don',
            'thuc_dons.ngay',
            'thuc_dons.mo_ta',
            DB::raw('COUNT(DISTINCT chi_tiet_thuc_dons.id) as so_mon'),
            DB::raw('GROUP_CONCAT(DISTINCT bua_ans.ten_bua_an SEPARATOR ", ") as loai_bua')
        )
            ->leftJoin('chi_tiet_thuc_dons', 'thuc_dons.id', '=', 'chi_tiet_thuc_dons.id_thuc_don')
            ->leftJoin('bua_ans', 'chi_tiet_thuc_dons.id_bua_an', '=', 'bua_ans.id')
            ->groupBy(
                'thuc_dons.id',
                'thuc_dons.ten_thuc_don',
                'thuc_dons.ngay',
                'thuc_dons.mo_ta'
            )
            ->orderBy('thuc_dons.ngay', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Load dữ liệu thực đơn thành công',
            'data' => $data,
        ]);
    }

    /**
     * Tạo mới thực đơn
     */
    public function store(CreateThucDonRequest $request)
    {
        $thucDon = ThucDon::create([
            'ten_thuc_don' => $request->ten_thuc_don,
            'ngay' => $request->ngay,
            'mo_ta' => $request->mo_ta,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Thực đơn " . $request->ten_thuc_don . " đã được thêm mới thành công",
            'data' => $thucDon,
        ]);
    }

    /**
     * Cập nhật thực đơn
     */
    public function update(UpdateThucDonRequest $request)
    {
        ThucDon::where('id', $request->id)->update([
            'ten_thuc_don' => $request->ten_thuc_don,
            'ngay' => $request->ngay,
            'mo_ta' => $request->mo_ta,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Thực đơn " . $request->ten_thuc_don . " đã được cập nhật thành công",
        ]);
    }

    /**
     * Xóa thực đơn
     */
    public function destroy(DeleteThucDonRequest $request)
    {
        // Kiểm tra xem thực đơn có đang được sử dụng trong chi tiết thực đơn không
        $isUsed = \App\Models\ChiTietThucDon::where('id_thuc_don', $request->id)->exists();

        if ($isUsed) {
            return response()->json([
                'status' => false,
                'message' => 'Không thể xóa thực đơn này vì đang có món ăn được gán',
            ], 400);
        }

        ThucDon::where('id', $request->id)->delete();

        return response()->json([
            'status' => true,
            'message' => "Thực đơn đã được xóa thành công",
        ]);
    }

    /**
     * Tìm kiếm thực đơn
     */
    public function search(Request $request)
    {
        $query = ThucDon::select(
            'thuc_dons.id',
            'thuc_dons.ten_thuc_don',
            'thuc_dons.ngay',
            'thuc_dons.mo_ta',
            DB::raw('COUNT(DISTINCT chi_tiet_thuc_dons.id) as so_mon'),
            DB::raw('GROUP_CONCAT(DISTINCT bua_ans.ten_bua_an SEPARATOR ", ") as loai_bua')
        )
            ->leftJoin('chi_tiet_thuc_dons', 'thuc_dons.id', '=', 'chi_tiet_thuc_dons.id_thuc_don')
            ->leftJoin('bua_ans', 'chi_tiet_thuc_dons.id_bua_an', '=', 'bua_ans.id');

        // Tìm kiếm theo tên thực đơn
        if ($request->filled('noi_dung')) {
            $query->where('thuc_dons.ten_thuc_don', 'like', '%' . $request->noi_dung . '%');
        }

        // Tìm kiếm theo mô tả
        if ($request->filled('mo_ta')) {
            $query->where('thuc_dons.mo_ta', 'like', '%' . $request->mo_ta . '%');
        }

        // Tìm kiếm theo ngày
        if ($request->filled('ngay_tu')) {
            $query->where('thuc_dons.ngay', '>=', $request->ngay_tu);
        }
        if ($request->filled('ngay_den')) {
            $query->where('thuc_dons.ngay', '<=', $request->ngay_den);
        }

        // Tìm kiếm theo loại bữa
        if ($request->filled('id_bua_an')) {
            $query->where('chi_tiet_thuc_dons.id_bua_an', $request->id_bua_an);
        }

        $data = $query
            ->groupBy(
                'thuc_dons.id',
                'thuc_dons.ten_thuc_don',
                'thuc_dons.ngay',
                'thuc_dons.mo_ta'
            )
            ->orderBy('thuc_dons.ngay', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Load dữ liệu thực đơn thành công',
            'data' => $data,
        ]);
    }

    /**
     * Thống kê thực đơn
     */
    public function statistical()
    {
        $total = ThucDon::count();

        // Tổng số món ăn trong tất cả thực đơn
        $totalMonAn = \App\Models\ChiTietThucDon::distinct('id_mon_an')->count('id_mon_an');

        // Thống kê theo tháng
        $byMonth = ThucDon::selectRaw('DATE_FORMAT(ngay, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Thống kê theo loại bữa (số lượng món ăn mỗi loại bữa)
        $byBuaAn = \App\Models\ChiTietThucDon::select(
            'bua_ans.id',
            'bua_ans.ten_bua_an',
            DB::raw('COUNT(chi_tiet_thuc_dons.id) as so_luong_mon')
        )
            ->join('bua_ans', 'chi_tiet_thuc_dons.id_bua_an', '=', 'bua_ans.id')
            ->groupBy('bua_ans.id', 'bua_ans.ten_bua_an')
            ->orderBy('so_luong_mon', 'desc')
            ->get();

        // Thống kê theo tuần (7 ngày gần nhất)
        $byWeek = ThucDon::selectRaw('DATE_FORMAT(ngay, "%Y-%u") as week, COUNT(*) as count')
            ->where('ngay', '>=', now()->subDays(7))
            ->groupBy('week')
            ->orderBy('week', 'asc')
            ->get();

        // Top 10 món ăn được sử dụng nhiều nhất
        $topMonAn = \App\Models\ChiTietThucDon::select(
            'mon_ans.id',
            'mon_ans.ten_mon',
            DB::raw('COUNT(chi_tiet_thuc_dons.id) as so_luong_su_dung')
        )
            ->join('mon_ans', 'chi_tiet_thuc_dons.id_mon_an', '=', 'mon_ans.id')
            ->groupBy('mon_ans.id', 'mon_ans.ten_mon')
            ->orderBy('so_luong_su_dung', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Thống kê thực đơn',
            'data' => [
                'total_records' => $total,
                'total_mon_an' => $totalMonAn,
                'by_month' => $byMonth,
                'by_bua_an' => $byBuaAn,
                'by_week' => $byWeek,
                'top_mon_an' => $topMonAn,
            ],
        ]);
    }
}
