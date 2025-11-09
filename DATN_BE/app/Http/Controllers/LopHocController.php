<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLopHocRequest;
use App\Http\Requests\DeleteLopHocRequest;
use App\Http\Requests\UpdateLopHocRequest;
use App\Models\HocSinh;
use App\Models\LopHoc;
use App\Models\KhoiLop;
use App\Models\NamHoc;
use App\Models\GiaoVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LopHocController extends Controller
{


    public function getMyClasses()
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Giáo viên không tồn tại trong hệ thống!',
            ]);
        }

        $classes = LopHoc::join('khoi_lops', 'lop_hocs.id_khoi_lop', 'khoi_lops.id')
            ->join('nam_hocs', 'lop_hocs.id_nam_hoc', 'nam_hocs.id')
            ->where('lop_hocs.id_giao_vien', $user->id)
            ->select(
                'lop_hocs.id',
                'lop_hocs.ten_lop',
                'khoi_lops.ten_khoi_lop',
                'nam_hocs.ten_nam_hoc',
                'lop_hocs.so_luong'
            )
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Lấy danh sách lớp thành công',
            'data' => $classes,
        ]);
    }

    public function getDataClass()
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Giáo viên không tồn tại trong hệ thống!',
            ]);
        }
        $lopHoc = LopHoc::where('id_giao_vien', $user->id)->first();

        if (!$lopHoc) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn chưa được phân công lớp học nào!',
            ], 404);
        }
        $data = LopHoc::join('khoi_lops', 'lop_hocs.id_khoi_lop',  'khoi_lops.id')
            ->join('nam_hocs', 'lop_hocs.id_nam_hoc', 'nam_hocs.id')
            ->join('giao_viens', 'lop_hocs.id_giao_vien', 'giao_viens.id')
            ->join('hoc_sinhs', 'lop_hocs.id', 'hoc_sinhs.id_lop_hoc')
            ->leftJoin('phu_huynhs', 'hoc_sinhs.id_phu_huynh', 'phu_huynhs.id')
            ->where('lop_hocs.id_giao_vien', $user->id)
            ->select(
                'lop_hocs.id as id_lop_hoc',
                'lop_hocs.ten_lop',
                'khoi_lops.ten_khoi_lop',
                'nam_hocs.ten_nam_hoc',
                'giao_viens.ho_va_ten',
                'hoc_sinhs.id as id_hoc_sinh',
                'hoc_sinhs.ho_va_ten',
                'hoc_sinhs.gioi_tinh',
                'hoc_sinhs.avatar',
                'hoc_sinhs.ngay_sinh',
                'hoc_sinhs.dia_chi',
                'hoc_sinhs.tinh_trang',
                'hoc_sinhs.is_block',
                'phu_huynhs.id as id_phu_huynh',
                'phu_huynhs.ho_va_ten as ten_phu_huynh',
                'phu_huynhs.so_dien_thoai',
                'phu_huynhs.quan_he',
                'phu_huynhs.email',
                'phu_huynhs.gioi_tinh as gioi_tinh_phu_huynh',
                'phu_huynhs.ngay_sinh as ngay_sinh_phu_huynh',

            )
            ->orderBy('hoc_sinhs.ho_va_ten', 'asc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Load dữ liệu lớp học thành công',
            'data' => $data,
        ]);
    }


    public function updateHocSinh(Request $request)
    {
        $data = HocSinh::where('id', $request->id_hoc_sinh)->first();
        $data->update([
            'ho_va_ten' => $request->ho_va_ten,
            'gioi_tinh' => $request->gioi_tinh,
            'ngay_sinh' => $request->ngay_sinh,
            'dia_chi' => $request->dia_chi,
            'tinh_trang' => $request->tinh_trang,

        ]);
        return response()->json([
            'status' => true,
            'message' => 'Học sinh đã được cập nhật thành công',
        ]);
    }

    public function destroyHocSinh(Request $request)
    {
        $data = HocSinh::where('id', $request->id)->delete();
        return response()->json([
            'status' => true,
            'message' => 'Học sinh đã được xóa thành công',
        ]);
    }

    public function searchHocSinh(Request $request) {}

    public function changeStatusHocSinh(Request $request)
    {
        $data = HocSinh::where('id', $request->id_hoc_sinh)->first();
        $new_tinh_trang = !$data->tinh_trang;
        $data->tinh_trang = $new_tinh_trang;
        $data->save();
        return response()->json([
            'status' => true,
            'message' => 'Học sinh đã được cập nhật thành công',
        ]);
    }

    // Admin functions
    public function getData()
    {
        $id_chuc_nang = 5;
        $data = LopHoc::join('khoi_lops', 'lop_hocs.id_khoi_lop', 'khoi_lops.id')
            ->join('nam_hocs', 'lop_hocs.id_nam_hoc', 'nam_hocs.id')
            ->join('giao_viens', 'lop_hocs.id_giao_vien', 'giao_viens.id')
            ->leftJoin('hoc_sinhs', 'lop_hocs.id', 'hoc_sinhs.id_lop_hoc')
            ->select(
                'lop_hocs.id',
                'lop_hocs.ten_lop',
                'lop_hocs.id_khoi_lop',
                'lop_hocs.id_nam_hoc',
                'lop_hocs.id_giao_vien',
                'lop_hocs.so_luong',
                'lop_hocs.is_block',
                'khoi_lops.ten_khoi_lop',
                'nam_hocs.ten_nam_hoc',
                'giao_viens.ho_va_ten as ten_giao_vien',
                DB::raw('COUNT(hoc_sinhs.id) as tong_hoc_sinh')
            )
            ->groupBy(
                'lop_hocs.id',
                'lop_hocs.ten_lop',
                'lop_hocs.id_khoi_lop',
                'lop_hocs.id_nam_hoc',
                'lop_hocs.id_giao_vien',
                'lop_hocs.so_luong',
                'lop_hocs.is_block',
                'khoi_lops.ten_khoi_lop',
                'nam_hocs.ten_nam_hoc',
                'giao_viens.ho_va_ten'
            )
            ->get();
        return response()->json([
            'status' => true,
            'message' => 'Load dữ liệu lớp học thành công',
            'id_chuc_nang' => $id_chuc_nang,
            'data' => $data,
        ]);
    }

    public function search(Request $request)
    {
        $conditions = [
            'noi_dung'   => ['field' => 'lop_hocs.ten_lop', 'operator' => 'like'],
            'id_khoi_lop' => ['field' => 'lop_hocs.id_khoi_lop', 'operator' => '='],
            'id_nam_hoc' => ['field' => 'lop_hocs.id_nam_hoc', 'operator' => '='],
            'id_giao_vien' => ['field' => 'lop_hocs.id_giao_vien', 'operator' => '='],
        ];

        $query = LopHoc::join('khoi_lops', 'lop_hocs.id_khoi_lop', 'khoi_lops.id')
            ->join('nam_hocs', 'lop_hocs.id_nam_hoc', 'nam_hocs.id')
            ->join('giao_viens', 'lop_hocs.id_giao_vien', 'giao_viens.id');

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
            ->leftJoin('hoc_sinhs', 'lop_hocs.id', 'hoc_sinhs.id_lop_hoc')
            ->select(
                'lop_hocs.id',
                'lop_hocs.ten_lop',
                'lop_hocs.id_khoi_lop',
                'lop_hocs.id_nam_hoc',
                'lop_hocs.id_giao_vien',
                'lop_hocs.so_luong',
                'lop_hocs.is_block',
                'khoi_lops.ten_khoi_lop',
                'nam_hocs.ten_nam_hoc',
                'giao_viens.ho_va_ten as ten_giao_vien',
                DB::raw('COUNT(hoc_sinhs.id) as tong_hoc_sinh')
            )
            ->groupBy(
                'lop_hocs.id',
                'lop_hocs.ten_lop',
                'lop_hocs.id_khoi_lop',
                'lop_hocs.id_nam_hoc',
                'lop_hocs.id_giao_vien',
                'lop_hocs.so_luong',
                'lop_hocs.is_block',
                'khoi_lops.ten_khoi_lop',
                'nam_hocs.ten_nam_hoc',
                'giao_viens.ho_va_ten'
            )
            ->get();
        return response()->json([
            'status' => true,
            'message' => 'Load dữ liệu lớp học thành công',
            'data' => $data,
        ]);
    }

    public function store(CreateLopHocRequest $request)
    {
        LopHoc::create([
            'ten_lop'       => $request->ten_lop,
            'id_khoi_lop'   => $request->id_khoi_lop,
            'id_nam_hoc'    => $request->id_nam_hoc,
            'id_giao_vien'  => $request->id_giao_vien,
            'so_luong'      => $request->so_luong,
            'is_block'      => 0,
        ]);

        return response()->json([
            'status' => true,
            'message' => "Lớp học " . $request->ten_lop . " đã được thêm mới thành công",
        ]);
    }

    public function update(UpdateLopHocRequest $request)
    {
        LopHoc::where('id', $request->id)->update([
            'ten_lop'       => $request->ten_lop,
            'id_khoi_lop'   => $request->id_khoi_lop,
            'id_nam_hoc'    => $request->id_nam_hoc,
            'id_giao_vien'  => $request->id_giao_vien,
            'so_luong'      => $request->so_luong,
        ]);
        return response()->json([
            'status' => true,
            'message' => "Lớp học " . $request->ten_lop . " đã được cập nhật thành công",
        ]);
    }

    public function destroy(DeleteLopHocRequest $request)
    {
        LopHoc::where('id', $request->id)->delete();
        return response()->json([
            'status' => true,
            'message' => "Lớp học đã được xóa thành công",
        ]);
    }

    public function changeStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:lop_hocs,id',
            'is_block' => 'required|integer|in:0,1',
        ]);

        $new_is_block = !$request->is_block;
        LopHoc::find($request->id)->update([
            'is_block' => $new_is_block,
        ]);
        return response()->json([
            'status' => true,
            'message' => "Lớp học đã được cập nhật trạng thái thành công",
        ]);
    }
}
