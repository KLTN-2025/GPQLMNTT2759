<?php

use App\Http\Controllers\BaiVietController;
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
use App\Http\Controllers\HocPhiController;
use App\Http\Controllers\SucKhoeController;
use App\Http\Controllers\DongHocPhiController;
use App\Http\Controllers\NamHocController;
use App\Http\Controllers\ThongBaoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// API PAYOS
Route::post('/payos/create-payment', [PayosController::class, 'create']);
Route::get('/payos/payment-info/{id}', [PayosController::class, 'getInfo']);
Route::post('/payos/webhook', [PayosController::class, 'webhook']);

// API PAYMENT
Route::post('/payment/create-hoc-phi', [PaymentController::class, 'createHocPhiPayment']);
Route::post('/payment/create-custom', [PaymentController::class, 'createCustomPayment']);
Route::get('/payment/info', [PaymentController::class, 'getPaymentInfo']);
Route::post('/payment/cancel', [PaymentController::class, 'cancelPayment']);
Route::post('/payment/webhook', [PaymentController::class, 'handleWebhook']);
Route::get('/payment/hoc-phi-list', [PaymentController::class, 'getHocPhiPayments']);

// ADMIN API
// Login
Route::post('admin/login', [NhanVienController::class, 'login']);
Route::get('admin/logout', [NhanVienController::class, 'logout']);
Route::post('admin/forget-password', [NhanVienController::class, 'ForgotPassword']);
Route::post('admin/reset-password', [NhanVienController::class, 'passwordReset']);

Route::group(['prefix' => 'admin'], function () {

    // Check
    Route::get('/check-token', [NhanVienController::class, 'checkToken']);
    // Profile
    Route::get('/profile/data', [NhanVienController::class, 'getProfile']);
    Route::post('/profile/update', [NhanVienController::class, 'updateProfile']);
    Route::post('/profile/change-password', [NhanVienController::class, 'changePassword']);
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
    Route::get('/phan-quyen/data/{id}', [PhanQuyenController::class, 'getData']);
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

    // Thực Đơn
    Route::get('/thuc-don/data', [ThucDonController::class, 'getData']);
    Route::post('/thuc-don/create', [ThucDonController::class, 'store']);
    Route::post('/thuc-don/update', [ThucDonController::class, 'update']);
    Route::post('/thuc-don/delete', [ThucDonController::class, 'destroy']);
    Route::post('/thuc-don/search', [ThucDonController::class, 'search']);
    Route::post('/thuc-don/statistical', [ThucDonController::class, 'statistical']);
    Route::post('/thuc-don/change-status', [ThucDonController::class, 'changeStatus']);

    // Thông Báo
    Route::get('/thong-bao/data', [ThongBaoController::class, 'getData']);
    Route::post('/thong-bao/create', [ThongBaoController::class, 'store']);
    Route::post('/thong-bao/update', [ThongBaoController::class, 'update']);
    Route::post('/thong-bao/delete', [ThongBaoController::class, 'destroy']);
    Route::post('/thong-bao/search', [ThongBaoController::class, 'search']);
    Route::post('/thong-bao/statistical', [ThongBaoController::class, 'statistical']);
    Route::post('/thong-bao/change-status', [ThongBaoController::class, 'changeStatus']);

    // Bài Viết
    Route::get('/bai-viet/data', [BaiVietController::class, 'getData']);
    Route::post('/bai-viet/create', [BaiVietController::class, 'store']);
    Route::post('/bai-viet/update', [BaiVietController::class, 'update']);
    Route::post('/bai-viet/delete', [BaiVietController::class, 'destroy']);
    Route::post('/bai-viet/search', [BaiVietController::class, 'search']);
    Route::post('/bai-viet/statistical', [BaiVietController::class, 'statistical']);
    Route::post('/bai-viet/change-status', [BaiVietController::class, 'changeStatus']);
});

// GIÁO VIÊN   API
Route::post('teacher/login', [GiaoVienController::class, 'login']);
Route::post('teacher/logout', [GiaoVienController::class, 'logout']);
Route::post('teacher/forget-password', [GiaoVienController::class, 'ForgotPassword']);
Route::post('teacher/reset-password', [GiaoVienController::class, 'passwordReset']);

Route::group(['prefix' => 'teacher'], function () {

    // Check
    Route::get('/check-token', [GiaoVienController::class, 'checkToken']);

    // Profile
    Route::get('/profile/data', [GiaoVienController::class, 'getDataProfile']);
    Route::post('/profile/update', [GiaoVienController::class, 'updateProfile']);

    // My Class
    Route::get('/my-classes', [LopHocController::class, 'getMyClasses']);
    Route::get('/my-class/data', [LopHocController::class, 'getDataClass']);
    // Route::post('/my-class/create', [LopHocController::class, 'storeHocSinh']);
    Route::post('/my-class/update', [LopHocController::class, 'updateHocSinh']);
    // Route::post('/my-class/delete', [LopHocController::class, 'destroyHocSinh']);
    Route::post('/my-class/search', [LopHocController::class, 'searchHocSinh']);
    Route::post('/my-class/change-status', [LopHocController::class, 'changeStatusHocSinh']);

    // Học Sinh
});

// PHỤ HUYNH   API
Route::post('login', [PhuHuynhController::class, 'login']);
Route::post('logout', [PhuHuynhController::class, 'logout']);
Route::post('forget-password', [PhuHuynhController::class, 'ForgotPassword']);
Route::post('reset-password', [PhuHuynhController::class, 'passwordReset']);

Route::group(['prefix' => 'phu-huynh'], function () {

    // Check
    Route::get('/check-token', [PhuHuynhController::class, 'checkToken']);

    // Profile
    Route::get('/profile/data', [PhuHuynhController::class, 'getDataProfile']);
    Route::post('/profile/update', [PhuHuynhController::class, 'updateProfile']);
    Route::post('/register', [PhuHuynhController::class, 'register']);

    // bai viet



});

// ChatBot
Route::post('/tu-van-ai', [ChatController::class, 'tuvanAI']);

//Thực đơn
Route::get('/thuc-don', [ThucDonController::class, 'getThucDon']);
Route::post('/thuc-don/update', [ThucDonController::class, 'updateThucDon']);
Route::post('/thuc-don/create', [ThucDonController::class, 'createThucDon']);
Route::post('/thuc-don/delete', [ThucDonController::class, 'deleteThucDon']);
Route::post('/thuc-don/search', [ThucDonController::class, 'searchThucDon']);
Route::post('/thuc-don/changes', [ThucDonController::class, 'changesThucDon']);
//Chi Tiết Thực đơn
Route::get('/chi-tiet-thuc-don', [ChiTietThucDonController::class, 'getChiTietThucDon']);
Route::post('/chi-tiet-thuc-don/update', [ChiTietThucDonController::class, 'updateChiTietThucDon']);
Route::post('/chi-tiet-thuc-don/create', [ChiTietThucDonController::class, 'createChiTietThucDon']);
Route::post('/chi-tiet-thuc-don/delete', [ChiTietThucDonController::class, 'deleteChiTietThucDon']);
Route::post('/chi-tiet-thuc-don/search', [ChiTietThucDonController::class, 'searchChiTietThucDon']);
Route::post('/chi-tiet-thuc-don/changes', [ChiTietThucDonController::class, 'changesChiTietThucDon']);

//Món ăn
Route::get('/mon-an', [MonAnController::class, 'getMonAn']);
Route::post('/mon-an/update', [MonAnController::class, 'updateMonAn']);
Route::post('/mon-an/create', [MonAnController::class, 'createMonAn']);
Route::post('/mon-an/delete', [MonAnController::class, 'deleteMonAn']);
Route::post('/mon-an/search', [MonAnController::class, 'searchMonAn']);
Route::post('/mon-an/changes', [MonAnController::class, 'changesMonAn']);

//Bữa ăn
Route::post('/bua-an', [BuaAnController::class, 'getBuaAn']);
Route::post('/bua-an/create', [BuaAnController::class, 'createBuaAn']);
Route::post('/bua-an/update', [BuaAnController::class, 'updateBuaAn']);
Route::post('/bua-an/delete', [BuaAnController::class, 'deleteBuaAn']);
Route::post('/bua-an/search', [BuaAnController::class, 'searchBuaAn']);
Route::post('/bua-an/changes', [BuaAnController::class, 'changesBuaAn']);

//Sức khỏe
Route::post('/suc-khoe', [SucKhoeController::class, 'getSucKhoe']);
Route::post('/suc-khoe/create', [SucKhoeController::class, 'createSucKhoe']);
Route::post('/suc-khoe/update', [SucKhoeController::class, 'updateSucKhoe']);
Route::post('/suc-khoe/delete', [SucKhoeController::class, 'deleteSucKhoe']);
Route::post('/suc-khoe/search', [SucKhoeController::class, 'searchSucKhoe']);
Route::post('/suc-khoe/changes', [SucKhoeController::class, 'changesSucKhoe']);

//Học Phí
Route::post('/hoc-phi', [HocPhiController::class, 'getHocPhi']);
Route::post('/hoc-phi/create', [HocPhiController::class, 'createHocPhi']);
Route::post('/hoc-phi/update', [HocPhiController::class, 'updateHocPhi']);
Route::post('/hoc-phi/delete', [HocPhiController::class, 'deleteHocPhi']);
Route::post('/hoc-phi/search', [HocPhiController::class, 'searchHocPhi']);
Route::post('/hoc-phi/changes', [HocPhiController::class, 'changesHocPhi']);

//Đóng Học Phí
Route::get('/dong-hoc-phi', [DongHocPhiController::class, 'getDongHocPhi']);
Route::post('/dong-hoc-phi/create', [DongHocPhiController::class, 'createDongHocPhi']);
Route::post('/dong-hoc-phi/update', [DongHocPhiController::class, 'updateDongHocPhi']);
Route::post('/dong-hoc-phi/delete', [DongHocPhiController::class, 'deleteDongHocPhi']);
Route::post('/dong-hoc-phi/search', [DongHocPhiController::class, 'searchDongHocPhi']);
Route::post('/dong-hoc-phi/changes', [DongHocPhiController::class, 'changesDongHocPhi']);
