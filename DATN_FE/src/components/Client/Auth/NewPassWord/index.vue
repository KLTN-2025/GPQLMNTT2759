<template>
  <div class="login-card">
    <h2 class="title">Đặt Lại Mật Khẩu</h2>
    <p class="description">Nhập mã OTP và mật khẩu mới của bạn.</p>
    <form @submit.prevent="handleSubmit" class="mt-3" novalidate>
      <div class="form-line password-field">
        <label class="form-label">Nhập OTP</label>

        <input
          :type="showPassword ? 'text' : 'password'"
          class="form-control input-outline"
          placeholder="Nhập OTP"
          v-model="otp"
          @blur="validateOTP"
          :class="{ 'is-invalid': errors.otp }"
          required
        />
      </div>
      <div class="form-line password-field">
        <label class="form-label">Mật khẩu</label>

        <input
          :type="showPassword ? 'text' : 'password'"
          class="form-control input-outline"
          placeholder="Nhập mật khẩu"
          v-model="password"
          @blur="validatePassword"
          :class="{ 'is-invalid': errors.password }"
          required
        />
        <button
          type="button"
          class="toggle-visibility"
          @click="showPassword = !showPassword"
          aria-label="Hiển thị/Ẩn mật khẩu"
        >
          <i
            class="bx bx-icon"
            :class="showPassword ? 'bx-hide' : 'bx-show'"
          ></i>
        </button>
        <div v-if="errors.password" class="invalid-feedback">
          {{ errors.password }}
        </div>
      </div>
      <div class="form-line password-field">
        <label class="form-label">Xác nhận mật khẩu</label>
        <input
          :type="showConfirmPassword ? 'text' : 'password'"
          class="form-control input-outline"
          placeholder="Xác nhận mật khẩu"
          v-model="confirmPassword"
          @blur="validateConfirmPassword"
          :class="{ 'is-invalid': errors.confirmPassword }"
          required
        />
        <button
          type="button"
          class="toggle-visibility"
          @click="showConfirmPassword = !showConfirmPassword"
          aria-label="Hiển thị/Ẩn xác nhận mật khẩu"
        >
          <i
            class="bx bx-icon"
            :class="showConfirmPassword ? 'bx-hide' : 'bx-show'"
          ></i>
        </button>
        <div v-if="errors.confirmPassword" class="invalid-feedback">
          {{ errors.confirmPassword }}
        </div>
      </div>

      <button
        type="submit"
        class="btn-submit btn-request w-100 btn-lg"
        :disabled="
          !!errors.password ||
          !password ||
          !!errors.confirmPassword ||
          !confirmPassword
        "
      >
        <i class="bx bx-mail-send me-2 icon-send"></i>Đặt lại mật
        khẩu
      </button>
      <div class="back-actions">
        <button
          type="button"
          class="btn-back btn-lg btn-back-login"
          @click="$emit('back-to-login')"
        >
          <i class="bx bx-log-in me-2"></i>Quay lại đăng nhập
        </button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  name: "NewPasswordForm",
  data() {
    return {
      password: "",
      confirmPassword: "",
      showPassword: false,
      showConfirmPassword: false,
      errors: {
        password: "",
        confirmPassword: "",
      },
    };
  },
  methods: {
    validatePassword() {
      if (!this.password) {
        this.errors.password = "Vui lòng nhập mật khẩu";
        return false;
      }
      if (this.password.length < 6) {
        this.errors.password = "Mật khẩu phải có ít nhất 6 ký tự";
        return false;
      }
      this.errors.password = "";
      return true;
    },
    validateConfirmPassword() {
      if (!this.confirmPassword) {
        this.errors.confirmPassword = "Vui lòng xác nhận mật khẩu";
        return false;
      }
      if (this.confirmPassword !== this.password) {
        this.errors.confirmPassword = "Mật khẩu xác nhận không khớp";
        return false;
      }
      this.errors.confirmPassword = "";
      return true;
    },
    handleSubmit() {
      const p = this.validatePassword();
      const c = this.validateConfirmPassword();
      if (!p || !c) return;
      this.$emit("reset-password", { password: this.password });
    },
  },
};
</script>

<style lang="scss" scoped>
@import "./style.scss";
</style>
