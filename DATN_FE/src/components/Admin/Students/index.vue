<template>
  <div class="page-header education-theme">
    <div class="container-fluid">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="page-header-content">
            <div class="page-icon">
              <i class="fas fa-child"></i>
            </div>
            <div class="page-info">
              <h1 class="page-title">Quản lý Học Sinh</h1>
              <p class="page-subtitle">
                Quản lý thông tin học sinh trong hệ thống
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
                <i class="fas fa-child"></i>
                Học Sinh
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
          <i class="fas fa-child"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">{{ list_hoc_sinh.length }}</h3>
          <p class="stats-label">Tổng Học Sinh</p>
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
            {{list_hoc_sinh.filter((hs) => hs.tinh_trang == 1).length}}
          </h3>
          <p class="stats-label">Đang Học</p>
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
            {{list_hoc_sinh.filter((hs) => hs.tinh_trang == 0).length}}
          </h3>
          <p class="stats-label">Tạm Nghỉ</p>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="stats-card stats-info">
        <div class="stats-icon">
          <i class="fas fa-graduation-cap"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">{{ getUniqueClasses().length }}</h3>
          <p class="stats-label">Lớp Học</p>
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
              <i class="fas fa-child"></i>
            </div>
            <div class="header-text">
              <h5 class="card-title">Danh Sách Học Sinh</h5>
              <p class="card-subtitle">Quản lý thông tin học sinh hệ thống</p>
            </div>
          </div>
          <button class="btn btn-primary btn-modern" data-bs-toggle="modal" data-bs-target="#themModal">
            <i class="fas fa-user-plus"></i>
            Thêm Học Sinh
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
                  placeholder="Tìm kiếm theo tên, lớp học..." />
              </div>

              <div class="search-filters">
                <select v-on:change="TiemKiem()" class="filter-select" v-model="search.tinh_trang">
                  <option value="">Tất cả trạng thái</option>
                  <option value="1">Đang học</option>
                  <option value="0">Tạm nghỉ</option>
                </select>
                <select v-on:change="TiemKiem()" class="filter-select" v-model="search.lop_hoc">
                  <option value="">Tất cả lớp</option>
                  <option value="Lớp Mầm">Lớp Mầm</option>
                  <option value="Lớp Chồi">Lớp Chồi</option>
                  <option value="Lớp Lá">Lớp Lá</option>
                  <option value="Lớp Hoa">Lớp Hoa</option>
                  <option value="Lớp Búp">Lớp Búp</option>
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
                  <th>Học Sinh</th>
                  <th class="text-center">Thông Tin</th>
                  <th class="text-center">Lớp Học</th>
                  <th class="text-center">Phụ Huynh</th>
                  <th class="text-center">Ngày Nhập Học</th>
                  <th class="text-center">Trạng Thái</th>
                  <th class="text-center">Thao Tác</th>
                </tr>
              </thead>
              <tbody>
                <template v-for="(value, index) in list_hoc_sinh" :key="index">
                  <tr class="table-row-hover">
                    <td class="text-center table-index">
                      {{ index + 1 }}
                    </td>
                    <td class="student-info">
                      <div class="student-container">
                        <div class="student-avatar">
                          <img :src="value.avatar || '/default-avatar.jpg'" :alt="value.ho_va_ten" class="avatar-img" />
                        </div>
                        <div class="student-details">
                          <span class="student-name">{{ value.ho_va_ten }}</span>
                          <small class="student-age">{{ getAge(value.ngay_sinh) }} tuổi</small>
                        </div>
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
                        <div class="info-item" v-if="value.ghi_chu">
                          <i class="fas fa-sticky-note"></i>
                          <span>{{ value.ghi_chu }}</span>
                        </div>
                      </div>
                    </td>
                    <td class="text-center">
                      <span class="class-badge">
                        <i class="fas fa-graduation-cap"></i>
                        {{ value.lop_hoc }}
                      </span>
                    </td>
                    <td class="text-center">
                      <div class="parent-info">
                        <div class="parent-name">{{ value.ten_phu_huynh || 'Chưa cập nhật' }}</div>
                        <small class="parent-relationship">{{ value.quan_he_phu_huynh || '' }}</small>
                      </div>
                    </td>
                    <td class="text-center">
                      <div class="date-info">
                        <div class="date">{{ formatDate(value.ngay_nhap_hoc) }}</div>
                        <small class="duration">{{ getStudyDuration(value.ngay_nhap_hoc) }}</small>
                      </div>
                    </td>
                    <td class="text-center">
                      <button v-on:click="DoiTrangThai(value)" v-if="value.tinh_trang == 1"
                        class="btn status-badge status-active">
                        <i class="fas fa-check-circle"></i>
                        Đang Học
                      </button>
                      <button v-on:click="DoiTrangThai(value)" v-else class="btn status-badge status-inactive">
                        <i class="fas fa-pause-circle"></i>
                        Tạm Nghỉ
                      </button>
                    </td>
                    <td class="text-center">
                      <div class="action-buttons">
                        <button class="btn-action btn-edit" @click="Object.assign(update_hoc_sinh, value)"
                          data-bs-toggle="modal" data-bs-target="#capNhatModal" title="Chỉnh sửa">
                          <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-action btn-delete" @click="Object.assign(delete_hoc_sinh, value)"
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

  <!-- Modal Cập Nhật Học Sinh -->
  <div class="modal fade" id="capNhatModal" tabindex="-1" aria-labelledby="capNhatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="capNhatModalLabel">
            <i class="fas fa-user-edit me-2"></i>
            Cập Nhật Thông Tin Học Sinh
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateHoVaTen" class="form-label">Họ và Tên *</label>
                  <input type="text" class="form-control" id="updateHoVaTen" v-model="update_hoc_sinh.ho_va_ten"
                    required />
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateGioiTinh" class="form-label">Giới Tính *</label>
                  <select class="form-select" id="updateGioiTinh" v-model="update_hoc_sinh.gioi_tinh" required>
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
                  <input type="date" class="form-control" id="updateNgaySinh" v-model="update_hoc_sinh.ngay_sinh"
                    required />
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateLopHoc" class="form-label">Lớp Học *</label>
                  <select class="form-select" id="updateLopHoc" v-model="update_hoc_sinh.lop_hoc" required>
                    <option value="">Chọn lớp học</option>
                    <option value="Lớp Mầm">Lớp Mầm</option>
                    <option value="Lớp Chồi">Lớp Chồi</option>
                    <option value="Lớp Lá">Lớp Lá</option>
                    <option value="Lớp Hoa">Lớp Hoa</option>
                    <option value="Lớp Búp">Lớp Búp</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updatePhuHuynh" class="form-label">Phụ Huynh *</label>
                  <select class="form-select" id="updatePhuHuynh" v-model="update_hoc_sinh.id_phu_huynh" required>
                    <option value="">Chọn phụ huynh</option>
                    <option v-for="ph in list_phu_huynh" :key="ph.id" :value="ph.id">
                      {{ ph.ho_va_ten }} ({{ ph.quan_he }})
                    </option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateNgayNhapHoc" class="form-label">Ngày Nhập Học *</label>
                  <input type="date" class="form-control" id="updateNgayNhapHoc" v-model="update_hoc_sinh.ngay_nhap_hoc"
                    required />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateAvatar" class="form-label">Avatar URL</label>
                  <input type="url" class="form-control" id="updateAvatar" v-model="update_hoc_sinh.avatar"
                    placeholder="https://example.com/avatar.jpg" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateTinhTrang" class="form-label">Tình Trạng</label>
                  <select v-model="update_hoc_sinh.tinh_trang" class="form-select">
                    <option value="1">Đang Học</option>
                    <option value="0">Tạm Nghỉ</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label for="updateGhiChu" class="form-label">Ghi Chú</label>
              <textarea class="form-control" id="updateGhiChu" rows="3" v-model="update_hoc_sinh.ghi_chu"
                placeholder="Ghi chú về học sinh..."></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>
            Hủy
          </button>
          <button type="button" class="btn btn-primary" @click="CapNhatHocSinh" :disabled="loading">
            <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
            <i v-else class="fas fa-save me-1"></i>
            {{ loading ? 'Đang xử lý...' : 'Cập Nhật' }}
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Xóa Học Sinh -->
  <div class="modal fade" id="xoaModal" tabindex="-1" aria-labelledby="xoaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="xoaModalLabel">
            <i class="fas fa-exclamation-triangle me-2 text-warning"></i>
            Xác Nhận Xóa Học Sinh
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="text-center">
            <div class="mb-3">
              <i class="fas fa-user-times text-danger" style="font-size: 3rem;"></i>
            </div>
            <h6>Bạn có chắc chắn muốn xóa học sinh này không?</h6>
            <div class="alert alert-warning" role="alert">
              <strong>Thông tin học sinh:</strong><br>
              <strong>Tên:</strong> {{ delete_hoc_sinh.ho_va_ten }}<br>
              <strong>Lớp:</strong> {{ delete_hoc_sinh.lop_hoc }}<br>
              <strong>Phụ huynh:</strong> {{ delete_hoc_sinh.ten_phu_huynh }}
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
          <button type="button" class="btn btn-danger" @click="XoaHocSinh" :disabled="loading">
            <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
            <i v-else class="fas fa-trash me-1"></i>
            {{ loading ? 'Đang xử lý...' : 'Xóa Học Sinh' }}
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Thêm Học Sinh -->
  <div class="modal fade" id="themModal" tabindex="-1" aria-labelledby="themModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="themModalLabel">
            <i class="fas fa-user-plus me-2"></i>
            Thêm Học Sinh Mới
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="row">
              <div class="col-md-6">
                <label for="hoVaTen" class="form-label">Họ và Tên *</label>
                <input type="text" class="form-control" id="hoVaTen" v-model="create_hoc_sinh.ho_va_ten" required />
              </div>
              <div class="col-md-6">
                <label for="gioiTinh" class="form-label">Giới Tính *</label>
                <select class="form-select" id="gioiTinh" v-model="create_hoc_sinh.gioi_tinh" required>
                  <option value="">Chọn giới tính</option>
                  <option value="1">Nam</option>
                  <option value="0">Nữ</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="ngaySinh" class="form-label">Ngày Sinh *</label>
                <input type="date" class="form-control" id="ngaySinh" v-model="create_hoc_sinh.ngay_sinh" required />
              </div>
              <div class="col-md-6">
                <label for="lopHoc" class="form-label">Lớp Học *</label>
                <select class="form-select" id="lopHoc" v-model="create_hoc_sinh.lop_hoc" required>
                  <option value="">Chọn lớp học</option>
                  <option value="Lớp Mầm">Lớp Mầm</option>
                  <option value="Lớp Chồi">Lớp Chồi</option>
                  <option value="Lớp Lá">Lớp Lá</option>
                  <option value="Lớp Hoa">Lớp Hoa</option>
                  <option value="Lớp Búp">Lớp Búp</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="phuHuynh" class="form-label">Phụ Huynh *</label>
                <select class="form-select" id="phuHuynh" v-model="create_hoc_sinh.id_phu_huynh" required>
                  <option value="">Chọn phụ huynh</option>
                  <option v-for="ph in list_phu_huynh" :key="ph.id" :value="ph.id">
                    {{ ph.ho_va_ten }} ({{ ph.quan_he }})
                  </option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="ngayNhapHoc" class="form-label">Ngày Nhập Học *</label>
                <input type="date" class="form-control" id="ngayNhapHoc" v-model="create_hoc_sinh.ngay_nhap_hoc"
                  required />
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="avatar" class="form-label">Avatar URL</label>
                <input type="url" class="form-control" id="avatar" v-model="create_hoc_sinh.avatar"
                  placeholder="https://example.com/avatar.jpg" />
              </div>
              <div class="col-md-6">
                <label for="tinhTrang" class="form-label">Tình Trạng</label>
                <select v-model="create_hoc_sinh.tinh_trang" class="form-select">
                  <option value="1">Đang Học</option>
                  <option value="0">Tạm Nghỉ</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <label for="ghiChu" class="form-label">Ghi Chú</label>
                <textarea class="form-control" id="ghiChu" rows="3" v-model="create_hoc_sinh.ghi_chu"
                  placeholder="Ghi chú về học sinh..."></textarea>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>
            Hủy
          </button>
          <button type="button" class="btn btn-primary" @click="ThemHocSinh" :disabled="loading">
            <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
            <i v-else class="fas fa-save me-1"></i>
            {{ loading ? 'Đang xử lý...' : 'Thêm Học Sinh' }}
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
      list_hoc_sinh: [],
      list_phu_huynh: [],
      create_hoc_sinh: {
        ho_va_ten: "",
        gioi_tinh: "",
        ngay_sinh: "",
        lop_hoc: "",
        id_phu_huynh: "",
        ngay_nhap_hoc: "",
        avatar: "",
        tinh_trang: "1",
        ghi_chu: "",
      },
      update_hoc_sinh: {
        id: "",
        ho_va_ten: "",
        gioi_tinh: "",
        ngay_sinh: "",
        lop_hoc: "",
        id_phu_huynh: "",
        ngay_nhap_hoc: "",
        avatar: "",
        tinh_trang: "",
        ghi_chu: "",
      },
      delete_hoc_sinh: {
        id: "",
        ho_va_ten: "",
        lop_hoc: "",
        ten_phu_huynh: "",
      },
      search: {
        noi_dung: "",
        tinh_trang: "",
        lop_hoc: "",
      },
      loading: false,
    };
  },

  mounted() {
    this.loadData();
    this.loadPhuHuynh();
  },

  methods: {
    formatDate(dateString) {
      if (!dateString) return "";
      const date = new Date(dateString);
      return date.toLocaleDateString("vi-VN");
    },

    getAge(birthDate) {
      if (!birthDate) return 0;
      const today = new Date();
      const birth = new Date(birthDate);
      let age = today.getFullYear() - birth.getFullYear();
      const monthDiff = today.getMonth() - birth.getMonth();
      if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
        age--;
      }
      return age;
    },

    getStudyDuration(startDate) {
      if (!startDate) return "";
      const today = new Date();
      const start = new Date(startDate);
      const diffTime = Math.abs(today - start);
      const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

      if (diffDays < 30) {
        return `${diffDays} ngày`;
      } else if (diffDays < 365) {
        const months = Math.floor(diffDays / 30);
        return `${months} tháng`;
      } else {
        const years = Math.floor(diffDays / 365);
        return `${years} năm`;
      }
    },

    getUniqueClasses() {
      const classes = new Set();
      this.list_hoc_sinh.forEach((hs) => {
        if (hs.lop_hoc) {
          classes.add(hs.lop_hoc);
        }
      });
      return Array.from(classes);
    },

    loadData() {
      baseRequestAdmin
        .get("admin/hoc-sinh/data")
        .then((res) => {
          if (res.data.status) {
            this.list_hoc_sinh = res.data.data;
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

    loadPhuHuynh() {
      baseRequestAdmin
        .get("admin/phu-huynh/data")
        .then((res) => {
          if (res.data.status) {
            this.list_phu_huynh = res.data.data;
          }
        })
        .catch((err) => {
          console.log("Không thể tải danh sách phụ huynh");
        });
    },

    DoiTrangThai(payload) {
      baseRequestAdmin
        .post("admin/hoc-sinh/change-status", payload)
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

    ThemHocSinh() {
      this.loading = true;
      baseRequestAdmin
        .post("admin/hoc-sinh/create", this.create_hoc_sinh)
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
            this.$toast.error("Có lỗi xảy ra khi thêm học sinh");
          }
        })
        .finally(() => {
          this.loading = false;
        });
    },

    CapNhatHocSinh() {
      this.loading = true;
      baseRequestAdmin
        .post("admin/hoc-sinh/update", this.update_hoc_sinh)
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
            this.$toast.error("Có lỗi xảy ra khi cập nhật học sinh");
          }
        })
        .finally(() => {
          this.loading = false;
        });
    },

    XoaHocSinh() {
      this.loading = true;
      baseRequestAdmin
        .post("admin/hoc-sinh/delete", this.delete_hoc_sinh)
        .then((res) => {
          if (res.data.status) {
            this.$toast.success(res.data.message);
            this.loadData();
            this.delete_hoc_sinh = {};
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
            this.$toast.error("Có lỗi xảy ra khi xóa học sinh");
          }
        })
        .finally(() => {
          this.loading = false;
        });
    },

    TiemKiem() {
      baseRequestAdmin
        .post("admin/hoc-sinh/search", this.search)
        .then((res) => {
          if (res.data.status) {
            this.$toast.success(res.data.message);
            this.list_hoc_sinh = res.data.data;
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
      this.create_hoc_sinh = {
        ho_va_ten: "",
        gioi_tinh: "",
        ngay_sinh: "",
        lop_hoc: "",
        id_phu_huynh: "",
        ngay_nhap_hoc: "",
        avatar: "",
        tinh_trang: "1",
        ghi_chu: "",
      };
    },
  },
};
</script>

<style lang="scss">
@use "./style.scss";
</style>