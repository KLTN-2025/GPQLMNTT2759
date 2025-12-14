<template>
  <div class="topbar">
    <nav class="navbar navbar-expand align-items-center px-3">
      <!-- Logo & School Name -->
      <div class="d-flex align-items-center">
        <div class="logo-icon-wrapper me-2">
          <img src="../../../../assets/images/Home/logohoa.png" alt="Logo" class="logo-icon" />
        </div>
        <div class="school-info">
          <h4 class="school-name mb-0">Hoa Sen</h4>
          <p class="school-motto mb-0 small">Nơi ươm mầm tương lai</p>
        </div>
      </div>

      <!-- Mobile Toggle (chỉ hiện khi mobile) -->
      <div class="mobile-toggle-menu" @click="handleToggleSidebar">
        <i class="bx" :class="isSidebarOpen ? 'bx-x' : 'bx-menu'"></i>
      </div>

      <!-- Search Bar -->
      <div class="search-bar flex-grow-1 px-3">
        <div class="search-input-wrapper position-relative">
          <input type="text" class="form-control search-control" placeholder="Tìm kiếm học sinh, giáo viên..." />
          <span class="search-icon position-absolute top-50 end-0 translate-middle-y me-2">
            <i class="bx bx-search"></i>
          </span>
        </div>
      </div>

      <!-- User Profile -->
      <div class="user-box dropdown ms-auto">
        <a class="user-profile-link" href="#" role="button" data-bs-toggle="dropdown">
          <div class="user-avatar">
            <img
              :src="userInfo.avatar || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(userInfo.ho_va_ten || 'Admin') + '&background=random'"
              alt="user avatar" />
            <span class="status-indicator online"></span>
          </div>
          <div class="user-info">
            <p class="user-name">{{ userInfo.ho_va_ten || 'Admin' }}</p>
            <p class="user-role">{{ userInfo.chuc_vu || 'Quản trị viên' }}</p>
          </div>
          <i class="bx bx-chevron-down dropdown-arrow"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-end user-dropdown">
          <li class="dropdown-header">
            <h6>Hồ sơ người dùng</h6>
          </li>
          <li>
            <router-link to="/admin/profile" class="dropdown-item">
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

<script>
import baseRequestAdmin from '../../../../core/baseRequestAdmin';
import { useRouter } from 'vue-router';
import { ref, onMounted } from 'vue';

export default {
  props: {
    isSidebarOpen: {
      type: Boolean,
      default: false
    }
  },
  emits: ['toggleSidebar'],
  setup(props, { emit }) {
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
        const res = await baseRequestAdmin.get('admin/check-token');
        if (res.data.status) {
          userInfo.value = {
            ho_va_ten: res.data.ho_ten,
            avatar: res.data.avatar,
            chuc_vu: res.data.chuc_vu || 'Quản trị viên',
            email: res.data.email
          };
        }
      } catch (err) {
        console.error('Failed to load admin info:', err);
      }
    });

    function handleToggleSidebar() {
      emit('toggleSidebar');
    }

    function logout() {
      baseRequestAdmin
        .get('admin/logout')
        .then((res) => {
          if (res.data.status) {
            // Xóa token và thông tin đăng nhập
            localStorage.removeItem('token_admin');
            localStorage.removeItem('admin_info');

            // Redirect về trang login
            router.push('/admin/login');
          }
        })
        .catch((err) => {
          console.error('Logout error:', err);
          // Vẫn xóa token và redirect về login nếu có lỗi
          localStorage.removeItem('token_admin');
          localStorage.removeItem('admin_info');
          router.push('/admin/login');
        });
    }

    return {
      handleToggleSidebar,
      logout,
      userInfo
    };
  }
}
</script>

<style lang="scss" scoped>
@use "./style.scss";
</style>
