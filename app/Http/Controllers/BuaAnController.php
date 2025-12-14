<?php

namespace App\Http\Controllers;

use App\Models\BuaAn;
use Illuminate\Http\Request;

class BuaAnController extends Controller
{
    /**
     * API: /bua-an
     * Lấy toàn bộ dữ liệu bữa ăn
     */
    public function getBuaAn()
    {
        $data = BuaAn::all();

        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu bữa ăn thành công',
            'data' => $data,
        ]);
    }

    /**
     * API: /bua-an/create
     * Tạo mới bữa ăn
     */
    public function createBuaAn(Request $request)
    {
        $request->validate([
            'ten_bua_an' => 'required|string|max:255',
            'mo_ta' => 'nullable|string',
        ]);

        $buaAn = BuaAn::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Thêm bữa ăn "' . $buaAn->ten_bua_an . '" thành công',
            'data' => $buaAn,
        ]);
    }

    /**
     * API: /bua-an/update
     * Cập nhật thông tin bữa ăn
     */
    public function updateBuaAn(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:bua_ans,id',
            'ten_bua_an' => 'required|string|max:255',
            'mo_ta' => 'nullable|string',
        ]);

        $buaAn = BuaAn::find($request->id);
        $buaAn->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật bữa ăn "' . $buaAn->ten_bua_an . '" thành công',
            'data' => $buaAn,
        ]);
    }

    /**
     * API: /bua-an/delete
     * Xóa bữa ăn
     */
    public function deleteBuaAn(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:bua_ans,id',
        ]);

        BuaAn::where('id', $request->id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Xóa bữa ăn thành công',
        ]);
    }

    /**
     * API: /bua-an/search
     * Tìm kiếm bữa ăn theo tên hoặc mô tả
     */
    public function searchBuaAn(Request $request)
    {
        $keyword = $request->keyword ?? '';

        $data = BuaAn::where('ten_bua_an', 'like', "%{$keyword}%")
            ->orWhere('mo_ta', 'like', "%{$keyword}%")
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Tìm kiếm bữa ăn thành công',
            'data' => $data,
        ]);
    }

    /**
     * API: /bua-an/changes
     * Thay đổi nhanh một trường cụ thể (ví dụ mô tả)
     */
    public function changesBuaAn(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:bua_ans,id',
            'field' => 'required|string',
            'value' => 'nullable',
        ]);

        $buaAn = BuaAn::find($request->id);
        $buaAn->{$request->field} = $request->value;
        $buaAn->save();

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật thông tin bữa ăn thành công',
            'data' => $buaAn,
        ]);
    }
}
