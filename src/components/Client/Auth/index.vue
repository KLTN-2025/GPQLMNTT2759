<template>
  <div class="auth-container">
    <div class="profile-wrapper">
      <h2 class="title">
        <i class="mdi mdi-account-box-outline"></i>
        THÔNG TIN CÁ NHÂN
      </h2>

      <div class="profile-content">
        <div class="profile-info">
          <ul>
            <li><strong>Tên Người dùng:</strong> {{ thong_tin.ho_va_ten }}</li>
            <li><strong>Mã Mầm Non:</strong> {{ thong_tin.id }}</li>
            <li><strong>Giới tính:</strong> {{ thong_tin.gioi_tinh === 1 ? 'Nam' : 'Nữ' }}</li>
            <li><strong>Ngày sinh:</strong> {{ thong_tin.ngay_sinh }}</li>
            <li><strong>Email (HS):</strong> {{ thong_tin.email }}</li>
          </ul>
        </div>

        <div class="profile-avatar">
          <div class="item-avatar">
            <div class="from-avatar">
              <img :src="anh_tmp || thong_tin.avatar || 'https://cdn-icons-png.flaticon.com/512/149/149071.png'"
                alt="Avatar" />
            </div>
            <label for="file_upload" class="btn-change-avatar" style="cursor: pointer;">Thay đổi Avatar</label>
            <input type="file" id="file_upload" hidden @change="loadAnhTuLocal" accept="image/*">
          </div>
          <p class="caption">(Kích thước tối thiểu là cao 165px, rộng 147px)</p>
        </div>
      </div>

      <h3 class="section-title">Địa chỉ Hiện thời:</h3>
      <ul class="address-info">
        <li>
          <strong>Địa chỉ:</strong> {{ thong_tin.dia_chi }}
        </li>
        <li><strong>Điện thoại:</strong> {{ thong_tin.so_dien_thoai }}</li>
      </ul>

      <h3 class="section-title red">
        Người Liên hệ trong Trường hợp Khẩn cấp:
      </h3>
      <ul class="contact-info">
        <!-- Placeholder for emergency contact info if available -->
        <li><strong>Thông tin:</strong> Đang cập nhật...</li>
      </ul>

      <div class="button-wrapper">
        <button class="btn-update" data-bs-toggle="modal" data-bs-target="#exampleModal">
          CẬP NHẬT
        </button>
      </div>
    </div>
    <ModalAddUser />
  </div>
</template>
<script>
import axios from 'axios';
import ModalAddUser from "./Dialog.vue";

export default {
  components: {
    ModalAddUser
  },
  data() {
    return {
      thong_tin: {},
      file_anh: null,
      anh_tmp: null,
    }
  },
  mounted() {
    this.getDataProfile();
  },
  methods: {
    getDataProfile() {
      axios
        .get("http://127.0.0.1:8000/api/khach-hang/profile/data", {
          headers: {
            Authorization: 'Bearer ' + localStorage.getItem("token_khach_hang")
          }
        })
        .then((res) => {
          this.thong_tin = res.data.data;
        })
        .catch((err) => {
          // Handle error
        });
    },
    loadAnhTuLocal(event) {
      this.file_anh = event.target.files[0];
      this.createImage(this.file_anh);
    },
    createImage(file) {
      let reader = new FileReader();
      let vm = this;
      reader.onload = (e) => {
        vm.anh_tmp = e.target.result;
        this.updateChange();
      };
      reader.readAsDataURL(file);
    },
    updateChange() {
      const payload = new FormData();
      payload.append("hinh_anh", this.file_anh);
      axios
        .post("http://127.0.0.1:8000/api/khach-hang/profile/anh-dai-dien", payload, {
          headers: {
            Authorization: 'Bearer ' + localStorage.getItem("token_khach_hang"),
            'Content-Type': 'multipart/form-data'
          }
        })
        .then((res) => {
          if (res.data.status) {
            var thong_bao = '<b>Thông báo</b><span style="margin-top: 5px">' + res.data.message + '<span>';
            this.$toast.success(thong_bao);
            this.getDataProfile()
          } else {
            var thong_bao = '<b>Thông báo</b><span style="margin-top: 5px">' + res.data.message + '<span>';
            this.$toast.error(thong_bao);
          }
        })
    },
  }
}
</script>
<style lang="scss">
@use "./style.scss";

.btn-change-avatar {
  margin-top: 10px;
  padding: 5px 10px;
  background: #eee;
  border: 1px solid #999;
  border-radius: 4px;
  cursor: pointer;
  display: inline-block;
}
</style>
