<template>
    <div class="page-header education-theme">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-header-content">
                        <div class="page-icon">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <div class="page-info">
                            <h1 class="page-title">Quản lý Bài Viết</h1>
                            <p class="page-subtitle">
                                Quản lý bài viết và tin tức trong hệ thống
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <nav class="breadcrumb-nav">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <i class="fas fa-school"></i>
                                <a href="javascript: void(0);">Quản lý</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="fas fa-newspaper"></i>
                                Bài Viết
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
                    <i class="fas fa-newspaper"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number">{{ list_bai_viet.length }}</h3>
                    <p class="stats-label">Tổng Bài Viết</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card stats-success">
                <div class="stats-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number">
                        {{list_bai_viet.filter((bv) => bv.tinh_trang == 1).length}}
                    </h3>
                    <p class="stats-label">Đã Xuất Bản</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card stats-warning">
                <div class="stats-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number">
                        {{list_bai_viet.filter((bv) => bv.tinh_trang == 0).length}}
                    </h3>
                    <p class="stats-label">Bản Nháp</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card stats-info">
                <div class="stats-icon">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number">
                        {{
                            list_bai_viet.reduce(
                                (total, bv) => total + (bv.luot_xem || 0),
                                0
                            )
                        }}
                    </h3>
                    <p class="stats-label">Tổng Lượt Xem</p>
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
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <div class="header-text">
                            <h5 class="card-title">Danh Sách Bài Viết</h5>
                            <p class="card-subtitle">Quản lý bài viết và tin tức hệ thống</p>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-modern" data-bs-toggle="modal" data-bs-target="#themModal">
                        <i class="fas fa-plus"></i>
                        Thêm Bài Viết
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
                                    class="search-input" placeholder="Tìm kiếm theo tiêu đề, nội dung..." />
                            </div>

                            <div class="search-filters">
                                <select v-on:change="TiemKiem()" class="filter-select" v-model="search.tinh_trang">
                                    <option value="">Tất cả trạng thái</option>
                                    <option value="1">Đã xuất bản</option>
                                    <option value="0">Bản nháp</option>
                                </select>
                                <select v-on:change="TiemKiem()" class="filter-select" v-model="search.loai_bai_viet">
                                    <option value="">Tất cả loại</option>
                                    <option value="Tin tức">Tin tức</option>
                                    <option value="Thông báo">Thông báo</option>
                                    <option value="Hoạt động">Hoạt động</option>
                                    <option value="Khác">Khác</option>
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
                                    <th>Tiêu Đề</th>
                                    <th class="text-center">Hình Ảnh</th>
                                    <th class="text-center">Loại</th>
                                    <th class="text-center">Tác Giả</th>
                                    <th class="text-center">Ngày Đăng</th>
                                    <th class="text-center">Lượt Xem</th>
                                    <th class="text-center">Trạng Thái</th>
                                    <th class="text-center">Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(value, index) in list_bai_viet" :key="index">
                                    <tr class="table-row-hover">
                                        <td class="text-center table-index">
                                            {{ index + 1 }}
                                        </td>
                                        <td class="article-info">
                                            <div class="article-container">
                                                <div class="article-details">
                                                    <span class="article-title">{{ value.tieu_de }}</span>
                                                    <small class="article-excerpt">
                                                        {{
                                                            !value.noi_dung
                                                                ? ""
                                                                : value.noi_dung.length > 80
                                                                    ? value.noi_dung.substring(0, 80) + "..."
                                                                    : value.noi_dung
                                                        }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="article-image">
                                                <img :src="value.hinh_anh || '/default-image.jpg'" :alt="value.tieu_de"
                                                    class="image-thumbnail" />
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="type-badge" :class="value.ten_loai_bai_viet === 'Tin tức'
                                                ? 'type-news'
                                                : value.ten_loai_bai_viet === 'Thông báo'
                                                    ? 'type-notice'
                                                    : value.ten_loai_bai_viet === 'Hoạt động'
                                                        ? 'type-activity'
                                                        : 'type-other'">
                                                <i class="fas" :class="value.ten_loai_bai_viet === 'Tin tức'
                                                    ? 'fa-newspaper'
                                                    : value.ten_loai_bai_viet === 'Thông báo'
                                                        ? 'fa-bullhorn'
                                                        : value.ten_loai_bai_viet === 'Hoạt động'
                                                            ? 'fa-calendar-check'
                                                            : 'fa-file-alt'"></i>
                                                {{ value.ten_loai_bai_viet }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="author-info">
                                                <div class="author-name">{{ value.nguoi_dang || 'Chưa cập nhật' }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="date-info">
                                                <div class="date">{{ formatDate(value.ngay_dang) }}</div>
                                                <small class="time">{{ formatTime(value.ngay_dang) }}</small>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="views-info">
                                                <i class="fas fa-eye"></i>
                                                {{ value.luot_xem || 0 }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <button v-if="value.tinh_trang == 1" class="btn status-badge status-active">
                                                <i class="fas fa-check-circle"></i>
                                                Đã Xuất Bản
                                            </button>
                                            <button v-else class="btn status-badge status-inactive">
                                                <i class="fas fa-clock"></i>
                                                Bản Nháp
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <div class="action-buttons">
                                                <button class="btn-action btn-edit"
                                                    @click="Object.assign(update_bai_viet, value)"
                                                    data-bs-toggle="modal" data-bs-target="#capNhatModal"
                                                    title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                
                                                <button class="btn-action btn-delete"
                                                    @click="Object.assign(delete_bai_viet, value)"
                                                    data-bs-toggle="modal" data-bs-target="#xoaModal" title="Xóa">
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

    <!-- Modal Cập Nhật Bài Viết -->
    <div class="modal fade" id="capNhatModal" tabindex="-1" aria-labelledby="capNhatModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="capNhatModalLabel">
                        <i class="fas fa-edit me-2"></i>
                        Cập Nhật Bài Viết
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="updateTieuDe" class="form-label">Tiêu Đề *</label>
                                    <input type="text" class="form-control" id="updateTieuDe"
                                        v-model="update_bai_viet.tieu_de" required />
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="updateSlug" class="form-label">Slug tiêu đề *</label>
                            <input type="text" class="form-control" id="updateSlug"
                                v-model="update_bai_viet.slug_tieu_de" placeholder="vd: giao-luu-cung-phu-huynh"
                                required />
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="updateLoaiBaiViet" class="form-label">Loại Bài Viết *</label>
                                    <select class="form-select" id="loaiBaiViet"
                                        v-model="update_bai_viet.id_loai_bai_viet" required>
                                        <option value="">Chọn loại bài viết</option>
                                        <option v-for="nh in list_loai_bai_viet" :key="nh.id" :value="nh.id">
                                            {{ nh.ten_loai }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="updateHinhAnh" class="form-label">Hình Ảnh URL</label>
                                    <input type="url" class="form-control" id="updateHinhAnh"
                                        v-model="update_bai_viet.hinh_anh"
                                        placeholder="https://example.com/image.jpg" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="updateTacGia" class="form-label">Tác Giả *</label>
                                    <select class="form-select" id="loaiBaiViet" v-model="update_bai_viet.id_nhan_vien"
                                        required>
                                        <option v-for="nh in list_nhan_vien" :key="nh.id" :value="nh.id">
                                            {{ nh.ho_va_ten }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="updateTinhTrang" class="form-label">Trạng Thái</label>
                                    <select v-model="update_bai_viet.tinh_trang" class="form-select">
                                        <option value="1">Đã Xuất Bản</option>
                                        <option value="0">Bản Nháp</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="updateNoiDung" class="form-label">Nội Dung *</label>
                            <textarea class="form-control" id="updateNoiDung" rows="10"
                                v-model="update_bai_viet.noi_dung" placeholder="Nhập nội dung bài viết..."
                                required></textarea>
                        </div>
                        
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>
                        Hủy
                    </button>
                    <button type="button" class="btn btn-primary" @click="CapNhatBaiViet" :disabled="loading">
                        <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
                        <i v-else class="fas fa-save me-1"></i>
                        {{ loading ? 'Đang xử lý...' : 'Cập Nhật' }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Xóa Bài Viết -->
    <div class="modal fade" id="xoaModal" tabindex="-1" aria-labelledby="xoaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="xoaModalLabel">
                        <i class="fas fa-exclamation-triangle me-2 text-warning"></i>
                        Xác Nhận Xóa Bài Viết
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <div class="mb-3">
                            <i class="fas fa-newspaper text-danger" style="font-size: 3rem;"></i>
                        </div>
                        <h6>Bạn có chắc chắn muốn xóa bài viết này không?</h6>
                        <div class="alert alert-warning" role="alert">
                            <strong>Thông tin bài viết:</strong><br>
                            <strong>Tiêu đề:</strong> {{ delete_bai_viet.tieu_de }}<br>
                            <strong>Loại:</strong> {{ delete_bai_viet.ten_loai_bai_viet }}<br>
                            <strong>Tác giả:</strong> {{ delete_bai_viet.nguoi_dang }}
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
                    <button type="button" class="btn btn-danger" @click="XoaBaiViet" :disabled="loading">
                        <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
                        <i v-else class="fas fa-trash me-1"></i>
                        {{ loading ? 'Đang xử lý...' : 'Xóa Bài Viết' }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Thêm Bài Viết -->
    <div class="modal fade" id="themModal" tabindex="-1" aria-labelledby="themModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="themModalLabel">
                        <i class="fas fa-plus me-2"></i>
                        Thêm Bài Viết Mới
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="tieuDe" class="form-label">Tiêu Đề *</label>
                                <input type="text" class="form-control" id="tieuDe" v-model="create_bai_viet.tieu_de"
                                    required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="slugTieuDe" class="form-label">Slug tiêu đề *</label>
                                <input type="text" class="form-control" id="slugTieuDe"
                                    v-model="create_bai_viet.slug_tieu_de" placeholder="vd: giao-luu-cung-phu-huynh"
                                    required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="loaiBaiViet" class="form-label">Loại Bài Viết *</label>
                                <select class="form-select" id="loaiBaiViet" v-model="create_bai_viet.id_loai_bai_viet"
                                    required>
                                    <option value="">Chọn loại bài viết</option>
                                    <option v-for="nh in list_loai_bai_viet" :key="nh.id" :value="nh.id">
                                        {{ nh.ten_loai }}
                                    </option>
                                </select>

                            </div>
                            <div class="col-md-6">
                                <label for="hinhAnh" class="form-label">Hình Ảnh URL</label>
                                <input type="url" class="form-control" id="hinhAnh" v-model="create_bai_viet.hinh_anh"
                                    placeholder="https://example.com/image.jpg" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="tacGia" class="form-label">Tác Giả *</label>
                                <select class="form-select" id="tacGia" v-model="create_bai_viet.id_nhan_vien" required>
                                    <option value="">Chọn tác giả</option>
                                    <option v-for="nh in list_nhan_vien" :key="nh.id" :value="nh.id">
                                        {{ nh.ho_va_ten }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="tinhTrang" class="form-label">Trạng Thái</label>
                                <select v-model="create_bai_viet.tinh_trang" class="form-select">
                                    <option value="0">Bản Nháp</option>
                                    <option value="1">Đã Xuất Bản</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="noiDung" class="form-label">Nội Dung *</label>
                                <textarea class="form-control" id="noiDung" rows="10" v-model="create_bai_viet.noi_dung"
                                    placeholder="Nhập nội dung bài viết..." required></textarea>
                            </div>
                        </div>
                        
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>
                        Hủy
                    </button>
                    <button type="button" class="btn btn-primary" @click="ThemBaiViet" :disabled="loading">
                        <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
                        <i v-else class="fas fa-save me-1"></i>
                        {{ loading ? 'Đang xử lý...' : 'Thêm Bài Viết' }}
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
            list_bai_viet: [],
            list_loai_bai_viet: [],
            list_nhan_vien: [],
            create_bai_viet: {
                tieu_de: "",
                noi_dung: "",
                slug_tieu_de: "",
                hinh_anh: "",
                loai_bai_viet: "",
                ten_tac_gia: "",
                tinh_trang: "0",
                id_loai_bai_viet: "",
                id_nhan_vien: "",
            },
            update_bai_viet: {
                id: "",
                tieu_de: "",
                noi_dung: "",
                slug_tieu_de: "",
                hinh_anh: "",
                loai_bai_viet: "",
                ten_tac_gia: "",
                tinh_trang: "",
                id_loai_bai_viet: "",
                id_nhan_vien: "",
            },
            delete_bai_viet: {
                id: "",
                tieu_de: "",
                ten_loai_bai_viet: "",
                nguoi_dang: "",
            },
            search: {
                noi_dung: "",
                tinh_trang: "",
                loai_bai_viet: "",
            },
            loading: false,
            modalOpen: false,
        };
    },

    mounted() {
        this.loadData();
        this.loadLoaiBaiViet();
        this.loadDatanhanvien();
    },

    methods: {
        formatDate(dateString) {
            if (!dateString) return "";
            const date = new Date(dateString);
            return date.toLocaleDateString("vi-VN");
        },

        formatTime(dateString) {
            if (!dateString) return "";
            const date = new Date(dateString);
            return date.toLocaleTimeString("vi-VN", { hour: '2-digit', minute: '2-digit' });
        },

        loadData() {
            baseRequestAdmin
                .get("admin/bai-viet/data")
                .then((res) => {
                    if (res.data.status) {
                        this.list_bai_viet = res.data.data;
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
        loadLoaiBaiViet() {
            baseRequestAdmin
                .get("admin/loai-bai-viet/data")
                .then((res) => {
                    if (res.data.status) {
                        this.list_loai_bai_viet = res.data.data;
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
        loadDatanhanvien() {
            baseRequestAdmin
                .get("admin/nhan-vien/data")
                .then((res) => {
                    if (res.data.status) {
                        this.list_nhan_vien = res.data.data;
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

        DoiTrangThai(payload) {
            baseRequestAdmin
                .post("admin/bai-viet/change-status", payload)
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

        ThemBaiViet() {
            this.loading = true;
            baseRequestAdmin
                .post("admin/bai-viet/create", this.create_bai_viet)
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
                        this.$toast.error("Có lỗi xảy ra khi thêm bài viết");
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        CapNhatBaiViet() {
            this.loading = true;
            baseRequestAdmin
                .post("admin/bai-viet/update", this.update_bai_viet)
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
                        this.$toast.error("Có lỗi xảy ra khi cập nhật bài viết");
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        XoaBaiViet() {
            this.loading = true;
            baseRequestAdmin
                .post("admin/bai-viet/delete", this.delete_bai_viet)
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.loadData();
                        this.delete_bai_viet = {
                            id: "",
                            tieu_de: "",
                            ten_loai_bai_viet: "",
                            nguoi_dang: "",
                        };
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
                        this.$toast.error("Có lỗi xảy ra khi xóa bài viết");
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        TiemKiem() {
            baseRequestAdmin
                .post("admin/bai-viet/search", this.search)
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.list_bai_viet = res.data.data;
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

        viewArticle(article) {
            // Implement view article functionality
            alert(`Xem chi tiết bài viết: ${article.tieu_de}`);
        },

        resetCreateForm() {
            this.create_bai_viet = {
                tieu_de: "",
                noi_dung: "",
                slug_tieu_de: "",
                hinh_anh: "",
                loai_bai_viet: "",
                ten_tac_gia: "",
                tinh_trang: "0",
                id_loai_bai_viet: "",
                id_nhan_vien: "",
            };
        },
    },
};
</script>

<style lang="scss" scoped>
@use "./style.scss";
</style>
