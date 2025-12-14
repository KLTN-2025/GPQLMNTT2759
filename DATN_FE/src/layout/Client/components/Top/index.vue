<template>
  <div class="header-top">
    <div class="header-menu">
      <div class="header-logo">Hoa Sen</div>
      <div class="form-nav">
        <div class="nav-menu">
          <div class="item-home" @click="goToHome">Trang chủ</div>
          <div class="post-wrapper" @mouseenter="hoverPost = true" @mouseleave="hoverPost = false">
            <div class="item-home">Bài Viết</div>
            <transition name="fade-slide">
              <v-card class="blog-dropdown" v-show="hoverPost">
                <v-list v-model:opened="open">
                  <v-list-item @click="goToBlog" title="Hành Trình Của Bé" class="logout-item" />
                  <v-list-item @click="goToSchoolBlog" title="Nhà Trường" class="logout-item" />
                </v-list>
              </v-card>
            </transition>
          </div>
          <div class="post-wrapper" @mouseenter="hoverCV = true" @mouseleave="hoverCV = false">
            <div class="item-home">Tuyển Sinh</div>
            <transition name="fade-slide">
              <v-card class="blog-dropdown" v-show="hoverCV">
                <v-list v-model:opened="open">
                  <v-list-item @click="goToRecruitment" title="Thông Tin Tuyển Sinh" class="logout-item" />
                  <v-list-item @click="goToTuition" title="Học Phí" class="logout-item" />
                </v-list>
              </v-card>
            </transition>
          </div>
          <div class="post-wrapper" @mouseenter="hoverProgramme = true" @mouseleave="hoverProgramme = false">
            <div class="item-home">Chương Trình Học</div>
            <transition name="fade-slide">
              <v-card class="blog-dropdown" v-show="hoverProgramme">
                <v-list v-model:opened="open">
                  <v-list-item @click="goToProgramme" title="Lớp Mầm" class="logout-item" />
                  <v-list-item @click="goToMiddleProgramme" title="Lớp Chòi" class="logout-item" />
                  <v-list-item @click="goToBigProgramme" title="Lớp Lớn" class="logout-item" />
                </v-list>
              </v-card>
            </transition>
          </div>
          <div class="post-wrapper" @mouseenter="hoverParent = true" @mouseleave="hoverParent = false">
            <div class="item-home">Góc Phụ Huynh</div>
            <transition name="fade-slide">
              <v-card class="blog-dropdown" v-show="hoverParent">
                <v-list v-model:opened="open">
                  <v-list-item @click="goToMeal" title="Thực Đơn Của Bé" class="logout-item" />
                  <v-list-item @click="goToNotebook" title="Sổ Tay Phụ Huynh" class="logout-item" />
                </v-list>
              </v-card>
            </transition>
          </div>
          <div class="item-home" @click="goToContact">Liên hệ</div>
        </div>

        <!-- Khi CHƯA đăng nhập: chỉ hiện nút Đăng nhập -->
        <div class="auth-buttons" v-if="!isLoggedIn">
          <button class="btn-login" @click="goToLogin">
            <i class="mdi mdi-login-variant"></i>
            Đăng nhập
          </button>
        </div>

        <!-- Khi ĐÃ đăng nhập: hiện avatar và dropdown -->
        <div class="avatar-wrapper" @mouseenter="hover = true" @mouseleave="hover = false" v-else>
          <div class="form-avatar">
            <p>{{ userName }}</p>
            <div class="img-avatar">
              <img class="avatar" :src="userAvatar" alt="avatar" />
            </div>
          </div>
          <transition name="fade-slide">
            <v-card class="mx-auto" width="300" v-show="hover">
              <v-list v-model:opened="open">
                <!-- Hồ sơ cá nhân - Đầu tiên -->
                <v-list-item title="Hồ sơ cá nhân" prepend-icon="mdi-account-circle" @click="goToProfile" />
                <v-divider></v-divider>

                <!-- Thông Báo - Thứ hai -->
                <v-list-group value="Notifications">
                  <template v-slot:activator="{ props }">
                    <v-list-item v-bind="props" prepend-icon="mdi-bell-outline" title="Thông Báo"></v-list-item>
                  </template>

                  <v-list-item @click="goToParentMailbox" title="Phụ huynh" prepend-icon="mdi-account-outline"
                    value="parent-notice"></v-list-item>

                  <v-list-item @click="goToMessages" title="Nhắn tin giáo viên" prepend-icon="mdi-message-text-outline"
                    value="messages"></v-list-item>
                </v-list-group>

                <!-- Cài Đặt -->
                <v-list-group value="Settings">
                  <template v-slot:activator="{ props }">
                    <v-list-item v-bind="props" prepend-icon="mdi-cog-outline" title="Cài Đặt"></v-list-item>
                  </template>

                  <v-list-item title="Quyền riêng tư" prepend-icon="mdi-lock-outline" value="privacy"
                    @click="goToPrivacy"></v-list-item>

                  <v-list-item @click="goToAuth" title="Thông tin cá nhân" prepend-icon="mdi-account-box-outline"
                    value="profile"></v-list-item>
                </v-list-group>

                <!-- Thanh Toán -->
                <v-list-group value="payment">
                  <template v-slot:activator="{ props }">
                    <v-list-item v-bind="props" prepend-icon="mdi-credit-card-outline" title="Thanh Toán"></v-list-item>
                  </template>

                  <v-list-item @click="goToPaymentHistory" title="Lịch sử thanh toán"
                    prepend-icon="mdi-receipt-text-outline" value="history"></v-list-item>

                  <v-list-item @click="goToInstructPayment" title="Hướng Dẫn Thanh Toán"
                    prepend-icon="mdi-cash-multiple" value="guide"></v-list-item>
                </v-list-group>

                <!-- Lịch hoạt động -->
                <v-list-group value="Schedule">
                  <template v-slot:activator="{ props }">
                    <v-list-item v-bind="props" prepend-icon="mdi-calendar-clock" title="Lịch hoạt động"></v-list-item>
                  </template>

                  <v-list-item title="Lịch học" prepend-icon="mdi-calendar-text"
                    @click="goToStudySchedule"></v-list-item>

                  <v-list-item title="Sự kiện đặc biệt" prepend-icon="mdi-party-popper"
                    @click="goToEvents"></v-list-item>
                </v-list-group>

                <v-divider></v-divider>
                <!-- Đăng xuất - Cuối cùng -->
                <v-list-item title="Đăng xuất" prepend-icon="mdi-logout" @click="handleLogout" class="logout-item" />
              </v-list>
            </v-card>
          </transition>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, computed, onMounted } from "vue";
import { useRouter } from "vue-router";
import baseRequestClient from '../../../../core/baseRequestClient';

const hover = ref(false);
const hoverPost = ref(false);
const hoverCV = ref(false);
const hoverParent = ref(false);
const hoverProgramme = ref(false);

const router = useRouter();

// Reactive user info
const userInfo = ref({
  ho_ten: '',
  avatar: ''
});

// Load user info from API on mount
onMounted(async () => {
  if (isLoggedIn.value) {
    try {
      const res = await baseRequestClient.get('client/check-token');
      if (res.data.status) {
        userInfo.value = {
          ho_ten: res.data.ho_va_ten || res.data.ho_ten,
          avatar: res.data.avatar
        };
        // Also save to localStorage for persistence
        localStorage.setItem('ho_ten_phu_huynh', userInfo.value.ho_ten);
        localStorage.setItem('avatar_phu_huynh', userInfo.value.avatar || '');
      }
    } catch (err) {
      console.error('Failed to load user info:', err);
    }
  }
});

// Computed property để kiểm tra trạng thái đăng nhập
const isLoggedIn = computed(() => {
  try {
    const token = localStorage.getItem('token_phu_huynh');
    return !!token;
  } catch (e) {
    return false;
  }
});

// Lấy thông tin user
const userName = computed(() => {
  return userInfo.value.ho_ten || localStorage.getItem('ho_ten_phu_huynh') || 'Phụ huynh';
});

const userAvatar = computed(() => {
  const avatar = userInfo.value.avatar || localStorage.getItem('avatar_phu_huynh');
  if (avatar && avatar !== 'null' && avatar !== '') {
    return avatar;
  }
  return `https://ui-avatars.com/api/?name=${encodeURIComponent(userName.value)}&background=random`;
});

function goToLogin() {
  router.push('/login');
}

function goToRegister() {
  router.push('/register');
}

function goToPaymentHistory() {
  router.push("/paymentHistory");
}

function goToProfile() {
  router.push("/client/profile");
}

function goToHome() {
  router.push("/");
}
function goToBlog() {
  router.push("/blog");
}
function goToRecruitment() {
  router.push("/recruitment");
}
function goToContact() {
  router.push("/contact");
}
function goToAuth() {
  router.push("/auth");
}
function goToMeal() {
  router.push("/meal");
}
function goToTuition() {
  router.push("/tuition");
}
function goToStudySchedule() {
  router.push("/study-schedule");
}
function goToNotebook() {
  router.push("/notebook");
}
function goToProgramme() {
  router.push("/programme");
}
function goToMiddleProgramme() {
  router.push("/middle-programme");
}
function goToBigProgramme() {
  router.push("/big-programme");
}
function goToEvents() {
  router.push("/events");
}
function goToParentMailbox() {
  router.push("/parent-mail-box");
}
function goToSchoolBlog() {
  router.push("/school-blog");
}
function goToPrivacy() {
  router.push("/privacy");
}
function goToInstructPayment() {
  router.push("/instructPayment");
}
function goToParentBlogDetail() {
  router.push("/blog-detail");
}

function goToMessages() {
  router.push("/client/messages");
}

function handleLogout() {
  baseRequestClient
    .get('client/logout')
    .then((res) => {
      if (res.data.status) {
        // Xóa token và thông tin đăng nhập
        localStorage.removeItem('token_phu_huynh');
        localStorage.removeItem('ho_ten_phu_huynh');
        localStorage.removeItem('avatar_phu_huynh');

        // Redirect về trang login
        router.push('/login');
      }
    })
    .catch((err) => {
      console.error('Logout error:', err);
      // Vẫn xóa token và redirect về login nếu có lỗi
      localStorage.removeItem('token_phu_huynh');
      localStorage.removeItem('ho_ten_phu_huynh');
      localStorage.removeItem('avatar_phu_huynh');
      router.push('/login');
    });
}

const open = ref(["Notifications"]);
</script>
<style lang="scss">
@use "./style.scss";

.auth-buttons {
  display: flex;
  align-items: center;

  .btn-login {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 10px 24px;
    border-radius: 24px;
    font-weight: 500;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: none;
    outline: none;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.25);
    letter-spacing: 0.3px;

    i {
      font-size: 16px;
    }

    &:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(102, 126, 234, 0.35);
    }

    &:active {
      transform: translateY(0);
      box-shadow: 0 2px 6px rgba(102, 126, 234, 0.3);
    }
  }
}
</style>
