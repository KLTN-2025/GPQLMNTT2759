<template>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Lịch làm việc giáo viên</h5>
                    <div>
                        <button class="btn btn-outline-secondary btn-sm me-2" @click="changeWeek(-1)">
                            <i class='bx bx-chevron-left'></i> Tuần trước
                        </button>
                        <button class="btn btn-outline-secondary btn-sm" @click="changeWeek(1)">
                            Tuần sau <i class='bx bx-chevron-right'></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filter Teachers -->
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    <i class='bx bx-user me-2'></i>Chọn giáo viên
                                </label>
                                <select class="form-select" v-model="selectedTeacherId" @change="loadSchedules">
                                    <option value="">-- Tất cả giáo viên --</option>
                                    <option v-for="teacher in teachers" :key="teacher.id" :value="teacher.id">
                                        {{ teacher.ho_va_ten }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div v-if="loading" class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Đang tải...</span>
                        </div>
                    </div>
                    <div v-else>
                        <div class="mb-2 fw-semibold">{{ weekTitle }}</div>
                        <div class="row g-0 border rounded">
                            <div class="col-12">
                                <div class="row g-0">
                                    <div class="col" v-for="day in weekDays" :key="day.name">
                                        <div class="p-2 bg-light border-end text-center fw-bold">
                                            {{ day.name }}<br>
                                            <small class="text-muted">{{ day.date }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row g-0" style="min-height: 360px;">
                                    <div class="col border-end" v-for="(day, idx) in weekDays" :key="idx">
                                        <div class="p-2 h-100" style="min-height: 360px;">
                                            <div v-for="item in getSchedulesForDay(day.date)" :key="item.id"
                                                class="mb-2 p-2 border rounded cursor-pointer schedule-item" :class="{
                                                    'morning': isMorning(item),
                                                    'afternoon': isAfternoon(item),
                                                    'evening': isEvening(item)
                                                }" @click="viewScheduleDetail(item)">
                                                <div class="fw-bold small mb-1">{{ item.teacher_name }}</div>
                                                <div class="small text-muted">
                                                    <span class="badge bg-success me-1"
                                                        v-if="isMorning(item)">Sáng</span>
                                                    <span class="badge bg-info text-dark me-1"
                                                        v-if="isAfternoon(item)">Chiều</span>
                                                    <span class="badge bg-warning text-dark me-1"
                                                        v-if="isEvening(item)">Tối</span>
                                                </div>
                                                <div class="small text-muted"
                                                    v-if="item.thoi_gian_bat_dau && item.thoi_gian_ket_thuc">
                                                    {{ item.thoi_gian_bat_dau }} - {{ item.thoi_gian_ket_thuc }}
                                                </div>
                                            </div>
                                            <div v-if="getSchedulesForDay(day.date).length === 0"
                                                class="text-center text-muted py-3 small">
                                                Không có lịch
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal chi tiết lịch làm việc -->
        <div class="modal fade" id="scheduleTeacherDetailModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class='bx bx-info-circle me-2'></i>
                            Chi tiết lịch làm việc giáo viên
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="schedule-detail-info">
                            <div class="info-row mb-2">
                                <span class="fw-bold">
                                    <i class='bx bx-user'></i> Giáo viên:
                                </span>
                                <span class="ms-2">{{ selectedSchedule.teacher_name }}</span>
                            </div>
                            <div class="info-row mb-2">
                                <span class="fw-bold">
                                    <i class='bx bx-calendar'></i> Ngày làm việc:
                                </span>
                                <span class="ms-2">{{ formatDate(new Date(selectedSchedule.ngay_lam_viec)) }}</span>
                            </div>
                            <div class="info-row mb-2">
                                <span class="fw-bold">
                                    <i class='bx bx-time'></i> Ca làm việc:
                                </span>
                                <span class="ms-2">{{ selectedSchedule.ca_lam_viec === 1 ? 'Ca sáng' : 'Ca chiều'
                                    }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class='bx bx-x'></i> Đóng
                        </button>
                        <button type="button" class="btn btn-danger" @click="confirmDeleteSchedule">
                            <i class='bx bx-trash'></i> Xóa lịch
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import baseRequestAdmin from '../../../core/baseRequestAdmin';

export default {
    name: 'ScheduleTeacher',
    data() {
        return {
            currentWeek: new Date(),
            schedules: [],
            teachers: [],
            loading: false,
            selectedTeacherId: '',
            selectedSchedule: {
                id: null,
                teacher_name: '',
                ngay_lam_viec: '',
                ca_lam_viec: 1
            }
        };
    },
    computed: {
        weekTitle() {
            const start = this.getWeekStart(this.currentWeek);
            const end = new Date(start);
            end.setDate(start.getDate() + 6);
            return `${this.formatDate(start)} - ${this.formatDate(end)}`;
        },
        weekDays() {
            const start = this.getWeekStart(this.currentWeek);
            const days = ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7', 'Chủ nhật'];
            return days.map((name, index) => {
                const date = new Date(start);
                date.setDate(start.getDate() + index);
                return { name, date: this.formatDate(date) };
            });
        },
    },
    mounted() {
        this.loadTeachers();
        this.loadSchedules();
    },
    methods: {
        getWeekStart(date) {
            const d = new Date(date);
            const day = d.getDay();
            const diff = d.getDate() - day + (day === 0 ? -6 : 1);
            d.setDate(diff);
            d.setHours(0, 0, 0, 0);
            return d;
        },
        formatDate(date) {
            if (!date) return "";
            const dateObj = date instanceof Date ? date : new Date(date);
            return dateObj.toLocaleDateString('vi-VN', { day: '2-digit', month: '2-digit', year: 'numeric' });
        },
        changeWeek(step) {
            const n = new Date(this.currentWeek);
            n.setDate(n.getDate() + step * 7);
            this.currentWeek = n;
            this.loadSchedules();
        },
        getSchedulesForDay(dateStr) {
            return this.schedules.filter(s => {
                const scheduleDate = this.formatDate(new Date(s.ngay_lam_viec));
                return scheduleDate === dateStr;
            });
        },
        isMorning(item) {
            if (item.thoi_gian_bat_dau) {
                return item.thoi_gian_bat_dau < '12:00';
            }
            return item.ca_lam_viec === 1;
        },
        isAfternoon(item) {
            if (item.thoi_gian_bat_dau) {
                return item.thoi_gian_bat_dau >= '12:00' && item.thoi_gian_bat_dau < '18:00';
            }
            return item.ca_lam_viec === 2;
        },
        isEvening(item) {
            if (item.thoi_gian_bat_dau) {
                return item.thoi_gian_bat_dau >= '18:00';
            }
            return false;
        },
        viewScheduleDetail(schedule) {
            this.selectedSchedule = {
                id: schedule.id,
                teacher_name: schedule.teacher_name,
                ngay_lam_viec: schedule.ngay_lam_viec,
                ca_lam_viec: schedule.ca_lam_viec
            };
            const modal = new bootstrap.Modal(document.getElementById('scheduleTeacherDetailModal'));
            modal.show();
        },
        // Load danh sách giáo viên
        loadTeachers() {
            baseRequestAdmin
                .get('admin/giao-vien/data')
                .then((res) => {
                    if (res.data.status) {
                        this.teachers = res.data.data || [];
                    } else {
                        this.$toast.error(res.data.message || 'Có lỗi xảy ra khi tải danh sách giáo viên');
                    }
                })
                .catch((err) => {
                    const listErr = err.response?.data?.errors;
                    if (listErr) {
                        Object.values(listErr).forEach((error) => {
                            this.$toast.error(error[0]);
                        });
                    } else {
                        this.$toast.error('Có lỗi xảy ra khi tải danh sách giáo viên');
                    }
                });
        },
        // Load lịch làm việc giáo viên
        loadSchedules() {
            this.loading = true;
            const searchData = {};

            // Filter by teacher if selected
            if (this.selectedTeacherId) {
                searchData.id_giao_vien = this.selectedTeacherId;
            }

            // Get week start and end dates for filtering
            const weekStart = this.getWeekStart(this.currentWeek);
            const weekEnd = new Date(weekStart);
            weekEnd.setDate(weekStart.getDate() + 6);

            searchData.from_date = weekStart.toISOString().split('T')[0];
            searchData.to_date = weekEnd.toISOString().split('T')[0];

            baseRequestAdmin
                .post('admin/lich-lam-viec/giao-vien/search', searchData)
                .then((res) => {
                    if (res.data.status) {
                        // Transform data từ API
                        this.schedules = (res.data.data || []).map(item => ({
                            id: item.id,
                            id_giao_vien: item.id_giao_vien,
                            teacher_name: item.ho_va_ten || 'Không xác định',
                            id_chuc_vu: item.id_chuc_vu,
                            ngay_lam_viec: item.ngay_lam_viec,
                            ca_lam_viec: parseInt(item.ca_lam_viec),
                            thoi_gian_bat_dau: item.thoi_gian_bat_dau || null,
                            thoi_gian_ket_thuc: item.thoi_gian_ket_thuc || null,
                        }));
                        // Dữ liệu đã tải thành công
                    } else {
                        this.$toast.error(res.data.message || 'Có lỗi xảy ra khi tải dữ liệu');
                    }
                })
                .catch((err) => {
                    const listErr = err.response?.data?.errors;
                    if (listErr) {
                        Object.values(listErr).forEach((error) => {
                            this.$toast.error(error[0]);
                        });
                    } else {
                        this.$toast.error('Có lỗi xảy ra khi tải dữ liệu lịch làm việc');
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        // Xác nhận xóa lịch
        confirmDeleteSchedule() {
            this.XoaLichLamViec();
        },

        // Xóa lịch làm việc
        XoaLichLamViec() {
            this.loading = true;
            baseRequestAdmin
                .post('admin/lich-lam-viec/delete', {
                    id: this.selectedSchedule.id
                })
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message || 'Xóa lịch làm việc thành công');
                        this.loadSchedules();
                        // Đóng modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('scheduleTeacherDetailModal'));
                        if (modal) modal.hide();
                    } else {
                        this.$toast.error(res.data.message || 'Có lỗi xảy ra khi xóa lịch làm việc');
                    }
                })
                .catch((err) => {
                    const listErr = err.response?.data?.errors;
                    if (listErr) {
                        Object.values(listErr).forEach((error) => {
                            this.$toast.error(error[0]);
                        });
                    } else {
                        this.$toast.error('Có lỗi xảy ra khi xóa lịch làm việc');
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
        },
    }
}
</script>

<style lang="scss">
@use "./style.scss";
</style>
