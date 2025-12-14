<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNamHocRequest;
use App\Http\Requests\DeleteNamHocRequest;
use App\Http\Requests\UpdateNamHocRequest;
use App\Models\NamHoc;
use Illuminate\Http\Request;

class NamHocController extends Controller
{
    public function getData()
    {
        $id_chuc_nang = 6;
        $data = NamHoc::all();
        return response()->json([
            'status' => true,
            'message' => 'Load dữ liệu năm học thành công',
            'id_chuc_nang' => $id_chuc_nang,
            'data' => $data,
        ]);
    }

    public function store(CreateNamHocRequest $request)
    {
        NamHoc::create([
            'ten_nam_hoc'   => $request->ten_nam_hoc,
            'ngay_bat_dau'  => $request->ngay_bat_dau,
            'ngay_ket_thuc' => $request->ngay_ket_thuc,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Năm học " . $request->ten_nam_hoc . " đã được thêm mới thành công",
        ]);
    }

    public function update(UpdateNamHocRequest $request)
    {
        NamHoc::where('id', $request->id)->update([
            'ten_nam_hoc'   => $request->ten_nam_hoc,
            'ngay_bat_dau'  => $request->ngay_bat_dau,
            'ngay_ket_thuc' => $request->ngay_ket_thuc,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Năm học " . $request->ten_nam_hoc . " đã được cập nhật thành công",
        ]);
    }

    public function destroy(DeleteNamHocRequest $request)
    {
        NamHoc::where('id', $request->id)->delete();
        return response()->json([
            'status' => true,
            'message' => "Năm học đã được xóa thành công",
        ]);
    }

    public function search(Request $request)
    {
        $query = NamHoc::query();

        // Tìm kiếm theo nội dung (tên năm học)
        if ($request->filled('noi_dung')) {
            $noiDung = $request->noi_dung;
            $query->where('ten_nam_hoc', 'like', '%' . $noiDung . '%');
        }

        // Tìm kiếm theo ngày bắt đầu
        if ($request->filled('ngay_bat_dau')) {
            $query->where('ngay_bat_dau', '>=', $request->ngay_bat_dau);
        }

        // Tìm kiếm theo ngày kết thúc
        if ($request->filled('ngay_ket_thuc')) {
            $query->where('ngay_ket_thuc', '<=', $request->ngay_ket_thuc);
        }

        $data = $query->get();

        return response()->json([
            'status' => true,
            'message' => 'Load dữ liệu năm học thành công',
            'data' => $data,
        ]);
    }

    public function changeStatus(Request $request)
    {
        // Lưu ý: Bảng nam_hocs không có trường tinh_trang hoặc is_block
        // Hàm này có thể được sử dụng để thêm logic khác trong tương lai
        return response()->json([
            'status' => false,
            'message' => 'Chức năng đổi trạng thái chưa được hỗ trợ cho năm học',
        ]);
    }
}
