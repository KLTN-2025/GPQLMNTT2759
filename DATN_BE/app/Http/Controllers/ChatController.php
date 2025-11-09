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

    /**
     * Lấy danh sách học sinh
     */
    private function layThongTinHocSinh()
    {
        $items = HocSinh::limit(50)->get();
        if ($items->isEmpty()) return "Hiện chưa có thông tin học sinh trong hệ thống.";

        $txt = " DANH SÁCH HỌC SINH:\n";
        foreach ($items as $hs) {
            $ten = $hs->ho_va_ten ?? 'N/A';
            $ns = $hs->ngay_sinh ?? 'N/A';
            $lop = $hs->id_lop_hoc ?? 'N/A';
            $txt .= "- {$ten} | NS: {$ns} | Lớp: {$lop}\n";
        }
        return $txt;
    }

    /**
     * Lấy danh sách giáo viên
     */
    private function layThongTinGiaoVien()
    {
        $giaoviens = GiaoVien::where('tinh_trang', 1)->get();
        if ($giaoviens->isEmpty()) {
            return "Hiện chưa có thông tin giáo viên trong hệ thống.";
        }

        $txt = " DANH SÁCH GIÁO VIÊN:\n";
        foreach ($giaoviens as $gv) {
            $ten = $gv->ho_va_ten ?? 'Chưa có tên';
            $cm = $gv->chuyen_mon ?? 'Chưa rõ chuyên môn';
            $lop = $gv->lop_phu_trach ?? 'Chưa rõ lớp';
            $txt .= "- {$ten} | Chuyên môn: {$cm} | Phụ trách: {$lop}\n";
        }
        return $txt;
    }

    /**
     * Lấy danh sách Lớp học
     */
    private function layDanhSachLopHoc()
    {
        $lopHocs = LopHoc::where('is_block', false)->get();
        if ($lopHocs->isEmpty()) {
            return "Hiện chưa có thông tin lớp học trong hệ thống.";
        }

        $txt = " DANH SÁCH LỚP HỌC:\n";
        foreach ($lopHocs as $lop) {
            $tenLop = $lop->ten_lop ?? 'Chưa đặt tên';
            $khoiLop = $lop->id_khoi_lop ?? 'Chưa xác định';
            $namHoc = $lop->id_nam_hoc ?? 'Chưa xác định';
            $soLuong = $lop->so_luong ?? 0;
            $tinhTrang = $lop->is_block ? 'Đã khóa' : 'Đang hoạt động';

            $gv = GiaoVien::find($lop->id_giao_vien);
            $tenGV = $gv ? $gv->ho_va_ten : 'Chưa có giáo viên phụ trách';

            $txt .= "- Lớp: {$tenLop} | Khối: {$khoiLop} | Năm: {$namHoc}\n";
            $txt .= "   Giáo viên: {$tenGV} | Số lượng: {$soLuong} | Trạng thái: {$tinhTrang}\n";
        }

        return $txt;
    }

    /**
     *  Lấy danh sách Bữa ăn
     */
    private function layBuaAn()
    {
        $buaAns = BuaAn::all();
        if ($buaAns->isEmpty()) {
            return " Hiện chưa có thông tin bữa ăn trong hệ thống.";
        }

        $txt = " DANH SÁCH CÁC BỮA ĂN TRONG NGÀY:\n\n";
        foreach ($buaAns as $bua) {
            $tenBua = $bua->ten_bua_an ?? 'Chưa đặt tên';
            $moTa = $bua->mo_ta ?? 'Không có mô tả';
            $txt .= " {$tenBua}\n";
            $txt .= "    Mô tả: {$moTa}\n\n";
        }
        $txt .= " Tổng cộng: {$buaAns->count()} bữa ăn.";
        return $txt;
    }

    /**
     *  Lấy danh sách Món ăn
     */
    private function layMonAn()
    {
        $monAns = \App\Models\MonAn::all();

        if ($monAns->isEmpty()) {
            return " Hiện chưa có thông tin món ăn trong hệ thống.";
        }

        $txt = " *DANH SÁCH MÓN ĂN:*\n\n";
        foreach ($monAns as $mon) {
            $tenMon = $mon->ten_mon ?? 'Chưa đặt tên';
            $loaiMon = $mon->loai_mon ?? 'Không rõ loại';
            $nguonGoc = $mon->nguon_goc ?? 'Không rõ nguồn gốc';
            $moTa = $mon->mo_ta ?? 'Không có mô tả';
            $calo = $mon->calo ?? 0;
            $protein = $mon->protein ?? 0;
            $carb = $mon->carb ?? 0;
            $fat = $mon->fat ?? 0;

            $txt .= " *{$tenMon}*\n";
            $txt .= " Loại: {$loaiMon}\n";
            $txt .= " Nguồn gốc: {$nguonGoc}\n";
            $txt .= " Calo: {$calo} kcal\n";
            $txt .= " P: {$protein}g | C: {$carb}g | F: {$fat}g\n";
            $txt .= " Mô tả: {$moTa}\n\n";
        }

        $txt .= " Tổng cộng: {$monAns->count()} món ăn.";
        return $txt;
    }



    /**
     *  Lấy danh sách Thực đơn (chuẩn theo model & seeder)
     */
    private function layDanhSachThucDon()
    {
        $thucDons = ThucDon::orderBy('ngay', 'asc')->get();

        if ($thucDons->isEmpty()) {
            return "🍽 Hiện chưa có thông tin thực đơn trong hệ thống.";
        }

        $txt = "📅 DANH SÁCH THỰC ĐƠN TRONG TUẦN:\n\n";

        foreach ($thucDons as $td) {
            $ten = $td->ten_thuc_don ?? 'Chưa đặt tên';
            $ngay = $td->ngay ? date('d/m/Y', strtotime($td->ngay)) : 'Chưa có ngày';
            $moTa = $td->mo_ta ?? 'Không có mô tả';

            $txt .= "🍱 {$ten}\n";
            $txt .= "   📆 Ngày áp dụng: {$ngay}\n";
            $txt .= "   📋 Mô tả: {$moTa}\n\n";
        }

        $txt .= "✅ Tổng cộng: {$thucDons->count()} thực đơn.";
        return $txt;
    }



    /**
     * Lấy danh sách chi tiết thực đơn kèm thông tin liên quan
     */
    private function layChiTietThucDon()
    {
        // Lấy danh sách chi tiết thực đơn, có liên kết với các bảng khác nếu cần
        $chiTietThucDon = \App\Models\ChiTietThucDon::query()
            ->join('thuc_dons', 'chi_tiet_thuc_dons.id_thuc_don', '=', 'thuc_dons.id')
            ->join('mon_ans', 'chi_tiet_thuc_dons.id_mon_an', '=', 'mon_ans.id')
            ->join('bua_ans', 'chi_tiet_thuc_dons.id_bua_an', '=', 'bua_ans.id')
            ->select(
                'chi_tiet_thuc_dons.id',
                'chi_tiet_thuc_dons.id_thuc_don',
                'thuc_dons.ten_thuc_don',
                'bua_ans.ten_bua_an',
                'mon_ans.ten_mon_an',
                'chi_tiet_thuc_dons.so_luong',
                'chi_tiet_thuc_dons.ghi_chu'
            )
            ->orderBy('id_thuc_don')
            ->get();

        // Nếu không có dữ liệu
        if ($chiTietThucDon->isEmpty()) {
            return "Hiện tại chưa có chi tiết thực đơn nào trong hệ thống.";
        }

        // Chuyển dữ liệu thành định dạng thân thiện cho AI xử lý/gợi ý
        $ketQua = "Danh sách chi tiết thực đơn:\n";
        foreach ($chiTietThucDon as $ct) {
            $ketQua .= "- [Thực đơn {$ct->id_thuc_don} - {$ct->ten_thuc_don}] "
                . "{$ct->ten_bua_an}: {$ct->ten_mon_an} "
                . "(Số lượng: {$ct->so_luong})";
            if (!empty($ct->ghi_chu)) {
                $ketQua .= " — Ghi chú: {$ct->ghi_chu}";
            }
            $ketQua .= "\n";
        }

        return $ketQua;
    }



    /**
     * *  Lưu lịch sử chat
     */
    public function luuLichSuChat($nguoi_dung_id, $noi_dung, $la_bot = false)
    {
        if (empty($noi_dung)) $noi_dung = '[Không có nội dung]';

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
    private function layLichSuChat()
    {
        return LichSuChat::where('nguoi_gui', $this->BOT_ID)
            ->orWhere('nguoi_nhan', $this->BOT_ID)
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($chat) {
                return [
                    'role' => $chat->nguoi_gui === $this->BOT_ID ? 'assistant' : 'user',
                    'content' => $chat->noi_dung ?? '[Không có nội dung]'
                ];
            })
            ->toArray();
    }

    /**
     * ✅ Gọi API Gemini để tư vấn phụ huynh (thêm dữ liệu bữa ăn)
     */
    public function tuvanAI(Request $request)
    {
        $api_key = env('API_KEY_GEMINI');
        if (!$api_key) {
            return response()->json(['success' => false, 'message' => 'Thiếu API_KEY_GEMINI trong .env'], 500);
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

        // --- Giới hạn dữ liệu demo ---
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

        $buaAns = BuaAn::take(5)->get()
            ->map(fn($bua) => "- {$bua->ten_bua_an}: {$bua->mo_ta}")
            ->implode("\n");

        $thucDons = ThucDon::orderBy('ngay', 'asc')->take(5)->get()
            ->map(fn($td) => "- {$td->ten_thuc_don} (Ngày: " . ($td->ngay ? date('d/m/Y', strtotime($td->ngay)) : 'N/A') . "): {$td->mo_ta}")
            ->implode("\n");

        $chiTietThucDon = ChiTietThucDon::take(5)->get()
            ->map(fn($ct) => "- Thực đơn ID {$ct->id_thuc_don} | Bữa ăn: {$ct->id_bua_an} | Món ăn: {$ct->id_mon_an} | Số lượng: {$ct->so_luong}")
            ->implode("\n");

        $monAns = MonAn::take(5)->get()
            ->map(fn($mon) => "- {$mon->ten_mon} | Loại: {$mon->loai_mon} | Nguồn gốc: {$mon->nguon_goc} | Calo: {$mon->calo} kcal")
            ->implode("\n");


        // --- Tạo prompt gửi Gemini ---
       $prompt = <<<PROMPT
Bạn là "MAMNON AI" – trợ lý ảo thân thiện của Hệ thống Quản lý Trường Mầm Non Hoa Sen 🌸.
Bạn đóng vai như một giáo viên/nhân viên tư vấn của trường, luôn nhẹ nhàng, thân mật và chuyên nghiệp.

🎯 Nhiệm vụ:
- Giải đáp thắc mắc của phụ huynh, giáo viên hoặc quản lý trường.
- Có thể cung cấp thêm thông tin liên quan đến học sinh, giáo viên, lớp học, bữa ăn, thực đơn, món ăn hoặc hoạt động trong ngày.
- Khi trả lời, hãy nói tự nhiên, không dùng ký tự markdown (** hoặc #), và tránh liệt kê khô khan.
- Có thể thêm cảm xúc nhẹ nhàng như “ạ”, “nhé”, “nha”, “ạ!” để thân thiện hơn.

🧩 Nguyên tắc trả lời:
1. Trả lời bằng **tiếng Việt đơn giản, dễ hiểu, phù hợp với môi trường mầm non**.
2. Nếu dữ liệu chưa có hoặc không rõ, hãy nói rõ:
   👉 “Hiện tại mình chưa có thông tin này, bạn có muốn mình kiểm tra thêm không ạ?”
3. Không trả lời các câu hỏi không liên quan đến trường học hoặc nội dung không phù hợp.
4. Luôn hướng người dùng đến thông tin hữu ích, ví dụ:
   - Gợi ý món ăn phù hợp cho trẻ
   - Lịch học hoặc hoạt động trong ngày
   - Cách liên hệ giáo viên hoặc quản lý

📚 Dữ liệu nội bộ (tóm tắt ngắn gọn):

👩‍🏫 Giáo viên:
$thongtinGV

🧒 Học sinh:
$thongtinHS

🏫 Lớp học:
$lopHocs

🍽️ Bữa ăn:
$buaAns

🥗 Món ăn:
$monAns

📅 Thực đơn:
$thucDons

📘 Chi tiết thực đơn:
$chiTietThucDon

💬 Câu hỏi người dùng:
"$message"

Hãy phản hồi tự nhiên, thân thiện, không dùng markdown, không quá dài (3–5 câu là đủ).
Kết thúc câu trả lời bằng một lời mời nhẹ nhàng, ví dụ:
“Bạn có muốn mình xem thêm thông tin này giúp không ạ?” hoặc “Mình có thể gợi ý thêm nếu bạn muốn nha 🌷.”
PROMPT;

// Giới hạn độ dài để tránh lỗi từ API
if (strlen($prompt) > 9000) {
    $prompt = substr($prompt, 0, 8900) . "\n...[Một phần dữ liệu đã được rút gọn để hệ thống hoạt động ổn định]";
}


        try {
            $client = new Client(['timeout' => 30]);
            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$api_key}";

            $response = $client->post($url, [
                'json' => ['contents' => [['parts' => [['text' => $prompt]]]]],
                'headers' => ['Content-Type' => 'application/json']
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            $ket_qua = $body['candidates'][0]['content']['parts'][0]['text'] ?? 'Xin lỗi, hiện tại MAMNON AI chưa có phản hồi.';

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
}
