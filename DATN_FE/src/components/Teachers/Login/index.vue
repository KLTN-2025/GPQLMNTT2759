<template>
    <div class="login-wrapper d-flex align-items-center justify-content-center">
        <div class="login-box shadow">
            <div class="text-center mb-4">
                <div class="logo-icon-wrapper">
                    <img src="../../../assets/images/Home/logohoa.png" alt="Logo" class="logo-icon" />
                </div>
                <h3 class="text-white">Chào mừng đến với <br> <span class="text-gradient">Mầm Non Hoa Sen</span></h3>
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
                    <label class="text-white mb-1">Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark text-white"><i class="fa-solid fa-envelope"></i></span>
                        <input v-model="user.email" type="email"
                            class="form-control bg-transparent text-white custom-placeholder placeholder-white"
                            placeholder="Nhập email" />

                    </div>
                </div>

                <div class="form-group mb-3">
                    <label class="text-white mb-1">Mật khẩu</label>
                    <div class="input-group ">
                        <span class="input-group-text bg-dark text-white"><i class="fa-solid fa-lock"></i></span>
                        <input v-model="user.password" :type="showPassword ? 'text' : 'password'" required
                            class="form-control bg-transparent text-white custom-placeholder placeholder-white"
                            placeholder="Nhập mật khẩu" />
                        <span class="input-group-text bg-transparent" @click="showPassword = !showPassword">
                            <i class="bx" :class="showPassword ? 'bx-hide' : 'bx-show'"></i>
                        </span>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember" />
                        <label class="form-check-label text-white" for="remember">Ghi nhớ đăng nhập</label>
                    </div>
                    <button @click="goToForgotPassword" class="btn-forgot-password">Quên mật khẩu?</button>
                </div>

                <button @click="DangNhap()" class="btn btn-gradient w-100">Đăng Nhập</button>
            </div>

            <div class="text-center mt-4 text-white">
                Chưa có tài khoản? <a href="#" class="text-gradient fw-bold">Đăng ký ngay</a>
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
            user: {
                email: '',
                password: ''
            },
            showPassword: false,
        }
    },
    methods: {
        DangNhap() {
            baseRequestTeacher.post('teacher/login', this.user)
                .then((res) => {
                    if (res && res.data && res.data.status) {
                        toaster.success(res.data.message)
                        this.user = {};
                        localStorage.setItem('token_giao_vien', res.data.token);
                        this.$router.push('/teacher');
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
            this.$router.push('/teacher/forgot-password');
        }
    }
}
</script>

<style scoped>
.placeholder-white::placeholder {
    color: #ffffff !important;
    /* Trắng */
    opacity: 1;
    /* Không làm mờ */
}

.custom-placeholder::placeholder {
    color: #ffffff;
    /* Màu trắng nổi bật */
    opacity: 1;
    /* Bỏ độ mờ mặc định */
    font-weight: 500;
    /* Làm chữ đậm hơn */
}

.login-wrapper {
    min-height: 100vh;
    background: linear-gradient(135deg, #2c2c54, #1b1464);
    padding: 40px 20px;
}

.login-box {
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
    margin: 0 auto;
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

.logo {
    width: 60px;
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
}

.btn-gradient:hover {
    opacity: 0.9;
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

.separator {
    text-align: center;
    position: relative;
}

.separator span {
    background: #1e1f2f;
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
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-50%);
    z-index: 0;
}

.btn-forgot-password {
    background: transparent;
    border: none;
    color: #7873f5;
    font-weight: 500;
    padding: 0;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.875rem;
    text-decoration: none;
}

.btn-forgot-password:hover {
    color: #ff6ec4;
    text-decoration: underline;
}
</style>
