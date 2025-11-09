<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateHocSinhRequest;
use App\Http\Requests\DeleteHocSinhRequest;
use App\Http\Requests\UpdateHocSinhRequest;
use App\Models\HocSinh;
use App\Models\LopHoc;
use App\Models\PhuHuynh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HocSinhController extends Controller
{
    public function getData()
    {
        $id_chuc_nang = 4;
        $data = HocSinh::join('lop_hocs', 'hoc_sinhs.id_lop_hoc', 'lop_hocs.id')
            ->join('phu_huynhs', 'hoc_sinhs.id_phu_huynh', 'phu_huynhs.id')
            ->select(
                'hoc_sinhs.id',
                'hoc_sinhs.ho_va_ten',
                'hoc_sinhs.gioi_tinh',
                'hoc_sinhs.avatar',
                'hoc_sinhs.ngay_sinh',
                'hoc_sinhs.dia_chi',
                'hoc_sinhs.tinh_trang',
                'hoc_sinhs.id_lop_hoc',
                'hoc_sinhs.id_phu_huynh',
                'hoc_sinhs.is_block',
                'lop_hocs.ten_lop',
                'phu_huynhs.ho_va_ten as ten_phu_huynh',
                'phu_huynhs.so_dien_thoai as sdt_phu_huynh'
            )
            ->get();
        return response()->json([
            'status' => true,
            'message' => 'Load dữ liệu học sinh thành công',
            'id_chuc_nang' => $id_chuc_nang,
            'data' => $data,
        ]);
    }

    public function search(Request $request)
    {
        $conditions = [
            'noi_dung'   => ['field' => 'hoc_sinhs.ho_va_ten', 'operator' => 'like'],
            'tinh_trang' => ['field' => 'hoc_sinhs.tinh_trang', 'operator' => '='],
            'gioi_tinh' => ['field' => 'hoc_sinhs.gioi_tinh', 'operator' => '='],
            'id_lop_hoc' => ['field' => 'hoc_sinhs.id_lop_hoc', 'operator' => '='],
        ];

        $query = HocSinh::join('lop_hocs', 'hoc_sinhs.id_lop_hoc', 'lop_hocs.id')
            ->join('phu_huynhs', 'hoc_sinhs.id_phu_huynh', 'phu_huynhs.id');

        foreach ($conditions as $key => $rule) {
            if ($request->filled($key)) {
                if ($rule['operator'] === 'like') {
                    $query->where($rule['field'], 'like', '%' . $request->$key . '%');
                } else {
                    $query->where($rule['field'], $request->$key);
                }
            }
        }

        $data = $query
            ->select(
                'hoc_sinhs.id',
                'hoc_sinhs.ho_va_ten',
                'hoc_sinhs.gioi_tinh',
                'hoc_sinhs.avatar',
                'hoc_sinhs.ngay_sinh',
                'hoc_sinhs.dia_chi',
                'hoc_sinhs.tinh_trang',
                'hoc_sinhs.id_lop_hoc',
                'hoc_sinhs.id_phu_huynh',
                'hoc_sinhs.is_block',
                'lop_hocs.ten_lop',
                'phu_huynhs.ho_va_ten as ten_phu_huynh',
                'phu_huynhs.so_dien_thoai as sdt_phu_huynh'
            )
            ->get();
        return response()->json([
            'status' => true,
            'message' => 'Load dữ liệu học sinh thành công',
            'data' => $data,
        ]);
    }

    public function store(CreateHocSinhRequest $request)
    {
        HocSinh::create([
            'ho_va_ten'     => $request->ho_va_ten,
            'gioi_tinh'     => $request->gioi_tinh,
            'avatar'        => $request->avatar,
            'ngay_sinh'     => $request->ngay_sinh,
            'dia_chi'       => $request->dia_chi,
            'tinh_trang'    => $request->tinh_trang,
            'id_lop_hoc'    => $request->id_lop_hoc,
            'id_phu_huynh'  => $request->id_phu_huynh,
            'is_block'      => 0,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Học sinh " . $request->ho_va_ten . " đã được thêm mới thành công",
        ]);
    }

    public function update(UpdateHocSinhRequest $request)
    {
        HocSinh::where('id', $request->id)->update([
            'ho_va_ten'     => $request->ho_va_ten,
            'gioi_tinh'     => $request->gioi_tinh,
            'avatar'        => $request->avatar,
            'ngay_sinh'     => $request->ngay_sinh,
            'dia_chi'       => $request->dia_chi,
            'tinh_trang'    => $request->tinh_trang,
            'id_lop_hoc'    => $request->id_lop_hoc,
            'id_phu_huynh'  => $request->id_phu_huynh,
        ]);
        return response()->json([
            'status' => true,
            'message' => "Học sinh " . $request->ho_va_ten . " đã được cập nhật thành công",
        ]);
    }

    public function destroy(DeleteHocSinhRequest $request)
    {
        HocSinh::where('id', $request->id)->delete();
        return response()->json([
            'status' => true,
            'message' => "Học sinh đã được xóa thành công",
        ]);
    }

    public function changeStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:hoc_sinhs,id',
            'tinh_trang' => 'required|integer|in:0,1,2',
        ]);

        HocSinh::find($request->id)->update([
            'tinh_trang' => $request->tinh_trang,
        ]);
        return response()->json([
            'status' => true,
            'message' => "Học sinh đã được cập nhật trạng thái thành công",
        ]);
    }
}
