<template>
  <div class="page-header education-theme">
    <div class="container-fluid">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="page-header-content">
            <div class="page-icon">
              <i class="fas fa-user-shield"></i>
            </div>
            <div class="page-info">
              <h1 class="page-title">Quản lý Phân Quyền</h1>
              <p class="page-subtitle">
                Quản lý vai trò và phân quyền hệ thống
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <nav class="breadcrumb-nav">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <i class="fas fa-school"></i>
                <a href="javascript: void(0);">Hệ thống</a>
              </li>
              <li class="breadcrumb-item active">
                <i class="fas fa-user-shield"></i>
                Phân Quyền
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
          <h3 class="stats-number">{{ list_chuc_vu.length }}</h3>
          <p class="stats-label">Tổng Chức Vụ</p>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="stats-card stats-success">
        <div class="stats-icon">
          <i class="fas fa-check-circle"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">
            {{list_chuc_vu.filter((cv) => cv.tinh_trang === 1).length}}
          </h3>
          <p class="stats-label">Chức Vụ Hoạt Động</p>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="stats-card stats-info">
        <div class="stats-icon">
          <i class="fas fa-cogs"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">{{ list_chuc_nang.length }}</h3>
          <p class="stats-label">Tổng Chức Năng</p>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="stats-card stats-warning">
        <div class="stats-icon">
          <i class="fas fa-shield-alt"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">
            {{ phan_quyen.id ? list_phan_quyen.length : 0 }}
          </h3>
          <p class="stats-label">Quyền Đã Cấp</p>
        </div>
      </div>
    </div>
  </div>

  <!-- 3 Bảng Song Song -->
  <div class="row g-4">
    <!-- Bảng 1: Danh sách Vai Trò -->
    <div class="col-lg-4">
      <div class="management-card permission-table-card">
        <div class="card-header-custom">
          <div class="header-content">
            <div class="header-icon">
              <i class="fas fa-user-shield"></i>
            </div>
            <div class="header-text">
              <h5 class="card-title">Danh Sách Vai Trò</h5>
              <p class="card-subtitle">{{ list_chuc_vu.length }} vai trò</p>
            </div>
          </div>
          <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#themModal">
            <i class="fas fa-plus"></i>
          </button>
        </div>
        <div class="card-body">
          <div class="table-container-no-scroll">
            <table class="table table-modern">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th>Vai Trò</th>
                  <th class="text-center">Trạng Thái</th>
                  <th class="text-center">Thao Tác</th>
                </tr>
              </thead>
              <tbody>
                <template v-for="(value, index) in list_chuc_vu" :key="index">
                  <tr v-on:click="Object.assign(phan_quyen, value), loadPhanQuyen(value)" class="table-row-hover"
                    :class="{ 'table-row-selected': phan_quyen?.id === value.id }">
                    <td class="text-center table-index">{{ index + 1 }}</td>
                    <td>
                      <div class="d-flex align-items-center">
                        <i class="fas fa-user-tie me-2 text-primary"></i>
                        <span class="fw-semibold">{{ value.ten_chuc_vu }}</span>
                      </div>
                      <small class="text-muted d-block">{{ value.mo_ta }}</small>
                    </td>
                    <td class="text-center">
                      <button v-on:click="DoiTrangThai(value)" v-if="value.tinh_trang == 1"
                        class="btn btn-success btn-sm status-active">
                        <i class="fas fa-check-circle"></i>
                      </button>
                      <button v-on:click="DoiTrangThai(value)" v-else class="btn btn-danger btn-sm status-inactive">
                        <i class="fas fa-pause-circle"></i>
                      </button>
                    </td>
                    <td class="text-center">
                      <div class="action-buttons">
                        <button class="btn-action btn-edit" data-bs-toggle="modal" data-bs-target="#capNhatModal"
                          @click.stop="Object.assign(update_chuc_vu, value)" title="Chỉnh sửa">
                          <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-action btn-delete" data-bs-toggle="modal" data-bs-target="#xoaModal"
                          @click.stop="Object.assign(delete_chuc_vu, value)" title="Xóa">
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

    <!-- Bảng 2: Danh sách Chức Năng -->
    <div class="col-lg-4">
      <div class="management-card permission-table-card">
        <div class="card-header-custom">
          <div class="header-content">
            <div class="header-icon">
              <i class="fas fa-list-check"></i>
            </div>
            <div class="header-text">
              <h5 class="card-title">Danh Sách Chức Năng</h5>
              <p class="card-subtitle">{{ list_chuc_nang.length }} chức năng</p>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="function-list-container">
            <div v-for="func in list_chuc_nang" :key="func.id" class="function-item-card"
              :class="{ 'function-granted-card': isPhanQuyenGranted(func.id) }">
              <div class="function-item-content">
                <div class="function-name">
                  <i v-if="func.nhom_chuc_nang === 'quan_ly'" class="fas fa-cogs me-2 text-primary"></i>
                  <i v-else-if="func.nhom_chuc_nang === 'giang_day'" class="fas fa-chalkboard me-2 text-success"></i>
                  <i v-else-if="func.nhom_chuc_nang === 'hoc_tap'" class="fas fa-book-open me-2 text-info"></i>
                  <i v-else class="fas fa-puzzle-piece me-2 text-secondary"></i>
                  <span class="fw-semibold">{{ func.ten_chuc_nang }}</span>
                </div>
                <div class="function-description">{{ func.mo_ta }}</div>
              </div>
              <div class="function-item-action">
                <button v-if="phan_quyen.id && !isPhanQuyenGranted(func.id)" @click="PhanQuyen(func)"
                  class="btn btn-success btn-sm btn-plus" title="Cấp quyền">
                  <i class="fas fa-plus"></i>
                </button>
                <span v-else-if="isPhanQuyenGranted(func.id)" class="text-success">
                  <i class="fas fa-check-circle"></i>
                </span>
                <span v-else class="text-muted">
                  <i class="fas fa-lock"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bảng 3: Cấp Chức Năng Cho Vai Trò -->
    <div class="col-lg-4">
      <div class="management-card permission-table-card">
        <div class="card-header-custom">
          <div class="header-content">
            <div class="header-icon">
              <i class="fas fa-shield-check"></i>
            </div>
            <div class="header-text">
              <h5 class="card-title">Quyền Đã Cấp</h5>
              <p class="card-subtitle" v-if="phan_quyen.id">
                {{ list_phan_quyen.length }} quyền cho {{ phan_quyen.ten_chuc_vu }}
              </p>
              <p class="card-subtitle text-warning" v-else>
                Chọn vai trò để xem quyền
              </p>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div v-if="!phan_quyen.id" class="empty-permissions">
            <div class="empty-icon">
              <i class="fas fa-shield-alt"></i>
            </div>
            <h6 class="empty-title">Chưa chọn vai trò</h6>
            <p class="empty-description">
              Vui lòng chọn một vai trò từ bảng bên trái để xem và quản lý quyền
            </p>
          </div>
          <div v-else>
            <div class="granted-list-container">
              <template v-for="(item, index) in list_phan_quyen" :key="index">
                <div class="granted-item-card">
                  <div class="granted-item-content">
                    <div class="granted-name">
                      <span class="fw-semibold">{{ item.ten_chuc_nang }}</span>
                    </div>
                    <div class="granted-description">{{ item.mo_ta }}</div>
                  </div>
                  <div class="granted-item-action">
                    <button @click="XoaPhanQuyen(item)" class="btn btn-danger btn-sm btn-remove" title="Xóa quyền">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
              </template>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Thêm Chức Vụ -->
  <div class="modal fade" id="themModal" tabindex="-1" aria-labelledby="themModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="themModalLabel">
            <i class="fas fa-user-plus me-2"></i>
            Thêm Chức Vụ Mới
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="row">
              <div class="col-md-6">
                <label for="tenChucVu" class="form-label">Tên Chức Vụ *</label>
                <input type="text" class="form-control" id="tenChucVu" v-model="create_chuc_vu.ten_chuc_vu"
                  placeholder="Nhập tên chức vụ" required />
              </div>
              <div class="col-md-6">
                <label for="loaiVaiTro" class="form-label">Loại Vai Trò *</label>
                <select class="form-select" id="loaiVaiTro" v-model="create_chuc_vu.loai_vai_tro" required>
                  <option value="" selected>Chọn loại vai trò</option>
                  <option value="1">Quản Lý</option>
                  <option value="2">Giáo Viên</option>
                  <option value="3">Y Tế</option>
                  <option value="4">Nhân Viên</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="slugChucVu" class="form-label">Slug Chức Vụ</label>
                <input type="text" class="form-control" id="slugChucVu" v-model="create_chuc_vu.slug_chuc_vu"
                  placeholder="Tự động tạo nếu để trống" />
              </div>
              <div class="col-md-6">
                <label for="tinhTrang" class="form-label">Tình Trạng</label>
                <select v-model="create_chuc_vu.tinh_trang" class="form-select">
                  <option value="1">Hoạt Động</option>
                  <option value="0">Tạm Ngừng</option>
                </select>
              </div>
            </div>
            <div class="mb-3">
              <label for="moTa" class="form-label">Mô Tả *</label>
              <textarea placeholder="Nhập mô tả chức vụ" class="form-control" id="moTa" rows="3"
                v-model="create_chuc_vu.mo_ta" required></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>
            Hủy
          </button>
          <button type="button" class="btn btn-primary" @click="ThemChucVu" :disabled="loading">
            <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
            <i v-else class="fas fa-save me-1"></i>
            {{ loading ? 'Đang xử lý...' : 'Thêm Chức Vụ' }}
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Cập Nhật Chức Vụ -->
  <div class="modal fade" id="capNhatModal" tabindex="-1" aria-labelledby="capNhatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="capNhatModalLabel">
            <i class="fas fa-user-edit me-2"></i>
            Cập Nhật Thông Tin Chức Vụ
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateTenChucVu" class="form-label">Tên Chức Vụ *</label>
                  <input type="text" class="form-control" id="updateTenChucVu" v-model="update_chuc_vu.ten_chuc_vu"
                    required />
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateLoaiVaiTro" class="form-label">Loại Vai Trò *</label>
                  <select class="form-select" id="updateLoaiVaiTro" v-model="update_chuc_vu.loai_chuc_vu" required>
                    <option value="1">Quản Lý</option>
                    <option value="2">Giáo Viên</option>
                    <option value="3">Y Tế</option>
                    <option value="4">Nhân Viên</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateSlugChucVu" class="form-label">Slug Chức Vụ</label>
                  <input type="text" class="form-control" id="updateSlugChucVu" v-model="update_chuc_vu.slug_chuc_vu" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateTinhTrang" class="form-label">Tình Trạng</label>
                  <select v-model="update_chuc_vu.tinh_trang" class="form-select">
                    <option value="1">Hoạt Động</option>
                    <option value="0">Tạm Ngừng</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label for="updateMoTa" class="form-label">Mô Tả *</label>
              <textarea class="form-control" id="updateMoTa" rows="3" v-model="update_chuc_vu.mo_ta"
                required></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>
            Hủy
          </button>
          <button type="button" class="btn btn-primary" @click="CapNhatChucVu" :disabled="loading">
            <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
            <i v-else class="fas fa-save me-1"></i>
            {{ loading ? 'Đang xử lý...' : 'Cập Nhật' }}
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Xóa Chức Vụ -->
  <div class="modal fade" id="xoaModal" tabindex="-1" aria-labelledby="xoaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="xoaModalLabel">
            <i class="fas fa-exclamation-triangle me-2 text-warning"></i>
            Xác Nhận Xóa Chức Vụ
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="text-center">
            <div class="mb-3">
              <i class="fas fa-user-times text-danger" style="font-size: 3rem;"></i>
            </div>
            <h6>Bạn có chắc chắn muốn xóa chức vụ này không?</h6>
            <div class="alert alert-warning" role="alert">
              <strong>Thông tin chức vụ:</strong><br>
              <strong>Tên:</strong> {{ delete_chuc_vu.ten_chuc_vu }}<br>
              <strong>Loại:</strong> {{ delete_chuc_vu.loai_chuc_vu }}<br>
              <strong>Mô tả:</strong> {{ delete_chuc_vu.mo_ta }}
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
          <button type="button" class="btn btn-danger" @click="XoaChucVu" :disabled="loading">
            <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
            <i v-else class="fas fa-trash me-1"></i>
            {{ loading ? 'Đang xử lý...' : 'Xóa Chức Vụ' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import baseRequestAdmin from "../../../core/baseRequestAdmin";

export default {
  data() {
    return {
      list_chuc_nang: [],
      list_chuc_vu: [],
      create_chuc_vu: {
        ten_chuc_vu: "",
        mo_ta: "",
        loai_chuc_vu: "",
        slug_chuc_vu: "",
        tinh_trang: "1",
      },
      update_chuc_vu: {
        id: "",
        ten_chuc_vu: "",
        mo_ta: "",
        loai_chuc_vu: "",
        slug_chuc_vu: "",
        tinh_trang: "",
      },
      delete_chuc_vu: {
        id: "",
        ten_chuc_vu: "",
        mo_ta: "",
        loai_chuc_vu: "",
      },
      search: {
        noi_dung: "",
        loai_vai_tro: "",
      },
      list_phan_quyen: [],
      phan_quyen: {},
      loading: false,
    };
  },


  mounted() {
    this.loadData();
  },

  methods: {
    loadData() {
      baseRequestAdmin
        .get("admin/chuc-vu/data")
        .then((res) => {
          if (res.data.status) {
            this.list_chuc_vu = res.data.data;
            this.$toast.success(res.data.message);
          } else {
            this.$toast.error(res.data.message);
          }
        })
        .catch((res) => {
          const list = Object.values(res.response.data.errors);
          list.forEach((v, i) => {
            this.$toast.error(v[0]);
          })
        });

      baseRequestAdmin
        .get("admin/chuc-nang/data")
        .then((res) => {
          if (res.data.status) {
            this.list_chuc_nang = res.data.data;
          }
        })
        .catch((res) => {
          const list = Object.values(res.response.data.errors);
          list.forEach((v, i) => {
            this.$toast.error(v[0]);
          })
        });
    },

    TiemKiem() {
      baseRequestAdmin
        .post("admin/chuc-vu/search", this.search)
        .then((res) => {
          if (res.data.status) {
            this.list_chuc_vu = res.data.data;
          } else {
            this.$toast.error(res.data.message);
          }
        })
        .catch((res) => {
          const list = Object.values(res.response.data.errors);
          list.forEach((v, i) => {
            this.$toast.error(v[0]);
          })
        });
    },

    DoiTrangThai(payload) {
      baseRequestAdmin
        .post("admin/chuc-vu/change-status", payload)
        .then((res) => {
          if (res.data.status) {
            this.$toast.success(res.data.message);
            this.loadData();
          } else {
            this.$toast.error(res.data.message);
          }
        })
        .catch((res) => {
          const list = Object.values(res.response.data.errors);
          list.forEach((v, i) => {
            this.$toast.error(v[0]);
          })
        });
    },

    isPhanQuyenGranted(functionId) {
      return this.list_phan_quyen.some((p) => p.id_chuc_nang === functionId);
    },

    ThemChucVu() {
      this.loading = true;
      baseRequestAdmin
        .post("admin/chuc-vu/create", this.create_chuc_vu)
        .then((res) => {
          if (res.data.status) {
            this.$toast.success(res.data.message);
            this.loadData();
            this.resetCreateForm();
            const modal = bootstrap.Modal.getInstance(document.getElementById("themModal"));
            if (modal) modal.hide();
          } else {
            this.$toast.error(res.data.message);
          }
        })
        .catch((res) => {
          const list = Object.values(res.response.data.errors);
          list.forEach((v, i) => {
            this.$toast.error(v[0]);
          })
        })
        .finally(() => {
          this.loading = false;
        });
    },

    CapNhatChucVu() {
      this.loading = true;
      baseRequestAdmin
        .post("admin/chuc-vu/update", this.update_chuc_vu)
        .then((res) => {
          if (res.data.status) {
            this.$toast.success(res.data.message);
            this.loadData();
            const modal = bootstrap.Modal.getInstance(document.getElementById("capNhatModal"));
            if (modal) modal.hide();
          } else {
            this.$toast.error(res.data.message);
          }
        })
        .catch((res) => {
          const list = Object.values(res.response.data.errors);
          list.forEach((v, i) => {
            this.$toast.error(v[0]);
          })
        })
        .finally(() => {
          this.loading = false;
        });
    },

    XoaChucVu() {
      this.loading = true;
      baseRequestAdmin
        .post("admin/chuc-vu/delete", this.delete_chuc_vu)
        .then((res) => {
          if (res.data.status) {
            this.$toast.success(res.data.message);
            this.loadData();
            this.delete_chuc_vu = {};
            const modal = bootstrap.Modal.getInstance(document.getElementById("xoaModal"));
            if (modal) modal.hide();
          } else {
            this.$toast.error(res.data.message);
          }
        })
        .catch((res) => {
          const list = Object.values(res.response.data.errors);
          list.forEach((v, i) => {
            this.$toast.error(v[0]);
          })
        })
        .finally(() => {
          this.loading = false;
        });
    },
    loadPhanQuyen(value) {
      baseRequestAdmin
        .post(`admin/phan-quyen/data`, value)
        .then((res) => {
          if (res.data.status) {
            this.list_phan_quyen = res.data.data;
          }
        })
        .catch((res) => {
          const list = Object.values(res.response.data.errors);
          list.forEach((v, i) => {
            this.$toast.error(v[0]);
          })
        })
    },
    PhanQuyen(func) {
      if (!this.phan_quyen.id) {
        this.$toast.warning("Vui lòng chọn vai trò trước!");
        return;
      }
      const payload = {
        id_chuc_vu: this.phan_quyen.id,
        id_chuc_nang: func.id,
      };
      baseRequestAdmin
        .post("admin/phan-quyen/create", payload)
        .then((res) => {
          if (res.data.status) {
            this.$toast.success(res.data.message);
            this.loadPhanQuyen(this.phan_quyen);
          } else {
            this.$toast.error(res.data.message);
          }
        })
        .catch((res) => {
          const list = Object.values(res.response.data.errors);
          list.forEach((v, i) => {
            this.$toast.error(v[0]);
          })
        })
    },
    XoaPhanQuyen(payload) {
      baseRequestAdmin
        .post("admin/phan-quyen/delete", payload)
        .then((res) => {
          if (res.data.status) {
            this.$toast.success(res.data.message);
            this.loadPhanQuyen(this.phan_quyen);
          } else {
            this.$toast.error(res.data.message);
          }
        })
        .catch((res) => {
          const list = Object.values(res.response.data.errors);
          list.forEach((v, i) => {
            this.$toast.error(v[0]);
          })
        })
    },

    resetCreateForm() {
      this.create_chuc_vu = {
        ten_chuc_vu: "",
        mo_ta: "",
        loai_vai_tro: "",
        slug_chuc_vu: "",
        tinh_trang: "1",
      };
    },
  },
};
</script>

<style lang="scss">
@use "./style.scss";
</style>
