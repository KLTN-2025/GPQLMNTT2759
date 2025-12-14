<template>
    <div class="profile-page">
        <!-- Header Section -->
        <div class="page-header education-theme">
            <div class="container-fluid">
                <div class="page-header-content">
                    <div class="page-icon">
                        <i class="bx bx-user"></i>
                    </div>
                    <div class="page-info">
                        <h1 class="page-title">Hồ Sơ Cá Nhân</h1>
                        <p class="page-subtitle">Quản lý thông tin cá nhân và cài đặt tài khoản</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="profile-content">
            <div class="container-fluid">
                <div class="row g-4">
                    <!-- Left Column - Avatar & Basic Info -->
                    <div class="col-xl-4">
                        <div class="profile-card">
                            <div class="profile-avatar-section">
                                <div class="profile-avatar-wrapper">
                                    <img :src="anh_tmp || profile.avatar || '/src/assets/images/avatars/avatar-1.png'"
                                        class="profile-avatar" alt="Avatar" />
                                    <label class="btn-change-avatar" for="avatar-upload" title="Đổi ảnh đại diện">
                                        <i class="bx bx-camera"></i>
                                        <input type="file" id="avatar-upload" hidden @change="loadAnhTuLocal"
                                            accept="image/*">
                                    </label>
                                </div>
                                <h4 class="profile-name">{{ profile.ho_va_ten }}</h4>
                                <p class="profile-role">{{ profile.ten_chuc_vu || 'Giáo viên' }}</p>
                            </div>

                            <div class="profile-stats">
                                <div class="stat-item">
                                    <div class="stat-value">{{ profile.so_lop || 0 }}</div>
                                    <div class="stat-label">Lớp phụ trách</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-value">{{ profile.so_hoc_sinh || 0 }}</div>
                                    <div class="stat-label">Học sinh</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-value">{{ profile.tham_nien || 0 }}</div>
                                    <div class="stat-label">Năm kinh nghiệm</div>
                                </div>
                            </div>

                            <div class="profile-contact">
                                <div class="contact-item">
                                    <i class="bx bx-envelope"></i>
                                    <span>{{ profile.email }}</span>
                                </div>
                                <div class="contact-item">
                                    <i class="bx bx-phone"></i>
                                    <span>{{ profile.so_dien_thoai }}</span>
                                </div>
                                <div class="contact-item">
                                    <i class="bx bx-map"></i>
                                    <span>{{ profile.dia_chi }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Tabs -->
                    <div class="col-xl-8">
                        <div class="profile-tabs-card">
                            <div class="tabs-header">
                                <button class="tab-button" :class="{ active: activeTab === 'info' }"
                                    @click="activeTab = 'info'">
                                    <i class="bx bx-user"></i>
                                    Thông tin cá nhân
                                </button>
                                <button class="tab-button" :class="{ active: activeTab === 'work' }"
                                    @click="activeTab = 'work'">
                                    <i class="bx bx-briefcase"></i>
                                    Công việc
                                </button>
                                <button class="tab-button" :class="{ active: activeTab === 'password' }"
                                    @click="activeTab = 'password'">
                                    <i class="bx bx-lock"></i>
                                    Đổi mật khẩu
                                </button>
                            </div>

                            <div class="tabs-content">
                                <!-- Personal Info Tab -->
                                <div v-show="activeTab === 'info'" class="tab-panel">
                                    <form @submit.prevent="updateProfile">
                                        <div class="form-section">
                                            <h6 class="section-title">
                                                <i class="bx bx-user-circle"></i>
                                                Thông tin cơ bản
                                            </h6>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Họ và tên <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" v-model="profile.ho_va_ten"
                                                        required />
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Ngày sinh</label>
                                                    <input type="date" class="form-control"
                                                        v-model="profile.ngay_sinh" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Giới tính</label>
                                                    <select class="form-select" v-model="profile.gioi_tinh">
                                                        <option :value="1">Nam</option>
                                                        <option :value="0">Nữ</option>
                                                        <option :value="2">Khác</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Số điện thoại</label>
                                                    <input type="tel" class="form-control"
                                                        v-model="profile.so_dien_thoai" />
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Địa chỉ</label>
                                                    <textarea class="form-control" rows="2"
                                                        v-model="profile.dia_chi"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bx bx-save"></i>
                                                Lưu thay đổi
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Work Info Tab -->
                                <div v-show="activeTab === 'work'" class="tab-panel">
                                    <form @submit.prevent="updateWorkInfo">
                                        <div class="form-section">
                                            <h6 class="section-title">
                                                <i class="bx bx-building-house"></i>
                                                Thông tin công việc
                                            </h6>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Mã giáo viên</label>
                                                    <input type="text" class="form-control" v-model="profile.id"
                                                        disabled />
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Chức vụ</label>
                                                    <input type="text" class="form-control"
                                                        v-model="profile.ten_chuc_vu" disabled />
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Ngày vào làm</label>
                                                    <input type="date" class="form-control"
                                                        v-model="profile.ngay_vao_lam" disabled />
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Lớp chủ nhiệm</label>
                                                    <input type="text" class="form-control"
                                                        v-model="profile.lop_chu_nhiem" disabled />
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- Change Password Tab -->
                                <div v-show="activeTab === 'password'" class="tab-panel">
                                    <form @submit.prevent="changePassword">
                                        <div class="form-section">
                                            <h6 class="section-title">
                                                <i class="bx bx-shield-quarter"></i>
                                                Bảo mật
                                            </h6>
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <label class="form-label">Mật khẩu hiện tại</label>
                                                    <div class="input-group">
                                                        <input :type="showCurrentPassword ? 'text' : 'password'"
                                                            class="form-control"
                                                            v-model="passwordForm.currentPassword" />
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            @click="showCurrentPassword = !showCurrentPassword">
                                                            <i class="bx"
                                                                :class="showCurrentPassword ? 'bx-show' : 'bx-hide'"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Mật khẩu mới</label>
                                                    <div class="input-group">
                                                        <input :type="showNewPassword ? 'text' : 'password'"
                                                            class="form-control" v-model="passwordForm.newPassword" />
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            @click="showNewPassword = !showNewPassword">
                                                            <i class="bx"
                                                                :class="showNewPassword ? 'bx-show' : 'bx-hide'"></i>
                                                        </button>
                                                    </div>
                                                    <!-- Password strength indicator could go here -->
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Xác nhận mật khẩu mới</label>
                                                    <div class="input-group">
                                                        <input :type="showConfirmPassword ? 'text' : 'password'"
                                                            class="form-control"
                                                            v-model="passwordForm.confirmPassword" />
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            @click="showConfirmPassword = !showConfirmPassword">
                                                            <i class="bx"
                                                                :class="showConfirmPassword ? 'bx-show' : 'bx-hide'"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-primary"
                                                :disabled="passwordForm.newPassword !== passwordForm.confirmPassword">
                                                <i class="bx bx-key"></i>
                                                Đổi mật khẩu
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted, getCurrentInstance } from 'vue';
import baseRequestTeacher from '../../../core/baseRequestTeacher';

export default {
    name: 'TeacherProfile',
    setup() {
        const { proxy } = getCurrentInstance();
        const activeTab = ref('info');

        const profile = ref({});
        const file_anh = ref(null);
        const anh_tmp = ref(null);

        const passwordForm = ref({
            currentPassword: '',
            newPassword: '',
            confirmPassword: ''
        });

        const showCurrentPassword = ref(false);
        const showNewPassword = ref(false);
        const showConfirmPassword = ref(false);

        const loadData = () => {
            baseRequestTeacher
                .get("teacher/profile/data")
                .then((res) => {
                    if (res.data.status) {
                        profile.value = res.data.data;
                    } else {
                        proxy.$toast.error(res.data.message);
                    }
                })
                .catch((err) => {
                    if (err.response && err.response.data && err.response.data.errors) {
                        const listErr = err.response.data.errors;
                        Object.values(listErr).forEach((error) => {
                            proxy.$toast.error(error[0]);
                        });
                    } else {
                        proxy.$toast.error('Có lỗi xảy ra khi tải dữ liệu');
                    }
                });
        };

        onMounted(() => {
            loadData();
        });

        const loadAnhTuLocal = (event) => {
            file_anh.value = event.target.files[0];
            createImage(file_anh.value);
        };

        const createImage = (file) => {
            let reader = new FileReader();
            reader.onload = (e) => {
                anh_tmp.value = e.target.result;
                updateChange();
            };
            reader.readAsDataURL(file);
        };

        const updateChange = () => {
            const payload = new FormData();
            payload.append("hinh_anh", file_anh.value);

            baseRequestTeacher
                .post("teacher/profile/update-avatar", payload)
                .then((res) => {
                    if (res.data.status) {
                        proxy.$toast.success(res.data.message);
                        loadData();
                    } else {
                        proxy.$toast.error(res.data.message);
                    }
                })
                .catch((err) => {
                    if (err.response && err.response.data && err.response.data.errors) {
                        const listErr = err.response.data.errors;
                        Object.values(listErr).forEach((error) => {
                            proxy.$toast.error(error[0]);
                        });
                    } else {
                        proxy.$toast.error('Có lỗi xảy ra khi cập nhật ảnh đại diện');
                    }
                });
        };

        const updateProfile = () => {
            if (!profile.value.ho_va_ten) {
                proxy.$toast.error('Vui lòng điền đầy đủ thông tin bắt buộc');
                return;
            }

            baseRequestTeacher
                .post("teacher/profile/update", profile.value)
                .then((res) => {
                    if (res.data.status) {
                        proxy.$toast.success('Cập nhật thông tin thành công');
                        loadData();
                    } else {
                        proxy.$toast.error(res.data.message);
                    }
                })
                .catch((err) => {
                    if (err.response && err.response.data && err.response.data.errors) {
                        const listErr = err.response.data.errors;
                        Object.values(listErr).forEach((error) => {
                            proxy.$toast.error(error[0]);
                        });
                    } else {
                        proxy.$toast.error('Có lỗi xảy ra khi cập nhật thông tin');
                    }
                });
        };

        const updateWorkInfo = () => {
            proxy.$toast.info('Thông tin công việc được quản lý bởi Admin.');
        };

        const changePassword = () => {
            if (!passwordForm.value.currentPassword || !passwordForm.value.newPassword || !passwordForm.value.confirmPassword) {
                proxy.$toast.error('Vui lòng điền đầy đủ thông tin');
                return;
            }

            if (passwordForm.value.newPassword !== passwordForm.value.confirmPassword) {
                proxy.$toast.error('Mật khẩu mới và xác nhận mật khẩu không khớp');
                return;
            }

            if (passwordForm.value.newPassword.length < 6) {
                proxy.$toast.error('Mật khẩu mới phải có ít nhất 6 ký tự');
                return;
            }

            baseRequestTeacher
                .post("teacher/profile/change-password", passwordForm.value)
                .then((res) => {
                    if (res.data.status) {
                        proxy.$toast.success('Đổi mật khẩu thành công');
                        passwordForm.value = {
                            currentPassword: '',
                            newPassword: '',
                            confirmPassword: ''
                        };
                    } else {
                        proxy.$toast.error(res.data.message);
                    }
                })
                .catch((err) => {
                    if (err.response && err.response.data && err.response.data.errors) {
                        const listErr = err.response.data.errors;
                        Object.values(listErr).forEach((error) => {
                            proxy.$toast.error(error[0]);
                        });
                    } else {
                        proxy.$toast.error('Có lỗi xảy ra khi đổi mật khẩu');
                    }
                });
        };

        return {
            activeTab,
            profile,
            passwordForm,
            showCurrentPassword,
            showNewPassword,
            showConfirmPassword,
            loadAnhTuLocal,
            updateProfile,
            updateWorkInfo,
            changePassword,
            file_anh,
            anh_tmp
        };
    }
};
</script>

<style lang="scss">
@use './style.scss';
</style>
