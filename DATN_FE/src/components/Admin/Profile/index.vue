<template>
  <div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
      <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
          <h4 class="mb-0">Hồ sơ cá nhân</h4>
          <div class="page-title-right">
            <ol class="breadcrumb m-0">
              <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
              <li class="breadcrumb-item active">Hồ sơ</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <!-- Profile Info -->
      <div class="col-xl-4">
        <div class="card">
          <div class="card-body text-center">
            <div class="position-relative d-inline-block">
              <img :src="thong_tin.avatar" alt="avatar"
                class="rounded-circle avatar-lg img-thumbnail">
              <div class="avatar-online">
                <span class="avatar-status-online"></span>
              </div>
            </div>
            <h5 class="mt-3 mb-1">{{ thong_tin.ho_va_ten }}</h5>
            <p class="text-muted">{{ thong_tin.ten_chuc_vu }}</p>
            <div class="mt-3">
              <button v-on:click="Object.assign(update_tt, thong_tin)" type="button" class="btn btn-primary me-2">
                <i class="bx bx-edit me-1"></i>Chỉnh sửa
              </button>
              <button type="button" class="btn btn-outline-secondary">
                <i class="bx bx-camera me-1"></i>Đổi ảnh
              </button>
            </div>
          </div>
        </div>

        <!-- Contact Info -->
        <div class="card">
          <div class="card-header">
            <h5 class="card-title mb-0">Thông tin liên hệ</h5>
          </div>
          <div class="card-body">
            <div class="d-flex align-items-center mb-3">
              <div class="flex-shrink-0">
                <div class="avatar-xs">
                  <span class="avatar-title rounded-circle bg-primary">
                    <i class="bx bx-envelope"></i>
                  </span>
                </div>
              </div>
              <div class="flex-grow-1 ms-3">
                <h6 class="mb-0">Email</h6>
                <p class="text-muted mb-0">{{ thong_tin.email }}</p>
              </div>
            </div>
            <div class="d-flex align-items-center mb-3">
              <div class="flex-shrink-0">
                <div class="avatar-xs">
                  <span class="avatar-title rounded-circle bg-success">
                    <i class="bx bx-phone"></i>
                  </span>
                </div>
              </div>
              <div class="flex-grow-1 ms-3">
                <h6 class="mb-0">Điện thoại</h6>
                <p class="text-muted mb-0">{{ thong_tin.so_dien_thoai }}</p>
              </div>
            </div>
            <div class="d-flex align-items-center mb-3">
              <div class="flex-shrink-0">
                <div class="avatar-xs">
                  <span class="avatar-title rounded-circle bg-info">
                    <i class="bx bx-map"></i>
                  </span>
                </div>
              </div>
              <div class="flex-grow-1 ms-3">
                <h6 class="mb-0">Địa chỉ</h6>
                <p class="text-muted mb-0">{{ thong_tin.dia_chi }}</p>
              </div>
            </div>
            <div class="d-flex align-items-center">
              <div class="flex-shrink-0">
                <div class="avatar-xs">
                  <span class="avatar-title rounded-circle bg-warning">
                    <i class="bx bx-calendar"></i>
                  </span>
                </div>
              </div>
              <div class="flex-grow-1 ms-3">
                <h6 class="mb-0">Ngày sinh</h6>
                <p class="text-muted mb-0">{{ thong_tin.ngay_sinh }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Skills -->
        <div class="card">
          <div class="card-header">
            <h5 class="card-title mb-0">Kỹ năng chuyên môn</h5>
          </div>
          <div class="card-body">
            <div class="mb-3">
              <div class="d-flex justify-content-between mb-1">
                <span>Quản lý hệ thống</span>
                <span>95%</span>
              </div>
              <div class="progress" style="height: 6px;">
                <div class="progress-bar bg-primary" style="width: 95%"></div>
              </div>
            </div>
            <div class="mb-3">
              <div class="d-flex justify-content-between mb-1">
                <span>Quản lý nhân sự</span>
                <span>88%</span>
              </div>
              <div class="progress" style="height: 6px;">
                <div class="progress-bar bg-success" style="width: 88%"></div>
              </div>
            </div>
            <div class="mb-3">
              <div class="d-flex justify-content-between mb-1">
                <span>Báo cáo tài chính</span>
                <span>92%</span>
              </div>
              <div class="progress" style="height: 6px;">
                <div class="progress-bar bg-info" style="width: 92%"></div>
              </div>
            </div>
            <div class="mb-3">
              <div class="d-flex justify-content-between mb-1">
                <span>Phân tích dữ liệu</span>
                <span>85%</span>
              </div>
              <div class="progress" style="height: 6px;">
                <div class="progress-bar bg-warning" style="width: 85%"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <div class="col-xl-8">
        <!-- Personal Info Form -->
        <div class="card">
          <div class="card-header">
            <h5 class="card-title mb-0">Thông tin cá nhân</h5>
          </div>
          <div class="card-body">
            <form>
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="firstName" class="form-label">Họ và tên đệm</label>
                    <input type="text" class="form-control" id="firstName" value="Nguyễn Văn">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="lastName" class="form-label">Tên</label>
                    <input type="text" class="form-control" id="lastName" value="Admin">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" value="admin@qlmn.edu.vn">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="phone" class="form-label">Điện thoại</label>
                    <input type="tel" class="form-control" id="phone" value="0901 234 567">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="birthDate" class="form-label">Ngày sinh</label>
                    <input type="date" class="form-control" id="birthDate" value="1985-03-15">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="gender" class="form-label">Giới tính</label>
                    <select class="form-select" id="gender">
                      <option value="male" selected>Nam</option>
                      <option value="female">Nữ</option>
                      <option value="other">Khác</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="mb-3">
                <label for="address" class="form-label">Địa chỉ</label>
                <textarea class="form-control" id="address" rows="3">123 Đường ABC, Quận 1, TP.HCM</textarea>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="department" class="form-label">Phòng ban</label>
                    <input type="text" class="form-control" id="department" value="Quản trị hệ thống">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="position" class="form-label">Chức vụ</label>
                    <input type="text" class="form-control" id="position" value="Quản trị viên">
                  </div>
                </div>
              </div>
              <div class="text-end">
                <button type="button" class="btn btn-secondary me-2">Hủy</button>
                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
              </div>
            </form>
          </div>
        </div>

        <!-- Change Password -->
        <div class="card">
          <div class="card-header">
            <h5 class="card-title mb-0">Đổi mật khẩu</h5>
          </div>
          <div class="card-body">
            <form>
              <div class="mb-3">
                <label for="currentPassword" class="form-label">Mật khẩu hiện tại</label>
                <input type="password" class="form-control" id="currentPassword">
              </div>
              <div class="mb-3">
                <label for="newPassword" class="form-label">Mật khẩu mới</label>
                <input type="password" class="form-control" id="newPassword">
              </div>
              <div class="mb-3">
                <label for="confirmPassword" class="form-label">Xác nhận mật khẩu mới</label>
                <input type="password" class="form-control" id="confirmPassword">
              </div>
              <div class="text-end">
                <button type="submit" class="btn btn-warning">Đổi mật khẩu</button>
              </div>
            </form>
          </div>
        </div>

        <!-- Activity Log -->
        <div class="card">
          <div class="card-header">
            <h5 class="card-title mb-0">Hoạt động gần đây</h5>
          </div>
          <div class="card-body">
            <div class="timeline-alt pb-0">
              <div class="timeline-item">
                <i class="bx bx-log-in bg-success-light text-success timeline-icon"></i>
                <div class="timeline-item-info">
                  <a href="#" class="text-info fw-bold mb-1 d-block">Đăng nhập hệ thống</a>
                  <small class="text-muted">2 phút trước</small>
                  <p class="mb-0 mt-1">Đăng nhập thành công từ IP: 192.168.1.100</p>
                </div>
              </div>
              <div class="timeline-item">
                <i class="bx bx-edit bg-primary-light text-primary timeline-icon"></i>
                <div class="timeline-item-info">
                  <a href="#" class="text-info fw-bold mb-1 d-block">Cập nhật thông tin học sinh</a>
                  <small class="text-muted">1 giờ trước</small>
                  <p class="mb-0 mt-1">Cập nhật thông tin lớp học cho 15 học sinh</p>
                </div>
              </div>
              <div class="timeline-item">
                <i class="bx bx-file bg-info-light text-info timeline-icon"></i>
                <div class="timeline-item-info">
                  <a href="#" class="text-info fw-bold mb-1 d-block">Xuất báo cáo tài chính</a>
                  <small class="text-muted">3 giờ trước</small>
                  <p class="mb-0 mt-1">Xuất báo cáo thu chi tháng 12/2024</p>
                </div>
              </div>
              <div class="timeline-item">
                <i class="bx bx-user-plus bg-warning-light text-warning timeline-icon"></i>
                <div class="timeline-item-info">
                  <a href="#" class="text-info fw-bold mb-1 d-block">Thêm giáo viên mới</a>
                  <small class="text-muted">1 ngày trước</small>
                  <p class="mb-0 mt-1">Thêm giáo viên Nguyễn Thị B vào hệ thống</p>
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
            this.$toast.success(res.data.message);
          } else {
            this.$toast.error(res.data.message);
          }
        })
        .catch((err) => {
          const listErr = err.res.data.errors;
          Object.values(listErr).forEach((error) => {
            this.$toast.error(error[0]);
          });
        });
    },
  }
}
</script>

<style scoped>
.page-title-box {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 20px;
  border-radius: 10px;
  margin-bottom: 30px;
}

.page-title-box h4 {
  color: white;
  margin: 0;
}

.breadcrumb {
  background: transparent;
  margin: 0;
}

.breadcrumb-item a {
  color: rgba(255, 255, 255, 0.8);
}

.breadcrumb-item.active {
  color: white;
}

.card {
  border: none;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
  border-radius: 15px;
  margin-bottom: 24px;
}

.card-header {
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
  border-bottom: none;
  border-radius: 15px 15px 0 0 !important;
}

.card-title {
  color: #2c3e50;
  font-weight: 600;
}

.avatar-lg {
  width: 150px;
  height: 150px;
}

.avatar-xs {
  width: 32px;
  height: 32px;
}

.avatar-online {
  position: absolute;
  bottom: 0;
  right: 0;
}

.avatar-status-online {
  width: 20px;
  height: 20px;
  background-color: #28a745;
  border: 3px solid #fff;
  border-radius: 50%;
  display: block;
}

.btn {
  border-radius: 25px;
  padding: 10px 20px;
  font-weight: 500;
  transition: all 0.3s ease;
}

.btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.form-control,
.form-select {
  border-radius: 10px;
  border: 1px solid #e9ecef;
  padding: 12px 15px;
  transition: all 0.3s ease;
}

.form-control:focus,
.form-select:focus {
  border-color: #667eea;
  box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.progress {
  border-radius: 10px;
  background-color: #f8f9fa;
}

.progress-bar {
  border-radius: 10px;
}

.timeline-alt {
  position: relative;
}

.timeline-item {
  position: relative;
  padding-bottom: 1.5rem;
}

.timeline-item:last-child {
  padding-bottom: 0;
}

.timeline-icon {
  position: absolute;
  left: 0;
  top: 0;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
}

.timeline-item-info {
  margin-left: 50px;
  padding-top: 5px;
}

.bg-success-light {
  background-color: rgba(40, 167, 69, 0.2);
}

.bg-primary-light {
  background-color: rgba(0, 123, 255, 0.2);
}

.bg-info-light {
  background-color: rgba(23, 162, 184, 0.2);
}

.bg-warning-light {
  background-color: rgba(255, 193, 7, 0.2);
}

@media (max-width: 768px) {
  .page-title-box {
    padding: 15px;
  }

  .btn {
    padding: 8px 16px;
    font-size: 14px;
  }

  .avatar-lg {
    width: 120px;
    height: 120px;
  }
}
</style>