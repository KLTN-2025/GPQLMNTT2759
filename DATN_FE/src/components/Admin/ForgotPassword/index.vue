<template>
  <div class="forgot-password-wrapper d-flex align-items-center justify-content-center">
    <div class="forgot-password-box shadow">
      <div class="text-center mb-4">
        <div class="logo-icon-wrapper">
          <img src="../../../assets/images/Home/logohoa.png" alt="Logo" class="logo-icon" />
        </div>
        <h3 class="text-dark">Quên Mật Khẩu</h3>
        <p class="text-muted mt-2">Nhập email của bạn để nhận liên kết đặt lại mật khẩu</p>
      </div>

      <div>
        <div class="form-group mb-4">
          <label class="text-dark mb-1">Email</label>
          <div class="input-group">
            <span class="input-group-text bg-light text-dark"><i class="fa-solid fa-envelope"></i></span>
            <input v-model="noi_dung.email" type="email"
              class="form-control bg-white text-dark custom-placeholder placeholder-dark"
              placeholder="Nhập email của bạn" />
          </div>
        </div>

        <button v-on:click="sendResetLink" class="btn btn-gradient w-100" :disabled="loading">
          <i v-if="loading" class="fa-solid fa-spinner fa-spin me-2"></i>
          <i v-else class="fa-solid fa-paper-plane me-2"></i>
          {{ loading ? 'Đang gửi...' : 'Gửi liên kết đặt lại mật khẩu' }}
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
import axios from 'axios';

const toaster = createToaster({ position: "top-right" });

export default {
  data() {
    return {
      noi_dung: {
        email: '',
      },

      loading: false
    }
  },
  methods: {
    sendResetLink() {
      this.loading = true;
      axios.post('http://127.0.0.1:8000/api/admin/forgot-password', this.noi_dung)
        .then((res) => {
          if (res && res.data && res.data.status) {
            toaster.success(res.data.message || 'Đã gửi liên kết đặt lại mật khẩu đến email của bạn');
            this.noi_dung.email = '';
            this.$router.push('/admin/reset-password');

          } else {
            toaster.error(res.data?.message || 'Gửi email thất bại');
          }
        })
        .catch((err) => {
          if (err.response && err.response.data && err.response.data.errors) {
            const listErr = err.response.data.errors;
            Object.values(listErr).forEach((error) => {
              toaster.error(error[0]);
            });
          } else {
            toaster.error('Đã xảy ra lỗi. Vui lòng thử lại.');
          }
        })
        .finally(() => {
          this.loading = false;
        });
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
