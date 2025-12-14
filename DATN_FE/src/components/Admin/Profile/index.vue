<template>
  <div class="profile-dashboard">
    <!-- Header Section -->
    <div class="profile-header">
      <div class="header-content">
        <div>
          <h1 class="page-title">
            <i class="bx bx-user me-2"></i>
            Hồ sơ cá nhân
          </h1>
          <p class="page-subtitle">Quản lý thông tin cá nhân và cài đặt tài khoản</p>
        </div>
        <div class="breadcrumb-nav">
          <span class="breadcrumb-item">Admin</span>
          <i class="bx bx-chevron-right"></i>
          <span class="breadcrumb-item active">Hồ sơ</span>
        </div>
      </div>
    </div>

    <div class="row">
      <!-- Left Sidebar -->
      <div class="col-xl-4">
        <!-- Profile Info Card -->
        <div class="profile-info-card">
          <div class="profile-avatar-section">
            <div class="avatar-container">
              <img :src="thong_tin.avatar || '/default-avatar.png'" alt="avatar" class="profile-avatar">
              <div class="avatar-status"></div>
            </div>
            <h3 class="profile-name">{{ thong_tin.ho_va_ten || 'Nguyễn Văn Admin' }}</h3>
            <p class="profile-title">{{ thong_tin.ten_chuc_vu || 'Quản trị viên' }}</p>
            <div class="profile-actions">
              <button @click="Object.assign(update_tt, thong_tin)" class="btn-edit">
                <i class="bx bx-edit"></i>
                Chỉnh sửa
              </button>
              <button class="btn-avatar">
                <i class="bx bx-camera"></i>
                Đổi ảnh
              </button>
            </div>
          </div>
        </div>

        <!-- Contact Info Card -->
        <div class="contact-info-card">
          <div class="contact-header">
            <h5 class="contact-title">
              <i class="bx bx-phone me-2"></i>
              Thông tin liên hệ
            </h5>
          </div>
          <div class="contact-body">
            <div class="contact-item">
              <div class="contact-icon email">
                <i class="bx bx-envelope"></i>
              </div>
              <div class="contact-info">
                <p class="contact-label">Email</p>
                <p class="contact-value">{{ thong_tin.email || 'admin@qlmn.edu.vn' }}</p>
              </div>
            </div>
            <div class="contact-item">
              <div class="contact-icon phone">
                <i class="bx bx-phone"></i>
              </div>
              <div class="contact-info">
                <p class="contact-label">Điện thoại</p>
                <p class="contact-value">{{ thong_tin.so_dien_thoai || '0901 234 567' }}</p>
              </div>
            </div>
            <div class="contact-item">
              <div class="contact-icon location">
                <i class="bx bx-map"></i>
              </div>
              <div class="contact-info">
                <p class="contact-label">Địa chỉ</p>
                <p class="contact-value">{{ thong_tin.dia_chi || '123 Đường ABC, Quận 1, TP.HCM' }}</p>
              </div>
            </div>
            <div class="contact-item">
              <div class="contact-icon calendar">
                <i class="bx bx-calendar"></i>
              </div>
              <div class="contact-info">
                <p class="contact-label">Ngày sinh</p>
                <p class="contact-value">{{ thong_tin.ngay_sinh || '15/03/1985' }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Skills Card -->
        <div class="skills-card">
          <div class="skills-header">
            <h5 class="skills-title">
              <i class="bx bx-trophy me-2"></i>
              Kỹ năng chuyên môn
            </h5>
          </div>
          <div class="skills-body">
            <div class="skill-item">
              <div class="skill-header">
                <span class="skill-name">Quản lý hệ thống</span>
                <span class="skill-percentage">95%</span>
              </div>
              <div class="skill-progress">
                <div class="skill-progress-bar primary" style="width: 95%"></div>
              </div>
            </div>
            <div class="skill-item">
              <div class="skill-header">
                <span class="skill-name">Quản lý nhân sự</span>
                <span class="skill-percentage">88%</span>
              </div>
              <div class="skill-progress">
                <div class="skill-progress-bar success" style="width: 88%"></div>
              </div>
            </div>
            <div class="skill-item">
              <div class="skill-header">
                <span class="skill-name">Báo cáo tài chính</span>
                <span class="skill-percentage">92%</span>
              </div>
              <div class="skill-progress">
                <div class="skill-progress-bar info" style="width: 92%"></div>
              </div>
            </div>
            <div class="skill-item">
              <div class="skill-header">
                <span class="skill-name">Phân tích dữ liệu</span>
                <span class="skill-percentage">85%</span>
              </div>
              <div class="skill-progress">
                <div class="skill-progress-bar warning" style="width: 85%"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <div class="col-xl-8">
        <!-- Personal Info Form -->
        <div class="personal-info-card">
          <div class="personal-info-header">
            <h5 class="personal-info-title">
              <i class="bx bx-user-detail me-2"></i>
              Thông tin cá nhân
            </h5>
          </div>
          <div class="personal-info-body">
            <form @submit.prevent="updateProfile">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="firstName" class="form-label">Họ và tên đệm <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="firstName" v-model="update_tt.ho_va_ten"
                      placeholder="Nhập họ và tên đệm" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="lastName" class="form-label">Tên</label>
                    <input type="text" class="form-control" id="lastName" v-model="update_tt.ten"
                      placeholder="Nhập tên">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" v-model="update_tt.email"
                      placeholder="Nhập email" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="phone" class="form-label">Điện thoại</label>
                    <input type="tel" class="form-control" id="phone" v-model="update_tt.so_dien_thoai"
                      placeholder="Nhập số điện thoại">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="birthDate" class="form-label">Ngày sinh</label>
                    <input type="date" class="form-control" id="birthDate" v-model="update_tt.ngay_sinh">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="gender" class="form-label">Giới tính</label>
                    <select class="form-select" id="gender" v-model="update_tt.gioi_tinh">
                      <option value="Nam">Nam</option>
                      <option value="Nữ">Nữ</option>
                      <option value="Khác">Khác</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="address" class="form-label">Địa chỉ</label>
                <textarea class="form-control" id="address" rows="3" v-model="update_tt.dia_chi"
                  placeholder="Nhập địa chỉ"></textarea>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="department" class="form-label">Phòng ban</label>
                    <input type="text" class="form-control" id="department" v-model="update_tt.phong_ban"
                      placeholder="Nhập phòng ban">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="position" class="form-label">Chức vụ</label>
                    <input type="text" class="form-control" id="position" v-model="update_tt.ten_chuc_vu"
                      placeholder="Nhập chức vụ">
                  </div>
                </div>
              </div>
              <div class="form-actions">
                <button type="button" class="btn-cancel" @click="resetForm">Hủy</button>
                <button type="submit" class="btn-save">
                  <i class="bx bx-save me-1"></i>
                  Lưu thay đổi
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- Change Password -->
        <div class="password-card">
          <div class="password-header">
            <h5 class="password-title">
              <i class="bx bx-lock me-2"></i>
              Đổi mật khẩu
            </h5>
          </div>
          <div class="password-body">
            <form @submit.prevent="changePassword">
              <div class="form-group">
                <label for="currentPassword" class="form-label">Mật khẩu hiện tại</label>
                <input type="password" class="form-control" id="currentPassword" v-model="passwordForm.currentPassword"
                  placeholder="Nhập mật khẩu hiện tại">
              </div>
              <div class="form-group">
                <label for="newPassword" class="form-label">Mật khẩu mới</label>
                <input type="password" class="form-control" id="newPassword" v-model="passwordForm.newPassword"
                  placeholder="Nhập mật khẩu mới">
              </div>
              <div class="form-group">
                <label for="confirmPassword" class="form-label">Xác nhận mật khẩu mới</label>
                <input type="password" class="form-control" id="confirmPassword" v-model="passwordForm.confirmPassword"
                  placeholder="Xác nhận mật khẩu mới">
              </div>
              <div class="text-end">
                <button type="submit" class="btn-change-password">
                  <i class="bx bx-key me-1"></i>
                  Đổi mật khẩu
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- Activity Log -->
        <div class="activity-card">
          <div class="activity-header">
            <h5 class="activity-title">
              <i class="bx bx-time-five me-2"></i>
              Hoạt động gần đây
            </h5>
          </div>
          <div class="activity-body">
            <div class="timeline">
              <div class="timeline-item">
                <div class="timeline-icon success">
                  <i class="bx bx-log-in"></i>
                </div>
                <div class="timeline-content">
                  <h6 class="timeline-title">Đăng nhập hệ thống</h6>
                  <p class="timeline-time">2 phút trước</p>
                  <p class="timeline-description">Đăng nhập thành công từ IP: 192.168.1.100</p>
                </div>
              </div>
              <div class="timeline-item">
                <div class="timeline-icon primary">
                  <i class="bx bx-edit"></i>
                </div>
                <div class="timeline-content">
                  <h6 class="timeline-title">Cập nhật thông tin học sinh</h6>
                  <p class="timeline-time">1 giờ trước</p>
                  <p class="timeline-description">Cập nhật thông tin lớp học cho 15 học sinh</p>
                </div>
              </div>
              <div class="timeline-item">
                <div class="timeline-icon info">
                  <i class="bx bx-file"></i>
                </div>
                <div class="timeline-content">
                  <h6 class="timeline-title">Xuất báo cáo tài chính</h6>
                  <p class="timeline-time">3 giờ trước</p>
                  <p class="timeline-description">Xuất báo cáo thu chi tháng 12/2024</p>
                </div>
              </div>
              <div class="timeline-item">
                <div class="timeline-icon warning">
                  <i class="bx bx-user-plus"></i>
                </div>
                <div class="timeline-content">
                  <h6 class="timeline-title">Thêm giáo viên mới</h6>
                  <p class="timeline-time">1 ngày trước</p>
                  <p class="timeline-description">Thêm giáo viên Nguyễn Thị B vào hệ thống</p>
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
import baseRequestAdmin from '../../../core/baseRequestAdmin';

export default {
  name: 'Profile',
  data() {
    return {
      thong_tin: {},
      update_tt: {},
      is_update: false,
      passwordForm: {
        currentPassword: '',
        newPassword: '',
        confirmPassword: ''
      }
    }
  },
  mounted() {
    this.loadData();
  },
  methods: {
    loadData() {
      baseRequestAdmin
        .get("admin/profile/data")
        .then((res) => {
          if (res.data.status) {
            this.thong_tin = res.data.data;
            // Không hiển thị toast khi load data thành công
          } else {
            this.$toast.error(res.data.message);
          }
        })
        .catch((err) => {
          if (err.response && err.response.data && err.response.data.errors) {
            const listErr = err.response.data.errors;
            Object.values(listErr).forEach((error) => {
              this.$toast.error(error[0]);
            });
          } else {
            this.$toast.error('Có lỗi xảy ra khi tải dữ liệu');
          }
        });
    },

    updateProfile() {
      if (!this.update_tt.ho_va_ten || !this.update_tt.email) {
        this.$toast.error('Vui lòng điền đầy đủ thông tin bắt buộc');
        return;
      }

      baseRequestAdmin
        .put("admin/profile/update", this.update_tt)
        .then((res) => {
          if (res.data.status) {
            this.thong_tin = { ...this.thong_tin, ...this.update_tt };
            this.$toast.success('Cập nhật thông tin thành công');
          } else {
            this.$toast.error(res.data.message);
          }
        })
        .catch((err) => {
          if (err.response && err.response.data && err.response.data.errors) {
            const listErr = err.response.data.errors;
            Object.values(listErr).forEach((error) => {
              this.$toast.error(error[0]);
            });
          } else {
            this.$toast.error('Có lỗi xảy ra khi cập nhật thông tin');
          }
        });
    },

    changePassword() {
      if (!this.passwordForm.currentPassword || !this.passwordForm.newPassword || !this.passwordForm.confirmPassword) {
        this.$toast.error('Vui lòng điền đầy đủ thông tin');
        return;
      }

      if (this.passwordForm.newPassword !== this.passwordForm.confirmPassword) {
        this.$toast.error('Mật khẩu mới và xác nhận mật khẩu không khớp');
        return;
      }

      if (this.passwordForm.newPassword.length < 6) {
        this.$toast.error('Mật khẩu mới phải có ít nhất 6 ký tự');
        return;
      }

      baseRequestAdmin
        .put("admin/profile/change-password", this.passwordForm)
        .then((res) => {
          if (res.data.status) {
            this.$toast.success('Đổi mật khẩu thành công');
            this.passwordForm = {
              currentPassword: '',
              newPassword: '',
              confirmPassword: ''
            };
          } else {
            this.$toast.error(res.data.message);
          }
        })
        .catch((err) => {
          if (err.response && err.response.data && err.response.data.errors) {
            const listErr = err.response.data.errors;
            Object.values(listErr).forEach((error) => {
              this.$toast.error(error[0]);
            });
          } else {
            this.$toast.error('Có lỗi xảy ra khi đổi mật khẩu');
          }
        });
    },

    resetForm() {
      this.update_tt = {};
      this.$toast.info('Đã hủy thay đổi');
    }
  }
}
</script>

<style scoped>
@import "./style.scss";
</style>