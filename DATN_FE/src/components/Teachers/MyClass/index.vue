<template>
    <div class="my-class-page">
        <div class="page-header mb-4">
            <h2 class="page-title">
                <i class="bx bx-book-reader me-2"></i>Lớp Học Của Tôi
            </h2>
            <p class="page-subtitle">Quản lý thông tin và học sinh trong lớp</p>
        </div>

        <!-- Class Info Card -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card info-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-3 text-center">
                                <div class="class-avatar">
                                    <i class="bx bx-group"></i>
                                </div>
                                <h4 class="mt-3 mb-0">{{ ten_lop }}</h4>
                                <p class="text-muted">{{ ten_nam_hoc }}</p>
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="info-item">
                                            <i class="bx bx-user text-primary"></i>
                                            <div>
                                                <h5>{{ totalStudents }}</h5>
                                                <p>Học sinh</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="info-item">
                                            <i class="bx bx-male-female text-success"></i>
                                            <div>
                                                <h5>{{ maleStudents }}/{{ femaleStudents }}</h5>
                                                <p>Nam/Nữ</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="info-item">
                                            <i class="bx bx-calendar text-warning"></i>
                                            <div>
                                                <h5>{{ ageRange }}</h5>
                                                <p>Độ tuổi</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="info-item">
                                            <i class="bx bx-time text-info"></i>
                                            <div>
                                                <h5>{{ schedule }}</h5>
                                                <p>Giờ học</p>
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

        <!-- Students List -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-list-ul me-2"></i>Danh sách học sinh
                        </h5>
                        <div class="d-flex gap-2">
                            <input type="text" class="form-control form-control-sm" placeholder="Tìm kiếm học sinh..."
                                style="width: 250px;" v-model="searchQuery" />
                            <button class="btn btn-primary" >Tìm kiếm</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="align-middle text-center">
                                        <th>STT</th>
                                        <th>Hình ảnh</th>
                                        <th>Họ và tên</th>
                                        <th>Giới tính</th>
                                        <th>Ngày sinh</th>
                                        <th>Phụ huynh</th>
                                        <th>Điện thoại</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(value, index) in list_hoc_sinh" :key="index" class="align-middle">
                                        <td class="text-center">{{ index + 1 }}</td>
                                        <td class="text-center"><img :src="value.avatar" class="student-avatar me-2"
                                                :alt="value.name" /></td>
                                        <td>{{ value.ho_va_ten }}</td>
                                        <td class="text-center">
                                            <span class="badge w-50"
                                                :class="value.gioi_tinh == '1' ? 'bg-primary' : 'bg-pink'">
                                                {{ value.gioi_tinh == '1' ? 'Nam' : 'Nữ' }}
                                            </span>
                                        </td>
                                        <td class="text-center">{{ value.ngay_sinh }}</td>
                                        <td>{{ value.ten_phu_huynh }}</td>
                                        <td class="text-center">{{ value.so_dien_thoai }}</td>
                                        <td class="text-center">
                                            <button v-on:click="DoiTrangThai(value)" v-if="value.tinh_trang == 1"
                                                class="btn btn-success">Hoạt
                                                động</button>
                                            <button v-on:click="DoiTrangThai(value)" v-else-if="value.tinh_trang == 2"
                                                class="btn btn-warning">Tạm
                                                vắng</button>
                                            <button v-on:click="DoiTrangThai(value)" v-else class="btn btn-danger">Tạm
                                                ngừng</button>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-outline-info me-2" title="Xem chi tiết"
                                                data-bs-toggle="modal" data-bs-target="#detailModal"
                                                v-on:click="Object.assign(detail_hoc_sinh, value)">
                                                <i class="fa-solid fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Xem Chi Tiết -->
        <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel">
                            <i class="bx bx-user me-2"></i>Thông tin chi tiết học sinh
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Header Section -->
                        <div class="row mb-4">
                            <div class="col-md-3 text-center">
                                <div class="student-profile-section">
                                    <img :src="detail_hoc_sinh.avatar" class="student-detail-avatar mb-3"
                                        :alt="detail_hoc_sinh.ho_va_ten" />
                                    <h4 class="student-name">{{ detail_hoc_sinh.ho_va_ten }}</h4>
                                    <div class="student-badges">
                                        <span class="badge me-2"
                                            :class="detail_hoc_sinh.gioi_tinh == '1' ? 'bg-primary' : 'bg-pink'">
                                            <i class="bx"
                                                :class="detail_hoc_sinh.gioi_tinh == '1' ? 'bx-male' : 'bx-female'"></i>
                                            {{ detail_hoc_sinh.gioi_tinh == '1' ? 'Nam' : 'Nữ' }}
                                        </span>
                                        <span class="badge bg-info">
                                            <i class="bx bx-cake"></i>
                                            {{ calculateAge(detail_hoc_sinh.ngay_sinh) }} tuổi
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="info-card">
                                            <div class="info-icon">
                                                <i class="bx bx-calendar text-primary"></i>
                                            </div>
                                            <div class="info-content">
                                                <label class="info-label">Ngày sinh</label>
                                                <p class="info-value">{{ formatDate(detail_hoc_sinh.ngay_sinh) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="info-card">
                                            <div class="info-icon">
                                                <i class="bx bx-shield-check text-success"></i>
                                            </div>
                                            <div class="info-content">
                                                <label class="info-label">Trạng thái</label>
                                                <div class="info-value">
                                                    <button v-if="detail_hoc_sinh.tinh_trang == 1"
                                                        class="btn btn-success btn-sm">
                                                        <i class="bx bx-check-circle me-1"></i>Hoạt động
                                                    </button>
                                                    <button v-else-if="detail_hoc_sinh.tinh_trang == 2"
                                                        class="btn btn-warning btn-sm">
                                                        <i class="bx bx-time me-1"></i>Tạm vắng
                                                    </button>
                                                    <button v-else class="btn btn-danger btn-sm">
                                                        <i class="bx bx-x-circle me-1"></i>Tạm ngừng
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="info-card">
                                            <div class="info-icon">
                                                <i class="bx bx-user-circle text-warning"></i>
                                            </div>
                                            <div class="info-content">
                                                <label class="info-label">Phụ huynh</label>
                                                <p class="info-value">{{ detail_hoc_sinh.ten_phu_huynh }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="info-card">
                                            <div class="info-icon">
                                                <i class="bx bx-phone text-info"></i>
                                            </div>
                                            <div class="info-content">
                                                <label class="info-label">Số điện thoại</label>
                                                <p class="info-value">
                                                    <a :href="'tel:' + detail_hoc_sinh.so_dien_thoai"
                                                        class="text-decoration-none">
                                                        <i class="bx bx-phone-call me-1"></i>{{
                                                            detail_hoc_sinh.so_dien_thoai }}
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information Tabs -->
                        <div class="student-details-tabs">
                            <ul class="nav nav-tabs" id="studentTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="personal-tab" data-bs-toggle="tab"
                                        data-bs-target="#personal" type="button" role="tab">
                                        <i class="bx bx-user me-2"></i>Thông tin cá nhân
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="academic-tab" data-bs-toggle="tab"
                                        data-bs-target="#academic" type="button" role="tab">
                                        <i class="bx bx-book me-2"></i>Học tập
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                        data-bs-target="#contact" type="button" role="tab">
                                        <i class="bx bx-phone me-2"></i>Liên hệ
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="notes-tab" data-bs-toggle="tab" data-bs-target="#notes"
                                        type="button" role="tab">
                                        <i class="bx bx-note me-2"></i>Ghi chú
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content" id="studentTabsContent">
                                <!-- Personal Information Tab -->
                                <div class="tab-pane fade show active" id="personal" role="tabpanel">
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <div class="detail-section">
                                                <h6 class="section-title">
                                                    <i class="bx bx-info-circle me-2"></i>Thông tin cơ bản
                                                </h6>
                                                <div class="detail-item">
                                                    <span class="detail-label">Họ và tên:</span>
                                                    <span class="detail-value">{{ detail_hoc_sinh.ho_va_ten }}</span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Giới tính:</span>
                                                    <span class="detail-value">
                                                        <i class="bx"
                                                            :class="detail_hoc_sinh.gioi_tinh == '1' ? 'bx-male text-primary' : 'bx-female text-pink'"></i>
                                                        {{ detail_hoc_sinh.gioi_tinh == '1' ? 'Nam' : 'Nữ' }}
                                                    </span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Ngày sinh:</span>
                                                    <span class="detail-value">{{ formatDate(detail_hoc_sinh.ngay_sinh)
                                                    }}</span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Tuổi:</span>
                                                    <span class="detail-value">{{
                                                        calculateAge(detail_hoc_sinh.ngay_sinh) }} tuổi</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="detail-section">
                                                <h6 class="section-title">
                                                    <i class="bx bx-shield me-2"></i>Trạng thái
                                                </h6>
                                                <div class="detail-item">
                                                    <span class="detail-label">Trạng thái hiện tại:</span>
                                                    <span class="detail-value">
                                                        <span v-if="detail_hoc_sinh.tinh_trang == 1"
                                                            class="badge bg-success">
                                                            <i class="bx bx-check-circle me-1"></i>Hoạt động
                                                        </span>
                                                        <span v-else-if="detail_hoc_sinh.tinh_trang == 2"
                                                            class="badge bg-warning">
                                                            <i class="bx bx-time me-1"></i>Tạm vắng
                                                        </span>
                                                        <span v-else class="badge bg-danger">
                                                            <i class="bx bx-x-circle me-1"></i>Tạm ngừng
                                                        </span>
                                                    </span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Ngày nhập học:</span>
                                                    <span class="detail-value">{{
                                                        formatDate(detail_hoc_sinh.ngay_nhap_hoc || new Date())
                                                    }}</span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Thời gian học:</span>
                                                    <span class="detail-value">{{
                                                        calculateStudyTime(detail_hoc_sinh.ngay_nhap_hoc) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Academic Information Tab -->
                                <div class="tab-pane fade" id="academic" role="tabpanel">
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <div class="detail-section">
                                                <h6 class="section-title">
                                                    <i class="bx bx-book-open me-2"></i>Thông tin lớp học
                                                </h6>
                                                <div class="detail-item">
                                                    <span class="detail-label">Lớp hiện tại:</span>
                                                    <span class="detail-value">{{ ten_lop }}</span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Năm học:</span>
                                                    <span class="detail-value">{{ ten_nam_hoc }}</span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Giáo viên chủ nhiệm:</span>
                                                    <span class="detail-value"> {{ info_lop.ten_giao_vien || 'Chưa cập nhật' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="detail-section">
                                                <h6 class="section-title">
                                                    <i class="bx bx-trophy me-2"></i>Thành tích học tập
                                                </h6>
                                                <div class="detail-item">
                                                    <span class="detail-label">Điểm trung bình:</span>
                                                    <span class="detail-value">
                                                        <span class="badge bg-primary">{{
                                                            detail_hoc_sinh.diem_trung_binh || 'Chưa có' }}</span>
                                                    </span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Xếp loại:</span>
                                                    <span class="detail-value">
                                                        <span class="badge"
                                                            :class="getGradeBadgeClass(detail_hoc_sinh.xep_loai)">
                                                            {{ detail_hoc_sinh.xep_loai || 'Chưa đánh giá' }}
                                                        </span>
                                                    </span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Số ngày nghỉ:</span>
                                                    <span class="detail-value">{{ detail_hoc_sinh.so_ngay_nghi || 0 }}
                                                        ngày</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Information Tab -->
                                <div class="tab-pane fade" id="contact" role="tabpanel">
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <div class="detail-section">
                                                <h6 class="section-title">
                                                    <i class="bx bx-user-circle me-2"></i>Thông tin phụ huynh
                                                </h6>
                                                <div class="detail-item">
                                                    <span class="detail-label">Họ tên phụ huynh:</span>
                                                    <span class="detail-value">{{ detail_hoc_sinh.ten_phu_huynh
                                                    }}</span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Số điện thoại:</span>
                                                    <span class="detail-value">
                                                        <a :href="'tel:' + detail_hoc_sinh.so_dien_thoai"
                                                            class="contact-link">
                                                            <i class="bx bx-phone-call me-1"></i>{{
                                                                detail_hoc_sinh.so_dien_thoai }}
                                                        </a>
                                                    </span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Email:</span>
                                                    <span class="detail-value">
                                                        <a v-if="detail_hoc_sinh.email"
                                                            :href="'mailto:' + detail_hoc_sinh.email"
                                                            class="contact-link">
                                                            <i class="bx bx-envelope me-1"></i>{{ detail_hoc_sinh.email
                                                            }}
                                                        </a>
                                                        <span v-else class="text-muted">Chưa cập nhật</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="detail-section">
                                                <h6 class="section-title">
                                                    <i class="bx bx-home me-2"></i>Địa chỉ
                                                </h6>
                                                <div class="detail-item">
                                                    <span class="detail-label">Địa chỉ:</span>
                                                    <span class="detail-value">{{ detail_hoc_sinh.dia_chi || 'Chưa cập nhật' }}</span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Phường/Xã:</span>
                                                    <span class="detail-value">{{ detail_hoc_sinh.phuong_xa || 'Chưa cập nhật' }}</span>
                                                </div>
                                                <div class="detail-item">
                                                    <span class="detail-label">Quận/Huyện:</span>
                                                    <span class="detail-value">{{ detail_hoc_sinh.quan_huyen || 'Chưa cập nhật' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Notes Tab -->
                                <div class="tab-pane fade" id="notes" role="tabpanel">
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="detail-section">
                                                <h6 class="section-title">
                                                    <i class="bx bx-note me-2"></i>Ghi chú và nhận xét
                                                </h6>
                                                <div class="notes-content">
                                                    <div v-if="detail_hoc_sinh.ghi_chu" class="note-item">
                                                        <div class="note-header">
                                                            <i class="bx bx-note text-primary me-2"></i>
                                                            <strong>Ghi chú:</strong>
                                                        </div>
                                                        <div class="note-body">
                                                            {{ detail_hoc_sinh.ghi_chu }}
                                                        </div>
                                                    </div>
                                                    <div v-else class="no-notes">
                                                        <i class="bx bx-note text-muted"></i>
                                                        <p class="text-muted">Chưa có ghi chú nào</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x me-1"></i>Đóng
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" data-bs-toggle="modal"
                            data-bs-target="#editModal" v-on:click="Object.assign(update_hoc_sinh, detail_hoc_sinh)">
                            <i class="bx bx-edit me-1"></i>Chỉnh sửa
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
    data() {
        return {
            list_hoc_sinh: [],
            detail_hoc_sinh: {},
            info_lop: {},
            search: {},
            ten_lop: '',
            ten_nam_hoc: '',
        }
    },
    computed: {
        totalStudents() {
            return this.list_hoc_sinh.length;
        },
        maleStudents() {
            return this.list_hoc_sinh.filter(student => student.gioi_tinh == '1').length;
        },
        femaleStudents() {
            return this.list_hoc_sinh.filter(student => student.gioi_tinh == '0').length;
        },
        ageRange() {
            if (this.list_hoc_sinh.length === 0) return 'N/A';
            const ages = this.list_hoc_sinh.map(student => this.calculateAge(student.ngay_sinh));
            const minAge = Math.min(...ages);
            const maxAge = Math.max(...ages);
            return minAge === maxAge ? `${minAge} tuổi` : `${minAge}-${maxAge} tuổi`;
        },
        schedule() {
            return this.info_lop.gio_hoc || 'Chưa cập nhật';
        }
    },
    mounted() {
        this.LoadData();
    },
    methods: {
        LoadData() {
            baseRequestTeacher.get("teacher/my-class/data")
                .then((res) => {
                    if (res.data.status) {
                        this.list_hoc_sinh = res.data.data;
                        this.ten_lop = res.data.ten_lop || 'Chưa cập nhật';
                        this.ten_nam_hoc = res.data.ten_nam_hoc || 'Chưa cập nhật';
                        this.info_lop = res.data.info_lop || {};
                        this.$toast.success(res.data.message);
                    } else {
                        this.$toast.error(res.data.message);
                    }
                })
                .catch((err) => {
                    this.$toast.error(err.response.data.message);
                })
        },

        DoiTrangThai(payload) {
            baseRequestTeacher.post("teacher/my-class/change-status", payload)
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.LoadData();
                    }
                    else {
                        this.$toast.error(res.data.message);
                    }
                });
        },
        calculateAge(birthDate) {
            if (!birthDate) return 0;
            const today = new Date();
            const birth = new Date(birthDate);
            let age = today.getFullYear() - birth.getFullYear();
            const monthDiff = today.getMonth() - birth.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
                age--;
            }
            return age;
        },
        formatDate(dateString) {
            if (!dateString) return 'Chưa cập nhật';
            const date = new Date(dateString);
            return date.toLocaleDateString('vi-VN', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            });
        },
        calculateStudyTime(startDate) {
            if (!startDate) return 'Chưa cập nhật';
            const start = new Date(startDate);
            const today = new Date();
            const diffTime = Math.abs(today - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            if (diffDays < 30) {
                return `${diffDays} ngày`;
            } else if (diffDays < 365) {
                const months = Math.floor(diffDays / 30);
                return `${months} tháng`;
            } else {
                const years = Math.floor(diffDays / 365);
                const remainingMonths = Math.floor((diffDays % 365) / 30);
                return remainingMonths > 0 ? `${years} năm ${remainingMonths} tháng` : `${years} năm`;
            }
        },
        getGradeBadgeClass(grade) {
            if (!grade) return 'bg-secondary';
            const gradeLower = grade.toLowerCase();
            if (gradeLower.includes('giỏi') || gradeLower.includes('xuất sắc')) {
                return 'bg-success';
            } else if (gradeLower.includes('khá')) {
                return 'bg-info';
            } else if (gradeLower.includes('trung bình')) {
                return 'bg-warning';
            } else if (gradeLower.includes('yếu') || gradeLower.includes('kém')) {
                return 'bg-danger';
            }
            return 'bg-secondary';
        }
    }
};
</script>

<style scoped>
.my-class-page {
    padding: 20px;
}

.page-header {
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 15px;
}

.page-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.page-subtitle {
    color: #6c757d;
    margin: 0;
}

.info-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.class-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    font-size: 3rem;
    color: white;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 10px;
    margin-bottom: 10px;
}

.info-item i {
    font-size: 2rem;
}

.info-item h5 {
    margin: 0;
    font-weight: 700;
    color: #2c3e50;
}

.info-item p {
    margin: 0;
    font-size: 0.85rem;
    color: #6c757d;
}

.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.card-header {
    background: #f8f9fa;
    border-bottom: 2px solid #e9ecef;
    padding: 1.25rem;
    border-radius: 15px 15px 0 0;
}

.card-title {
    font-weight: 600;
    color: #2c3e50;
}

.student-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.table th {
    font-weight: 600;
    color: #2c3e50;
    border-bottom: 2px solid #dee2e6;
}

.table td {
    vertical-align: middle;
}

.bg-pink {
    background-color: #ec4899 !important;
}

.student-detail-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #e9ecef;
}

.modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 15px 15px 0 0;
}

.modal-header .btn-close {
    filter: invert(1);
}

.modal-content {
    border: none;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.modal-body {
    padding: 2rem;
}

.form-label {
    font-weight: 600;
    color: #2c3e50;
}

.form-control,
.form-select {
    border-radius: 8px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.form-control:focus,
.form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.btn {
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Enhanced Detail Modal Styles */
.student-profile-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 15px;
    padding: 20px;
    margin-bottom: 20px;
}

.student-name {
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 15px;
}

.student-badges .badge {
    font-size: 0.8rem;
    padding: 8px 12px;
    border-radius: 20px;
}

.info-card {
    display: flex;
    align-items: center;
    background: #f8f9fa;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 10px;
    border-left: 4px solid #667eea;
    transition: all 0.3s ease;
}

.info-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.info-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    flex-shrink: 0;
}

.info-icon i {
    font-size: 1.5rem;
    color: white;
}

.info-content {
    flex: 1;
}

.info-label {
    font-weight: 600;
    color: #6c757d;
    font-size: 0.85rem;
    margin-bottom: 5px;
    display: block;
}

.info-value {
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
    font-size: 1rem;
}

.contact-link {
    color: #667eea;
    text-decoration: none;
    transition: color 0.3s ease;
}

.contact-link:hover {
    color: #764ba2;
    text-decoration: underline;
}

/* Student Details Tabs */
.student-details-tabs {
    margin-top: 20px;
}

.student-details-tabs .nav-tabs {
    border-bottom: 2px solid #e9ecef;
    margin-bottom: 20px;
}

.student-details-tabs .nav-link {
    border: none;
    border-radius: 10px 10px 0 0;
    color: #6c757d;
    font-weight: 500;
    padding: 12px 20px;
    margin-right: 5px;
    transition: all 0.3s ease;
}

.student-details-tabs .nav-link:hover {
    color: #667eea;
    background-color: #f8f9fa;
}

.student-details-tabs .nav-link.active {
    color: #667eea;
    background-color: white;
    border-bottom: 2px solid #667eea;
}

.detail-section {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
}

.section-title {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid #e9ecef;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #e9ecef;
}

.detail-item:last-child {
    border-bottom: none;
}

.detail-label {
    font-weight: 600;
    color: #6c757d;
    flex: 1;
}

.detail-value {
    font-weight: 500;
    color: #2c3e50;
    text-align: right;
    flex: 1;
}

.notes-content {
    background: white;
    border-radius: 10px;
    padding: 20px;
    border: 1px solid #e9ecef;
}

.note-item {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
    border-left: 4px solid #667eea;
}

.note-header {
    color: #2c3e50;
    margin-bottom: 10px;
}

.note-body {
    color: #6c757d;
    line-height: 1.6;
}

.no-notes {
    text-align: center;
    padding: 40px 20px;
    color: #6c757d;
}

.no-notes i {
    font-size: 3rem;
    margin-bottom: 15px;
    display: block;
}

/* Modal Enhancements */
.modal-xl {
    max-width: 1200px;
}

.modal-body {
    max-height: 70vh;
    overflow-y: auto;
}

/* Responsive Design */
@media (max-width: 768px) {
    .my-class-page {
        padding: 10px;
    }

    .page-title {
        font-size: 1.5rem;
    }

    .modal-dialog {
        margin: 0.5rem;
    }

    .student-detail-avatar {
        width: 80px;
        height: 80px;
    }

    .info-card {
        flex-direction: column;
        text-align: center;
    }

    .info-icon {
        margin-right: 0;
        margin-bottom: 10px;
    }

    .detail-item {
        flex-direction: column;
        align-items: flex-start;
    }

    .detail-value {
        text-align: left;
        margin-top: 5px;
    }

    .student-details-tabs .nav-link {
        padding: 8px 12px;
        font-size: 0.9rem;
    }
}
</style>
