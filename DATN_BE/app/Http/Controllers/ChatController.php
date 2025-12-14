<?php

namespace App\Http\Controllers;

use App\Events\SendMessageEvent;
use App\Models\LichSuChat;
use App\Models\HocSinh;
use App\Models\GiaoVien;
use App\Models\LopHoc;
use App\Models\BuaAn;
use App\Models\ChiTietThucDon;
use App\Models\MonAn;
use App\Models\ThucDon;
use App\Models\HocPhi;
use App\Models\ChiTietHocPhi;
use App\Models\DongHocPhi;
use App\Models\SucKhoe;
use App\Models\ThongBao;
use App\Models\BaiViet;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    private $BOT_ID = 0; // ID mặc định của chatbot

    /**
     * Gửi tin nhắn realtime (qua socket)
     */
    public function sendMessage(Request $request)
    {
        event(new SendMessageEvent($request->message, $request->id_gui));
        return response()->json([
            'status' => true,
            'message' => 'Đã gửi tin nhắn realtime'
        ]);
    }


    public function getHocSinhInfo(Request $request)
    {
        try {
            $data = $this->getHocSinhData();
            return response()->json([
                'success' => true,
                'message' => 'Lấy thông tin học sinh thành công',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy thông tin học sinh: ' . $e->getMessage()
            ], 500);
        }
    }


    public function getGiaoVienInfo(Request $request)
    {
        try {
            $data = $this->getGiaoVienData();
            return response()->json([
                'success' => true,
                'message' => 'Lấy thông tin giáo viên thành công',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy thông tin giáo viên: ' . $e->getMessage()
            ], 500);
        }
    }


    public function getLopHocInfo(Request $request)
    {
        try {
            $data = $this->getLopHocData();
            return response()->json([
                'success' => true,
                'message' => 'Lấy thông tin lớp học thành công',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy thông tin lớp học: ' . $e->getMessage()
            ], 500);
        }
    }














    /**
     * *  Lưu lịch sử chat
     */
    public function luuLichSuChat($nguoi_dung_id, $noi_dung, $la_bot = false)
    {
        if (empty($noi_dung))
            $noi_dung = '[Không có nội dung]';

        return LichSuChat::create([
            'nguoi_gui' => $la_bot ? $this->BOT_ID : $nguoi_dung_id,
            'nguoi_nhan' => $la_bot ? $nguoi_dung_id : $this->BOT_ID,
            'noi_dung' => $noi_dung,
        ]);
    }

    /**
     * Lấy lịch sử chat
     */
    public function getLichSuChat()
    {
        $data = $this->layLichSuChat();
        return response()->json([
            'success' => true,
            'message' => 'Lấy lịch sử chat thành công',
            'history' => $data
        ]);
    }

    /**
     * Xử lý danh sách lịch sử chat
     */
    private function layLichSuChat($userId = null)
    {
        $query = LichSuChat::query();

        if ($userId) {
            $query->where(function ($q) use ($userId) {
                $q->where('nguoi_gui', $userId)
                    ->orWhere('nguoi_nhan', $userId);
            });
        } else {
            $query->where('nguoi_gui', $this->BOT_ID)
                ->orWhere('nguoi_nhan', $this->BOT_ID);
        }

        return $query->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($chat) {
                return [
                    'role' => $chat->nguoi_gui === $this->BOT_ID ? 'assistant' : 'user',
                    'content' => $chat->noi_dung ?? '[Không có nội dung]',
                    'timestamp' => $chat->created_at ? $chat->created_at->format('H:i d/m/Y') : 'N/A'
                ];
            })
            ->toArray();
    }

    /**
     * Get Thực đơn API
     */
    public function getThucDon()
    {
        try {
            $data = $this->getThucDonData();
            return response()->json([
                'success' => true,
                'message' => 'Lấy thực đơn thành công',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy thực đơn: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Chi tiết Thực đơn API
     */
    public function getChiTietThucDon()
    {
        try {
            $data = $this->getChiTietThucDonData();
            return response()->json([
                'success' => true,
                'message' => 'Lấy chi tiết thực đơn thành công',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy chi tiết thực đơn: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Món ăn API
     */
    public function getMonAn()
    {
        try {
            $data = $this->getMonAnData();
            return response()->json([
                'success' => true,
                'message' => 'Lấy danh sách món ăn thành công',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy danh sách món ăn: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Bữa ăn API
     */
    public function getBuaAn(Request $request)
    {
        try {
            $data = $this->getBuaAnData();
            return response()->json([
                'success' => true,
                'message' => 'Lấy danh sách bữa ăn thành công',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy danh sách bữa ăn: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Sức khỏe API
     */
    public function getSucKhoe(Request $request)
    {
        try {
            $data = $this->getSucKhoeData();
            return response()->json([
                'success' => true,
                'message' => 'Lấy thông tin sức khỏe thành công',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy thông tin sức khỏe: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Học phí API
     */
    public function getHocPhi(Request $request)
    {
        try {
            $data = $this->getHocPhiData();
            return response()->json([
                'success' => true,
                'message' => 'Lấy thông tin học phí thành công',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy thông tin học phí: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Đóng học phí API
     */
    public function getDongHocPhi()
    {
        try {
            $data = $this->getDongHocPhiData();
            return response()->json([
                'success' => true,
                'message' => 'Lấy thông tin đóng học phí thành công',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy thông tin đóng học phí: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Profile Giáo viên API
     */
    public function getDataProfile()
    {
        try {
            $giaovien = Auth::user();
            if (!$giaovien) {
                return response()->json([
                    'success' => false,
                    'message' => 'Người dùng chưa đăng nhập'
                ], 401);
            }
            return response()->json([
                'success' => true,
                'message' => 'Lấy thông tin profile thành công',
                'data' => $giaovien
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy thông tin profile: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Thông báo API
     */
    public function getData()
    {
        try {
            $data = $this->getThongBaoData();
            return response()->json([
                'success' => true,
                'message' => 'Lấy thông báo thành công',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy thông báo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * ✅ Gọi API GROQ để tư vấn phụ huynh (thêm dữ liệu bữa ăn)
     */
    public function tuvanAI(Request $request)
    {
        $api_key = env('GROQ_API_KEY');
        if (!$api_key) {
            return response()->json(['success' => false, 'message' => 'Thiếu GROQ_API_KEY trong .env'], 500);
        }

        // --- Lấy nội dung câu hỏi ---
        $message = trim($request->json('message', $request->input('message', '')));
        if ($message === '') {
            $raw = trim($request->getContent() ?? '');
            $dec = json_decode($raw, true);
            if (is_array($dec) && isset($dec['message'])) {
                $message = trim($dec['message']);
            }
        }
        if ($message === '') {
            return response()->json(['success' => false, 'message' => 'Vui lòng nhập nội dung câu hỏi'], 400);
        }

        // --- Phát hiện chủ đề câu hỏi và lấy dữ liệu liên quan ---
        $context = $this->detectAndFetchContext($message);

        // --- Lấy dữ liệu demo cơ bản ---
        $thongtinGV = GiaoVien::where('tinh_trang', 1)->take(3)->get()
            ->map(fn($gv) => "- {$gv->ho_va_ten} | Chuyên môn: {$gv->chuyen_mon} | Lớp: {$gv->lop_phu_trach}")
            ->implode("\n");

        $thongtinHS = HocSinh::take(3)->get()
            ->map(fn($hs) => "- {$hs->ho_va_ten} | NS: {$hs->ngay_sinh} | Lớp: {$hs->id_lop_hoc}")
            ->implode("\n");

        $lopHocs = LopHoc::where('is_block', false)->take(3)->get()
            ->map(function ($lop) {
                $gv = GiaoVien::find($lop->id_giao_vien);
                $tenGV = $gv ? $gv->ho_va_ten : 'Chưa có giáo viên phụ trách';
                return "- {$lop->ten_lop} | GV: {$tenGV} | SL: {$lop->so_luong}";
            })
            ->implode("\n");

        // --- Tạo prompt với context đầy đủ ---
        $prompt = $this->buildPrompt($message, $context, $thongtinGV, $thongtinHS, $lopHocs);

        // Giới hạn độ dài để tránh lỗi từ API
        if (strlen($prompt) > 9000) {
            $prompt = substr($prompt, 0, 8900) . "\n...[Một phần dữ liệu đã được rút gọn để hệ thống hoạt động ổn định]";
        }

        try {
            $client = new Client(['timeout' => 30]);
            $url = "https://api.groq.com/openai/v1/chat/completions";

            $response = $client->post($url, [
                'json' => [
                    'model' => 'llama-3.3-70b-versatile',
                    'messages' => [
                        ['role' => 'system', 'content' => 'Bạn là MAMNON AI 🌸, trợ lý ảo chuyên nghiệp và thân thiện của trường mầm non. Hãy trả lời CHI TIẾT, RÕ RÀNG và ĐẦY ĐỦ THÔNG TIN bằng tiếng Việt. Sử dụng emoji phù hợp để tăng tính thân thiện. Cấu trúc câu trả lời: (1) Chào hỏi ngắn gọn, (2) Trả lời chi tiết với đầy đủ thông tin từ dữ liệu, (3) Tóm tắt/gợi ý tiếp theo. Độ dài: 5-10 câu tùy độ phức tạp của câu hỏi. Luôn kết thúc bằng câu hỏi thân thiện hoặc gợi ý thêm.'],
                        ['role' => 'user', 'content' => $prompt]
                    ],
                    'temperature' => 0.5,
                    'max_tokens' => 1000
                ],
                'headers' => [
                    'Authorization' => "Bearer {$api_key}",
                    'Content-Type' => 'application/json'
                ]
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            $ket_qua = $body['choices'][0]['message']['content'] ?? 'Xin lỗi, hiện tại MAMNON AI chưa có phản hồi.';

            $userId = Auth::id() ?? 1;
            $this->luuLichSuChat($userId, $message, false);
            $this->luuLichSuChat($userId, $ket_qua, true);

            return response()->json([
                'success' => true,
                'message' => 'Tư vấn thành công',
                'data' => $ket_qua,
                'history' => $this->layLichSuChat()
            ]);
        } catch (\GuzzleHttp\Exception\ServerException $e) {
            return response()->json([
                'success' => false,
                'message' => 'MAMNON AI hiện đang quá tải, vui lòng thử lại sau vài giây.'
            ], 503);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi gọi API tư vấn: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Phát hiện chủ đề câu hỏi và lấy dữ liệu liên quan
     */
    private function detectAndFetchContext($message)
    {
        $message_lower = strtolower($message);
        $context = [];

        // Kiểm tra bài viết, tin tức (Ưu tiên cao)
        if (preg_match('/(bài viết|tin tức|hoạt động|sự kiện|blog|tin mới)/i', $message)) {
            $context['bai_viet'] = $this->getBaiVietData();
        }

        // Kiểm tra các từ khóa liên quan đến học phí và chi tiết
        if (preg_match('/(học phí|đóng học phí|tiền học|chi phí|bao nhiêu tiền|hóa đơn)/i', $message)) {
            $context['hoc_phi'] = $this->getHocPhiData();
            $context['chi_tiet_hoc_phi'] = $this->getChiTietHocPhiData(); // Thêm chi tiết học phí
            $context['dong_hoc_phi'] = $this->getDongHocPhiData();
        }

        // Kiểm tra các từ khóa liên quan đến thực đơn và bữa ăn
        if (preg_match('/(thực đơn|bữa ăn|ăn cơm|menu|ăn gì|hôm nay ăn|món ăn|dinh dưỡng)/i', $message)) {
            $context['thuc_don'] = $this->getThucDonData(); // Lấy thực đơn tổng quan
            $context['chi_tiet_thuc_don'] = $this->getChiTietThucDonData(); // Lấy chi tiết món ăn theo bữa
            $context['bua_an'] = $this->getBuaAnData();
            $context['mon_an'] = $this->getMonAnData();
        }

        // Kiểm tra các từ khóa liên quan đến thông báo
        if (preg_match('/(thông báo|tin tức|thông tin|công bố|lưu ý)/i', $message)) {
            $context['thong_bao'] = $this->getThongBaoData();
        }

        // Kiểm tra các từ khóa liên quan đến sức khỏe
        if (preg_match('/(sức khỏe|khám|chiều cao|cân nặng|y tế|bệnh|đau)/i', $message)) {
            $context['suc_khoe'] = $this->getSucKhoeData();
        }

        // Kiểm tra các từ khóa liên quan đến giáo viên
        if (preg_match('/(giáo viên|thầy cô|cô giáo|liên hệ|phụ trách|nhân viên)/i', $message)) {
            $context['giao_vien'] = $this->getGiaoVienData();
        }

        // Kiểm tra các từ khóa liên quan đến thông tin học sinh
        if (preg_match('/(học sinh|con|em|bé|trẻ|lớp|thông tin bé)/i', $message)) {
            $context['hoc_sinh'] = $this->getHocSinhData();
        }

        // Kiểm tra các từ khóa liên quan đến lớp học
        if (preg_match('/(lớp học|lớp|khối lớp|phòng học)/i', $message)) {
            $context['lop_hoc'] = $this->getLopHocData();
        }

        // Kiểm tra thông tin chung, quy định, tuyển sinh, giờ giấc (FAQ)
        if (preg_match('/(giờ|đón|trả|tan|về|quy định|thành lập|uy tín|giấy phép|an toàn|camera|ngủ|sinh hoạt|chương trình|tiếng anh|ngoại khóa|tuyển sinh|hồ sơ|nhập học|thủ tục|liên hệ|địa chỉ)/i', $message)) {
            $context['thong_tin_chung'] = $this->getThongTinChungData();
        }

        // Luôn bổ sung thông tin chung nếu hỏi về học phí, thực đơn, giáo viên để có thêm ngữ cảnh chính sách
        if (isset($context['hoc_phi']) || isset($context['thuc_don']) || isset($context['giao_vien'])) {
             if (!isset($context['thong_tin_chung'])) {
                 $context['thong_tin_chung'] = $this->getThongTinChungData();
             }
        }

        return $context;
    }

    /**
     * Lấy dữ liệu học phí
     */
    private function getHocPhiData()
    {
        $hocPhi = HocPhi::all();
        if ($hocPhi->isEmpty()) {
            return "Hiện chưa có thông tin học phí trong hệ thống.";
        }

        return "📚 THÔNG TIN HỌC PHÍ:\n" . $hocPhi->map(function ($hp) {
            return "- {$hp->ten_hoc_phi}: " . number_format($hp->so_tien) . " VND | Trạng thái: {$hp->trang_thai}";
        })->implode("\n");
    }

    /**
     * Lấy dữ liệu đóng học phí
     */
    private function getDongHocPhiData()
    {
        $dongHocPhi = DongHocPhi::latest()->take(5)->get();
        if ($dongHocPhi->isEmpty()) {
            return "Hiện chưa có thông tin đóng học phí.";
        }

        return "💰 THÔNG TIN ĐÓ HỌC PHÍ:\n" . $dongHocPhi->map(function ($dhp) {
            return "- Học sinh: {$dhp->ten_hoc_sinh} | Đã đóng: " . number_format($dhp->so_tien_da_dong) . " | Còn: " . number_format($dhp->so_tien_con_thieu) . " | Ngày: {$dhp->ngay_dong}";
        })->implode("\n");
    }

    /**
     * Lấy dữ liệu thực đơn
     */
    private function getThucDonData()
    {
        $thucDons = ThucDon::orderBy('ngay', 'asc')->get();
        if ($thucDons->isEmpty()) {
            return "Hiện chưa có thực đơn trong hệ thống.";
        }

        return "📅 THỰC ĐƠN TRONG TUẦN:\n" . $thucDons->map(function ($td) {
            $ngay = $td->ngay ? date('d/m/Y', strtotime($td->ngay)) : 'N/A';
            return "- {$td->ten_thuc_don} (Ngày: {$ngay}): {$td->mo_ta}";
        })->implode("\n");
    }

    /**
     * Lấy dữ liệu chi tiết thực đơn
     */
    private function getChiTietThucDonData()
    {
        $chiTiet = ChiTietThucDon::with(['thucDon', 'monAn', 'buaAn'])
            ->orderBy('id_thuc_don')
            ->take(10)
            ->get();

        if ($chiTiet->isEmpty()) {
            return "Hiện chưa có chi tiết thực đơn.";
        }

        return "🍱 CHI TIẾT THỰC ĐƠN:\n" . $chiTiet->map(function ($ct) {
            return "- [{$ct->thucDon->ten_thuc_don}] {$ct->buaAn->ten_bua_an}: {$ct->monAn->ten_mon} (SL: {$ct->so_luong})";
        })->implode("\n");
    }

    /**
     * Lấy dữ liệu bữa ăn
     */
    private function getBuaAnData()
    {
        $buaAn = BuaAn::all();
        if ($buaAn->isEmpty()) {
            return "Hiện chưa có bữa ăn nào.";
        }

        return "🍽️ DANH SÁCH BỮA ĂN:\n" . $buaAn->map(function ($b) {
            return "- {$b->ten_bua_an}: {$b->mo_ta}";
        })->implode("\n");
    }

    /**
     * Lấy dữ liệu món ăn chi tiết
     */
    private function getMonAnData()
    {
        $monAn = MonAn::take(20)->get(); // Lấy mẫu 20 món
        if ($monAn->isEmpty()) return "";
        return "🍲 DANH SÁCH MÓN ĂN (Tham khảo):\n" . $monAn->map(function ($m) {
            return "- {$m->ten_mon} (Calo: {$m->calo}, Đạm: {$m->protein})";
        })->implode("\n");
    }

    /**
     * Lấy dữ liệu bài viết/tin tức
     */
    private function getBaiVietData()
    {
        $baiViets = BaiViet::latest('ngay_dang')->take(5)->get();
        if ($baiViets->isEmpty()) {
            return "Hiện chưa có bài viết mới nào.";
        }
        return "📰 TIN TỨC & BÀI VIẾT MỚI:\n" . $baiViets->map(function ($bv) {
            return "- [{$bv->ngay_dang}] {$bv->tieu_de}: " . \Illuminate\Support\Str::limit(strip_tags($bv->noi_dung), 100);
        })->implode("\n");
    }

    /**
     * Lấy dữ liệu chi tiết học phí (các khoản thu)
     */
    private function getChiTietHocPhiData()
    {
        // Lấy danh sách các khoản phí chi tiết (thường là cấu thành nên học phí)
        // Giả sử bảng hoc_phis chứa danh mục phí
        $dsHocPhi = HocPhi::where('tinh_trang', 1)->get();
        
        if ($dsHocPhi->isEmpty()) return "";

        return "🧾 CHI TIẾT CÁC KHOẢN PHÍ:\n" . $dsHocPhi->map(function ($hp) {
             return "- {$hp->ten_hoc_phi}: " . number_format($hp->don_gia) . " VND ({$hp->don_vi_tinh})";
        })->implode("\n");
    }

    /**
     * Lấy dữ liệu thông báo
     */
    private function getThongBaoData()
    {
        $tb = ThongBao::latest()->take(5)->get();
        return "📢 THÔNG BÁO MỚI:\n" . $tb->map(function($t){
            return "- {$t->tieu_de} (" . ($t->created_at ? $t->created_at->format('d/m/Y') : 'N/A') . "): {$t->noi_dung}";
        })->implode("\n");
    }

    /**
     * Lấy dữ liệu sức khỏe
     */
    private function getSucKhoeData()
    {
        // Lấy mẫu thông tin sức khỏe mới nhất (demo) hoặc logic cụ thể theo user
        $sk = SucKhoe::latest()->take(5)->get();
        if($sk->isEmpty()) return "Chưa có dữ liệu sức khỏe.";
        
        return "giáo viên có thể xem thông tin sức khỏe của học sinh tại hệ thống quản lý.";
    }

    /**
     * Lấy dữ liệu giáo viên
     */
    private function getGiaoVienData()
    {
        $gvs = GiaoVien::where('tinh_trang', 1)->take(10)->get();
        return "👩‍🏫 DANH SÁCH GIÁO VIÊN:\n" . $gvs->map(function($gv){
            return "- {$gv->ho_va_ten} (Chuyên môn: {$gv->chuyen_mon}) - Lớp: {$gv->lop_phu_trach}";
        })->implode("\n");
    }

    /**
     * Lấy dữ liệu học sinh (demo)
     */
    private function getHocSinhData()
    {
        // Lưu ý: Bảo mật thông tin, chỉ lấy thống kê hoặc thông tin chung nếu chat public
        // Ở đây lấy mẫu vài học sinh
        return "👶 DỮ LIỆU HỌC SINH (Mẫu):\n" . HocSinh::take(5)->get()->map(function($hs){
            return "- {$hs->ho_va_ten} (Lớp {$hs->id_lop_hoc})";
        })->implode("\n");
    }

    /**
     * Lấy dữ liệu lớp học
     */
    private function getLopHocData()
    {
        return "🏫 DANH SÁCH LỚP HỌC:\n" . LopHoc::where('is_block', false)->get()->map(function($l){
            return "- Lớp {$l->ten_lop} (Sĩ số: {$l->so_luong})";
        })->implode("\n");
    }

    /**
     * Get Danh sách Lớp học API
     */
    public function getDanhSachLopHoc(Request $request)
    {
        try {
            $idLopHoc = $request->get('id_lop_hoc');

            if ($idLopHoc) {
                $lop = LopHoc::with('giaoVien')->find($idLopHoc);
                if (!$lop) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Không tìm thấy lớp học'
                    ]);
                }
                $data = [
                    'id' => $lop->id,
                    'ten_lop' => $lop->ten_lop,
                    'khoi_lop' => $lop->id_khoi_lop,
                    'nam_hoc' => $lop->id_nam_hoc,
                    'so_luong' => $lop->so_luong,
                    'giao_vien_phu_trach' => $lop->giaoVien->ho_va_ten ?? 'N/A',
                    'trang_thai' => $lop->is_block ? 'Đã khóa' : 'Đang hoạt động'
                ];
            } else {
                // Lấy tất cả lớp học
                $lopHocs = LopHoc::where('is_block', false)->with('giaoVien')->get();
                $data = $lopHocs->map(function ($lop) {
                    return [
                        'id' => $lop->id,
                        'ten_lop' => $lop->ten_lop,
                        'khoi_lop' => $lop->id_khoi_lop,
                        'so_luong' => $lop->so_luong,
                        'giao_vien' => $lop->giaoVien->ho_va_ten ?? 'N/A'
                    ];
                })->toArray();
            }

            return response()->json([
                'success' => true,
                'message' => 'Lấy danh sách lớp học thành công',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy danh sách lớp học: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Lịch sử Chat API
     */
    public function getChatHistory(Request $request)
    {
        try {
            $userId = Auth::id() ?? $request->query('user_id', 1);
            $history = $this->layLichSuChat($userId);

            return response()->json([
                'success' => true,
                'message' => 'Lấy lịch sử chat thành công',
                'data' => $history
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy lịch sử chat: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Xây dựng prompt với context đầy đủ
     */
    private function buildPrompt($message, $context, $thongtinGV, $thongtinHS, $lopHocs)
    {
        $contextData = "📚 DỮ LIỆU LIÊN QUAN:\n\n";

        if (!empty($context)) {
            foreach ($context as $key => $value) {
                $contextData .= $value . "\n\n";
            }
        } else {
            // Nếu không phát hiện được chủ đề cụ thể, cung cấp dữ liệu chung
            $contextData .= "👩‍🏫 GIÁO VIÊN:\n" . $thongtinGV . "\n\n";
            $contextData .= "🧒 HỌC SINH:\n" . $thongtinHS . "\n\n";
            $contextData .= "🏫 LỚP HỌC:\n" . $lopHocs . "\n\n";
        }

        $prompt = <<<PROMPT
🌸 BẠN LÀ MAMNON AI - TRỢ LÝ ẢO CHUYÊN NGHIỆP CỦA TRƯỜNG MẦM NON HOA SEN

📋 MỤC TIÊU:
Cung cấp thông tin ĐẦY ĐỦ, CHÍNH XÁC nhưng RẤT NGẮN GỌN, SÚC TÍCH. Tránh văn hoa dài dòng.

🎯 YÊU CẦU TRẢ LỜI:

1. **Nguyên tắc cốt lõi:**
   - **TRỰC DIỆN**: Trả lời thẳng vào câu hỏi.
   - **ĐẦY ĐỦ**: Không bỏ sót dữ liệu quan trọng (số tiền, ngày tháng, tên món).
   - **NGẮN GỌN**: Viết câu đơn giản, cô đọng.

2. **Cấu trúc câu trả lời:**
   - **Mở bài**: Chỉ chào xã giao 1 dòng nếu cần thiết.
   - **Thân bài**:
     • Liệt kê thông tin bằng gạch đầu dòng (bullet points) để dễ đọc.
     • Gom nhóm thông tin cùng loại.
   - **Kết bài**: Gợi ý ngắn gọn hoặc lời chúc 1 câu.

3. **Context dữ liệu:**
   - Dựa 100% vào dữ liệu cung cấp bên dưới để trả lời.
   - ⚠️ LƯU Ý QUAN TRỌNG: Nếu câu hỏi về "mấy giờ", "thời gian", hãy tìm trong mục [THÔNG TIN CHUNG & QUY ĐỊNH] hoặc [THỰC ĐƠN/LỊCH TRÌNH] của dữ liệu cung cấp.
   - TUYỆT ĐỐI KHÔNG trả lời giờ hiện tại của hệ thống trừ khi được hỏi "bây giờ là mấy giờ".
   - Nếu không có thông tin: Trả lời trung thực là "Hiện chưa có thông tin...".
   - Sử dụng emoji chừng mực để thân thiện (📅 💰 🍱).

4. **Ví dụ Tốt (Ngắn gọn & Đủ ý):**
   - Q: "Hôm nay bé ăn gì?"
     A: "Dạ, thực đơn hôm nay của bé (20/10):
     • Sáng: Phở bò
     • Trưa: Cơm cá kho, Canh cải
     Mời mẹ tham khảo ạ! 😊"

   - Q: "Mấy giờ đón bé vậy ạ?"
     A: "Dạ, giờ trả trẻ của trường là:
     • Từ 16:30 – 17:30 chiều.
     • Nếu đón muộn sau 17:30, phụ huynh vui lòng báo trước cho cô giáo chủ nhiệm ạ. �"

📊 DỮ LIỆU HỆ THỐNG:
{$contextData}

💬 CÂU HỎI:
"{$message}"

➡️ HÃY TRẢ LỜI NGẮN GỌN, ĐẦY ĐỦ Ý:
PROMPT;

        return $prompt;
    }

    /**
     * Get Bài Viết API
     */
    public function getBaiViet()
    {
        try {
            $data = $this->getBaiVietData();
            return response()->json([
                'success' => true,
                'message' => 'Lấy bài viết thành công',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Chi Tiết Học Phí API
     */
    public function getChiTietHocPhi()
    {
        try {
            $data = $this->getChiTietHocPhiData();
            return response()->json([
                'success' => true,
                'message' => 'Lấy chi tiết học phí thành công',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lấy dữ liệu thông tin chung (FAQ) từ yêu cầu
     */
   private function getThongTinChungData()
{
    return <<<FAQ
🏫 THÔNG TIN CHUNG & QUY ĐỊNH NHÀ TRƯỜNG

────────────────────────
1. ⏰ GIỜ GIẤC & ĐÓN TRẢ TRẺ
────────────────────────
• Giờ đón trẻ: Từ 7:00 sáng.
• Giờ trả trẻ: Từ 16:30 – 17:30 chiều.
• Đón sớm / đón muộn: 
  - Phụ huynh có thể đón sớm trong khung giờ hoạt động.
  - Trường hợp đón muộn sau 17:30 vui lòng báo trước cho giáo viên/nhà trường.
• Người khác đón trẻ: 
  - Phải đăng ký trước với giáo viên chủ nhiệm hoặc gọi điện xác nhận.
  - Nhà trường chỉ bàn giao trẻ khi xác minh đúng người đón.
• Thứ 7 & Chủ nhật:
  - Thứ 7: Có nhận giữ trẻ (đăng ký riêng).
  - Chủ nhật: Trường nghỉ.

────────────────────────
2. 🍽️ ĂN UỐNG & DINH DƯỠNG
────────────────────────
• Số bữa ăn: 3 bữa chính/ngày (Sáng – Trưa – Xế chiều) + Sữa/tráng miệng.
• Thực đơn:
  - Xây dựng bởi chuyên viên dinh dưỡng.
  - Đa dạng, cân đối dưỡng chất, thay đổi theo tuần.
  - Đảm bảo vệ sinh an toàn thực phẩm.
• Trẻ dị ứng thực phẩm:
  - Trường có chế độ ăn riêng (phụ huynh cần thông báo chi tiết khi nhập học).
• Trẻ biếng ăn:
  - Giáo viên nhẹ nhàng động viên, hỗ trợ bé ăn đúng cách.
  - Không ép buộc gây tâm lý sợ hãi cho trẻ.
• Công khai thực đơn:
  - Gửi cho phụ huynh hàng tuần qua ứng dụng/Zalo.
  - Niêm yết tại bảng tin của trường.

────────────────────────
3. 🧒 CHĂM SÓC & SINH HOẠT
────────────────────────
• Sĩ số lớp: 15 – 20 bé/lớp (tùy độ tuổi).
• Giáo viên phụ trách: 2 – 3 giáo viên/lớp.
• Chăm sóc sức khỏe:
  - Khi bé có dấu hiệu sốt/mệt sẽ được đưa xuống phòng y tế theo dõi.
  - Nhân viên y tế chăm sóc và thông báo ngay cho phụ huynh.
• Ngủ trưa:
  - Mỗi bé có giường/nệm riêng.
  - Phòng ngủ thoáng mát, sạch sẽ, đảm bảo yên tĩnh.
• Camera giám sát:
  - Camera trực tuyến 24/7.
  - Phụ huynh được cấp tài khoản theo dõi khi bé nhập học.
• Bé mới đi học:
  - Giáo viên có chuyên môn tâm lý mầm non.
  - Hỗ trợ bé làm quen môi trường từng bước, tạo cảm giác an toàn.

────────────────────────
4. 📚 CHƯƠNG TRÌNH HỌC
────────────────────────
• Chương trình giáo dục:
  - Theo chuẩn Bộ Giáo dục & Đào tạo.
  - Kết hợp phương pháp giáo dục hiện đại (Montessori / Reggio Emilia theo từng khối lớp).
• Tiếng Anh:
  - Làm quen tiếng Anh 2 buổi/tuần.
  - Giáo viên chuyên môn hoặc giáo viên bản ngữ.
• Kỹ năng sống:
  - Rèn luyện kỹ năng tự phục vụ, giao tiếp, xử lý tình huống, thoát hiểm.
• Hoạt động ngoại khóa:
  - Tham quan, dã ngoại, trải nghiệm thực tế: 1 lần/học kỳ.
• Theo dõi & báo cáo:
  - Sổ liên lạc điện tử cập nhật tình hình học tập – sinh hoạt hàng ngày/tuần.

────────────────────────
5. 👩‍🏫 ĐỘI NGŨ GIÁO VIÊN
────────────────────────
• Trình độ:
  - 100% giáo viên có bằng Sư phạm Mầm non chính quy.
  - Có chứng chỉ sơ cấp cứu và chăm sóc trẻ.
• Kinh nghiệm:
  - Trung bình trên 3 năm kinh nghiệm giảng dạy.
• Đào tạo:
  - Tập huấn, bồi dưỡng chuyên môn định kỳ 6 tháng/lần.
• Trao đổi với phụ huynh:
  - Trực tiếp vào giờ đón – trả trẻ.
  - Qua Zalo hoặc ứng dụng nhà trường.

────────────────────────
6. 🏛️ LỊCH SỬ & UY TÍN NHÀ TRƯỜNG
────────────────────────
• Năm thành lập: 2026.
• Loại hình: Trường mầm non tư thục chất lượng cao.
• Pháp lý:
  - Được cấp phép hoạt động đầy đủ bởi Phòng Giáo dục & Đào tạo.
• An toàn:
  - Đạt tiêu chuẩn an toàn trường học.
  - Hệ thống PCCC, camera giám sát 24/7.
  - Môi trường học tập an toàn – thân thiện – lành mạnh.

────────────────────────
7. 💰 HỌC PHÍ & TUYỂN SINH
────────────────────────
• Học phí:
  - Xem chi tiết tại mục “Học phí” trong ứng dụng nhà trường.
• Học phí bao gồm:
  - Tiền học và tiền ăn.
  - Không bao gồm: Phí cơ sở vật chất đầu năm và đồng phục.
• Nghỉ học:
  - Hoàn tiền ăn nếu phụ huynh báo nghỉ trước 8:00 sáng.
• Hồ sơ nhập học:
  - Đơn xin học.
  - Bản sao Giấy khai sinh.
  - Hộ khẩu hoặc Giấy tạm trú.
  - Giấy khám sức khỏe của bé.

💬 Nhà trường luôn sẵn sàng hỗ trợ và giải đáp mọi thắc mắc của Quý Phụ huynh!
FAQ;
}

}
