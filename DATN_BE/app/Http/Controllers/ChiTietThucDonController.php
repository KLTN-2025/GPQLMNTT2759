<?php

namespace App\Http\Controllers;

use App\Models\ChiTietThucDon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChiTietThucDonController extends Controller
{
    /**
     * Lấy toàn bộ danh sách chi tiết thực đơn
     */
    public function getChiTietThucDon()
    {
        $data = ChiTietThucDon::all();
        return response()->json([
            'status' => true,
            'message' => 'Danh sách chi tiết thực đơn',
            'data' => $data
        ]);
    }

    /**
     * Tạo mới chi tiết thực đơn
     */
    public function createChiTietThucDon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_thuc_don' => 'required|integer',
            'id_mon_an' => 'required|integer',
            'id_bua_an' => 'required|integer',
            'so_luong' => 'required|integer|min:1',
            'ghi_chu' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors(),
            ], 422);
        }

        $chiTiet = ChiTietThucDon::create($validator->validated());

        return response()->json([
            'status' => true,
            'message' => 'Tạo chi tiết thực đơn thành công',
            'data' => $chiTiet
        ]);
    }

    /**
     * Cập nhật chi tiết thực đơn
     */
    public function updateChiTietThucDon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:chi_tiet_thuc_dons,id',
            'id_thuc_don' => 'integer',
            'id_mon_an' => 'integer',
            'id_bua_an' => 'integer',
            'so_luong' => 'integer|min:1',
            'ghi_chu' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors(),
            ], 422);
        }

        $chiTiet = ChiTietThucDon::find($request->id);
        $chiTiet->update($validator->validated());

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật thành công',
            'data' => $chiTiet
        ]);
    }

    /**
     * Xóa chi tiết thực đơn
     */
    public function deleteChiTietThucDon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:chi_tiet_thuc_dons,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Không tìm thấy chi tiết cần xóa',
                'errors' => $validator->errors(),
            ], 422);
        }

        ChiTietThucDon::destroy($request->id);

        return response()->json([
            'status' => true,
            'message' => 'Xóa chi tiết thực đơn thành công',
        ]);
    }

    /**
     * Tìm kiếm chi tiết thực đơn theo từ khóa
     */
    public function searchChiTietThucDon(Request $request)
    {
        $keyword = $request->keyword ?? '';

        $data = ChiTietThucDon::query()
            ->where('ghi_chu', 'like', "%$keyword%")
            ->orWhere('id_thuc_don', $keyword)
            ->orWhere('id_mon_an', $keyword)
            ->orWhere('id_bua_an', $keyword)
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Kết quả tìm kiếm',
            'data' => $data
        ]);
    }

    /**
     * Thay đổi nhanh một thuộc tính (ví dụ: số lượng, ghi chú)
     */
    public function changesChiTietThucDon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:chi_tiet_thuc_dons,id',
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

        $chiTiet = ChiTietThucDon::find($request->id);
        $field = $request->field;

        if (!in_array($field, ['id_thuc_don', 'id_mon_an', 'id_bua_an', 'so_luong', 'ghi_chu'])) {
            return response()->json([
                'status' => false,
                'message' => 'Trường không hợp lệ để cập nhật',
            ], 400);
        }

        $chiTiet->$field = $request->value;
        $chiTiet->save();

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật nhanh thành công',
            'data' => $chiTiet
        ]);
    }
}
