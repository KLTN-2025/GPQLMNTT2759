<?php

namespace App\Http\Controllers;

use App\Models\SucKhoe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SucKhoeController extends Controller
{
    /**
     * Lấy danh sách tất cả hồ sơ sức khỏe
     */
    public function getSucKhoe()
    {
        $data = SucKhoe::all();

        return response()->json([
            'status' => true,
            'message' => 'Danh sách hồ sơ sức khỏe học sinh',
            'data' => $data
        ]);
    }

    /**
     * Thêm mới hồ sơ sức khỏe
     */
    public function createSucKhoe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_hoc_sinh' => 'required|integer',
            'ngay_kham' => 'required|date',
            'tinh_trang' => 'required|string|max:255',
            'chieu_cao' => 'nullable|numeric|min:0',
            'can_nang' => 'nullable|numeric|min:0',
            'ghi_chu' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors()
            ], 422);
        }

        $sucKhoe = SucKhoe::create($validator->validated());

        return response()->json([
            'status' => true,
            'message' => 'Thêm hồ sơ sức khỏe thành công',
            'data' => $sucKhoe
        ]);
    }

    /**
     * Cập nhật hồ sơ sức khỏe
     */
    public function updateSucKhoe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:suc_khoes,id',
            'id_hoc_sinh' => 'integer',
            'ngay_kham' => 'date',
            'tinh_trang' => 'string|max:255',
            'chieu_cao' => 'nullable|numeric|min:0',
            'can_nang' => 'nullable|numeric|min:0',
            'ghi_chu' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors()
            ], 422);
        }

        $sucKhoe = SucKhoe::find($request->id);
        $sucKhoe->update($validator->validated());

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật hồ sơ sức khỏe thành công',
            'data' => $sucKhoe
        ]);
    }

    /**
     * Xóa hồ sơ sức khỏe
     */
    public function deleteSucKhoe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:suc_khoes,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Không tìm thấy hồ sơ cần xóa',
                'errors' => $validator->errors(),
            ], 422);
        }

        SucKhoe::destroy($request->id);

        return response()->json([
            'status' => true,
            'message' => 'Xóa hồ sơ sức khỏe thành công',
        ]);
    }

    /**
     * Tìm kiếm hồ sơ sức khỏe (theo tên tình trạng hoặc ghi chú hoặc ID học sinh)
     */
    public function searchSucKhoe(Request $request)
    {
        $keyword = $request->keyword ?? '';

        $data = SucKhoe::query()
            ->where('tinh_trang', 'like', "%$keyword%")
            ->orWhere('ghi_chu', 'like', "%$keyword%")
            ->orWhere('id_hoc_sinh', $keyword)
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Kết quả tìm kiếm hồ sơ sức khỏe',
            'data' => $data
        ]);
    }

    /**
     * Cập nhật nhanh một trường (ví dụ: tình_trạng, cân_nặng, chiều_cao, ghi_chú)
     */
    public function changesSucKhoe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:suc_khoes,id',
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

        $sucKhoe = SucKhoe::find($request->id);
        $field = $request->field;

        if (!in_array($field, ['id_hoc_sinh', 'ngay_kham', 'tinh_trang', 'chieu_cao', 'can_nang', 'ghi_chu'])) {
            return response()->json([
                'status' => false,
                'message' => 'Trường không hợp lệ để cập nhật',
            ], 400);
        }

        $sucKhoe->$field = $request->value;
        $sucKhoe->save();

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật nhanh thành công',
            'data' => $sucKhoe
        ]);
    }

    // --- Alias methods to match routes structure (admin/...) ---
    public function getData()
    {
        $data = SucKhoe::join('hoc_sinhs', 'suc_khoes.id_hoc_sinh', 'hoc_sinhs.id')
            ->join('lop_hocs', 'hoc_sinhs.id_lop_hoc', 'lop_hocs.id')
            ->select(
                'lop_hocs.id as id_lop',
                'lop_hocs.ten_lop',
                'suc_khoes.id',
                'suc_khoes.id_hoc_sinh',
                'suc_khoes.ngay_kham',
                'suc_khoes.tinh_trang_suc_khoe',
                'suc_khoes.can_nang',
                'suc_khoes.chieu_cao',
                'suc_khoes.thi_luc',
                'suc_khoes.rang_mieng',
                'suc_khoes.loai_kham',
                'suc_khoes.ghi_chu',
                'hoc_sinhs.ho_va_ten',
                'hoc_sinhs.gioi_tinh',
                'hoc_sinhs.avatar',
                'hoc_sinhs.ngay_sinh',
                'hoc_sinhs.dia_chi',
                'hoc_sinhs.tinh_trang',
            )
            ->orderBy('lop_hocs.ten_lop', 'asc')
            ->orderBy('suc_khoes.ngay_kham', 'desc')
            ->get();
        return response()->json([
            'status' => true,
            'message' => 'Danh sách hồ sơ sức khỏe học sinh',
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        SucKhoe::create([
            'id_hoc_sinh' => $request->id_hoc_sinh,
            'ngay_kham'  => $request->ngay_kham,
            'chieu_cao' => $request->chieu_cao,
            'can_nang' => $request->can_nang,
            'thi_luc' => $request->thi_luc,
            'rang_mieng' => $request->rang_mieng,
            'tinh_trang_suc_khoe' => $request->tinh_trang_suc_khoe,
            'loai_kham' => $request->loai_kham,
            'ghi_chu' => $request->ghi_chu,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Thêm mới hồ sơ sức khỏe học sinh thành công',
        ]);
    }

    public function update(Request $request)
    {
        SucKhoe::where('id', $request->id)->update([
            'id_hoc_sinh' => $request->id_hoc_sinh,
            'ngay_kham'  => $request->ngay_kham,
            'chieu_cao' => $request->chieu_cao,
            'can_nang' => $request->can_nang,
            'thi_luc' => $request->thi_luc,
            'rang_mieng' => $request->rang_mieng,
            'tinh_trang_suc_khoe' => $request->tinh_trang_suc_khoe,
            'loai_kham' => $request->loai_kham,
            'ghi_chu' => $request->ghi_chu,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật hồ sơ sức khỏe học sinh thành công',
        ]);
    }

    public function destroy(Request $request)
    {
        SucKhoe::where('id', $request->id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Xoá hồ sơ sức khỏe học sinh thành công',
        ]);
    }

    public function search(Request $request)
    {
        $query = SucKhoe::join('hoc_sinhs', 'suc_khoes.id_hoc_sinh', '=', 'hoc_sinhs.id')
            ->join('lop_hocs', 'hoc_sinhs.id_lop_hoc', '=', 'lop_hocs.id')
            ->select(
                'lop_hocs.id as id_lop',
                'lop_hocs.ten_lop',
                'suc_khoes.id',
                'suc_khoes.id_hoc_sinh',
                'suc_khoes.ngay_kham',
                'suc_khoes.tinh_trang_suc_khoe',
                'suc_khoes.can_nang',
                'suc_khoes.chieu_cao',
                'suc_khoes.thi_luc',
                'suc_khoes.rang_mieng',
                'suc_khoes.loai_kham',
                'suc_khoes.ghi_chu',
                'hoc_sinhs.ho_va_ten',
                'hoc_sinhs.gioi_tinh',
                'hoc_sinhs.avatar',
                'hoc_sinhs.ngay_sinh',
                'hoc_sinhs.dia_chi',
                'hoc_sinhs.tinh_trang'
            );

        if ($request->filled('noi_dung')) {
            $query->where('hoc_sinhs.ho_va_ten', 'like', "%{$request->noi_dung}%");
        }

        if ($request->filled('tinh_trang_suc_khoe')) {
            $query->where('suc_khoes.tinh_trang_suc_khoe', $request->tinh_trang_suc_khoe);
        }

        if ($request->filled('id_lop')) {
            $query->where('lop_hocs.id', $request->id_lop);
        }

        $data = $query->get();

        return response()->json([
            'status' => true,
            'message' => 'Tìm kiếm hồ sơ sức khỏe thành công',
            'data' => $data
        ]);
    }

    public function statistical()
    {
        $total = SucKhoe::count();
        $byStatus = SucKhoe::select('tinh_trang')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('tinh_trang')
            ->get();
        $byMonth = SucKhoe::selectRaw('DATE_FORMAT(ngay_kham, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Thống kê hồ sơ sức khỏe',
            'data' => [
                'total_records' => $total,
                'by_status' => $byStatus,
                'by_month' => $byMonth,
            ],
        ]);
    }

    /**
     * Lấy thông tin sức khỏe theo lớp học của giáo viên đăng nhập
     */
    public function getDataByLop(Request $request)
    {
        // Lấy giáo viên đăng nhập
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Giáo viên không tồn tại trong hệ thống!',
            ], 401);
        }

        // Tìm lớp học của giáo viên
        $lopHoc = \App\Models\LopHoc::where('id_giao_vien', $user->id)->first();

        if (!$lopHoc) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn chưa được phân công lớp học nào!',
            ], 404);
        }

        // Lấy thông tin sức khỏe của học sinh trong lớp
        $data = SucKhoe::join('hoc_sinhs', 'suc_khoes.id_hoc_sinh', 'hoc_sinhs.id')
            ->join('lop_hocs', 'hoc_sinhs.id_lop_hoc', 'lop_hocs.id')
            ->leftJoin('khoi_lops', 'lop_hocs.id_khoi_lop', 'khoi_lops.id')
            ->leftJoin('giao_viens', 'lop_hocs.id_giao_vien', 'giao_viens.id')
            ->where('lop_hocs.id', $lopHoc->id)
            ->select(
                'lop_hocs.id as id_lop_hoc',
                'lop_hocs.ten_lop',
                'khoi_lops.ten_khoi_lop',
                'giao_viens.ho_va_ten as ten_giao_vien',
                'suc_khoes.id',
                'suc_khoes.id_hoc_sinh',
                'suc_khoes.ngay_kham',
                'suc_khoes.tinh_trang_suc_khoe',
                'suc_khoes.can_nang',
                'suc_khoes.chieu_cao',
                'suc_khoes.thi_luc',
                'suc_khoes.rang_mieng',
                'suc_khoes.loai_kham',
                'suc_khoes.ghi_chu',
                'hoc_sinhs.ho_va_ten',
                'hoc_sinhs.gioi_tinh',
                'hoc_sinhs.avatar',
                'hoc_sinhs.ngay_sinh',
                'hoc_sinhs.dia_chi',
                'hoc_sinhs.tinh_trang',
            )
            ->orderBy('hoc_sinhs.ho_va_ten', 'asc')
            ->orderBy('suc_khoes.ngay_kham', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Danh sách thông tin sức khỏe theo lớp học',
            'data' => $data
        ]);
    }
}
