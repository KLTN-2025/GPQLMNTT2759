<template>
  <div class="header-top">
    <div class="header-menu">
      <div class="header-logo">Hoa Sen</div>
      <div class="form-nav">
        <div class="nav-menu">
          <div class="item-home" @click="goToHome">Trang chủ</div>
          <div
            class="post-wrapper"
            @mouseenter="hoverPost = true"
            @mouseleave="hoverPost = false"
          >
            <div class="item-home">Bài Viết</div>
            <transition name="fade-slide">
              <v-card class="blog-dropdown" v-show="hoverPost">
                <v-list v-model:opened="open">
                  <v-list-item
                    @click="goToBlog"
                    title="Hành Trình Của Bé"
                    class="logout-item"
                  />
                  <v-list-item
                    @click="goToSchoolBlog"
                    title="Nhà Trường"
                    class="logout-item"
                  />
                </v-list>
              </v-card>
            </transition>
          </div>
          <div
            class="post-wrapper"
            @mouseenter="hoverCV = true"
            @mouseleave="hoverCV = false"
          >
            <div class="item-home">Tuyển Sinh</div>
            <transition name="fade-slide">
              <v-card class="blog-dropdown" v-show="hoverCV">
                <v-list v-model:opened="open">
                  <v-list-item
                    @click="goToRecruitment"
                    title="Thông Tin Tuyển Sinh"
                    class="logout-item"
                  />

                  <v-list-item
                    @click="goToTuition"
                    title="Học Phí"
                    class="logout-item"
                  />
                </v-list>
              </v-card>
            </transition>
          </div>
          <div
            class="post-wrapper"
            @mouseenter="hoverProgramme = true"
            @mouseleave="hoverProgramme = false"
          >
            <div class="item-home">Chương Trình Học</div>
            <transition name="fade-slide">
              <v-card class="blog-dropdown" v-show="hoverProgramme">
                <v-list v-model:opened="open">
                  <v-list-item
                    @click="goToProgramme"
                    title="Lớp Mầm"
                    class="logout-item"
                  />

                  <v-list-item
                    @click="goToMiddleProgramme"
                    title="Lớp Chòi"
                    class="logout-item"
                  />

                  <v-list-item
                    @click="goToBigProgramme"
                    title="Lớp Lớn"
                    class="logout-item"
                  />
                </v-list>
              </v-card>
            </transition>
          </div>
          <div
            class="post-wrapper"
            @mouseenter="hoverParent = true"
            @mouseleave="hoverParent = false"
          >
            <div class="item-home">Góc Phụ Huynh</div>
            <transition name="fade-slide">
              <v-card class="blog-dropdown" v-show="hoverParent">
                <v-list v-model:opened="open">
                  <v-list-item
                    @click="goToMeal"
                    title="Thực Đơn Của Bé"
                    class="logout-item"
                  />
                  <v-list-item
                    @click="goToNotebook"
                    title="Sổ Tay Phụ Huynh"
                    class="logout-item"
                  />
                </v-list>
              </v-card>
            </transition>
          </div>
          <div class="item-home" @click="goToContact">Liên hệ</div>
        </div>

        <div
          class="avatar-wrapper"
          @mouseenter="hover = true"
          @mouseleave="hover = false"
        >
          <div class="form-avatar">
            <p>Quang Trường</p>
            <div class="img-avatar">
              <img
                class="avatar"
                src="../../../../assets/images/Home/487997467_1413613139801823_4624082158516736839_n.jpg"
                alt=""
              />
            </div>
          </div>
          <transition name="fade-slide">
            <v-card class="mx-auto" width="300" v-show="hover">
              <v-list v-model:opened="open">
                <v-list-group value="Notifications">
                  <template v-slot:activator="{ props }">
                    <v-list-item
                      v-bind="props"
                      prepend-icon="mdi-bell-outline"
                      title="Thông Báo"
                    ></v-list-item>
                  </template>

                  <v-list-item
                    @click="goToParentMailbox"
                    title="Phụ huynh"
                    prepend-icon="mdi-account-outline"
                    value="parent-notice"
                  ></v-list-item>
                </v-list-group>
                <v-list-group value="Settings">
                  <template v-slot:activator="{ props }">
                    <v-list-item
                      v-bind="props"
                      prepend-icon="mdi-cog-outline"
                      title="Cài Đặt"
                    ></v-list-item>
                  </template>

                  <v-list-item
                    title="Quyền riêng tư"
                    prepend-icon="mdi-lock-outline"
                    value="privacy"
                    @click="goToPrivacy"
                  ></v-list-item>

                  <v-list-item
                    @click="goToAuth"
                    title="Thông tin cá nhân"
                    prepend-icon="mdi-account-box-outline"
                    value="profile"
                  ></v-list-item>
                </v-list-group>
                <v-list-group value="payment">
                  <template v-slot:activator="{ props }">
                    <v-list-item
                      v-bind="props"
                      prepend-icon="mdi-credit-card-outline"
                      title="Thanh Toán"
                    ></v-list-item>
                  </template>

                  <v-list-item
                    @click="goToPaymentHistory"
                    title="Lịch sử thanh toán"
                    prepend-icon="mdi-receipt-text-outline"
                    value="history"
                  ></v-list-item>

                  <v-list-item
                    @click="goToInstructPayment"
                    title="Hướng Dẫn Thanh Toán"
                    prepend-icon="mdi-cash-multiple"
                    value="guide"
                  ></v-list-item>
                </v-list-group>

                <v-list-group value="Schedule">
                  <template v-slot:activator="{ props }">
                    <v-list-item
                      v-bind="props"
                      prepend-icon="mdi-calendar-clock"
                      title="Lịch hoạt động"
                    ></v-list-item>
                  </template>

                  <v-list-item
                    title="Lịch học"
                    prepend-icon="mdi-calendar-text"
                    @click="goToStudySchedule"
                  ></v-list-item>

                  <v-list-item
                    title="Sự kiện đặc biệt"
                    prepend-icon="mdi-party-popper"
                    @click="goToEvents"
                  ></v-list-item>
                </v-list-group>
                <v-list-item
                  title="Đăng xuất"
                  prepend-icon="mdi-logout"
                  @click="handleLogout"
                  class="logout-item"
                />
              </v-list>
            </v-card>
          </transition>
        </div>
      </div>
    </div>
  </div>
  <ChatAI />
</template>
<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import ChatAI from "../ChatAI/index.vue";

const hover = ref(false);
const hoverPost = ref(false);
const hoverCV = ref(false);
const hoverParent = ref(false);
const hoverProgramme = ref(false);

const router = useRouter();

function goToPaymentHistory() {
  router.push("/paymentHistory");
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
const open = ref(["Notifications"]);
</script>
<style lang="scss">
@use "./style.scss";
</style>
