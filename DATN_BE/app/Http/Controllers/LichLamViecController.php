<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLichLamViecRequest;
use App\Models\LichLamViec;
use App\Models\NhanVien;
use App\Models\GiaoVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LichLamViecController extends Controller
{
    /**
     * Lấy danh sách lịch làm việc nhân viên
     */
    public function getDataLichLamViecNhanVien(Request $request)
    {
        // Kiểm tra quyền: Quản lý lịch làm việc (ID = 14 - giả định, cần cập nhật theo hệ thống thực tế)
        // $id_chuc_nang = 14; // Cần cập nhật ID chức năng quản lý lịch làm việc
        // $id_chuc_vu = Auth::guard('sanctum')->user()->id_chuc_vu;
        // $check = \App\Models\PhanQuyen::where('id_chuc_vu', $id_chuc_vu)
        //     ->where('id_chuc_nang', $id_chuc_nang)
        //     ->first();

        // if (!$check) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Bạn không có quyền thực hiện chức năng này!'
        //     ], 403);
        // }

        $data = LichLamViec::join('nhan_viens', 'lich_lam_viecs.id_nhan_vien', '=', 'nhan_viens.id')
            ->select(
                'lich_lam_viecs.id',
                'nhan_viens.ho_va_ten',
                'nhan_viens.id_chuc_vu',
                'lich_lam_viecs.ngay_lam_viec',
                'lich_lam_viecs.ca_lam_viec'
            )
            ->whereNotNull('lich_lam_viecs.id_nhan_vien')
            ->orderBy('lich_lam_viecs.ngay_lam_viec')
            ->orderBy('lich_lam_viecs.ca_lam_viec')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }

    /**
     * Tìm kiếm/lọc lịch làm việc nhân viên
     */
    public function searchLichLamViecNhanVien(Request $request)
    {
        $query = LichLamViec::join('nhan_viens', 'lich_lam_viecs.id_nhan_vien', '=', 'nhan_viens.id')
            ->select(
                'lich_lam_viecs.id',
                'nhan_viens.ho_va_ten',
                'nhan_viens.id_chuc_vu',
                'lich_lam_viecs.ngay_lam_viec',
                'lich_lam_viecs.ca_lam_viec'
            )
            ->whereNotNull('lich_lam_viecs.id_nhan_vien');

        // Lọc theo nhân viên
        if ($request->filled('id_nhan_vien')) {
            $query->where('lich_lam_viecs.id_nhan_vien', $request->id_nhan_vien);
        }

        // Lọc theo khoảng thời gian
        if ($request->filled('from_date')) {
            $query->whereDate('lich_lam_viecs.ngay_lam_viec', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('lich_lam_viecs.ngay_lam_viec', '<=', $request->to_date);
        }

        // Lọc theo ca làm việc
        if ($request->filled('ca_lam_viec')) {
            $query->where('lich_lam_viecs.ca_lam_viec', $request->ca_lam_viec);
        }

        $data = $query->orderBy('lich_lam_viecs.ngay_lam_viec')
            ->orderBy('lich_lam_viecs.ca_lam_viec')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Tìm kiếm lịch làm việc thành công',
            'data' => $data,
        ]);
    }

    /**
     * Tạo lịch làm việc nhân viên
     */
    public function createLichLamViecNhanVien(CreateLichLamViecRequest $request)
    {
        // Kiểm tra quyền
        // $id_chuc_nang = 14;
        // $id_chuc_vu = Auth::guard('sanctum')->user()->id_chuc_vu;
        // $check = \App\Models\PhanQuyen::where('id_chuc_vu', $id_chuc_vu)
        //     ->where('id_chuc_nang', $id_chuc_nang)
        //     ->first();

        // if (!$check) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Bạn không có quyền thực hiện chức năng này!'
        //     ], 403);
        // }

        // if (empty($request->id_nhan_vien)) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'ID nhân viên không được để trống'
        //     ], 400);
        // }

        $nhanVien = NhanVien::find($request->id_nhan_vien);
        if (!$nhanVien) {
            return response()->json([
                'status' => false,
                'message' => 'Nhân viên không tồn tại'
            ], 404);
        }

        if ($nhanVien->is_block) {
            return response()->json([
                'status' => false,
                'message' => 'Nhân viên đã bị khóa, không thể tạo lịch làm việc'
            ], 400);
        }

        // Kiểm tra trùng lịch: cùng nhân viên, cùng ngày, cùng ca
        $existingSchedule = LichLamViec::where('id_nhan_vien', $request->id_nhan_vien)
            ->where('ngay_lam_viec', $request->ngay_lam_viec)
            ->where('ca_lam_viec', $request->ca_lam_viec)
            ->exists();

        if ($existingSchedule) {
            return response()->json([
                'status' => false,
                'message' => 'Nhân viên đã có lịch làm việc trùng ca này trong ngày'
            ], 400);
        }

        $lichLamViec = LichLamViec::create([
            'id_nhan_vien' => $request->id_nhan_vien,
            'id_giao_vien' => null,
            'ngay_lam_viec' => $request->ngay_lam_viec,
            'ca_lam_viec' => $request->ca_lam_viec,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Tạo lịch làm việc thành công',
            'data' => $lichLamViec
        ], 201);
    }

    /**
     * Lấy ngày làm việc của nhân viên
     */
    public function getNgayLamViecNhanVien(Request $request)
    {
        $idNhanVien = $request->id_nhan_vien;
        if (empty($idNhanVien)) {
            return response()->json([
                'status' => false,
                'message' => 'Thiếu thông tin nhân viên'
            ], 400);
        }

        if (!NhanVien::where('id', $idNhanVien)->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Nhân viên không tồn tại'
            ], 404);
        }

        $from = $request->input('from_date', now()->toDateString());
        $to = $request->input('to_date', now()->addMonths(1)->toDateString());

        $fromDate = Carbon::parse($from)->toDateString();
        $toDate = Carbon::parse($to)->toDateString();

        $data = LichLamViec::where('id_nhan_vien', $idNhanVien)
            ->whereDate('ngay_lam_viec', '>=', $fromDate)
            ->whereDate('ngay_lam_viec', '<=', $toDate)
            ->orderBy('ngay_lam_viec')
            ->orderBy('ca_lam_viec')
            ->select('ngay_lam_viec', 'ca_lam_viec')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }

    /**
     * Lấy danh sách lịch làm việc giáo viên
     */
    public function getDataLichLamViecGiaoVien(Request $request)
    {
        //  Kiểm tra quyền
        // $id_chuc_nang = 14;
        // $id_chuc_vu = Auth::guard('sanctum')->user()->id_chuc_vu;
        // $check = \App\Models\PhanQuyen::where('id_chuc_vu', $id_chuc_vu)
        //     ->where('id_chuc_nang', $id_chuc_nang)
        //     ->first();

        // if (!$check) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Bạn không có quyền thực hiện chức năng này!'
        //     ], 403);
        // }

        $data = LichLamViec::join('giao_viens', 'lich_lam_viecs.id_giao_vien', '=', 'giao_viens.id')
            ->select(
                'lich_lam_viecs.id',
                'giao_viens.ho_va_ten',
                'giao_viens.id_chuc_vu',
                'lich_lam_viecs.ngay_lam_viec',
                'lich_lam_viecs.ca_lam_viec'
            )
            ->whereNotNull('lich_lam_viecs.id_giao_vien')
            ->orderBy('lich_lam_viecs.ngay_lam_viec')
            ->orderBy('lich_lam_viecs.ca_lam_viec')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }

    /**
     * Tìm kiếm/lọc lịch làm việc giáo viên
     */
    public function searchLichLamViecGiaoVien(Request $request)
    {
        $query = LichLamViec::join('giao_viens', 'lich_lam_viecs.id_giao_vien', '=', 'giao_viens.id')
            ->select(
                'lich_lam_viecs.id',
                'giao_viens.ho_va_ten',
                'giao_viens.id_chuc_vu',
                'lich_lam_viecs.ngay_lam_viec',
                'lich_lam_viecs.ca_lam_viec'
            )
            ->whereNotNull('lich_lam_viecs.id_giao_vien');

        // Lọc theo giáo viên
        if ($request->filled('id_giao_vien')) {
            $query->where('lich_lam_viecs.id_giao_vien', $request->id_giao_vien);
        }

        // Lọc theo khoảng thời gian
        if ($request->filled('from_date')) {
            $query->whereDate('lich_lam_viecs.ngay_lam_viec', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('lich_lam_viecs.ngay_lam_viec', '<=', $request->to_date);
        }

        // Lọc theo ca làm việc
        if ($request->filled('ca_lam_viec')) {
            $query->where('lich_lam_viecs.ca_lam_viec', $request->ca_lam_viec);
        }

        $data = $query->orderBy('lich_lam_viecs.ngay_lam_viec')
            ->orderBy('lich_lam_viecs.ca_lam_viec')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Tìm kiếm lịch làm việc thành công',
            'data' => $data,
        ]);
    }

    /**
     * Tạo lịch làm việc giáo viên
     */
    public function createLichLamViecGiaoVien(CreateLichLamViecRequest $request)
    {
        // Kiểm tra quyền
        // $id_chuc_nang = 14;
        // $id_chuc_vu = Auth::guard('sanctum')->user()->id_chuc_vu;
        // $check = \App\Models\PhanQuyen::where('id_chuc_vu', $id_chuc_vu)
        //     ->where('id_chuc_nang', $id_chuc_nang)
        //     ->first();

        // if (!$check) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Bạn không có quyền thực hiện chức năng này!'
        //     ], 403);
        // }

        // if (empty($request->id_giao_vien)) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'ID giáo viên không được để trống'
        //     ], 400);
        // }

        $giaoVien = GiaoVien::find($request->id_giao_vien);
        if (!$giaoVien) {
            return response()->json([
                'status' => false,
                'message' => 'Giáo viên không tồn tại'
            ], 404);
        }

        if ($giaoVien->is_block) {
            return response()->json([
                'status' => false,
                'message' => 'Giáo viên đã bị khóa, không thể tạo lịch làm việc'
            ], 400);
        }

        // Kiểm tra trùng lịch: cùng giáo viên, cùng ngày, cùng ca
        $existingSchedule = LichLamViec::where('id_giao_vien', $request->id_giao_vien)
            ->where('ngay_lam_viec', $request->ngay_lam_viec)
            ->where('ca_lam_viec', $request->ca_lam_viec)
            ->exists();

        if ($existingSchedule) {
            return response()->json([
                'status' => false,
                'message' => 'Giáo viên đã có lịch làm việc trùng ca này trong ngày'
            ], 400);
        }

        $lichLamViec = LichLamViec::create([
            'id_nhan_vien' => null,
            'id_giao_vien' => $request->id_giao_vien,
            'ngay_lam_viec' => $request->ngay_lam_viec,
            'ca_lam_viec' => $request->ca_lam_viec,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Tạo lịch làm việc thành công',
            'data' => $lichLamViec
        ], 201);
    }

    /**
     * Lấy ngày làm việc của giáo viên
     */
    public function getNgayLamViecGiaoVien(Request $request)
    {
        $idGiaoVien = $request->id_giao_vien;
        if (empty($idGiaoVien)) {
            return response()->json([
                'status' => false,
                'message' => 'Thiếu thông tin giáo viên'
            ], 400);
        }

        if (!GiaoVien::where('id', $idGiaoVien)->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Giáo viên không tồn tại'
            ], 404);
        }

        $from = $request->input('from_date', now()->toDateString());
        $to = $request->input('to_date', now()->addMonths(1)->toDateString());

        $fromDate = Carbon::parse($from)->toDateString();
        $toDate = Carbon::parse($to)->toDateString();

        $data = LichLamViec::where('id_giao_vien', $idGiaoVien)
            ->whereDate('ngay_lam_viec', '>=', $fromDate)
            ->whereDate('ngay_lam_viec', '<=', $toDate)
            ->orderBy('ngay_lam_viec')
            ->orderBy('ca_lam_viec')
            ->select('ngay_lam_viec', 'ca_lam_viec')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }

    /**
     * Xóa/Hủy lịch làm việc
     */
    public function deleteLichLamViec(Request $request)
    {
        // Kiểm tra quyền
        $id_chuc_nang = 14;
        $id_chuc_vu = Auth::guard('sanctum')->user()->id_chuc_vu;
        $check = \App\Models\PhanQuyen::where('id_chuc_vu', $id_chuc_vu)
            ->where('id_chuc_nang', $id_chuc_nang)
            ->first();

        if (!$check) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn không có quyền thực hiện chức năng này!'
            ], 403);
        }

        $id = $request->id;
        if (empty($id)) {
            return response()->json([
                'status' => false,
                'message' => 'ID lịch làm việc không được để trống'
            ], 400);
        }

        $lichLamViec = LichLamViec::find($id);
        if (!$lichLamViec) {
            return response()->json([
                'status' => false,
                'message' => 'Lịch làm việc không tồn tại'
            ], 404);
        }

        $lichLamViec->delete();

        return response()->json([
            'status' => true,
            'message' => 'Hủy lịch làm việc thành công'
        ]);
    }

    /**
     * ========== TEACHER API ==========
     */

    /**
     * Giáo viên xem lịch làm việc của chính mình
     */
    public function getMyLichLamViec(Request $request)
    {
        $giaoVien = Auth::guard('sanctum')->user();
        if (!$giaoVien) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn chưa đăng nhập'
            ], 401);
        }

        $data = LichLamViec::where('id_giao_vien', $giaoVien->id)
            ->select(
                'id',
                'id_giao_vien',
                'ngay_lam_viec',
                'ca_lam_viec'
            )
            ->orderBy('ngay_lam_viec')
            ->orderBy('ca_lam_viec')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }

    /**
     * Giáo viên xem ngày làm việc của chính mình theo khoảng thời gian
     */
    public function getMyNgayLamViec(Request $request)
    {
        $giaoVien = Auth::guard('sanctum')->user();
        if (!$giaoVien) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn chưa đăng nhập'
            ], 401);
        }

        $from = $request->input('from_date', now()->toDateString());
        $to = $request->input('to_date', now()->addMonths(1)->toDateString());

        $fromDate = Carbon::parse($from)->toDateString();
        $toDate = Carbon::parse($to)->toDateString();

        $data = LichLamViec::where('id_giao_vien', $giaoVien->id)
            ->whereDate('ngay_lam_viec', '>=', $fromDate)
            ->whereDate('ngay_lam_viec', '<=', $toDate)
            ->orderBy('ngay_lam_viec')
            ->orderBy('ca_lam_viec')
            ->select('id', 'id_giao_vien', 'ngay_lam_viec', 'ca_lam_viec')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }

    /**
     * Giáo viên hủy lịch làm việc của chính mình
     */
    public function deleteMyLichLamViec(Request $request)
    {
        $giaoVien = Auth::guard('sanctum')->user();
        if (!$giaoVien) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn chưa đăng nhập'
            ], 401);
        }

        $id = $request->id;
        if (empty($id)) {
            return response()->json([
                'status' => false,
                'message' => 'ID lịch làm việc không được để trống'
            ], 400);
        }

        $lichLamViec = LichLamViec::where('id', $id)
            ->where('id_giao_vien', $giaoVien->id)
            ->first();

        if (!$lichLamViec) {
            return response()->json([
                'status' => false,
                'message' => 'Lịch làm việc không tồn tại hoặc không thuộc về bạn'
            ], 404);
        }

        $lichLamViec->delete();

        return response()->json([
            'status' => true,
            'message' => 'Hủy lịch làm việc thành công'
        ]);
    }
}
