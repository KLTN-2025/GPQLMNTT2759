<template>
  <div class="page-header education-theme">
    <div class="container-fluid">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="page-header-content">
            <div class="page-icon">
              <i class="fas fa-users"></i>
            </div>
            <div class="page-info">
              <h1 class="page-title">Quản lý Phụ Huynh</h1>
              <p class="page-subtitle">
                Quản lý thông tin phụ huynh trong hệ thống
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <nav class="breadcrumb-nav">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <i class="fas fa-school"></i>
                <a href="javascript: void(0);">Học sinh & PH</a>
              </li>
              <li class="breadcrumb-item active">
                <i class="fas fa-users"></i>
                Phụ Huynh
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>

  <div class="row mb-4">
    <div class="col-xl-3 col-md-6">
      <div class="stats-card stats-primary">
        <div class="stats-icon">
          <i class="fas fa-users"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">{{ list_phu_huynh.length }}</h3>
          <p class="stats-label">Tổng Phụ Huynh</p>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="stats-card stats-success">
        <div class="stats-icon">
          <i class="fas fa-user-check"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">
            {{list_phu_huynh.filter((ph) => ph.tinh_trang == 1).length}}
          </h3>
          <p class="stats-label">Đang Hoạt Động</p>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="stats-card stats-warning">
        <div class="stats-icon">
          <i class="fas fa-user-pause"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">
            {{list_phu_huynh.filter((ph) => ph.tinh_trang == 0).length}}
          </h3>
          <p class="stats-label">Tạm Ngừng</p>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="stats-card stats-info">
        <div class="stats-icon">
          <i class="fas fa-child"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">{{ getTotalChildren().length }}</h3>
          <p class="stats-label">Con Em</p>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12">
      <div class="management-card" :class="{ 'no-hover': modalOpen }">
        <div class="card-header-custom">
          <div class="header-content">
            <div class="header-icon">
              <i class="fas fa-users"></i>
            </div>
            <div class="header-text">
              <h5 class="card-title">Danh Sách Phụ Huynh</h5>
              <p class="card-subtitle">Quản lý thông tin phụ huynh hệ thống</p>
            </div>
          </div>
          <button class="btn btn-primary btn-modern" data-bs-toggle="modal" data-bs-target="#themModal">
            <i class="fas fa-user-plus"></i>
            Thêm Phụ Huynh
          </button>
        </div>

        <div class="card-body">
          <!-- Search Container -->
          <div class="search-container mb-4">
            <div class="search-input-group">
              <div class="form-search">
                <div class="search-icon">
                  <i class="fas fa-search"></i>
                </div>
                <input v-on:change="TiemKiem()" v-model="search.noi_dung" type="text" class="search-input"
                  placeholder="Tìm kiếm theo tên, email, số điện thoại..." />
              </div>

              <div class="search-filters">
                <select v-on:change="TiemKiem()" class="filter-select" v-model="search.tinh_trang">
                  <option value="">Tất cả trạng thái</option>
                  <option value="1">Hoạt động</option>
                  <option value="0">Tạm ngừng</option>
                </select>
                <select v-on:change="TiemKiem()" class="filter-select" v-model="search.quan_he">
                  <option value="">Tất cả quan hệ</option>
                  <option value="Cha">Cha</option>
                  <option value="Mẹ">Mẹ</option>
                  <option value="Ông">Ông</option>
                  <option value="Bà">Bà</option>
                  <option value="Cô/Chú">Cô/Chú</option>
                  <option value="Anh/Chị">Anh/Chị</option>
                  <option value="Khác">Khác</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Table -->
          <div class="table-container">
            <table class="table table-modern">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th>Phụ Huynh</th>
                  <th class="text-center">Liên Hệ</th>
                  <th class="text-center">Thông Tin</th>
                  <th class="text-center">Quan Hệ</th>
                  <th class="text-center">Nghề Nghiệp</th>
                  <th class="text-center">Trạng Thái</th>
                  <th class="text-center">Thao Tác</th>
                </tr>
              </thead>
              <tbody>
                <template v-for="(value, index) in list_phu_huynh" :key="index">
                  <tr class="table-row-hover">
                    <td class="text-center table-index">
                      {{ index + 1 }}
                    </td>
                    <td class="employee-info">
                      <div class="employee-container">
                        <div class="employee-avatar">
                          <img :src="value.avatar || '/default-avatar.jpg'" :alt="value.ho_va_ten" class="avatar-img" />
                        </div>
                        <div class="employee-details">
                          <span class="employee-name">{{ value.ho_va_ten }}</span>
                          <small class="employee-email">{{ value.email }}</small>
                        </div>
                      </div>
                    </td>
                    <td class="text-center contact-info">
                      <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <span>{{ value.so_dien_thoai }}</span>
                      </div>
                    </td>
                    <td class="text-center personal-info">
                      <div class="info-group">
                        <div class="info-item">
                          <i
                            :class="value.gioi_tinh === 1 ? 'fas fa-mars text-primary' : 'fas fa-venus text-danger'"></i>
                          <span>{{ value.gioi_tinh === 1 ? "Nam" : "Nữ" }}</span>
                        </div>
                        <div class="info-item">
                          <i class="fas fa-birthday-cake"></i>
                          <span>{{ formatDate(value.ngay_sinh) }}</span>
                        </div>
                        <div class="info-item">
                          <i class="fas fa-map-marker-alt"></i>
                          <span>{{ value.dia_chi }}</span>
                        </div>
                      </div>
                    </td>
                    <td class="text-center">
                      <span class="relationship-badge">
                        <i class="fas fa-heart"></i>
                        {{ value.quan_he }}
                      </span>
                    </td>
                    <td class="text-center">
                      <div class="job-info">
                        <div class="job-title">{{ value.nghe_nghiep || 'Chưa cập nhật' }}</div>
                        <small class="company-name">{{ value.cong_ty || '' }}</small>
                      </div>
                    </td>
                    <td class="text-center">
                      <button v-on:click="DoiTrangThai(value)" v-if="value.tinh_trang == 1"
                        class="btn status-badge status-active">
                        <i class="fas fa-check-circle"></i>
                        Hoạt Động
                      </button>
                      <button v-on:click="DoiTrangThai(value)" v-else class="btn status-badge status-inactive">
                        <i class="fas fa-pause-circle"></i>
                        Tạm Ngừng
                      </button>
                    </td>
                    <td class="text-center">
                      <div class="action-buttons">
                        <button class="btn-action btn-edit" @click="Object.assign(update_phu_huynh, value)"
                          data-bs-toggle="modal" data-bs-target="#capNhatModal" title="Chỉnh sửa">
                          <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-action btn-delete" @click="Object.assign(delete_phu_huynh, value)"
                          data-bs-toggle="modal" data-bs-target="#xoaModal" title="Xóa">
                          <i class="fas fa-trash"></i>
                        </button>
                      </div>
                    </td>
                  </tr>
                </template>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Cập Nhật Phụ Huynh -->
  <div class="modal fade" id="capNhatModal" tabindex="-1" aria-labelledby="capNhatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="capNhatModalLabel">
            <i class="fas fa-user-edit me-2"></i>
            Cập Nhật Thông Tin Phụ Huynh
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateHoVaTen" class="form-label">Họ và Tên *</label>
                  <input type="text" class="form-control" id="updateHoVaTen" v-model="update_phu_huynh.ho_va_ten"
                    required />
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateEmail" class="form-label">Email *</label>
                  <input type="email" class="form-control" id="updateEmail" v-model="update_phu_huynh.email" required />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateSoDienThoai" class="form-label">Số Điện Thoại *</label>
                  <input type="tel" class="form-control" id="updateSoDienThoai" v-model="update_phu_huynh.so_dien_thoai"
                    required />
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateGioiTinh" class="form-label">Giới Tính *</label>
                  <select class="form-select" id="updateGioiTinh" v-model="update_phu_huynh.gioi_tinh" required>
                    <option value="">Chọn giới tính</option>
                    <option value="1">Nam</option>
                    <option value="0">Nữ</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateNgaySinh" class="form-label">Ngày Sinh *</label>
                  <input type="date" class="form-control" id="updateNgaySinh" v-model="update_phu_huynh.ngay_sinh"
                    required />
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateQuanHe" class="form-label">Quan Hệ Với Trẻ *</label>
                  <select class="form-select" id="updateQuanHe" v-model="update_phu_huynh.quan_he" required>
                    <option value="">Chọn quan hệ</option>
                    <option value="Cha">Cha</option>
                    <option value="Mẹ">Mẹ</option>
                    <option value="Ông">Ông</option>
                    <option value="Bà">Bà</option>
                    <option value="Cô/Chú">Cô/Chú</option>
                    <option value="Anh/Chị">Anh/Chị</option>
                    <option value="Khác">Khác</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateNgheNghiep" class="form-label">Nghề Nghiệp</label>
                  <input type="text" class="form-control" id="updateNgheNghiep" v-model="update_phu_huynh.nghe_nghiep"
                    placeholder="VD: Giáo viên, Bác sĩ..." />
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateCongTy" class="form-label">Công Ty</label>
                  <input type="text" class="form-control" id="updateCongTy" v-model="update_phu_huynh.cong_ty"
                    placeholder="Tên công ty làm việc" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateAvatar" class="form-label">Avatar URL</label>
                  <input type="url" class="form-control" id="updateAvatar" v-model="update_phu_huynh.avatar"
                    placeholder="https://example.com/avatar.jpg" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateTinhTrang" class="form-label">Tình Trạng</label>
                  <select v-model="update_phu_huynh.tinh_trang" class="form-select">
                    <option value="1">Hoạt Động</option>
                    <option value="0">Tạm Ngừng</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label for="updateDiaChi" class="form-label">Địa Chỉ *</label>
              <textarea class="form-control" id="updateDiaChi" rows="3" v-model="update_phu_huynh.dia_chi"
                required></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>
            Hủy
          </button>
          <button type="button" class="btn btn-primary" @click="CapNhatPhuHuynh" :disabled="loading">
            <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
            <i v-else class="fas fa-save me-1"></i>
            {{ loading ? 'Đang xử lý...' : 'Cập Nhật' }}
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Xóa Phụ Huynh -->
  <div class="modal fade" id="xoaModal" tabindex="-1" aria-labelledby="xoaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="xoaModalLabel">
            <i class="fas fa-exclamation-triangle me-2 text-warning"></i>
            Xác Nhận Xóa Phụ Huynh
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="text-center">
            <div class="mb-3">
              <i class="fas fa-user-times text-danger" style="font-size: 3rem;"></i>
            </div>
            <h6>Bạn có chắc chắn muốn xóa phụ huynh này không?</h6>
            <div class="alert alert-warning" role="alert">
              <strong>Thông tin phụ huynh:</strong><br>
              <strong>Tên:</strong> {{ delete_phu_huynh.ho_va_ten }}<br>
              <strong>Email:</strong> {{ delete_phu_huynh.email }}<br>
              <strong>Quan hệ:</strong> {{ delete_phu_huynh.quan_he }}
            </div>
            <p class="text-muted">
              <i class="fas fa-info-circle me-1"></i>
              Hành động này không thể hoàn tác!
            </p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>
            Hủy
          </button>
          <button type="button" class="btn btn-danger" @click="XoaPhuHuynh" :disabled="loading">
            <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
            <i v-else class="fas fa-trash me-1"></i>
            {{ loading ? 'Đang xử lý...' : 'Xóa Phụ Huynh' }}
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Thêm Phụ Huynh -->
  <div class="modal fade" id="themModal" tabindex="-1" aria-labelledby="themModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="themModalLabel">
            <i class="fas fa-user-plus me-2"></i>
            Thêm Phụ Huynh Mới
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="row">
              <div class="col-md-6">
                <label for="hoVaTen" class="form-label">Họ và Tên *</label>
                <input type="text" class="form-control" id="hoVaTen" v-model="create_phu_huynh.ho_va_ten" required />
              </div>
              <div class="col-md-6">
                <label for="email" class="form-label">Email *</label>
                <input type="email" class="form-control" id="email" v-model="create_phu_huynh.email" required />
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="soDienThoai" class="form-label">Số Điện Thoại *</label>
                <input type="tel" class="form-control" id="soDienThoai" v-model="create_phu_huynh.so_dien_thoai"
                  required />
              </div>
              <div class="col-md-6">
                <label for="gioiTinh" class="form-label">Giới Tính *</label>
                <select class="form-select" id="gioiTinh" v-model="create_phu_huynh.gioi_tinh" required>
                  <option value="">Chọn giới tính</option>
                  <option value="1">Nam</option>
                  <option value="0">Nữ</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="ngaySinh" class="form-label">Ngày Sinh *</label>
                <input type="date" class="form-control" id="ngaySinh" v-model="create_phu_huynh.ngay_sinh" required />
              </div>
              <div class="col-md-6">
                <label for="quanHe" class="form-label">Quan Hệ Với Trẻ *</label>
                <select class="form-select" id="quanHe" v-model="create_phu_huynh.quan_he" required>
                  <option value="">Chọn quan hệ</option>
                  <option value="Cha">Cha</option>
                  <option value="Mẹ">Mẹ</option>
                  <option value="Ông">Ông</option>
                  <option value="Bà">Bà</option>
                  <option value="Cô/Chú">Cô/Chú</option>
                  <option value="Anh/Chị">Anh/Chị</option>
                  <option value="Khác">Khác</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="ngheNghiep" class="form-label">Nghề Nghiệp</label>
                <input type="text" class="form-control" id="ngheNghiep" v-model="create_phu_huynh.nghe_nghiep"
                  placeholder="VD: Giáo viên, Bác sĩ..." />
              </div>
              <div class="col-md-6">
                <label for="congTy" class="form-label">Công Ty</label>
                <input type="text" class="form-control" id="congTy" v-model="create_phu_huynh.cong_ty"
                  placeholder="Tên công ty làm việc" />
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="avatar" class="form-label">Avatar URL</label>
                <input type="url" class="form-control" id="avatar" v-model="create_phu_huynh.avatar"
                  placeholder="https://example.com/avatar.jpg" />
              </div>
              <div class="col-md-6">
                <label for="tinhTrang" class="form-label">Tình Trạng</label>
                <select v-model="create_phu_huynh.tinh_trang" class="form-select">
                  <option value="1">Hoạt Động</option>
                  <option value="0">Tạm Ngừng</option>
                </select>
              </div>
            </div>
            <label for="diaChi" class="form-label">Địa Chỉ *</label>
            <textarea class="form-control" id="diaChi" rows="3" v-model="create_phu_huynh.dia_chi" required></textarea>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>
            Hủy
          </button>
          <button type="button" class="btn btn-primary" @click="ThemPhuHuynh" :disabled="loading">
            <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
            <i v-else class="fas fa-save me-1"></i>
            {{ loading ? 'Đang xử lý...' : 'Thêm Phụ Huynh' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import baseRequestAdmin from "../../../core/baseRequestAdmin";

export default {
  data() {
    return {
      list_phu_huynh: [],
      create_phu_huynh: {
        ho_va_ten: "",
        email: "",
        so_dien_thoai: "",
        gioi_tinh: "",
        ngay_sinh: "",
        quan_he: "",
        nghe_nghiep: "",
        cong_ty: "",
        dia_chi: "",
        avatar: "",
        tinh_trang: "1",
      },
      update_phu_huynh: {
        id: "",
        ho_va_ten: "",
        email: "",
        so_dien_thoai: "",
        gioi_tinh: "",
        ngay_sinh: "",
        quan_he: "",
        nghe_nghiep: "",
        cong_ty: "",
        dia_chi: "",
        tinh_trang: "",
        avatar: "",
      },
      delete_phu_huynh: {
        id: "",
        ho_va_ten: "",
        email: "",
        quan_he: "",
      },
      search: {
        noi_dung: "",
        tinh_trang: "",
        quan_he: "",
      },
      loading: false,
    };
  },

  mounted() {
    this.loadData();
  },

  methods: {
    formatDate(dateString) {
      if (!dateString) return "";
      const date = new Date(dateString);
      return date.toLocaleDateString("vi-VN");
    },

    getTotalChildren() {
      // Mock data - trong thực tế sẽ lấy từ API
      const children = [];
      this.list_phu_huynh.forEach(ph => {
        if (ph.con_em) {
          ph.con_em.forEach(child => {
            children.push(child);
          });
        }
      });
      return children;
    },

    loadData() {
      baseRequestAdmin
        .get("admin/phu-huynh/data")
        .then((res) => {
          if (res.data.status) {
            this.list_phu_huynh = res.data.data;
            this.$toast.success(res.data.message);
          } else {
            this.$toast.error(res.data.message);
          }
        })
        .catch((err) => {
          const listErr = err.response?.data?.errors;
          if (listErr) {
            Object.values(listErr).forEach((error) => {
              this.$toast.error(error[0]);
            });
          } else {
            this.$toast.error("Có lỗi xảy ra khi tải dữ liệu");
          }
        });
    },

    DoiTrangThai(payload) {
      baseRequestAdmin
        .post("admin/phu-huynh/change-status", payload)
        .then((res) => {
          if (res.data.status) {
            this.$toast.success(res.data.message);
            this.loadData();
          } else {
            this.$toast.error(res.data.message);
          }
        })
        .catch((err) => {
          this.$toast.error("Có lỗi xảy ra khi thay đổi trạng thái");
        });
    },

    ThemPhuHuynh() {
      this.loading = true;
      baseRequestAdmin
        .post("admin/phu-huynh/create", this.create_phu_huynh)
        .then((res) => {
          if (res.data.status) {
            this.$toast.success(res.data.message);
            this.loadData();
            this.resetCreateForm();
            // Đóng modal
            const modal = bootstrap.Modal.getInstance(document.getElementById("themModal"));
            if (modal) modal.hide();
          } else {
            this.$toast.error(res.data.message);
          }
        })
        .catch((err) => {
          const listErr = err.response?.data?.errors;
          if (listErr) {
            Object.values(listErr).forEach((error) => {
              this.$toast.error(error[0]);
            });
          } else {
            this.$toast.error("Có lỗi xảy ra khi thêm phụ huynh");
          }
        })
        .finally(() => {
          this.loading = false;
        });
    },

    CapNhatPhuHuynh() {
      this.loading = true;
      baseRequestAdmin
        .post("admin/phu-huynh/update", this.update_phu_huynh)
        .then((res) => {
          if (res.data.status) {
            this.$toast.success(res.data.message);
            this.loadData();
            // Đóng modal
            const modal = bootstrap.Modal.getInstance(document.getElementById("capNhatModal"));
            if (modal) modal.hide();
          } else {
            this.$toast.error(res.data.message);
          }
        })
        .catch((err) => {
          const listErr = err.response?.data?.errors;
          if (listErr) {
            Object.values(listErr).forEach((error) => {
              this.$toast.error(error[0]);
            });
          } else {
            this.$toast.error("Có lỗi xảy ra khi cập nhật phụ huynh");
          }
        })
        .finally(() => {
          this.loading = false;
        });
    },

    XoaPhuHuynh() {
      this.loading = true;
      baseRequestAdmin
        .post("admin/phu-huynh/delete", this.delete_phu_huynh)
        .then((res) => {
          if (res.data.status) {
            this.$toast.success(res.data.message);
            this.loadData();
            this.delete_phu_huynh = {};
            // Đóng modal
            const modal = bootstrap.Modal.getInstance(document.getElementById("xoaModal"));
            if (modal) modal.hide();
          } else {
            this.$toast.error(res.data.message);
          }
        })
        .catch((err) => {
          const listErr = err.response?.data?.errors;
          if (listErr) {
            Object.values(listErr).forEach((error) => {
              this.$toast.error(error[0]);
            });
          } else {
            this.$toast.error("Có lỗi xảy ra khi xóa phụ huynh");
          }
        })
        .finally(() => {
          this.loading = false;
        });
    },

    TiemKiem() {
      baseRequestAdmin
        .post("admin/phu-huynh/search", this.search)
        .then((res) => {
          if (res.data.status) {
            this.$toast.success(res.data.message);
            this.list_phu_huynh = res.data.data;
          } else {
            this.$toast.error(res.data.message);
          }
        })
        .catch((err) => {
          const listErr = err.response?.data?.errors;
          if (listErr) {
            Object.values(listErr).forEach((error) => {
              this.$toast.error(error[0]);
            });
          } else {
            this.$toast.error("Có lỗi xảy ra khi tìm kiếm");
          }
        });
    },

    resetCreateForm() {
      this.create_phu_huynh = {
        ho_va_ten: "",
        email: "",
        so_dien_thoai: "",
        gioi_tinh: "",
        ngay_sinh: "",
        quan_he: "",
        nghe_nghiep: "",
        cong_ty: "",
        dia_chi: "",
        avatar: "",
        tinh_trang: "1",
      };
    },
  },
};
</script>

<style lang="scss">
@use "./style.scss";
</style>