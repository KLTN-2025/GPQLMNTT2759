<template>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header schedule-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class='bx bx-calendar-check me-2'></i>
                            Lịch làm việc cá nhân
                        </h5>
                        <div>
                            <button class="btn btn-week-nav" @click="changeWeek(-1)">
                                <i class='bx bx-chevron-left'></i> Tuần trước
                            </button>
                            <button class="btn btn-week-nav" @click="changeWeek(1)">
                                Tuần sau <i class='bx bx-chevron-right'></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div v-if="loading" class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Đang tải...</span>
                        </div>
                    </div>
                    <div v-else>
                        <div class="week-title">{{ weekTitle }}</div>
                        <div class="schedule-calendar">
                            <!-- Header: Ngày -->
                            <div class="schedule-header-row">
                                <div class="schedule-shift-column">Ca</div>
                                <div class="schedule-day-header" v-for="day in weekDays" :key="day.name">
                                    <div class="day-name">{{ day.name }}</div>
                                    <div class="day-date">{{ day.date }}</div>
                                </div>
                            </div>

                            <!-- Content: Ca sáng -->
                            <div class="schedule-content-row">
                                <div class="schedule-shift-label schedule-shift-morning">
                                    <i class='bx bx-sun'></i>
                                    <span>Ca sáng</span>
                                </div>
                                <div class="schedule-cell" v-for="(day, idx) in weekDays" :key="'morning-' + idx">
                                    <div v-if="getMorningSchedule(day.date)"
                                        class="schedule-item schedule-morning schedule-registered"
                                        @click="openDeleteModal(getMorningSchedule(day.date))">
                                        <div class="schedule-status-success">
                                            <i class='bx bx-check-circle'></i>
                                            <span>Đã đăng ký</span>
                                        </div>
                                    </div>
                                    <div v-else class="schedule-empty-cell schedule-add"
                                        @click="openAddModal(day.date, 1)" title="Nhấn để thêm lịch">
                                        <i class='bx bx-plus'></i>
                                        <span class="add-text">Thêm lịch</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Content: Ca chiều -->
                            <div class="schedule-content-row">
                                <div class="schedule-shift-label schedule-shift-afternoon">
                                    <i class='bx bx-moon'></i>
                                    <span>Ca chiều</span>
                                </div>
                                <div class="schedule-cell" v-for="(day, idx) in weekDays" :key="'afternoon-' + idx">
                                    <div v-if="getAfternoonSchedule(day.date)"
                                        class="schedule-item schedule-afternoon schedule-registered"
                                        @click="openDeleteModal(getAfternoonSchedule(day.date))">
                                        <div class="schedule-status-success">
                                            <i class='bx bx-check-circle'></i>
                                            <span>Đã đăng ký</span>
                                        </div>
                                    </div>
                                    <div v-else class="schedule-empty-cell schedule-add"
                                        @click="openAddModal(day.date, 2)" title="Nhấn để thêm lịch">
                                        <i class='bx bx-plus'></i>
                                        <span class="add-text">Thêm lịch</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal thêm lịch -->
        <div class="modal fade" id="addScheduleModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class='bx bx-plus-circle me-2'></i>
                            Đăng ký lịch làm việc
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class='bx bx-info-circle me-2'></i>
                            <strong>Ngày:</strong> {{ formatDate(new Date(addForm.ngay_lam_viec)) }}<br>
                            <strong>Ca:</strong> {{ addForm.ca_lam_viec === 1 ? 'Ca sáng' : 'Ca chiều' }}
                        </div>
                        <p class="text-muted mb-0">Bạn có chắc chắn muốn đăng ký lịch làm việc này?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class='bx bx-x'></i> Hủy
                        </button>
                        <button type="button" class="btn btn-primary" @click="confirmAddSchedule">
                            <i class='bx bx-check'></i> Xác nhận đăng ký
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal xóa lịch -->
        <div class="modal fade" id="deleteScheduleModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title">
                            <i class='bx bx-trash me-2'></i>
                            Hủy lịch làm việc
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <i class='bx bx-warning me-2'></i>
                            <strong>Ngày:</strong> {{ formatDate(new Date(deleteForm.ngay_lam_viec)) }}<br>
                            <strong>Ca:</strong> {{ deleteForm.ca_lam_viec === 1 ? 'Ca sáng' : 'Ca chiều' }}
                        </div>
                        <p class="text-danger fw-bold mb-0">
                            <i class='bx bx-error-circle me-2'></i>
                            Bạn có chắc chắn muốn hủy lịch làm việc này?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class='bx bx-x'></i> Đóng
                        </button>
                        <button type="button" class="btn btn-danger" @click="confirmDeleteSchedule">
                            <i class='bx bx-trash'></i> Xác nhận hủy
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import baseRequestTeacher from '../../../core/baseRequestTeacher';
import { createToaster } from "@meforma/vue-toaster";

const toaster = createToaster({ position: "top-right" });

export default {
    name: 'Schedule',
    data() {
        return {
            currentWeek: new Date(),
            schedules: [],
            loading: false,
            idGiaoVien: null,
            addForm: {
                id_giao_vien: null,
                ngay_lam_viec: '',
                ca_lam_viec: 1
            },
            deleteForm: {
                id: null,
                ngay_lam_viec: '',
                ca_lam_viec: 1
            }
        };
    },
    computed: {
        weekTitle() {
            const start = this.getWeekStart(this.currentWeek);
            const end = new Date(start);
            end.setDate(start.getDate() + 4); // Thứ 2 đến Thứ 6 (5 ngày)
            return `${this.formatDate(start)} - ${this.formatDate(end)}`;
        },
        weekDays() {
            const start = this.getWeekStart(this.currentWeek);
            const days = ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6'];
            return days.map((name, index) => {
                const date = new Date(start);
                date.setDate(start.getDate() + index);
                return { name, date: this.formatDate(date) };
            });
        },
    },
    mounted() {
        this.loadSchedules();
    },
    methods: {
        getWeekStart(date) {
            const d = new Date(date);
            const day = d.getDay();
            const diff = d.getDate() - day + (day === 0 ? -6 : 1); // Thứ 2 là ngày đầu tuần
            d.setDate(diff);
            d.setHours(0, 0, 0, 0);
            return d;
        },
        formatDate(date) {
            if (!date) return "";
            const dateObj = date instanceof Date ? date : new Date(date);
            return dateObj.toLocaleDateString('vi-VN', { day: '2-digit', month: '2-digit', year: 'numeric' });
        },
        formatDateForAPI(date) {
            if (!date) return "";
            const dateObj = date instanceof Date ? date : new Date(date);
            const year = dateObj.getFullYear();
            const month = String(dateObj.getMonth() + 1).padStart(2, '0');
            const day = String(dateObj.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
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
        getMorningSchedule(dateStr) {
            const schedules = this.getSchedulesForDay(dateStr);
            return schedules.find(s => parseInt(s.ca_lam_viec) === 1);
        },
        getAfternoonSchedule(dateStr) {
            const schedules = this.getSchedulesForDay(dateStr);
            return schedules.find(s => parseInt(s.ca_lam_viec) === 2);
        },
        isMorning(item) {
            return parseInt(item.ca_lam_viec) === 1;
        },
        isAfternoon(item) {
            return parseInt(item.ca_lam_viec) === 2;
        },
        getScheduleItemClass(item) {
            if (item.ca_lam_viec === 1) {
                return 'schedule-morning';
            } else if (item.ca_lam_viec === 2) {
                return 'schedule-afternoon';
            }
            return 'schedule-default';
        },
        // Mở modal thêm lịch
        openAddModal(dateStr, caLamViec) {
            if (!this.idGiaoVien) {
                toaster.error('Không tìm thấy thông tin giáo viên. Vui lòng đăng nhập lại.');
                return;
            }

            // Convert dateStr từ format dd/mm/yyyy sang yyyy-mm-dd
            const parts = dateStr.split('/');
            const ngayLamViec = `${parts[2]}-${parts[1]}-${parts[0]}`;

            this.addForm.id_giao_vien = this.idGiaoVien;
            this.addForm.ngay_lam_viec = ngayLamViec;
            this.addForm.ca_lam_viec = caLamViec;

            console.log('Data sẽ gửi lên:', this.addForm);

            const modal = new bootstrap.Modal(document.getElementById('addScheduleModal'));
            modal.show();
        },
        // Mở modal xóa lịch
        openDeleteModal(item) {
            this.deleteForm.id = item.id;
            this.deleteForm.ngay_lam_viec = item.ngay_lam_viec;
            this.deleteForm.ca_lam_viec = item.ca_lam_viec;

            const modal = new bootstrap.Modal(document.getElementById('deleteScheduleModal'));
            modal.show();
        },
        // Xác nhận thêm lịch
        async confirmAddSchedule() {
            const success = await this.createLichLamViecGiaoVien(this.addForm);
            if (success) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('addScheduleModal'));
                modal.hide();
            }
        },
        // Xác nhận xóa lịch
        async confirmDeleteSchedule() {
            const success = await this.deleteLichLamViec(this.deleteForm.id);
            if (success) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('deleteScheduleModal'));
                modal.hide();
            }
        },
        async loadSchedules() {
            try {
                this.loading = true;
                const response = await baseRequestTeacher.get('teacher/lich-lam-viec/data');

                if (response.data.status) {
                    // Transform data từ API - chỉ lấy thông tin cần thiết cho lịch làm việc
                    this.schedules = (response.data.data || []).map(item => ({
                        id: item.id,
                        id_giao_vien: item.id_giao_vien,
                        ngay_lam_viec: item.ngay_lam_viec,
                        ca_lam_viec: parseInt(item.ca_lam_viec),
                        ...item
                    }));

                    // Lấy id_giao_vien từ lịch làm việc đầu tiên
                    if (this.schedules.length > 0 && !this.idGiaoVien) {
                        this.idGiaoVien = this.schedules[0].id_giao_vien;
                        this.addForm.id_giao_vien = this.schedules[0].id_giao_vien;
                        console.log('ID giáo viên từ lịch làm việc:', this.idGiaoVien);
                    }

                    console.log('Schedules loaded:', this.schedules);
                } else {
                    toaster.error(response.data.message || 'Có lỗi xảy ra khi tải dữ liệu');
                }
            } catch (error) {
                console.error('Error fetching schedule data:', error);
                toaster.error('Có lỗi xảy ra khi tải dữ liệu lịch làm việc');
            } finally {
                this.loading = false;
            }
        },
        // Lấy ngày làm việc của giáo viên
        async getNgayLamViecGiaoVien(ngayLamViec) {
            try {
                const response = await baseRequestTeacher.post('teacher/lich-lam-viec/ngay-lam-viec', {
                    ngay_lam_viec: ngayLamViec
                });

                if (response.data.status) {
                    return response.data.data || [];
                } else {
                    toaster.error(response.data.message || 'Có lỗi xảy ra');
                    return [];
                }
            } catch (error) {
                console.error('Error fetching working days:', error);
                toaster.error('Có lỗi xảy ra khi lấy ngày làm việc');
                return [];
            }
        },
        // Tạo lịch làm việc mới
        async createLichLamViecGiaoVien(scheduleData) {
            try {
                this.loading = true;
                const response = await baseRequestTeacher.post('teacher/lich-lam-viec/create', scheduleData);

                if (response.data.status) {
                    toaster.success(response.data.message || 'Tạo lịch làm việc thành công');
                    await this.loadSchedules(); // Reload data
                    return true;
                } else {
                    toaster.error(response.data.message || 'Có lỗi xảy ra khi tạo lịch làm việc');
                    return false;
                }
            } catch (error) {
                console.error('Error creating schedule:', error);

                // Xử lý các loại lỗi từ backend
                if (error.response) {
                    const status = error.response.status;
                    const message = error.response.data?.message;

                    switch (status) {
                        case 400:
                            toaster.error(message || 'Dữ liệu không hợp lệ');
                            break;
                        case 403:
                            toaster.error('Bạn không có quyền thực hiện chức năng này');
                            break;
                        case 404:
                            toaster.error('Giáo viên không tồn tại');
                            break;
                        default:
                            toaster.error(message || 'Có lỗi xảy ra khi tạo lịch làm việc');
                    }
                } else {
                    toaster.error('Không thể kết nối đến server');
                }
                return false;
            } finally {
                this.loading = false;
            }
        },
        // Xóa lịch làm việc
        async deleteLichLamViec(scheduleId) {
            try {
                this.loading = true;
                const response = await baseRequestTeacher.post('teacher/lich-lam-viec/delete', {
                    id: scheduleId
                });

                if (response.data.status) {
                    toaster.success(response.data.message || 'Xóa lịch làm việc thành công');
                    await this.loadSchedules(); // Reload data
                    return true;
                } else {
                    toaster.error(response.data.message || 'Có lỗi xảy ra khi xóa lịch làm việc');
                    return false;
                }
            } catch (error) {
                console.error('Error deleting schedule:', error);
                const errorMessage = error.response?.data?.message || 'Có lỗi xảy ra khi xóa lịch làm việc';
                toaster.error(errorMessage);
                return false;
            } finally {
                this.loading = false;
            }
        },
    }
}
</script>

<style lang="scss">
@use "./style.scss";
</style>
