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
                        {{list_lop_hoc.filter((lh) => lh.is_block == 0).length}}
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
                        {{list_lop_hoc.filter((lh) => lh.is_block == 1).length}}
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
            <div class="management-card">
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
                    <div class="header-actions">
                        <button class="btn btn-outline-success btn-sm me-2" @click="exportClassesExcel">
                            <i class="fas fa-file-excel"></i> Xuất Excel
                        </button>
                        <button class="btn btn-primary btn-modern" data-bs-toggle="modal" data-bs-target="#themModal">
                            <i class="fas fa-plus"></i>
                            Thêm Lớp Học
                        </button>
                    </div>
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
                                <select v-on:change="TiemKiem()" class="filter-select" v-model="search.is_block">
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
                                                    <i class="fas fa-book"></i>
                                                    <span>{{ value.ten_khoi_lop }}</span>
                                                </div>
                                                <div class="info-item">
                                                    <i class="fas fa-calendar"></i>
                                                    <span>{{ value.ten_nam_hoc }}</span>
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
                                                <button class="btn-action btn-edit" @click="OpenUpdateModal(value)"
                                                    data-bs-toggle="modal" data-bs-target="#capNhatModal"
                                                    title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn-action btn-view" @click="viewClassDetails(value)"
                                                    title="Xem chi tiết">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="btn-action btn-delete" @click="OpenDeleteModal(value)"
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
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="updateTenLop" class="form-label">Tên Lớp *</label>
                                    <input type="text" class="form-control" id="updateTenLop"
                                        v-model="update_lop_hoc.ten_lop" required />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="updateNamHoc" class="form-label">Năm Học *</label>
                                    <select class="form-select" id="updateNamHoc" v-model="update_lop_hoc.id_nam_hoc"
                                        required>
                                        <option value="">Chọn Năm Học</option>
                                        <option v-for="nh in list_nam_hoc" :key="nh.id" :value="nh.id">{{ nh.ten_nam_hoc
                                            }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="updateKhoiLop" class="form-label">Khối Lớp *</label>
                                    <select class="form-select" id="updateKhoiLop" v-model="update_lop_hoc.id_khoi_lop"
                                        required>
                                        <option value="">Chọn khối lớp</option>
                                        <option v-for="kl in list_khoi_lop" :key="kl.id" :value="kl.id">
                                            {{ kl.ten_khoi_lop }} ({{ kl.do_tuoi }} tuổi)
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="updateSoLuongToiDa" class="form-label">Số Lượng Tối Đa *</label>
                                    <input type="number" class="form-control" id="updateSoLuongToiDa"
                                        v-model="update_lop_hoc.so_luong" min="1" max="30" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="updateTinhTrang" class="form-label">Tình Trạng</label>
                                    <select v-model="update_lop_hoc.is_block" class="form-select">
                                        <option value="0">Hoạt Động</option>
                                        <option value="1">Tạm Ngừng</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="updateGiaoVienChuNhiem" class="form-label">Giáo Viên Chủ Nhiệm *</label>
                                    <select class="form-select" id="updateGiaoVienChuNhiem"
                                        v-model="update_lop_hoc.id_giao_vien" required>
                                        <option value="">Chọn giáo viên</option>
                                        <option v-for="gv in list_giao_vien" :key="gv.id" :value="gv.id">
                                            {{ gv.ho_va_ten }}
                                        </option>
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
                            <strong>Khối lớp:</strong> {{ delete_lop_hoc.ten_khoi_lop || 'N/A' }}<br>
                            <strong>Năm học:</strong> {{ delete_lop_hoc.ten_nam_hoc || 'N/A' }}
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

    <!-- Modal Chi Tiết Lớp Học -->
    <div class="modal fade" id="chiTietModal" tabindex="-1" aria-labelledby="chiTietModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="chiTietModalLabel">
                        <i class="fas fa-info-circle me-2"></i>
                        Chi Tiết Lớp Học
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Thông Tin Lớp Học -->
                    <div class="class-detail-section mb-4">
                        <h6 class="section-title">
                            <i class="fas fa-graduation-cap me-2"></i>
                            Thông Tin Lớp Học
                        </h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="info-card">
                                    <div class="info-label">
                                        <i class="fas fa-tag me-2"></i>
                                        Tên Lớp:
                                    </div>
                                    <div class="info-value">{{ selected_lop_hoc.ten_lop || 'N/A' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-card">
                                    <div class="info-label">
                                        <i class="fas fa-book me-2"></i>
                                        Khối Lớp:
                                    </div>
                                    <div class="info-value">{{ selected_lop_hoc.ten_khoi_lop || 'N/A' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-card">
                                    <div class="info-label">
                                        <i class="fas fa-calendar-alt me-2"></i>
                                        Độ Tuổi:
                                    </div>
                                    <div class="info-value">{{ selected_lop_hoc.do_tuoi || 'N/A' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-card">
                                    <div class="info-label">
                                        <i class="fas fa-calendar me-2"></i>
                                        Năm Học:
                                    </div>
                                    <div class="info-value">{{ selected_lop_hoc.ten_nam_hoc || 'N/A' }}</div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-card">
                                    <div class="info-label">
                                        <i class="fas fa-user-tie me-2"></i>
                                        Giáo Viên Chủ Nhiệm:
                                    </div>
                                    <div class="info-value">{{ selected_lop_hoc.ten_giao_vien || 'Chưa phân công' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-card">
                                    <div class="info-label">
                                        <i class="fas fa-users me-2"></i>
                                        Số Lượng Học Sinh:
                                    </div>
                                    <div class="info-value">
                                        {{ selected_lop_hoc.tong_hoc_sinh || 0 }} / {{ selected_lop_hoc.so_luong || 0 }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="info-card">
                                    <div class="info-label">
                                        <i class="fas fa-check-circle me-2"></i>
                                        Trạng Thái:
                                    </div>
                                    <div class="info-value">
                                        <span v-if="selected_lop_hoc.is_block == 0" class="badge bg-success">Hoạt
                                            Động</span>
                                        <span v-else class="badge bg-warning">Tạm Ngừng</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Danh Sách Học Sinh -->
                    <div class="students-detail-section">
                        <h6 class="section-title">
                            <i class="fas fa-child me-2"></i>
                            Danh Sách Học Sinh
                            <span class="badge bg-primary ms-2">{{ list_hoc_sinh_lop.length }}</span>
                        </h6>

                        <div v-if="loading_students" class="text-center py-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Đang tải...</span>
                            </div>
                            <p class="mt-2">Đang tải danh sách học sinh...</p>
                        </div>

                        <div v-else-if="list_hoc_sinh_lop.length === 0" class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Lớp học chưa có học sinh nào</p>
                        </div>

                        <div v-else class="table-container">
                            <table class="table table-modern table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Tên Học Sinh</th>
                                        <th>Phụ Huynh</th>
                                        <th>Quan Hệ</th>
                                        <th>Số Điện Thoại</th>
                                        <th>Địa Chỉ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(hs, index) in list_hoc_sinh_lop" :key="hs.id">
                                        <td class="text-center">{{ index + 1 }}</td>
                                        <td>
                                            <div class="student-name">
                                                <i class="fas fa-user-graduate me-2 text-primary"></i>
                                                <strong>{{ hs.ho_va_ten || 'N/A' }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="parent-name">
                                                <i class="fas fa-user me-2 text-info"></i>
                                                {{ hs.ten_phu_huynh || 'N/A' }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">
                                                {{ hs.quan_he || 'N/A' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="phone-number">
                                                <i class="fas fa-phone me-2 text-success"></i>
                                                <a :href="`tel:${hs.so_dien_thoai}`" class="text-decoration-none">
                                                    {{ hs.so_dien_thoai || 'N/A' }}
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="address">
                                                <i class="fas fa-map-marker-alt me-2 text-danger"></i>
                                                <span>{{ hs.dia_chi || 'N/A' }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>
                        Đóng
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
                                    <option v-for="nh in list_nam_hoc" :key="nh.id" :value="nh.id">{{ nh.ten_nam_hoc }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="doTuoi" class="form-label">Khối Lớp *</label>
                                <select class="form-select" id="doTuoi" v-model="create_lop_hoc.id_khoi_lop" required>
                                    <option value="">Chọn khối lớp</option>
                                    <option v-for="kl in list_khoi_lop" :key="kl.id" :value="kl.id">
                                        {{ kl.ten_khoi_lop }} ({{ kl.do_tuoi }} tuổi)
                                    </option>
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
                                <select class="form-select" id="giaoVienChuNhiem" v-model="create_lop_hoc.id_giao_vien"
                                    required>
                                    <option value="">Chọn giáo viên</option>
                                    <option v-for="gv in list_giao_vien" :key="gv.id" :value="gv.id">
                                        {{ gv.ho_va_ten }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="tinhTrang" class="form-label">Tình Trạng</label>
                                <select v-model="create_lop_hoc.is_block" class="form-select">
                                    <option value="0">Hoạt Động</option>
                                    <option value="1">Tạm Ngừng</option>
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
import { ExcelExportMixin } from '../../../mixins/ExcelExportMixin';

export default {
    mixins: [ExcelExportMixin],
    data() {
        return {
            list_lop_hoc: [],
            list_giao_vien: [],
            list_nam_hoc: [],
            list_khoi_lop: [
                { id: 1, ten_khoi_lop: "Nhà trẻ", do_tuoi: "18-36 tháng" },
                { id: 2, ten_khoi_lop: "Mầm", do_tuoi: "3-4 tuổi" },
                { id: 3, ten_khoi_lop: "Chồi", do_tuoi: "4-5 tuổi" },
                { id: 4, ten_khoi_lop: "Lá", do_tuoi: "5-6 tuổi" },
            ],
            create_lop_hoc: {
                ten_lop: "",
                id_khoi_lop: "",
                id_nam_hoc: "",
                so_luong: "",
                id_giao_vien: "",
                hoc_phi: "",
                is_block: "0",
                ghi_chu: "",
                mo_ta: "",
            },
            update_lop_hoc: {
                id: "",
                ten_lop: "",
                id_khoi_lop: "",
                id_nam_hoc: "",
                so_luong: "",
                id_giao_vien: "",
                is_block: "",
                mo_ta: "",
            },
            delete_lop_hoc: {
                id: "",
                ten_lop: "",
                ten_khoi_lop: "",
                ten_nam_hoc: "",
            },
            search: {
                noi_dung: "",
                is_block: "",
                do_tuoi: "",
            },
            loading: false,
            selected_lop_hoc: {},
            list_hoc_sinh_lop: [],
            loading_students: false,
        };
    },

    mounted() {
        this.loadData();
        this.loadGiaoVien();
        this.loadNamHoc();
    },

    methods: {
        exportClassesExcel() {
            const columns = [
                { header: 'Tên Lớp', value: 'ten_lop', width: 25 },
                { header: 'Khối Lớp', value: 'ten_khoi_lop', width: 20 },
                { header: 'Độ Tuổi', value: 'do_tuoi', width: 15 },
                { header: 'Năm Học', value: 'ten_nam_hoc', width: 20 },
                { header: 'Giáo Viên', value: 'ten_giao_vien', width: 25 },
                { header: 'Sĩ Số', value: (item) => `${item.tong_hoc_sinh || 0}/${item.so_luong}`, width: 15 },
                { header: 'Trạng Thái', value: (item) => item.is_block == 0 ? 'Hoạt động' : 'Tạm ngừng', width: 15 }
            ];
            
            this.exportToExcel(this.list_lop_hoc, columns, 'danh-sach-lop-hoc');
        },

        formatCurrency(amount) {
            if (!amount) return "0 VNĐ";
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(amount);
        },

        getTotalStudents() {
            return this.list_lop_hoc.reduce((total, lop) => total + (parseInt(lop.tong_hoc_sinh) || 0), 0);
        },

        getStudentPercentage(lop) {
            if (!lop.so_luong || lop.so_luong === 0) return 0;
            return Math.round(((parseInt(lop.tong_hoc_sinh) || 0) / lop.so_luong) * 100);
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
            // Validate required fields
            if (!this.update_lop_hoc.id) {
                this.$toast.error("Không tìm thấy ID lớp học");
                return;
            }
            if (!this.update_lop_hoc.ten_lop) {
                this.$toast.error("Vui lòng nhập tên lớp");
                return;
            }
            if (!this.update_lop_hoc.id_khoi_lop) {
                this.$toast.error("Vui lòng chọn khối lớp");
                return;
            }
            if (!this.update_lop_hoc.id_nam_hoc) {
                this.$toast.error("Vui lòng chọn năm học");
                return;
            }
            if (!this.update_lop_hoc.id_giao_vien) {
                this.$toast.error("Vui lòng chọn giáo viên chủ nhiệm");
                return;
            }

            this.loading = true;

            // Prepare data for update
            const updateData = {
                id: this.update_lop_hoc.id,
                ten_lop: this.update_lop_hoc.ten_lop,
                id_khoi_lop: parseInt(this.update_lop_hoc.id_khoi_lop),
                id_nam_hoc: parseInt(this.update_lop_hoc.id_nam_hoc),
                so_luong: parseInt(this.update_lop_hoc.so_luong) || 0,
                id_giao_vien: parseInt(this.update_lop_hoc.id_giao_vien),
                is_block: parseInt(this.update_lop_hoc.is_block) || 0,
                mo_ta: this.update_lop_hoc.mo_ta || "",
            };

            baseRequestAdmin
                .post("admin/lop-hoc/update", updateData)
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
            // Validate
            if (!this.delete_lop_hoc.id) {
                this.$toast.error("Không tìm thấy ID lớp học");
                return;
            }

            this.loading = true;

            // Only send ID for delete
            const deleteData = {
                id: this.delete_lop_hoc.id
            };

            baseRequestAdmin
                .post("admin/lop-hoc/delete", deleteData)
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.loadData();
                        this.delete_lop_hoc = {
                            id: "",
                            ten_lop: "",
                            ten_khoi_lop: "",
                            ten_nam_hoc: "",
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
                        this.$toast.error("Có lỗi xảy ra khi xóa lớp học");
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        TiemKiem() {
            // Chuẩn bị dữ liệu tìm kiếm - chỉ gửi các field có giá trị
            const searchData = {};

            if (this.search.noi_dung && this.search.noi_dung.trim()) {
                searchData.noi_dung = this.search.noi_dung.trim();
            }

            if (this.search.is_block !== "" && this.search.is_block !== null) {
                // Frontend: 1 = Hoạt động, 0 = Tạm ngừng
                // Backend sẽ đảo ngược: frontend 1 => database 0, frontend 0 => database 1
                searchData.is_block = this.search.is_block;
            }

            if (this.search.do_tuoi && this.search.do_tuoi.trim()) {
                // Backend sẽ thêm " tuổi" vào giá trị (ví dụ: "3-4" => "3-4 tuổi")
                searchData.do_tuoi = this.search.do_tuoi.trim();
            }

            baseRequestAdmin
                .post("admin/lop-hoc/search", searchData)
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
            if (!lop || !lop.id) {
                this.$toast.error("Không tìm thấy thông tin lớp học");
                return;
            }

            this.selected_lop_hoc = {};
            this.list_hoc_sinh_lop = [];
            this.loading_students = true;

            // Load chi tiết lớp học và danh sách học sinh
            baseRequestAdmin
                .get(`admin/lop-hoc/chi-tiet-lop/data?id=${lop.id}`)
                .then((res) => {
                    if (res.data.status) {
                        // Lấy thông tin lớp học từ response
                        const thongTinLop = res.data.data.thong_tin_lop || {};
                        const danhSachHocSinh = res.data.data.danh_sach_hoc_sinh || [];

                        // Gán thông tin lớp học và tính tổng học sinh
                        this.selected_lop_hoc = {
                            ...thongTinLop,
                            tong_hoc_sinh: danhSachHocSinh.length
                        };

                        // Map dữ liệu học sinh từ backend sang format template
                        this.list_hoc_sinh_lop = danhSachHocSinh.map(hs => ({
                            id: hs.id,
                            ho_va_ten: hs.ten_hoc_sinh || 'N/A',
                            ten_phu_huynh: hs.ten_phu_huynh || 'N/A',
                            quan_he: hs.quan_he || 'N/A',
                            so_dien_thoai: hs.so_dien_thoai || 'N/A',
                            dia_chi: hs.dia_chi || 'N/A'
                        }));

                        // Mở modal
                        const modal = new bootstrap.Modal(document.getElementById("chiTietModal"));
                        modal.show();
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
                        this.$toast.error("Có lỗi xảy ra khi tải chi tiết lớp học");
                    }
                })
                .finally(() => {
                    this.loading_students = false;
                });
        },

        resetCreateForm() {
            this.create_lop_hoc = {
                ten_lop: "",
                id_khoi_lop: "",
                id_nam_hoc: "",
                so_luong: "",
                id_giao_vien: "",
                hoc_phi: "",
                is_block: "0",
                ghi_chu: "",
                mo_ta: "",
            };
        },

        OpenUpdateModal(value) {
            // Reset form first
            this.update_lop_hoc = {
                id: "",
                ten_lop: "",
                id_khoi_lop: "",
                id_nam_hoc: "",
                so_luong: "",
                id_giao_vien: "",
                is_block: "0",
                mo_ta: "",
            };

            // Then assign values from backend - ensure proper type conversion
            this.$nextTick(() => {
                this.update_lop_hoc = {
                    id: value.id ? String(value.id) : "",
                    ten_lop: value.ten_lop || "",
                    id_khoi_lop: (value.id_khoi_lop !== undefined && value.id_khoi_lop !== null) ? String(value.id_khoi_lop) : "",
                    id_nam_hoc: (value.id_nam_hoc !== undefined && value.id_nam_hoc !== null) ? String(value.id_nam_hoc) : "",
                    so_luong: (value.so_luong !== undefined && value.so_luong !== null) ? String(value.so_luong) : "",
                    id_giao_vien: (value.id_giao_vien !== undefined && value.id_giao_vien !== null) ? String(value.id_giao_vien) : "",
                    is_block: (value.is_block !== undefined && value.is_block !== null) ? String(value.is_block) : "0",
                    mo_ta: value.mo_ta || "",
                };
            });
        },

        OpenDeleteModal(value) {
            this.delete_lop_hoc = {
                id: value.id ? String(value.id) : "",
                ten_lop: value.ten_lop || "",
                ten_khoi_lop: value.ten_khoi_lop || "",
                ten_nam_hoc: value.ten_nam_hoc || "",
            };
        },
    },
};
</script>

<style lang="scss">
@use "./style.scss";
</style>
