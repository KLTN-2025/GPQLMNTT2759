<template>
    <div class="attendance-page">
        <!-- Header Section -->
        <div class="page-header education-theme">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <div class="page-header-content">
                            <div class="page-icon">
                                <i class="bx bx-check-square"></i>
                            </div>
                            <div class="page-info">
                                <h1 class="page-title">Điểm Danh Học Sinh</h1>
                                <p class="page-subtitle">{{ className || 'Quản lý điểm danh học sinh hàng ngày' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="date-section">
                            <div class="date-icon">
                                <i class="bx bx-calendar-check"></i>
                            </div>
                            <div class="date-input-wrapper">
                                <label class="date-label">Chọn ngày điểm danh</label>
                                <input type="date" class="date-input" v-model="selectedDate" @change="loadAttendance"
                                    :max="new Date().toISOString().split('T')[0]" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Statistics Cards -->
        <div class="stats-section">
            <div class="container-fluid">
                <div class="row g-4">
                    <div class="col-xl-3 col-md-6">
                        <div class="stats-card stats-success">
                            <div class="stats-background">
                                <div class="stats-pattern"></div>
                            </div>
                            <div class="stats-content-wrapper">
                                <div class="stats-icon">
                                    <i class="bx bx-check-circle"></i>
                                </div>
                                <div class="stats-content">
                                    <div class="stats-number">{{ presentCount }}</div>
                                    <div class="stats-label">Có mặt</div>
                                    <div class="stats-percentage">
                                        {{ presentPercentage }}%
                                    </div>
                                </div>
                            </div>
                            <div class="stats-progress">
                                <div class="stats-progress-bar"
                                    :style="{ width: presentPercentage + '%' }">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="stats-card stats-danger">
                            <div class="stats-background">
                                <div class="stats-pattern"></div>
                            </div>
                            <div class="stats-content-wrapper">
                                <div class="stats-icon">
                                    <i class="bx bx-x-circle"></i>
                                </div>
                                <div class="stats-content">
                                    <div class="stats-number">{{ absentCount }}</div>
                                    <div class="stats-label">Vắng</div>
                                    <div class="stats-percentage">
                                        {{ absentPercentage }}%
                                    </div>
                                </div>
                            </div>
                            <div class="stats-progress">
                                <div class="stats-progress-bar"
                                    :style="{ width: absentPercentage + '%' }">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="stats-card stats-primary">
                            <div class="stats-background">
                                <div class="stats-pattern"></div>
                            </div>
                            <div class="stats-content-wrapper">
                                <div class="stats-icon">
                                    <i class="bx bx-group"></i>
                                </div>
                                <div class="stats-content">
                                    <div class="stats-number">{{ totalStudents }}</div>
                                    <div class="stats-label">Tổng số học sinh</div>
                                    <div class="stats-percentage">
                                        <i class="bx bx-check"></i> Đã điểm danh
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Attendance Table Section -->
        <div class="attendance-table-section">
            <div class="container-fluid">
                <div class="management-card">
                    <div class="card-header-custom">
                        <div class="header-content">
                            <div class="header-icon">
                                <i class="bx bx-list-ul"></i>
                            </div>
                            <div class="header-text">
                                <h5 class="card-title">Danh sách điểm danh</h5>
                                <p class="card-subtitle">Quản lý và cập nhật tình trạng điểm danh học sinh</p>
                            </div>
                        </div>
                        <div class="header-actions">
                            <button class="btn btn-refresh" @click="loadAttendance" :disabled="loading" title="Làm mới">
                                <i v-if="loading" class="bx bx-loader-alt bx-spin"></i>
                                <i v-else class="bx bx-refresh"></i>
                            </button>
                            <button class="btn btn-save" @click="saveAttendance"
                                :disabled="loading || list_hoc_sinh.length === 0">
                                <i v-if="loading" class="bx bx-loader-alt bx-spin me-2"></i>
                                <i v-else class="bx bx-save me-2"></i>
                                {{ loading ? 'Đang lưu...' : 'Lưu điểm danh' }}
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div v-if="list_hoc_sinh.length === 0 && !loading" class="empty-state">
                            <div class="empty-icon">
                                <i class="bx bx-user-x"></i>
                            </div>
                            <h3>Chưa có dữ liệu học sinh</h3>
                            <p>Vui lòng chọn ngày khác hoặc liên hệ quản trị viên</p>
                        </div>

                        <div v-else-if="loading && list_hoc_sinh.length === 0" class="loading-state">
                            <div class="spinner"></div>
                            <p>Đang tải dữ liệu...</p>
                        </div>

                        <div v-else class="table-container">
                            <table class="table table-modern">
                                <thead>
                                    <tr class="text-center">
                                        <th class="col-index">STT</th>
                                        <th class="col-student">Học sinh</th>
                                        <th class="col-status">
                                            <div class="status-header">
                                                <i class="bx bx-check-circle"></i>
                                                <span>Có mặt</span>
                                            </div>
                                        </th>
                                        <th class="col-status">
                                            <div class="status-header">
                                                <i class="bx bx-x-circle"></i>
                                                <span>Vắng</span>
                                            </div>
                                        </th>
                                        <th class="col-note">Ghi chú</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(student, index) in list_hoc_sinh" :key="student.id"
                                        :class="getRowClass(student.trang_thai)" class="student-row">
                                        <td class="col-index">
                                            <span class="index-badge">{{ index + 1 }}</span>
                                        </td>
                                        <td class="col-student">
                                            <div class="student-container">
                                                <div class="student-avatar-wrapper">
                                                    <img :src="student.avatar || '/default-avatar.jpg'"
                                                        :alt="student.ho_va_ten" class="avatar-img"
                                                        @error="handleImageError" />
                                                    <span class="status-badge"
                                                        :class="getStatusBadgeClass(student.trang_thai)"></span>
                                                </div>
                                                <div class="student-details">
                                                    <span class="student-name">{{ student.ho_va_ten }}</span>
                                                    <small class="student-parent">
                                                        <i class="bx bx-user"></i>
                                                        {{ student.ten_phu_huynh || 'Chưa cập nhật' }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col-status">
                                            <label class="status-radio present-radio">
                                                <input type="radio" :name="'attendance-' + student.id" value="co_mat"
                                                    v-model="student.trang_thai" @change="updateStatistics" />
                                                <span class="radio-custom">
                                                    <i class="bx bx-check"></i>
                                                </span>
                                            </label>
                                        </td>
                                        <td class="col-status">
                                            <label class="status-radio absent-radio">
                                                <input type="radio" :name="'attendance-' + student.id" value="vang"
                                                    v-model="student.trang_thai" @change="updateStatistics" />
                                                <span class="radio-custom">
                                                    <i class="bx bx-x"></i>
                                                </span>
                                            </label>
                                        </td>
                                        <td class="col-note">
                                            <div class="note-input-wrapper">
                                                <input type="text" class="note-input" v-model="student.ghi_chu"
                                                    placeholder="Nhập ghi chú (nếu có)..." />
                                                <i class="bx bx-edit note-icon"></i>
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
    </div>
</template>

<script>
import baseRequestTeacher from '../../../core/baseRequestTeacher';

export default {
    name: 'Attendance',
    data() {
        return {
            list_hoc_sinh: [],
            selectedDate: new Date().toISOString().split('T')[0],
            className: '',
            loading: false,
        };
    },
    computed: {
        totalStudents() {
            return this.list_hoc_sinh.length;
        },
        presentCount() {
            return this.list_hoc_sinh.filter(student => student.trang_thai === 'co_mat').length;
        },
        absentCount() {
            return this.list_hoc_sinh.filter(student => student.trang_thai === 'vang').length;
        },
        presentPercentage() {
            return this.totalStudents > 0 ? Math.round((this.presentCount / this.totalStudents) * 100) : 0;
        },
        absentPercentage() {
            return this.totalStudents > 0 ? Math.round((this.absentCount / this.totalStudents) * 100) : 0;
        }
    },
    mounted() {
        this.loadData();
    },
    methods: {
        loadData() {
            this.loading = true;
            baseRequestTeacher.get("teacher/my-class/data")
                .then((res) => {
                    if (res.data.status) {
                        this.list_hoc_sinh = res.data.data || [];
                        this.className = res.data.ten_lop || '';
                        this.loadAttendance();
                    }
                })
                .catch((err) => {
                    console.error(err);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        loadAttendance() {
            if (!this.selectedDate) {
                this.selectedDate = new Date().toISOString().split('T')[0];
            }

            baseRequestTeacher.get("teacher/attendance/data", {
                params: {
                    ngay: this.selectedDate
                }
            })
                .then((res) => {
                    if (res.data.status && res.data.data) {
                        const attendanceMap = {};
                        res.data.data.forEach(item => {
                            attendanceMap[item.id_hoc_sinh] = {
                                tinh_trang: item.tinh_trang !== undefined ? item.tinh_trang : (item.trang_thai ? this.convertTrangThaiToInt(item.trang_thai) : 1),
                                ghi_chu: item.ghi_chu || ''
                            };
                        });

                        // Cập nhật tình trạng điểm danh cho từng học sinh
                        this.list_hoc_sinh = this.list_hoc_sinh.map(student => {
                            const attendance = attendanceMap[student.id];
                            const tinh_trang = attendance?.tinh_trang !== undefined ? attendance.tinh_trang : 1;
                            return {
                                ...student,
                                trang_thai: this.convertIntToTrangThai(tinh_trang),
                                ghi_chu: attendance?.ghi_chu || ''
                            };
                        });
                    } else {
                        // Nếu chưa có dữ liệu điểm danh, set mặc định là 'co_mat'
                        this.list_hoc_sinh = this.list_hoc_sinh.map(student => ({
                            ...student,
                            trang_thai: student.trang_thai || 'co_mat',
                            ghi_chu: student.ghi_chu || ''
                        }));
                    }
                })
                .catch((err) => {
                    console.error('Error loading attendance:', err);
                    if (this.$toast) {
                        this.$toast.error('Không thể tải dữ liệu điểm danh');
                    }
                });
        },
        saveAttendance() {
            if (this.list_hoc_sinh.length === 0) return;

            this.loading = true;
            const attendanceData = {
                ngay: this.selectedDate,
                danh_sach: this.list_hoc_sinh.map(student => ({
                    id_hoc_sinh: student.id,
                    tinh_trang: this.convertTrangThaiToInt(student.trang_thai || 'co_mat'),
                    ghi_chu: student.ghi_chu || ''
                }))
            };

            baseRequestTeacher.post("teacher/attendance/save", attendanceData)
                .then((res) => {
                    if (res.data.status) {
                        if (this.$toast) {
                            this.$toast.success(res.data.message || 'Lưu điểm danh thành công');
                        } else {
                            alert(res.data.message || 'Lưu điểm danh thành công');
                        }
                        // Reload attendance data sau khi lưu thành công
                        this.loadAttendance();
                    } else {
                        if (this.$toast) {
                            this.$toast.error(res.data.message || 'Có lỗi xảy ra');
                        } else {
                            alert(res.data.message || 'Có lỗi xảy ra');
                        }
                    }
                })
                .catch((err) => {
                    const errorMessage = err.response?.data?.message || 'Không thể lưu điểm danh';
                    if (this.$toast) {
                        this.$toast.error(errorMessage);
                    } else {
                        alert(errorMessage);
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        updateStatistics() {
            // Computed properties sẽ tự động cập nhật
            // Method này có thể được gọi khi cần thực hiện thêm logic
        },
        getRowClass(status) {
            if (status === 'co_mat') return 'row-present';
            if (status === 'vang') return 'row-absent';
            return '';
        },
        getStatusBadgeClass(status) {
            if (status === 'co_mat') return 'badge-present';
            if (status === 'vang') return 'badge-absent';
            return '';
        },
        handleImageError(event) {
            event.target.src = 'https://ui-avatars.com/api/?name=' + encodeURIComponent(event.target.alt) + '&background=667eea&color=fff&size=128';
        },
        // Convert từ string sang integer (0 hoặc 1) để gửi lên backend
        convertTrangThaiToInt(trangThai) {
            // co_mat = 1, vang = 0
            return trangThai === 'co_mat' ? 1 : 0;
        },
        // Convert từ integer (0 hoặc 1) sang string để hiển thị
        convertIntToTrangThai(tinhTrang) {
            // 1 = co_mat, 0 = vang
            return tinhTrang === 1 ? 'co_mat' : 'vang';
        }
    }
};
</script>

<style lang="scss">
@use "./style.scss";
</style>
