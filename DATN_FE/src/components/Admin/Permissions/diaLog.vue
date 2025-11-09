<template>
  <!-- Modal Phân Quyền -->
  <div
    class="modal fade"
    id="permissionModal"
    tabindex="-1"
    aria-labelledby="permissionModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content modal-modern">
        <div class="modal-header-modern">
          <div class="modal-header-content">
            <div class="modal-title-content">
              <h5 class="modal-title" id="permissionModalLabel">
                Phân Quyền Hệ Thống
              </h5>
              <p class="modal-subtitle" v-if="selectedRole">
                Quản lý quyền cho:
                <strong>{{ selectedRole.ten_chuc_vu }}</strong>
              </p>
            </div>
          </div>
          <button
            type="button"
            class="btn-close-modern"
            data-bs-dismiss="modal"
            aria-label="Close"
            @click="clearSelectedRole"
          >
            <i class="fas fa-times"></i>
          </button>
        </div>

        <div class="modal-body-modern permission-modal-body">
          <div class="row g-4">
            <!-- Cột trái: Danh sách chức năng có thể cấp -->
            <div class="col-md-6">
              <div class="permission-section">
                <div class="section-header">
                  <div class="section-icon">
                    <i class="fas fa-list-check"></i>
                  </div>
                  <div class="section-title">
                    <h6>Danh Sách Chức Năng</h6>
                    <small
                      >{{ availableFunctions.length }} chức năng có sẵn</small
                    >
                  </div>
                </div>

                <!-- Search và Filter -->
                <div class="permission-search">
                  <div class="search-input-group">
                    <i class="fas fa-search search-icon"></i>
                    <input
                      type="text"
                      class="search-input"
                      placeholder="Tìm kiếm chức năng..."
                      v-model="functionSearch"
                    />
                  </div>
                  <select class="filter-select" v-model="functionGroupFilter">
                    <option value="">Tất cả nhóm</option>
                    <option value="quan_ly">Quản lý</option>
                    <option value="giang_day">Giảng dạy</option>
                    <option value="hoc_tap">Học tập</option>
                  </select>
                </div>

                <!-- Danh sách chức năng -->
                <div class="function-list">
                  <div
                    v-for="func in filteredAvailableFunctions"
                    :key="func.id"
                    class="function-item"
                    :class="{
                      'function-granted': isPermissionGranted(func.id),
                    }"
                  >
                    <div class="function-info">
                      <div class="function-header">
                        <i
                          :class="getFunctionIcon(func.nhom_chuc_nang)"
                          class="function-icon"
                        ></i>
                        <span class="function-name">{{
                          func.ten_chuc_nang
                        }}</span>
                        <span
                          :class="getFunctionGroupBadge(func.nhom_chuc_nang)"
                          class="group-badge"
                        >
                          {{ getFunctionGroupLabel(func.nhom_chuc_nang) }}
                        </span>
                      </div>
                      <p class="function-description">{{ func.mo_ta }}</p>
                    </div>
                    <div class="function-actions">
                      <button
                        v-if="!isPermissionGranted(func.id)"
                        @click="grantPermission(func)"
                        class="btn-grant"
                        title="Cấp quyền"
                      >
                        <i class="fas fa-plus"></i>
                      </button>
                      <button
                        v-else
                        @click="revokePermission(func)"
                        class="btn-revoke"
                        title="Thu hồi quyền"
                      >
                        <i class="fas fa-minus"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Cột phải: Quyền đã cấp -->
            <div class="col-md-6">
              <div class="permission-section">
                <div class="section-header">
                  <div class="section-icon">
                    <i class="fas fa-shield-check"></i>
                  </div>
                  <div class="section-title">
                    <h6>Quyền Đã Cấp</h6>
                    <small
                      >{{ currentPermissions.length }} quyền được cấp</small
                    >
                  </div>
                </div>

                <!-- Thống kê quyền -->
                <div class="permission-stats">
                  <div class="stat-item">
                    <span class="stat-label">Quản lý:</span>
                    <span class="stat-value">{{
                      getPermissionCountByGroup("quan_ly")
                    }}</span>
                  </div>
                  <div class="stat-item">
                    <span class="stat-label">Giảng dạy:</span>
                    <span class="stat-value">{{
                      getPermissionCountByGroup("giang_day")
                    }}</span>
                  </div>
                  <div class="stat-item">
                    <span class="stat-label">Học tập:</span>
                    <span class="stat-value">{{
                      getPermissionCountByGroup("hoc_tap")
                    }}</span>
                  </div>
                </div>

                <!-- Danh sách quyền đã cấp -->
                <div class="granted-permissions">
                  <div
                    v-for="permission in currentPermissions"
                    :key="permission.id"
                    class="granted-item"
                  >
                    <div class="granted-info">
                      <div class="granted-header">
                        <i
                          :class="getFunctionIcon(permission.nhom_chuc_nang)"
                          class="granted-icon"
                        ></i>
                        <span class="granted-name">{{
                          permission.ten_chuc_nang
                        }}</span>
                        <span
                          :class="
                            getFunctionGroupBadge(permission.nhom_chuc_nang)
                          "
                          class="group-badge"
                        >
                          {{ getFunctionGroupLabel(permission.nhom_chuc_nang) }}
                        </span>
                      </div>
                      <p class="granted-description">{{ permission.mo_ta }}</p>
                    </div>
                    <button
                      @click="revokePermission(permission)"
                      class="btn-remove"
                      title="Xóa quyền"
                    >
                      <i class="fas fa-times"></i>
                    </button>
                  </div>

                  <!-- Empty state -->
                  <div
                    v-if="currentPermissions.length === 0"
                    class="empty-permissions"
                  >
                    <div class="empty-icon">
                      <i class="fas fa-shield-alt"></i>
                    </div>
                    <h6 class="empty-title">Chưa có quyền nào</h6>
                    <p class="empty-description">
                      Chọn các chức năng bên trái để cấp quyền cho vai trò này
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer-modern">
          <div class="footer-info">
            <span class="permission-count">
              <i class="fas fa-info-circle"></i>
              Đã cấp {{ currentPermissions.length }}/{{
                availableFunctions.length
              }}
              quyền
            </span>
          </div>
          <div class="footer-actions">
            <button
              type="button"
              class="btn btn-secondary btn-modern"
              data-bs-dismiss="modal"
              @click="clearSelectedRole"
            >
              <i class="fas fa-times"></i>
              Đóng
            </button>
            <button
              @click="savePermissions"
              type="button"
              class="btn btn-primary btn-modern"
            >
              <i class="fas fa-save"></i>
              Lưu Thay Đổi
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "PermissionDialog",
  props: {
    selectedRole: {
      type: Object,
      default: null,
    },
    availableFunctions: {
      type: Array,
      default: () => [],
    },
    currentPermissions: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {
      functionSearch: "",
      functionGroupFilter: "",
      list_chuc_nang: [],
    };
  },
  computed: {
    filteredAvailableFunctions() {
      let filtered = this.availableFunctions;

      // Filter by search term
      if (this.functionSearch) {
        filtered = filtered.filter(
          (func) =>
            func.ten_chuc_nang
              .toLowerCase()
              .includes(this.functionSearch.toLowerCase()) ||
            func.mo_ta.toLowerCase().includes(this.functionSearch.toLowerCase())
        );
      }

      // Filter by group
      if (this.functionGroupFilter) {
        filtered = filtered.filter(
          (func) => func.nhom_chuc_nang === this.functionGroupFilter
        );
      }

      return filtered;
    },
  },
  methods: {
    layDataChucNang() {
      axios
        .get("http://127.0.0.1:8000/api/admin/chuc-nang/data")
        .then((res) => {
          this.list_chuc_nang = res.data.data;
        });
    },
    isPermissionGranted(functionId) {
      return this.currentPermissions.some((p) => p.id === functionId);
    },

    grantPermission(func) {
      this.$emit("grant-permission", func);
    },

    revokePermission(permission) {
      this.$emit("revoke-permission", permission);
    },

    savePermissions() {
      this.$emit("save-permissions", {
        roleId: this.selectedRole?.id,
        permissions: this.currentPermissions,
      });
    },

    clearSelectedRole() {
      this.$emit("clear-selected-role");
    },

    getPermissionCountByGroup(group) {
      return this.currentPermissions.filter((p) => p.nhom_chuc_nang === group)
        .length;
    },

    getFunctionIcon(groupType) {
      const icons = {
        quan_ly: "fas fa-cogs",
        giang_day: "fas fa-chalkboard",
        hoc_tap: "fas fa-book-open",
      };
      return icons[groupType] || "fas fa-puzzle-piece";
    },

    getFunctionGroupLabel(groupType) {
      const labels = {
        quan_ly: "Quản lý",
        giang_day: "Giảng dạy",
        hoc_tap: "Học tập",
      };
      return labels[groupType] || "Khác";
    },

    getFunctionGroupBadge(groupType) {
      const classes = {
        quan_ly: "group-badge-management",
        giang_day: "group-badge-teaching",
        hoc_tap: "group-badge-learning",
      };
      return classes[groupType] || "group-badge-default";
    },
  },
};
</script>

<style lang="scss" scoped>
.permission-modal-body {
  padding: 1.5rem;
  max-height: 70vh;
  overflow-y: auto;
}

.permission-section {
  background: #f8f9fa;
  border-radius: 12px;
  padding: 1.5rem;
  height: 100%;
  display: flex;
  flex-direction: column;
}

.section-header {
  display: flex;
  align-items: center;
  gap: 1rem;
  margin-bottom: 1.5rem;
  padding-bottom: 1rem;
  border-bottom: 2px solid #e9ecef;
}

.section-icon {
  width: 40px;
  height: 40px;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 1.2rem;
}

.section-title h6 {
  margin: 0;
  font-weight: 600;
  color: #2c3e50;
  font-size: 0.95rem; /* Giảm từ mặc định */
}

.section-title small {
  color: #6c757d;
  font-size: 0.75rem; /* Giảm từ 0.85rem */
}

.permission-search {
  display: flex;
  gap: 1rem;
  margin-bottom: 1.5rem;
}

.search-input-group {
  position: relative;
  flex: 1;
}

.search-icon {
  position: absolute;
  left: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: #6c757d;
  font-size: 0.9rem;
}

.search-input {
  width: 100%;
  padding: 0.75rem 0.75rem 0.75rem 2.5rem;
  border: 2px solid #e9ecef;
  border-radius: 8px;
  font-size: 0.8rem;
  transition: all 0.3s ease;

  &:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
  }
}

.filter-select {
  padding: 0.75rem;
  border: 2px solid #e9ecef;
  border-radius: 8px;
  font-size: 0.8rem; /* Giảm từ 0.9rem */
  min-width: 140px;
  transition: all 0.3s ease;

  &:focus {
    outline: none;
    border-color: #667eea;
  }
}
.function-list,
.granted-permissions {
  flex: 1;
  overflow-y: auto;
  max-height: 400px;
}

.function-item,
.granted-item {
  background: white;
  border: 2px solid #e9ecef;
  border-radius: 10px;
  padding: 1rem;
  margin-bottom: 0.75rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  transition: all 0.3s ease;

  &:hover {
    border-color: #667eea;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }
}

.function-granted {
  background: #e8f5e8;
  border-color: #28a745;
}

.function-info,
.granted-info {
  flex: 1;
}

.function-header,
.granted-header {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  margin-bottom: 0.5rem;
}

.function-icon,
.granted-icon {
  width: 32px;
  height: 32px;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 0.9rem;
}

.function-name,
.granted-name {
  font-weight: 600;
  color: #2c3e50;
  font-size: 0.85rem; /* Giảm từ 0.95rem */
}

.function-description,
.granted-description {
  margin: 0;
  color: #6c757d;
  font-size: 0.75rem; /* Giảm từ 0.85rem */
  line-height: 1.4;
}

.group-badge {
  padding: 0.25rem 0.5rem;
  border-radius: 12px;
  font-size: 0.65rem; /* Giảm từ 0.7rem */
  font-weight: 500;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.group-badge-management {
  background: #e3f2fd;
  color: #1976d2;
}

.group-badge-teaching {
  background: #f3e5f5;
  color: #7b1fa2;
}

.group-badge-learning {
  background: #e8f5e8;
  color: #388e3c;
}

.group-badge-default {
  background: #f5f5f5;
  color: #757575;
}

.btn-grant,
.btn-revoke,
.btn-remove {
  width: 36px;
  height: 36px;
  border: none;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.9rem;
  cursor: pointer;
  transition: all 0.3s ease;
}

.btn-grant {
  background: #28a745;
  color: white;

  &:hover {
    background: #218838;
    transform: scale(1.1);
  }
}

.btn-revoke,
.btn-remove {
  background: #dc3545;
  color: white;

  &:hover {
    background: #c82333;
    transform: scale(1.1);
  }
}

.permission-stats {
  display: flex;
  gap: 1rem;
  margin-bottom: 1.5rem;
  padding: 1rem;
  background: white;
  border-radius: 8px;
  border: 2px solid #e9ecef;
}

.stat-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  flex: 1;
}

.stat-label {
  font-size: 0.7rem; /* Giảm từ 0.8rem */
  color: #6c757d;
  margin-bottom: 0.25rem;
}

.stat-value {
  font-size: 1.1rem; /* Giảm từ 1.2rem */
  font-weight: 600;
  color: #2c3e50;
}

.empty-permissions {
  text-align: center;
  padding: 3rem 1rem;
  color: #6c757d;
}

.empty-icon {
  font-size: 3rem;
  margin-bottom: 1rem;
  opacity: 0.5;
}

.empty-title {
  font-size: 1rem; /* Giảm từ 1.1rem */
  font-weight: 600;
  margin-bottom: 0.5rem;
  color: #495057;
}

.empty-description {
  font-size: 0.8rem; /* Giảm từ 0.9rem */
  margin: 0;
  line-height: 1.5;
}

.modal-footer-modern {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1.5rem;
  border-top: 2px solid #e9ecef;
}

.footer-info {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  color: #6c757d;
  font-size: 0.8rem; /* Giảm từ 0.9rem */
}

.footer-actions {
  display: flex;
  gap: 1rem;
}

.permission-count {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}
</style>
