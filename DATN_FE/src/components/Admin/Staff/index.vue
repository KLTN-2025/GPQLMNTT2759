<template>
  <div class="page-header education-theme">
    <div class="container-fluid">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="page-header-content">
            <div class="page-icon">
              <i class="fas fa-user-tie"></i>
            </div>
            <div class="page-info">
              <h1 class="page-title">Quản lý Nhân Viên</h1>
              <p class="page-subtitle">
                Quản lý thông tin nhân viên trong hệ thống
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <nav class="breadcrumb-nav">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <i class="fas fa-school"></i>
                <a href="javascript: void(0);">Nhân sự</a>
              </li>
              <li class="breadcrumb-item active">
                <i class="fas fa-user-tie"></i>
                Nhân Viên
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
          <i class="fas fa-user-tie"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">{{ list_nhan_vien.length }}</h3>
          <p class="stats-label">Tổng Nhân Viên</p>
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
            {{list_nhan_vien.filter((nv) => nv.tinh_trang == 1).length}}
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
            {{list_nhan_vien.filter((nv) => nv.tinh_trang == 0).length}}
          </h3>
          <p class="stats-label">Tạm Ngừng</p>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="stats-card stats-info">
        <div class="stats-icon">
          <i class="fas fa-briefcase"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">{{ list_chuc_vu.length }}</h3>
          <p class="stats-label">Chức Vụ</p>
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
              <h5 class="card-title">Danh Sách Nhân Viên</h5>
              <p class="card-subtitle">Quản lý thông tin nhân viên hệ thống</p>
            </div>
          </div>
          <button class="btn btn-primary btn-modern" data-bs-toggle="modal" data-bs-target="#themModal">
            <i class="fas fa-user-plus"></i>
            Thêm Nhân Viên
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
                <select v-on:change="TiemKiem()" class="filter-select" v-model="search.id_chuc_vu">
                  <option value="">Tất cả chức vụ</option>
                  <option v-for="cv in list_chuc_vu" :key="cv.id" :value="cv.id">
                    {{ cv.ten_chuc_vu }}
                  </option>
                </select>
              </div>
            </div>
          </div>

          <!-- Table -->
          <div class="table-container">
            <div class="">
              <table class="table table-modern">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>Nhân Viên</th>
                    <th class="text-center">Liên Hệ</th>
                    <th class="text-center">Thông Tin</th>
                    <th class="text-center">Chức Vụ</th>
                    <th class="text-center">Trạng Thái</th>
                    <th class="text-center">Thao Tác</th>
                  </tr>
                </thead>
                <tbody>
                  <template v-for="(value, index) in list_nhan_vien" :key="index">
                    <tr class="table-row-hover">
                      <td class="text-center table-index">
                        {{ index + 1 }}
                      </td>
                      <td class="employee-info">
                        <div class="employee-container">
                          <div class="employee-avatar">
                            <img :src="value.avatar || '/default-avatar.jpg'" :alt="value.ho_va_ten"
                              class="avatar-img" />
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
                        <span class="position-badge">
                          <i class="fas fa-briefcase"></i>
                          {{ value.ten_chuc_vu }}
                        </span>
                      </td>
                      <td class="text-center">
                        <button v-on:click="DoiTrangThai(value)" v-if="value.tinh_trang == 1"
                          class="btn btn-success status-active">
                          <i class="fas fa-check-circle"></i>
                          Hoạt Động
                        </button>
                        <button v-on:click="DoiTrangThai(value)" v-else class="btn btn-danger status-inactive">
                          <i class="fas fa-pause-circle"></i>
                          Tạm Ngừng
                        </button>
                      </td>
                      <td class="text-center">
                        <div class="action-buttons">
                          <button class="btn-action btn-edit" @click="Object.assign(update_nhan_vien, value)"
                            data-bs-toggle="modal" data-bs-target="#capNhatModal" title="Chỉnh sửa">
                            <i class="fas fa-edit"></i>
                          </button>
                          <button class="btn-action btn-delete" @click="Object.assign(delete_nhan_vien, value)"
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
  </div>

  <!-- Modal Thêm Nhân Viên -->
  <div class="modal fade" id="themModal" tabindex="-1" aria-labelledby="themModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="themModalLabel">
            <i class="fas fa-user-plus me-2"></i>
            Thêm Nhân Viên Mới
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="row">
              <div class="col-md-6">
                <label for="hoVaTen" class="form-label">Họ và Tên *</label>
                <input type="text" class="form-control" id="hoVaTen" v-model="create_nhan_vien.ho_va_ten" required />
              </div>
              <div class="col-md-6">
                <label for="email" class="form-label">Email *</label>
                <input type="email" class="form-control" id="email" v-model="create_nhan_vien.email" required />
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="soDienThoai" class="form-label">Số Điện Thoại *</label>
                <input type="tel" class="form-control" id="soDienThoai" v-model="create_nhan_vien.so_dien_thoai"
                  required />
              </div>
              <div class="col-md-6">
                <label for="gioiTinh" class="form-label">Giới Tính *</label>
                <select class="form-select" id="gioiTinh" v-model="create_nhan_vien.gioi_tinh" required>
                  <option value="">Chọn giới tính</option>
                  <option value="1">Nam</option>
                  <option value="0">Nữ</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="ngaySinh" class="form-label">Ngày Sinh *</label>
                <input type="date" class="form-control" id="ngaySinh" v-model="create_nhan_vien.ngay_sinh" required />
              </div>
              <div class="col-md-6">
                <label for="chucVu" class="form-label">Chức Vụ *</label>
                <select class="form-select" id="chucVu" v-model="create_nhan_vien.id_chuc_vu" required>
                  <option value="">Chọn chức vụ</option>
                  <option v-for="cv in list_chuc_vu" :key="cv.id" :value="cv.id">
                    {{ cv.ten_chuc_vu }}
                  </option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="avatar" class="form-label">Avatar URL</label>
                <input type="url" class="form-control" id="avatar" v-model="create_nhan_vien.avatar"
                  placeholder="https://example.com/avatar.jpg" />
              </div>
              <div class="col-md-6">
                <label for="tinhTrang" class="form-label">Tình Trạng</label>
                <select v-model="create_nhan_vien.tinh_trang" class="form-select">
                  <option value="1">Hoạt Động</option>
                  <option value="0">Tạm Ngừng</option>
                </select>
              </div>
            </div>
            <label for="diaChi" class="form-label">Địa Chỉ *</label>
            <textarea class="form-control" id="diaChi" rows="3" v-model="create_nhan_vien.dia_chi" required></textarea>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>
            Hủy
          </button>
          <button type="button" class="btn btn-primary" @click="ThemNhanVien" :disabled="loading">
            <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
            <i v-else class="fas fa-save me-1"></i>
            {{ loading ? 'Đang xử lý...' : 'Thêm Nhân Viên' }}
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Cập Nhật Nhân Viên -->
  <div class="modal fade" id="capNhatModal" tabindex="-1" aria-labelledby="capNhatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="capNhatModalLabel">
            <i class="fas fa-user-edit me-2"></i>
            Cập Nhật Thông Tin Nhân Viên
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateHoVaTen" class="form-label">Họ và Tên *</label>
                  <input type="text" class="form-control" id="updateHoVaTen" v-model="update_nhan_vien.ho_va_ten"
                    required />
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateEmail" class="form-label">Email *</label>
                  <input type="email" class="form-control" id="updateEmail" v-model="update_nhan_vien.email" required />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateSoDienThoai" class="form-label">Số Điện Thoại *</label>
                  <input type="tel" class="form-control" id="updateSoDienThoai" v-model="update_nhan_vien.so_dien_thoai"
                    required />
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateGioiTinh" class="form-label">Giới Tính *</label>
                  <select class="form-select" id="updateGioiTinh" v-model="update_nhan_vien.gioi_tinh" required>
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
                  <input type="date" class="form-control" id="updateNgaySinh" v-model="update_nhan_vien.ngay_sinh"
                    required />
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateChucVu" class="form-label">Chức Vụ *</label>
                  <select class="form-select" id="updateChucVu" v-model="update_nhan_vien.id_chuc_vu" required>
                    <option value="">Chọn chức vụ</option>
                    <option v-for="cv in list_chuc_vu" :key="cv.id" :value="cv.id">
                      {{ cv.ten_chuc_vu }}
                    </option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateAvatar" class="form-label">Avatar URL</label>
                  <input type="url" class="form-control" id="updateAvatar" v-model="update_nhan_vien.avatar"
                    placeholder="https://example.com/avatar.jpg" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateTinhTrang" class="form-label">Tình Trạng</label>
                  <select v-model="update_nhan_vien.tinh_trang" class="form-select">
                    <option value="1">Hoạt Động</option>
                    <option value="0">Tạm Ngừng</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label for="updateDiaChi" class="form-label">Địa Chỉ *</label>
              <textarea class="form-control" id="updateDiaChi" rows="3" v-model="update_nhan_vien.dia_chi"
                required></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>
            Hủy
          </button>
          <button type="button" class="btn btn-primary" @click="CapNhatNhanVien" :disabled="loading">
            <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
            <i v-else class="fas fa-save me-1"></i>
            {{ loading ? 'Đang xử lý...' : 'Cập Nhật' }}
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Xóa Nhân Viên -->
  <div class="modal fade" id="xoaModal" tabindex="-1" aria-labelledby="xoaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="xoaModalLabel">
            <i class="fas fa-exclamation-triangle me-2 text-warning"></i>
            Xác Nhận Xóa Nhân Viên
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="text-center">
            <div class="mb-3">
              <i class="fas fa-user-times text-danger" style="font-size: 3rem;"></i>
            </div>
            <h6>Bạn có chắc chắn muốn xóa nhân viên này không?</h6>
            <div class="alert alert-warning" role="alert">
              <strong>Thông tin nhân viên:</strong><br>
              <strong>Tên:</strong> {{ delete_nhan_vien.ho_va_ten }}<br>
              <strong>Email:</strong> {{ delete_nhan_vien.email }}<br>
              <strong>Chức vụ:</strong> {{ delete_nhan_vien.ten_chuc_vu }}
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
          <button type="button" class="btn btn-danger" @click="XoaNhanVien" :disabled="loading">
            <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
            <i v-else class="fas fa-trash me-1"></i>
            {{ loading ? 'Đang xử lý...' : 'Xóa Nhân Viên' }}
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
      list_nhan_vien: [],
      list_chuc_vu: [],
      create_nhan_vien: {
        ho_va_ten: "",
        email: "",
        so_dien_thoai: "",
        gioi_tinh: "",
        ngay_sinh: "",
        id_chuc_vu: "",
        dia_chi: "",
        avatar: "",
        tinh_trang: "1",
      },
      update_nhan_vien: {
        id: "",
        ho_va_ten: "",
        email: "",
        so_dien_thoai: "",
        gioi_tinh: "",
        ngay_sinh: "",
        id_chuc_vu: "",
        dia_chi: "",
        tinh_trang: "",
        avatar: "",
      },
      delete_nhan_vien: {
        id: "",
        ho_va_ten: "",
        email: "",
        ten_chuc_vu: "",
      },
      search: {
        noi_dung: "",
        tinh_trang: "",
        id_chuc_vu: "",
      },
      loading: false,
    };
  },

  mounted() {
    this.loadData();
    this.loadChucVu();
  },

  methods: {
    formatDate(dateString) {
      if (!dateString) return "";
      const date = new Date(dateString);
      return date.toLocaleDateString("vi-VN");
    },

    loadData() {
      baseRequestAdmin
        .get("admin/nhan-vien/data")
        .then((res) => {
          if (res.data.status) {
            this.list_nhan_vien = res.data.data;
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

    loadChucVu() {
      baseRequestAdmin
        .get("admin/chuc-vu/data")
        .then((res) => {
          if (res.data.status) {
            this.list_chuc_vu = res.data.data;
          }
        })
        .catch((err) => {
          console.log("Không thể tải danh sách chức vụ");
        });
    },

    DoiTrangThai(payload) {
      baseRequestAdmin
        .post("admin/nhan-vien/change-status", payload)
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

    ThemNhanVien() {
      this.loading = true;
      baseRequestAdmin
        .post("admin/nhan-vien/create", this.create_nhan_vien)
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
            this.$toast.error("Có lỗi xảy ra khi thêm nhân viên");
          }
        })
        .finally(() => {
          this.loading = false;
        });
    },

    CapNhatNhanVien() {
      this.loading = true;
      baseRequestAdmin
        .post("admin/nhan-vien/update", this.update_nhan_vien)
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
            this.$toast.error("Có lỗi xảy ra khi cập nhật nhân viên");
          }
        })
        .finally(() => {
          this.loading = false;
        });
    },

    XoaNhanVien() {
      this.loading = true;
      baseRequestAdmin
        .post("admin/nhan-vien/delete", this.delete_nhan_vien)
        .then((res) => {
          if (res.data.status) {
            this.$toast.success(res.data.message);
            this.loadData();
            this.delete_nhan_vien = {};
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
            this.$toast.error("Có lỗi xảy ra khi xóa nhân viên");
          }
        })
        .finally(() => {
          this.loading = false;
        });
    },

    TiemKiem() {
      baseRequestAdmin
        .post("admin/nhan-vien/search", this.search)
        .then((res) => {
          if (res.data.status) {
            this.$toast.success(res.data.message);
            this.list_nhan_vien = res.data.data;
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
      this.create_nhan_vien = {
        ho_va_ten: "",
        email: "",
        so_dien_thoai: "",
        gioi_tinh: "",
        ngay_sinh: "",
        id_chuc_vu: "",
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
