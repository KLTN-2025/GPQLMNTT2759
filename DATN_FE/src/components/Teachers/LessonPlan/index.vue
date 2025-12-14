<template>
    <div class="lesson-plan-page">
        <!-- Header Section -->
        <div class="page-header education-theme">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="page-header-content">
                            <div class="page-icon">
                                <i class="bx bx-book-open"></i>
                            </div>
                            <div class="page-info">
                                <h1 class="page-title">Kế Hoạch Dạy Học</h1>
                                <p class="page-subtitle">Quản lý kế hoạch dạy học của giáo viên</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <button class="btn btn-create" @click="openCreateModal">
                            <i class="bx bx-plus"></i>
                            Tạo kế hoạch mới
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="lesson-plan-section">
            <div class="container-fluid">
                <div class="management-card">
                    <div class="card-header-custom">
                        <div class="header-content">
                            <div class="header-icon">
                                <i class="bx bx-book-content"></i>
                            </div>
                            <div class="header-text">
                                <h5 class="card-title">Danh sách kế hoạch dạy học</h5>
                                <p class="card-subtitle">Quản lý và theo dõi kế hoạch dạy học</p>
                            </div>
                        </div>
                        <div class="header-actions">
                            <div class="search-wrapper">
                                <i class="bx bx-search"></i>
                                <input type="text" class="search-input" placeholder="Tìm kiếm kế hoạch..."
                                    v-model="searchQuery" />
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div v-if="loading" class="text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <div v-else-if="filteredLessonPlans.length === 0" class="empty-state">
                            <i class="bx bx-book-open"></i>
                            <h3>Chưa có kế hoạch dạy học</h3>
                            <p>Bắt đầu tạo kế hoạch dạy học mới để quản lý bài giảng của bạn</p>
                        </div>
                        <div v-else class="lesson-plans-list">
                            <div v-for="plan in filteredLessonPlans" :key="plan.id" class="lesson-plan-item">
                                <div class="plan-header">
                                    <div class="plan-info">
                                        <h6 class="plan-title">{{ plan.tieu_de }}</h6>
                                        <div class="plan-meta">
                                            <span class="meta-item">
                                                <i class="bx bx-calendar"></i>
                                                {{ formatDate(plan.ngay_day) }}
                                            </span>
                                            <span class="meta-item">
                                                <i class="bx bx-time"></i>
                                                {{ plan.tiet_hoc }}
                                            </span>
                                            <span class="meta-item">
                                                <i class="bx bx-group"></i>
                                                {{ plan.lop_hoc }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="plan-actions">
                                        <button class="btn-action btn-view" @click="viewPlan(plan)"
                                            title="Xem chi tiết">
                                            <i class="bx bx-show"></i>
                                        </button>
                                        <button class="btn-action btn-edit" @click="editPlan(plan)" title="Chỉnh sửa">
                                            <i class="bx bx-edit"></i>
                                        </button>
                                        <button class="btn-action btn-delete" @click="deletePlan(plan)" title="Xóa">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="plan-content">
                                    <p class="plan-description">{{ plan.noi_dung || 'Chưa có mô tả' }}</p>
                                    <div class="plan-tags">
                                        <span class="tag" v-if="plan.mon_hoc">{{ plan.mon_hoc }}</span>
                                        <span class="tag tag-status" :class="getStatusClass(plan.trang_thai)">
                                            {{ getStatusText(plan.trang_thai) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create/Edit Modal -->
        <div class="modal fade" id="lessonPlanModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header-custom">
                        <div class="modal-header-content">
                            <div class="modal-icon">
                                <i class="bx bx-book-open"></i>
                            </div>
                            <div>
                                <h5 class="modal-title">{{ isEditMode ? 'Chỉnh sửa' : 'Tạo mới' }} kế hoạch dạy học</h5>
                                <p class="modal-subtitle">{{ isEditMode ? 'Cập nhật thông tin kế hoạch' : 'Thêm kế hoạch dạy học mới' }}</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close-custom" data-bs-dismiss="modal">
                            <i class="bx bx-x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="saveLessonPlan">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" v-model="lessonPlanForm.tieu_de" required />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Ngày dạy <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" v-model="lessonPlanForm.ngay_day"
                                        required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tiết học <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" v-model="lessonPlanForm.tiet_hoc"
                                        required />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Lớp học <span class="text-danger">*</span></label>
                                    <select class="form-select" v-model="lessonPlanForm.lop_hoc" required>
                                        <option value="">Chọn lớp</option>
                                        <option v-for="lop in listLop" :key="lop.id" :value="lop.ten_lop">
                                            {{ lop.ten_lop }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Môn học</label>
                                <input type="text" class="form-control" v-model="lessonPlanForm.mon_hoc" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nội dung <span class="text-danger">*</span></label>
                                <textarea class="form-control" rows="5" v-model="lessonPlanForm.noi_dung"
                                    required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ghi chú</label>
                                <textarea class="form-control" rows="3" v-model="lessonPlanForm.ghi_chu"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Trạng thái</label>
                                <select class="form-select" v-model="lessonPlanForm.trang_thai">
                                    <option value="1">Đã hoàn thành</option>
                                    <option value="0">Chưa hoàn thành</option>
                                </select>
                            </div>
                            <div class="modal-footer-custom">
                                <button type="button" class="btn btn-secondary-custom" data-bs-dismiss="modal">
                                    Hủy
                                </button>
                                <button type="submit" class="btn btn-primary-custom" :disabled="saving">
                                    <span v-if="saving" class="spinner-border spinner-border-sm me-2"></span>
                                    {{ isEditMode ? 'Cập nhật' : 'Tạo mới' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>


import baseRequestTeacher from '../../../core/baseRequestTeacher';

export default {
    name: "LessonPlan",
    data() {
        return {
            loading: false,
            saving: false,
            searchQuery: "",
            lessonPlans: [],
            listLop: [],
            isEditMode: false,
            lessonPlanForm: {
                id: null,
                tieu_de: "",
                ngay_day: "",
                tiet_hoc: "",
                lop_hoc: "",
                mon_hoc: "",
                noi_dung: "",
                ghi_chu: "",
                trang_thai: "0"
            }
        };
    },
    computed: {
        filteredLessonPlans() {
            if (!this.searchQuery) return this.lessonPlans;
            const query = this.searchQuery.toLowerCase();
            return this.lessonPlans.filter(plan =>
                plan.tieu_de.toLowerCase().includes(query) ||
                plan.lop_hoc?.toLowerCase().includes(query) ||
                plan.mon_hoc?.toLowerCase().includes(query)
            );
        }
    },
    mounted() {
        this.loadLessonPlans();
        this.loadLop();
    },
    methods: {
        async loadLessonPlans() {
            this.loading = true;
            try {
                const res = await baseRequestTeacher.get("/teacher/ke-hoach-day-hoc");
                this.lessonPlans = res.data.data || [];
            } catch (error) {
                const list = Object.values(error.response?.data?.errors || {});
                list.forEach((v) => {
                    this.$toast.error(v[0]);
                });
            } finally {
                this.loading = false;
            }
        },
        async loadLop() {
            try {
                const res = await baseRequestTeacher.get("/teacher/lop-hoc");
                this.listLop = res.data.data || [];
            } catch (error) {
                console.error("Error loading classes:", error);
            }
        },
        openCreateModal() {
            this.isEditMode = false;
            this.lessonPlanForm = {
                id: null,
                tieu_de: "",
                ngay_day: "",
                tiet_hoc: "",
                lop_hoc: "",
                mon_hoc: "",
                noi_dung: "",
                ghi_chu: "",
                trang_thai: "0"
            };
            const modal = new Modal(document.getElementById("lessonPlanModal"));
            modal.show();
        },
        editPlan(plan) {
            this.isEditMode = true;
            this.lessonPlanForm = { ...plan };
            const modal = new Modal(document.getElementById("lessonPlanModal"));
            modal.show();
        },
        viewPlan(plan) {
            // TODO: Implement view detail modal
            this.$toast.info("Xem chi tiết kế hoạch: " + plan.tieu_de);
        },
        async deletePlan(plan) {
            if (!confirm(`Bạn có chắc chắn muốn xóa kế hoạch "${plan.tieu_de}"?`)) return;
            try {
                await baseRequestTeacher.delete(`/teacher/ke-hoach-day-hoc/${plan.id}`);
                this.$toast.success("Xóa kế hoạch thành công");
                this.loadLessonPlans();
            } catch (error) {
                const list = Object.values(error.response?.data?.errors || {});
                list.forEach((v) => {
                    this.$toast.error(v[0]);
                });
            }
        },
        async saveLessonPlan() {
            this.saving = true;
            try {
                if (this.isEditMode) {
                    await baseRequestTeacher.put(`/teacher/ke-hoach-day-hoc/${this.lessonPlanForm.id}`, this.lessonPlanForm);
                    this.$toast.success("Cập nhật kế hoạch thành công");
                } else {
                    await baseRequestTeacher.post("/teacher/ke-hoach-day-hoc", this.lessonPlanForm);
                    this.$toast.success("Tạo kế hoạch thành công");
                }
                const modal = Modal.getInstance(document.getElementById("lessonPlanModal"));
                modal.hide();
                this.loadLessonPlans();
            } catch (error) {
                const list = Object.values(error.response?.data?.errors || {});
                list.forEach((v) => {
                    this.$toast.error(v[0]);
                });
            } finally {
                this.saving = false;
            }
        },
        formatDate(date) {
            if (!date) return "";
            return new Date(date).toLocaleDateString("vi-VN");
        },
        getStatusClass(status) {
            return status == 1 ? "tag-success" : "tag-warning";
        },
        getStatusText(status) {
            return status == 1 ? "Đã hoàn thành" : "Chưa hoàn thành";
        }
    }
};
</script>

<style lang="scss">
@use './style.scss';
</style>
