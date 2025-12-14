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
                                    <option value="0">Toàn Trường</option>
                                    <option value="1">Theo Lớp</option>
                                    <option value="2">Cá Nhân</option>
                                    <option value="3">Hệ Thống</option>
                                    <option value="4">Sự Kiện</option>
                                    <option value="5">Khẩn Cấp</option>
                                </select>
                                <select class="filter-select" v-model="filterStatus" @change="loadData">
                                    <option value="">Tất cả trạng thái</option>
                                    <option value="0">Chờ gửi</option>
                                    <option value="1">Đã gửi</option>
                                    <option value="2">Đã hủy</option>
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
                                            <small class="text-muted">
                                                {{ truncatedContent(notification.noi_dung) }}
                                            </small>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="type-badge"
                                            :class="typeDescriptor(notification.loai_thong_bao).badge">
                                            <i :class="typeDescriptor(notification.loai_thong_bao).icon"></i>
                                            {{ typeDescriptor(notification.loai_thong_bao).label }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="audience-badge">
                                            <i :class="audienceDescriptor(notification.doi_tuong_nhan).icon"></i>
                                            {{ audienceDescriptor(notification.doi_tuong_nhan).label }}
                                        </span>
                                    </td>
                                    <td class="">
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
                                        <button class="btn btn-sm w-100"
                                            :class="statusDescriptor(notification.tinh_trang).buttonClass"
                                            @click="DoiTrangThai(notification)">
                                            <i :class="statusDescriptor(notification.tinh_trang).icon"></i>
                                            {{ statusDescriptor(notification.tinh_trang).label }}
                                        </button>
                                    </td>
                                    <td class="text-center">
                                        <div class="action-buttons">
                                            <button v-if="notification.tinh_trang == 0" class="btn-action btn-send"
                                                @click="MoModalGui(notification)" title="Gửi thông báo">
                                                <i class="fas fa-paper-plane"></i>
                                            </button>
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

    <!-- Add Modal (Simplified) -->
    <div class="modal fade" id="themModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus-circle me-2"></i>
                        Tạo Thông Báo Mới
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
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-tags me-1"></i> Loại thông báo <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" v-model.number="new_thong_bao.loai_thong_bao" required>
                                <option value="">Chọn loại</option>
                                <option :value="0">Toàn Trường</option>
                                <option :value="1">Theo Lớp</option>
                                <option :value="2">Cá Nhân</option>
                                <option :value="3">Hệ Thống</option>
                                <option :value="4">Sự Kiện</option>
                                <option :value="5">Khẩn Cấp</option>
                            </select>
                        </div>
                        <div class="alert alert-info" role="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Lưu ý:</strong> Thông báo sẽ được tạo với trạng thái "Chờ gửi".
                            Bạn cần chọn người nhận và gửi thông báo sau khi tạo.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Đóng
                        </button>
                        <button type="submit" class="btn btn-primary" :disabled="loading">
                            <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
                            <i v-else class="fas fa-save me-1"></i>
                            {{ loading ? 'Đang xử lý...' : 'Tạo Thông Báo' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Send Modal (New) -->
    <div class="modal fade" id="guiModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-paper-plane me-2"></i>
                        Gửi Thông Báo
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form @submit.prevent="GuiThongBao">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">
                                <strong>Tiêu đề:</strong> {{ send_thong_bao.tieu_de }}
                            </label>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="fas fa-users me-1"></i> Đối tượng nhận <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" v-model="send_data.doi_tuong_nhan" required>
                                <option value="">Chọn đối tượng</option>
                                <option value="tat_ca">Tất cả</option>
                                <option value="phu_huynh">Phụ huynh</option>
                                <option value="giao_vien">Giáo viên</option>
                                <option value="lop">Theo lớp</option>
                            </select>
                        </div>
                        <div class="mb-3" v-if="send_data.doi_tuong_nhan === 'lop'">
                            <label class="form-label">
                                <i class="fas fa-graduation-cap me-1"></i> Chọn lớp <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" v-model="send_data.id_lop" required>
                                <option value="">Chọn lớp</option>
                                <option v-for="lop in list_lop" :key="lop.id" :value="lop.id">
                                    {{ lop.ten_lop }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Hủy
                        </button>
                        <button type="submit" class="btn btn-success" :disabled="loading">
                            <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
                            <i v-else class="fas fa-paper-plane me-1"></i>
                            {{ loading ? 'Đang gửi...' : 'Gửi Ngay' }}
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
                                <select class="form-select" v-model.number="update_thong_bao.loai_thong_bao" required>
                                    <option :value="0">Toàn Trường</option>
                                    <option :value="1">Theo Lớp</option>
                                    <option :value="2">Cá Nhân</option>
                                    <option :value="3">Hệ Thống</option>
                                    <option :value="4">Sự Kiện</option>
                                    <option :value="5">Khẩn Cấp</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Trạng thái</label>
                                <select class="form-select" v-model.number="update_thong_bao.tinh_trang" required>
                                    <option :value="0">Chờ gửi</option>
                                    <option :value="1">Đã gửi</option>
                                    <option :value="2">Đã huỷ</option>
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
                                <span class="type-badge" :class="typeDescriptor(view_thong_bao.loai_thong_bao).badge">
                                    <i :class="typeDescriptor(view_thong_bao.loai_thong_bao).icon"></i>
                                    {{ typeDescriptor(view_thong_bao.loai_thong_bao).label }}
                                </span>
                                <span class="status-badge"
                                    :class="statusDescriptor(view_thong_bao.tinh_trang).badgeClass">
                                    {{ statusDescriptor(view_thong_bao.tinh_trang).label }}
                                </span>
                            </div>
                        </div>
                        <div class="detail-content">
                            <p>{{ view_thong_bao.noi_dung }}</p>
                        </div>
                        <div class="detail-info">
                            <p>
                                <strong>Đối tượng:</strong>
                                {{ audienceDescriptor(view_thong_bao.doi_tuong_nhan).label }}
                            </p>
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
            send_thong_bao: {}, // Notification to send
            send_data: {
                doi_tuong_nhan: "",
                id_lop: "",
            },
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

    computed: {
        truncatedContent() {
            return (text, limit = 50) => {
                if (!text) return "";
                return text.length > limit ? text.substring(0, limit) + "..." : text;
            };
        },
        typeDescriptor() {
            const descriptors = {
                toan_truong: { label: "Toàn Trường", badge: "type-system", icon: "fas fa-building" },
                theo_lop: { label: "Theo Lớp", badge: "type-admin", icon: "fas fa-chalkboard" },
                ca_nhan: { label: "Cá Nhân", badge: "type-classroom", icon: "fas fa-user" },
                he_thong: { label: "Hệ Thống", badge: "type-event", icon: "fas fa-cog" },
                su_kien: { label: "Sự Kiện", badge: "type-event", icon: "fas fa-calendar-star" },
                khan_cap: { label: "Khẩn Cấp", badge: "type-alert", icon: "fas fa-exclamation-triangle" },
            };
            return (value) => descriptors[this.normalizeTypeKey(value)] || descriptors.toan_truong;
        },
        audienceDescriptor() {
            const descriptors = {
                tat_ca: { label: "Tất cả", icon: "fas fa-users" },
                phu_huynh: { label: "Phụ huynh", icon: "fas fa-user-friends" },
                giao_vien: { label: "Giáo viên", icon: "fas fa-chalkboard-teacher" },
                lop: { label: "Theo lớp", icon: "fas fa-layer-group" },
                he_thong: { label: "Hệ thống", icon: "fas fa-globe" },
            };
            return (value) => descriptors[this.normalizeAudienceKey(value)] || descriptors.tat_ca;
        },
        statusDescriptor() {
            const descriptors = {
                pending: {
                    label: "Chờ gửi",
                    icon: "fas fa-clock",
                    buttonClass: "btn-warning",
                    badgeClass: "status-warning",
                },
                sent: {
                    label: "Đã gửi",
                    icon: "fas fa-check-circle",
                    buttonClass: "btn-success",
                    badgeClass: "status-success",
                },
                cancelled: {
                    label: "Đã Huỷ",
                    icon: "fas fa-times-circle",
                    buttonClass: "btn-danger",
                    badgeClass: "status-danger",
                },
            };
            return (value) => descriptors[this.normalizeStatusKey(value)] || descriptors.pending;
        },
    },

    mounted() {
        this.loadData();
        this.loadClasses();
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

        // Load all data (initial load without filters)
        loadAllData() {
            baseRequestAdmin.get("admin/thong-bao/data").then((res) => {
                if (res.data.status) {
                    this.list_thong_bao = res.data.data || [];
                    this.updateStatsFromList();
                } else {
                    this.$toast.error(res.data.message || "Không thể tải dữ liệu");
                }
            }).catch((err) => {
                console.error("Error loading data:", err);
                this.$toast.error("Có lỗi xảy ra khi tải dữ liệu");
            });
        },

        // Search/filter data
        searchData() {
            const params = {
                search: this.searchKeyword,
                loai_thong_bao: this.filterType,
                tinh_trang: this.filterStatus,
            };
            baseRequestAdmin.post("admin/thong-bao/search", params).then((res) => {
                if (res.data.status) {
                    this.list_thong_bao = res.data.data || [];
                    this.updateStatsFromList();
                } else {
                    this.$toast.error(res.data.message || "Không tìm thấy kết quả");
                }
            }).catch((err) => {
                console.error("Error searching:", err);
                this.$toast.error("Có lỗi xảy ra khi tìm kiếm");
            });
        },

        // Wrapper function to use appropriate method
        loadData() {
            // If any filter is active, use search, otherwise load all
            if (this.searchKeyword || this.filterType || this.filterStatus) {
                this.searchData();
            } else {
                this.loadAllData();
            }
        },

        updateStatsFromList() {
            if (!Array.isArray(this.list_thong_bao)) {
                this.totalSent = 0;
                this.totalRead = 0;
                this.scheduled = 0;
                this.readRate = 0;
                return;
            }
            const summary = this.list_thong_bao.reduce(
                (acc, item) => {
                    const status = Number(item.tinh_trang);
                    if (status === 1) acc.sent += 1;
                    if (status === 0) acc.scheduled += 1;
                    const readCount = Number(
                        item.tong_so_da_doc ??
                        item.so_da_doc ??
                        item.da_doc ??
                        0
                    );
                    if (!Number.isNaN(readCount)) {
                        acc.read += readCount;
                    }
                    const recipients = Number(item.tong_so_nguoi_nhan ?? 0);
                    if (!Number.isNaN(recipients)) {
                        acc.recipients += recipients;
                    }
                    return acc;
                },
                { sent: 0, scheduled: 0, read: 0, recipients: 0 }
            );
            this.totalSent = summary.sent;
            this.scheduled = summary.scheduled;
            this.totalRead = summary.read;
            this.readRate = summary.recipients
                ? Math.round((summary.read / summary.recipients) * 100)
                : (summary.sent ? 100 : 0);
        },

        loadClasses() {
            baseRequestAdmin.get("admin/lop-hoc/data").then((res) => {
                if (res.data.status) {
                    this.list_lop = res.data.data || [];
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

        MoModalGui(thong_bao) {
            this.send_thong_bao = { ...thong_bao };
            this.send_data = {
                doi_tuong_nhan: "",
                id_lop: "",
            };
            const modal = new bootstrap.Modal(document.getElementById("guiModal"));
            modal.show();
        },

        GuiThongBao() {
            this.loading = true;
            const payload = {
                id_thong_bao: this.send_thong_bao.id,
                doi_tuong_nhan: this.send_data.doi_tuong_nhan,
                id_lop: this.send_data.id_lop,
            };

            baseRequestAdmin
                .post("admin/thong-bao/send", payload)
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.loadData();
                        this.closeModal("guiModal");
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
                        this.$toast.error("Có lỗi xảy ra khi gửi thông báo");
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

        DoiTrangThai(thong_bao) {
            const currentStatus = Number(thong_bao.tinh_trang);
            const transitions = {
                0: { next: 1, message: "Chuyển trạng thái sang 'Đã gửi'?" },
                1: { next: 2, message: "Đánh dấu thông báo này là 'Đã hủy'?" },
                2: { next: 0, message: "Chuyển trạng thái về 'Chờ gửi'?" },
            };
            const transition = transitions[currentStatus] || transitions[0];
            if (!confirm(transition.message)) {
                return;
            }
            this.loading = true;
            baseRequestAdmin
                .post("admin/thong-bao/change-status", {
                    id: thong_bao.id,
                    tinh_trang: transition.next,
                })
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.loadData();
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
                        this.$toast.error("Có lỗi xảy ra khi đổi trạng thái");
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        normalizeTypeKey(value) {
            const key = String(value ?? "").toLowerCase().trim();
            const mapping = {
                "0": "toan_truong",
                "1": "theo_lop",
                "2": "ca_nhan",
                "3": "he_thong",
                "4": "su_kien",
                "5": "khan_cap",
                system: "toan_truong",
                admin: "theo_lop",
                classroom: "ca_nhan",
                event: "su_kien",
                alert: "khan_cap",
            };
            return mapping[key] || "toan_truong";
        },

        normalizeAudienceKey(value) {
            const key = String(value ?? "").toLowerCase().trim();
            const mapping = {
                tat_ca: "tat_ca",
                "tat-ca": "tat_ca",
                all: "tat_ca",
                phu_huynh: "phu_huynh",
                "phu-huynh": "phu_huynh",
                parents: "phu_huynh",
                giao_vien: "giao_vien",
                "giao-vien": "giao_vien",
                teachers: "giao_vien",
                lop: "lop",
                class: "lop",
                he_thong: "he_thong",
                system: "he_thong",
            };
            return mapping[key] || "tat_ca";
        },

        normalizeStatusKey(value) {
            const key = String(value ?? "").toLowerCase().trim();
            const mapping = {
                "0": "pending",
                cho_gui: "pending",
                pending: "pending",
                waiting: "pending",
                "1": "sent",
                da_gui: "sent",
                sent: "sent",
                delivered: "sent",
                "2": "cancelled",
                da_huy: "cancelled",
                cancelled: "cancelled",
                cancel: "cancelled",
            };
            return mapping[key] || "pending";
        },

        formatDate(dateString) {
            if (!dateString) return "";
            return new Date(dateString).toLocaleString("vi-VN");
        },
    },
};
</script>

<style lang="scss">
@use "./style.scss";
</style>
