<template>
  <!-- Modal Thêm Nhân Viên -->
  <div class="modal fade" id="themGiaoVienModal" tabindex="-1" aria-labelledby="themGiaoVienModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="themGiaoVienModalLabel">
            <i class="fas fa-user-plus me-2"></i>
            Thêm Nhân Viên Mới
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="createNhanVien">
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="hoVaTen" class="form-label">Họ và Tên *</label>
                  <input type="text" class="form-control" id="hoVaTen" v-model="create_nhan_vien.ho_va_ten" required />
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="email" class="form-label">Email *</label>
                  <input type="email" class="form-control" id="email" v-model="create_nhan_vien.email" required />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="soDienThoai" class="form-label">Số Điện Thoại *</label>
                  <input type="tel" class="form-control" id="soDienThoai" v-model="create_nhan_vien.so_dien_thoai"
                    required />
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="gioiTinh" class="form-label">Giới Tính *</label>
                  <select class="form-select" id="gioiTinh" v-model="create_nhan_vien.gioi_tinh" required>
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
                  <label for="ngaySinh" class="form-label">Ngày Sinh *</label>
                  <input type="date" class="form-control" id="ngaySinh" v-model="create_nhan_vien.ngay_sinh" required />
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="chucVu" class="form-label">Chức Vụ *</label>
                  <select class="form-select" id="chucVu" v-model="create_nhan_vien.id_chuc_vu" required>
                    <option value="">Chọn chức vụ</option>
                    <option v-for="cv in list_chuc_vu" :key="cv.id" :value="cv.id">
                      {{ cv.ten_chuc_vu }}
                    </option>
                  </select>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label for="diaChi" class="form-label">Địa Chỉ *</label>
              <textarea class="form-control" id="diaChi" rows="3" v-model="create_nhan_vien.dia_chi"
                required></textarea>
            </div>
            <div class="mb-3">
              <label for="avatar" class="form-label">Avatar URL</label>
              <input type="url" class="form-control" id="avatar" v-model="create_nhan_vien.avatar"
                placeholder="https://example.com/avatar.jpg" />
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>
            Hủy
          </button>
          <button type="button" class="btn btn-primary" @click="createNhanVien">
            <i class="fas fa-save me-1"></i>
            Thêm Nhân Viên
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Cập Nhật Nhân Viên -->
  <div class="modal fade" id="capNhatGiaoVienModal" tabindex="-1" aria-labelledby="capNhatGiaoVienModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="capNhatGiaoVienModalLabel">
            <i class="fas fa-user-edit me-2"></i>
            Cập Nhật Thông Tin Nhân Viên
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="updateNhanVien">
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
                  <label for="updateDiaChi" class="form-label">Địa Chỉ *</label>
                  <textarea class="form-control" id="updateDiaChi" rows="3" v-model="update_nhan_vien.dia_chi"
                    required></textarea>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateTinhTrang" class="form-label">Trạng Thái *</label>
                  <select class="form-select" id="updateTinhTrang" v-model="update_nhan_vien.tinh_trang" required>
                    <option value="1">Hoạt động</option>
                    <option value="0">Tạm ngừng</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label for="updateAvatar" class="form-label">Avatar URL</label>
              <input type="url" class="form-control" id="updateAvatar" v-model="update_nhan_vien.avatar"
                placeholder="https://example.com/avatar.jpg" />
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>
            Hủy
          </button>
          <button type="button" class="btn btn-primary" @click="updateNhanVien">
            <i class="fas fa-save me-1"></i>
            Cập Nhật
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Xóa Nhân Viên -->
  <div class="modal fade" id="xoaGiaoVienModal" tabindex="-1" aria-labelledby="xoaGiaoVienModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="xoaGiaoVienModalLabel">
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
            <h6 class="mb-3">Bạn có chắc chắn muốn xóa nhân viên này?</h6>
            <div class="alert alert-info" v-if="delete_nhan_vien.ho_va_ten">
              <strong>Nhân viên:</strong> {{ delete_nhan_vien.ho_va_ten }}<br>
              <strong>Email:</strong> {{ delete_nhan_vien.email }}<br>
              <strong>Chức vụ:</strong> {{ delete_nhan_vien.ten_chuc_vu }}
            </div>
            <p class="text-muted small">
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
          <button type="button" class="btn btn-danger" @click="deleteNhanVien">
            <i class="fas fa-trash me-1"></i>
            Xóa Nhân Viên
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'NhanVienDialog',
  props: {
    list_chuc_vu: {
      type: Array,
      default: () => []
    },
    create_nhan_vien: {
      type: Object,
      default: () => ({})
    },
    update_nhan_vien: {
      type: Object,
      default: () => ({})
    },
    delete_nhan_vien: {
      type: Object,
      default: () => ({})
    }
  },
  methods: {
    createNhanVien() {
      // Validate form
      if (!this.create_nhan_vien.ho_va_ten ||
        !this.create_nhan_vien.email ||
        !this.create_nhan_vien.so_dien_thoai ||
        !this.create_nhan_vien.gioi_tinh ||
        !this.create_nhan_vien.ngay_sinh ||
        !this.create_nhan_vien.id_chuc_vu ||
        !this.create_nhan_vien.dia_chi) {
        alert('Vui lòng điền đầy đủ thông tin bắt buộc!');
        return;
      }

      // Emit event to parent component
      this.$emit('create-nhan-vien', this.create_nhan_vien);

      // Close modal
      const modal = bootstrap.Modal.getInstance(document.getElementById('themGiaoVienModal'));
      modal.hide();

      // Reset form
      this.$emit('reset-create-form');
    },

    updateNhanVien() {
      // Validate form
      if (!this.update_nhan_vien.ho_va_ten ||
        !this.update_nhan_vien.email ||
        !this.update_nhan_vien.so_dien_thoai ||
        !this.update_nhan_vien.dia_chi) {
        alert('Vui lòng điền đầy đủ thông tin bắt buộc!');
        return;
      }

      // Emit event to parent component
      this.$emit('update-nhan-vien', this.update_nhan_vien);

      // Close modal
      const modal = bootstrap.Modal.getInstance(document.getElementById('capNhatGiaoVienModal'));
      modal.hide();
    },

    deleteNhanVien() {
      // Emit event to parent component
      this.$emit('delete-nhan-vien', this.delete_nhan_vien);

      // Close modal
      const modal = bootstrap.Modal.getInstance(document.getElementById('xoaGiaoVienModal'));
      modal.hide();
    }
  }
};
</script>

<style lang="scss">
@use './diaLog.scss';
</style>
