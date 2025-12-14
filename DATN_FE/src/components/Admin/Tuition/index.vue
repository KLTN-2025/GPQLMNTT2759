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

    <!-- Premium Payment Dashboard -->
    <div class="row g-4 mb-4">
        <!-- Payment Completion Rate - Enhanced -->
        <div class="col-xl-3 col-md-6">
            <div class="premium-stat-card card-gradient-blue">
                <div class="card-glow blue-glow"></div>
                <div class="card-pattern">
                    <div class="pattern-dots"></div>
                </div>
                <div class="card-content-wrapper">
                    <div class="stat-header">
                        <div class="stat-icon-box gradient-blue">
                            <i class="fas fa-chart-line"></i>
                            <div class="icon-shine"></div>
                        </div>
                        <div class="stat-badge badge-blue">
                            <i class="fas fa-trending-up"></i>
                        </div>
                    </div>
                    <div class="stat-body">
                        <div class="stat-title">
                            <i class="fas fa-percentage me-2"></i>
                            Tỷ Lệ Hoàn Thành
                        </div>
                        <div class="stat-number gradient-text-blue">
                            {{ paymentCompletionRate }}<span class="unit">%</span>
                        </div>
                        <div class="stat-progress-elegant">
                            <div class="progress-track">
                                <div class="progress-bar-fill gradient-blue-bar"
                                    :style="{ width: paymentCompletionRate + '%' }">
                                    <div class="progress-shine"></div>
                                </div>
                            </div>
                            <div class="progress-text">
                                <i class="fas fa-users me-1"></i>
                                {{ studentsFullyPaid }}/{{ totalStudents }} học sinh
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Students Fully Paid - Enhanced -->
        <div class="col-xl-3 col-md-6">
            <div class="premium-stat-card card-gradient-green">
                <div class="card-glow green-glow"></div>
                <div class="card-pattern">
                    <div class="pattern-dots"></div>
                </div>
                <div class="card-content-wrapper">
                    <div class="stat-header">
                        <div class="stat-icon-box gradient-green">
                            <i class="fas fa-check-double"></i>
                            <div class="icon-shine"></div>
                        </div>
                        <div class="stat-badge badge-green">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                    <div class="stat-body">
                        <div class="stat-title">
                            <i class="fas fa-user-check me-2"></i>
                            Đã Đóng Đủ
                        </div>
                        <div class="stat-number gradient-text-green">
                            {{ studentsFullyPaid }}<span class="unit">HS</span>
                        </div>
                        <div class="stat-footer success">
                            <div class="footer-icon">
                                <i class="fas fa-circle-check"></i>
                            </div>
                            <span>Hoàn thành thanh toán</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Students Partial Payment - Enhanced -->
        <div class="col-xl-3 col-md-6">
            <div class="premium-stat-card card-gradient-orange">
                <div class="card-glow orange-glow"></div>
                <div class="card-pattern">
                    <div class="pattern-dots"></div>
                </div>
                <div class="card-content-wrapper">
                    <div class="stat-header">
                        <div class="stat-icon-box gradient-orange">
                            <i class="fas fa-clock-rotate-left"></i>
                            <div class="icon-shine"></div>
                        </div>
                        <div class="stat-badge badge-orange">
                            <i class="fas fa-exclamation"></i>
                        </div>
                    </div>
                    <div class="stat-body">
                        <div class="stat-title">
                            <i class="fas fa-hourglass-half me-2"></i>
                            Nợ Một Phần
                        </div>
                        <div class="stat-number gradient-text-orange">
                            {{ studentsPartialPaid }}<span class="unit">HS</span>
                        </div>
                        <div class="stat-footer warning">
                            <div class="footer-icon">
                                <i class="fas fa-bell"></i>
                            </div>
                            <span>Cần theo dõi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Students Not Paid - Enhanced -->
        <div class="col-xl-3 col-md-6">
            <div class="premium-stat-card card-gradient-red">
                <div class="card-glow red-glow"></div>
                <div class="card-pattern">
                    <div class="pattern-dots"></div>
                </div>
                <div class="card-content-wrapper">
                    <div class="stat-header">
                        <div class="stat-icon-box gradient-red">
                            <i class="fas fa-exclamation-triangle"></i>
                            <div class="icon-shine"></div>
                        </div>
                        <div class="stat-badge badge-red pulse">
                            <i class="fas fa-bell"></i>
                        </div>
                    </div>
                    <div class="stat-body">
                        <div class="stat-title">
                            <i class="fas fa-user-times me-2"></i>
                            Chưa Đóng Phí
                        </div>
                        <div class="stat-number gradient-text-red">
                            {{ studentsNotPaid }}<span class="unit">HS</span>
                        </div>
                        <div class="stat-footer danger">
                            <div class="footer-icon">
                                <i class="fas fa-paper-plane"></i>
                            </div>
                            <span>Cần nhắc nhở ngay</span>
                        </div>
                    </div>
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
                            <h5 class="card-title">Tình Hình Thu Học Phí Theo Loại</h5>
                            <p class="card-subtitle">Phân tích thu học phí theo từng loại phí</p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tuition-chart-container">
                        <div v-for="(feeType, index) in list_loai_phi.slice(0, 3)" :key="index"
                            class="tuition-chart-item">
                            <div class="chart-header">
                                <div class="class-info">
                                    <span class="class-name">{{ feeType.ten_loai_phi }}</span>
                                    <span class="student-count">{{ feeType.so_hoc_sinh || 0 }} học sinh</span>
                                </div>
                                <div class="payment-percentage">
                                    <span class="percentage">{{ calculatePercentage(feeType.da_thu,
                                        feeType.tong_so_tien) }}%</span>
                                    <small>đã thu</small>
                                </div>
                            </div>
                            <div class="progress-container">
                                <div class="progress-bar">
                                    <div class="progress-fill paid"
                                        :style="{ width: calculatePercentage(feeType.da_thu, feeType.tong_so_tien) + '%' }">
                                    </div>
                                    <div class="progress-fill pending"
                                        :style="{ width: calculatePercentage(feeType.con_lai, feeType.tong_so_tien) + '%' }">
                                    </div>
                                </div>
                                <div class="progress-labels">
                                    <span class="label paid">{{ formatCurrency(feeType.da_thu || 0) }} đã thu</span>
                                    <span class="label pending">{{ formatCurrency(feeType.con_lai || 0) }} chưa
                                        thu</span>
                                </div>
                            </div>
                        </div>
                        <div v-if="list_loai_phi.length === 0" class="text-center py-5">
                            <i class="fas fa-money-bill-wave text-muted mb-3"
                                style="font-size: 3rem; opacity: 0.3;"></i>
                            <h6 class="text-muted">Chưa có loại phí nào</h6>
                            <p class="text-muted small">Thêm loại phí để bắt đầu quản lý</p>
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
                        <div v-for="(feeType, index) in list_loai_phi.slice(0, 3)" :key="index" class="stat-item">
                            <div class="stat-icon">
                                <i :class="getFeeIcon(feeType.loai_phi)"></i>
                            </div>
                            <div class="stat-content">
                                <div class="stat-title">{{ feeType.ten_loai_phi }}</div>
                                <div class="stat-value">
                                    {{ formatCurrency(feeType.da_thu || 0) }}/{{ formatCurrency(feeType.tong_so_tien ||
                                        0) }}
                                </div>
                                <div class="stat-status" :class="{
                                    'completed': calculatePercentage(feeType.da_thu, feeType.tong_so_tien) >= 100,
                                    'in-progress': calculatePercentage(feeType.da_thu, feeType.tong_so_tien) < 100
                                }">
                                    {{ calculatePercentage(feeType.da_thu, feeType.tong_so_tien) >= 100 ? 'Hoàn thành' :
                                        'Đang thu' }}
                                </div>
                            </div>
                        </div>
                        <div v-if="list_loai_phi.length === 0" class="text-center py-4">
                            <i class="fas fa-info-circle text-muted mb-2" style="font-size: 2rem;"></i>
                            <p class="text-muted small mb-0">Chưa có dữ liệu thống kê</p>
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
                                                <div class="fee-icon" :class="{
                                                    'fee-basic': value.loai_phi === 'hoc_phi_co_ban',
                                                    'fee-meal': value.loai_phi === 'phi_an_uong',
                                                    'fee-activity': value.loai_phi === 'phi_hoat_dong'
                                                }">
                                                    <i :class="value.loai_phi === 'hoc_phi_co_ban' ? 'fas fa-graduation-cap' :
                                                        value.loai_phi === 'phi_an_uong' ? 'fas fa-utensils' :
                                                            value.loai_phi === 'phi_hoat_dong' ? 'fas fa-running' :
                                                                'fas fa-money-bill-wave'"></i>
                                                </div>
                                                <div class="fee-details">
                                                    <span class="fee-name">{{ value.ten_loai_phi }}</span>
                                                    <small class="fee-type">
                                                        <template v-if="value.loai_phi === 'hoc_phi_co_ban'">Học phí cơ
                                                            bản</template>
                                                        <template v-else-if="value.loai_phi === 'phi_an_uong'">Phí ăn
                                                            uống</template>
                                                        <template v-else-if="value.loai_phi === 'phi_hoat_dong'">Phí
                                                            hoạt động</template>
                                                        <template v-else>{{ value.loai_phi }}</template>
                                                    </small>
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
                                            <span class="status-badge" :class="{
                                                'status-active': value.tinh_trang === 'active',
                                                'status-inactive': value.tinh_trang === 'inactive'
                                            }">
                                                <i :class="value.tinh_trang === 1 ? 'fas fa-check-circle' :
                                                    value.tinh_trang === 0 ? 'fas fa-times-circle' :
                                                        'fas fa-question'"></i>
                                                <template v-if="value.tinh_trang === 1">Đang áp dụng</template>
                                                <template v-else-if="value.tinh_trang === 0">Không áp
                                                    dụng</template>
                                                <template v-else>Chưa rõ</template>
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
                        <div class="row g-3">

                            <!-- Tên Loại Phí -->
                            <div class="col-md-6">
                                <label class="form-label">Tên Loại Phí *</label>
                                <input type="text" class="form-control" v-model="create_loai_phi.ten_loai_phi"
                                    placeholder="Nhập tên loại phí" required>
                            </div>

                            <!-- Loại Phí -->
                            <div class="col-md-6">
                                <label class="form-label">Loại Phí *</label>
                                <select class="form-select" v-model="create_loai_phi.loai_phi" required>
                                    <option value="">Chọn loại phí</option>
                                    <option value="hoc_phi_co_ban">Học phí cơ bản</option>
                                    <option value="phi_an_uong">Phí ăn uống</option>
                                    <option value="phi_hoat_dong">Phí hoạt động</option>
                                </select>
                            </div>

                            <!-- Mô Tả -->
                            <div class="col-12">
                                <label class="form-label">Mô Tả</label>
                                <textarea class="form-control" v-model="create_loai_phi.mo_ta" rows="3"
                                    placeholder="Nhập mô tả..."></textarea>
                            </div>

                            <!-- Ngày Áp Dụng -->
                            <div class="col-md-6">
                                <label class="form-label">Ngày Áp Dụng</label>
                                <input type="date" class="form-control" v-model="create_loai_phi.ap_dung_tu_ngay">
                            </div>

                            <!-- Ngày Kết Thúc -->
                            <div class="col-md-6">
                                <label class="form-label">Ngày Kết Thúc</label>
                                <input type="date" class="form-control" v-model="create_loai_phi.ap_dung_den_ngay">
                            </div>

                            <!-- Đơn Vị Tính -->
                            <div class="col-md-6">
                                <label class="form-label">Đơn Vị Tính</label>
                                <input type="text" class="form-control" v-model="create_loai_phi.don_vi_tinh"
                                    placeholder="Tháng">
                            </div>

                            <!-- Đơn Giá -->
                            <div class="col-md-6">
                                <label class="form-label">Đơn Giá (VNĐ)</label>
                                <input type="number" class="form-control" v-model="create_loai_phi.don_gia"
                                    placeholder="Nhập đơn giá">
                            </div>

                            <!-- Trạng Thái -->
                            <div class="col-12">
                                <label class="form-label">Trạng Thái</label>
                                <select class="form-select" v-model="create_loai_phi.trang_thai">
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
                        <div class="row g-3">

                            <!-- Tên Loại Phí -->
                            <div class="col-md-6">
                                <label class="form-label">Tên Loại Phí *</label>
                                <input type="text" class="form-control" v-model="update_loai_phi.ten_loai_phi"
                                    placeholder="Nhập tên loại phí" required>
                            </div>

                            <!-- Loại Phí -->
                            <div class="col-md-6">
                                <label class="form-label">Loại Phí *</label>
                                <select class="form-select" v-model="update_loai_phi.loai_phi" required>
                                    <option value="">Chọn loại phí</option>
                                    <option value="hoc_phi_co_ban">Học phí cơ bản</option>
                                    <option value="phi_an_uong">Phí ăn uống</option>
                                    <option value="phi_hoat_dong">Phí hoạt động</option>
                                </select>
                            </div>

                            <!-- Mô Tả -->
                            <div class="col-12">
                                <label class="form-label">Mô Tả</label>
                                <textarea class="form-control" v-model="update_loai_phi.mo_ta" rows="3"
                                    placeholder="Nhập mô tả..."></textarea>
                            </div>

                            <!-- Ngày Áp Dụng -->
                            <div class="col-md-6">
                                <label class="form-label">Ngày Áp Dụng</label>
                                <input type="date" class="form-control" v-model="update_loai_phi.ap_dung_tu_ngay">
                            </div>

                            <!-- Ngày Kết Thúc -->
                            <div class="col-md-6">
                                <label class="form-label">Ngày Kết Thúc</label>
                                <input type="date" class="form-control" v-model="update_loai_phi.ap_dung_den_ngay">
                            </div>

                            <!-- Đơn Vị Tính -->
                            <div class="col-md-6">
                                <label class="form-label">Đơn Vị Tính</label>
                                <input type="text" class="form-control" v-model="update_loai_phi.don_vi_tinh"
                                    placeholder="Tháng">
                            </div>

                            <!-- Đơn Giá -->
                            <div class="col-md-6">
                                <label class="form-label">Đơn Giá (VNĐ)</label>
                                <input type="number" class="form-control" v-model="update_loai_phi.don_gia"
                                    placeholder="Nhập đơn giá">
                            </div>

                            <!-- Trạng Thái -->
                            <div class="col-12">
                                <label class="form-label">Trạng Thái</label>
                                <select class="form-select" v-model="update_loai_phi.trang_thai">
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
                            <strong>Loại:</strong>
                            <template v-if="delete_loai_phi.loai_phi === 'hoc_phi_co_ban'">Học phí cơ bản</template>
                            <template v-else-if="delete_loai_phi.loai_phi === 'phi_an_uong'">Phí ăn uống</template>
                            <template v-else-if="delete_loai_phi.loai_phi === 'phi_hoat_dong'">Phí hoạt động</template>
                            <template v-else>{{ delete_loai_phi.loai_phi }}</template>
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
            list_hoc_sinh: [],
            create_loai_phi: {
                ten_loai_phi: "",
                loai_phi: "",
                mo_ta: "",
                ap_dung_tu_ngay: "",
                ap_dung_den_ngay: "",
                don_gia: "",
                don_vi_tinh: "",
                trang_thai: "active",
            },
            update_loai_phi: {
                id: "",
                ten_loai_phi: "",
                loai_phi: "",
                mo_ta: "",
                ap_dung_tu_ngay: "",
                ap_dung_den_ngay: "",
                don_gia: "",
                don_vi_tinh: "",
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

    computed: {
        totalRevenue() {
            // Tính tổng thu theo tháng hiện tại
            const currentMonth = new Date().getMonth() + 1;
            const currentYear = new Date().getFullYear();
            return this.list_loai_phi.reduce((total, item) => {
                // Giả sử da_thu là tổng đã thu trong tháng
                return total + (item.da_thu || 0);
            }, 0);
        },
        totalRemaining() {
            // Tính tổng còn phải thu = Tổng tiền - Đã thu
            const totalAmount = this.list_loai_phi.reduce((sum, item) => sum + (item.tong_so_tien || 0), 0);
            return totalAmount - this.totalRevenue;
        },
        totalStudents() {
            // Lấy số học sinh thực tế từ danh sách học sinh của trường
            return this.list_hoc_sinh.length;
        },
        // Số học sinh đã đóng đủ học phí
        studentsFullyPaid() {
            // Giả sử mỗi học sinh cần đóng tất cả các loại phí
            const requiredTotal = this.list_loai_phi.reduce((sum, item) => sum + (item.don_gia || 0), 0);
            return this.list_hoc_sinh.filter(student => {
                // Logic này cần được điều chỉnh dựa trên cấu trúc dữ liệu thực tế
                // Hiện tại tạm tính số học sinh có payment records đầy đủ
                return student.da_dong_day_du === 1 || student.trang_thai_thanh_toan === 'paid';
            }).length;
        },
        // Số học sinh đang nợ một phần
        studentsPartialPaid() {
            return this.list_hoc_sinh.filter(student => {
                return student.trang_thai_thanh_toan === 'partial' || (student.da_dong && !student.da_dong_day_du);
            }).length;
        },
        // Số học sinh chưa đóng phí
        studentsNotPaid() {
            return this.totalStudents - this.studentsFullyPaid - this.studentsPartialPaid;
        },
        // Tỷ lệ hoàn thành thanh toán
        paymentCompletionRate() {
            if (this.totalStudents === 0) return 0;
            return Math.round((this.studentsFullyPaid / this.totalStudents) * 100);
        }
    },

    mounted() {
        this.loadFeeData();
        this.loadStudents();
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

        calculatePercentage(part, total) {
            if (!total || total === 0) return 0;
            return Math.round((part / total) * 100);
        },

        getFeeIcon(feeType) {
            const icons = {
                'hoc_phi_co_ban': 'fas fa-graduation-cap',
                'phi_an_uong': 'fas fa-utensils',
                'phi_hoat_dong': 'fas fa-running'
            };
            return icons[feeType] || 'fas fa-money-bill-wave';
        },

        loadStudents() {
            baseRequestAdmin
                .get("admin/hoc-sinh/data")
                .then((res) => {
                    if (res.data.status) {
                        this.list_hoc_sinh = res.data.data;
                    }
                })
                .catch((err) => {
                    console.error("Không thể tải danh sách học sinh", err);
                });
        },

        loadFeeData() {
            baseRequestAdmin
                .get("admin/hoc-phi/data")
                .then((res) => {
                    if (res.data.status) {
                        // Gán vào cả 2 biến vì cùng dữ liệu
                        this.list_loai_phi = res.data.data;
                        this.list_hoc_phi = res.data.data;
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
