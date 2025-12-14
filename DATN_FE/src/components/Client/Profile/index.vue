<template>
  <div class="profile-container">
    <div class="profile-wrapper">
      <!-- Profile Header -->
      <div class="profile-header">
        <div class="avatar-section">
          <div class="avatar-container" @click="triggerFileInput">
            <img :src="profile.avatar || `https://ui-avatars.com/api/?name=${profile.ho_va_ten}&background=random`"
              alt="User Avatar">
            <div class="edit-avatar">
              <i class="fas fa-camera"></i>
            </div>
            <input type="file" ref="fileInput" class="d-none" accept="image/*" @change="handleAvatarChange">
          </div>
          <div class="user-info">
            <h3 class="user-name">{{ profile.ho_va_ten || 'Chưa cập nhật' }}</h3>
            <span class="user-role">Phụ Huynh</span>
            <div class="user-meta">
              <span><i class="fas fa-envelope"></i> {{ profile.email }}</span>
              <span><i class="fas fa-phone"></i> {{ profile.so_dien_thoai }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Tabs Navigation -->
      <div class="tabs-navigation">
        <div class="tab-item" :class="{ active: activeTab === 'personal' }" @click="activeTab = 'personal'">
          <i class="fas fa-user"></i>
          <span>Thông tin cá nhân</span>
        </div>
        <div class="tab-item" :class="{ active: activeTab === 'children' }" @click="activeTab = 'children'">
          <i class="fas fa-child"></i>
          <span>Thông tin con cái</span>
        </div>
        <div class="tab-item" :class="{ active: activeTab === 'password' }" @click="activeTab = 'password'">
          <i class="fas fa-lock"></i>
          <span>Đổi mật khẩu</span>
        </div>
      </div>

      <!-- Content -->
      <div class="profile-content">
        <!-- Personal Info Tab -->
        <div v-if="activeTab === 'personal'" class="tab-pane fade-in">
          <div class="section-header">
            <h2>Thông tin cá nhân</h2>
            <button class="btn-save" :disabled="loading" @click="updateProfile">
              <i class="fas fa-save"></i>
              Lưu thay đổi
            </button>
          </div>

          <div class="form-grid">
            <div class="form-group">
              <label>Họ và tên</label>
              <div class="input-wrapper">
                <i class="fas fa-user"></i>
                <input type="text" v-model="profile.ho_va_ten" placeholder="Nhập họ và tên">
              </div>
            </div>
            <div class="form-group">
              <label>Số điện thoại</label>
              <div class="input-wrapper">
                <i class="fas fa-phone"></i>
                <input type="text" v-model="profile.so_dien_thoai" placeholder="Nhập số điện thoại">
              </div>
            </div>
            <div class="form-group">
              <label>Email</label>
              <div class="input-wrapper">
                <i class="fas fa-envelope"></i>
                <input type="email" v-model="profile.email">
              </div>
            </div>
            <div class="form-group">
              <label>Ngày sinh</label>
              <div class="input-wrapper">
                <i class="fas fa-calendar"></i>
                <input type="date" v-model="profile.ngay_sinh">
              </div>
            </div>
            <div class="form-group full-width">
              <label>Địa chỉ</label>
              <div class="input-wrapper">
                <i class="fas fa-map-marker-alt"></i>
                <input type="text" v-model="profile.dia_chi" placeholder="Nhập địa chỉ liên hệ">
              </div>
            </div>
          </div>
        </div>

        <!-- Children Tab -->
        <div v-if="activeTab === 'children'" class="tab-pane fade-in">
          <div class="section-header">
            <h2>Thông tin con cái</h2>
          </div>
          <div class="children-grid">
            <div v-for="(child, index) in children" :key="child.id || index" class="child-card">
              <div class="card-bg"></div>
              <div class="child-avatar">
                <img :src="child.avatar || `https://ui-avatars.com/api/?name=${child.ho_va_ten}&background=random`"
                  alt="Child Avatar">
              </div>
              <div class="child-info">
                <h3>{{ child.ho_va_ten }}</h3>
                <span class="class-badge">
                  <i class="fas fa-graduation-cap"></i>
                  {{ child.lop_hoc }}
                </span>
                <div class="detail-row">
                  <i class="fas fa-birthday-cake"></i>
                  <span>{{ formatDate(child.ngay_sinh) }}</span>
                </div>
                <div class="detail-row">
                  <i class="fas fa-venus-mars"></i>
                  <span>{{ child.gioi_tinh }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Password Tab -->
        <div v-if="activeTab === 'password'" class="tab-pane fade-in">
          <div class="password-change-wrapper">
            <div class="password-form-section">
              <div class="section-header">
                <h2>Đổi mật khẩu</h2>
              </div>

              <div class="password-form">
                <div class="form-group">
                  <label>Mật khẩu hiện tại</label>
                  <div class="input-wrapper">
                    <i class="fas fa-lock"></i>
                    <input type="password" v-model="passwordData.current" placeholder="Nhập mật khẩu hiện tại">
                  </div>
                </div>
                <div class="form-group">
                  <label>Mật khẩu mới</label>
                  <div class="input-wrapper">
                    <i class="fas fa-key"></i>
                    <input type="password" v-model="passwordData.new" placeholder="Nhập mật khẩu mới">
                  </div>
                </div>
                <div class="form-group">
                  <label>Xác nhận mật khẩu mới</label>
                  <div class="input-wrapper">
                    <i class="fas fa-check-circle"></i>
                    <input type="password" v-model="passwordData.confirm" placeholder="Nhập lại mật khẩu mới">
                  </div>
                </div>
                <button class="btn-save" :disabled="loading" @click="updatePassword">
                  <i class="fas fa-key"></i>
                  Cập nhật mật khẩu
                </button>
              </div>
            </div>

            <div class="password-image-section">
              <div class="security-image">
                <img src="https://images.unsplash.com/photo-1633265486064-086b219458ec?w=600&h=600&fit=crop"
                  alt="Security Authentication">
                <div class="security-overlay">
                  <div class="security-icon"><i class="fas fa-shield-alt"></i></div>
                  <h3>Bảo mật tài khoản</h3>
                  <p>Đảm bảo mật khẩu của bạn an toàn và khó đoán</p>
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
import baseRequestClient from '../../../core/baseRequestClient';

export default {
  data() {
    return {
      activeTab: 'personal',
      loading: false,
      profile: {
        ho_va_ten: '',
        email: '',
        so_dien_thoai: '',
        ngay_sinh: '',
        dia_chi: '',
        avatar: ''
      },
      children: [],
      passwordData: {
        current: '',
        new: '',
        confirm: ''
      }
    };
  },
  mounted() {
    this.loadData();
  },
  methods: {
    async loadData() {
      try {
        const res = await baseRequestClient.get('phu-huynh/profile/data');
        if (res.data.status) {
          this.profile = res.data.data.profile || {};
          this.children = res.data.data.children || [];
          this.$toast.success(res.data.message);
        } else {
          this.$toast.error(res.data.message);
        }
      } catch (err) {
        const listErr = err.response?.data?.errors;
        if (listErr) Object.values(listErr).forEach(e => this.$toast.error(e[0]));
        else this.$toast.error('Có lỗi xảy ra khi tải dữ liệu');
      }
    },

    // Lưu thông tin cá nhân
    async updateProfile() {
      this.loading = true;
      try {
        const res = await baseRequestClient.post('phu-huynh/profile/update', this.profile);
        if (res.data.status) {
          this.$toast.success(res.data.message);
        } else {
          this.$toast.error(res.data.message);
        }
      } catch (err) {
        this.$toast.error('Cập nhật thông tin thất bại');
      } finally {
        this.loading = false;
      }
    },

    // Đổi mật khẩu
    async updatePassword() {
      if (!this.passwordData.current) {
        this.$toast.error('Vui lòng nhập mật khẩu hiện tại');
        return;
      }
      if (!this.passwordData.new) {
        this.$toast.error('Vui lòng nhập mật khẩu mới');
        return;
      }
      if (this.passwordData.new !== this.passwordData.confirm) {
        this.$toast.error('Mật khẩu mới không trùng khớp');
        return;
      }
      this.loading = true;
      try {
        const res = await baseRequestClient.post('phu-huynh/profile/changePassword', this.passwordData);
        if (res.data.status) {
          this.$toast.success(res.data.message);
          this.passwordData.current = '';
          this.passwordData.new = '';
          this.passwordData.confirm = '';
        } else {
          this.$toast.error(res.data.message);
        }
      } catch (err) {
        this.$toast.error('Cập nhật mật khẩu thất bại');
      } finally {
        this.loading = false;
      }
    },

    // Upload avatar
    triggerFileInput() {
      this.$refs.fileInput.click();
    },
    async handleAvatarChange(e) {
      const file = e.target.files[0];
      if (!file) return;
      const formData = new FormData();
      formData.append('hinh_anh', file);
      this.loading = true;
      try {
        const res = await baseRequestClient.post('phu-huynh/profile/update-avatar', formData);
        console.log('Avatar upload response:', res.data);
        if (res.data.status) {
          this.profile.avatar = res.data.data.avatar;
          this.$toast.success('Cập nhật avatar thành công');
          // Reload để update avatar trong navbar
          localStorage.setItem('avatar_phu_huynh', res.data.data.avatar);
        } else {
          this.$toast.error(res.data.message);
        }
      } catch (err) {
        console.error('Avatar upload error:', err.response?.data || err);
        const errorMsg = err.response?.data?.message || 'Cập nhật avatar thất bại';
        this.$toast.error(errorMsg);
      } finally {
        this.loading = false;
      }
    },

    formatDate(dateString) {
      if (!dateString) return '';
      const date = new Date(dateString);
      return date.toLocaleDateString('vi-VN');
    }
  }
};
</script>

<style lang="scss">
@use "./style.scss";

.fade-in {
  animation: fadeIn 0.5s ease-in-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
