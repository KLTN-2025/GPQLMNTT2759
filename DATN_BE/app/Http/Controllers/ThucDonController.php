<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateThucDonRequest;
use App\Http\Requests\DeleteThucDonRequest;
use App\Http\Requests\UpdateThucDonRequest;
use App\Models\ThucDon;
use App\Models\ChiTietThucDon;
use App\Models\MonAn;
use App\Models\BuaAn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

    /**
     * API: /thuc-don/tuan-nay
     * Lấy danh sách thực đơn theo tuần (tuần hiện tại hoặc tuần được chỉ định)
     */
    public function getThucDonTuanNay(Request $request)
    {
        // Lấy ngày bắt đầu tuần (Thứ 2)
        $startDate = $request->has('ngay_bat_dau')
            ? Carbon::parse($request->ngay_bat_dau)->startOfWeek(Carbon::MONDAY)
            : Carbon::now()->startOfWeek(Carbon::MONDAY);

        // Lấy ngày kết thúc tuần (Chủ nhật)
        $endDate = $startDate->copy()->endOfWeek(Carbon::SUNDAY);

        // Tên các ngày trong tuần
        $dayNames = [
            1 => 'Thứ 2',
            2 => 'Thứ 3',
            3 => 'Thứ 4',
            4 => 'Thứ 5',
            5 => 'Thứ 6',
            6 => 'Thứ 7',
            0 => 'Chủ nhật'
        ];

        $weeklyMenu = [];

        // Duyệt qua từng ngày trong tuần
        for ($i = 0; $i < 7; $i++) {
            $currentDate = $startDate->copy()->addDays($i);
            $dayOfWeek = $currentDate->dayOfWeek; // 0 = Chủ nhật, 1 = Thứ 2, ..., 6 = Thứ 7

            // Tìm thực đơn cho ngày này
            $thucDon = ThucDon::whereDate('ngay', $currentDate->format('Y-m-d'))->first();

            $meals = [];

            if ($thucDon) {
                // Lấy chi tiết thực đơn với món ăn và bữa ăn
                $chiTietThucDon = ChiTietThucDon::where('id_thuc_don', $thucDon->id)
                    ->join('mon_ans', 'chi_tiet_thuc_dons.id_mon_an', '=', 'mon_ans.id')
                    ->join('bua_ans', 'chi_tiet_thuc_dons.id_bua_an', '=', 'bua_ans.id')
                    ->select(
                        'chi_tiet_thuc_dons.id_bua_an',
                        'chi_tiet_thuc_dons.id_mon_an',
                        'mon_ans.ten_mon',
                        'mon_ans.hinh_anh',
                        'bua_ans.ten_bua_an'
                    )
                    ->get();

                // Nhóm theo bữa ăn
                foreach ($chiTietThucDon as $ct) {
                    $meals[] = [
                        'type' => $ct->id_bua_an,
                        'typeName' => $ct->ten_bua_an,
                        'dish' => [
                            'id' => $ct->id_mon_an,
                            'name' => $ct->ten_mon,
                            'image' => $ct->hinh_anh ? asset('storage/' . $ct->hinh_anh) : asset('images/default-dish.jpg')
                        ]
                    ];
                }
            }

            // Định dạng tên ngày
            $dayName = $dayNames[$dayOfWeek] ?? '';

            $weeklyMenu[] = [
                'day' => strtolower($currentDate->format('l')), // monday, tuesday, etc.
                'dayName' => $dayName,
                'date' => $currentDate->format('d/m/Y'),
                'dateRaw' => $currentDate->format('Y-m-d'),
                'meals' => $meals
            ];
        }

        return response()->json([
            'status' => true,
            'message' => 'Lấy thực đơn tuần thành công',
            'data' => $weeklyMenu,
            'weekInfo' => [
                'startDate' => $startDate->format('Y-m-d'),
                'endDate' => $endDate->format('Y-m-d'),
                'startDateFormatted' => $startDate->format('d/m/Y'),
                'endDateFormatted' => $endDate->format('d/m/Y')
            ]
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
            'thuc_dons.id_lop_hoc',
            DB::raw('COUNT(DISTINCT chi_tiet_thuc_dons.id) as so_mon'),
            DB::raw('MIN(chi_tiet_thuc_dons.id_bua_an) as id_bua_an'),
            DB::raw('MIN(bua_ans.ten_bua_an) as ten_bua_an')
        )
            ->leftJoin('chi_tiet_thuc_dons', 'thuc_dons.id', '=', 'chi_tiet_thuc_dons.id_thuc_don')
            ->leftJoin('bua_ans', 'chi_tiet_thuc_dons.id_bua_an', '=', 'bua_ans.id')
            ->groupBy(
                'thuc_dons.id',
                'thuc_dons.ten_thuc_don',
                'thuc_dons.ngay',
                'thuc_dons.mo_ta',
                'thuc_dons.id_lop_hoc'
            )
            ->orderBy('thuc_dons.ngay', 'desc')
            ->get();

        // Thêm thông tin món ăn cho mỗi thực đơn
        $data->each(function ($thucDon) {
            $monAns = ChiTietThucDon::select(
                'mon_ans.id',
                'mon_ans.ten_mon',
                'mon_ans.hinh_anh',
                'mon_ans.loai_mon',
                'mon_ans.mo_ta',
                'mon_ans.calo',
                'mon_ans.protein',
                'mon_ans.carb',
                'mon_ans.fat'
            )
                ->join('mon_ans', 'chi_tiet_thuc_dons.id_mon_an', '=', 'mon_ans.id')
                ->where('chi_tiet_thuc_dons.id_thuc_don', $thucDon->id)
                ->get();

            $thucDon->mon_ans = $monAns;
            $thucDon->loai_bua = $thucDon->ten_bua_an; // Backwards compatibility
        });

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
        // Create the menu
        $thucDon = ThucDon::create([
            'ten_thuc_don' => $request->ten_thuc_don,
            'ngay' => $request->ngay,
            'mo_ta' => $request->mo_ta,
            'id_lop_hoc' => $request->id_lop_hoc ?? null,
        ]);

        // Create ChiTietThucDon records for each selected dish
        // Note: id_mon_ans from frontend is normalized to id_mon_an in CreateThucDonRequest
        $soMonAn = 0;
        if ($request->has('id_mon_an') && is_array($request->id_mon_an) && count($request->id_mon_an) > 0) {
            foreach ($request->id_mon_an as $idMonAn) {
                ChiTietThucDon::create([
                    'id_thuc_don' => $thucDon->id,
                    'id_mon_an' => $idMonAn,
                    'id_bua_an' => $request->id_bua_an,
                    'so_luong' => 1, // Default quantity
                    'ghi_chu' => null,
                ]);
                $soMonAn++;
            }
        }

        return response()->json([
            'status' => true,
            'message' => "Thực đơn " . $request->ten_thuc_don . " đã được thêm mới thành công với " . $soMonAn . " món ăn",
            'data' => [
                'thuc_don' => $thucDon,
                'so_mon_an' => $soMonAn,
                'id_bua_an' => $request->id_bua_an,
            ],
        ]);
    }

    /**
     * Cập nhật thực đơn
     */
    public function update(UpdateThucDonRequest $request)
    {
        // Cập nhật thông tin thực đơn
        ThucDon::where('id', $request->id)->update([
            'ten_thuc_don' => $request->ten_thuc_don,
            'ngay' => $request->ngay,
            'mo_ta' => $request->mo_ta,
        ]);

        // Cập nhật món ăn: Xóa các chi tiết cũ và tạo mới
        if ($request->has('id_mon_ans') && is_array($request->id_mon_ans)) {
            // Xóa chi tiết thực đơn cũ
            \App\Models\ChiTietThucDon::where('id_thuc_don', $request->id)->delete();

            // Thêm chi tiết thực đơn mới
            foreach ($request->id_mon_ans as $idMonAn) {
                \App\Models\ChiTietThucDon::create([
                    'id_thuc_don' => $request->id,
                    'id_mon_an' => $idMonAn,
                    'id_bua_an' => $request->id_bua_an,
                    'so_luong' => 1,
                ]);
            }
        }

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
        // Xóa các chi tiết thực đơn trước
        \App\Models\ChiTietThucDon::where('id_thuc_don', $request->id)->delete();

        // Sau đó xóa thực đơn
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
