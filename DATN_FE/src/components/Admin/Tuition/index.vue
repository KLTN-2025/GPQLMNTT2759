<template>
    <div class="page-header education-theme">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-header-content">
                        <div class="page-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="page-info">
                            <h1 class="page-title">Quản lý Học Phí</h1>
                            <p class="page-subtitle">
                                Quản lý các loại phí và theo dõi thanh toán
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
                                <i class="fas fa-money-bill-wave"></i>
                                Học Phí
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Section -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stats-card stats-primary">
                <div class="stats-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number">{{ formatCurrency(getTotalRevenue()) }}</h3>
                    <p class="stats-label">Tổng Thu Tháng</p>
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
                        {{ getPaymentStatusCount('paid') }}
                    </h3>
                    <p class="stats-label">Đã Thanh Toán</p>
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
                        {{ getPaymentStatusCount('pending') }}
                    </h3>
                    <p class="stats-label">Chưa Thanh Toán</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card stats-danger">
                <div class="stats-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number">
                        {{ getPaymentStatusCount('overdue') }}
                    </h3>
                    <p class="stats-label">Quá Hạn</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tuition Dashboard Charts -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="dashboard-card">
                <div class="card-header-custom">
                    <div class="header-content">
                        <div class="header-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div class="header-text">
                            <h5 class="card-title">Tình Hình Thu Học Phí Theo Lớp</h5>
                            <p class="card-subtitle">Phân tích thu học phí theo từng lớp</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tuition-chart-container">
                        <div v-for="(classData, index) in getClassTuitionData()" :key="index"
                            class="tuition-chart-item">
                            <div class="chart-header">
                                <div class="class-info">
                                    <span class="class-name">{{ classData.className }}</span>
                                    <span class="student-count">{{ classData.totalStudents }} học sinh</span>
                                </div>
                                <div class="payment-percentage">
                                    <span class="percentage">{{ classData.paymentPercentage }}%</span>
                                    <small>đã thu</small>
                                </div>
                            </div>
                            <div class="progress-container">
                                <div class="progress-bar">
                                    <div class="progress-fill paid" :style="{ width: classData.paidPercentage + '%' }">
                                    </div>
                                    <div class="progress-fill pending"
                                        :style="{ width: classData.pendingPercentage + '%' }"></div>
                                    <div class="progress-fill overdue"
                                        :style="{ width: classData.overduePercentage + '%' }"></div>
                                </div>
                                <div class="progress-labels">
                                    <span class="label paid">{{ classData.paidCount }} đã thu</span>
                                    <span class="label pending">{{ classData.pendingCount }} chưa thu</span>
                                    <span class="label overdue">{{ classData.overdueCount }} quá hạn</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="dashboard-card">
                <div class="card-header-custom">
                    <div class="header-content">
                        <div class="header-icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <div class="header-text">
                            <h5 class="card-title">Thống Kê Thu Học Phí</h5>
                            <p class="card-subtitle">Phân tích chi tiết các loại phí</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tuition-stats">
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-title">Học phí cơ bản</div>
                                <div class="stat-value">{{ formatCurrency(getBasicTuitionRevenue()) }}/{{
                                    formatCurrency(getTotalBasicTuition()) }}</div>
                                <div class="stat-status completed">Đã thu</div>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-utensils"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-title">Phí ăn uống</div>
                                <div class="stat-value">{{ formatCurrency(getMealFeeRevenue()) }}/{{
                                    formatCurrency(getTotalMealFee()) }}</div>
                                <div class="stat-status completed">Đã thu</div>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon">
                                <i class="fas fa-running"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-title">Phí hoạt động</div>
                                <div class="stat-value">{{ formatCurrency(getActivityFeeRevenue()) }}/{{
                                    formatCurrency(getTotalActivityFee()) }}</div>
                                <div class="stat-status in-progress">Đang thu</div>
                            </div>
                        </div>
                    </div>
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
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="header-text">
                            <h5 class="card-title">Danh Sách Các Loại Phí</h5>
                            <p class="card-subtitle">Quản lý các loại phí và xem danh sách học sinh</p>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-modern" data-bs-toggle="modal" data-bs-target="#themModal">
                        <i class="fas fa-plus"></i>
                        Thêm Loại Phí
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
                                    class="search-input" placeholder="Tìm kiếm theo tên loại phí..." />
                            </div>

                            <div class="search-filters">
                                <select v-on:change="TiemKiem()" class="filter-select" v-model="search.lop_hoc">
                                    <option value="">Tất cả lớp</option>
                                    <option value="Lớp Mầm">Lớp Mầm</option>
                                    <option value="Lớp Chồi">Lớp Chồi</option>
                                    <option value="Lớp Lá">Lớp Lá</option>
                                </select>
                                <select v-on:change="TiemKiem()" class="filter-select" v-model="search.trang_thai">
                                    <option value="">Tất cả trạng thái</option>
                                    <option value="active">Đang áp dụng</option>
                                    <option value="inactive">Không áp dụng</option>
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
                                    <th class="text-center">Loại Phí</th>
                                    <th class="text-center">Mô Tả</th>
                                    <th class="text-center">Số Học Sinh</th>
                                    <th class="text-center">Tổng Số Tiền</th>
                                    <th class="text-center">Đã Thu</th>
                                    <th class="text-center">Trạng Thái</th>
                                    <th class="text-center">Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template v-for="(value, index) in list_loai_phi" :key="index">
                                    <tr class="table-row-hover" @click="viewFeeDetails(value)" style="cursor: pointer;">
                                        <td class="text-center table-index">
                                            {{ index + 1 }}
                                        </td>
                                        <td class="fee-info">
                                            <div class="fee-container">
                                                <div class="fee-icon" :class="getFeeTypeClass(value.loai_phi)">
                                                    <i :class="getFeeTypeIcon(value.loai_phi)"></i>
                                                </div>
                                                <div class="fee-details">
                                                    <span class="fee-name">{{ value.ten_loai_phi }}</span>
                                                    <small class="fee-type">{{ getFeeTypeLabel(value.loai_phi)
                                                        }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="">
                                            <span class="fee-description">{{ value.mo_ta || 'Chưa có mô tả'
                                                }}</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="student-count-badge">
                                                <div class="count-number">{{ value.so_hoc_sinh || 0 }}</div>
                                                <small class="count-label">học sinh</small>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="amount-info">
                                                <div class="total-amount">{{ formatCurrency(value.tong_so_tien) }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <div class="payment-info-clean">
                                                <div class="paid-amount-line">
                                                    <span class="payment-label">Đã thu:</span>
                                                    <span class="payment-value">{{ formatCurrency(value.da_thu)
                                                        }}</span>
                                                </div>
                                                <div class="remaining-amount-line"
                                                    :class="value.con_lai > 0 ? 'has-remaining' : 'fully-paid'">
                                                    <span class="payment-label">Còn lại:</span>
                                                    <span class="payment-value"
                                                        :class="value.con_lai > 0 ? 'text-warning' : 'text-success'">
                                                        {{ formatCurrency(value.con_lai) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="status-badge" :class="getStatusBadgeClass(value.tinh_trang)">
                                                <i :class="getStatusIcon(value.tinh_trang)"></i>
                                                {{ getStatusLabel(value.tinh_trang) }}
                                                {{ value.tinh_trang }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="action-buttons">
                                                <button class="btn-action btn-view" @click.stop="viewFeeDetails(value)"
                                                    title="Xem danh sách học sinh">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn-action btn-edit" @click.stop="openUpdateModal(value)"
                                                    data-bs-toggle="modal" data-bs-target="#capNhatModal"
                                                    title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn-action btn-delete"
                                                    @click.stop="Object.assign(delete_loai_phi, value)"
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

    <!-- Modal Thêm Loại Phí -->
    <div class="modal fade" id="themModal" tabindex="-1" aria-labelledby="themModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="themModalLabel">
                        <i class="fas fa-plus me-2"></i>
                        Thêm Loại Phí
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="tenLoaiPhi" class="form-label">Tên Loại Phí *</label>
                                <input type="text" class="form-control" id="tenLoaiPhi"
                                    v-model="create_loai_phi.ten_loai_phi" required />
                            </div>
                            <div class="col-md-6">
                                <label for="loaiPhi" class="form-label">Loại Phí *</label>
                                <select class="form-select" id="loaiPhi" v-model="create_loai_phi.loai_phi" required>
                                    <option value="">Chọn loại phí</option>
                                    <option value="hoc_phi_co_ban">Học phí cơ bản</option>
                                    <option value="phi_an_uong">Phí ăn uống</option>
                                    <option value="phi_hoat_dong">Phí hoạt động</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="moTa" class="form-label">Mô Tả</label>
                                <textarea class="form-control" id="moTa" v-model="create_loai_phi.mo_ta" rows="3"
                                    placeholder="Mô tả về loại phí..."></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="trangThai" class="form-label">Trạng Thái</label>
                                <select v-model="create_loai_phi.trang_thai" class="form-select">
                                    <option value="active">Đang áp dụng</option>
                                    <option value="inactive">Không áp dụng</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>
                        Hủy
                    </button>
                    <button type="button" class="btn btn-primary" @click="ThemLoaiPhi" :disabled="loading">
                        <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
                        <i v-else class="fas fa-save me-1"></i>
                        {{ loading ? 'Đang xử lý...' : 'Thêm Loại Phí' }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Cập Nhật Loại Phí -->
    <div class="modal fade" id="capNhatModal" tabindex="-1" aria-labelledby="capNhatModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="capNhatModalLabel">
                        <i class="fas fa-edit me-2"></i>
                        Cập Nhật Loại Phí
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="updateTenLoaiPhi" class="form-label">Tên Loại Phí *</label>
                                    <input type="text" class="form-control" id="updateTenLoaiPhi"
                                        v-model="update_loai_phi.ten_loai_phi" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="updateLoaiPhi" class="form-label">Loại Phí *</label>
                                    <select class="form-select" id="updateLoaiPhi" v-model="update_loai_phi.loai_phi"
                                        required>
                                        <option value="">Chọn loại phí</option>
                                        <option value="hoc_phi_co_ban">Học phí cơ bản</option>
                                        <option value="phi_an_uong">Phí ăn uống</option>
                                        <option value="phi_hoat_dong">Phí hoạt động</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="updateMoTa" class="form-label">Mô Tả</label>
                                    <textarea class="form-control" id="updateMoTa" v-model="update_loai_phi.mo_ta"
                                        rows="3" placeholder="Mô tả về loại phí..."></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="updateTrangThai" class="form-label">Trạng Thái</label>
                                    <select v-model="update_loai_phi.trang_thai" class="form-select">
                                        <option value="active">Đang áp dụng</option>
                                        <option value="inactive">Không áp dụng</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>
                        Hủy
                    </button>
                    <button type="button" class="btn btn-primary" @click="CapNhatLoaiPhi" :disabled="loading">
                        <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
                        <i v-else class="fas fa-save me-1"></i>
                        {{ loading ? 'Đang xử lý...' : 'Cập Nhật' }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Xóa Loại Phí -->
    <div class="modal fade" id="xoaModal" tabindex="-1" aria-labelledby="xoaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="xoaModalLabel">
                        <i class="fas fa-exclamation-triangle me-2 text-warning"></i>
                        Xác Nhận Xóa Loại Phí
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <div class="mb-3">
                            <i class="fas fa-money-bill-wave text-danger" style="font-size: 3rem;"></i>
                        </div>
                        <h6>Bạn có chắc chắn muốn xóa loại phí này không?</h6>
                        <div class="alert alert-warning" role="alert">
                            <strong>Thông tin loại phí:</strong><br>
                            <strong>Tên:</strong> {{ delete_loai_phi.ten_loai_phi }}<br>
                            <strong>Loại:</strong> {{ getFeeTypeLabel(delete_loai_phi.loai_phi) }}
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
                    <button type="button" class="btn btn-danger" @click="XoaLoaiPhi" :disabled="loading">
                        <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
                        <i v-else class="fas fa-trash me-1"></i>
                        {{ loading ? 'Đang xử lý...' : 'Xóa Loại Phí' }}
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
            list_loai_phi: [],
            list_hoc_phi: [],
            create_loai_phi: {
                ten_loai_phi: "",
                loai_phi: "",
                mo_ta: "",
                trang_thai: "active",
            },
            update_loai_phi: {
                id: "",
                ten_loai_phi: "",
                loai_phi: "",
                mo_ta: "",
                trang_thai: "",
            },
            delete_loai_phi: {
                id: "",
                ten_loai_phi: "",
                loai_phi: "",
            },
            search: {
                noi_dung: "",
                lop_hoc: "",
                trang_thai: "",
            },
            loading: false,
            modalOpen: false,
        };
    },

    mounted() {
        this.loadData();
        this.loadFeeData();
    },

    methods: {
        formatCurrency(amount) {
            if (!amount) return "0 VNĐ";
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(amount);
        },

        formatDate(dateString) {
            if (!dateString) return "";
            const date = new Date(dateString);
            return date.toLocaleDateString("vi-VN");
        },

        getTotalRevenue() {
            return this.list_loai_phi.reduce((total, item) => total + (item.da_thu || 0), 0);
        },

        getPaymentStatusCount(status) {
            // Tính từ danh sách học phí liên quan đến các loại phí
            return this.list_hoc_phi.filter(item => item.trang_thai === status).length;
        },

        getClassTuitionData() {
            const classes = ['Lớp Mầm', 'Lớp Chồi', 'Lớp Lá'];
            return classes.map(className => {
                const classStudents = this.list_hoc_phi.filter(item => item.lop_hoc === className);
                const totalStudents = classStudents.length;
                const paidCount = classStudents.filter(item => item.trang_thai === 'paid').length;
                const pendingCount = classStudents.filter(item => item.trang_thai === 'pending').length;
                const overdueCount = classStudents.filter(item => item.trang_thai === 'overdue').length;

                return {
                    className,
                    totalStudents,
                    paidCount,
                    pendingCount,
                    overdueCount,
                    paidPercentage: totalStudents > 0 ? Math.round((paidCount / totalStudents) * 100) : 0,
                    pendingPercentage: totalStudents > 0 ? Math.round((pendingCount / totalStudents) * 100) : 0,
                    overduePercentage: totalStudents > 0 ? Math.round((overdueCount / totalStudents) * 100) : 0,
                    paymentPercentage: totalStudents > 0 ? Math.round((paidCount / totalStudents) * 100) : 0,
                };
            });
        },

        getBasicTuitionRevenue() {
            const basicFee = this.list_loai_phi.find(item => item.loai_phi === 'hoc_phi_co_ban');
            return basicFee ? (basicFee.da_thu || 0) : 0;
        },

        getTotalBasicTuition() {
            const basicFee = this.list_loai_phi.find(item => item.loai_phi === 'hoc_phi_co_ban');
            return basicFee ? (basicFee.tong_tien || 0) : 0;
        },

        getMealFeeRevenue() {
            const mealFee = this.list_loai_phi.find(item => item.loai_phi === 'phi_an_uong');
            return mealFee ? (mealFee.da_thu || 0) : 0;
        },

        getTotalMealFee() {
            const mealFee = this.list_loai_phi.find(item => item.loai_phi === 'phi_an_uong');
            return mealFee ? (mealFee.tong_tien || 0) : 0;
        },

        getActivityFeeRevenue() {
            const activityFee = this.list_loai_phi.find(item => item.loai_phi === 'phi_hoat_dong');
            return activityFee ? (activityFee.da_thu || 0) : 0;
        },

        getTotalActivityFee() {
            const activityFee = this.list_loai_phi.find(item => item.loai_phi === 'phi_hoat_dong');
            return activityFee ? (activityFee.tong_tien || 0) : 0;
        },

        getFeeTypeLabel(type) {
            const labels = {
                'hoc_phi_co_ban': 'Học phí cơ bản',
                'phi_an_uong': 'Phí ăn uống',
                'phi_hoat_dong': 'Phí hoạt động'
            };
            return labels[type] || type;
        },

        getFeeTypeIcon(type) {
            switch (type) {
                case 'hoc_phi_co_ban':
                    return 'fas fa-graduation-cap';
                case 'phi_an_uong':
                    return 'fas fa-utensils';
                case 'phi_hoat_dong':
                    return 'fas fa-running';
                default:
                    return 'fas fa-money-bill-wave';
            }
        },

        getFeeTypeClass(type) {
            return {
                'fee-basic': type === 'hoc_phi_co_ban',
                'fee-meal': type === 'phi_an_uong',
                'fee-activity': type === 'phi_hoat_dong',
            };
        },

        getStatusLabel(status) {
            switch (status) {
                case 'active':
                    return 'Đang áp dụng';
                case 'inactive':
                    return 'Không áp dụng';
                default:
                    return 'Chưa rõ';
            }
        },

        getStatusBadgeClass(status) {
            return {
                'status-active': status === 'active',
                'status-inactive': status === 'inactive',
            };
        },

        getStatusIcon(status) {
            switch (status) {
                case 'active':
                    return 'fas fa-check-circle';
                case 'inactive':
                    return 'fas fa-times-circle';
                default:
                    return 'fas fa-question';
            }
        },

        loadData() {
            // Load danh sách học phí để tính toán thống kê
            baseRequestAdmin
                .get("admin/hoc-phi/data")
                .then((res) => {
                    if (res.data.status) {
                        this.list_hoc_phi = res.data.data;
                    }
                })
                .catch((err) => {
                    console.log("Không thể tải danh sách học phí");
                });
        },

        loadFeeData() {
            baseRequestAdmin
                .get("admin/hoc-phi/data")
                .then((res) => {
                    if (res.data.status) {
                        this.list_loai_phi = res.data.data;
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

        ThemLoaiPhi() {
            this.loading = true;
            baseRequestAdmin
                .post("admin/hoc-phi/create", this.create_loai_phi)
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.loadFeeData();
                        this.resetCreateForm();
                        const modal = bootstrap.Modal.getInstance(document.getElementById("themModal"));
                        if (modal) {
                            modal.hide();
                            this.modalOpen = false;
                        }
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
                        this.$toast.error("Có lỗi xảy ra khi thêm loại phí");
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        openUpdateModal(fee) {
            this.update_loai_phi = {
                id: fee.id || "",
                ten_loai_phi: fee.ten_loai_phi || "",
                loai_phi: fee.loai_phi || "",
                mo_ta: fee.mo_ta || "",
                trang_thai: fee.trang_thai || "active",
            };
        },

        CapNhatLoaiPhi() {
            this.loading = true;
            baseRequestAdmin
                .post("admin/hoc-phi/update", this.update_loai_phi)
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.loadFeeData();
                        const modal = bootstrap.Modal.getInstance(document.getElementById("capNhatModal"));
                        if (modal) {
                            modal.hide();
                            this.modalOpen = false;
                        }
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
                        this.$toast.error("Có lỗi xảy ra khi cập nhật loại phí");
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        XoaLoaiPhi() {
            this.loading = true;
            baseRequestAdmin
                .post("admin/hoc-phi/delete", this.delete_loai_phi)
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.loadFeeData();
                        this.delete_loai_phi = {};
                        const modal = bootstrap.Modal.getInstance(document.getElementById("xoaModal"));
                        if (modal) {
                            modal.hide();
                            this.modalOpen = false;
                        }
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
                        this.$toast.error("Có lỗi xảy ra khi xóa loại phí");
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        TiemKiem() {
            baseRequestAdmin
                .post("admin/hoc-phi/search", this.search)
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.list_loai_phi = res.data.data;
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

        viewFeeDetails(fee) {
            // Navigate đến trang chi tiết với ID loại phí
            this.$router.push({
                path: '/admin/hoc-phi/chi-tiet',
                query: { id: fee.id, loai_phi: fee.loai_phi }
            });
        },

        resetCreateForm() {
            this.create_loai_phi = {
                ten_loai_phi: "",
                loai_phi: "",
                mo_ta: "",
                trang_thai: "active",
            };
        },
    },
};
</script>

<style lang="scss">
@use "./style.scss";
</style>
