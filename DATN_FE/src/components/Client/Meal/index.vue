<template>
  <div class="meal-container">
    <div class="form-swiper scroll-reveal" data-delay="0">
      <swiper
        :modules="modules"
        :pagination="{ clickable: true }"
        class="mySwiper"
      >
        <swiper-slide>
          <img
            src="../../../assets/images/Home/COVER_WEB_831a2a5ba4.jpg"
            class="slide-image"
            alt="slide 1"
          />
        </swiper-slide>
        <swiper-slide>
          <img
            src="../../../assets/images/Home/COVER_WEB_831a2a5ba4.jpg"
            class="slide-image"
            alt="slide 2"
          />
        </swiper-slide>
      </swiper>
    </div>
    <div class="meal-main">
      <h1 class="scroll-reveal" data-delay="200">THỰC HƠN DÀNH CHO BÉ</h1>
      <div class="form-posts">
        <div class="item-post scroll-reveal" data-delay="400">
          <div class="form-img-post">
            <img
              class="img-post"
              src="../../../assets/images/Home/thuc-don-cho-tre-5-tuoi-bieng-an.jpg.webp"
              alt=""
            />
          </div>
          <div class="form-detail">
            <div class="tags">
              <span class="tag tag-news">News</span>
              <span class="tag tag-inspiration">Inspiration</span>
            </div>
            <h3 class="post-title">Nay Bé Ăn Gì:Thực Đơn Cho Các Bé</h3>
            <p class="post-desc">
              thực đơn ăn của các bé được cái chuyên gia dinh dưỡng điều chỉnh
              phụ hợp với các bé giúp bé phát triển
            </p>
            <div class="author-info">
              <img
                class="author-avatar"
                src="../../../assets/images/Home/487997467_1413613139801823_4624082158516736839_n.jpg"
                alt="hhhh"
              />
              <div class="author-meta">
                <p class="author-name">Quang Trường</p>
                <p class="author-date">Đăng ngày: 17/07/2025</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="form-btn scroll-reveal" data-delay="600">
        <button class="btn-show">Xem Thêm</button>
      </div>
    </div>
  </div>
</template>
<script setup>
import { Swiper, SwiperSlide } from "swiper/vue";
import { Pagination } from "swiper/modules";
import { onMounted, onUnmounted } from 'vue';

import "swiper/css";
import "swiper/css/pagination";

const modules = [Pagination];

let observer;

onMounted(() => {
  // Tạo Intersection Observer
  observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const delay = entry.target.dataset.delay || 0;
        setTimeout(() => {
          entry.target.classList.add('revealed');
        }, delay);
        observer.unobserve(entry.target);
      }
    });
  }, {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
  });

  // Quan sát tất cả các phần tử có class scroll-reveal
  const scrollElements = document.querySelectorAll('.scroll-reveal');
  scrollElements.forEach(el => observer.observe(el));
});

onUnmounted(() => {
  if (observer) {
    observer.disconnect();
  }
});
</script>

<style lang="scss">
@use "./style.scss";
</style>
