<template>
    <div class="my-class-page">
        <!-- Header Section -->
        <!-- <div class="page-header education-theme">
            <div class="container-fluid">
                <div class="page-header-content">
                    <div class="page-icon">
                        <i class="bx bx-book-reader"></i>
                    </div>
                    <div class="page-info">
                        <h1 class="page-title">Lớp Học Của Tôi</h1>
                        <p class="page-subtitle">Quản lý thông tin và học sinh trong lớp</p>
                    </div>
                </div>
            </div>
        </div> -->

        <!-- Class Info Card -->
        <div class="class-info-section">
            <div class="container-fluid">
                <div class="class-info-card">
                    <div class="class-info-header">
                        <div class="class-avatar-wrapper">
                            <div class="class-avatar">
                                <i class="bx bx-group"></i>
                            </div>
                            <div class="class-basic-info">
                                <h3>{{ ten_lop }}</h3>
                                <p>{{ ten_nam_hoc }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="class-info-body">
                        <div class="row g-4">
                            <div class="col-md-3 col-sm-6">
                                <div class="info-stat-card">
                                    <div class="stat-icon stat-primary">
                                        <i class="bx bx-user"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-number">{{ totalStudents }}</div>
                                        <div class="stat-label">Học sinh</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="info-stat-card">
                                    <div class="stat-icon stat-success">
                                        <i class="bx bx-male-female"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-number">{{ maleStudents }}/{{ femaleStudents }}</div>
                                        <div class="stat-label">Nam/Nữ</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="info-stat-card">
                                    <div class="stat-icon stat-warning">
                                        <i class="bx bx-calendar"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-number">{{ ageRange }}</div>
                                        <div class="stat-label">Độ tuổi</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="info-stat-card">
                                    <div class="stat-icon stat-info">
                                        <i class="bx bx-time"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-number">{{ schedule }}</div>
                                        <div class="stat-label">Giờ học</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Students List -->
        <div class="students-section">
            <div class="container-fluid">
                <div class="management-card">
                    <div class="card-header-custom">
                        <div class="header-content">
                            <div class="header-icon">
                                <i class="bx bx-list-ul"></i>
                            </div>
                            <div class="header-text">
                                <h5 class="card-title">Danh sách học sinh</h5>
                                <p class="card-subtitle">Quản lý thông tin học sinh trong lớp</p>
                            </div>
                        </div>
                        <div class="header-actions">
                            <div class="search-wrapper">
                                <i class="bx bx-search"></i>
                                <input type="text" class="search-input" placeholder="Tìm kiếm học sinh..."
                                    v-model="searchQuery" />
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div v-if="filteredStudents.length === 0" class="empty-state">
                            <i class="bx bx-user-x"></i>
                            <h3>Không tìm thấy học sinh</h3>
                            <p>Thử tìm kiếm với từ khóa khác</p>
                        </div>
                        <div v-else class="table-container">
                            <table class="table table-modern">
                                <thead>
                                    <tr class="text-center">
                                        <th class="col-index">STT</th>
                                        <th class="col-student">Học sinh</th>
                                        <th class="col-gender">Giới tính</th>
                                        <th class="col-date">Ngày sinh</th>
                                        <th class="col-parent">Phụ huynh</th>
                                        <th class="col-phone">Điện thoại</th>
                                        <th class="col-status">Trạng thái</th>
                                        <th class="col-actions">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(student, index) in filteredStudents" :key="index" class="student-row">
                                        <td class="col-index">
                                            <span class="index-badge">{{ index + 1 }}</span>
                                        </td>
                                        <td class="col-student">
                                            <div class="student-container">
                                                <div class="student-avatar-wrapper">
                                                    <img :src="student.avatar || '/default-avatar.jpg'"
                                                        :alt="student.ho_va_ten" class="avatar-img"
                                                        @error="handleImageError" />
                                                </div>
                                                <div class="student-details">
                                                    <span class="student-name">{{ student.ho_va_ten }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col-gender">
                                            <span class="badge" :class="getGenderBadgeClass(student.gioi_tinh)">
                                                <i :class="getGenderIcon(student.gioi_tinh)"></i>
                                                {{ getGenderLabel(student.gioi_tinh) }}
                                            </span>
                                        </td>
                                        <td class="col-date text-center">{{ formatDate(student.ngay_sinh) }}</td>
                                        <td class="col-parent">{{ student.ten_phu_huynh || 'Chưa cập nhật' }}</td>
                                        <td class="col-phone text-center">{{ student.so_dien_thoai || 'Chưa cập nhật' }}
                                        </td>
                                        <td class="col-status text-center text-nowrap">
                                            <button @click="DoiTrangThai(student)"
                                                :class="getStatusButtonClass(student.tinh_trang)">
                                                {{ getStatusLabel(student.tinh_trang) }}
                                            </button>
                                        </td>
                                        <td class="col-actions text-nowrap">

                                            <button class="btn-action btn-edit" title="Cập nhật" data-bs-toggle="modal"
                                                data-bs-target="#updateModal"
                                                @click="Object.assign(update_hoc_sinh, student)">
                                                <i class="bx bx-edit"></i>
                                            </button>
                                            <button class="btn-action btn-delete" title="Xóa" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal"
                                                @click="Object.assign(delete_hoc_sinh, student)">
                                                <i class="bx bx-trash"></i>
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

        <!-- Modal Cập Nhật Học Sinh -->
        <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header-custom">
                        <div class="modal-header-content">
                            <div class="modal-icon">
                                <i class="bx bx-edit"></i>
                            </div>
                            <div>
                                <h5 class="modal-title" id="updateModalLabel">Cập nhật thông tin học sinh</h5>
                                <p class="modal-subtitle">{{ update_hoc_sinh.ho_va_ten }}</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close-custom" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bx bx-x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" v-model="update_hoc_sinh.ho_va_ten"
                                            required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Giới tính <span class="text-danger">*</span></label>
                                        <select class="form-select" v-model="update_hoc_sinh.gioi_tinh" required>
                                            <option value="1">Nam</option>
                                            <option value="0">Nữ</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Ngày sinh <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" v-model="update_hoc_sinh.ngay_sinh"
                                            required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Trạng thái</label>
                                        <select class="form-select" v-model="update_hoc_sinh.tinh_trang">
                                            <option value="1">Hoạt Động</option>
                                            <option value="0">Tạm Ngừng</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Tên phụ huynh</label>
                                        <input type="text" class="form-control"
                                            v-model="update_hoc_sinh.ten_phu_huynh" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Số điện thoại</label>
                                        <input type="tel" class="form-control"
                                            v-model="update_hoc_sinh.so_dien_thoai" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" v-model="update_hoc_sinh.email" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Địa chỉ</label>
                                        <input type="text" class="form-control" v-model="update_hoc_sinh.dia_chi" />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer-custom">
                        <button type="button" class="btn btn-secondary-custom" data-bs-dismiss="modal">
                            <i class="bx bx-x"></i>
                            Hủy
                        </button>
                        <button type="button" class="btn btn-primary-custom" @click="CapNhatHocSinh"
                            :disabled="loading">
                            <i v-if="loading" class="bx bx-loader-alt bx-spin"></i>
                            <i v-else class="bx bx-save"></i>
                            {{ loading ? 'Đang xử lý...' : 'Cập nhật' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Xóa Học Sinh -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content delete-modal">
                    <div class="modal-header-custom delete-modal-header">
                        <div class="modal-header-content">
                            <div class="modal-icon delete-icon">
                                <i class="bx bx-trash"></i>
                            </div>
                            <div>
                                <h5 class="modal-title delete-title" id="deleteModalLabel">Xác nhận xóa học sinh</h5>
                                <p class="modal-subtitle delete-subtitle">{{ delete_hoc_sinh.ho_va_ten }}</p>
                            </div>
                        </div>
                        <button type="button" class="btn-close-custom" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bx bx-x"></i>
                        </button>
                    </div>
                    <div class="modal-body delete-modal-body">
                        <div class="text-center">
                            <div class="mb-4">
                                <div class="delete-icon-large">
                                    <i class="bx bx-error-circle"></i>
                                </div>
                            </div>
                            <h4 class="delete-question">Bạn có chắc chắn muốn xóa học sinh này không?</h4>
                            <div class="delete-info-box">
                                <div class="delete-info-item">
                                    <span class="delete-info-label">Họ tên:</span>
                                    <span class="delete-info-value">{{ delete_hoc_sinh.ho_va_ten }}</span>
                                </div>
                                <div class="delete-info-item">
                                    <span class="delete-info-label">Lớp:</span>
                                    <span class="delete-info-value">{{ ten_lop }}</span>
                                </div>
                                <div class="delete-info-item">
                                    <span class="delete-info-label">Năm học:</span>
                                    <span class="delete-info-value">{{ ten_nam_hoc }}</span>
                                </div>
                            </div>
                            <p class="delete-warning">
                                <i class="bx bx-info-circle"></i>
                                Hành động này không thể hoàn tác!
                            </p>
                        </div>
                    </div>
                    <div class="modal-footer-custom delete-modal-footer">
                        <button type="button" class="btn btn-secondary-custom" data-bs-dismiss="modal">
                            <i class="bx bx-x"></i>
                            Hủy
                        </button>
                        <button type="button" class="btn btn-danger-custom" @click="XoaHocSinh" :disabled="loading">
                            <i v-if="loading" class="bx bx-loader-alt bx-spin"></i>
                            <i v-else class="bx bx-trash"></i>
                            {{ loading ? 'Đang xử lý...' : 'Xóa học sinh' }}
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
    name: 'MyClass',
    data() {
        return {
            list_hoc_sinh: [],
            update_hoc_sinh: {},
            delete_hoc_sinh: {},
            info_lop: {},
            ten_lop: '',
            ten_nam_hoc: '',
            searchQuery: '',
            loading: false,
        };
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
        },
        filteredStudents() {
            if (!this.searchQuery) return this.list_hoc_sinh;
            const query = this.searchQuery.toLowerCase();
            return this.list_hoc_sinh.filter(student =>
                student.ho_va_ten?.toLowerCase().includes(query) ||
                student.ten_phu_huynh?.toLowerCase().includes(query) ||
                student.so_dien_thoai?.includes(query)
            );
        }
    },
    mounted() {
        this.loadData();
    },
    methods: {
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
        getGenderLabel(gioiTinh) {
            return gioiTinh == '1' ? 'Nam' : 'Nữ';
        },
        getGenderIcon(gioiTinh) {
            return gioiTinh == '1' ? 'bx bx-male' : 'bx bx-female';
        },
        getGenderBadgeClass(gioiTinh) {
            return gioiTinh == '1' ? 'badge-primary' : 'badge-pink';
        },
        getStatusLabel(tinhTrang) {
            return tinhTrang == 1 ? 'Hoạt Động' : 'Tạm Ngừng';
        },
        getStatusButtonClass(tinhTrang) {
            return tinhTrang == 1 
                ? 'btn btn-success btn-sm' 
                : 'btn btn-danger btn-sm';
        },
        handleImageError(event) {
            event.target.src = 'https://ui-avatars.com/api/?name=' + encodeURIComponent(event.target.alt) + '&background=667eea&color=fff&size=128';
        },
        loadData() {
            baseRequestTeacher.get("teacher/my-class/data")
                .then((res) => {
                    if (res.data.status) {
                        this.list_hoc_sinh = res.data.data || [];
                        this.ten_lop = res.data.ten_lop || 'Chưa cập nhật';
                        this.ten_nam_hoc = res.data.ten_nam_hoc || 'Chưa cập nhật';
                        this.info_lop = res.data.info_lop || {};
                    }
                })
                .catch((res) => {
                    const list = Object.values(res.response.data.errors);
                    list.forEach((v, i) => {
                        this.$toast.error(v[0]);
                    })
                });
        },
        DoiTrangThai(payload) {

            baseRequestTeacher.post("teacher/my-class/change-status", payload)
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.loadData();
                    } else {
                        this.$toast.error(res.data.message);
                    }
                })
                .catch((res) => {
                    const list = Object.values(res.response.data.errors);
                    list.forEach((v, i) => {
                        this.$toast.error(v[0]);
                    })
                });
        },
        CapNhatHocSinh() {
            this.loading = true;
            baseRequestTeacher.post("teacher/my-class/update", this.update_hoc_sinh)
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.loadData();
                        const modal = bootstrap.Modal.getInstance(document.getElementById("updateModal"));
                        if (modal) modal.hide();
                    } else {
                        this.$toast.error(res.data.message);
                    }
                })
                .catch((res) => {
                    const list = Object.values(res.response.data.errors);
                    list.forEach((v, i) => {
                        this.$toast.error(v[0]);
                    })
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        XoaHocSinh() {
            this.loading = true;
            baseRequestTeacher.post("teacher/my-class/delete", this.delete_hoc_sinh)
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.loadData();
                        this.delete_hoc_sinh = {};
                        const modal = bootstrap.Modal.getInstance(document.getElementById("deleteModal"));
                        if (modal) modal.hide();
                    } else {
                        this.$toast.error(res.data.message);
                    }
                })
                .catch((res) => {
                    const list = Object.values(res.response.data.errors);
                    list.forEach((v, i) => {
                        this.$toast.error(v[0]);
                    })
                })
                .finally(() => {
                    this.loading = false;
                });
        }
    }
};
</script>

<style lang="scss">
@use './style.scss';
</style>
