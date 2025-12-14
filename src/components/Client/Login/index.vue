<template>
  <div class="login-wrapper d-flex align-items-center justify-content-center">
    <div class="login-box shadow bg-white p-4 rounded-4">
      <div class="text-center mb-4">
        <div class="logo-icon-wrapper">
          <img src="../../../assets/images/Home/logohoa.png" alt="Logo" class="logo-icon" />
        </div>
        <h3 class="fw-bold">Chào mừng đến với <br> <span class="school-name">Mầm Non Hoa Sen</span></h3>
      </div>

      <div>
        <div class="form-group mb-3">
          <label class="form-label">Email</label>
          <div class="input-group">
            <span class="input-group-text bg-white text-secondary"><i class="fa-solid fa-envelope"></i></span>
            <input v-model="user.email" type="email" class="form-control" placeholder="Nhập email" />
          </div>
        </div>

        <div class="form-group mb-3">
          <label class="form-label">Mật khẩu</label>
          <div class="input-group">
            <span class="input-group-text bg-white text-secondary"><i class="fa-solid fa-lock"></i></span>
            <input v-model="user.password" type="password" class="form-control" placeholder="Nhập mật khẩu" />
          </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="remember" />
            <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
          </div>
          <button @click="goToForgotPassword" class="btn-forgot-password">Quên mật khẩu?</button>
        </div>
        <button v-on:click="DangNhap()" class="btn btn-gradient w-100">Đăng Nhập</button>

      </div>

    </div>
  </div>
</template>

<script>

import './style.scss';

import { createToaster } from "@meforma/vue-toaster";
import baseRequestClient from "../../../core/baseRequestClient";
const toaster = createToaster({ position: "top-right" });
export default {
  data() {
    return {
      showPassword: false,
      user: {
        email: '',
        password: ''

      },
    }

  },
  methods: {
    DangNhap() {
      baseRequestClient.post('login', this.user)
        .then((res) => {
          if (res && res.data && res.data.status) {
            toaster.success(res.data.message)
            this.user = {};
            localStorage.setItem('token_phu_huynh', res.data.token);
            this.$router.push('/');
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
      this.$router.push('/forgot-password');
    }
  },
};
</script>
