<template>
  <div class="login-card">
    <h2 class="title">Đăng Nhập</h2>

    <form @submit.prevent="handleSubmit" class="mt-3" novalidate>
      <div class="form-line ">
        <label class="form-label">Email</label>
        <input
          type="email"
          class="form-control input-outline"
          placeholder="Nhập email"
          v-model="email"
          @blur="validateEmail"
          :class="{ 'is-invalid': errors.email }"
          required
        />
        <div v-if="errors.email" class="invalid-feedback">{{ errors.email }}</div>
      </div>

      <div class="form-line ">
        <label class="form-label">Mật khẩu</label>
        <input
          type="password"
          class="form-control input-outline"
          placeholder="Nhập mật khẩu"
          v-model="password"
          @blur="validatePassword"
          :class="{ 'is-invalid': errors.password }"
          required
        />
        <div v-if="errors.password" class="invalid-feedback">{{ errors.password }}</div>
      </div>

      <button type="submit" class=" btn-submit btn-dark w-100 btn-lg" :disabled="!!errors.email || !!errors.password || !email || !password">Đăng Nhập</button>
    </form>

    <div class="text-muted mt-3">
      <span>Chưa có tài khoản.</span>
      <a href="#" class="ms-1">Quên mật khẩu?</a>
    </div>
  </div>
</template>

<script>
export default {
  name: "LoginForm",
  data() {
    return {
      email: "",
      password: "",
      errors: {
        email: "",
        password: ""
      }
    };
  },
  methods: {
    validateEmail() {
      if (!this.email) {
        this.errors.email = "Vui lòng nhập email";
        return false;
      }
      const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!re.test(this.email)) {
        this.errors.email = "Email không hợp lệ";
        return false;
      }
      this.errors.email = "";
      return true;
    },
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
    handleSubmit() {
      const emailValid = this.validateEmail();
      const passwordValid = this.validatePassword();
      if (!emailValid || !passwordValid) return;
      this.$emit("submit", { email: this.email, password: this.password });
    }
  }
};
</script>

<style lang="scss" scoped>
@import "./style.scss";
</style>
