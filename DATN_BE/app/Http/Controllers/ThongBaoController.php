<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateThongBaoRequest;
use App\Http\Requests\DeleteThongBaoRequest;
use App\Http\Requests\UpdateThongBaoRequest;
use App\Models\ChiTietThongBao;
use App\Models\ThongBao;
use App\Models\PhuHuynh;
use App\Models\GiaoVien;
use App\Models\HocSinh;
use App\Models\LopHoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ThongBaoController extends Controller
{
    /**
     * Lấy danh sách tất cả thông báo
     */
    public function getData()
    {
        $data = ThongBao::join('nhan_viens', 'thong_baos.id_nhan_vien', '=', 'nhan_viens.id')
            ->leftJoin('chi_tiet_thong_baos', 'thong_baos.id', '=', 'chi_tiet_thong_baos.id_thong_bao')
            ->select(
                'thong_baos.id',
                'thong_baos.tieu_de',
                'thong_baos.noi_dung',
                'thong_baos.hinh_anh',
                'thong_baos.tep_dinh_kem',
                'thong_baos.thoi_gian_dang',
                'thong_baos.ngay_het_hieu_luc',
                'thong_baos.tinh_trang',
                'thong_baos.loai_thong_bao',
                'nhan_viens.ho_va_ten as nguoi_gui',
                'nhan_viens.avatar as avatar_nguoi_gui',
                DB::raw("
            CASE
                WHEN chi_tiet_thong_baos.id_phu_huynh IS NOT NULL THEN 'Phụ huynh'
                WHEN chi_tiet_thong_baos.id_giao_vien IS NOT NULL THEN 'Giáo viên'
                WHEN chi_tiet_thong_baos.id_lop_hoc IS NOT NULL THEN 'Lớp học'
                ELSE 'Không xác định'
            END as doi_tuong_nhan
        "),
                DB::raw('(SELECT COUNT(*) FROM chi_tiet_thong_baos WHERE chi_tiet_thong_baos.id_thong_bao = thong_baos.id) as tong_so_nguoi_nhan')
            )
            ->distinct()
            ->orderBy('thong_baos.thoi_gian_dang', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Load dữ liệu thông báo thành công',
            'data' => $data,
        ]);
    }

    /**
     * Tạo thông báo mới
     */
    /**
     * Tạo thông báo mới (chỉ tạo draft, chưa gửi)
     */
    public function store(CreateThongBaoRequest $request)
    {
        $user = Auth::guard('admin')->user() ?: Auth::guard('sanctum')->user();

        if (!$user || !($user instanceof \App\Models\NhanVien)) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn không có quyền tạo thông báo',
            ], 403);
        }

        try {
            // Tạo thông báo với trạng thái "Chờ gửi"
            $thongBao = ThongBao::create([
                'tieu_de' => $request->tieu_de,
                'noi_dung' => $request->noi_dung,
                'hinh_anh' => $request->hinh_anh,
                'tep_dinh_kem' => $request->tep_dinh_kem,
                'thoi_gian_dang' => now(),
                'ngay_het_hieu_luc' => $request->ngay_het_hieu_luc,
                'loai_thong_bao' => $request->loai_thong_bao,
                'tinh_trang' => 0, // Chờ gửi
                'id_nhan_vien' => $user->id,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Tạo thông báo thành công. Vui lòng chọn người nhận và gửi.',
                'data' => $thongBao,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Có lỗi xảy ra khi tạo thông báo: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Gửi thông báo đến người nhận
     */
    public function sendNotification(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'id_thong_bao' => 'required|exists:thong_baos,id',
            'doi_tuong_nhan' => 'required|string|in:tat_ca,phu_huynh,giao_vien,lop',
            'id_lop' => 'required_if:doi_tuong_nhan,lop|exists:lop_hocs,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = Auth::guard('admin')->user() ?: Auth::guard('sanctum')->user();

        if (!$user || !($user instanceof \App\Models\NhanVien)) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn không có quyền gửi thông báo',
            ], 403);
        }

        DB::beginTransaction();
        try {
            $thongBao = ThongBao::find($request->id_thong_bao);

            // Kiểm tra thông báo đã gửi chưa
            if ($thongBao->tinh_trang == 1) {
                return response()->json([
                    'status' => false,
                    'message' => 'Thông báo này đã được gửi trước đó',
                ], 400);
            }

            // Xóa chi tiết cũ nếu có
            ChiTietThongBao::where('id_thong_bao', $thongBao->id)->delete();

            // Lưu chi tiết người nhận
            $recipients = $this->saveChiTietThongBao($thongBao->id, $request);

            // Gửi email cho phụ huynh
            if (isset($recipients['phu_huynh']) && count($recipients['phu_huynh']) > 0) {
                $this->sendEmailToParents($thongBao, $recipients['phu_huynh'], $user);
            }

            // Cập nhật trạng thái thành "Đã gửi" và thời gian gửi
            $thongBao->update([
                'tinh_trang' => 1,
                'thoi_gian_dang' => now(),
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Gửi thông báo thành công đến ' . count($recipients['phu_huynh'] ?? []) . ' phụ huynh và ' . count($recipients['giao_vien'] ?? []) . ' giáo viên',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Có lỗi xảy ra khi gửi thông báo: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Cập nhật thông báo
     */
    public function update(UpdateThongBaoRequest $request)
    {
        $user = Auth::guard('admin')->user() ?: Auth::guard('sanctum')->user();

        if (!$user || !($user instanceof \App\Models\NhanVien)) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn không có quyền cập nhật thông báo',
            ], 403);
        }

        DB::beginTransaction();
        try {
            // Cập nhật thông báo
            ThongBao::where('id', $request->id)->update([
                'tieu_de' => $request->tieu_de,
                'noi_dung' => $request->noi_dung,
                'hinh_anh' => $request->hinh_anh,
                'tep_dinh_kem' => $request->tep_dinh_kem,
                'thoi_gian_dang' => $request->thoi_gian_dang,
                'ngay_het_hieu_luc' => $request->ngay_het_hieu_luc,
                'loai_thong_bao' => $request->loai_thong_bao,
                'tinh_trang' => $request->tinh_trang ?? 1,
            ]);

            // Xóa chi tiết cũ
            ChiTietThongBao::where('id_thong_bao', $request->id)->delete();

            // Lưu chi tiết mới
            $this->saveChiTietThongBao($request->id, $request);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Cập nhật thông báo thành công',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật thông báo: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Xóa thông báo
     */
    public function destroy(DeleteThongBaoRequest $request)
    {
        DB::beginTransaction();
        try {
            // Xóa chi tiết thông báo
            ChiTietThongBao::where('id_thong_bao', $request->id)->delete();

            // Xóa thông báo
            ThongBao::where('id', $request->id)->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Xóa thông báo thành công',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Có lỗi xảy ra khi xóa thông báo: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Tìm kiếm thông báo
     */
    public function search(Request $request)
    {
        $query = ThongBao::join('nhan_viens', 'thong_baos.id_nhan_vien', 'nhan_viens.id')
            ->leftJoin('chi_tiet_thong_baos', 'thong_baos.id', 'chi_tiet_thong_baos.id_thong_bao')
            ->leftJoin('phu_huynhs', 'chi_tiet_thong_baos.id_phu_huynh', 'phu_huynhs.id')
            ->leftJoin('giao_viens', 'chi_tiet_thong_baos.id_giao_vien', 'giao_viens.id')
            ->leftJoin('lop_hocs', 'chi_tiet_thong_baos.id_lop_hoc', 'lop_hocs.id')
            ->select(
                'thong_baos.id',
                'thong_baos.tieu_de',
                'thong_baos.noi_dung',
                'thong_baos.hinh_anh',
                'thong_baos.tep_dinh_kem',
                'thong_baos.thoi_gian_dang',
                'thong_baos.ngay_het_hieu_luc',
                'thong_baos.tinh_trang',
                'thong_baos.loai_thong_bao',
                'nhan_viens.ho_va_ten as nguoi_gui',
                'nhan_viens.avatar as avatar_nguoi_gui',
                DB::raw("
            CASE
                WHEN chi_tiet_thong_baos.id_phu_huynh IS NOT NULL THEN 'phu_huynh'
                WHEN chi_tiet_thong_baos.id_giao_vien IS NOT NULL THEN 'giao_vien'
                WHEN chi_tiet_thong_baos.id_lop_hoc IS NOT NULL THEN 'lop'
                ELSE 'tat_ca'
            END as doi_tuong_nhan
        "),
                DB::raw('(SELECT COUNT(*) FROM chi_tiet_thong_baos WHERE chi_tiet_thong_baos.id_thong_bao = thong_baos.id) as tong_so_nguoi_nhan')
            );

        // Tìm kiếm theo từ khóa (tiêu đề hoặc nội dung)
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('thong_baos.tieu_de', 'like', '%' . $searchTerm . '%')
                    ->orWhere('thong_baos.noi_dung', 'like', '%' . $searchTerm . '%');
            });
        }

        // Tìm kiếm theo loại thông báo
        if ($request->filled('loai_thong_bao')) {
            $query->where('thong_baos.loai_thong_bao', $request->loai_thong_bao);
        }

        // Tìm kiếm theo trạng thái
        if ($request->filled('tinh_trang')) {
            $query->where('thong_baos.tinh_trang', $request->tinh_trang);
        }

        // Tìm kiếm theo người gửi
        if ($request->filled('id_nhan_vien')) {
            $query->where('thong_baos.id_nhan_vien', $request->id_nhan_vien);
        }

        $data = $query->distinct()->orderBy('thong_baos.thoi_gian_dang', 'desc')->get();

        return response()->json([
            'status' => true,
            'message' => 'Tìm kiếm thông báo thành công',
            'data' => $data,
        ]);
    }

    /**
     * Thống kê thông báo
     */
    public function statistical()
    {
        $total = ThongBao::count();
        $totalActive = ThongBao::where('tinh_trang', 1)->count();
        $totalInactive = ThongBao::where('tinh_trang', 0)->count();

        // Thống kê theo tháng
        $byMonth = ThongBao::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Thống kê theo trạng thái
        $byStatus = ThongBao::select('tinh_trang')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('tinh_trang')
            ->get();

        // Thống kê theo loại thông báo
        $byType = ThongBao::select('loai_thong_bao')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('loai_thong_bao')
            ->get();

        // Thống kê số người nhận trung bình
        $recipientsStats = DB::table('chi_tiet_thong_baos')
            ->select('id_thong_bao', DB::raw('COUNT(*) as recipient_count'))
            ->groupBy('id_thong_bao')
            ->get();

        $avgRecipients = $recipientsStats->count() > 0
            ? round($recipientsStats->avg('recipient_count'), 2)
            : 0;

        return response()->json([
            'status' => true,
            'message' => 'Thống kê thông báo',
            'data' => [
                'total_records' => $total,
                'total_active' => $totalActive,
                'total_inactive' => $totalInactive,
                'by_month' => $byMonth,
                'by_status' => $byStatus,
                'by_type' => $byType,
                'avg_recipients' => $avgRecipients,
            ],
        ]);
    }

    /**
     * Thay đổi trạng thái thông báo
     */
    public function changeStatus(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'id' => 'required|exists:thong_baos,id',
            'tinh_trang' => 'required|integer|in:0,1,2',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors(),
            ], 422);
        }

        ThongBao::where('id', $request->id)->update([
            'tinh_trang' => $request->tinh_trang,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Thay đổi trạng thái thành công',
        ]);
    }

    /**
     * Lưu chi tiết thông báo (người nhận)
     */
    private function saveChiTietThongBao($idThongBao, $request)
    {
        $chiTietList = [];

        // Xử lý theo đối tượng nhận từ Vue form
        if ($request->filled('doi_tuong_nhan')) {
            $doiTuongNhan = $request->doi_tuong_nhan;

            switch ($doiTuongNhan) {
                case 'tat_ca':
                    // Lấy tất cả phụ huynh
                    $phuHuynhs = PhuHuynh::where('is_block', 0)->pluck('id');
                    foreach ($phuHuynhs as $idPhuHuynh) {
                        $chiTietList[] = [
                            'id_thong_bao' => $idThongBao,
                            'id_phu_huynh' => $idPhuHuynh,
                            'id_giao_vien' => null,
                            'id_lop_hoc' => null,
                        ];
                    }

                    // Lấy tất cả giáo viên
                    $giaoViens = GiaoVien::where('is_block', 0)->pluck('id');
                    foreach ($giaoViens as $idGiaoVien) {
                        $chiTietList[] = [
                            'id_thong_bao' => $idThongBao,
                            'id_phu_huynh' => null,
                            'id_giao_vien' => $idGiaoVien,
                            'id_lop_hoc' => null,
                        ];
                    }
                    break;

                case 'phu_huynh':
                    // Lấy tất cả phụ huynh
                    $phuHuynhs = PhuHuynh::where('is_block', 0)->pluck('id');
                    foreach ($phuHuynhs as $idPhuHuynh) {
                        $chiTietList[] = [
                            'id_thong_bao' => $idThongBao,
                            'id_phu_huynh' => $idPhuHuynh,
                            'id_giao_vien' => null,
                            'id_lop_hoc' => null,
                        ];
                    }
                    break;

                case 'giao_vien':
                    // Lấy tất cả giáo viên
                    $giaoViens = GiaoVien::where('is_block', 0)->pluck('id');
                    foreach ($giaoViens as $idGiaoVien) {
                        $chiTietList[] = [
                            'id_thong_bao' => $idThongBao,
                            'id_phu_huynh' => null,
                            'id_giao_vien' => $idGiaoVien,
                            'id_lop_hoc' => null,
                        ];
                    }
                    break;

                case 'lop':
                    // Lấy phụ huynh và giáo viên của lớp
                    if ($request->filled('id_lop')) {
                        $idLop = $request->id_lop;

                        // Lấy giáo viên của lớp
                        $lopHoc = LopHoc::find($idLop);
                        if ($lopHoc && $lopHoc->id_giao_vien) {
                            $chiTietList[] = [
                                'id_thong_bao' => $idThongBao,
                                'id_phu_huynh' => null,
                                'id_giao_vien' => $lopHoc->id_giao_vien,
                                'id_lop_hoc' => $idLop,
                            ];
                        }

                        // Lấy tất cả phụ huynh của học sinh trong lớp
                        $hocSinhs = HocSinh::where('id_lop_hoc', $idLop)
                            ->where('is_block', 0)
                            ->whereNotNull('id_phu_huynh')
                            ->distinct()
                            ->pluck('id_phu_huynh');

                        foreach ($hocSinhs as $idPhuHuynh) {
                            $chiTietList[] = [
                                'id_thong_bao' => $idThongBao,
                                'id_phu_huynh' => $idPhuHuynh,
                                'id_giao_vien' => null,
                                'id_lop_hoc' => $idLop,
                            ];
                        }
                    }
                    break;
            }
        }

        // Xử lý theo cách cũ (tương thích ngược) - nếu có id_phu_huynh, id_giao_vien, id_lop_hoc trực tiếp
        // Lưu danh sách phụ huynh
        if ($request->filled('id_phu_huynh') && is_array($request->id_phu_huynh)) {
            foreach ($request->id_phu_huynh as $idPhuHuynh) {
                if ($idPhuHuynh) {
                    $chiTietList[] = [
                        'id_thong_bao' => $idThongBao,
                        'id_phu_huynh' => $idPhuHuynh,
                        'id_giao_vien' => null,
                        'id_lop_hoc' => null,
                    ];
                }
            }
        }

        // Lưu danh sách giáo viên
        if ($request->filled('id_giao_vien') && is_array($request->id_giao_vien)) {
            foreach ($request->id_giao_vien as $idGiaoVien) {
                if ($idGiaoVien) {
                    $chiTietList[] = [
                        'id_thong_bao' => $idThongBao,
                        'id_phu_huynh' => null,
                        'id_giao_vien' => $idGiaoVien,
                        'id_lop_hoc' => null,
                    ];
                }
            }
        }

        // Lưu danh sách lớp học
        if ($request->filled('id_lop_hoc') && is_array($request->id_lop_hoc)) {
            foreach ($request->id_lop_hoc as $idLopHoc) {
                if ($idLopHoc) {
                    $chiTietList[] = [
                        'id_thong_bao' => $idThongBao,
                        'id_phu_huynh' => null,
                        'id_giao_vien' => null,
                        'id_lop_hoc' => $idLopHoc,
                    ];
                }
            }
        }

        // Loại bỏ trùng lặp dựa trên id_phu_huynh, id_giao_vien, id_lop_hoc
        $uniqueList = [];
        $seen = [];
        $recipientIds = [
            'phu_huynh' => [],
            'giao_vien' => [],
        ];

        foreach ($chiTietList as $item) {
            $key = $item['id_phu_huynh'] . '_' . $item['id_giao_vien'] . '_' . $item['id_lop_hoc'];
            if (!isset($seen[$key])) {
                $seen[$key] = true;
                $uniqueList[] = $item;

                // Track unique recipient IDs
                if ($item['id_phu_huynh']) {
                    $recipientIds['phu_huynh'][] = $item['id_phu_huynh'];
                }
                if ($item['id_giao_vien']) {
                    $recipientIds['giao_vien'][] = $item['id_giao_vien'];
                }
            }
        }

        // Remove duplicates from recipient IDs
        $recipientIds['phu_huynh'] = array_unique($recipientIds['phu_huynh']);
        $recipientIds['giao_vien'] = array_unique($recipientIds['giao_vien']);

        // Insert all chi tiết
        if (!empty($uniqueList)) {
            ChiTietThongBao::insert($uniqueList);
        }

        return $recipientIds;
    }

    /**
     * Gửi email tới phụ huynh
     */
    private function sendEmailToParents($thongBao, $parentIds, $sender)
    {
        try {
            // Lấy danh sách phụ huynh có email
            $parents = PhuHuynh::whereIn('id', $parentIds)
                ->whereNotNull('email')
                ->where('email', '!=', '')
                ->get();

            foreach ($parents as $parent) {
                try {
                    $noiDung = [
                        'tieuDe' => $thongBao->tieu_de,
                        'noiDung' => $thongBao->noi_dung,
                        'loaiThongBao' => $thongBao->loai_thong_bao,
                        'nguoiGui' => $sender->ho_va_ten ?? 'Admin',
                        'thoiGian' => $thongBao->thoi_gian_dang->format('d/m/Y H:i'),
                    ];

                    Mail::to($parent->email)->send(
                        new \App\Mail\MasterMail(
                            $thongBao->tieu_de,
                            'thongBao',
                            $noiDung
                        )
                    );
                } catch (\Exception $e) {
                    // Log error but don't stop the process
                    Log::error("Failed to send email to {$parent->email}: " . $e->getMessage());
                }
            }
        } catch (\Exception $e) {
            Log::error("Error in sendEmailToParents: " . $e->getMessage());
        }
    }
}
