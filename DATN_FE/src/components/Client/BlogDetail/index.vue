<template>
  <div class="blog-detail-container">
    <aside class="sidebar">
      <h3>Mục lục</h3>
      <ul>
        <li><a href="#section1">1. Nội Dung Chi Tiết</a></li>
      </ul>
    </aside>

    <div class="main-content" v-if="bai_viet">
      <h1>{{ bai_viet.tieu_de }}</h1>
      <div class="post-meta" style="margin-bottom: 20px; color: #666; font-style: italic;">
        <span v-if="bai_viet.ten_tac_gia" style="margin-right: 15px;">
          <i class="fas fa-user-edit"></i> {{ bai_viet.ten_tac_gia }}
        </span>
        <span>
          <i class="far fa-clock"></i> {{ formatDate(bai_viet.ngay_dang) }}
        </span>
      </div>
      
      <img
        class="banner-img"
        :src="bai_viet.hinh_anh"
        :alt="bai_viet.tieu_de"
        v-if="bai_viet.hinh_anh"
      />

      <div class="highlight-box" v-if="bai_viet.mo_ta_ngan">
        <h2>{{ bai_viet.mo_ta_ngan }}</h2>
      </div>

      <section id="section1">
        <div class="content-body" v-html="bai_viet.noi_dung"></div>
      </section>
    </div>
    <div v-else class="main-content text-center">
      <p>Đang tải dữ liệu bài viết...</p>
    </div>
  </div>
</template>
<script>
import baseRequestClient from '../../../core/baseRequestClient';

export default {
  data() {
    return {
      bai_viet: null,
    };
  },
  mounted() {
    this.loadData();
    // Scroll animation logic retained if needed later
    this.$nextTick(() => {
      this.setupScrollAnimations();
      window.addEventListener('scroll', this.handleScroll);
    });
  },
  beforeUnmount() {
    window.removeEventListener('scroll', this.handleScroll);
  },
  watch: {
    '$route.params.id': function(newId) {
      if(newId) this.loadData();
    }
  },
  methods: {
    async loadData() {
      try {
        const id = this.$route.params.id;
        if (!id) return;
        
        // Fallback: Fetch all data and filter client-side since specific endpoint might not exist
        const res = await baseRequestClient.get('client/bai-viet/data');
        if (res.data.status) {
          const allPosts = res.data.data;
          // Ensure we compare strings/numbers correctly
          this.bai_viet = allPosts.find(post => post.id == id);
          
          if (!this.bai_viet) {
            this.$toast.error('Không tìm thấy bài viết');
          } else {
            this.$nextTick(() => {
              this.handleScroll();
            });
          }
        } else {
          this.$toast.error(res.data.message);
        }
      } catch (err) {
        const listErr = err.response?.data?.errors;
        if (listErr) {
          Object.values(listErr).forEach((error) => this.$toast.error(error[0]));
        } else {
          this.$toast.error('Có lỗi xảy ra khi tải dữ liệu bài viết');
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
      if (!date) return '';
      const d = new Date(date);
      return d.toLocaleDateString('vi-VN');
    },
  },
};
</script>

<style lang="scss">
@use "./style.scss";
</style>
