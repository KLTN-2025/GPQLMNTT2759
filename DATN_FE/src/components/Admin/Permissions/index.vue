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
          <i class="fas fa-user-tie"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">
            {{list_chuc_vu.filter((cv) => cv.loai_vai_tro === "nhan_vien").length}}
          </h3>
          <p class="stats-label">Nhân Viên</p>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="stats-card stats-success">
        <div class="stats-icon">
          <i class="fas fa-chalkboard-teacher"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">
            {{list_chuc_vu.filter((cv) => cv.loai_vai_tro === "giao_vien").length}}
          </h3>
          <p class="stats-label">Giáo Viên</p>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="stats-card stats-info">
        <div class="stats-icon">
          <i class="fas fa-user-graduate"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">
            {{list_chuc_vu.filter((cv) => cv.loai_vai_tro === "hoc_sinh").length}}
          </h3>
          <p class="stats-label">Học Sinh</p>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="stats-card stats-warning">
        <div class="stats-icon">
          <i class="fas fa-cogs"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">{{ list_chuc_nang.length }}</h3>
          <p class="stats-label">Chức Năng</p>
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
              <i class="fas fa-user-shield"></i>
            </div>
            <div class="header-text">
              <h5 class="card-title">Danh Sách Vai Trò</h5>
              <p class="card-subtitle">Quản lý vai trò và quyền truy cập</p>
            </div>
          </div>
          <button class="btn btn-primary btn-modern" data-bs-toggle="modal" data-bs-target="#themModal">
            <i class="fas fa-plus"></i>
            Thêm Vai Trò
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
                  placeholder="Tìm kiếm vai trò..." />
              </div>

              <div class="search-filters">
                <select v-on:change="TiemKiem()" class="filter-select" v-model="search.loai_vai_tro">
                  <option value="">Tất cả loại</option>
                  <option value="nhan_vien">Nhân viên</option>
                  <option value="giao_vien">Giáo viên</option>
                  <option value="hoc_sinh">Học sinh</option>
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
                    <th>Vai Trò</th>
                    <th class="text-center">Loại</th>
                    <th class="text-center">Mô Tả</th>
                    <th class="text-center">Trạng Thái</th>
                    <th class="text-center">Thao Tác</th>
                  </tr>
                </thead>
                <tbody>
                  <template v-for="(value, index) in list_chuc_vu" :key="index">
                    <tr class="table-row-hover">
                      <td class="text-center table-index">
                        {{ index + 1 }}
                      </td>
                      <td class="employee-info">
                        <div class="employee-container">
                          <div class="employee-avatar">
                            <i class="fas fa-user-tie"></i>
                          </div>
                          <div class="employee-details">
                            <span class="employee-name">{{ value.ten_chuc_vu }}</span>
                          </div>
                        </div>
                      </td>
                      <td class="text-center">
                        <span class="position-badge">
                          {{ getRoleLabel(value.loai_vai_tro) }}
                        </span>
                      </td>
                      <td class="text-center">{{ value.mo_ta }}</td>
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
                          <button class="btn-action btn-edit" @click="selectRoleForPermission(value)"
                            title="Phân quyền">
                            <i class="fas fa-key"></i>
                          </button>
                          <button class="btn-action btn-view" data-bs-toggle="modal" data-bs-target="#capNhatModal"
                            @click="Object.assign(update_chuc_vu, value)" title="Chỉnh sửa">
                            <i class="fas fa-edit"></i>
                          </button>
                          <button class="btn-action btn-delete" data-bs-toggle="modal" data-bs-target="#xoaModal"
                            @click="Object.assign(delete_chuc_vu, value)" title="Xóa">
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

  <!-- Permission Dialog Component -->
  <PermissionDialog v-if="selectedRole" :selectedRole="selectedRole" :availableFunctions="list_chuc_nang"
    :currentPermissions="currentPermissions" @grant-permission="handleGrantPermission"
    @revoke-permission="handleRevokePermission" @save-permissions="handleSavePermissions"
    @clear-selected-role="handleClearSelectedRole" />
</template>

<script>
import axios from "axios";
import baseRequestAdmin from "../../../core/baseRequestAdmin";
import PermissionDialog from "./diaLog.vue";

export default {
  components: {
    PermissionDialog,
  },
  data() {
    return {
      list_chuc_nang: [],
      list_chuc_vu: [],
      create_chuc_vu: {
        ten_chuc_vu: "",
        mo_ta: "",
        loai_vai_tro: "",
        slug_chuc_vu: "",
        tinh_trang: "1",
      },
      update_chuc_vu: {},
      delete_chuc_vu: {},
      search: {
        noi_dung: "",
        loai_vai_tro: "",
      },
      selectedRole: null,
      currentPermissions: [],
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

      baseRequestAdmin
        .get("admin/chuc-nang/data")
        .then((res) => {
          if (res.data.status) {
            this.list_chuc_nang = res.data.data;
          }
        })
        .catch((err) => {
          console.log("Không thể tải danh sách chức năng");
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
        .catch((err) => {
          this.$toast.error("Có lỗi xảy ra khi tìm kiếm");
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
        .catch((err) => {
          this.$toast.error("Có lỗi xảy ra khi thay đổi trạng thái");
        });
    },

    selectRoleForPermission(role) {
      this.selectedRole = role;
      // Load current permissions for this role
      this.loadCurrentPermissions(role.id);
      // Show modal via Bootstrap
      const modalElement = document.getElementById("permissionModal");
      if (modalElement) {
        const modal = new bootstrap.Modal(modalElement);
        modal.show();
      }
    },

    loadCurrentPermissions(roleId) {
      // Mock data - replace with actual API call
      this.currentPermissions = [];
    },

    handleGrantPermission(func) {
      if (!this.selectedRole) {
        this.$toast.warning("Vui lòng chọn vai trò trước!");
        return;
      }

      const exists = this.currentPermissions.find((p) => p.id === func.id);
      if (exists) {
        this.$toast.warning("Quyền này đã được cấp!");
        return;
      }

      this.currentPermissions.push(func);
      this.$toast.success(
        `Đã cấp quyền "${func.ten_chuc_nang}" cho vai trò "${this.selectedRole.ten_chuc_vu}"`
      );
    },

    handleRevokePermission(permission) {
      const index = this.currentPermissions.findIndex((p) => p.id === permission.id);
      if (index > -1) {
        this.currentPermissions.splice(index, 1);
        this.$toast.success(`Đã thu hồi quyền "${permission.ten_chuc_nang}"`);
      }
    },

    handleSavePermissions(data) {
      this.$toast.success("Đã lưu thay đổi phân quyền!");
      const modalElement = document.getElementById("permissionModal");
      if (modalElement) {
        const modal = bootstrap.Modal.getInstance(modalElement);
        if (modal) modal.hide();
      }
    },

    handleClearSelectedRole() {
      this.selectedRole = null;
      this.currentPermissions = [];
    },

    getRoleLabel(roleType) {
      const labels = {
        nhan_vien: "Nhân viên",
        giao_vien: "Giáo viên",
        hoc_sinh: "Học sinh",
      };
      return labels[roleType] || "Không xác định";
    },
  },
};
</script>

<style lang="scss">
@use "./style.scss";
</style>
