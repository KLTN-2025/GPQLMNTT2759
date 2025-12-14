<template>
    <div class="health-page">
        <!-- Header Section -->
        <div class="page-header education-theme">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-7">
                        <div class="page-header-content">
                            <div class="page-icon">
                                <i class="bx bx-heart"></i>
                            </div>
                            <div class="page-info">
                                <h1 class="page-title">Sức Khỏe Học Sinh</h1>
                                <p class="page-subtitle">{{ className || 'Quản lý và theo dõi sức khỏe học sinh' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="date-section">
                            <div class="date-icon">
                                <i class="bx bx-calendar-check"></i>
                            </div>
                            <div class="date-input-wrapper">
                                <label class="date-label">Chọn ngày</label>
                                <input type="date" class="date-input" v-model="selectedDate" @change="loadDataSucKhoe"
                                    :max="new Date().toISOString().split('T')[0]" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Health Content -->
        <div class="health-section">
            <div class="container-fluid">
                <div class="management-card">
                    <div class="card-header-custom">
                        <div class="header-content">
                            <div class="header-icon">
                                <i class="bx bx-heart-circle"></i>
                            </div>
                            <div class="header-text">
                                <h5 class="card-title">Hồ sơ sức khỏe</h5>
                                <p class="card-subtitle">Quản lý thông tin sức khỏe học sinh</p>
                            </div>
                        </div>
                        <div class="header-actions">
                            <div class="search-wrapper">
                                <i class="bx bx-search"></i>
                                <input type="text" placeholder="Tìm kiếm học sinh..." v-model="searchQuery"
                                    class="search-input" />
                            </div>
                            <button class="btn btn-refresh" @click="loadDataSucKhoe" :disabled="loading"
                                title="Làm mới">
                                <i v-if="loading" class="bx bx-loader-alt bx-spin"></i>
                                <i v-else class="bx bx-refresh"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div v-if="filteredStudents.length === 0 && !loading" class="empty-state">
                            <i class="bx bx-user-x"></i>
                            <h3>Không tìm thấy học sinh</h3>
                            <p>Thử tìm kiếm với từ khóa khác</p>
                        </div>
                        <div v-else-if="loading && list_hoc_sinh.length === 0" class="loading-state">
                            <div class="spinner"></div>
                            <p>Đang tải dữ liệu...</p>
                        </div>
                        <div v-else class="table-container">
                            <table class="table table-modern">
                                <thead>
                                    <tr>
                                        <th class="col-index">STT</th>
                                        <th class="col-student">Học sinh</th>
                                        <th class="col-height">Chiều cao (cm)</th>
                                        <th class="col-weight">Cân nặng (kg)</th>
                                        <th class="col-teeth">Răng miệng</th>
                                        <th class="col-vision">Thị lực</th>
                                        <th class="col-bmi">BMI</th>
                                        <th class="col-note">Ghi chú sức khỏe</th>
                                        <th class="col-actions">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(student, index) in filteredStudents" :key="student.id"
                                        class="student-row">
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
                                        <td class="col-height">{{ student.chieu_cao || 'Chưa cập nhật' }}</td>
                                        <td class="col-weight">{{ student.can_nang || 'Chưa cập nhật' }}</td>
                                        <td class="col-teeth">
                                            <input type="text" class="form-control form-control-sm" readonly
                                                v-if="student.rang_mieng == 1" value="Tốt" />
                                            <input type="text" class="form-control form-control-sm" readonly
                                                v-else-if="student.rang_mieng == 2" value="Khá" />
                                            <input type="text" class="form-control form-control-sm" readonly
                                                v-else-if="student.rang_mieng == 3" value="Trung bình" />
                                            <input type="text" class="form-control form-control-sm" readonly
                                                v-else-if="student.rang_mieng == 4" value="Yếu" />
                                            <input type="text" class="form-control form-control-sm" readonly v-else
                                                value="Chưa cập nhật" />
                                        </td>
                                        <td class="col-vision">
                                            <input type="text" class="form-control form-control-sm" readonly
                                                v-if="student.thi_luc == 1" value="Tốt" />
                                            <input type="text" class="form-control form-control-sm" readonly
                                                v-else-if="student.thi_luc == 2" value="Khá" />
                                            <input type="text" class="form-control form-control-sm" readonly
                                                v-else-if="student.thi_luc == 3" value="Trung bình" />
                                            <input type="text" class="form-control form-control-sm" readonly
                                                v-else-if="student.thi_luc == 4" value="Yếu" />
                                            <input type="text" class="form-control form-control-sm" readonly v-else
                                                value="Chưa cập nhật" />
                                        </td>
                                        <td class="col-bmi">
                                            <span class="badge" :class="getBMIBadgeClass(student.bmi)">
                                                {{ student.bmi || 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="col-note">
                                            <input type="text" class="form-control form-control-sm" readonly
                                                v-if="student.tinh_trang_suc_khoe == 0" value="Nguy hiểm" />
                                            <input type="text" class="form-control form-control-sm" readonly
                                                v-else-if="student.tinh_trang_suc_khoe == 1" value="Cần can thiệp" />
                                            <input type="text" class="form-control form-control-sm" readonly
                                                v-else-if="student.tinh_trang_suc_khoe == 2" value="Cần theo dõi" />
                                            <input type="text" class="form-control form-control-sm" readonly
                                                v-else-if="student.tinh_trang_suc_khoe == 3" value="Tốt" />
                                            <input type="text" class="form-control form-control-sm" readonly v-else
                                                value="Không có" />
                                        </td>
                                        <td class="col-actions">
                                            <button class="btn-action btn-edit" title="Cập nhật"
                                                @click="openUpdateModal(student)">
                                                <i class="bx bx-edit"></i>
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

        <!-- Modal Cập Nhật Sức Khỏe -->
        <div class="modal fade" id="updateHealthModal" tabindex="-1" aria-labelledby="updateHealthModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header-custom">
                        <div class="modal-header-content">
                            <div class="modal-icon">
                                <i class="bx bx-heart"></i>
                            </div>
                            <div>
                                <h5 class="modal-title" id="updateHealthModalLabel">Cập nhật sức khỏe học sinh</h5>
                                <p class="modal-subtitle">{{ update_health.ho_va_ten }}</p>
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
                                        <label class="form-label">Chiều cao (cm) <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" v-model="update_health.chieu_cao"
                                            placeholder="Nhập chiều cao" step="0.1" min="0" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Cân nặng (kg) <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" v-model="update_health.can_nang"
                                            placeholder="Nhập cân nặng" step="0.1" min="0" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Răng miệng</label>
                                        <select class="form-select" v-model="update_health.rang_mieng">
                                            <option value="">Chọn tình trạng</option>
                                            <option value="1">Tốt</option>
                                            <option value="2">Khá</option>
                                            <option value="3">Trung bình</option>
                                            <option value="4">Yếu</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Thị lực</label>
                                        <select class="form-select" v-model="update_health.thi_luc">
                                            <option value="">Chọn tình trạng</option>
                                            <option value="1">Tốt</option>
                                            <option value="2">Khá</option>
                                            <option value="3">Trung bình</option>
                                            <option value="4">Yếu</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">BMI</label>
                                        <input type="text" class="form-control" v-model="calculatedBMI" readonly
                                            placeholder="Tự động tính toán" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Ghi chú sức khỏe</label>
                                        <select class="form-select" v-model="update_health.tinh_trang_suc_khoe">
                                            <option value="">Chọn tình trạng</option>
                                            <option value="0">Nguy hiểm</option>
                                            <option value="1">Cần can thiệp</option>
                                            <option value="2">Cần theo dõi</option>
                                            <option value="3">Tốt</option>
                                        </select>
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
                        <button type="button" class="btn btn-primary-custom" @click="saveHealthRecord"
                            :disabled="loading">
                            <i v-if="loading" class="bx bx-loader-alt bx-spin"></i>
                            <i v-else class="bx bx-save"></i>
                            {{ loading ? 'Đang lưu...' : 'Lưu thông tin' }}
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
    name: 'Health',
    data() {
        return {
            list_hoc_sinh: [],
            update_health: {},
            selectedDate: new Date().toISOString().split('T')[0],
            className: '',
            searchQuery: '',
            loading: false,
        };
    },
    computed: {
        filteredStudents() {
            if (!this.searchQuery) return this.list_hoc_sinh;
            const query = this.searchQuery.toLowerCase();
            return this.list_hoc_sinh.filter(student =>
                student.ho_va_ten?.toLowerCase().includes(query) ||
                student.tinh_trang_suc_khoe?.toLowerCase().includes(query)
            );
        },
        calculatedBMI() {
            if (!this.update_health.chieu_cao || !this.update_health.can_nang) return '';
            const height = parseFloat(this.update_health.chieu_cao) / 100; // Convert cm to m
            const weight = parseFloat(this.update_health.can_nang);
            if (height > 0 && weight > 0) {
                const bmi = (weight / (height * height)).toFixed(1);
                return bmi;
            }
            return '';
        }
    },
    mounted() {
        this.loadDataSucKhoe();
    },
    methods: {
        loadDataSucKhoe() {
            if (!this.selectedDate) {
                this.selectedDate = new Date().toISOString().split('T')[0];
            }

            this.loading = true;
            baseRequestTeacher.get("teacher/suc-khoe/data-by-lop", {
                params: {
                    ngay: this.selectedDate
                }
            })
                .then((res) => {
                    if (res.data.status) {
                        this.list_hoc_sinh = (res.data.data || []).map(item => {
                            const bmi = item.bmi || this.calculateBMI(item.chieu_cao, item.can_nang) || '';
                            return {
                                id: item.id_hoc_sinh,
                                ho_va_ten: item.ho_va_ten || '',
                                avatar: item.avatar || '',
                                chieu_cao: item.chieu_cao || '',
                                can_nang: item.can_nang || '',
                                rang_mieng: item.rang_mieng || '',
                                thi_luc: item.thi_luc || '',
                                bmi: bmi,
                                tinh_trang_suc_khoe: item.tinh_trang_suc_khoe || ''
                            };
                        });
                        this.className = res.data.ten_lop || '';
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
        calculateBMI(height, weight) {
            if (!height || !weight) return '';
            const h = parseFloat(height) / 100; // Convert cm to m
            const w = parseFloat(weight);
            if (h > 0 && w > 0) {
                return (w / (h * h)).toFixed(1);
            }
            return '';
        },
        getBMIBadgeClass(bmi) {
            if (!bmi) return 'bg-secondary';
            const bmiValue = parseFloat(bmi);
            if (bmiValue < 16) return 'bg-danger'; // Gầy độ III
            if (bmiValue < 17) return 'bg-warning'; // Gầy độ II
            if (bmiValue < 18.5) return 'bg-info'; // Gầy độ I
            if (bmiValue < 25) return 'bg-success'; // Bình thường
            if (bmiValue < 30) return 'bg-warning'; // Thừa cân
            return 'bg-danger'; // Béo phì
        },
        openUpdateModal(student) {
            this.update_health = {
                id: student.id,
                id_hoc_sinh: student.id,
                ho_va_ten: student.ho_va_ten,
                chieu_cao: student.chieu_cao || '',
                can_nang: student.can_nang || '',
                rang_mieng: student.rang_mieng || '',
                thi_luc: student.thi_luc || '',
                tinh_trang_suc_khoe: student.tinh_trang_suc_khoe || '',
                ngay: this.selectedDate
            };
            const modal = new bootstrap.Modal(document.getElementById('updateHealthModal'));
            modal.show();
        },
        saveHealthRecord() {
            if (!this.update_health.chieu_cao || !this.update_health.can_nang) {
                this.$toast.error('Vui lòng nhập đầy đủ chiều cao và cân nặng');
                return;
            }

            this.loading = true;
            const healthData = {
                id_hoc_sinh: this.update_health.id_hoc_sinh,
                chieu_cao: this.update_health.chieu_cao,
                can_nang: this.update_health.can_nang,
                rang_mieng: this.update_health.rang_mieng || '',
                thi_luc: this.update_health.thi_luc || '',
                bmi: this.calculatedBMI,
                tinh_trang_suc_khoe: this.update_health.tinh_trang_suc_khoe || '',
                ngay: this.selectedDate
            };

            baseRequestTeacher.post("teacher/health/save", healthData)
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message || 'Lưu thông tin sức khỏe thành công');
                        this.loadDataSucKhoe();
                        const modal = bootstrap.Modal.getInstance(document.getElementById("updateHealthModal"));
                        if (modal) modal.hide();
                    } else {
                        this.$toast.error(res.data.message || 'Có lỗi xảy ra');
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
        handleImageError(event) {
            event.target.src = 'https://ui-avatars.com/api/?name=' + encodeURIComponent(event.target.alt) + '&background=667eea&color=fff&size=128';
        }
    }
};
</script>

<style lang="scss">
@use './style.scss';
</style>
