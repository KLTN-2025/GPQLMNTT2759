<template>
  <div class="login-card">
    <h2 class="title">Quên Mật Khẩu</h2>
    <p class="description">
      Nhập email của bạn để nhận yêu cầu đặt lại mật khẩu.
    </p>
    <form @submit.prevent="handleSubmit" class="mt-3" novalidate>
      <div class="form-line">
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
        <div v-if="errors.email" class="invalid-feedback">
          {{ errors.email }}
        </div>
      </div>

      <button
        type="submit"
        class="btn-submit btn-request w-100 btn-lg"
        :disabled="!!errors.email || !email"
      >
        <i class="bx bx-mail-send me-2 icon-send"></i>Gửi yêu cầu đặt lại mật
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
  name: "LoginForm",
  data() {
    return {
      email: "",

      errors: {
        email: "",
      },
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

    handleSubmit() {
      const emailValid = this.validateEmail();
    },
  },
};
</script>

<style lang="scss" scoped>
@import "./style.scss";
</style>
