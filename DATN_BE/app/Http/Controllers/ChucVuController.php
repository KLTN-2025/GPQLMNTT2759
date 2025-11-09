<?php

namespace App\Http\Controllers;

use App\Models\ChucVu;
use Illuminate\Http\Request;

class ChucVuController extends Controller
{
    public function getData()
    {
        $data = ChucVu::all();
        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu chức vụ thành công',
            'data' => $data,
        ]);
    }
    public function store(Request $request)
    {
        ChucVu::create([
            'ten_chuc_vu' => $request->ten_chuc_vu,
            'slug_chuc_vu' => $request->slug_chuc_vu,
            'tinh_trang' => $request->tinh_trang,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Thêm chức vụ ' . $request->ten_chuc_vu . ' thành công',
        ]);
    }
    public function update(Request $request)
    {
        ChucVu::where('id', $request->id)->update([
            'ten_chuc_vu' => $request->ten_chuc_vu,
            'slug_chuc_vu' => $request->slug_chuc_vu,
            'tinh_trang' => $request->tinh_trang,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Cập nhật chức vụ ' . $request->ten_chuc_vu . ' thành công',
        ]);
    }
    public function destroy(Request $request)
    {
        ChucVu::where('id', $request->id)->delete();
        return response()->json([
            'status' => true,
            'message' => 'Xóa chức vụ thành công',
        ]);
    }

    public function changeStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:chuc_vus,id',
            'tinh_trang' => 'required|integer|in:0,1',
        ]);
        $new_tinh_trang = !$request->tinh_trang;
        ChucVu::find($request->id)->update([
            'tinh_trang' => $new_tinh_trang,
        ]);

        $status = $request->tinh_trang == 1 ? 'khóa' : 'mở khóa';
        return response()->json([
            'status' => true,
            'message' => "Chức vụ đã được {$status} thành công",
        ]);
    }
}
