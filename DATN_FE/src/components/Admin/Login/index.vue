<template>
  <div class="login-wrapper d-flex align-items-center justify-content-center">
    <div class="login-box shadow">
      <div class="text-center mb-4">
        <div class="logo-icon-wrapper">
          <img src="../../../assets/images/Home/logohoa.png" alt="Logo" class="logo-icon" />
        </div>
        <h3 class="text-dark">Chào mừng đến với <br> <span class="text-gradient">Mầm Non Hoa Sen</span></h3>
      </div>

      <div class="mb-3">
        <button class="btn btn-light w-100 shadow-sm d-flex align-items-center justify-content-center">
          <img src="../../../assets/images/icons/search.svg" alt="Google" width="18" class="me-2" />
          Đăng nhập bằng Google
        </button>
      </div>

      <div class="separator my-3">
        <span class="text-muted">hoặc</span>
      </div>

      <div>
        <div class="form-group mb-3">
          <label class="text-dark mb-1">Email</label>
          <div class="input-group">
            <span class="input-group-text bg-light text-dark"><i class="fa-solid fa-envelope"></i></span>
            <input v-model="user.email" type="email"
              class="form-control bg-white text-dark custom-placeholder placeholder-dark"
              placeholder="Nhập email" />

          </div>
        </div>

        <div class="form-group mb-3">
          <label class="text-dark mb-1">Mật khẩu</label>
          <div class="input-group ">
            <span class="input-group-text bg-light text-dark"><i class="fa-solid fa-lock"></i></span>
            <input v-model="user.password" :type="showPassword ? 'text' : 'password'" required
              class="form-control bg-white text-dark custom-placeholder placeholder-dark"
              placeholder="Nhập mật khẩu" />
            <span class="input-group-text bg-light text-dark cursor-pointer" @click="showPassword = !showPassword">
              <i class="bx" :class="showPassword ? 'bx-hide' : 'bx-show'"></i>
            </span>
          </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="remember" />
            <label class="form-check-label text-dark" for="remember">Ghi nhớ đăng nhập</label>
          </div>
          <button @click="goToForgotPassword" class="btn-forgot-password">Quên mật khẩu?</button>
        </div>

        <button @click="DangNhap()" class="btn btn-gradient w-100">Đăng Nhập</button>
      </div>

      <div class="text-center mt-4 text-dark">
        Chưa có tài khoản? <a href="#" class="text-gradient fw-bold">Đăng ký ngay</a>
      </div>
    </div>
  </div>
</template>

<script>
import { createToaster } from "@meforma/vue-toaster";
import baseRequestAdmin from "../../../core/baseRequestAdmin";
const toaster = createToaster({ position: "top-right" });
export default {
  data() {
    return {
      user: {
        email: '',
        password: ''
      },
      showPassword: false,
    }
  },
  methods: {
    DangNhap() {
      baseRequestAdmin.post('admin/login', this.user)
        .then((res) => {
          if (res && res.data && res.data.status) {
            toaster.success(res.data.message)
            this.user = {};
            localStorage.setItem('token_admin', res.data.token);
            this.$router.push('/admin');
          } else {
            toaster.error(res.data?.message || 'Đăng nhập thất bại');
          }
        })
        .catch((err) => {
          if (err.response && err.response.data && err.response.data.errors) {
            const listErr = err.response.data.errors;
            Object.values(listErr).forEach((error) => {
              toaster.error(error[0]);
            });
          } else {
            toaster.error('Đã xảy ra lỗi khi đăng nhập. Vui lòng thử lại.');
          }
        });
    },
    goToForgotPassword() {
      this.$router.push('/admin/forgot-password');
    }
  }
}
</script>

<style lang="scss" scoped>
@use './style.scss';
</style>
