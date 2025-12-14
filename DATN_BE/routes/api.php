<?php

use App\Http\Controllers\BaiVietController;
use App\Http\Controllers\BaoCaoController;
use App\Http\Controllers\Api\ChatController as ApiChatController;
use App\Http\Controllers\Api\GroupChatController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChucNangController;
use App\Http\Controllers\ChucVuController;
use App\Http\Controllers\GiaoVienController;
use App\Http\Controllers\HocSinhController;
use App\Http\Controllers\LopHocController;
use App\Http\Controllers\NhanVienController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PayosController;
use App\Http\Controllers\PhanQuyenController;
use App\Http\Controllers\PhuHuynhController;
use App\Http\Controllers\ThucDonController;
use App\Http\Controllers\BuaAnController;
use App\Http\Controllers\MonAnController;
use App\Http\Controllers\ChiTietThucDonController;
use App\Http\Controllers\DiemDanhController;
use App\Http\Controllers\HocPhiController;
use App\Http\Controllers\SucKhoeController;
use App\Http\Controllers\DongHocPhiController;
use App\Http\Controllers\LichLamViecController;
use App\Http\Controllers\NamHocController;
use App\Http\Controllers\ThongBaoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// ADMIN API
// Login
Route::post('admin/login', [NhanVienController::class, 'login']);
Route::get('admin/logout', [NhanVienController::class, 'logout']);
Route::post('/admin/forgot-password', [NhanVienController::class, 'ForgotPassword']);
Route::post('admin/reset-password', [NhanVienController::class, 'passwordReset']);

Route::group(['prefix' => 'admin'], function () {

    // Check
    Route::get('/check-token', [NhanVienController::class, 'checkToken']);

    // Profile
    Route::get('/profile/data', [NhanVienController::class, 'getProfile']);
    Route::post('/profile/update', [NhanVienController::class, 'updateProfile']);
    Route::post('/profile/change-password', [NhanVienController::class, 'changePassword']);
    Route::post('/profile/update-avatar', [NhanVienController::class, 'updateAvatar']);

    //Dashboard



    // Nhân viên
    Route::get('/nhan-vien/data', [NhanVienController::class, 'getData']);
    Route::post('/nhan-vien/create', [NhanVienController::class, 'store']);
    Route::post('/nhan-vien/update', [NhanVienController::class, 'update']);
    Route::post('/nhan-vien/delete', [NhanVienController::class, 'destroy']);
    Route::post('/nhan-vien/search', [NhanVienController::class, 'Search']);
    Route::post('/nhan-vien/change-status', [NhanVienController::class, 'changeStatus']);

    // Giáo viên
    Route::get('/giao-vien/data', [GiaoVienController::class, 'getData']);
    Route::post('/giao-vien/create', [GiaoVienController::class, 'store']);
    Route::post('/giao-vien/update', [GiaoVienController::class, 'update']);
    Route::post('/giao-vien/delete', [GiaoVienController::class, 'destroy']);
    Route::post('/giao-vien/search', [GiaoVienController::class, 'Search']);
    Route::post('/giao-vien/change-status', [GiaoVienController::class, 'changeStatus']);

    // Phụ Huynh
    Route::get('/phu-huynh/data', [PhuHuynhController::class, 'getData']);
    Route::post('/phu-huynh/create', [PhuHuynhController::class, 'store']);
    Route::post('/phu-huynh/update', [PhuHuynhController::class, 'update']);
    Route::post('/phu-huynh/delete', [PhuHuynhController::class, 'destroy']);
    Route::post('/phu-huynh/search', [PhuHuynhController::class, 'search']);
    Route::post('/phu-huynh/change-status', [PhuHuynhController::class, 'changeStatus']);

    // Học Sinh
    Route::get('/hoc-sinh/data', [HocSinhController::class, 'getData']);
    Route::post('/hoc-sinh/create', [HocSinhController::class, 'store']);
    Route::post('/hoc-sinh/update', [HocSinhController::class, 'update']);
    Route::post('/hoc-sinh/delete', [HocSinhController::class, 'destroy']);
    Route::post('/hoc-sinh/search', [HocSinhController::class, 'search']);
    Route::post('/hoc-sinh/change-status', [HocSinhController::class, 'changeStatus']);

    // Chức Vụ
    Route::get('/chuc-vu/data', [ChucVuController::class, 'getData']);
    Route::post('/chuc-vu/create', [ChucVuController::class, 'store']);
    Route::post('/chuc-vu/update', [ChucVuController::class, 'update']);
    Route::post('/chuc-vu/delete', [ChucVuController::class, 'destroy']);
    Route::post('/chuc-vu/change-status', [ChucVuController::class, 'changeStatus']);

    // Chức Năng
    Route::get('/chuc-nang/data', [ChucNangController::class, 'getData']);

    // Phân Quyền
    Route::post('/phan-quyen/data', [PhanQuyenController::class, 'getData']);
    Route::post('/phan-quyen/create', [PhanQuyenController::class, 'store']);
    Route::post('/phan-quyen/delete', [PhanQuyenController::class, 'destroy']);

    //Năm Học
    Route::get('/nam-hoc/data', [NamHocController::class, 'getData']);
    Route::post('/nam-hoc/create', [NamHocController::class, 'store']);
    Route::post('/nam-hoc/update', [NamHocController::class, 'update']);
    Route::post('/nam-hoc/delete', [NamHocController::class, 'destroy']);
    Route::post('/nam-hoc/search', [NamHocController::class, 'search']);
    Route::post('/nam-hoc/change-status', [NamHocController::class, 'changeStatus']);


    // Lớp Học
    Route::get('/lop-hoc/data', [LopHocController::class, 'getData']);
    Route::get('/lop-hoc/chi-tiet-lop/data', [LopHocController::class, 'getDataChiTiet']);
    Route::post('/lop-hoc/create', [LopHocController::class, 'store']);
    Route::post('/lop-hoc/update', [LopHocController::class, 'update']);
    Route::post('/lop-hoc/delete', [LopHocController::class, 'destroy']);
    Route::post('/lop-hoc/search', [LopHocController::class, 'search']);
    Route::post('/lop-hoc/change-status', [LopHocController::class, 'changeStatus']);

    // Sức Khoẻ
    Route::get('/suc-khoe/data', [SucKhoeController::class, 'getData']);
    Route::post('/suc-khoe/create', [SucKhoeController::class, 'store']);
    Route::post('/suc-khoe/update', [SucKhoeController::class, 'update']);
    Route::post('/suc-khoe/delete', [SucKhoeController::class, 'destroy']);
    Route::post('/suc-khoe/search', [SucKhoeController::class, 'search']);
    Route::post('/suc-khoe/statistical', [SucKhoeController::class, 'statistical']);

    // Học Phi
    Route::get('/hoc-phi/data', [HocPhiController::class, 'getData']);
    Route::post('/hoc-phi/create', [HocPhiController::class, 'store']);
    Route::post('/hoc-phi/update', [HocPhiController::class, 'update']);
    Route::post('/hoc-phi/delete', [HocPhiController::class, 'destroy']);
    Route::post('/hoc-phi/search', [HocPhiController::class, 'search']);
    Route::post('/hoc-phi/statistical', [HocPhiController::class, 'statistical']);

    // Chi Tiết Học Phi
    Route::get('/hoc-phi/chi-tiet-hoc-phi/data', [HocPhiController::class, 'getDataChiTietHocPhi']);
    Route::get('/hoc-phi/chi-tiet-hoc-phi/hoc-sinh/data', [HocPhiController::class, 'getDataChiTietHocPhiHocSinh']);

    // Thực Đơn
    Route::get('/thuc-don/data', [ThucDonController::class, 'getData']);
    Route::post('/thuc-don/create', [ThucDonController::class, 'store']);
    Route::post('/thuc-don/update', [ThucDonController::class, 'update']);
    Route::post('/thuc-don/delete', [ThucDonController::class, 'destroy']);
    Route::post('/thuc-don/search', [ThucDonController::class, 'search']);
    Route::post('/thuc-don/statistical', [ThucDonController::class, 'statistical']);
    Route::post('/thuc-don/change-status', [ThucDonController::class, 'changeStatus']);

    // Món Ăn
    Route::get('/mon-an/data', [MonAnController::class, 'getData']);
    Route::post('/mon-an/create', [MonAnController::class, 'store']);
    Route::post('/mon-an/update', [MonAnController::class, 'update']);
    Route::post('/mon-an/delete', [MonAnController::class, 'destroy']);
    Route::post('/mon-an/search', [MonAnController::class, 'search']);
    Route::post('/mon-an/statistical', [MonAnController::class, 'statistical']);
    Route::post('/mon-an/change-status', [MonAnController::class, 'changeStatus']);

    // Thông Báo
    Route::get('/thong-bao/data', [ThongBaoController::class, 'getData']);
    Route::post('/thong-bao/create', [ThongBaoController::class, 'store']);
    Route::post('/thong-bao/add', [ThongBaoController::class, 'store']); // Alias for create
    Route::post('/thong-bao/send', [ThongBaoController::class, 'sendNotification']); // Send to recipients
    Route::post('/thong-bao/update', [ThongBaoController::class, 'update']);
    Route::post('/thong-bao/delete', [ThongBaoController::class, 'destroy']);
    Route::post('/thong-bao/search', [ThongBaoController::class, 'search']);
    Route::post('/thong-bao/statistical', [ThongBaoController::class, 'statistical']);
    Route::post('/thong-bao/change-status', [ThongBaoController::class, 'changeStatus']);

    //laoi bài viet
    Route::get('/loai-bai-viet/data', [BaiVietController::class, 'getLoaiBaiVietData']);

    // Bài Viết
    Route::get('/bai-viet/data', [BaiVietController::class, 'getData']);
    Route::post('/bai-viet/create', [BaiVietController::class, 'store']);
    Route::post('/bai-viet/update', [BaiVietController::class, 'update']);
    Route::post('/bai-viet/delete', [BaiVietController::class, 'destroy']);
    Route::post('/bai-viet/search', [BaiVietController::class, 'search']);
    Route::post('/bai-viet/statistical', [BaiVietController::class, 'statistical']);
    Route::post('/bai-viet/change-status', [BaiVietController::class, 'changeStatus']);

    // Bài Viết
    Route::get('/bao-cao/data', [BaoCaoController::class, 'getData']);
    Route::post('/bao-cao/create', [BaoCaoController::class, 'store']);
    Route::post('/bao-cao/update', [BaoCaoController::class, 'update']);
    Route::post('/bao-cao/delete', [BaoCaoController::class, 'destroy']);
    Route::post('/bao-cao/search', [BaoCaoController::class, 'search']);
    Route::post('/bao-cao/statistical', [BaoCaoController::class, 'statistical']);
    Route::post('/bao-cao/change-status', [BaoCaoController::class, 'changeStatus']);


    // Lịch Làm Việc Nhân Viên
    Route::get('/lich-lam-viec/nhan-vien/data', [LichLamViecController::class, 'getDataLichLamViecNhanVien']);
    Route::post('/lich-lam-viec/nhan-vien/search', [LichLamViecController::class, 'searchLichLamViecNhanVien']);
    Route::post('/lich-lam-viec/nhan-vien/create', [LichLamViecController::class, 'createLichLamViecNhanVien']);
    Route::post('/lich-lam-viec/nhan-vien/ngay-lam-viec', [LichLamViecController::class, 'getNgayLamViecNhanVien']);

    // Lịch Làm Việc Giáo Viên
    Route::get('/lich-lam-viec/giao-vien/data', [LichLamViecController::class, 'getDataLichLamViecGiaoVien']);
    Route::post('/lich-lam-viec/giao-vien/search', [LichLamViecController::class, 'searchLichLamViecGiaoVien']);
    Route::post('/lich-lam-viec/giao-vien/create', [LichLamViecController::class, 'createLichLamViecGiaoVien']);
    Route::post('/lich-lam-viec/giao-vien/ngay-lam-viec', [LichLamViecController::class, 'getNgayLamViecGiaoVien']);

    // Hủy/Xóa Lịch Làm Việc (chung cho cả nhân viên và giáo viên)
    Route::post('/lich-lam-viec/delete', [LichLamViecController::class, 'deleteLichLamViec']);
});

// GIÁO VIÊN   API
Route::post('teacher/login', [GiaoVienController::class, 'login']);
Route::post('teacher/logout', [GiaoVienController::class, 'logout']);
Route::post('teacher/forgot-password', [GiaoVienController::class, 'ForgotPassword']);
Route::post('teacher/reset-password', [GiaoVienController::class, 'passwordReset']);

Route::group(['prefix' => 'teacher'], function () {

    // Check
    Route::get('/check-token', [GiaoVienController::class, 'checkToken']);

    // Profile
    Route::get('/profile/data', [GiaoVienController::class, 'getDataProfile']);
    Route::post('/profile/update', [GiaoVienController::class, 'updateProfile']);
    Route::post('/profile/update-avatar', [GiaoVienController::class, 'updateAvatar']);
    Route::post('/profile/change-password', [GiaoVienController::class, 'changePassword']);

    // My Class
    Route::get('/my-classes', [LopHocController::class, 'getMyClasses']);
    Route::get('/my-class/data', [LopHocController::class, 'getDataClass']);
    Route::post('/my-class/update', [LopHocController::class, 'updateHocSinh']);
    Route::post('/my-class/delete', [LopHocController::class, 'destroyHocSinh']);
    Route::post('/my-class/search', [LopHocController::class, 'searchHocSinh']);
    Route::post('/my-class/change-status', [LopHocController::class, 'changeStatusHocSinh']);
    Route::get('/my-class/phu-huynh/data', [LopHocController::class, 'getDataClassPhuHuynh']);

    // Điểm Danh
    Route::get('/attendance/data', [DiemDanhController::class, 'getAttendanceData']);
    Route::post('/attendance/save', [DiemDanhController::class, 'saveAttendance']);
    // Sức Khoẻ
    Route::get('/suc-khoe/data-by-lop', [SucKhoeController::class, 'getDataByLop']);
    Route::post('/suc-khoe/change-status', [SucKhoeController::class, 'changeStatus']);

    // Lịch Làm Việc (Giáo viên xem và quản lý lịch của chính mình)
    Route::get('/lich-lam-viec/data', [LichLamViecController::class, 'getMyLichLamViec']);
    Route::post('/lich-lam-viec/delete', [LichLamViecController::class, 'deleteMyLichLamViec']);
    Route::post('/lich-lam-viec/create', [LichLamViecController::class, 'createLichLamViecGiaoVien']);

    // Báo Cáo
    Route::get('/bao-cao/data', [BaoCaoController::class, 'getData']);
    Route::post('/bao-cao/create', [BaoCaoController::class, 'store']);
    Route::post('/bao-cao/update', [BaoCaoController::class, 'update']);
    Route::post('/bao-cao/delete', [BaoCaoController::class, 'destroy']);
    Route::post('/bao-cao/search', [BaoCaoController::class, 'search']);
    Route::post('/bao-cao/statistical', [BaoCaoController::class, 'statistical']);
    Route::post('/bao-cao/change-status', [BaoCaoController::class, 'changeStatus']);

    // User Info
    Route::get('/user-info', [GiaoVienController::class, 'getUserInfo']);


    // Chat với phụ huynh
    Route::get('/chat/conversations', [ApiChatController::class, 'getConversations']);
    Route::get('/chat/messages/{conversationId}', [ApiChatController::class, 'getMessages']);
    Route::post('/chat/send-message', [ApiChatController::class, 'sendMessage']);
    Route::post('/chat/mark-as-read/{conversationId}', [ApiChatController::class, 'markAsRead']);
    Route::get('/chat/conversation/{parentId}', [ApiChatController::class, 'getOrCreateConversation']);

    // Group chat routes
    Route::get('/group-chat/my-class', [GroupChatController::class, 'getMyClassGroupChat']);
    Route::get('/group-chat/{groupId}/messages', [GroupChatController::class, 'getMessages']);
    Route::post('/group-chat/{groupId}/send', [GroupChatController::class, 'sendMessage']);
    Route::post('/group-chat/{groupId}/mark-read', [GroupChatController::class, 'markAsRead']);
    Route::get('/group-chat/{groupId}/unread-count', [GroupChatController::class, 'getUnreadCount']);
    Route::get('/group-chat/{groupId}/participants', [GroupChatController::class, 'getParticipants']);
});

// PHỤ HUYNH   API
Route::post('login', [PhuHuynhController::class, 'login']);
Route::post('logout', [PhuHuynhController::class, 'logout']);
Route::post('phu-huynh/forgot-password', [PhuHuynhController::class, 'ForgotPassword']);
Route::post('phu-huynh/reset-password', [PhuHuynhController::class, 'passwordReset']);

Route::group(['prefix' => 'phu-huynh'], function () {

    // Check
    Route::get('/check-token', [PhuHuynhController::class, 'checkToken']);

    // Profile
    Route::get('/profile/data', [PhuHuynhController::class, 'getDataProfile']);
    Route::post('/profile/update', [PhuHuynhController::class, 'updateProfile']);
    Route::post('/profile/update-avatar', [PhuHuynhController::class, 'updateAvatar']);
    Route::post('/register', [PhuHuynhController::class, 'register']);
    Route::post('/profile/changePassword', [PhuHuynhController::class, 'changePassword']);

    // Chat với giáo viên
    Route::get('/chat/conversations', [ApiChatController::class, 'getConversations']);
    Route::get('/chat/messages/{conversationId}', [ApiChatController::class, 'getMessages']);
    Route::post('/chat/send-message', [ApiChatController::class, 'sendMessage']);
    Route::post('/chat/mark-as-read/{conversationId}', [ApiChatController::class, 'markAsRead']);
    Route::get('/chat/conversation/{teacherId}', [ApiChatController::class, 'getOrCreateConversation']);

    // Group chat với lớp của con
    Route::get('/group-chat/my-classes', [GroupChatController::class, 'getMyClassesForParent']);
    Route::get('/group-chat/{groupId}/messages', [GroupChatController::class, 'getMessages']);
    Route::post('/group-chat/{groupId}/send', [GroupChatController::class, 'sendMessage']);
    Route::post('/group-chat/{groupId}/mark-read', [GroupChatController::class, 'markAsRead']);
    Route::get('/group-chat/{groupId}/unread-count', [GroupChatController::class, 'getUnreadCount']);
    Route::get('/group-chat/{groupId}/participants', [GroupChatController::class, 'getParticipants']);
});

// CLIENT API (Alias for Phu Huynh routes)
Route::post('client/login', [PhuHuynhController::class, 'login']);
Route::get('client/logout', [PhuHuynhController::class, 'logout']);

Route::group(['prefix' => 'client'], function () {
    // Check token
    Route::get('/check-token', [PhuHuynhController::class, 'checkToken']);

    // Profile
    Route::get('/profile/data', [PhuHuynhController::class, 'getDataProfile']);
    Route::post('/profile/update', [PhuHuynhController::class, 'updateProfile']);
    Route::post('/profile/update-avatar', [PhuHuynhController::class, 'updateAvatar']);
    Route::post('/profile/changePassword', [PhuHuynhController::class, 'changePassword']);

    // Chat với giáo viên
    Route::get('/chat/conversations', [ApiChatController::class, 'getConversations']);
    Route::get('/chat/messages/{conversationId}', [ApiChatController::class, 'getMessages']);
    Route::post('/chat/send-message', [ApiChatController::class, 'sendMessage']);
    Route::post('/chat/mark-as-read/{conversationId}', [ApiChatController::class, 'markAsRead']);
    Route::get('/chat/conversation/{teacherId}', [ApiChatController::class, 'getOrCreateConversation']);

    // Group chat với lớp của con
    Route::get('/group-chat/my-classes', [GroupChatController::class, 'getMyClassesForParent']);
    Route::get('/group-chat/{groupId}/messages', [GroupChatController::class, 'getMessages']);
    Route::post('/group-chat/{groupId}/send', [GroupChatController::class, 'sendMessage']);
    Route::post('/group-chat/{groupId}/mark-read', [GroupChatController::class, 'markAsRead']);
    Route::get('/group-chat/{groupId}/unread-count', [GroupChatController::class, 'getUnreadCount']);
    Route::get('/group-chat/{groupId}/participants', [GroupChatController::class, 'getParticipants']);

    // Bài viết
    Route::get('/bai-viet/data', [BaiVietController::class, 'getData']);
});


// ChatBot - AI Tư vấn
Route::post('/tu-van-ai', [ChatController::class, 'tuvanAI']);

Route::group(['prefix' => 'chat'], function () {
    // Thực đơn - Lấy theo ngày hoặc tất cả
    Route::post('/thuc-don', [ChatController::class, 'getThucDon']);

    // Chi Tiết Thực đơn - Lấy theo ID thực đơn hoặc tất cả
    Route::post('/chi-tiet-thuc-don', [ChatController::class, 'getChiTietThucDon']);

    // Món ăn - Lấy chi tiết hoặc danh sách
    Route::post('/mon-an', [ChatController::class, 'getMonAn']);

    // Bữa ăn - Lấy danh sách tất cả bữa ăn
    Route::post('/bua-an', [ChatController::class, 'getBuaAn']);

    // Lớp học - Lấy danh sách hoặc chi tiết
    Route::post('/lop-hoc', [ChatController::class, 'getDanhSachLopHoc']);

    // Giáo viên - Lấy danh sách thông tin giáo viên
    Route::post('/giao-vien', [ChatController::class, 'getGiaoVienInfo']);

    // Học sinh - Lấy danh sách thông tin học sinh
    Route::post('/hoc-sinh', [ChatController::class, 'getHocSinhInfo']);

    // Sức khỏe - Lấy thông tin sức khỏe
    Route::post('/suc-khoe', [ChatController::class, 'getSucKhoe']);

    // Học Phí - Lấy thông tin học phí
    Route::post('/hoc-phi', [ChatController::class, 'getHocPhi']);

    // Đóng Học Phí - Lấy thông tin đóng học phí theo học sinh
    Route::post('/dong-hoc-phi', [ChatController::class, 'getDongHocPhi']);

    // Thông Báo - Lấy danh sách thông báo mới
    Route::post('/thong-bao', [ChatController::class, 'getData']);

    // Profile Giáo Viên
    Route::post('/profile', [ChatController::class, 'getDataProfile']);

    // Lịch sử Chat - Lấy cuộc trò chuyện trước
    Route::post('/history', [ChatController::class, 'getChatHistory']);

    // Bài Viết - Lấy tin tức/bài viết mới
    Route::post('/bai-viet', [ChatController::class, 'getBaiViet']);

    // Chi Tiết Học Phí - Lấy chi tiết các khoản phí
    Route::post('/chi-tiet-hoc-phi', [ChatController::class, 'getChiTietHocPhi']);
});
