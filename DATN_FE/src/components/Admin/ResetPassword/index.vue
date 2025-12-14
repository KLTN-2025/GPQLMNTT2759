<template>
  <div class="reset-password-wrapper d-flex align-items-center justify-content-center">
    <div class="reset-password-box shadow">
      <div class="text-center mb-4">
        <div class="logo-icon-wrapper">
          <img src="../../../assets/images/Home/logohoa.png" alt="Logo" class="logo-icon" />
        </div>
        <h3 class="text-dark">Đặt Lại Mật Khẩu</h3>
        <p class="text-muted mt-2">Nhập mã OTP và mật khẩu mới của bạn</p>
      </div>

      <div>
        <div class="form-group mb-3">
          <label class="text-dark mb-1">Mã OTP</label>
          <div class="input-group">
            <span class="input-group-text bg-light text-dark"><i class="fa-solid fa-key"></i></span>
            <input v-model="otp" type="text" class="form-control bg-white text-dark custom-placeholder placeholder-dark"
              placeholder="Nhập mã OTP" maxlength="6" />
          </div>
        </div>

        <div class="form-group mb-3">
          <label class="text-dark mb-1">Mật khẩu mới</label>
          <div class="input-group">
            <span class="input-group-text bg-light text-dark"><i class="fa-solid fa-lock"></i></span>
            <input v-model="password" :type="showPassword ? 'text' : 'password'"
              class="form-control bg-white text-dark custom-placeholder placeholder-dark"
              placeholder="Nhập mật khẩu mới" />
            <span class="input-group-text bg-light text-dark cursor-pointer" @click="showPassword = !showPassword">
              <i class="bx" :class="showPassword ? 'bx-hide' : 'bx-show'"></i>
            </span>
          </div>
        </div>

        <div class="form-group mb-4">
          <label class="text-dark mb-1">Nhập lại mật khẩu</label>
          <div class="input-group">
            <span class="input-group-text bg-light text-dark"><i class="fa-solid fa-lock"></i></span>
            <input v-model="confirmPassword" :type="showConfirmPassword ? 'text' : 'password'"
              class="form-control bg-white text-dark custom-placeholder placeholder-dark"
              placeholder="Nhập lại mật khẩu mới" />
            <span class="input-group-text bg-light text-dark cursor-pointer"
              @click="showConfirmPassword = !showConfirmPassword">
              <i class="bx" :class="showConfirmPassword ? 'bx-hide' : 'bx-show'"></i>
            </span>
          </div>
        </div>

        <button v-on:click="resetPassword" class="btn btn-gradient w-100" :disabled="loading">
          <i v-if="loading" class="fa-solid fa-spinner fa-spin me-2"></i>
          <i v-else class="fa-solid fa-check me-2"></i>
          {{ loading ? 'Đang xử lý...' : 'Đặt lại mật khẩu' }}
        </button>
      </div>

      <div class="text-center mt-4">
        <button @click="goToLogin" class="btn-back-login">
          <i class="fa-solid fa-arrow-left me-1"></i>
          Quay lại đăng nhập
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import './style.scss';
import { createToaster } from "@meforma/vue-toaster";
import baseRequestAdmin from "../../../core/baseRequestAdmin";

const toaster = createToaster({ position: "top-right" });

export default {
  data() {
    return {
      otp: '',
      password: '',
      confirmPassword: '',
      showPassword: false,
      showConfirmPassword: false,
      loading: false
    }
  },
  methods: {
    async resetPassword() {
      // Validation
      if (!this.otp || !this.otp.trim()) {
        toaster.error('Vui lòng nhập mã OTP');
        return;
      }

      if (this.otp.length !== 6) {
        toaster.error('Mã OTP phải có 6 ký tự');
        return;
      }

      if (!this.password || !this.password.trim()) {
        toaster.error('Vui lòng nhập mật khẩu mới');
        return;
      }

      if (this.password.length < 6) {
        toaster.error('Mật khẩu mới phải có ít nhất 6 ký tự');
        return;
      }

      if (this.password !== this.confirmPassword) {
        toaster.error('Mật khẩu mới và xác nhận không khớp');
        return;
      }

      try {
        this.loading = true;

        const res = await baseRequestAdmin.post('admin/reset-password', {
          otp: this.otp,
          new_password: this.password,
          confirm_password: this.confirmPassword
        });

        if (res?.data?.status) {
          toaster.success(res?.data?.message || 'Đổi mật khẩu thành công');
          this.password = '';
          this.otp = '';
          this.confirmPassword = '';
          setTimeout(() => this.$router.push('/admin/login'), 2000);
        } else {
          toaster.error(res?.data?.message || 'Đổi mật khẩu thất bại');
        }
      } catch (err) {
        toaster.error(err.response?.data?.message || 'Đã xảy ra lỗi. Vui lòng thử lại.');
      } finally {
        this.loading = false;
      }
    },

    goToLogin() {
      this.$router.push('/admin/login');
    }
  },
};
</script>

<style lang="scss" scoped>
@use './style.scss';
</style>
