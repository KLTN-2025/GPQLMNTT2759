<?php

namespace App\Http\Controllers;

use App\Models\DongHocPhi;
use App\Models\HocPhi;
use App\Models\HocSinh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DongHocPhiController extends Controller
{
    /**
     * Lấy danh sách đóng học phí
     */
    public function getDongHocPhi()
    {
        $data = DongHocPhi::with(['hocPhi', 'hocSinh'])->get();

        return response()->json([
            'status' => true,
            'message' => 'Danh sách đóng học phí',
            'data' => $data,
        ]);
    }

    /**
     * Thêm mới một lần đóng học phí
     */
    public function createDongHocPhi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_hoc_phi' => 'required|exists:hoc_phis,id',
            'id_hoc_sinh' => 'required|integer',
            'so_tien_dong' => 'required|numeric|min:0',
            'ngay_dong' => 'required|date',
            'hinh_thuc_thanh_toan' => 'required|string|max:255',
            'ghi_chu' => 'nullable|string|max:500',
            'tinh_trang' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors(),
            ], 422);
        }

        $dongHocPhi = DongHocPhi::create($validator->validated());

        return response()->json([
            'status' => true,
            'message' => 'Thêm thông tin đóng học phí thành công',
            'data' => $dongHocPhi,
        ]);
    }

    /**
     * Cập nhật thông tin đóng học phí
     */
    public function updateDongHocPhi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:dong_hoc_phis,id',
            'id_hoc_phi' => 'exists:hoc_phis,id',
            'id_hoc_sinh' => 'integer',
            'so_tien_dong' => 'numeric|min:0',
            'ngay_dong' => 'date',
            'hinh_thuc_thanh_toan' => 'string|max:255',
            'ghi_chu' => 'nullable|string|max:500',
            'tinh_trang' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors(),
            ], 422);
        }

        $dongHocPhi = DongHocPhi::find($request->id);
        $dongHocPhi->update($validator->validated());

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật thông tin đóng học phí thành công',
            'data' => $dongHocPhi,
        ]);
    }

    /**
     * Xóa thông tin đóng học phí
     */
    public function deleteDongHocPhi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:dong_hoc_phis,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Không tìm thấy thông tin cần xóa',
                'errors' => $validator->errors(),
            ], 422);
        }

        DongHocPhi::destroy($request->id);

        return response()->json([
            'status' => true,
            'message' => 'Xóa thông tin đóng học phí thành công',
        ]);
    }

    /**
     * Tìm kiếm đóng học phí theo học sinh, học phí, hoặc ghi chú
     */
    public function searchDongHocPhi(Request $request)
    {
        $keyword = $request->keyword ?? '';

        $data = DongHocPhi::with(['hocPhi', 'hocSinh'])
            ->whereHas('hocPhi', function ($query) use ($keyword) {
                $query->where('ten_hoc_phi', 'like', "%$keyword%");
            })
            ->orWhere('ghi_chu', 'like', "%$keyword%")
            ->orWhere('hinh_thuc_thanh_toan', 'like', "%$keyword%")
            ->orWhere('so_tien_dong', 'like', "%$keyword%")
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Kết quả tìm kiếm thông tin đóng học phí',
            'data' => $data,
        ]);
    }

    /**
     * Cập nhật nhanh một trường cụ thể
     */
    public function changesDongHocPhi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:dong_hoc_phis,id',
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

        $dongHocPhi = DongHocPhi::find($request->id);
        $field = $request->field;

        if (!in_array($field, [
            'id_hoc_phi',
            'id_hoc_sinh',
            'so_tien_dong',
            'ngay_dong',
            'hinh_thuc_thanh_toan',
            'ghi_chu',
            'tinh_trang'
        ])) {
            return response()->json([
                'status' => false,
                'message' => 'Trường không hợp lệ để cập nhật',
            ], 400);
        }

        $dongHocPhi->$field = $request->value;
        $dongHocPhi->save();

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật nhanh thành công',
            'data' => $dongHocPhi,
        ]);
    }
}
