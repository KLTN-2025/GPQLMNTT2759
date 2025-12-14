<template>
    <div class="teaching-plan-page">
        <div class="page-header mb-4">
            <h2 class="page-title">
                <i class="bx bx-book-open me-2"></i>Kế Hoạch Giảng Dạy
            </h2>
            <p class="page-subtitle">Quản lý kế hoạch giảng dạy và chương trình học</p>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card stat-card stat-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon"><i class="bx bx-calendar-check"></i></div>
                            <div class="stat-content">
                                <h3 class="stat-number">{{ totalPlans }}</h3>
                                <p class="stat-label">Kế hoạch đã tạo</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card stat-card stat-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon"><i class="bx bx-check-circle"></i></div>
                            <div class="stat-content">
                                <h3 class="stat-number">{{ completedPlans }}</h3>
                                <p class="stat-label">Đã hoàn thành</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card stat-card stat-warning">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon"><i class="bx bx-time"></i></div>
                            <div class="stat-content">
                                <h3 class="stat-number">{{ pendingPlans }}</h3>
                                <p class="stat-label">Đang thực hiện</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card stat-card stat-info">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon"><i class="bx bx-book"></i></div>
                            <div class="stat-content">
                                <h3 class="stat-number">{{ curriculumCount }}</h3>
                                <p class="stat-label">Chương trình học</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#daily-plan" role="tab">
                            <i class="bx bx-calendar me-1"></i>Kế Hoạch Hàng Ngày
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#curriculum" role="tab">
                            <i class="bx bx-book me-1"></i>Chương Trình Học
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#reports" role="tab">
                            <i class="bx bx-file me-1"></i>Báo Cáo
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <!-- Daily Plan Tab -->
                    <div class="tab-pane fade show active" id="daily-plan" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex gap-2">
                                <input type="date" class="form-control" v-model="selectedDate"
                                    @change="loadDailyPlans" />
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPlanModal">
                                    <i class="bx bx-plus me-1"></i>Thêm Kế Hoạch
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Chủ Đề</th>
                                        <th>Mục Tiêu</th>
                                        <th>Nội Dung</th>
                                        <th>Thời Gian</th>
                                        <th>Trạng Thái</th>
                                        <th>Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(plan, index) in dailyPlans" :key="plan.id">
                                        <td>{{ index + 1 }}</td>
                                        <td><strong>{{ plan.chu_de }}</strong></td>
                                        <td>{{ plan.muc_tieu }}</td>
                                        <td>{{ truncateText(plan.noi_dung, 50) }}</td>
                                        <td>{{ plan.thoi_gian }}</td>
                                        <td>
                                            <span class="badge" :class="getStatusClass(plan.tinh_trang)">
                                                {{ getStatusText(plan.tinh_trang) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-primary" @click="editPlan(plan)"
                                                    data-bs-toggle="modal" data-bs-target="#editPlanModal">
                                                    <i class="bx bx-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-info" @click="viewPlan(plan)">
                                                    <i class="bx bx-show"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger" @click="deletePlan(plan)"
                                                    data-bs-toggle="modal" data-bs-target="#deletePlanModal">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="dailyPlans.length === 0">
                                        <td colspan="7" class="text-center text-muted">
                                            <i class="bx bx-info-circle me-1"></i>Chưa có kế hoạch cho ngày này
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Curriculum Tab -->
                    <div class="tab-pane fade" id="curriculum" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5>Chương Trình Học</h5>
                            <select class="form-select" style="width: auto;" v-model="selectedWeek"
                                @change="loadCurriculum">
                                <option value="">Chọn tuần</option>
                                <option v-for="week in weeks" :key="week" :value="week">Tuần {{ week }}</option>
                            </select>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tuần</th>
                                        <th>Chủ Đề</th>
                                        <th>Mục Tiêu</th>
                                        <th>Nội Dung</th>
                                        <th>Hoạt Động</th>
                                        <th>Thao Tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in curriculum" :key="item.id">
                                        <td>{{ index + 1 }}</td>
                                        <td>Tuần {{ item.tuan }}</td>
                                        <td><strong>{{ item.chu_de }}</strong></td>
                                        <td>{{ item.muc_tieu }}</td>
                                        <td>{{ truncateText(item.noi_dung, 50) }}</td>
                                        <td>{{ item.hoat_dong }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary"
                                                @click="createPlanFromCurriculum(item)">
                                                <i class="bx bx-plus me-1"></i>Tạo Kế Hoạch
                                            </button>
                                        </td>
                                    </tr>
                                    <tr v-if="curriculum.length === 0">
                                        <td colspan="7" class="text-center text-muted">
                                            <i class="bx bx-info-circle me-1"></i>Chưa có chương trình học
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Reports Tab -->
                    <div class="tab-pane fade" id="reports" role="tabpanel">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5>Báo Cáo Kết Quả</h5>
                            <div class="d-flex gap-2">
                                <input type="date" class="form-control" v-model="reportStartDate" />
                                <span class="align-self-center">đến</span>
                                <input type="date" class="form-control" v-model="reportEndDate" />
                                <button class="btn btn-success" @click="generateReport">
                                    <i class="bx bx-file me-1"></i>Xuất Báo Cáo
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6>Kết Quả Hoàn Thành</h6>
                                        <div class="progress mb-2">
                                            <div class="progress-bar bg-success"
                                                :style="{ width: completionRate + '%' }">
                                                {{ completionRate }}%
                                            </div>
                                        </div>
                                        <small class="text-muted">{{ completedPlans }} / {{ totalPlans }} kế
                                            hoạch</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h6>Thống Kê Theo Tuần</h6>
                                        <canvas id="weeklyChart" height="100"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Plan Modal -->
        <div class="modal fade" id="addPlanModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bx bx-plus me-2"></i>Thêm Kế Hoạch Giảng Dạy
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label class="form-label">Ngày *</label>
                                <input type="date" class="form-control" v-model="newPlan.ngay" required />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Chủ Đề *</label>
                                <input type="text" class="form-control" v-model="newPlan.chu_de" required />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mục Tiêu *</label>
                                <textarea class="form-control" rows="2" v-model="newPlan.muc_tieu" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nội Dung *</label>
                                <textarea class="form-control" rows="4" v-model="newPlan.noi_dung" required></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Thời Gian *</label>
                                    <input type="text" class="form-control" v-model="newPlan.thoi_gian"
                                        placeholder="VD: 8:00 - 9:30" required />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Trạng Thái</label>
                                    <select class="form-select" v-model="newPlan.tinh_trang">
                                        <option value="0">Chưa thực hiện</option>
                                        <option value="1">Đang thực hiện</option>
                                        <option value="2">Đã hoàn thành</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-primary" @click="savePlan" :disabled="loading">
                            <i v-if="loading" class="bx bx-loader-alt bx-spin me-1"></i>
                            <i v-else class="bx bx-save me-1"></i>
                            {{ loading ? 'Đang lưu...' : 'Lưu' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Plan Modal -->
        <div class="modal fade" id="editPlanModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bx bx-edit me-2"></i>Cập Nhật Kế Hoạch
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label class="form-label">Ngày *</label>
                                <input type="date" class="form-control" v-model="editPlanData.ngay" required />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Chủ Đề *</label>
                                <input type="text" class="form-control" v-model="editPlanData.chu_de" required />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mục Tiêu *</label>
                                <textarea class="form-control" rows="2" v-model="editPlanData.muc_tieu"
                                    required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nội Dung *</label>
                                <textarea class="form-control" rows="4" v-model="editPlanData.noi_dung"
                                    required></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Thời Gian *</label>
                                    <input type="text" class="form-control" v-model="editPlanData.thoi_gian" required />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Trạng Thái</label>
                                    <select class="form-select" v-model="editPlanData.tinh_trang">
                                        <option value="0">Chưa thực hiện</option>
                                        <option value="1">Đang thực hiện</option>
                                        <option value="2">Đã hoàn thành</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-primary" @click="updatePlan" :disabled="loading">
                            <i v-if="loading" class="bx bx-loader-alt bx-spin me-1"></i>
                            <i v-else class="bx bx-save me-1"></i>
                            {{ loading ? 'Đang cập nhật...' : 'Cập Nhật' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Plan Modal -->
        <div class="modal fade" id="deletePlanModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bx bx-trash me-2 text-danger"></i>Xác Nhận Xóa
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Bạn có chắc chắn muốn xóa kế hoạch "<strong>{{ deletePlanData.chu_de }}</strong>"?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-danger" @click="confirmDelete" :disabled="loading">
                            <i v-if="loading" class="bx bx-loader-alt bx-spin me-1"></i>
                            <i v-else class="bx bx-trash me-1"></i>
                            {{ loading ? 'Đang xóa...' : 'Xóa' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, computed, onMounted, getCurrentInstance } from 'vue';
import baseRequestTeacher from '../../../core/baseRequestTeacher';

export default {
    name: 'TeachingPlan',
    setup() {
        const { proxy } = getCurrentInstance();
        const selectedDate = ref(new Date().toISOString().split('T')[0]);
        const selectedWeek = ref('');
        const dailyPlans = ref([]);
        const curriculum = ref([]);
        const weeks = ref([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36]);
        const loading = ref(false);
        const reportStartDate = ref('');
        const reportEndDate = ref('');

        const newPlan = ref({
            ngay: new Date().toISOString().split('T')[0],
            chu_de: '',
            muc_tieu: '',
            noi_dung: '',
            thoi_gian: '',
            tinh_trang: '0'
        });

        const editPlanData = ref({
            id: '',
            ngay: '',
            chu_de: '',
            muc_tieu: '',
            noi_dung: '',
            thoi_gian: '',
            tinh_trang: '0'
        });

        const deletePlanData = ref({
            id: '',
            chu_de: ''
        });

        const totalPlans = computed(() => dailyPlans.value.length);
        const completedPlans = computed(() => dailyPlans.value.filter(p => p.tinh_trang == 2).length);
        const pendingPlans = computed(() => dailyPlans.value.filter(p => p.tinh_trang == 1).length);
        const curriculumCount = computed(() => curriculum.value.length);
        const completionRate = computed(() => {
            if (totalPlans.value === 0) return 0;
            return Math.round((completedPlans.value / totalPlans.value) * 100);
        });

        const loadDailyPlans = () => {
            loading.value = true;
            baseRequestTeacher
                .post('teacher/ke-hoach-giang-day/data', { ngay: selectedDate.value })
                .then((res) => {
                    if (res.data.status) {
                        dailyPlans.value = res.data.data;
                        proxy.$toast?.success(res.data.message);
                    } else {
                        proxy.$toast?.error(res.data.message);
                    }
                })
                .catch((err) => {
                    proxy.$toast?.error('Có lỗi xảy ra khi tải dữ liệu');
                })
                .finally(() => {
                    loading.value = false;
                });
        };

        const loadCurriculum = () => {
            if (!selectedWeek.value) return;
            loading.value = true;
            baseRequestTeacher
                .get(`teacher/chuong-trinh-hoc/data?tuan=${selectedWeek.value}`)
                .then((res) => {
                    if (res.data.status) {
                        curriculum.value = res.data.data;
                    }
                })
                .catch((err) => {
                    console.error('Error loading curriculum:', err);
                })
                .finally(() => {
                    loading.value = false;
                });
        };

        const savePlan = () => {
            loading.value = true;
            baseRequestTeacher
                .post('teacher/ke-hoach-giang-day/create', newPlan.value)
                .then((res) => {
                    if (res.data.status) {
                        proxy.$toast?.success(res.data.message);
                        loadDailyPlans();
                        resetNewPlan();
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addPlanModal'));
                        if (modal) modal.hide();
                    } else {
                        proxy.$toast?.error(res.data.message);
                    }
                })
                .catch((err) => {
                    proxy.$toast?.error('Có lỗi xảy ra khi lưu kế hoạch');
                })
                .finally(() => {
                    loading.value = false;
                });
        };

        const editPlan = (plan) => {
            editPlanData.value = { ...plan };
        };

        const updatePlan = () => {
            loading.value = true;
            baseRequestTeacher
                .post('teacher/ke-hoach-giang-day/update', editPlanData.value)
                .then((res) => {
                    if (res.data.status) {
                        proxy.$toast?.success(res.data.message);
                        loadDailyPlans();
                        const modal = bootstrap.Modal.getInstance(document.getElementById('editPlanModal'));
                        if (modal) modal.hide();
                    } else {
                        proxy.$toast?.error(res.data.message);
                    }
                })
                .catch((err) => {
                    proxy.$toast?.error('Có lỗi xảy ra khi cập nhật');
                })
                .finally(() => {
                    loading.value = false;
                });
        };

        const deletePlan = (plan) => {
            deletePlanData.value = { id: plan.id, chu_de: plan.chu_de };
        };

        const confirmDelete = () => {
            loading.value = true;
            baseRequestTeacher
                .post('teacher/ke-hoach-giang-day/delete', deletePlanData.value)
                .then((res) => {
                    if (res.data.status) {
                        proxy.$toast?.success(res.data.message);
                        loadDailyPlans();
                        const modal = bootstrap.Modal.getInstance(document.getElementById('deletePlanModal'));
                        if (modal) modal.hide();
                    } else {
                        proxy.$toast?.error(res.data.message);
                    }
                })
                .catch((err) => {
                    proxy.$toast?.error('Có lỗi xảy ra khi xóa');
                })
                .finally(() => {
                    loading.value = false;
                });
        };

        const viewPlan = (plan) => {
            alert(`Xem chi tiết: ${plan.chu_de}`);
        };

        const createPlanFromCurriculum = (item) => {
            newPlan.value = {
                ngay: selectedDate.value,
                chu_de: item.chu_de,
                muc_tieu: item.muc_tieu,
                noi_dung: item.noi_dung,
                thoi_gian: '',
                tinh_trang: '0'
            };
            const modal = new bootstrap.Modal(document.getElementById('addPlanModal'));
            modal.show();
        };

        const generateReport = () => {
            alert('Tính năng xuất báo cáo đang được phát triển');
        };

        const resetNewPlan = () => {
            newPlan.value = {
                ngay: selectedDate.value,
                chu_de: '',
                muc_tieu: '',
                noi_dung: '',
                thoi_gian: '',
                tinh_trang: '0'
            };
        };

        const truncateText = (text, length) => {
            if (!text) return '';
            if (text.length <= length) return text;
            return text.substring(0, length) + '...';
        };

        const getStatusClass = (status) => {
            const classes = {
                0: 'bg-secondary',
                1: 'bg-warning',
                2: 'bg-success'
            };
            return classes[status] || 'bg-secondary';
        };

        const getStatusText = (status) => {
            const texts = {
                0: 'Chưa thực hiện',
                1: 'Đang thực hiện',
                2: 'Đã hoàn thành'
            };
            return texts[status] || 'Không xác định';
        };

        onMounted(() => {
            loadDailyPlans();
            reportStartDate.value = new Date(new Date().setDate(new Date().getDate() - 7)).toISOString().split('T')[0];
            reportEndDate.value = new Date().toISOString().split('T')[0];
        });

        return {
            selectedDate,
            selectedWeek,
            dailyPlans,
            curriculum,
            weeks,
            loading,
            reportStartDate,
            reportEndDate,
            newPlan,
            editPlanData,
            deletePlanData,
            totalPlans,
            completedPlans,
            pendingPlans,
            curriculumCount,
            completionRate,
            loadDailyPlans,
            loadCurriculum,
            savePlan,
            editPlan,
            updatePlan,
            deletePlan,
            confirmDelete,
            viewPlan,
            createPlanFromCurriculum,
            generateReport,
            truncateText,
            getStatusClass,
            getStatusText
        };
    }
};
</script>

<style scoped>
.teaching-plan-page {
    padding: 20px;
}

.stat-card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    margin-right: 15px;
}

.stat-primary .stat-icon {
    background: linear-gradient(135deg, #667eea, #764ba2);
}

.stat-success .stat-icon {
    background: linear-gradient(135deg, #28a745, #20c997);
}

.stat-warning .stat-icon {
    background: linear-gradient(135deg, #ffc107, #fd7e14);
}

.stat-info .stat-icon {
    background: linear-gradient(135deg, #17a2b8, #6f42c1);
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
    color: #2c3e50;
}

.stat-label {
    font-size: 0.9rem;
    color: #6c757d;
    margin: 0;
}

.nav-tabs .nav-link {
    color: #6c757d;
    border: none;
    border-bottom: 2px solid transparent;
}

.nav-tabs .nav-link.active {
    color: #667eea;
    border-bottom-color: #667eea;
    background: transparent;
}
</style>
