<template>
    <div class="reports-page">
        <!-- Header Section -->
        <div class="page-header education-theme">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="page-header-content">
                            <div class="page-icon">
                                <i class="bx bx-file"></i>
                            </div>
                            <div class="page-info">
                                <h1 class="page-title">Báo Cáo Học Tập</h1>
                                <p class="page-subtitle">Tạo và quản lý báo cáo học tập</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <button class="btn btn-create" @click="openCreateModal">
                            <i class="bx bx-plus"></i>
                            Tạo báo cáo mới
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filters-section">
            <div class="container-fluid">
                <div class="filter-card">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="filter-label">Loại báo cáo</label>
                            <select class="form-select" v-model="filters.loai_bao_cao">
                                <option value="">Tất cả</option>
                                <option value="financial">Báo cáo tài chính</option>
                                <option value="student">Báo cáo học sinh</option>
                                <option value="activity">Báo cáo hoạt động</option>
                                <option value="attendance">Báo cáo điểm danh</option>
                                <option value="health">Báo cáo sức khỏe</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="filter-label">Trạng thái</label>
                            <select class="form-select" v-model="filters.trang_thai">
                                <option value="">Tất cả</option>
                                <option value="completed">Hoàn thành</option>
                                <option value="pending">Đang soạn</option>
                                <option value="failed">Thất bại</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="filter-label">Tìm kiếm</label>
                            <div class="search-input-wrapper">
                                <i class="bx bx-search"></i>
                                <input type="text" placeholder="Tìm kiếm báo cáo..." v-model="filters.noi_dung"
                                    class="search-input" @keyup.enter="searchReports" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="filter-label">&nbsp;</label>
                            <button class="btn btn-search" @click="searchReports" :disabled="loading">
                                <i class="bx bx-search"></i>
                                Tìm kiếm
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reports List -->
        <div class="reports-section">
            <div class="container-fluid">
                <div class="management-card">
                    <div class="card-header-custom">
                        <div class="header-content">
                            <div class="header-icon">
                                <i class="bx bx-list-ul"></i>
                            </div>
                            <div class="header-text">
                                <h5 class="card-title">Danh sách báo cáo</h5>
                                <p class="card-subtitle">Quản lý các báo cáo học tập</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Loading State -->
                        <div v-if="loading" class="text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-3">Đang tải dữ liệu...</p>
                        </div>

                        <!-- Empty State -->
                        <div v-else-if="reports.length === 0" class="empty-state">
                            <i class="bx bx-file-blank"></i>
                            <h3>Không có báo cáo nào</h3>
                            <p>Hãy tạo báo cáo mới để bắt đầu</p>
                            <button class="btn btn-create" @click="openCreateModal">
                                <i class="bx bx-plus"></i>
                                Tạo báo cáo mới
                            </button>
                        </div>

                        <!-- Table -->
                        <div v-else class="table-container">
                            <table class="table table-modern">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Tiêu đề</th>
                                        <th class="text-center">Loại</th>
                                        <th class="text-center">Ngày tạo</th>
                                        <th class="text-center">Người tạo</th>
                                        <th class="text-center">Trạng thái</th>
                                        <th class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(report, index) in reports" :key="report.id" class="report-row">
                                        <th class="text-center">{{ index + 1 }}</th>
                                        <td>
                                            <strong>{{ report.ten_bao_cao }}</strong>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge" :class="'bg-' + getTypeColor(report.loai_bao_cao)">
                                                {{ getTypeName(report.loai_bao_cao) }}
                                            </span>
                                        </td>
                                        <td class="text-end">{{ formatDate(report.ngay_tao) }}</td>
                                        <td class="text-center">{{ report.ten_giao_vien || report.ten_nhan_vien || 'N/A'
                                            }}</td>
                                        <td class="text-center">
                                            <button class="status-btn"
                                                :class="'status-' + getStatusColor(report.trang_thai)"
                                                @click="toggleStatus(report)" :title="'Click để đổi trạng thái'">
                                                {{ getStatusName(report.trang_thai) }}
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <div class="action-buttons">
                                                <button class="btn-action btn-view" title="Xem chi tiết"
                                                    @click="viewReportDetail(report)">
                                                    <i class="bx bx-show"></i>
                                                </button>
                                                <button class="btn-action btn-edit" title="Chỉnh sửa"
                                                    @click="openEditModal(report)">
                                                    <i class="bx bx-edit"></i>
                                                </button>
                                                <button class="btn-action btn-delete" title="Xóa"
                                                    @click="confirmDelete(report)">
                                                    <i class="bx bx-trash"></i>
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

        <!-- Create/Edit Modal -->
        <div class="modal fade" id="reportModal" tabindex="-1" ref="reportModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ isEditMode ? 'Chỉnh sửa báo cáo' : 'Tạo báo cáo mới' }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="saveReport">
                            <div class="mb-3">
                                <label class="form-label">Tiêu đề báo cáo <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" v-model="formData.ten_bao_cao" required
                                    placeholder="Nhập tiêu đề báo cáo" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Loại báo cáo <span class="text-danger">*</span></label>
                                <select class="form-select" v-model="formData.loai_bao_cao" required>
                                    <option value="">Chọn loại báo cáo</option>
                                    <option value="financial">Báo cáo tài chính</option>
                                    <option value="student">Báo cáo học sinh</option>
                                    <option value="activity">Báo cáo hoạt động</option>
                                    <option value="attendance">Báo cáo điểm danh</option>
                                    <option value="health">Báo cáo sức khỏe</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Đường dẫn file</label>
                                <input type="text" class="form-control" v-model="formData.duong_dan"
                                    placeholder="URL hoặc đường dẫn file" />
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Từ ngày</label>
                                    <input type="date" class="form-control" v-model="formData.tu_ngay" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Đến ngày</label>
                                    <input type="date" class="form-control" v-model="formData.den_ngay" />
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-primary" @click="saveReport" :disabled="saving">
                            <span v-if="saving">
                                <span class="spinner-border spinner-border-sm me-2"></span>
                                Đang lưu...
                            </span>
                            <span v-else>
                                <i class="bx bx-save me-2"></i>
                                {{ isEditMode ? 'Cập nhật' : 'Tạo mới' }}
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" ref="deleteModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">
                            <i class="bx bx-trash me-2"></i>
                            Xác nhận xóa
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Bạn có chắc chắn muốn xóa báo cáo <strong>"{{ reportToDelete?.ten_bao_cao }}"</strong>?</p>
                        <p class="text-muted mb-0">Hành động này không thể hoàn tác.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-danger" @click="deleteReport" :disabled="deleting">
                            <span v-if="deleting">
                                <span class="spinner-border spinner-border-sm me-2"></span>
                                Đang xóa...
                            </span>
                            <span v-else>
                                <i class="bx bx-trash me-2"></i>
                                Xóa
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- View Detail Modal -->
        <div class="modal fade" id="detailModal" tabindex="-1" ref="detailModal">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bx bx-file me-2"></i>
                            Chi tiết báo cáo
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" v-if="selectedReport">
                        <div class="detail-container">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="detail-field">
                                        <label class="detail-label">Tiêu đề báo cáo</label>
                                        <div class="detail-value">{{ selectedReport.ten_bao_cao }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-field">
                                        <label class="detail-label">Loại báo cáo</label>
                                        <div class="detail-value">
                                            <span class="badge"
                                                :class="'bg-' + getTypeColor(selectedReport.loai_bao_cao)">
                                                {{ getTypeName(selectedReport.loai_bao_cao) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="detail-field">
                                        <label class="detail-label">Ngày tạo</label>
                                        <div class="detail-value">{{ formatDate(selectedReport.ngay_tao) }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-field">
                                        <label class="detail-label">Trạng thái</label>
                                        <div class="detail-value">
                                            <span class="badge"
                                                :class="'bg-' + getStatusColor(selectedReport.trang_thai)">
                                                {{ getStatusName(selectedReport.trang_thai) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3" v-if="selectedReport.tu_ngay || selectedReport.den_ngay">
                                <div class="col-md-6">
                                    <div class="detail-field">
                                        <label class="detail-label">Từ ngày</label>
                                        <div class="detail-value">{{ formatDate(selectedReport.tu_ngay) }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="detail-field">
                                        <label class="detail-label">Đến ngày</label>
                                        <div class="detail-value">{{ formatDate(selectedReport.den_ngay) }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="detail-field">
                                        <label class="detail-label">Người tạo</label>
                                        <div class="detail-value">
                                            {{ selectedReport.ten_giao_vien || selectedReport.ten_nhan_vien }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row" v-if="selectedReport.duong_dan">
                                <div class="col-md-12">
                                    <div class="detail-field">
                                        <label class="detail-label">Đường dẫn file</label>
                                        <div class="detail-value">
                                            <a :href="selectedReport.duong_dan" target="_blank" class="file-link">
                                                <i class="bx bx-link-external me-1"></i>
                                                {{ selectedReport.duong_dan }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary" @click="editFromDetail">
                            <i class="bx bx-edit me-2"></i>
                            Chỉnh sửa
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import baseRequestTeacher from '../../../core/baseRequestTeacher';

export default {
    name: 'Reports',
    data() {
        return {
            loading: false,
            saving: false,
            deleting: false,
            reports: [],
            isEditMode: false,
            reportToDelete: null,
            selectedReport: null,
            filters: {
                noi_dung: '',
                loai_bao_cao: '',
                trang_thai: '',
                tu_ngay: '',
                den_ngay: ''
            },
            formData: {
                id: null,
                ten_bao_cao: '',
                loai_bao_cao: '',
                duong_dan: '',
                tu_ngay: '',
                den_ngay: ''
            }
        };
    },
    mounted() {
        // Initialize Bootstrap modals
        this.modalInstance = new bootstrap.Modal(this.$refs.reportModal);
        this.deleteModalInstance = new bootstrap.Modal(this.$refs.deleteModal);
        this.detailModalInstance = new bootstrap.Modal(this.$refs.detailModal);

        // Fetch initial data
        this.fetchReports();
    },
    methods: {
        // Fetch reports data
        fetchReports() {
            this.loading = true;
            baseRequestTeacher.get('teacher/bao-cao/data')
                .then((res) => {
                    if (res.data.status) {
                        this.reports = res.data.data;
                    }
                })
                .catch((error) => {
                    console.error('Error fetching reports:', error);
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        // Search reports
        searchReports() {
            this.loading = true;
            baseRequestTeacher.post('teacher/bao-cao/search', this.filters)
                .then((res) => {
                    if (res.data.status) {
                        this.reports = res.data.data;
                    }
                })
                .catch((error) => {
                    console.error('Error searching reports:', error);
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        // Open create modal
        openCreateModal() {
            this.isEditMode = false;
            this.formData = {
                id: null,
                ten_bao_cao: '',
                loai_bao_cao: '',
                duong_dan: '',
                tu_ngay: '',
                den_ngay: ''
            };
            this.modalInstance.show();
        },

        // Open edit modal
        openEditModal(report) {
            this.isEditMode = true;
            this.formData = {
                id: report.id,
                ten_bao_cao: report.ten_bao_cao,
                loai_bao_cao: report.loai_bao_cao,
                duong_dan: report.duong_dan || '',
                tu_ngay: report.tu_ngay || '',
                den_ngay: report.den_ngay || ''
            };
            this.modalInstance.show();
        },

        // Save report (create or update)
        saveReport() {
            if (!this.formData.ten_bao_cao || !this.formData.loai_bao_cao) {
                this.$toast.warning('Vui lòng điền đầy đủ thông tin bắt buộc');
                return;
            }

            this.saving = true;
            const endpoint = this.isEditMode ? 'teacher/bao-cao/update' : 'teacher/bao-cao/create';

            baseRequestTeacher.post(endpoint, this.formData)
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.modalInstance.hide();
                        this.fetchReports();
                    } else {
                        this.$toast.error(res.data.message);
                    }
                })
                .catch((error) => {
                    console.error('Error saving report:', error);
                    this.$toast.error('Không thể lưu báo cáo');
                })
                .finally(() => {
                    this.saving = false;
                });
        },

        // Confirm delete
        confirmDelete(report) {
            this.reportToDelete = report;
            this.deleteModalInstance.show();
        },

        // Delete report
        deleteReport() {
            this.deleting = true;
            baseRequestTeacher.post('teacher/bao-cao/delete', {
                id: this.reportToDelete.id
            })
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.deleteModalInstance.hide();
                        this.fetchReports();
                    } else {
                        this.$toast.error(res.data.message);
                    }
                })
                .catch((error) => {
                    console.error('Error deleting report:', error);
                    this.$toast.error('Không thể xóa báo cáo');
                })
                .finally(() => {
                    this.deleting = false;
                });
        },

        // Toggle status
        toggleStatus(report) {
            const statusMap = {
                'completed': 'pending',
                'pending': 'completed',
                'failed': 'completed'
            };

            const newStatus = statusMap[report.trang_thai] || 'pending';

            baseRequestTeacher.post('teacher/bao-cao/change-status', {
                id: report.id,
                trang_thai: newStatus
            })
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success('Đã cập nhật trạng thái');
                        this.fetchReports();
                    }
                })
                .catch((error) => {
                    console.error('Error changing status:', error);
                    this.$toast.error('Không thể thay đổi trạng thái');
                });
        },

        // View report detail
        viewReportDetail(report) {
            this.selectedReport = report;
            this.detailModalInstance.show();
        },

        // Edit from detail modal
        editFromDetail() {
            this.detailModalInstance.hide();
            this.openEditModal(this.selectedReport);
        },

        // Helper functions
        getTypeName(type) {
            const types = {
                'financial': 'Tài chính',
                'student': 'Học sinh',
                'activity': 'Hoạt động',
                'attendance': 'Điểm danh',
                'health': 'Sức khỏe'
            };
            return types[type] || 'Khác';
        },

        getTypeColor(type) {
            const colors = {
                'financial': 'success',
                'student': 'primary',
                'activity': 'info',
                'attendance': 'warning',
                'health': 'danger'
            };
            return colors[type] || 'secondary';
        },

        getStatusName(status) {
            const statuses = {
                'completed': 'Hoàn thành',
                'pending': 'Đang soạn',
                'failed': 'Thất bại'
            };
            return statuses[status] || 'Không xác định';
        },

        getStatusColor(status) {
            const colors = {
                'completed': 'success',
                'pending': 'warning',
                'failed': 'danger'
            };
            return colors[status] || 'secondary';
        },

        formatDate(dateString) {
            if (!dateString) return 'N/A';
            const date = new Date(dateString);
            return date.toLocaleDateString('vi-VN');
        }
    }
};
</script>

<style lang="scss" scoped>
@use "./style.scss";
</style>
