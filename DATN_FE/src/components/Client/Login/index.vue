<template>
  <div class="login-wrapper d-flex align-items-center justify-content-center">
    <div class="login-box shadow bg-white p-4 rounded-4">
      <div class="text-center mb-4">
        <div class="logo-icon-wrapper me-2">
          <img src="../../../../assets/images/Home/logohoa.png" alt="Logo" class="logo-icon" />
        </div>
        <h3 class="fw-bold">Chào mừng đến với <br> <span class="school-name">Mầm Non Hoa Sen</span></h3>
      </div>

      <div>
        <div class="form-group mb-3">
          <label class="form-label">Email</label>
          <div class="input-group">
            <span class="input-group-text bg-white text-secondary"><i class="fa-solid fa-envelope"></i></span>
            <input type="email" class="form-control" placeholder="Nhập email" />
          </div>
        </div>

        <div class="form-group mb-3">
          <label class="form-label">Mật khẩu</label>
          <div class="input-group">
            <span class="input-group-text bg-white text-secondary"><i class="fa-solid fa-lock"></i></span>
            <input type="password" class="form-control" placeholder="Nhập mật khẩu" />
          </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="remember" />
            <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
          </div>
          <a href="#" class="text-primary small">Quên mật khẩu?</a>
        </div>

        <button type="submit" class="btn btn-gradient w-100">Đăng Nhập</button>
      </div>

      <div class="text-center mt-4">
        <span>Chưa có tài khoản? <a href="#" class="text-primary fw-bold">Đăng ký ngay</a></span>
      </div>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style scoped>
.login-wrapper {
  min-height: 100vh;
  background: linear-gradient(to right, #eef2f3, #f9f9f9);
  padding: 40px 20px;
}

.login-box {
  max-width: 420px;
  width: 100%;
}

.logo-icon-wrapper {
  width: 100px;
  height: 100px;
  border-radius: 15px;
  display: flex;
  align-items: center;
  justify-content: center;

  .logo-icon {
    width: 100%;
    height: 100%;
    color: white;
  }
}
.logo {
  width: 60px;
}
.school-name {
  font-size: 1.55rem;
  font-weight: 700;
  font-family: Cambria, Cochin, Georgia, Times, "Times New Roman", serif;
  background: linear-gradient(90deg, #ff66c4, #ffde59);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  margin: 0;
  line-height: 1.2;
}
.btn-gradient {
  background: linear-gradient(to right, #6a11cb, #2575fc);
  color: white;
  border: none;
  font-weight: 600;
  transition: 0.3s ease;
  padding: 10px 0;
}

.btn-gradient:hover {
  opacity: 0.95;
}

.separator {
  text-align: center;
  position: relative;
}

.separator span {
  background: #fff;
  padding: 0 12px;
  position: relative;
  z-index: 1;
}

.separator::before {
  content: "";
  position: absolute;
  top: 50%;
  left: 0;
  right: 0;
  height: 1px;
  background: #ddd;
  transform: translateY(-50%);
  z-index: 0;
}

.input-group-text {
  background-color: #fff;
  border-right: none;
  color: #555;
}

.form-control {
  border-left: none;
}

.form-control:focus {
  box-shadow: 0 0 0 0.2rem rgba(106, 17, 203, 0.15);
  border-color: #6a11cb;
}
</style>
