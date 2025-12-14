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

/**
 * @OA\Tag(
 *     name="Admin - Học sinh",
 *     description="API quản lý học sinh"
 * )
 */
class HocSinhController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/admin/hoc-sinh/data",
     *     summary="Lấy danh sách học sinh",
     *     tags={"Admin - Học sinh"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lấy danh sách học sinh thành công (status = true)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Load dữ liệu học sinh thành công"),
     *             @OA\Property(property="id_chuc_nang", type="integer", example=4),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="ho_va_ten", type="string", example="Nguyễn Văn C"),
     *                     @OA\Property(property="gioi_tinh", type="integer", example=1),
     *                     @OA\Property(property="avatar", type="string", nullable=true, example="avatar.jpg"),
     *                     @OA\Property(property="ngay_sinh", type="string", format="date", example="2018-01-01"),
     *                     @OA\Property(property="dia_chi", type="string", example="123 Đường ABC"),
     *                     @OA\Property(property="tinh_trang", type="integer", example=1),
     *                     @OA\Property(property="id_lop_hoc", type="integer", example=1),
     *                     @OA\Property(property="id_phu_huynh", type="integer", example=1),
     *                     @OA\Property(property="is_block", type="integer", example=0),
     *                     @OA\Property(property="ten_lop", type="string", example="Lớp Mầm 1"),
     *                     @OA\Property(property="ten_phu_huynh", type="string", example="Nguyễn Văn D"),
     *                     @OA\Property(property="sdt_phu_huynh", type="string", example="0901234567")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function getData()
    {
        $id_chuc_nang = 4;
        $data = HocSinh::leftJoin('lop_hocs', 'hoc_sinhs.id_lop_hoc', 'lop_hocs.id')
            ->leftJoin('phu_huynhs', 'hoc_sinhs.id_phu_huynh', 'phu_huynhs.id')
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
                'phu_huynhs.so_dien_thoai as sdt_phu_huynh',
                'phu_huynhs.quan_he as quan_he_phu_huynh',
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

        $query = HocSinh::join('lop_hocs', 'hoc_sinhs.id_lop_hoc', 'lop_hocs.id')
            ->join('phu_huynhs', 'hoc_sinhs.id_phu_huynh', 'phu_huynhs.id');


        // Tìm kiếm theo tên học sinh
        if ($request->filled('noi_dung')) {
            $query->where('hoc_sinhs.ho_va_ten', 'like', '%' . $request->noi_dung . '%');
        }

        // Lọc theo trạng thái
        if ($request->filled('tinh_trang')) {
            $query->where('hoc_sinhs.tinh_trang', $request->tinh_trang);
        }

        // Lọc theo id lớp học (ưu tiên id_lop_hoc, nếu không có thì dùng lop_hoc)
        if ($request->filled('id_lop_hoc')) {
            $query->where('hoc_sinhs.id_lop_hoc', $request->id_lop_hoc);
        } elseif ($request->filled('lop_hoc')) {
            // Nếu lop_hoc là số thì coi như ID, nếu là chuỗi thì coi như tên lớp
            if (is_numeric($request->lop_hoc)) {
                $query->where('hoc_sinhs.id_lop_hoc', $request->lop_hoc);
            } else {
                $query->where('lop_hocs.ten_lop', $request->lop_hoc);
            }
        }

        // Lọc theo giới tính (nếu có)
        if ($request->filled('gioi_tinh')) {
            $query->where('hoc_sinhs.gioi_tinh', $request->gioi_tinh);
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

    /**
     * @OA\Post(
     *     path="/api/admin/hoc-sinh/change-status",
     *     summary="Thay đổi trạng thái học sinh",
     *     tags={"Admin - Học sinh"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Thông tin thay đổi trạng thái",
     *         @OA\JsonContent(
     *             required={"id","tinh_trang"},
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="tinh_trang", type="integer", example=1, description="0: Không hoạt động, 1: Hoạt động")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật trạng thái thành công (status = true)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Học sinh đã được cập nhật trạng thái thành công")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Dữ liệu không hợp lệ (status = false)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Dữ liệu không hợp lệ")
     *         )
     *     )
     * )
     */
    public function changeStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:hoc_sinhs,id',
            'tinh_trang' => 'required|integer|in:0,1',
        ]);

        $new_tinh_trang = !$request->tinh_trang;
        HocSinh::find($request->id)->update([
            'tinh_trang' => $new_tinh_trang,
        ]);

        $status_text = $new_tinh_trang ? 'kích hoạt' : 'vô hiệu hóa';

        return response()->json([
            'status' => true,
            'message' => "Học sinh đã được {$status_text} thành công",
        ]);
    }
}
