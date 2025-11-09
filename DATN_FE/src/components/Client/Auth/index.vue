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
            <li><strong>Tên Người dùng:</strong> Nguyễn Quang Trường</li>
            <li><strong>Mã Mầm Non:</strong> 27211232535</li>
            <li><strong>Giới tính:</strong> Nam</li>
            <li><strong>Ngày sinh:</strong> 16/9/2003</li>
            <li><strong>Email (HS):</strong> nguyenvanquang6@hsedu.vn</li>
          </ul>
        </div>

        <div class="profile-avatar">
          <div class="item-avatar">
            <div class="from-avatar">
              <img
                src="https://cdn-icons-png.flaticon.com/512/149/149071.png"
                alt="Avatar"
              />
            </div>
            <button>Thay đổi Avatar</button>
          </div>
          <p class="caption">(Kích thước tối thiểu là cao 165px, rộng 147px)</p>
        </div>
      </div>

      <h3 class="section-title">Địa chỉ Hiện thời:</h3>
      <ul class="address-info">
        <li>
          <strong>Địa chỉ/Tổ/Thôn:</strong> tổ 7, thôn Liễu Thanh, xã Bình
          Nguyên, huyện Thăng Bình, tỉnh Quảng Nam
        </li>
        <li><strong>Phường/Xã:</strong> Bình Nguyên</li>
        <li><strong>Quận/Huyện:</strong> Thăng Bình</li>
        <li><strong>Tỉnh/Thành phố:</strong> Quảng Nam</li>
        <li><strong>Quốc gia:</strong> Việt Nam</li>
        <li><strong>Điện thoại:</strong> 0925306503</li>
        <li><strong>Email (khác):</strong> nguyenvqt03011609@gmail.com</li>
      </ul>

      <h3 class="section-title red">
        Người Liên hệ trong Trường hợp Khẩn cấp (Cha/Mẹ/Người thân):
      </h3>
      <ul class="contact-info">
        <li><strong>Người liên hệ:</strong> Đoàn Thị Thu Ba</li>
        <li><strong>Là:</strong> Mẹ</li>
        <li>
          <strong>Địa chỉ:</strong> tổ 7, thôn Liễu Thanh, xã Bình Nguyên, huyện
          Thăng Bình, tỉnh Quảng Nam
        </li>
        <li><strong>Phường/Xã:</strong> Bình Nguyên</li>
        <li><strong>Quận/Huyện:</strong> Thăng Bình</li>
        <li><strong>Tỉnh/Thành phố:</strong> Quảng Nam</li>
        <li><strong>Quốc gia:</strong> Việt Nam</li>
        <li><strong>Điện thoại:</strong> 0925306503</li>
        <li><strong>Email:</strong> nguyenvqt03011609@gmail.com</li>
      </ul>

      <div class="button-wrapper">
        <button
          class="btn-update"
          data-bs-toggle="modal"
          data-bs-target="#exampleModal"
        >
          CẬP NHẬT
        </button>
      </div>
    </div>
    <ModalAddUser />
  </div>
</template>
<script setup>
import ModalAddUser from "./Dialog.vue";
</script>
<style lang="scss">
@use "./style.scss";
</style>
