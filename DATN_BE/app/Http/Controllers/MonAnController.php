<?php

namespace App\Http\Controllers;

use App\Models\MonAn;
use Illuminate\Http\Request;

class MonAnController extends Controller
{
    /**
     * API: /mon-an
     * Lấy toàn bộ dữ liệu món ăn
     */
    public function getMonAn()
    {
        $data = MonAn::all();

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu món ăn thành công',
            'data' => $data,
        ]);
    }

    /**
     * API: /mon-an/create
     * Thêm mới món ăn
     */
    public function createMonAn(Request $request)
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
            'is_block' => 'boolean',
        ]);

        $monAn = MonAn::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Thêm món ăn "' . $monAn->ten_mon . '" thành công',
            'data' => $monAn,
        ]);
    }

    /**
     * API: /mon-an/update
     * Cập nhật thông tin món ăn
     */
    public function updateMonAn(Request $request)
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
            'is_block' => 'boolean',
        ]);

        $monAn = MonAn::find($request->id);
        $monAn->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật món ăn "' . $monAn->ten_mon . '" thành công',
            'data' => $monAn,
        ]);
    }

    /**
     * API: /mon-an/delete
     * Xóa món ăn
     */
    public function deleteMonAn(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:mon_ans,id',
        ]);

        MonAn::where('id', $request->id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Xóa món ăn thành công',
        ]);
    }

    /**
     * API: /mon-an/search
     * Tìm kiếm món ăn theo tên hoặc loại
     */
    public function searchMonAn(Request $request)
    {
        $keyword = $request->keyword ?? '';

        $data = MonAn::where('ten_mon', 'like', "%{$keyword}%")
            ->orWhere('loai_mon', 'like', "%{$keyword}%")
            ->orWhere('nguon_goc', 'like', "%{$keyword}%")
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Tìm kiếm món ăn thành công',
            'data' => $data,
        ]);
    }

    /**
     * API: /mon-an/changes
     * Thay đổi nhanh thông tin (VD: chặn/mở món ăn, đổi tên,…)
     */
    public function changesMonAn(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:mon_ans,id',
            'field' => 'required|string',
            'value' => 'nullable',
        ]);

        $monAn = MonAn::find($request->id);
        $monAn->{$request->field} = $request->value;
        $monAn->save();

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật thông tin món ăn thành công',
            'data' => $monAn,
        ]);
    }
}
