<?php

namespace App\Http\Controllers;

use App\Models\MonAn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonAnController extends Controller
{
    /**
     * Lấy danh sách món ăn
     */
    public function getData()
    {
        $data = MonAn::orderBy('created_at', 'desc')->get();

        return response()->json([
            'status' => true,
            'message' => 'Load dữ liệu món ăn thành công',
            'data' => $data,
        ]);
    }

    /**
     * Thêm mới món ăn
     */
    public function store(Request $request)
    {
        $request->validate([
            'ten_mon' => 'required|string|max:255',
            'mo_ta' => 'nullable|string',
            'ghi_chu' => 'nullable|string',
            'hinh_anh' => 'nullable|string',
            'loai_mon' => 'required|string|max:100',
            'nguon_goc' => 'required|string|max:100',
            'calo' => 'required|integer|min:0',
            'protein' => 'nullable|numeric|min:0',
            'carb' => 'nullable|numeric|min:0',
            'fat' => 'nullable|numeric|min:0',
            'is_block' => 'nullable|boolean',
        ]);

        $monAn = MonAn::create([
            'ten_mon' => $request->ten_mon,
            'mo_ta' => $request->mo_ta,
            'ghi_chu' => $request->ghi_chu,
            'hinh_anh' => $request->hinh_anh,
            'loai_mon' => $request->loai_mon,
            'nguon_goc' => $request->nguon_goc,
            'calo' => $request->calo,
            'protein' => $request->protein,
            'carb' => $request->carb,
            'fat' => $request->fat,
            'is_block' => $request->is_block ?? 0,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Món ăn " . $request->ten_mon . " đã được thêm mới thành công",
        ]);
    }

    /**
     * Cập nhật món ăn
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:mon_ans,id',
            'ten_mon' => 'required|string|max:255',
            'mo_ta' => 'nullable|string',
            'ghi_chu' => 'nullable|string',
            'hinh_anh' => 'nullable|string',
            'loai_mon' => 'required|string|max:100',
            'nguon_goc' => 'required|string|max:100',
            'calo' => 'required|integer|min:0',
            'protein' => 'nullable|numeric|min:0',
            'carb' => 'nullable|numeric|min:0',
            'fat' => 'nullable|numeric|min:0',
            'is_block' => 'nullable|boolean',
        ]);

        MonAn::where('id', $request->id)->update([
            'ten_mon' => $request->ten_mon,
            'mo_ta' => $request->mo_ta,
            'ghi_chu' => $request->ghi_chu,
            'hinh_anh' => $request->hinh_anh,
            'loai_mon' => $request->loai_mon,
            'nguon_goc' => $request->nguon_goc,
            'calo' => $request->calo,
            'protein' => $request->protein,
            'carb' => $request->carb,
            'fat' => $request->fat,
            'is_block' => $request->is_block ?? 0,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Món ăn " . $request->ten_mon . " đã được cập nhật thành công",
        ]);
    }

    /**
     * Xóa món ăn
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:mon_ans,id',
        ]);

        MonAn::where('id', $request->id)->delete();

        return response()->json([
            'status' => true,
            'message' => "Món ăn đã được xóa thành công",
        ]);
    }

    /**
     * Tìm kiếm món ăn
     */
    public function search(Request $request)
    {
        $query = MonAn::query();

        // Tìm kiếm theo nội dung (tên món, loại món, nguồn gốc)
        if ($request->filled('noi_dung')) {
            $noiDung = $request->noi_dung;
            $query->where(function ($q) use ($noiDung) {
                $q->where('ten_mon', 'like', '%' . $noiDung . '%')
                    ->orWhere('loai_mon', 'like', '%' . $noiDung . '%')
                    ->orWhere('nguon_goc', 'like', '%' . $noiDung . '%');
            });
        }

        // Tìm kiếm theo loại món
        if ($request->filled('loai_mon')) {
            $query->where('loai_mon', $request->loai_mon);
        }

        // Tìm kiếm theo nguồn gốc
        if ($request->filled('nguon_goc')) {
            $query->where('nguon_goc', $request->nguon_goc);
        }

        // Tìm kiếm theo trạng thái
        if ($request->filled('is_block')) {
            $query->where('is_block', $request->is_block);
        }

        // Tìm kiếm theo calo (từ - đến)
        if ($request->filled('calo_min')) {
            $query->where('calo', '>=', $request->calo_min);
        }
        if ($request->filled('calo_max')) {
            $query->where('calo', '<=', $request->calo_max);
        }

        $data = $query->orderBy('ten_mon', 'asc')->get();

        return response()->json([
            'status' => true,
            'message' => 'Load dữ liệu món ăn thành công',
            'data' => $data,
        ]);
    }

    /**
     * Thống kê món ăn
     */
    public function statistical()
    {
        $total = MonAn::count();
        $totalActive = MonAn::where('is_block', 0)->count();
        $totalBlocked = MonAn::where('is_block', 1)->count();

        // Thống kê theo loại món
        $byLoaiMon = MonAn::select('loai_mon')
            ->selectRaw('COUNT(*) as so_luong')
            ->groupBy('loai_mon')
            ->get();

        // Thống kê theo nguồn gốc
        $byNguonGoc = MonAn::select('nguon_goc')
            ->selectRaw('COUNT(*) as so_luong')
            ->groupBy('nguon_goc')
            ->get();

        // Trung bình calo
        $avgCalo = MonAn::avg('calo');

        // Top 10 món ăn có calo cao nhất
        $topCalo = MonAn::orderBy('calo', 'desc')
            ->limit(10)
            ->select('id', 'ten_mon', 'calo', 'loai_mon')
            ->get();

        // Top 10 món ăn có calo thấp nhất
        $lowCalo = MonAn::orderBy('calo', 'asc')
            ->limit(10)
            ->select('id', 'ten_mon', 'calo', 'loai_mon')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Thống kê món ăn',
            'data' => [
                'total_records' => $total,
                'total_active' => $totalActive,
                'total_blocked' => $totalBlocked,
                'avg_calo' => round($avgCalo, 2),
                'by_loai_mon' => $byLoaiMon,
                'by_nguon_goc' => $byNguonGoc,
                'top_calo' => $topCalo,
                'low_calo' => $lowCalo,
            ],
        ]);
    }

    /**
     * Đổi trạng thái món ăn
     */
    public function changeStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:mon_ans,id',
            'is_block' => 'required|integer|in:0,1',
        ]);

        $new_is_block = !$request->is_block;
        MonAn::find($request->id)->update([
            'is_block' => $new_is_block,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Món ăn đã được cập nhật trạng thái thành công",
        ]);
    }
}
