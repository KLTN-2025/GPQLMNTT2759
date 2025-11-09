<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateBaiVietRequest;
use App\Http\Requests\DeleteBaiVietRequest;
use App\Http\Requests\UpdateBaiVietRequest;
use App\Models\BaiViet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BaiVietController extends Controller
{
    /**
     * Lấy danh sách tất cả bài viết
     */
    public function getData()
    {
        $data = BaiViet::join('nhan_viens', 'bai_viets.id_nhan_vien', '=', 'nhan_viens.id')
            ->join('loai_bai_viets', 'bai_viets.id_loai_bai_viet', '=', 'loai_bai_viets.id')
            ->select(
                'bai_viets.id',
                'bai_viets.tieu_de',
                'bai_viets.slug_tieu_de',
                'bai_viets.noi_dung',
                'bai_viets.hinh_anh',
                'bai_viets.ngay_dang',
                'bai_viets.luot_xem',
                'bai_viets.tinh_trang',
                'bai_viets.id_loai_bai_viet',
                'nhan_viens.ho_va_ten as nguoi_dang',
                'nhan_viens.avatar as avatar_nguoi_dang',
                'loai_bai_viets.ten_loai as ten_loai_bai_viet'
            )
            ->orderBy('bai_viets.ngay_dang', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Load dữ liệu bài viết thành công',
            'data' => $data,
        ]);
    }

    /**
     * Tạo bài viết mới
     */
    public function store(CreateBaiVietRequest $request)
    {
        $user = Auth::guard('admin')->user() ?: Auth::guard('sanctum')->user();

        if (!$user || !($user instanceof \App\Models\NhanVien)) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn không có quyền tạo bài viết',
            ], 403);
        }

        try {
            // Tạo slug từ tiêu đề
            $slug = Str::slug($request->tieu_de);

            // Kiểm tra slug trùng lặp và thêm số nếu cần
            $originalSlug = $slug;
            $counter = 1;
            while (BaiViet::where('slug_tieu_de', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            // Tạo bài viết
            $baiViet = BaiViet::create([
                'tieu_de' => $request->tieu_de,
                'slug_tieu_de' => $slug,
                'noi_dung' => $request->noi_dung,
                'hinh_anh' => $request->hinh_anh,
                'ngay_dang' => $request->ngay_dang ?? now(),
                'luot_xem' => 0,
                'tinh_trang' => $request->tinh_trang ?? true,
                'id_nhan_vien' => $user->id,
                'id_loai_bai_viet' => $request->id_loai_bai_viet,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Tạo bài viết thành công',
                'data' => $baiViet,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Có lỗi xảy ra khi tạo bài viết: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Cập nhật bài viết
     */
    public function update(UpdateBaiVietRequest $request)
    {
        $user = Auth::guard('admin')->user() ?: Auth::guard('sanctum')->user();

        if (!$user || !($user instanceof \App\Models\NhanVien)) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn không có quyền cập nhật bài viết',
            ], 403);
        }

        try {
            $baiViet = BaiViet::find($request->id);

            if (!$baiViet) {
                return response()->json([
                    'status' => false,
                    'message' => 'Bài viết không tồn tại',
                ], 404);
            }

            // Tạo slug mới từ tiêu đề nếu tiêu đề thay đổi
            $slug = $baiViet->slug_tieu_de;
            if ($baiViet->tieu_de !== $request->tieu_de) {
                $slug = Str::slug($request->tieu_de);

                // Kiểm tra slug trùng lặp và thêm số nếu cần
                $originalSlug = $slug;
                $counter = 1;
                while (BaiViet::where('slug_tieu_de', $slug)->where('id', '!=', $request->id)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
            }

            // Cập nhật bài viết
            $baiViet->update([
                'tieu_de' => $request->tieu_de,
                'slug_tieu_de' => $slug,
                'noi_dung' => $request->noi_dung,
                'hinh_anh' => $request->hinh_anh,
                'ngay_dang' => $request->ngay_dang ?? $baiViet->ngay_dang,
                'tinh_trang' => $request->tinh_trang ?? $baiViet->tinh_trang,
                'id_loai_bai_viet' => $request->id_loai_bai_viet,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Cập nhật bài viết thành công',
                'data' => $baiViet,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật bài viết: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Xóa bài viết
     */
    public function destroy(DeleteBaiVietRequest $request)
    {
        try {
            $baiViet = BaiViet::find($request->id);

            if (!$baiViet) {
                return response()->json([
                    'status' => false,
                    'message' => 'Bài viết không tồn tại',
                ], 404);
            }

            $baiViet->delete();

            return response()->json([
                'status' => true,
                'message' => 'Xóa bài viết thành công',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Có lỗi xảy ra khi xóa bài viết: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Tìm kiếm bài viết
     */
    public function search(Request $request)
    {
        $query = BaiViet::join('nhan_viens', 'bai_viets.id_nhan_vien', '=', 'nhan_viens.id')
            ->join('loai_bai_viets', 'bai_viets.id_loai_bai_viet', '=', 'loai_bai_viets.id')
            ->select(
                'bai_viets.id',
                'bai_viets.tieu_de',
                'bai_viets.slug_tieu_de',
                'bai_viets.noi_dung',
                'bai_viets.hinh_anh',
                'bai_viets.ngay_dang',
                'bai_viets.luot_xem',
                'bai_viets.tinh_trang',
                'bai_viets.id_loai_bai_viet',
                'nhan_viens.ho_va_ten as nguoi_dang',
                'nhan_viens.avatar as avatar_nguoi_dang',
                'loai_bai_viets.ten_loai as ten_loai_bai_viet'
            );

        // Tìm kiếm theo tiêu đề hoặc nội dung
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('bai_viets.tieu_de', 'like', '%' . $keyword . '%')
                    ->orWhere('bai_viets.noi_dung', 'like', '%' . $keyword . '%');
            });
        }

        // Tìm kiếm theo trạng thái
        if ($request->filled('tinh_trang')) {
            $query->where('bai_viets.tinh_trang', $request->tinh_trang);
        }

        // Tìm kiếm theo loại bài viết
        if ($request->filled('id_loai_bai_viet')) {
            $query->where('bai_viets.id_loai_bai_viet', $request->id_loai_bai_viet);
        }

        // Tìm kiếm theo người đăng
        if ($request->filled('id_nhan_vien')) {
            $query->where('bai_viets.id_nhan_vien', $request->id_nhan_vien);
        }

        // Tìm kiếm theo khoảng thời gian
        if ($request->filled('tu_ngay')) {
            $query->where('bai_viets.ngay_dang', '>=', $request->tu_ngay);
        }

        if ($request->filled('den_ngay')) {
            $query->where('bai_viets.ngay_dang', '<=', $request->den_ngay);
        }

        $data = $query->orderBy('bai_viets.ngay_dang', 'desc')->get();

        return response()->json([
            'status' => true,
            'message' => 'Tìm kiếm bài viết thành công',
            'data' => $data,
        ]);
    }

    /**
     * Thống kê bài viết
     */
    public function statistical()
    {
        $total = BaiViet::count();
        $totalActive = BaiViet::where('tinh_trang', true)->count();
        $totalInactive = BaiViet::where('tinh_trang', false)->count();

        // Thống kê theo tháng
        $byMonth = BaiViet::selectRaw('DATE_FORMAT(ngay_dang, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Thống kê theo trạng thái
        $byStatus = BaiViet::select('tinh_trang')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('tinh_trang')
            ->get();

        // Thống kê theo loại bài viết
        $byType = BaiViet::join('loai_bai_viets', 'bai_viets.id_loai_bai_viet', '=', 'loai_bai_viets.id')
            ->select('loai_bai_viets.ten_loai', DB::raw('COUNT(*) as count'))
            ->groupBy('loai_bai_viets.id', 'loai_bai_viets.ten_loai')
            ->get();

        // Tổng lượt xem
        $totalViews = BaiViet::sum('luot_xem');

        // Bài viết có lượt xem cao nhất
        $topViewed = BaiViet::select('id', 'tieu_de', 'luot_xem')
            ->orderBy('luot_xem', 'desc')
            ->limit(5)
            ->get();

        // Thống kê theo người đăng
        $byAuthor = BaiViet::join('nhan_viens', 'bai_viets.id_nhan_vien', '=', 'nhan_viens.id')
            ->select('nhan_viens.ho_va_ten', DB::raw('COUNT(*) as count'))
            ->groupBy('nhan_viens.id', 'nhan_viens.ho_va_ten')
            ->orderBy('count', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Thống kê bài viết',
            'data' => [
                'total_records' => $total,
                'total_active' => $totalActive,
                'total_inactive' => $totalInactive,
                'total_views' => $totalViews,
                'by_month' => $byMonth,
                'by_status' => $byStatus,
                'by_type' => $byType,
                'by_author' => $byAuthor,
                'top_viewed' => $topViewed,
            ],
        ]);
    }

    /**
     * Thay đổi trạng thái bài viết
     */
    public function changeStatus(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'id' => 'required|exists:bai_viets,id',
            'tinh_trang' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            BaiViet::where('id', $request->id)->update([
                'tinh_trang' => $request->tinh_trang,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Thay đổi trạng thái thành công',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Có lỗi xảy ra khi thay đổi trạng thái: ' . $e->getMessage(),
            ], 500);
        }
    }
}
