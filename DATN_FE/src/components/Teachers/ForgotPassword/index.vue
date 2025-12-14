<template>
  <div class="forgot-password-wrapper d-flex align-items-center justify-content-center">
    <div class="forgot-password-box shadow">
      <div class="text-center mb-4">
        <div class="logo-icon-wrapper">
          <img src="../../../assets/images/Home/logohoa.png" alt="Logo" class="logo-icon" />
        </div>
        <h3 class="text-white">Quên Mật Khẩu</h3>
        <p class="text-muted mt-2">Nhập email của bạn để nhận liên kết đặt lại mật khẩu</p>
      </div>

      <div>
        <div class="form-group mb-4">
          <label class="text-white mb-1">Email</label>
          <div class="input-group">
            <span class="input-group-text bg-dark text-white"><i class="fa-solid fa-envelope"></i></span>
            <input v-model="email" type="email" class="form-control bg-transparent text-white custom-placeholder placeholder-white" placeholder="Nhập email của bạn" />
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
import { createToaster } from "@meforma/vue-toaster";
import baseRequestTeacher from "../../../core/baseRequestTeacher";
import axios from 'axios';
const toaster = createToaster({ position: "top-right" });

export default {
  data() {
    return {
      email: '',
      loading: false
    }
  },
  methods: {
    sendResetLink() {
      this.loading = true;
      axios.post('http://127.0.0.1:8000/api/teacher/forgot-password', this.noi_dung)
        .then((res) => {
          if (res && res.data && res.data.status) {
            toaster.success(res.data.message || 'Đã gửi liên kết đặt lại mật khẩu đến email của bạn');
            this.noi_dung.email = '';
            this.$router.push('teacher/reset-password');

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
      this.$router.push('/teacher/login');
    }
  },
};
</script>

<style scoped>
.placeholder-white::placeholder {
  color: #ffffff !important;
  opacity: 1;
}

.custom-placeholder::placeholder {
  color: #ffffff;
  opacity: 1;
  font-weight: 500;
}

.forgot-password-wrapper {
  min-height: 100vh;
  background: linear-gradient(135deg, #2c2c54, #1b1464);
  padding: 40px 20px;
}

.forgot-password-box {
  background: #1e1f2f;
  padding: 40px 30px;
  border-radius: 12px;
  max-width: 420px;
  width: 100%;
}

.logo-icon-wrapper {
  width: 100px;
  height: 100px;
  border-radius: 15px;
  margin: 0 auto 20px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.logo-icon-wrapper .logo-icon {
  width: 100%;
  height: 100%;
  color: white;
  object-fit: contain;
}

.text-gradient {
  background: linear-gradient(to right, #f953c6, #b91d73);
  background-clip: text;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.btn-gradient {
  background: linear-gradient(to right, #ff6ec4, #7873f5);
  border: none;
  color: white;
  transition: 0.3s ease;
  font-weight: 600;
  padding: 10px 0;
}

.btn-gradient:hover {
  opacity: 0.9;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(120, 115, 245, 0.3);
}

.btn-gradient:disabled {
  opacity: 0.6;
  cursor: not-allowed;
  transform: none;
}

.input-group-text {
  border-right: none;
}

.form-control {
  border-left: none;
}

.form-control:focus {
  background-color: transparent;
  color: white;
  box-shadow: none;
  border-color: #7873f5;
}

.btn-back-login {
  background: transparent;
  border: none;
  color: #7873f5;
  font-weight: 600;
  padding: 8px 16px;
  cursor: pointer;
  transition: all 0.3s ease;
  font-size: 1rem;
}

.btn-back-login:hover {
  color: #ff6ec4;
  transform: translateX(-3px);
}

.btn-back-login i {
  transition: transform 0.3s ease;
}

.btn-back-login:hover i {
  transform: translateX(-3px);
}
</style>

