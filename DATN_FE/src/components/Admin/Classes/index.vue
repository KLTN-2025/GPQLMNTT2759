<template>
    <div class="page-header education-theme">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-header-content">
                        <div class="page-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div class="page-info">
                            <h1 class="page-title">Quản lý Lớp Học</h1>
                            <p class="page-subtitle">
                                Quản lý thông tin lớp học trong hệ thống
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <nav class="breadcrumb-nav">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <i class="fas fa-school"></i>
                                <a href="javascript: void(0);">Quản lý</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="fas fa-graduation-cap"></i>
                                Lớp Học
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stats-card stats-primary">
                <div class="stats-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number">{{ list_lop_hoc.length }}</h3>
                    <p class="stats-label">Tổng Lớp Học</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card stats-success">
                <div class="stats-icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number">
                        {{list_lop_hoc.filter((lh) => lh.tinh_trang == 1).length}}
                    </h3>
                    <p class="stats-label">Đang Hoạt Động</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card stats-warning">
                <div class="stats-icon">
                    <i class="fas fa-user-pause"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number">
                        {{list_lop_hoc.filter((lh) => lh.tinh_trang == 0).length}}
                    </h3>
                    <p class="stats-label">Tạm Ngừng</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card stats-info">
                <div class="stats-icon">
                    <i class="fas fa-child"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number">{{ getTotalStudents() }}</h3>
                    <p class="stats-label">Tổng Học Sinh</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="management-card" :class="{ 'no-hover': modalOpen }">
                <div class="card-header-custom">
                    <div class="header-content">
                        <div class="header-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div class="header-text">
                            <h5 class="card-title">Danh Sách Lớp Học</h5>
                            <p class="card-subtitle">Quản lý thông tin lớp học hệ thống</p>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-modern" data-bs-toggle="modal" data-bs-target="#themModal">
                        <i class="fas fa-plus"></i>
                        Thêm Lớp Học
                    </button>
                </div>

                <div class="card-body">
                    <!-- Search Container -->
                    <div class="search-container mb-4">
                        <div class="search-input-group">
                            <div class="form-search">
                                <div class="search-icon">
                                    <i class="fas fa-search"></i>
                                </div>
                                <input v-on:change="TiemKiem()" v-model="search.noi_dung" type="text"
                                    class="search-input" placeholder="Tìm kiếm theo tên lớp, mã lớp..." />
                            </div>

                            <div class="search-filters">
                                <select v-on:change="TiemKiem()" class="filter-select" v-model="search.tinh_trang">
                                    <option value="">Tất cả trạng thái</option>
                                    <option value="1">Hoạt động</option>
                                    <option value="0">Tạm ngừng</option>
                                </select>
                                <select v-on:change="TiemKiem()" class="filter-select" v-model="search.do_tuoi">
                                    <option value="">Tất cả độ tuổi</option>
                                    <option value="3-4">3-4 tuổi</option>
                                    <option value="4-5">4-5 tuổi</option>
                                    <option value="5-6">5-6 tuổi</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-container">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Lớp Học</th>
                                    <th class="text-center">Thông Tin</th>
                                    <th class="text-center">Giáo Viên</th>
                                    <th class="text-center">Học Sinh</th>
                                    <th class="text-center">Học Phí</th>
                                    <th class="text-center">Trạng Thái</th>
                                    <th class="text-center">Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(value, index) in list_lop_hoc" :key="index">
                                    <tr class="table-row-hover">
                                        <td class="text-center table-index">
                                            {{ index + 1 }}
                                        </td>
                                        <td class="class-info">
                                            <div class="class-container">
                                                <div class="class-icon">
                                                    <i class="fas fa-graduation-cap"></i>
                                                </div>
                                                <div class="class-details">
                                                    <span class="class-name">{{ value.ten_lop }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center class-details-info">
                                            <div class="info-group">
                                                <div class="info-item">
                                                    <i class="fas fa-calendar-alt"></i>
                                                    <span>{{ value.do_tuoi }} tuổi</span>
                                                </div>
                                                <div class="info-item">
                                                    <i class="fas fa-clock"></i>
                                                    <span>{{ value.thoi_gian_hoc }}</span>
                                                </div>
                                                <div class="info-item">
                                                    <i class="fas fa-door-open"></i>
                                                    <span>{{ value.phong_hoc }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="teacher-info">
                                                <div class="teacher-name">{{ value.ten_giao_vien || 'Chưa phân công'
                                                }}</div>
                                                <small class="teacher-role">Chủ nhiệm</small>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="student-count">
                                                <div class="count-number">{{ value.tong_hoc_sinh || 0 }} / {{
                                                    value.so_luong }}</div>
                                            </div>
                                            <div class="progress-bar">
                                                <div class="progress-fill"
                                                    :style="{ width: getStudentPercentage(value) + '%' }"></div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="fee-info">
                                                <div class="fee-amount">{{ formatCurrency(value.hoc_phi) }}</div>
                                                <small class="fee-period">/tháng</small>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <button v-on:click="DoiTrangThai(value)" v-if="value.is_block == 0"
                                                class="btn status-badge status-active">
                                                <i class="fas fa-check-circle"></i>
                                                Hoạt Động
                                            </button>
                                            <button v-on:click="DoiTrangThai(value)" v-else
                                                class="btn status-badge status-inactive">
                                                <i class="fas fa-pause-circle"></i>
                                                Tạm Ngừng
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <div class="action-buttons">
                                                <button class="btn-action btn-edit"
                                                    @click="Object.assign(update_lop_hoc, value)" data-bs-toggle="modal"
                                                    data-bs-target="#capNhatModal" title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn-action btn-view" @click="viewClassDetails(value)"
                                                    title="Xem chi tiết">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn-action btn-delete"
                                                    @click="Object.assign(delete_lop_hoc, value)" data-bs-toggle="modal"
                                                    data-bs-target="#xoaModal" title="Xóa">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Cập Nhật Lớp Học -->
    <div class="modal fade" id="capNhatModal" tabindex="-1" aria-labelledby="capNhatModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="capNhatModalLabel">
                        <i class="fas fa-edit me-2"></i>
                        Cập Nhật Thông Tin Lớp Học
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="updateTenLop" class="form-label">Tên Lớp *</label>
                                    <input type="text" class="form-control" id="updateTenLop"
                                        v-model="update_lop_hoc.ten_lop" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="updateMaLop" class="form-label">Mã Lớp *</label>
                                    <input type="text" class="form-control" id="updateMaLop"
                                        v-model="update_lop_hoc.ma_lop" required />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="updateDoTuoi" class="form-label">Độ Tuổi *</label>
                                    <select class="form-select" id="updateDoTuoi" v-model="update_lop_hoc.do_tuoi"
                                        required>
                                        <option value="">Chọn độ tuổi</option>
                                        <option value="3-4">3-4 tuổi (Lớp Mầm)</option>
                                        <option value="4-5">4-5 tuổi (Lớp Chồi)</option>
                                        <option value="5-6">5-6 tuổi (Lớp Lá)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="updateSoLuongToiDa" class="form-label">Số Lượng Tối Đa *</label>
                                    <input type="number" class="form-control" id="updateSoLuongToiDa"
                                        v-model="update_lop_hoc.so_luong_toi_da" min="1" max="30" required />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="updateGiaoVienChuNhiem" class="form-label">Giáo Viên Chủ Nhiệm *</label>
                                    <select class="form-select" id="updateGiaoVienChuNhiem"
                                        v-model="update_lop_hoc.id_giao_vien_chu_nhiem" required>
                                        <option value="">Chọn giáo viên</option>
                                        <option v-for="gv in list_giao_vien" :key="gv.id" :value="gv.id">
                                            {{ gv.ho_va_ten }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="updatePhongHoc" class="form-label">Phòng Học *</label>
                                    <input type="text" class="form-control" id="updatePhongHoc"
                                        v-model="update_lop_hoc.phong_hoc" required />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="updateThoiGianHoc" class="form-label">Thời Gian Học *</label>
                                    <input type="text" class="form-control" id="updateThoiGianHoc"
                                        v-model="update_lop_hoc.thoi_gian_hoc" placeholder="VD: 7:30 - 17:00"
                                        required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="updateHocPhi" class="form-label">Học Phí (VNĐ) *</label>
                                    <input type="number" class="form-control" id="updateHocPhi"
                                        v-model="update_lop_hoc.hoc_phi" min="0" required />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="updateTinhTrang" class="form-label">Tình Trạng</label>
                                    <select v-model="update_lop_hoc.tinh_trang" class="form-select">
                                        <option value="1">Hoạt Động</option>
                                        <option value="0">Tạm Ngừng</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="updateGhiChu" class="form-label">Ghi Chú</label>
                                    <input type="text" class="form-control" id="updateGhiChu"
                                        v-model="update_lop_hoc.ghi_chu" placeholder="Ghi chú về lớp học..." />
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="updateMoTa" class="form-label">Mô Tả Lớp Học</label>
                            <textarea class="form-control" id="updateMoTa" rows="3" v-model="update_lop_hoc.mo_ta"
                                placeholder="Mô tả chi tiết về lớp học..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>
                        Hủy
                    </button>
                    <button type="button" class="btn btn-primary" @click="CapNhatLopHoc" :disabled="loading">
                        <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
                        <i v-else class="fas fa-save me-1"></i>
                        {{ loading ? 'Đang xử lý...' : 'Cập Nhật' }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Xóa Lớp Học -->
    <div class="modal fade" id="xoaModal" tabindex="-1" aria-labelledby="xoaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="xoaModalLabel">
                        <i class="fas fa-exclamation-triangle me-2 text-warning"></i>
                        Xác Nhận Xóa Lớp Học
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <div class="mb-3">
                            <i class="fas fa-graduation-cap text-danger" style="font-size: 3rem;"></i>
                        </div>
                        <h6>Bạn có chắc chắn muốn xóa lớp học này không?</h6>
                        <div class="alert alert-warning" role="alert">
                            <strong>Thông tin lớp học:</strong><br>
                            <strong>Tên lớp:</strong> {{ delete_lop_hoc.ten_lop }}<br>
                            <strong>Mã lớp:</strong> {{ delete_lop_hoc.ma_lop }}<br>
                            <strong>Độ tuổi:</strong> {{ delete_lop_hoc.do_tuoi }} tuổi
                        </div>
                        <p class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Hành động này không thể hoàn tác!
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>
                        Hủy
                    </button>
                    <button type="button" class="btn btn-danger" @click="XoaLopHoc" :disabled="loading">
                        <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
                        <i v-else class="fas fa-trash me-1"></i>
                        {{ loading ? 'Đang xử lý...' : 'Xóa Lớp Học' }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Thêm Lớp Học -->
    <div class="modal fade" id="themModal" tabindex="-1" aria-labelledby="themModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="themModalLabel">
                        <i class="fas fa-plus me-2"></i>
                        Thêm Lớp Học Mới
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="tenLop" class="form-label">Tên Lớp *</label>
                                <input type="text" class="form-control" id="tenLop" v-model="create_lop_hoc.ten_lop"
                                    required />
                            </div>
                            <div class="col-md-6">
                                <label for="maLop" class="form-label">Năm Học *</label>
                                <select class="form-select" id="doTuoi" v-model="create_lop_hoc.id_nam_hoc" required>
                                    <option value="">Chọn Năm Học</option>
                                    <option v-for="nh in list_nam_hoc" :key="nh.id" :value="nh.id">{{ nh.ten_nam_hoc }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="doTuoi" class="form-label">Độ Tuổi *</label>
                                <select class="form-select" id="doTuoi" v-model="create_lop_hoc.id_khoi_lop" required>
                                    <option value="">Chọn độ tuổi</option>
                                    <option value="1">3-4 tuổi (Lớp Mầm)</option>
                                    <option value="2">4-5 tuổi (Lớp Chồi)</option>
                                    <option value="3">5-6 tuổi (Lớp Lá)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="soLuongToiDa" class="form-label">Số Lượng Tối Đa *</label>
                                <input type="number" class="form-control" id="soLuongToiDa"
                                    v-model="create_lop_hoc.so_luong" min="1" max="30" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="giaoVienChuNhiem" class="form-label">Giáo Viên Chủ Nhiệm *</label>
                                <select class="form-select" id="giaoVienChuNhiem"
                                    v-model="create_lop_hoc.id_giao_vien" required>
                                    <option value="">Chọn giáo viên</option>
                                    <option v-for="gv in list_giao_vien" :key="gv.id" :value="gv.id">
                                        {{ gv.ho_va_ten }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="phongHoc" class="form-label">Phòng Học *</label>
                                <input type="text" class="form-control" id="phongHoc" v-model="create_lop_hoc.phong_hoc"
                                    required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="thoiGianHoc" class="form-label">Thời Gian Học *</label>
                                <input type="text" class="form-control" id="thoiGianHoc"
                                    v-model="create_lop_hoc.thoi_gian_hoc" placeholder="VD: 7:30 - 17:00" required />
                            </div>
                            <div class="col-md-6">
                                <label for="hocPhi" class="form-label">Học Phí (VNĐ) *</label>
                                <input type="number" class="form-control" id="hocPhi" v-model="create_lop_hoc.hoc_phi"
                                    min="0" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="tinhTrang" class="form-label">Tình Trạng</label>
                                <select v-model="create_lop_hoc.tinh_trang" class="form-select">
                                    <option value="1">Hoạt Động</option>
                                    <option value="0">Tạm Ngừng</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="ghiChu" class="form-label">Ghi Chú</label>
                                <input type="text" class="form-control" id="ghiChu" v-model="create_lop_hoc.ghi_chu"
                                    placeholder="Ghi chú về lớp học..." />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="moTa" class="form-label">Mô Tả Lớp Học</label>
                                <textarea class="form-control" id="moTa" rows="3" v-model="create_lop_hoc.mo_ta"
                                    placeholder="Mô tả chi tiết về lớp học..."></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>
                        Hủy
                    </button>
                    <button type="button" class="btn btn-primary" @click="ThemLopHoc" :disabled="loading">
                        <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
                        <i v-else class="fas fa-save me-1"></i>
                        {{ loading ? 'Đang xử lý...' : 'Thêm Lớp Học' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import baseRequestAdmin from "../../../core/baseRequestAdmin";

export default {
    data() {
        return {
            list_lop_hoc: [],
            list_giao_vien: [],
            list_nam_hoc: [],
            create_lop_hoc: {
                ten_lop: "",
                ma_lop: "",
                do_tuoi: "",
                so_luong_toi_da: "",
                id_giao_vien_chu_nhiem: "",
                phong_hoc: "",
                thoi_gian_hoc: "",
                hoc_phi: "",
                is_block: "1",
                ghi_chu: "",
                mo_ta: "",
            },
            update_lop_hoc: {
                id: "",
                ten_lop: "",
                ma_lop: "",
                do_tuoi: "",
                so_luong_toi_da: "",
                id_giao_vien_chu_nhiem: "",
                phong_hoc: "",
                thoi_gian_hoc: "",
                hoc_phi: "",
                is_block: "",
                ghi_chu: "",
                mo_ta: "",
            },
            delete_lop_hoc: {
                id: "",
                ten_lop: "",
                ma_lop: "",
                do_tuoi: "",
            },
            search: {
                noi_dung: "",
                is_block: "",
                do_tuoi: "",
            },
            loading: false,
        };
    },

    mounted() {
        this.loadData();
        this.loadGiaoVien();
        this.loadNamHoc();
    },

    methods: {
        formatCurrency(amount) {
            if (!amount) return "0 VNĐ";
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(amount);
        },

        getTotalStudents() {
            return this.list_lop_hoc.reduce((total, lop) => total + (lop.so_hoc_sinh || 0), 0);
        },

        getStudentPercentage(lop) {
            if (!lop.so_luong_toi_da || lop.so_luong_toi_da === 0) return 0;
            return Math.round(((lop.so_hoc_sinh || 0) / lop.so_luong_toi_da) * 100);
        },

        loadNamHoc() {
            baseRequestAdmin
                .get("admin/nam-hoc/data")
                .then((res) => {
                    if (res.data.status) {
                        this.list_nam_hoc = res.data.data;
                    }
                });
        },
        loadData() {
            baseRequestAdmin
                .get("admin/lop-hoc/data")
                .then((res) => {
                    if (res.data.status) {
                        this.list_lop_hoc = res.data.data;
                        this.$toast.success(res.data.message);
                    } else {
                        this.$toast.error(res.data.message);
                    }
                })
                .catch((err) => {
                    const listErr = err.response?.data?.errors;
                    if (listErr) {
                        Object.values(listErr).forEach((error) => {
                            this.$toast.error(error[0]);
                        });
                    } else {
                        this.$toast.error("Có lỗi xảy ra khi tải dữ liệu");
                    }
                });
        },

        loadGiaoVien() {
            baseRequestAdmin
                .get("admin/giao-vien/data")
                .then((res) => {
                    if (res.data.status) {
                        this.list_giao_vien = res.data.data;
                    }
                })
                .catch((err) => {
                    console.log("Không thể tải danh sách giáo viên");
                });
        },

        DoiTrangThai(payload) {
            baseRequestAdmin
                .post("admin/lop-hoc/change-status", payload)
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.loadData();
                    } else {
                        this.$toast.error(res.data.message);
                    }
                })
                .catch((err) => {
                    this.$toast.error("Có lỗi xảy ra khi thay đổi trạng thái");
                });
        },

        ThemLopHoc() {
            this.loading = true;
            baseRequestAdmin
                .post("admin/lop-hoc/create", this.create_lop_hoc)
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.loadData();
                        this.resetCreateForm();
                        // Đóng modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById("themModal"));
                        if (modal) modal.hide();
                    } else {
                        this.$toast.error(res.data.message);
                    }
                })
                .catch((err) => {
                    const listErr = err.response?.data?.errors;
                    if (listErr) {
                        Object.values(listErr).forEach((error) => {
                            this.$toast.error(error[0]);
                        });
                    } else {
                        this.$toast.error("Có lỗi xảy ra khi thêm lớp học");
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        CapNhatLopHoc() {
            this.loading = true;
            baseRequestAdmin
                .post("admin/lop-hoc/update", this.update_lop_hoc)
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.loadData();
                        // Đóng modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById("capNhatModal"));
                        if (modal) modal.hide();
                    } else {
                        this.$toast.error(res.data.message);
                    }
                })
                .catch((err) => {
                    const listErr = err.response?.data?.errors;
                    if (listErr) {
                        Object.values(listErr).forEach((error) => {
                            this.$toast.error(error[0]);
                        });
                    } else {
                        this.$toast.error("Có lỗi xảy ra khi cập nhật lớp học");
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        XoaLopHoc() {
            this.loading = true;
            baseRequestAdmin
                .post("admin/lop-hoc/delete", this.delete_lop_hoc)
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.loadData();
                        this.delete_lop_hoc = {};
                        // Đóng modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById("xoaModal"));
                        if (modal) modal.hide();
                    } else {
                        this.$toast.error(res.data.message);
                    }
                })
                .catch((err) => {
                    const listErr = err.response?.data?.errors;
                    if (listErr) {
                        Object.values(listErr).forEach((error) => {
                            this.$toast.error(error[0]);
                        });
                    } else {
                        this.$toast.error("Có lỗi xảy ra khi xóa lớp học");
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        TiemKiem() {
            baseRequestAdmin
                .post("admin/lop-hoc/search", this.search)
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.list_lop_hoc = res.data.data;
                    } else {
                        this.$toast.error(res.data.message);
                    }
                })
                .catch((err) => {
                    const listErr = err.response?.data?.errors;
                    if (listErr) {
                        Object.values(listErr).forEach((error) => {
                            this.$toast.error(error[0]);
                        });
                    } else {
                        this.$toast.error("Có lỗi xảy ra khi tìm kiếm");
                    }
                });
        },

        viewClassDetails(lop) {
            // Implement view class details functionality
            alert(`Xem chi tiết lớp học: ${lop.ten_lop}`);
        },

        resetCreateForm() {
            this.create_lop_hoc = {
                ten_lop: "",
                ma_lop: "",
                do_tuoi: "",
                so_luong_toi_da: "",
                id_giao_vien_chu_nhiem: "",
                phong_hoc: "",
                thoi_gian_hoc: "",
                hoc_phi: "",
                is_block: "0",
                ghi_chu: "",
                mo_ta: "",
            };
        },
    },
};
</script>

<style lang="scss">
@use "./style.scss";
</style>