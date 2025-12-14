<template>
  <div class="reset-password-wrapper d-flex align-items-center justify-content-center">
    <div class="reset-password-box shadow">
      <div class="text-center mb-4">
        <div class="logo-icon-wrapper">
          <img src="../../../assets/images/Home/logohoa.png" alt="Logo" class="logo-icon" />
        </div>
        <h3 class="text-white">Đặt Lại Mật Khẩu</h3>
        <p class="text-muted mt-2">Nhập mã OTP và mật khẩu mới của bạn</p>
      </div>

      <div>
        <div class="form-group mb-3">
          <label class="text-white mb-1">Mã OTP</label>
          <div class="input-group">
            <span class="input-group-text bg-dark text-white"><i class="fa-solid fa-key"></i></span>
            <input v-model="otp" type="text" class="form-control bg-transparent text-white custom-placeholder placeholder-white" placeholder="Nhập mã OTP" maxlength="6" />
          </div>
        </div>

        <div class="form-group mb-3">
          <label class="text-white mb-1">Mật khẩu mới</label>
          <div class="input-group">
            <span class="input-group-text bg-dark text-white"><i class="fa-solid fa-lock"></i></span>
            <input v-model="password" :type="showPassword ? 'text' : 'password'" class="form-control bg-transparent text-white custom-placeholder placeholder-white" placeholder="Nhập mật khẩu mới" />
            <span class="input-group-text bg-transparent text-white cursor-pointer" @click="showPassword = !showPassword">
              <i class="bx" :class="showPassword ? 'bx-hide' : 'bx-show'"></i>
            </span>
          </div>
        </div>

        <div class="form-group mb-4">
          <label class="text-white mb-1">Nhập lại mật khẩu</label>
          <div class="input-group">
            <span class="input-group-text bg-dark text-white"><i class="fa-solid fa-lock"></i></span>
            <input v-model="confirmPassword" :type="showConfirmPassword ? 'text' : 'password'" class="form-control bg-transparent text-white custom-placeholder placeholder-white" placeholder="Nhập lại mật khẩu mới" />
            <span class="input-group-text bg-transparent text-white cursor-pointer" @click="showConfirmPassword = !showConfirmPassword">
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
import { createToaster } from "@meforma/vue-toaster";
import baseRequestTeacher from "../../../core/baseRequestTeacher";

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

        const res = await baseRequestTeacher.post('teacher/reset-password', {
          otp: this.otp,
          new_password: this.password,
          confirm_password: this.confirmPassword
        });

        if (res?.data?.status) {
          toaster.success(res?.data?.message || 'Đổi mật khẩu thành công');
          this.password = '';
          this.otp = '';
          this.confirmPassword = '';
          setTimeout(() => this.$router.push('/teacher/login'), 2000);
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

.reset-password-wrapper {
  min-height: 100vh;
  background: linear-gradient(135deg, #2c2c54, #1b1464);
  padding: 40px 20px;
}

.reset-password-box {
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

.cursor-pointer {
  cursor: pointer;
}

.cursor-pointer:hover {
  color: #7873f5;
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

