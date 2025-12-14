<template>
    <div class="topbar">
        <nav class="navbar navbar-expand align-items-center px-3">
            <!-- Logo & School Name -->
            <div class="d-flex align-items-center">
                <div class="logo-icon-wrapper me-2">
                    <img src="../../../../assets/images/Home/logohoa.png" alt="Logo" class="logo-icon" />
                </div>
                <div class="school-info">
                    <h4 class="school-name mb-0">Hoa Sen - Giáo Viên</h4>
                    <p class="school-motto mb-0 small">Hệ thống quản lý lớp học</p>
                </div>
            </div>

            <!-- Mobile Toggle -->
            <div class="mobile-toggle-menu" @click="handleToggleSidebar">
                <i class="bx" :class="isSidebarOpen ? 'bx-x' : 'bx-menu'"></i>
            </div>

            <!-- Search Bar -->
            <div class="search-bar flex-grow-1 px-3">
                <div class="search-input-wrapper position-relative">
                    <input type="text" class="form-control search-control"
                        placeholder="Tìm kiếm học sinh, bài tập..." />
                    <span class="search-icon position-absolute top-50 end-0 translate-middle-y me-2">
                        <i class="bx bx-search"></i>
                    </span>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="top-menu d-flex align-items-center me-3">
                <div class="nav-item">
                    <a class="nav-link position-relative" href="#" title="Thông báo">
                        <i class="bx bx-bell"></i>
                        <span class="notification-badge">3</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link position-relative" href="#" title="Tin nhắn">
                        <i class="bx bx-message-dots"></i>
                        <span class="message-badge">5</span>
                    </a>
                </div>
            </div>

            <!-- User Profile -->
            <div class="user-box dropdown ms-auto">
                <a class="user-profile-link" href="#" role="button" data-bs-toggle="dropdown">
                    <div class="user-avatar">
                        <img :src="userInfo.avatar || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(userInfo.ho_va_ten || 'Teacher') + '&background=random'"
                            alt="user avatar" />
                        <span class="status-indicator online"></span>
                    </div>
                    <div class="user-info">
                        <p class="user-name">{{ userInfo.ho_va_ten || 'Giáo viên' }}</p>
                        <p class="user-role">{{ userInfo.chuc_vu || 'Giáo viên' }}</p>
                    </div>
                    <i class="bx bx-chevron-down dropdown-arrow"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end user-dropdown">
                    <li class="dropdown-header">
                        <h6>Tài khoản giáo viên</h6>
                    </li>
                    <li>
                        <router-link to="/teacher/profile" class="dropdown-item">
                            <i class="bx bx-user"></i>
                            <span>Hồ sơ cá nhân</span>
                        </router-link>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="bx bx-cog"></i>
                            <span>Cài đặt</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="bx bx-help-circle"></i>
                            <span>Trợ giúp</span>
                        </a>
                    </li>
                    <li class="dropdown-divider"></li>
                    <li>
                        <a v-on:click="logout()" class="dropdown-item text-danger" href="#">
                            <i class="bx bx-log-out"></i>
                            <span>Đăng xuất</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</template>

<script setup>
import baseRequestTeacher from '../../../../core/baseRequestTeacher';
import { useRouter } from 'vue-router';
import { ref, onMounted } from 'vue';

const props = defineProps({
    isSidebarOpen: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['toggleSidebar']);
const router = useRouter();
const userInfo = ref({
    ho_va_ten: '',
    avatar: '',
    chuc_vu: '',
    email: ''
});

// Load user info on mount
onMounted(async () => {
    try {
        const res = await baseRequestTeacher.get('teacher/user-info');
        if (res.data.status) {
            userInfo.value = {
                ho_va_ten: res.data.data.ho_va_ten,
                avatar: res.data.data.avatar,
                chuc_vu: res.data.data.chuc_vu || 'Giáo viên',
                email: res.data.data.email
            };
        }
    } catch (err) {
        console.error('Failed to load teacher info:', err);
    }
});

function handleToggleSidebar() {
    emit('toggleSidebar');
}

function logout() {
    baseRequestTeacher
        .get('teacher/logout')
        .then((res) => {
            if (res.data.status) {
                // Xóa token và thông tin đăng nhập
                localStorage.removeItem('token_giao_vien');
                localStorage.removeItem('ho_ten_giao_vien');

                // Redirect về trang login
                router.push('/teacher/login');
            }
        })
        .catch((err) => {
            console.error('Logout error:', err);
            // Vẫn xóa token và redirect về login nếu có lỗi
            localStorage.removeItem('token_giao_vien');
            localStorage.removeItem('ho_ten_giao_vien');
            router.push('/teacher/login');
        });
}
</script>

<style scoped>
.topbar {
    border-bottom: 1px solid #e9ecef;
    padding: 10px 0;
    height: auto;
    position: relative;
    z-index: 1000;
    background: white;
}

.navbar {
    padding: 0.75rem 1.5rem;
}

.logo-icon-wrapper {
    width: 100px;
    height: 100px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.logo-icon {
    width: 100%;
    height: 100%;
}

.school-info {
    display: flex;
    flex-direction: column;
}

.school-name {
    font-size: 1.55rem;
    font-weight: 700;
    font-family: Cambria, Cochin, Georgia, Times, "Times New Roman", serif;
    background: linear-gradient(90deg, #667eea, #764ba2);
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin: 0;
    line-height: 1.2;
}

.school-motto {
    font-size: 0.8rem;
    color: #6c757d;
    margin: 0;
    font-style: italic;
}

.mobile-toggle-menu {
    display: none;
    font-size: 24px;
    color: #6c757d;
    cursor: pointer;
    padding: 8px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.mobile-toggle-menu:hover {
    background: #f8f9fa;
    color: #667eea;
}

.search-bar {
    max-width: auto;
    min-width: none;
    margin: 0 2rem;
}

.search-input-wrapper {
    position: relative;
}

.search-control {
    border: 2px solid #e9ecef;
    border-radius: 25px;
    padding: 12px 45px 12px 20px;
    font-size: 0.9rem;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.search-control:focus {
    border-color: #667eea;
    background: white;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.search-icon {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    font-size: 18px;
}

.top-menu {
    display: flex;
    align-items: center;
}

.nav-item {
    margin: 0 5px;
}

.nav-link {
    color: #6c757d;
    padding: 10px;
    border-radius: 10px;
    transition: all 0.3s ease;
    position: relative;
}

.nav-link:hover {
    color: #667eea;
    background: #f8f9fa;
}

.nav-link i {
    font-size: 20px;
}

.notification-badge,
.message-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #dc3545;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    font-size: 0.7rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}

.dropdown-menu {
    border: none;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    padding: 0;
    min-width: 200px;
}

.dropdown-header {
    padding: 20px 20px 15px;
    border-bottom: 1px solid #e9ecef;
}

.dropdown-header h6 {
    margin: 0;
    font-weight: 600;
    color: #2c3e50;
}

.user-box {
    margin-left: 20px;
}

.user-profile-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 8px 15px;
    border-radius: 25px;
    text-decoration: none;
    color: #2c3e50;
    transition: all 0.3s ease;
}

.user-profile-link:hover {
    background: #f8f9fa;
    text-decoration: none;
    color: #2c3e50;
}

.user-avatar {
    position: relative;
}

.user-avatar img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.status-indicator {
    position: absolute;
    bottom: 2px;
    right: 2px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid white;
}

.status-indicator.online {
    background: #28a745;
}

.user-info {
    display: flex;
    flex-direction: column;
}

.user-name {
    font-size: 0.9rem;
    font-weight: 600;
    margin: 0;
    color: #2c3e50;
}

.user-role {
    font-size: 0.75rem;
    color: #6c757d;
    margin: 0;
}

.dropdown-arrow {
    font-size: 16px;
    color: #6c757d;
    transition: transform 0.3s ease;
}

.user-profile-link[aria-expanded="true"] .dropdown-arrow {
    transform: rotate(180deg);
}

.user-dropdown .dropdown-item {
    padding: 12px 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    transition: all 0.3s ease;
}

.user-dropdown .dropdown-item:hover {
    background: #f8f9fa;
    color: #667eea;
}

.user-dropdown .dropdown-item i {
    font-size: 18px;
    width: 20px;
}

@media (max-width: 992px) {
    .mobile-toggle-menu {
        display: block;
        order: 1;
    }

    .search-bar {
        display: none;
    }

    .d-flex.align-items-center {
        order: 2;
        flex: 1;
        justify-content: center;
        margin: 0 20px;
    }

    .top-menu {
        order: 3;
    }

    .user-box {
        order: 4;
        margin-left: 0;
    }

    .school-name {
        font-size: 1.1rem;
    }

    .school-motto {
        display: none;
    }

    .navbar {
        justify-content: space-between;
    }
}

@media (max-width: 768px) {
    .navbar {
        padding: 0.5rem 1rem;
    }

    .logo-icon-wrapper {
        width: 40px;
        height: 40px;
    }

    .school-name {
        font-size: 1rem;
    }

    .user-info {
        display: none;
    }

    .top-menu {
        margin-right: 10px;
    }
}
</style>
