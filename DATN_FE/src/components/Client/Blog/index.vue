<template>
  <div class="blog-container">
    <div class="blog-main">
      <p class="txt-new animate-on-scroll" data-animation="fade-up">
        Bài Đăng mới
      </p>
      <div
        class="form-new-post animate-on-scroll"
        data-animation="fade-up"
        data-delay="200"
      >
        <div
          class="img-thumbnail animate-on-scroll"
          data-animation="slide-left"
        >
          <img
            class="item-thumbnail"
            src="../../../assets/images/Home/IMG_3071-scaled (1).jpg"
            alt=""
          />
        </div>
        <div
          class="form-content animate-on-scroll"
          data-animation="slide-right"
          data-delay="300"
        >
          <div class="form-status">
            <p class="item-new">News</p>
            <p class="item-inspiration">Inspiration</p>
            <p class="item-date">17/07/2025</p>
          </div>
          <h3>Vẽ Tranh Ngoại Cảnh Cùng Bé</h3>
          <p class="txt-short">
            Một buổi sáng đầy nắng, các bé cùng nhau trải nghiệm hoạt động vẽ
            tranh ngoài trời tại sân trường. Với giấy, bút màu và trí tưởng
            tượng phong phú, các bé đã ghi lại khung cảnh thiên nhiên xung quanh
            bằng những nét vẽ ngộ nghĩnh, sinh động. Hoạt động không chỉ giúp bé
            phát triển khả năng quan sát và sáng tạo, mà còn mang lại niềm vui,
            sự thư giãn và gắn kết với bạn bè.
          </p>
          <button class="btn-view">Xem Thêm</button>
        </div>
      </div>
      <div class="blog-information animate-on-scroll" data-animation="fade-up">
        <div class="item-information">
          <h2 class="animate-on-scroll" data-animation="fade-up">
            Góc Hoạt Động – Hành Trình Gắn Kết & Phát Triển
          </h2>
          <p
            class="animate-on-scroll"
            data-animation="fade-up"
            data-delay="200"
          >
            Chào mừng quý phụ huynh đến với chuyên mục Góc Hoạt Động – nơi ghi
            lại những khoảnh khắc đáng nhớ của thầy cô và các em học sinh qua
            từng sự kiện, chương trình ngoại khóa, và hoạt động trải nghiệm. Mỗi
            bài viết là một câu chuyện sống động, thể hiện sự sáng tạo, đoàn kết
            và tinh thần học tập tích cực trong môi trường giáo dục thân thiện
            và hiện đại.
          </p>
        </div>
      </div>
      <div
        class="form-posts item-post animate-on-scroll"
        @click="goToParentBlogDetail"
        data-animation="fade-up"
      >
        <div
          class="item-post animate-on-scroll"
          data-animation="fade-up"
          data-delay="100"
        >
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
        <div
          class="item-post animate-on-scroll"
          data-animation="fade-up"
          data-delay="200"
        >
          <div class="form-img-post">
            <img
              class="img-post"
              src="../../../assets/images/Home/lich-hoat-dong-cua-tre-tai-truong-mam-non.jpg_636767702616441017.jpg"
              alt=""
            />
          </div>
          <div class="form-detail">
            <div class="tags">
              <span class="tag tag-news">News</span>
              <span class="tag tag-inspiration">Inspiration</span>
            </div>
            <h3 class="post-title">Lịch Hoạt Động: Lịch Học Tập Của Các Bé</h3>
            <p class="post-desc">
              lịch sẽ được thay đổi 6 tháng một lần và lịch nghỉ hè của các bé
              và được thông báo cho quý phụ huynh
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
        <div
          class="item-post animate-on-scroll"
          data-animation="fade-up"
          data-delay="300"
        >
          <div class="form-img-post">
            <img
              class="img-post"
              src="../../../assets/images/Home/mam.png"
              alt=""
            />
          </div>
          <div class="form-detail">
            <div class="tags">
              <span class="tag tag-news">News</span>
              <span class="tag tag-inspiration">Inspiration</span>
            </div>
            <h3 class="post-title">Hoạt Động Cuối Ngày:Các Mầm Non Yêu Nước</h3>
            <p class="post-desc">
              Các bé đang chào mừng kỷ niệm 50 ngày giải phóng Niềm Nam,thống
              nhất đất nước
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
        <div
          class="item-post animate-on-scroll"
          data-animation="fade-up"
          data-delay="400"
        >
          <div class="form-img-post">
            <img
              class="img-post"
              src="../../../assets/images/Home/cac-tro-choi-tieng-anh-cho-tre-mam-non.jpg"
              alt=""
            />
          </div>
          <div class="form-detail">
            <div class="tags">
              <span class="tag tag-news">News</span>
              <span class="tag tag-inspiration">Inspiration</span>
            </div>
            <h3 class="post-title">
              Ngoại Khóa: Các Bé Đang Luyện Tập Nói Cùng Giảng Viên
            </h3>
            <p class="post-desc">
              Buổi trò chuyện giúp các bé tự tin hơn khi được tiếp xúc với người
              nước ngoài và tạo ra được kĩ năng giao tiếp
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
        <div
          class="item-post animate-on-scroll"
          data-animation="fade-up"
          data-delay="500"
        >
          <div class="form-img-post">
            <img
              class="img-post"
              src="../../../assets/images/Home/IMG_3071-scaled (1).jpg"
              alt=""
            />
          </div>
          <div class="form-detail">
            <div class="tags">
              <span class="tag tag-news">News</span>
              <span class="tag tag-inspiration">Inspiration</span>
            </div>
            <h3 class="post-title">Vẽ Tranh Ngoại Cảnh Cùng Bé</h3>
            <p class="post-desc">
              Một buổi sáng đầy nắng, các bé cùng nhau trải nghiệm hoạt động vẽ
              tranh ngoài trời tại sân trường.
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
      <div
        class="newsletter-container animate-on-scroll"
        data-animation="fade-up"
      >
        <div class="newsletter-content">
          <div
            class="newsletter-text animate-on-scroll"
            data-animation="slide-left"
          >
            <h2>Hãy để lại thông tin nếu cần</h2>
            <p>
              Đội ngũ nhân viên nhân sẽ tư vấn và giải đáp các vấn đề còn thắc
              mắc của các quý phụ huynh
            </p>
          </div>
          <div
            class="newsletter-form animate-on-scroll"
            data-animation="slide-right"
            data-delay="200"
          >
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
<script setup>
import { useRouter } from "vue-router";
import { onMounted, onUnmounted } from "vue";

const router = useRouter();
let observer = null;

function goToParentBlogDetail() {
  router.push("/blog-detail");
}

const initScrollAnimation = () => {
  observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const element = entry.target;
          const animation = element.dataset.animation;
          const delay = element.dataset.delay || 0;

          setTimeout(() => {
            element.classList.add("animate-visible");
            if (animation) {
              element.classList.add(`animate-${animation}`);
            }
          }, delay);

          observer.unobserve(element);
        }
      });
    },
    {
      threshold: 0.1,
      rootMargin: "0px 0px -50px 0px",
    }
  );

  const animatedElements = document.querySelectorAll(".animate-on-scroll");
  animatedElements.forEach((element) => {
    observer.observe(element);
  });
};

onMounted(() => {
  setTimeout(() => {
    initScrollAnimation();
  }, 100);
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
