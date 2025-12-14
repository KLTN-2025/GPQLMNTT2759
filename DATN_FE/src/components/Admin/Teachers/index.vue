<template>
  <div class="page-header education-theme">
    <div class="container-fluid">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="page-header-content">
            <div class="page-icon">
              <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="page-info">
              <h1 class="page-title">Quản lý Giáo Viên</h1>
              <p class="page-subtitle">
                Quản lý thông tin giáo viên trong hệ thống
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
                <i class="fas fa-chalkboard-teacher"></i>
                Giáo Viên
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
          <i class="fas fa-chalkboard-teacher"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">{{ list_giao_vien.length }}</h3>
          <p class="stats-label">Tổng Giáo Viên</p>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="stats-card stats-success">
        <div class="stats-icon">
          <i class="fas fa-user-check"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">{{ activeTeacherCount }}</h3>
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
          <h3 class="stats-number">{{ inactiveTeacherCount }}</h3>
          <p class="stats-label">Tạm Ngừng</p>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="stats-card stats-info">
        <div class="stats-icon">
          <i class="fas fa-mars"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">{{ maleTeacherCount }}</h3>
          <p class="stats-label">Giáo Viên Nam</p>
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
              <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div class="header-text">
              <h5 class="card-title">Danh Sách Giáo Viên</h5>
              <p class="card-subtitle">Quản lý thông tin giáo viên hệ thống</p>
            </div>
          </div>
          <div class="header-actions">
            <button class="btn btn-outline-success btn-sm me-2" @click="exportTeachersExcel">
              <i class="fas fa-file-excel"></i> Xuất Excel
            </button>
            <button class="btn btn-primary btn-modern" data-bs-toggle="modal" data-bs-target="#themModal">
              <i class="fas fa-user-plus"></i>
              Thêm Giáo Viên
            </button>
          </div>
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
                <select v-on:change="TiemKiem()" class="filter-select" v-model="search.chuc_vu">
                  <option value="">Tất cả chức vụ</option>
                  <option value="Giáo viên">Giáo viên</option>
                  <option value="Giáo viên chính">Giáo viên chính</option>
                  <option value="Trưởng nhóm">Trưởng nhóm</option>
                  <option value="Giáo viên phụ tá">Giáo viên phụ tá</option>
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
                    <th>Giáo Viên</th>
                    <th class="text-center">Liên Hệ</th>
                    <th class="text-center">Thông Tin</th>
                    <th class="text-center">Chức Vụ</th>
                    <th class="text-center">Lớp Phụ Trách</th>
                    <th class="text-center">Trạng Thái</th>
                    <th class="text-center">Thao Tác</th>
                  </tr>
                </thead>
                <tbody>
                  <template v-for="(value, index) in list_giao_vien" :key="index">
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
                            <i :class="genderDescriptor(value.gioi_tinh).icon"></i>
                            <span>{{ genderDescriptor(value.gioi_tinh).label }}</span>
                          </div>
                          <div class="info-item">
                            <i class="fas fa-birthday-cake"></i>
                            <span>{{ formatDate(value.ngay_sinh) }}</span>
                          </div>
                          <div class="info-item">
                            <i class="fas fa-calendar-alt"></i>
                            <span>{{ formatDate(value.ngay_vao_lam) }}</span>
                          </div>
                        </div>
                      </td>
                      <td class="text-center">
                        <span class="position-badge">
                          <i class="fas fa-chalkboard-teacher"></i>
                          {{ value.ten_chuc_vu }}
                        </span>
                      </td>
                      <td class="text-center">
                        <div class="class-tags" v-if="value.ten_lop">
                          <button v-for="className in value.ten_lop.split(', ')" :key="className" class="class-tag">
                            {{ className }}
                          </button>
                        </div>
                        <span v-else class="text-muted">Chưa phân lớp</span>
                      </td>
                      <td class="text-center">
                        <button @click="DoiTrangThai(value)" class="btn btn-sm"
                          :class="[statusDescriptor(value.tinh_trang).buttonClass, statusDescriptor(value.tinh_trang).statusClass]">
                          <i :class="statusDescriptor(value.tinh_trang).icon"></i>
                          {{ statusDescriptor(value.tinh_trang).label }}
                        </button>
                      </td>
                      <td class="text-center">
                        <div class="action-buttons">
                          <button class="btn-action btn-edit" @click="Object.assign(update_giao_vien, value)"
                            data-bs-toggle="modal" data-bs-target="#capNhatModal" title="Chỉnh sửa">
                            <i class="fas fa-edit"></i>
                          </button>
                          <button class="btn-action btn-delete" @click="Object.assign(delete_giao_vien, value)"
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
  <!-- Modal Thêm Giáo Viên -->
  <div class="modal fade" id="themModal" tabindex="-1" aria-labelledby="themModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="themModalLabel">
            <i class="fas fa-user-plus me-2"></i>
            Thêm Giáo Viên Mới
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="row">
              <div class="col-md-6">
                <label for="hoVaTen" class="form-label">Họ và Tên *</label>
                <input type="text" class="form-control" id="hoVaTen" v-model="create_giao_vien.ho_va_ten" required />
              </div>
              <div class="col-md-6">
                <label for="email" class="form-label">Email *</label>
                <input type="email" class="form-control" id="email" v-model="create_giao_vien.email" required />
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="soDienThoai" class="form-label">Số Điện Thoại *</label>
                <input type="tel" class="form-control" id="soDienThoai" v-model="create_giao_vien.so_dien_thoai"
                  required />
              </div>
              <div class="col-md-6">
                <label for="gioiTinh" class="form-label">Giới Tính *</label>
                <select class="form-select" id="gioiTinh" v-model="create_giao_vien.gioi_tinh" required>
                  <option value="">Chọn giới tính</option>
                  <option value="1">Nam</option>
                  <option value="0">Nữ</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="ngaySinh" class="form-label">Ngày Sinh *</label>
                <input type="date" class="form-control" id="ngaySinh" v-model="create_giao_vien.ngay_sinh" required />
              </div>
              <div class="col-md-6">
                <label for="chucVu" class="form-label">Trình Độ *</label>
                <select class="form-select" id="chucVu" v-model="create_giao_vien.trinh_do" placeholder="Chọn trình độ"
                  required>
                  <option value="">Chọn trình độ</option>
                  <option value="0">Trung cấp</option>
                  <option value="1">Cao đẳng</option>
                  <option value="2">Đại học</option>
                  <option value="3">Thạc sĩ</option>
                  <option value="4">Tiến sĩ</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="avatar" class="form-label">Avatar URL</label>
                <input type="url" class="form-control" id="avatar" v-model="create_giao_vien.avatar"
                  placeholder="https://example.com/avatar.jpg" />
              </div>
              <div class="col-md-6">
                <label for="tinhTrang" class="form-label">Tình Trạng</label>
                <select v-model="create_giao_vien.tinh_trang" class="form-select">
                  <option value="1">Hoạt Động</option>
                  <option value="0">Tạm Ngừng</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <label for="kyNang" class="form-label">Kỹ Năng Chuyên Môn</label>
                <div class="skill-checkboxes">
                  <div class="form-check form-check-inline" v-for="skill in availableSkills" :key="skill">
                    <input class="form-check-input" type="checkbox" :value="skill" v-model="create_giao_vien.ky_nang" />
                    <label class="form-check-label">{{ skill }}</label>
                  </div>
                </div>
              </div>
            </div>
            <label for="diaChi" class="form-label">Địa Chỉ *</label>
            <textarea class="form-control" id="diaChi" rows="3" v-model="create_giao_vien.dia_chi" required></textarea>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>
            Hủy
          </button>
          <button type="button" class="btn btn-primary" @click="ThemGiaoVien" :disabled="loading">
            <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
            <i v-else class="fas fa-save me-1"></i>
            {{ loading ? 'Đang xử lý...' : 'Thêm Giáo Viên' }}
          </button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Cập Nhật Giáo Viên -->
  <div class="modal fade" id="capNhatModal" tabindex="-1" aria-labelledby="capNhatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="capNhatModalLabel">
            <i class="fas fa-user-edit me-2"></i>
            Cập Nhật Thông Tin Giáo Viên
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateHoVaTen" class="form-label">Họ và Tên *</label>
                  <input type="text" class="form-control" id="updateHoVaTen" v-model="update_giao_vien.ho_va_ten"
                    required />
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateEmail" class="form-label">Email *</label>
                  <input type="email" class="form-control" id="updateEmail" v-model="update_giao_vien.email" required />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateSoDienThoai" class="form-label">Số Điện Thoại *</label>
                  <input type="tel" class="form-control" id="updateSoDienThoai" v-model="update_giao_vien.so_dien_thoai"
                    required />
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateGioiTinh" class="form-label">Giới Tính *</label>
                  <select class="form-select" id="updateGioiTinh" v-model="update_giao_vien.gioi_tinh" required>
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
                  <input type="date" class="form-control" id="updateNgaySinh" v-model="update_giao_vien.ngay_sinh"
                    required />
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateChucVu" class="form-label">Trình Độ *</label>
                  <select class="form-select" id="updateChucVu" v-model="update_giao_vien.trinh_do" required>
                    <option value="">Chọn trình độ</option>
                    <option value="0">Trung cấp</option>
                    <option value="1">Cao đẳng</option>
                    <option value="2">Đại học</option>
                    <option value="3">Thạc sĩ</option>
                    <option value="4">Tiến sĩ</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateAvatar" class="form-label">Avatar URL</label>
                  <input type="url" class="form-control" id="updateAvatar" v-model="update_giao_vien.avatar"
                    placeholder="https://example.com/avatar.jpg" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateTinhTrang" class="form-label">Tình Trạng</label>
                  <select v-model="update_giao_vien.tinh_trang" class="form-select">
                    <option value="1">Hoạt Động</option>
                    <option value="0">Tạm Ngừng</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="mb-3">
                  <label for="updateKyNang" class="form-label">Kỹ Năng Chuyên Môn</label>
                  <div class="skill-checkboxes">
                    <div class="form-check form-check-inline" v-for="skill in availableSkills" :key="skill">
                      <input class="form-check-input" type="checkbox" :value="skill"
                        v-model="update_giao_vien.ky_nang" />
                      <label class="form-check-label">{{ skill }}</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label for="updateDiaChi" class="form-label">Địa Chỉ *</label>
              <textarea class="form-control" id="updateDiaChi" rows="3" v-model="update_giao_vien.dia_chi"
                required></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>
            Hủy
          </button>
          <button type="button" class="btn btn-primary" @click="CapNhatGiaoVien" :disabled="loading">
            <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
            <i v-else class="fas fa-save me-1"></i>
            {{ loading ? 'Đang xử lý...' : 'Cập Nhật' }}
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Xóa Giáo Viên -->
  <div class="modal fade" id="xoaModal" tabindex="-1" aria-labelledby="xoaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="xoaModalLabel">
            <i class="fas fa-exclamation-triangle me-2 text-warning"></i>
            Xác Nhận Xóa Giáo Viên
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="text-center">
            <div class="mb-3">
              <i class="fas fa-user-times text-danger" style="font-size: 3rem;"></i>
            </div>
            <h6>Bạn có chắc chắn muốn xóa giáo viên này không?</h6>
            <div class="alert alert-warning" role="alert">
              <strong>Thông tin giáo viên:</strong><br>
              <strong>Tên:</strong> {{ delete_giao_vien.ho_va_ten }}<br>
              <strong>Email:</strong> {{ delete_giao_vien.email }}<br>
              <strong>Chức vụ:</strong> {{ delete_giao_vien.chuc_vu }}
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
          <button type="button" class="btn btn-danger" @click="XoaGiaoVien" :disabled="loading">
            <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
            <i v-else class="fas fa-trash me-1"></i>
            {{ loading ? 'Đang xử lý...' : 'Xóa Giáo Viên' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import baseRequestAdmin from "../../../core/baseRequestAdmin";
import { ExcelExportMixin } from '../../../mixins/ExcelExportMixin';

export default {
  mixins: [ExcelExportMixin],
  data() {
    return {
      list_giao_vien: [],
      create_giao_vien: {
        ho_va_ten: "",
        email: "",
        so_dien_thoai: "",
        gioi_tinh: "",
        ngay_sinh: "",
        chuc_vu: "",
        lop_phu_trach: "",
        ngay_vao_lam: "",
        dia_chi: "",
        avatar: "",
        tinh_trang: "1",
        ky_nang: [],
      },
      update_giao_vien: {
        id: "",
        ho_va_ten: "",
        email: "",
        so_dien_thoai: "",
        gioi_tinh: "",
        ngay_sinh: "",
        chuc_vu: "",
        lop_phu_trach: "",
        ngay_vao_lam: "",
        dia_chi: "",
        tinh_trang: "",
        avatar: "",
        ky_nang: [],
      },
      delete_giao_vien: {
        id: "",
        ho_va_ten: "",
        email: "",
        chuc_vu: "",
      },
      search: {
        noi_dung: "",
        tinh_trang: "",
        chuc_vu: "",
      },
      loading: false,
      availableSkills: [
        "Ngôn ngữ & Giao tiếp",
        "Toán học & Logic",
        "Kỹ năng sống",
        "Âm nhạc & Vận động",
        "Tạo hình & Thủ công",
        "Khám phá thiên nhiên",
        "Quản lý",
      ],
    };
  },

  computed: {
    activeTeacherCount() {
      return this.list_giao_vien.filter((gv) => Number(gv.tinh_trang) === 1).length;
    },
    inactiveTeacherCount() {
      return this.list_giao_vien.filter((gv) => Number(gv.tinh_trang) === 0).length;
    },
    maleTeacherCount() {
      return this.list_giao_vien.filter((gv) => Number(gv.gioi_tinh) === 1).length;
    },
    uniqueClasses() {
      const classes = new Set();
      this.list_giao_vien.forEach((gv) => {
        if (gv.lop_phu_trach) {
          gv.lop_phu_trach.split(",").forEach((className) => {
            const trimmed = className.trim();
            if (trimmed) {
              classes.add(trimmed);
            }
          });
        }
      });
      return Array.from(classes);
    },
    genderDescriptor() {
      const meta = {
        1: { label: "Nam", icon: "fas fa-mars text-primary" },
        0: { label: "Nữ", icon: "fas fa-venus text-danger" },
      };
      return (gender) => meta[Number(gender)] || meta[0];
    },
    statusDescriptor() {
      const meta = {
        1: { label: "Hoạt Động", icon: "fas fa-check-circle", buttonClass: "btn-success", statusClass: "status-active" },
        0: { label: "Tạm Ngừng", icon: "fas fa-pause-circle", buttonClass: "btn-danger", statusClass: "status-inactive" },
      };
      return (status) => meta[Number(status)] || meta[0];
    },
  },

  mounted() {
    this.loadData();
  },

  methods: {
    exportTeachersExcel() {
      const columns = [
        { header: 'Họ và Tên', value: 'ho_va_ten', width: 25 },
        { header: 'Ngày Sinh', value: (item) => this.formatDate(item.ngay_sinh), width: 15 },
        { header: 'Giới Tính', value: (item) => item.gioi_tinh == 1 ? 'Nam' : 'Nữ', width: 12 },
        { header: 'Số Điện Thoại', value: 'so_dien_thoai', width: 15 },
        { header: 'Email', value: 'email', width: 30 },
        { header: 'Chức Vụ', value: 'ten_chuc_vu', width: 20 },
        { header: 'Lớp Phụ Trách', value: 'ten_lop', width: 25 },
        { header: 'Ngày Vào Làm', value: (item) => this.formatDate(item.ngay_vao_lam), width: 15 },
        { header: 'Trạng Thái', value: (item) => item.tinh_trang == 1 ? 'Đang dạy' : 'Nghỉ việc', width: 15 }
      ];

      this.exportToExcel(this.list_giao_vien, columns, 'danh-sach-giao-vien');
    },

    formatDate(dateString) {
      if (!dateString) return "";
      const date = new Date(dateString);
      return date.toLocaleDateString("vi-VN");
    },

    loadData() {
      baseRequestAdmin
        .get("admin/giao-vien/data")
        .then((res) => {
          if (res.data.status) {
            this.list_giao_vien = res.data.data;
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
        .post("admin/giao-vien/change-status", payload)
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

    ThemGiaoVien() {
      this.loading = true;
      baseRequestAdmin
        .post("admin/giao-vien/create", this.create_giao_vien)
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
            this.$toast.error("Có lỗi xảy ra khi thêm giáo viên");
          }
        })
        .finally(() => {
          this.loading = false;
        });
    },

    CapNhatGiaoVien() {
      this.loading = true;
      baseRequestAdmin
        .post("admin/giao-vien/update", this.update_giao_vien)
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
            this.$toast.error("Có lỗi xảy ra khi cập nhật giáo viên");
          }
        })
        .finally(() => {
          this.loading = false;
        });
    },

    XoaGiaoVien() {
      this.loading = true;
      baseRequestAdmin
        .post("admin/giao-vien/delete", this.delete_giao_vien)
        .then((res) => {
          if (res.data.status) {
            this.$toast.success(res.data.message);
            this.loadData();
            this.delete_giao_vien = {};
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
            this.$toast.error("Có lỗi xảy ra khi xóa giáo viên");
          }
        })
        .finally(() => {
          this.loading = false;
        });
    },

    TiemKiem() {
      baseRequestAdmin
        .post("admin/giao-vien/search", this.search)
        .then((res) => {
          if (res.data.status) {
            this.$toast.success(res.data.message);
            this.list_giao_vien = res.data.data;
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
      this.create_giao_vien = {
        ho_va_ten: "",
        email: "",
        so_dien_thoai: "",
        gioi_tinh: "",
        ngay_sinh: "",
        chuc_vu: "",
        lop_phu_trach: "",
        ngay_vao_lam: "",
        dia_chi: "",
        avatar: "",
        tinh_trang: "1",
        ky_nang: [],
      };
    },
  },
};
</script>

<style lang="scss">
@use "./style.scss";
</style>
