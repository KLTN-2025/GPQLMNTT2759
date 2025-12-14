<template>
    <div class="attendance-page">
        <!-- Header Section -->
        <div class="page-header education-theme">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="page-header-content">
                            <div class="page-icon">
                                <i class="bx bx-check-square"></i>
                            </div>
                            <div class="page-info">
                                <h1 class="page-title">Điểm Danh</h1>
                                <p class="page-subtitle">Quản lý điểm danh học sinh hàng ngày</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="date-section">
                            <div class="date-icon">
                                <i class="bx bx-calendar"></i>
                            </div>
                            <div class="date-input-wrapper">
                                <label class="date-label">Ngày điểm danh</label>
                                <input type="date" class="date-input" v-model="selectedDate" @change="loadAttendance" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-4 col-md-6 mb-3">
                <div class="stats-card stats-success">
                    <div class="stats-icon">
                        <i class="bx bx-check-circle"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ presentCount }}</h3>
                        <p class="stats-label">Có mặt</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-3">
                <div class="stats-card stats-danger">
                    <div class="stats-icon">
                        <i class="bx bx-x-circle"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ absentCount }}</h3>
                        <p class="stats-label">Vắng mặt</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-3">
                <div class="stats-card stats-primary">
                    <div class="stats-icon">
                        <i class="bx bx-group"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ totalStudents }}</h3>
                        <p class="stats-label">Tổng số học sinh</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Table Section -->
        <div class="row">
            <div class="col-lg-12">
                <div class="management-card">
                    <div class="card-header-custom">
                        <div class="header-content">
                            <div class="header-icon">
                                <i class="bx bx-list-ul"></i>
                            </div>
                            <div class="header-text">
                                <h5 class="card-title">Danh sách điểm danh - {{ className }}</h5>
                                <p class="card-subtitle">Quản lý điểm danh học sinh trong lớp</p>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-modern" @click="saveAttendance" :disabled="loading">
                            <i v-if="loading" class="bx bx-loader-alt bx-spin me-1"></i>
                            <i v-else class="bx bx-save me-1"></i>
                            {{ loading ? 'Đang lưu...' : 'Lưu điểm danh' }}
                        </button>
                    </div>

                    <div class="card-body">
                        <div class="table-container">
                            <table class="table table-modern">
                                <thead>
                                    <tr>
                                        <th class="text-center">STT</th>
                                        <th>Học sinh</th>
                                        <th class="text-center">Có mặt</th>
                                        <th class="text-center">Vắng có phép</th>
                                        <th class="text-center">Vắng không phép</th>
                                        <th>Ghi chú</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(student, index) in students" :key="student.id"
                                        :class="getRowClass(student.trang_thai)">
                                        <td class="text-center table-index">
                                            {{ index + 1 }}
                                        </td>
                                        <td class="student-info">
                                            <div class="student-container">
                                                <div class="student-avatar">
                                                    <img :src="student.avatar || '/default-avatar.jpg'"
                                                        :alt="student.ho_va_ten" class="avatar-img" />
                                                    <span class="status-badge"
                                                        :class="getStatusBadgeClass(student.trang_thai)"></span>
                                                </div>
                                                <div class="student-details">
                                                    <span class="student-name">{{ student.ho_va_ten }}</span>
                                                    <small class="student-parent">{{ student.ten_phu_huynh || 'Chưa cập
                                                        nhật' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center col-status">
                                            <label class="radio-wrapper present-radio">
                                                <input type="radio" :name="'attendance-' + student.id" value="co_mat"
                                                    v-model="student.trang_thai" />
                                                <span class="radio-custom"></span>
                                            </label>
                                        </td>
                                        <td class="text-center col-status">
                                            <label class="radio-wrapper absent-permit-radio">
                                                <input type="radio" :name="'attendance-' + student.id"
                                                    value="vang_co_phep" v-model="student.trang_thai" />
                                                <span class="radio-custom"></span>
                                            </label>
                                        </td>
                                        <td class="text-center col-status">
                                            <label class="radio-wrapper absent-no-permit-radio">
                                                <input type="radio" :name="'attendance-' + student.id"
                                                    value="vang_khong_phep" v-model="student.trang_thai" />
                                                <span class="radio-custom"></span>
                                            </label>
                                        </td>
                                        <td class="col-note">
                                            <input type="text" class="note-input" v-model="student.ghi_chu"
                                                placeholder="Nhập ghi chú..." />
                                        </td>
                                    </tr>
                                    <tr v-if="students.length === 0">
                                        <td colspan="6" class="text-center text-muted py-5">
                                            <i class="bx bx-info-circle me-1"></i>Chưa có dữ liệu học sinh
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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
    name: 'Attendance',
    setup() {
        const { proxy } = getCurrentInstance();
        const selectedDate = ref(new Date().toISOString().split('T')[0]);
        const students = ref([]);
        const className = ref('');
        const loading = ref(false);

        const presentCount = computed(() => {
            return students.value.filter(s => s.trang_thai === 'co_mat').length;
        });

        const absentCount = computed(() => {
            return students.value.filter(s => s.trang_thai === 'vang_co_phep' || s.trang_thai === 'vang_khong_phep').length;
        });

        const totalStudents = computed(() => students.value.length);

        const loadAttendance = () => {
            loading.value = true;
            baseRequestTeacher
                .post('teacher/diem-danh/data', { ngay: selectedDate.value })
                .then((res) => {
                    if (res.data.status) {
                        students.value = res.data.data.hoc_sinh || [];
                        className.value = res.data.data.ten_lop || 'Chưa có lớp';
                        // Load existing attendance data if available
                        if (res.data.data.diem_danh) {
                            res.data.data.diem_danh.forEach((dd) => {
                                const student = students.value.find(s => s.id === dd.id_hoc_sinh);
                                if (student) {
                                    student.trang_thai = dd.trang_thai;
                                    student.ghi_chu = dd.ghi_chu || '';
                                }
                            });
                        }
                        proxy.$toast?.success(res.data.message || 'Tải dữ liệu thành công');
                    } else {
                        proxy.$toast?.error(res.data.message || 'Không thể tải dữ liệu');
                    }
                })
                .catch((err) => {
                    const listErr = err.response?.data?.errors;
                    if (listErr) {
                        Object.values(listErr).forEach((error) => {
                            proxy.$toast?.error(error[0]);
                        });
                    } else {
                        proxy.$toast?.error('Có lỗi xảy ra khi tải dữ liệu');
                    }
                })
                .finally(() => {
                    loading.value = false;
                });
        };

        const saveAttendance = () => {
            loading.value = true;
            const attendanceData = {
                ngay: selectedDate.value,
                diem_danh: students.value.map(s => ({
                    id_hoc_sinh: s.id,
                    trang_thai: s.trang_thai || 'co_mat',
                    ghi_chu: s.ghi_chu || ''
                }))
            };

            baseRequestTeacher
                .post('teacher/diem-danh/save', attendanceData)
                .then((res) => {
                    if (res.data.status) {
                        proxy.$toast?.success(res.data.message || 'Lưu điểm danh thành công');
                    } else {
                        proxy.$toast?.error(res.data.message || 'Không thể lưu điểm danh');
                    }
                })
                .catch((err) => {
                    const listErr = err.response?.data?.errors;
                    if (listErr) {
                        Object.values(listErr).forEach((error) => {
                            proxy.$toast?.error(error[0]);
                        });
                    } else {
                        proxy.$toast?.error('Có lỗi xảy ra khi lưu điểm danh');
                    }
                })
                .finally(() => {
                    loading.value = false;
                });
        };

        const getRowClass = (status) => {
            if (status === 'co_mat') return 'row-present';
            if (status === 'vang_co_phep') return 'row-absent-permit';
            if (status === 'vang_khong_phep') return 'row-absent-no-permit';
            return '';
        };

        const getStatusBadgeClass = (status) => {
            if (status === 'co_mat') return 'status-present';
            if (status === 'vang_co_phep') return 'status-absent-permit';
            if (status === 'vang_khong_phep') return 'status-absent-no-permit';
            return '';
        };

        onMounted(() => {
            loadAttendance();
        });

        return {
            selectedDate,
            students,
            className,
            loading,
            presentCount,
            absentCount,
            totalStudents,
            loadAttendance,
            saveAttendance,
            getRowClass,
            getStatusBadgeClass
        };
    }
};
</script>

<style lang="scss">
@use "./style.scss";
</style>
