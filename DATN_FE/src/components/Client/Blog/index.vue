<template>
  <div class="blog-container">
    <div class="blog-main">
      <!-- Bài đăng mới nhất -->
      <p class="txt-new animate-on-scroll" data-animation="fade-up">
        Bài Đăng mới
      </p>

      <template v-if="list_bai_viet.length">
        <!-- Card đầu tiên -->
        <div class="form-new-post animate-on-scroll" data-animation="fade-up" data-delay="200">
          <div class="img-thumbnail animate-on-scroll" data-animation="slide-left">
            <img :src="list_bai_viet[0].hinh_anh" class="item-thumbnail" alt="" />
          </div>
          <div class="form-content animate-on-scroll" data-animation="slide-right" data-delay="300">
            <div class="form-status">
              <p class="item-new">News</p>
              <p class="item-inspiration">Inspiration</p>
              <p class="item-date">{{ formatDate(list_bai_viet[0].ngay_dang) }}</p>
            </div>
            <h3>{{ list_bai_viet[0].tieu_de }}</h3>
            <p class="txt-short">{{ list_bai_viet[0].noi_dung }}</p>
            <router-link :to="`/blog-detail/${list_bai_viet[0].id}`" class="btn-view">
              Xem Thêm →
            </router-link>


          </div>
        </div>

        <!-- Card còn lại -->
        <div class="form-posts item-post animate-on-scroll" data-animation="fade-up">
          <template v-for="(value, index) in list_bai_viet.slice(1)" :key="value.id">
            <div class="item-post animate-on-scroll" :data-delay="100 * index">
              <div class="form-img-post">
                <img :src="value.hinh_anh || require('@/assets/images/default-image.jpg')" class="img-post" alt="" />
              </div>
              <div class="form-detail">
                <div class="tags">
                  <span class="tag tag-news">News</span>
                  <span class="tag tag-inspiration">Inspiration</span>
                </div>
                <h3 class="post-title">{{ value.tieu_de }}</h3>
                <p class="post-desc">{{ value.noi_dung }}</p>
                <div class="author-info">
                  <img class="author-avatar"
                    :src="value.avatar_nguoi_dang || require('@/assets/images/default-avatar.png')" alt="avatar" />
                  <div class="author-meta">
                    <p class="author-name">{{ value.ten_tac_gia }}</p>
                    <p class="author-date">Đăng ngày: {{ formatDate(value.ngay_dang) }}</p>
                    <router-link :to="`/blog-detail/${value.id}`" class="btn-view">
                      Xem Thêm →
                    </router-link>

                  </div>
                </div>
              </div>
            </div>
          </template>
        </div>
      </template>

      <!-- Góc hoạt động -->
      <div class="blog-information animate-on-scroll" data-animation="fade-up">
        <div class="item-information">
          <h2 class="animate-on-scroll" data-animation="fade-up">
            Góc Hoạt Động – Hành Trình Gắn Kết & Phát Triển
          </h2>
          <p class="animate-on-scroll" data-animation="fade-up" data-delay="200">
            Chào mừng quý phụ huynh đến với chuyên mục Góc Hoạt Động – nơi ghi lại những khoảnh khắc đáng nhớ của thầy
            cô và
            các em học sinh...
          </p>
        </div>
      </div>

      <!-- Đăng ký nhận tin -->
      <div class="newsletter-container animate-on-scroll" data-animation="fade-up">
        <div class="newsletter-content">
          <div class="newsletter-text animate-on-scroll" data-animation="slide-left">
            <h2>Hãy để lại thông tin nếu cần</h2>
            <p>
              Đội ngũ nhân viên sẽ tư vấn và giải đáp các vấn đề còn thắc mắc của quý phụ huynh
            </p>
          </div>
          <div class="newsletter-form animate-on-scroll" data-animation="slide-right" data-delay="200">
            <div class="form-email">
              <input placeholder="Enter your email address.." />
              <button>Contact Now</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import baseRequestClient from '../../../core/baseRequestClient';

export default {
  data() {
    return {
      list_bai_viet: [],
    };
  },
  mounted() {
    this.loadData();
    this.$nextTick(() => {
      this.setupScrollAnimations();
      window.addEventListener('scroll', this.handleScroll);
    });
  },
  beforeUnmount() {
    window.removeEventListener('scroll', this.handleScroll);
  },
  methods: {
    async loadData() {
      try {
        const res = await baseRequestClient.get('client/bai-viet/data');
        if (res.data.status) {
          this.list_bai_viet = res.data.data;
          this.$toast.success(res.data.message);
          this.$nextTick(() => {
            this.handleScroll();
          });
        } else {
          this.$toast.error(res.data.message);
        }
      } catch (err) {
        const listErr = err.response?.data?.errors;
        if (listErr) {
          Object.values(listErr).forEach((error) => this.$toast.error(error[0]));
        } else {
          this.$toast.error('Có lỗi xảy ra khi tải dữ liệu');
        }
      }
    },
    setupScrollAnimations() {
      const elements = document.querySelectorAll('.animate-on-scroll');
      elements.forEach((el) => {
        const animation = el.dataset.animation || 'fade-up';
        el.classList.add(`animate-${animation}`);
      });
      this.handleScroll();
    },
    handleScroll() {
      const elements = document.querySelectorAll('.animate-on-scroll');
      elements.forEach((el) => {
        const elementTop = el.getBoundingClientRect().top;
        const elementBottom = el.getBoundingClientRect().bottom;
        const windowHeight = window.innerHeight;

        if (elementTop < windowHeight && elementBottom > 0) {
          el.classList.add('animate-visible');
        } else {
          el.classList.remove('animate-visible');
        }
      });
    },
    formatDate(date) {
      const d = new Date(date);
      return d.toLocaleDateString('vi-VN');
    },
  },
};
</script>

<style lang="scss">
@use './style.scss';
</style>
