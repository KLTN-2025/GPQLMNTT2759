<template>
    <div class="profile-page">
        <div class="page-header mb-4">
            <h2 class="page-title">
                <i class="bx bx-user me-2"></i>Hồ Sơ Cá Nhân
            </h2>
            <p class="page-subtitle">Quản lý thông tin cá nhân và cài đặt tài khoản</p>
        </div>

        <div class="row">
            <!-- Left Column - Avatar & Basic Info -->
            <div class="col-md-4 mb-4">
                <div class="card profile-card">
                    <div class="card-body text-center">
                        <div class="profile-avatar-wrapper mb-3">
                            <img :src="profile.avatar" class="profile-avatar" alt="Avatar" />
                            <button class="btn-change-avatar" @click="changeAvatar">
                                <i class="bx bx-camera"></i>
                            </button>
                        </div>
                        <h4 class="profile-name mb-1">{{ profile.fullName }}</h4>
                        <p class="profile-role text-muted mb-3">{{ profile.role }}</p>

                        <div class="profile-stats">
                            <div class="stat-item">
                                <h5>{{ profile.classCount }}</h5>
                                <p>Lớp phụ trách</p>
                            </div>
                            <div class="stat-item">
                                <h5>{{ profile.studentCount }}</h5>
                                <p>Học sinh</p>
                            </div>
                            <div class="stat-item">
                                <h5>{{ profile.yearsOfExperience }}</h5>
                                <p>Năm kinh nghiệm</p>
                            </div>
                        </div>

                        <div class="profile-badges mt-3">
                            <span class="badge bg-success">
                                <i class="bx bx-check-circle me-1"></i>Tài khoản đã xác thực
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Quick Info Card -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h6 class="card-title mb-3">
                            <i class="bx bx-info-circle me-2"></i>Thông tin nhanh
                        </h6>
                        <div class="quick-info-item">
                            <i class="bx bx-envelope"></i>
                            <div>
                                <small class="text-muted">Email</small>
                                <p>{{ profile.email }}</p>
                            </div>
                        </div>
                        <div class="quick-info-item">
                            <i class="bx bx-phone"></i>
                            <div>
                                <small class="text-muted">Điện thoại</small>
                                <p>{{ profile.phone }}</p>
                            </div>
                        </div>
                        <div class="quick-info-item">
                            <i class="bx bx-map"></i>
                            <div>
                                <small class="text-muted">Địa chỉ</small>
                                <p>{{ profile.address }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Tabs -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <!-- Tabs -->
                        <ul class="nav nav-tabs mb-4" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" @click="activeTab = 'info'"
                                    :class="{ active: activeTab === 'info' }">
                                    <i class="bx bx-user me-2"></i>Thông tin cá nhân
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" @click="activeTab = 'work'"
                                    :class="{ active: activeTab === 'work' }">
                                    <i class="bx bx-briefcase me-2"></i>Công việc
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" @click="activeTab = 'password'"
                                    :class="{ active: activeTab === 'password' }">
                                    <i class="bx bx-lock me-2"></i>Đổi mật khẩu
                                </button>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content">
                            <!-- Personal Info Tab -->
                            <div v-show="activeTab === 'info'">
                                <form @submit.prevent="updateProfile">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Họ và tên <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" v-model="profile.fullName"
                                                required />
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Ngày sinh</label>
                                            <input type="date" class="form-control" v-model="profile.dateOfBirth" />
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Giới tính</label>
                                            <select class="form-select" v-model="profile.gender">
                                                <option value="Nữ">Nữ</option>
                                                <option value="Nam">Nam</option>
                                                <option value="Khác">Khác</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Số điện thoại</label>
                                            <input type="tel" class="form-control" v-model="profile.phone" />
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" v-model="profile.email" />
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">CCCD/CMND</label>
                                            <input type="text" class="form-control" v-model="profile.idCard" />
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Địa chỉ</label>
                                            <textarea class="form-control" rows="2"
                                                v-model="profile.address"></textarea>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bx bx-save me-2"></i>Lưu thay đổi
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary ms-2">
                                                <i class="bx bx-reset me-2"></i>Hủy
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Work Info Tab -->
                            <div v-show="activeTab === 'work'">
                                <form @submit.prevent="updateWorkInfo">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Mã giáo viên</label>
                                            <input type="text" class="form-control" v-model="profile.teacherId"
                                                readonly />
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Chức vụ</label>
                                            <input type="text" class="form-control" v-model="profile.position" />
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Trình độ học vấn</label>
                                            <select class="form-select" v-model="profile.education">
                                                <option>Trung cấp</option>
                                                <option>Cao đẳng</option>
                                                <option>Đại học</option>
                                                <option>Thạc sĩ</option>
                                                <option>Tiến sĩ</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Chuyên ngành</label>
                                            <input type="text" class="form-control" v-model="profile.major" />
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Ngày bắt đầu làm việc</label>
                                            <input type="date" class="form-control" v-model="profile.startDate" />
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Lớp đang phụ trách</label>
                                            <input type="text" class="form-control" v-model="profile.currentClass"
                                                readonly />
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Chứng chỉ & Bằng cấp</label>
                                            <textarea class="form-control" rows="3" v-model="profile.certificates"
                                                placeholder="Liệt kê các chứng chỉ, bằng cấp..."></textarea>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Kỹ năng đặc biệt</label>
                                            <textarea class="form-control" rows="2" v-model="profile.skills"
                                                placeholder="VD: Tiếng Anh, Piano, Múa..."></textarea>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bx bx-save me-2"></i>Lưu thay đổi
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Change Password Tab -->
                            <div v-show="activeTab === 'password'">
                                <form @submit.prevent="changePassword">
                                    <div class="row">
                                        <div class="col-12 mb-4">
                                            <div class="alert alert-info">
                                                <i class="bx bx-info-circle me-2"></i>
                                                Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ hoa, chữ thường và số.
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Mật khẩu hiện tại <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input :type="showCurrentPassword ? 'text' : 'password'"
                                                    class="form-control" v-model="passwordForm.currentPassword"
                                                    required />
                                                <button class="btn btn-outline-secondary" type="button"
                                                    @click="showCurrentPassword = !showCurrentPassword">
                                                    <i class="bx"
                                                        :class="showCurrentPassword ? 'bx-hide' : 'bx-show'"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Mật khẩu mới <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input :type="showNewPassword ? 'text' : 'password'"
                                                    class="form-control" v-model="passwordForm.newPassword" required />
                                                <button class="btn btn-outline-secondary" type="button"
                                                    @click="showNewPassword = !showNewPassword">
                                                    <i class="bx" :class="showNewPassword ? 'bx-hide' : 'bx-show'"></i>
                                                </button>
                                            </div>
                                            <div class="password-strength mt-2">
                                                <div class="progress" style="height: 5px;">
                                                    <div class="progress-bar" :class="passwordStrengthClass"
                                                        :style="{ width: passwordStrength + '%' }"></div>
                                                </div>
                                                <small class="text-muted">{{ passwordStrengthText }}</small>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Xác nhận mật khẩu mới <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input :type="showConfirmPassword ? 'text' : 'password'"
                                                    class="form-control" v-model="passwordForm.confirmPassword"
                                                    required />
                                                <button class="btn btn-outline-secondary" type="button"
                                                    @click="showConfirmPassword = !showConfirmPassword">
                                                    <i class="bx"
                                                        :class="showConfirmPassword ? 'bx-hide' : 'bx-show'"></i>
                                                </button>
                                            </div>
                                            <small
                                                v-if="passwordForm.confirmPassword && passwordForm.newPassword !== passwordForm.confirmPassword"
                                                class="text-danger">
                                                Mật khẩu xác nhận không khớp
                                            </small>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary"
                                                :disabled="passwordForm.newPassword !== passwordForm.confirmPassword">
                                                <i class="bx bx-key me-2"></i>Đổi mật khẩu
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, computed } from 'vue';

export default {
    name: 'TeacherProfile',
    setup() {
        const activeTab = ref('info');

        const profile = ref({
            avatar: '/src/assets/images/avatars/avatar-1.png',
            fullName: 'Nguyễn Thị Mai',
            role: 'Giáo viên chủ nhiệm',
            classCount: 1,
            studentCount: 30,
            yearsOfExperience: 5,
            email: 'nguyenthimai@example.com',
            phone: '0901234567',
            address: '123 Đường ABC, Quận 1, TP.HCM',
            dateOfBirth: '1990-05-15',
            gender: 'Nữ',
            idCard: '123456789012',
            teacherId: 'GV001',
            position: 'Giáo viên chủ nhiệm',
            education: 'Đại học',
            major: 'Sư phạm Mầm non',
            startDate: '2018-09-01',
            currentClass: 'Lớp Mầm 1A',
            certificates: 'Bằng Cử nhân Sư phạm Mầm non\nChứng chỉ Giáo viên dạy Tiếng Anh cho trẻ em',
            skills: 'Piano, Múa, Vẽ tranh'
        });

        const passwordForm = ref({
            currentPassword: '',
            newPassword: '',
            confirmPassword: ''
        });

        const showCurrentPassword = ref(false);
        const showNewPassword = ref(false);
        const showConfirmPassword = ref(false);

        const passwordStrength = computed(() => {
            const password = passwordForm.value.newPassword;
            if (!password) return 0;

            let strength = 0;
            if (password.length >= 8) strength += 25;
            if (password.length >= 12) strength += 25;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength += 25;
            if (/\d/.test(password)) strength += 25;

            return strength;
        });

        const passwordStrengthClass = computed(() => {
            const strength = passwordStrength.value;
            if (strength < 50) return 'bg-danger';
            if (strength < 75) return 'bg-warning';
            return 'bg-success';
        });

        const passwordStrengthText = computed(() => {
            const strength = passwordStrength.value;
            if (strength === 0) return '';
            if (strength < 50) return 'Yếu';
            if (strength < 75) return 'Trung bình';
            return 'Mạnh';
        });

        const changeAvatar = () => {
            alert('Chức năng thay đổi ảnh đại diện');
        };

        const updateProfile = () => {
            alert('Cập nhật thông tin cá nhân thành công!');
        };

        const updateWorkInfo = () => {
            alert('Cập nhật thông tin công việc thành công!');
        };

        const changePassword = () => {
            if (passwordForm.value.newPassword !== passwordForm.value.confirmPassword) {
                alert('Mật khẩu xác nhận không khớp!');
                return;
            }
            alert('Đổi mật khẩu thành công!');
            passwordForm.value = {
                currentPassword: '',
                newPassword: '',
                confirmPassword: ''
            };
        };

        return {
            activeTab,
            profile,
            passwordForm,
            showCurrentPassword,
            showNewPassword,
            showConfirmPassword,
            passwordStrength,
            passwordStrengthClass,
            passwordStrengthText,
            changeAvatar,
            updateProfile,
            updateWorkInfo,
            changePassword
        };
    }
};
</script>

<style scoped>
.profile-page {
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

.profile-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.profile-avatar-wrapper {
    position: relative;
    display: inline-block;
}

.profile-avatar {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 5px solid #fff;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.btn-change-avatar {
    position: absolute;
    bottom: 5px;
    right: 5px;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #667eea;
    color: white;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    transition: all 0.3s ease;
}

.btn-change-avatar:hover {
    background: #5568d3;
    transform: scale(1.1);
}

.profile-name {
    font-weight: 700;
    color: #2c3e50;
}

.profile-role {
    font-size: 0.95rem;
}

.profile-stats {
    display: flex;
    justify-content: space-around;
    padding: 20px 0;
    border-top: 1px solid #e9ecef;
    border-bottom: 1px solid #e9ecef;
    margin: 20px 0;
}

.stat-item {
    text-align: center;
}

.stat-item h5 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #667eea;
    margin: 0;
}

.stat-item p {
    font-size: 0.85rem;
    color: #6c757d;
    margin: 5px 0 0 0;
}

.quick-info-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid #f8f9fa;
}

.quick-info-item:last-child {
    border-bottom: none;
}

.quick-info-item i {
    font-size: 1.5rem;
    color: #667eea;
    margin-top: 5px;
}

.quick-info-item small {
    display: block;
    font-size: 0.75rem;
}

.quick-info-item p {
    margin: 0;
    font-size: 0.9rem;
    color: #2c3e50;
}

.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.nav-tabs {
    border-bottom: 2px solid #e9ecef;
}

.nav-tabs .nav-link {
    border: none;
    color: #6c757d;
    font-weight: 500;
    padding: 12px 20px;
    cursor: pointer;
    background: transparent;
    transition: all 0.3s ease;
}

.nav-tabs .nav-link:hover {
    color: #667eea;
    background: #f8f9fa;
    border-radius: 8px 8px 0 0;
}

.nav-tabs .nav-link.active {
    color: #667eea;
    border-bottom: 3px solid #667eea;
    font-weight: 600;
}

.form-label {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.form-control,
.form-select {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 10px 15px;
    transition: all 0.3s ease;
}

.form-control:focus,
.form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.password-strength {
    margin-top: 8px;
}

.password-strength small {
    display: block;
    margin-top: 5px;
    font-weight: 500;
}

.btn-primary {
    background: #667eea;
    border: none;
    padding: 10px 25px;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: #5568d3;
    transform: translateY(-2px);
}

.btn-outline-secondary {
    border: 2px solid #6c757d;
    color: #6c757d;
    padding: 10px 25px;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-outline-secondary:hover {
    background: #6c757d;
    color: white;
}

@media (max-width: 768px) {
    .profile-page {
        padding: 10px;
    }

    .page-title {
        font-size: 1.5rem;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
    }

    .profile-stats {
        flex-direction: column;
        gap: 15px;
    }
}
</style>
