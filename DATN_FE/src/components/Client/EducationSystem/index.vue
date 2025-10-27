<template>
  <div class="education-system-container">
    <!-- Hero Section -->
    <section class="hero-section">
      <div class="hero-background">
        <div class="floating-shapes">
          <div class="shape shape-1"></div>
          <div class="shape shape-2"></div>
          <div class="shape shape-3"></div>
        </div>
      </div>
      <div class="hero-content">
        <h1 class="hero-title animate-fade-up">Hệ Thống Giáo Dục Hiện Đại</h1>
        <p class="hero-subtitle animate-fade-up delay-200">
          Nơi thấu hiểu được nỗi lo của phụ huynh đối với con em
        </p>
        <div class="hero-stats animate-fade-up delay-400">
          <div class="stat-item">
            <span class="stat-number">15+</span>
            <span class="stat-label">Năm kinh nghiệm</span>
          </div>
          <div class="stat-item">
            <span class="stat-number">500+</span>
            <span class="stat-label">Học sinh</span>
          </div>
          <div class="stat-item">
            <span class="stat-number">98%</span>
            <span class="stat-label">Hài lòng</span>
          </div>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
      <div class="container">
        <h2 class="section-title animate-fade-up">Đặc Điểm Nổi Bật</h2>
        <div class="features-grid">
          <div
            class="feature-card animate-slide-up"
            v-for="(feature, index) in features"
            :key="index"
            :style="{ animationDelay: index * 100 + 'ms' }"
          >
            <div class="feature-icon">
              <i :class="feature.icon"></i>
            </div>
            <h3>{{ feature.title }}</h3>
            <p>{{ feature.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Technology Section -->
    <section class="technology-section">
      <div class="container">
        <div class="tech-content">
          <div class="tech-left animate-slide-left">
            <h2>Công Nghệ Giáo Dục Tiên Tiến</h2>
            <p>
              Chúng tôi áp dụng những công nghệ giáo dục tiên tiến nhất để mang
              lại trải nghiệm học tập tốt nhất cho trẻ em.
            </p>
            <div class="tech-features">
              <div
                class="tech-feature"
                v-for="(tech, index) in technologies"
                :key="index"
              >
                <div class="tech-icon">
                  <i :class="tech.icon"></i>
                </div>
                <div class="tech-info">
                  <h4>{{ tech.name }}</h4>
                  <p>{{ tech.description }}</p>
                </div>
              </div>
            </div>
          </div>
          <div class="tech-right animate-slide-right">
            <div class="tech-visual">
              <div class="tech-circle">
                <div
                  class="tech-item"
                  v-for="(item, index) in techItems"
                  :key="index"
                  :style="{
                    transform: `rotate(${index * 60}deg) translateY(-120px)`,
                  }"
                >
                  <div
                    class="tech-item-inner"
                    :style="{ transform: `rotate(${-index * 60}deg)` }"
                  >
                    <i :class="item.icon"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Programs Section -->
    <section class="programs-section">
      <div class="container">
        <h2 class="section-title animate-fade-up">Chương Trình Giáo Dục</h2>
        <div class="programs-tabs">
          <button
            v-for="(program, index) in programs"
            :key="index"
            :class="['tab-button', { active: activeTab === index }]"
            @click="activeTab = index"
          >
            {{ program.name }}
          </button>
        </div>
        <div class="program-content">
          <transition name="fade" mode="out-in">
            <div :key="activeTab" class="program-details">
              <div class="program-left">
                <h3>{{ programs[activeTab].title }}</h3>
                <p>{{ programs[activeTab].description }}</p>
                <ul class="program-benefits">
                  <li
                    v-for="(benefit, index) in programs[activeTab].benefits"
                    :key="index"
                  >
                    <i class="fas fa-check-circle"></i>
                    {{ benefit }}
                  </li>
                </ul>
                <button class="cta-button">Tìm hiểu thêm</button>
              </div>
              <div class="program-right">
                <img
                  :src="programs[activeTab].image"
                  :alt="programs[activeTab].name"
                />
              </div>
            </div>
          </transition>
        </div>
      </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section">
      <div class="container">
        <h2 class="section-title animate-fade-up">Phản Hồi Từ Phụ Huynh</h2>
        <div class="testimonials-slider">
          <div
            class="testimonial-card"
            v-for="(testimonial, index) in testimonials"
            :key="index"
          >
            <div class="testimonial-content">
              <div class="quote-icon">
                <i class="fas fa-quote-left"></i>
              </div>
              <p>{{ testimonial.content }}</p>
              <div class="testimonial-author">
                <img :src="testimonial.avatar" :alt="testimonial.name" />
                <div class="author-info">
                  <h4>{{ testimonial.name }}</h4>
                  <span>{{ testimonial.role }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
      <div class="container">
        <div class="cta-content animate-fade-up">
          <h2>Sẵn sàng cho con bạn trải nghiệm?</h2>
          <p>
            Hãy liên hệ với chúng tôi để được tư vấn chi tiết về chương trình
            giáo dục phù hợp
          </p>
          <div class="cta-buttons">
            <button class="btn-primary">Đăng ký tham quan</button>
            <button class="btn-secondary">Tư vấn miễn phí</button>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import { ref, onMounted } from "vue";

export default {
  name: "EducationSystem",
  setup() {
    const activeTab = ref(0);

    const features = ref([
      {
        icon: "fas fa-brain",
        title: "Phát triển tư duy",
        description:
          "Kích thích khả năng tư duy logic và sáng tạo của trẻ thông qua các hoạt động thực hành",
      },
      {
        icon: "fas fa-users",
        title: "Học tập nhóm",
        description:
          "Phát triển kỹ năng giao tiếp và làm việc nhóm qua các dự án chung",
      },
      {
        icon: "fas fa-laptop",
        title: "Công nghệ hiện đại",
        description:
          "Tích hợp công nghệ giáo dục tiên tiến để tăng hiệu quả học tập",
      },
      {
        icon: "fas fa-heart",
        title: "Chăm sóc tận tình",
        description:
          "Đội ngũ giáo viên tận tâm, luôn quan tâm đến sự phát triển của từng em",
      },
      {
        icon: "fas fa-shield-alt",
        title: "An toàn tuyệt đối",
        description:
          "Môi trường học tập an toàn với hệ thống bảo mật và giám sát 24/7",
      },
      {
        icon: "fas fa-star",
        title: "Chất lượng cao",
        description:
          "Chương trình giáo dục được thiết kế theo tiêu chuẩn quốc tế",
      },
    ]);

    const technologies = ref([
      {
        icon: "fas fa-tablet-alt",
        name: "Học tập tương tác",
        description:
          "Sử dụng tablet và ứng dụng giáo dục để tăng tính tương tác",
      },
      {
        icon: "fas fa-vr-cardboard",
        name: "Thực tế ảo",
        description: "Trải nghiệm học tập sống động qua công nghệ VR",
      },
      {
        icon: "fas fa-robot",
        name: "AI hỗ trợ",
        description: "Trí tuệ nhân tạo cá nhân hóa quá trình học tập",
      },
    ]);

    const techItems = ref([
      { icon: "fas fa-laptop" },
      { icon: "fas fa-tablet" },
      { icon: "fas fa-mobile" },
      { icon: "fas fa-tv" },
      { icon: "fas fa-headphones" },
      { icon: "fas fa-camera" },
    ]);

    const programs = ref([
      {
        name: "Mầm non",
        title: "Chương trình Mầm non (2-5 tuổi)",
        description:
          "Phát triển toàn diện các kỹ năng cơ bản cho trẻ từ 2-5 tuổi thông qua các hoạt động vui chơi và học tập.",
        benefits: [
          "Phát triển kỹ năng vận động tinh và thô",
          "Kích thích khả năng ngôn ngữ và giao tiếp",
          "Xây dựng tính tự lập và tự tin",
          "Học tập qua trò chơi và hoạt động thực hành",
        ],
        image:
          "/src/assets/images/Home/yJmRfMFSaXQT1sSjqAHwVugU16912mVG1sUG7yhe.jpeg",
      },
      {
        name: "Tiền tiểu học",
        title: "Chương trình Tiền tiểu học (5-6 tuổi)",
        description:
          "Chuẩn bị cho trẻ những kỹ năng cần thiết để bước vào môi trường tiểu học một cách tự tin.",
        benefits: [
          "Làm quen với chữ cái và số đếm cơ bản",
          "Phát triển khả năng tập trung và kiên nhẫn",
          "Kỹ năng giải quyết vấn đề đơn giản",
          "Chuẩn bị tâm lý cho môi trường học đường",
        ],
        image: "/src/assets/images/Home/2-6.jpg",
      },
      {
        name: "Ngoại khóa",
        title: "Hoạt động Ngoại khóa",
        description:
          "Các hoạt động bổ trợ giúp trẻ phát triển đa dạng về thể chất, tinh thần và kỹ năng sống.",
        benefits: [
          "Các lớp học nghệ thuật và âm nhạc",
          "Hoạt động thể thao và vận động",
          "Câu lạc bộ khoa học và khám phá",
          "Kỹ năng sống và giao tiếp xã hội",
        ],
        image:
          "/src/assets/images/Home/hoat-dong-ngoai-khoa-o-truong-tieu-hoc-3.png",
      },
    ]);

    const testimonials = ref([
      {
        content:
          "Con tôi đã thay đổi rất nhiều kể từ khi học tại Hoa Sen. Bé trở nên tự tin hơn và rất yêu thích việc học.",
        name: "Chị Nguyễn Thị Lan",
        role: "Phụ huynh học sinh Minh An",
        avatar: "/src/assets/images/avatars/avatar-1.png",
      },
      {
        content:
          "Môi trường học tập tại đây rất tốt, các cô giáo rất tận tâm và chương trình học rất phù hợp với lứa tuổi.",
        name: "Anh Trần Văn Nam",
        role: "Phụ huynh học sinh Bảo Ngọc",
        avatar: "/src/assets/images/avatars/avatar-2.png",
      },
      {
        content:
          "Tôi rất hài lòng với chất lượng giáo dục và sự chăm sóc mà nhà trường dành cho các em nhỏ.",
        name: "Chị Lê Thị Hoa",
        role: "Phụ huynh học sinh Quang Minh",
        avatar: "/src/assets/images/avatars/avatar-3.png",
      },
    ]);

    onMounted(() => {
      // Animation observers
      const observerOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px",
      };

      const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("animate");
          }
        });
      }, observerOptions);

      document
        .querySelectorAll(
          ".animate-fade-up, .animate-slide-up, .animate-slide-left, .animate-slide-right"
        )
        .forEach((el) => {
          observer.observe(el);
        });
    });

    return {
      activeTab,
      features,
      technologies,
      techItems,
      programs,
      testimonials,
    };
  },
};
</script>
<style lang="scss">
@use "./style.scss";
</style>
