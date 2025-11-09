<template>
    <div class="page-header education-theme">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-header-content">
                        <div class="page-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div class="page-info">
                            <h1 class="page-title">Quản Lý Thông Báo</h1>
                            <p class="page-subtitle">
                                Gửi và quản lý thông báo cho toàn hệ thống
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <nav class="breadcrumb-nav">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <i class="fas fa-home"></i>
                                <a href="javascript: void(0);">Admin</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="fas fa-bell"></i>
                                Thông Báo
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stats-card stats-primary">
                <div class="stats-icon">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number">{{ totalSent }}</h3>
                    <p class="stats-label">Đã Gửi</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card stats-success">
                <div class="stats-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number">{{ totalRead }}</h3>
                    <p class="stats-label">Đã Đọc</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card stats-warning">
                <div class="stats-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number">{{ scheduled }}</h3>
                    <p class="stats-label">Chờ Gửi</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card stats-info">
                <div class="stats-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number">{{ readRate }}%</h3>
                    <p class="stats-label">Tỷ Lệ Đọc</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Management Card -->
    <div class="row">
        <div class="col-12">
            <div class="management-card">
                <div class="card-header-custom">
                    <div class="header-content">
                        <div class="header-icon">
                            <i class="fas fa-list"></i>
                        </div>
                        <div class="header-text">
                            <h5 class="card-title">Danh Sách Thông Báo</h5>
                            <p class="card-subtitle">Quản lý tất cả thông báo đã gửi</p>
                        </div>
                    </div>
                    <div class="header-actions">
                        <button class="btn btn-outline-primary btn-sm me-2" @click="showFilters = !showFilters">
                            <i class="fas fa-filter"></i> Bộ Lọc
                        </button>
                        <button class="btn btn-primary btn-modern" data-bs-toggle="modal" data-bs-target="#themModal">
                            <i class="fas fa-plus"></i>
                            Gửi Thông Báo Mới
                        </button>
                    </div>
                </div>

                <!-- Filter Section -->
                <div v-if="showFilters" class="filter-section">
                    <div class="search-container">
                        <div class="search-input-group">
                            <div class="form-search">
                                <div class="search-icon">
                                    <i class="fas fa-search"></i>
                                </div>
                                <input type="text" class="search-input" placeholder="Tìm kiếm thông báo..."
                                    v-model="searchKeyword" @input="loadData" />
                            </div>
                            <div class="search-filters">
                                <select class="filter-select" v-model="filterType" @change="loadData">
                                    <option value="">Tất cả loại</option>
                                    <option value="system">Hệ thống</option>
                                    <option value="admin">Hành chính</option>
                                    <option value="classroom">Lớp học</option>
                                    <option value="event">Sự kiện</option>
                                    <option value="alert">Khẩn cấp</option>
                                </select>
                                <select class="filter-select" v-model="filterStatus" @change="loadData">
                                    <option value="">Tất cả trạng thái</option>
                                    <option value="da_gui">Đã gửi</option>
                                    <option value="cho_gui">Chờ gửi</option>
                                    <option value="that_bai">Thất bại</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-container">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 50px;">#</th>
                                    <th class="text-center">Tiêu Đề</th>
                                    <th class="text-center">Loại</th>
                                    <th class="text-center">Đối Tượng</th>
                                    <th class="text-center">Người Gửi</th>
                                    <th class="text-center">Thời Gian</th>
                                    <th class="text-center">Trạng Thái</th>
                                    <th class="text-center">Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(notification, index) in list_thong_bao" :key="notification.id"
                                    class="table-row-hover">
                                    <td class="table-index">{{ index + 1 }}</td>
                                    <td>
                                        <div class="notification-title">
                                            <strong>{{ notification.tieu_de }}</strong>
                                            <small class="text-muted">{{ truncateText(notification.noi_dung, 50)
                                            }}</small>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span v-if="notification.loai_thong_bao == 0" class="type-badge type-system">
                                            Toàn Trường
                                        </span>
                                        <span v-else-if="notification.loai_thong_bao == 1"
                                            class="type-badge type-admin">
                                            Theo Lớp
                                        </span>
                                        <span v-else-if="notification.loai_thong_bao == 2"
                                            class="type-badge type-classroom">
                                            Cá Nhân
                                        </span>
                                        <span v-else-if="notification.loai_thong_bao == 3"
                                            class="type-badge type-event">
                                            Hệ Thống
                                        </span>
                                        <span v-else-if="notification.loai_thong_bao == 4"
                                            class="type-badge type-event">
                                            Sự Kiện
                                        </span>
                                        <span v-else-if="notification.loai_thong_bao == 5"
                                            class="type-badge type-event">
                                            Khẩn Cấp
                                        </span>

                                    </td>
                                    <td>
                                        <span class="audience-badge">
                                            {{ notification.doi_tuong_nhan }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="user-badge">
                                            <i class="fas fa-user"></i>
                                            {{ notification.nguoi_gui || 'Admin' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="date-info">
                                            <i class="far fa-clock"></i>
                                            {{ formatDate(notification.thoi_gian_dang) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-warning w-100" v-if="notification.tinh_trang == 0">
                                            Chờ gửi
                                        </button>
                                        <button class="btn btn-success w-100" v-else-if="notification.tinh_trang == 1">
                                            Đã gửi
                                        </button>
                                        <button class="btn btn-danger w-100" v-else-if="notification.tinh_trang == 2">
                                            Đã Huỷ
                                        </button>
                                    </td>
                                    <td class="text-center">
                                        <div class="action-buttons">
                                            <button class="btn-action btn-view" @click="XemChiTiet(notification)"
                                                title="Xem chi tiết">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn-action btn-edit" @click="SuaThongBao(notification)"
                                                title="Sửa">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn-action btn-delete" @click="XoaThongBao(notification)"
                                                title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="themModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus-circle me-2"></i>
                        Gửi Thông Báo Mới
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form @submit.prevent="ThemThongBao">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-heading me-1"></i> Tiêu đề <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" v-model="new_thong_bao.tieu_de" required
                                placeholder="Nhập tiêu đề thông báo" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-align-left me-1"></i> Nội dung <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" rows="5" v-model="new_thong_bao.noi_dung" required
                                placeholder="Nhập nội dung thông báo"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-tags me-1"></i> Loại thông báo <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" v-model="new_thong_bao.loai_thong_bao" required>
                                    <option value="">Chọn loại</option>
                                    <option value="system">Hệ thống</option>
                                    <option value="admin">Hành chính</option>
                                    <option value="classroom">Lớp học</option>
                                    <option value="event">Sự kiện</option>
                                    <option value="alert">Khẩn cấp</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    <i class="fas fa-users me-1"></i> Đối tượng nhận <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" v-model="new_thong_bao.doi_tuong_nhan" required>
                                    <option value="">Chọn đối tượng</option>
                                    <option value="tat_ca">Tất cả</option>
                                    <option value="phu_huynh">Phụ huynh</option>
                                    <option value="giao_vien">Giáo viên</option>
                                    <option value="lop">Theo lớp</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3" v-if="new_thong_bao.doi_tuong_nhan === 'lop'">
                            <label class="form-label">
                                <i class="fas fa-graduation-cap me-1"></i> Chọn lớp
                            </label>
                            <select class="form-select" v-model="new_thong_bao.id_lop">
                                <option value="">Chọn lớp</option>
                                <option v-for="lop in list_lop" :key="lop.id" :value="lop.id">
                                    {{ lop.ten_lop }}
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-calendar me-1"></i> Thời gian gửi
                            </label>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" v-model="sendMode" value="now"
                                    id="sendNow" />
                                <label class="form-check-label" for="sendNow"> Gửi ngay</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" v-model="sendMode" value="schedule"
                                    id="sendSchedule" />
                                <label class="form-check-label" for="sendSchedule"> Lên lịch gửi</label>
                            </div>
                            <input v-if="sendMode === 'schedule'" type="datetime-local" class="form-control mt-2"
                                v-model="new_thong_bao.ngay_gui" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Đóng
                        </button>
                        <button type="submit" class="btn btn-primary" :disabled="loading">
                            <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
                            <i v-else class="fas fa-paper-plane me-1"></i>
                            {{ loading ? 'Đang xử lý...' : 'Gửi Thông Báo' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update Modal -->
    <div class="modal fade" id="capNhatModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>
                        Cập Nhật Thông Báo
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form @submit.prevent="CapNhatThongBao">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Tiêu đề</label>
                            <input type="text" class="form-control" v-model="update_thong_bao.tieu_de" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nội dung</label>
                            <textarea class="form-control" rows="5" v-model="update_thong_bao.noi_dung"
                                required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Loại thông báo</label>
                                <select class="form-select" v-model="update_thong_bao.loai_thong_bao" required>
                                    <option value="system">Hệ thống</option>
                                    <option value="admin">Hành chính</option>
                                    <option value="classroom">Lớp học</option>
                                    <option value="event">Sự kiện</option>
                                    <option value="alert">Khẩn cấp</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Trạng thái</label>
                                <select class="form-select" v-model="update_thong_bao.trang_thai_gui" required>
                                    <option value="cho_gui">Chờ gửi</option>
                                    <option value="da_gui">Đã gửi</option>
                                    <option value="that_bai">Thất bại</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" :disabled="loading">
                            <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
                            <i v-else class="fas fa-save me-1"></i>
                            {{ loading ? 'Đang xử lý...' : 'Cập Nhật' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Detail Modal -->
    <div class="modal fade" id="chiTietModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-info-circle me-2"></i>
                        Chi Tiết Thông Báo
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" v-if="view_thong_bao.id">
                    <div class="notification-detail">
                        <div class="detail-header mb-3">
                            <h4>{{ view_thong_bao.tieu_de }}</h4>
                            <div class="detail-meta">
                                <span class="type-badge" :class="getTypeClass(view_thong_bao.loai_thong_bao)">
                                    <i :class="getTypeIcon(view_thong_bao.loai_thong_bao)"></i>
                                    {{ getTypeLabel(view_thong_bao.loai_thong_bao) }}
                                </span>
                                <span class="status-badge" :class="getStatusClass(view_thong_bao.tinh_trang)">
                                    {{ getStatusLabel(view_thong_bao.tinh_trang) }}
                                </span>
                            </div>
                        </div>
                        <div class="detail-content">
                            <p>{{ view_thong_bao.noi_dung }}</p>
                        </div>
                        <div class="detail-info">
                            <p><strong>Đối tượng:</strong> {{ getAudienceLabel(view_thong_bao.doi_tuong_nhan) ||
                                view_thong_bao.doi_tuong_nhan }}</p>
                            <p><strong>Người gửi:</strong> {{ view_thong_bao.ten_nguoi_gui || view_thong_bao.nguoi_gui
                                || 'Admin' }}</p>
                            <p><strong>Thời gian:</strong> {{ formatDate(view_thong_bao.thoi_gian_dang) }}</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="xoaModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xác Nhận Xóa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa thông báo này?</p>
                    <p class="text-danger"><strong>{{ delete_thong_bao.tieu_de }}</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-danger" @click="XoaThongBaoConfirm" :disabled="loading">
                        <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
                        <i v-else class="fas fa-trash me-1"></i>
                        {{ loading ? 'Đang xử lý...' : 'Xóa' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import baseRequestAdmin from "../../../core/baseRequestAdmin";

export default {
    name: "NotificationManagement",
    data() {
        return {
            list_thong_bao: [],
            list_lop: [],
            new_thong_bao: {
                tieu_de: "",
                noi_dung: "",
                loai_thong_bao: "",
                doi_tuong_nhan: "",
                id_lop: "",
                ngay_gui: "",
            },
            update_thong_bao: {},
            delete_thong_bao: {},
            view_thong_bao: {},
            sendMode: "now",
            searchKeyword: "",
            filterType: "",
            filterStatus: "",
            showFilters: false,
            totalSent: 0,
            totalRead: 0,
            scheduled: 0,
            readRate: 0,
            loading: false,
        };
    },

    mounted() {
        this.loadData();
        this.loadClasses();
        this.loadStatistics();
    },

    methods: {
        // Helper functions
        closeModal(modalId) {
            const modal = bootstrap.Modal.getInstance(document.getElementById(modalId));
            if (modal) modal.hide();
        },

        resetForm() {
            this.new_thong_bao = {
                tieu_de: "",
                noi_dung: "",
                loai_thong_bao: "",
                doi_tuong_nhan: "",
                id_lop: "",
                ngay_gui: "",
            };
            this.sendMode = "now";
        },

        // Load data
        loadData() {
            const params = {
                search: this.searchKeyword,
                loai_thong_bao: this.filterType,
                trang_thai_gui: this.filterStatus,
            };
            baseRequestAdmin.get("admin/thong-bao/data", { params }).then((res) => {
                if (res.data.status) {
                    this.list_thong_bao = res.data.data || [];
                }
            });
        },

        loadClasses() {
            baseRequestAdmin.get("admin/lop-hoc/data").then((res) => {
                if (res.data.status) {
                    this.list_lop = res.data.data || [];
                }
            });
        },

        loadStatistics() {
            baseRequestAdmin.get("admin/thong-bao/thong-ke").then((res) => {
                if (res.data.status) {
                    const stats = res.data.data;
                    this.totalSent = stats.tong_so_gui || 0;
                    this.totalRead = stats.tong_so_da_doc || 0;
                    this.scheduled = stats.cho_gui || 0;
                    this.readRate = stats.ti_le_doc || 0;
                }
            });
        },

        // CRUD operations
        ThemThongBao() {
            this.loading = true;
            const payload = {
                ...this.new_thong_bao,
                ngay_gui: this.sendMode === "now" ? new Date().toISOString() : this.new_thong_bao.ngay_gui,
            };
            baseRequestAdmin
                .post("admin/thong-bao/add", payload)
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.loadData();
                        this.loadStatistics();
                        this.resetForm();
                        this.closeModal("themModal");
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
                        this.$toast.error("Có lỗi xảy ra khi thêm thông báo");
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        SuaThongBao(thong_bao) {
            this.update_thong_bao = { ...thong_bao };
            const modal = new bootstrap.Modal(document.getElementById("capNhatModal"));
            modal.show();
        },

        CapNhatThongBao() {
            this.loading = true;
            baseRequestAdmin
                .post("admin/thong-bao/update", this.update_thong_bao)
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.loadData();
                        this.loadStatistics();
                        this.closeModal("capNhatModal");
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
                        this.$toast.error("Có lỗi xảy ra khi cập nhật thông báo");
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        XoaThongBao(thong_bao) {
            this.delete_thong_bao = thong_bao;
            const modal = new bootstrap.Modal(document.getElementById("xoaModal"));
            modal.show();
        },

        XoaThongBaoConfirm() {
            this.loading = true;
            baseRequestAdmin
                .post("admin/thong-bao/delete", { id: this.delete_thong_bao.id })
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.loadData();
                        this.loadStatistics();
                        this.delete_thong_bao = {};
                        this.closeModal("xoaModal");
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
                        this.$toast.error("Có lỗi xảy ra khi xóa thông báo");
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        XemChiTiet(thong_bao) {
            this.view_thong_bao = thong_bao;
            const modal = new bootstrap.Modal(document.getElementById("chiTietModal"));
            modal.show();
        },

        // Utility functions
        getTypeLabel(type) {
            const labels = {
                0: "Toàn Trường",
                1: "Theo Lớp",
                2: "Cá Nhân",
                3: "Hệ Thống",
                4: "Sự Kiện",
                5: "Khẩn Cấp",
            };
            return labels[type] || labels[type?.toString()] || type;
        },

        getTypeClass(type) {
            const classes = {
                0: "type-system",
                1: "type-admin",
                2: "type-classroom",
                3: "type-event",
                4: "type-event",
                5: "type-event",
            };
            return classes[type] || classes[type?.toString()] || "";
        },

        getTypeIcon(type) {
            const icons = {
                0: "fas fa-building",
                1: "fas fa-chalkboard",
                2: "fas fa-user",
                3: "fas fa-cog",
                4: "fas fa-calendar-star",
                5: "fas fa-exclamation-triangle",
            };
            return icons[type] || icons[type?.toString()] || "fas fa-bell";
        },

        getAudienceLabel(audience) {
            const labels = {
                tat_ca: "Tất cả",
                phu_huynh: "Phụ huynh",
                giao_vien: "Giáo viên",
                lop: "Theo lớp",
            };
            return labels[audience] || audience;
        },

        getStatusLabel(status) {
            const labels = {
                0: "Chờ gửi",
                1: "Đã gửi",
                2: "Đã Huỷ",
            };
            return labels[status] || labels[status?.toString()] || status;
        },

        getStatusClass(status) {
            const classes = {
                0: "status-warning",
                1: "status-success",
                2: "status-danger",
            };
            return classes[status] || classes[status?.toString()] || "";
        },

        formatDate(dateString) {
            if (!dateString) return "";
            return new Date(dateString).toLocaleString("vi-VN");
        },

        truncateText(text, length) {
            if (!text) return "";
            return text.length > length ? text.substring(0, length) + "..." : text;
        },
    },
};
</script>

<style lang="scss">
@use "./style.scss";
</style>
