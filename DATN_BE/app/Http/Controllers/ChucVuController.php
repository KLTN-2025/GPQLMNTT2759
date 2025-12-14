<?php

namespace App\Http\Controllers;

use App\Models\ChucVu;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Admin - Chức vụ",
 *     description="API quản lý chức vụ"
 * )
 */
class ChucVuController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/admin/chuc-vu/data",
     *     summary="Lấy danh sách chức vụ",
     *     tags={"Admin - Chức vụ"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lấy danh sách chức vụ thành công (status = true)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Lấy dữ liệu chức vụ thành công"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="ten_chuc_vu", type="string", example="Quản lý"),
     *                     @OA\Property(property="slug_chuc_vu", type="string", example="quan-ly"),
     *                     @OA\Property(property="tinh_trang", type="integer", example=1),
     *                     @OA\Property(property="mo_ta", type="string", nullable=true, example="Người đứng đầu trường học"),
     *                     @OA\Property(property="loai_chuc_vu", type="string", nullable=true, example="Quản lý")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function getData()
    {
        $data = ChucVu::all();
        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu chức vụ thành công',
            'data' => $data,
        ]);
    }
    /**
     * @OA\Post(
     *     path="/api/admin/chuc-vu/create",
     *     summary="Thêm mới chức vụ",
     *     tags={"Admin - Chức vụ"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Thông tin chức vụ",
     *         @OA\JsonContent(
     *             required={"ten_chuc_vu","slug_chuc_vu","tinh_trang"},
     *             @OA\Property(property="ten_chuc_vu", type="string", example="Quản lý"),
     *             @OA\Property(property="slug_chuc_vu", type="string", example="quan-ly"),
     *             @OA\Property(property="tinh_trang", type="integer", example=1, description="0: Không hoạt động, 1: Hoạt động"),
     *             @OA\Property(property="mo_ta", type="string", nullable=true, example="Người đứng đầu trường học"),
     *             @OA\Property(property="loai_chuc_vu", type="string", nullable=true, example="Quản lý")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Thêm chức vụ thành công (status = true)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Thêm chức vụ Quản lý thành công")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        ChucVu::create([
            'ten_chuc_vu' => $request->ten_chuc_vu,
            'slug_chuc_vu' => $request->slug_chuc_vu,
            'tinh_trang' => $request->tinh_trang,
            'mo_ta' => $request->mo_ta,
            'loai_chuc_vu' => $request->loai_chuc_vu,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Thêm chức vụ ' . $request->ten_chuc_vu . ' thành công',
        ]);
    }
    /**
     * @OA\Post(
     *     path="/api/admin/chuc-vu/update",
     *     summary="Cập nhật chức vụ",
     *     tags={"Admin - Chức vụ"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Thông tin chức vụ cần cập nhật",
     *         @OA\JsonContent(
     *             required={"id","ten_chuc_vu","slug_chuc_vu","tinh_trang"},
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="ten_chuc_vu", type="string", example="Quản lý"),
     *             @OA\Property(property="slug_chuc_vu", type="string", example="quan-ly"),
     *             @OA\Property(property="tinh_trang", type="integer", example=1),
     *             @OA\Property(property="mo_ta", type="string", nullable=true, example="Người đứng đầu trường học"),
     *             @OA\Property(property="loai_chuc_vu", type="string", nullable=true, example="Quản lý")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cập nhật chức vụ thành công (status = true)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Cập nhật chức vụ Quản lý thành công")
     *         )
     *     )
     * )
     */
    public function update(Request $request)
    {
        ChucVu::where('id', $request->id)->update([
            'ten_chuc_vu' => $request->ten_chuc_vu,
            'slug_chuc_vu' => $request->slug_chuc_vu,
            'tinh_trang' => $request->tinh_trang,
            'mo_ta' => $request->mo_ta,
            'loai_chuc_vu' => $request->loai_chuc_vu,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Cập nhật chức vụ ' . $request->ten_chuc_vu . ' thành công',
        ]);
    }
    /**
     * @OA\Post(
     *     path="/api/admin/chuc-vu/delete",
     *     summary="Xóa chức vụ",
     *     tags={"Admin - Chức vụ"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="ID chức vụ cần xóa",
     *         @OA\JsonContent(
     *             required={"id"},
     *             @OA\Property(property="id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Xóa chức vụ thành công (status = true)",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Xóa chức vụ thành công")
     *         )
     *     )
     * )
     */
    public function destroy(Request $request)
    {
        ChucVu::where('id', $request->id)->delete();
        return response()->json([
            'status' => true,
            'message' => 'Xóa chức vụ thành công',
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/admin/chuc-vu/change-status",
     *     summary="Thay đổi trạng thái chức vụ",
     *     tags={"Admin - Chức vụ"},
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
     *             @OA\Property(property="message", type="string", example="Chức vụ đã được khóa thành công")
     *         )
     *     )
     * )
     */
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
