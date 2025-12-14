<template>
  <div class="advantages-container">
    <!-- Hero Section -->
    <section class="hero-section">
      <div class="hero-background">
        <div class="animated-bg">
          <div class="floating-element element-1"></div>
          <div class="floating-element element-2"></div>
          <div class="floating-element element-3"></div>
        </div>
      </div>
      <div class="hero-content">
        <div class="hero-badge animate-fade-up">🏆 Top 500 Châu Á</div>
        <h1 class="hero-title animate-fade-up delay-200">
          Ưu Điểm Vượt Trội Của Hoa Sen
        </h1>
        <p class="hero-subtitle animate-fade-up delay-400">
          Thuộc hệ thống giáo dục hàng đầu của châu Á với những thành tựu đáng
          tự hào
        </p>
        <div class="hero-stats animate-fade-up delay-600">
          <div class="stat-card">
            <div class="stat-icon">🎓</div>
            <div class="stat-number">500+</div>
            <div class="stat-label">Trường hàng đầu</div>
          </div>
          <div class="stat-card">
            <div class="stat-icon">🌟</div>
            <div class="stat-number">15+</div>
            <div class="stat-label">Năm kinh nghiệm</div>
          </div>
          <div class="stat-card">
            <div class="stat-icon">👨‍🎓</div>
            <div class="stat-number">10,000+</div>
            <div class="stat-label">Học sinh</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Main Advantages Section -->
    <section class="main-advantages">
      <div class="container">
        <div class="section-header">
          <h2 class="section-title animate-fade-up">Những Ưu Điểm Nổi Bật</h2>
          <p class="section-subtitle animate-fade-up delay-200">
            Khám phá những điểm mạnh giúp Hoa Sen trở thành lựa chọn hàng đầu
          </p>
        </div>

        <div class="advantages-grid">
          <div
            class="advantage-card animate-slide-up"
            v-for="(advantage, index) in advantages"
            :key="index"
            :style="{ animationDelay: index * 100 + 'ms' }"
          >
            <div class="card-header">
              <div
                class="advantage-icon"
                :style="{ background: advantage.color }"
              >
                <i :class="advantage.icon"></i>
              </div>
              <div class="advantage-number">
                {{ String(index + 1).padStart(2, "0") }}
              </div>
            </div>
            <div class="card-content">
              <h3>{{ advantage.title }}</h3>
              <p>{{ advantage.description }}</p>
              <ul class="advantage-features">
                <li
                  v-for="(feature, fIndex) in advantage.features"
                  :key="fIndex"
                >
                  <i class="fas fa-check-circle"></i>
                  {{ feature }}
                </li>
              </ul>
            </div>
            <div class="card-footer">
              <button
                class="learn-more-btn"
                @click="openModal(advantage, index)"
              >
                Tìm hiểu thêm
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Rankings Section -->
    <section class="rankings-section">
      <div class="container">
        <div class="rankings-content">
          <div class="rankings-left animate-slide-left">
            <h2>Thứ Hạng Quốc Tế</h2>
            <p>
              Hoa Sen tự hào là một trong những trường mầm non được xếp hạng cao
              nhất khu vực châu Á
            </p>
            <div class="ranking-items">
              <div
                class="ranking-item"
                v-for="(ranking, index) in rankings"
                :key="index"
              >
                <div class="ranking-position">{{ ranking.position }}</div>
                <div class="ranking-info">
                  <h4>{{ ranking.title }}</h4>
                  <p>{{ ranking.description }}</p>
                </div>
              </div>
            </div>
          </div>
          <div class="rankings-right animate-slide-right">
            <div class="ranking-visual">
              <div class="trophy-container">
                <div class="trophy">
                  <i class="fas fa-trophy"></i>
                </div>
                <div class="ranking-badges">
                  <div class="badge badge-1">Top 100</div>
                  <div class="badge badge-2">5 ⭐</div>
                  <div class="badge badge-3">ISO 9001</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Comparison Section -->
    <section class="comparison-section">
      <div class="container">
        <h2 class="section-title animate-fade-up">
          So Sánh Với Các Trường Khác
        </h2>
        <div class="comparison-table animate-fade-up delay-200">
          <div class="table-header">
            <div class="feature-col">Tiêu chí</div>
            <div class="school-col hoa-sen">Hoa Sen</div>
            <div class="school-col other">Trường khác</div>
          </div>
          <div class="table-body">
            <div
              class="table-row"
              v-for="(comparison, index) in comparisons"
              :key="index"
            >
              <div class="feature-col">{{ comparison.feature }}</div>
              <div class="school-col hoa-sen">
                <i class="fas fa-check-circle"></i>
                {{ comparison.hoaSen }}
              </div>
              <div class="school-col other">
                <i class="fas fa-times-circle"></i>
                {{ comparison.others }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section">
      <div class="container">
        <h2 class="section-title animate-fade-up">Phản Hồi Từ Phụ Huynh</h2>
        <div class="testimonials-slider">
          <div
            class="testimonial-track"
            :style="{ transform: `translateX(-${currentTestimonial * 100}%)` }"
          >
            <div
              class="testimonial-slide"
              v-for="(testimonial, index) in testimonials"
              :key="index"
            >
              <div class="testimonial-card">
                <div class="testimonial-header">
                  <img
                    :src="testimonial.avatar"
                    :alt="testimonial.name"
                    class="testimonial-avatar"
                  />
                  <div class="testimonial-info">
                    <h4>{{ testimonial.name }}</h4>
                    <p>{{ testimonial.role }}</p>
                    <div class="rating">
                      <i v-for="star in 5" :key="star" class="fas fa-star"></i>
                    </div>
                  </div>
                </div>
                <div class="testimonial-content">
                  <p>"{{ testimonial.content }}"</p>
                </div>
              </div>
            </div>
          </div>
          <div class="slider-controls">
            <button @click="prevTestimonial" class="slider-btn prev">
              <i class="fas fa-chevron-left"></i>
            </button>
            <button @click="nextTestimonial" class="slider-btn next">
              <i class="fas fa-chevron-right"></i>
            </button>
          </div>
          <div class="slider-dots">
            <button
              v-for="(testimonial, index) in testimonials"
              :key="index"
              @click="currentTestimonial = index"
              :class="['dot', { active: currentTestimonial === index }]"
            ></button>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
      <div class="container">
        <div class="cta-content animate-fade-up">
          <h2>Trải Nghiệm Sự Khác Biệt Tại Hoa Sen</h2>
          <p>
            Hãy đến và cảm nhận những ưu điểm vượt trội mà chúng tôi mang lại
            cho con bạn
          </p>
          <div class="cta-buttons">
            <button class="btn-primary">Đăng ký tham quan</button>
            <button class="btn-secondary">Tải brochure</button>
          </div>
        </div>
      </div>
    </section>

    <!-- Modal -->
    <!-- <div v-if="showModal" class="modal-overlay" @click="closeModal">

      <div class="modal-content" @click.stop>
        <div class="modal-header">
          <div
            class="modal-icon"
            :style="{ background: selectedAdvantage?.color }"
          >
            <i :class="selectedAdvantage?.icon"></i>
          </div>
          <h2>{{ selectedAdvantage?.title }}</h2>
          <button class="close-btn" @click="closeModal">
            <i class="fas fa-times"></i>
          </button>
        </div>

        <div class="modal-body">
          <div class="modal-description">
            <h3>Mô tả chi tiết</h3>
            <p>{{ selectedAdvantage?.description }}</p>
            <p>{{ selectedAdvantage?.detailedDescription }}</p>
          </div>

          <div class="modal-features">
            <h3>Các tính năng nổi bật</h3>
            <ul>
              <li
                v-for="(feature, index) in selectedAdvantage?.features"
                :key="index"
              >
                <i class="fas fa-check-circle"></i>
                {{ feature }}
              </li>
            </ul>
          </div>

          <div class="modal-benefits" v-if="selectedAdvantage?.benefits">
            <h3>Lợi ích mang lại</h3>
            <div class="benefits-grid">
              <div
                v-for="(benefit, index) in selectedAdvantage?.benefits"
                :key="index"
                class="benefit-item"
              >
                <i :class="benefit.icon"></i>
                <div>
                  <h4>{{ benefit.title }}</h4>
                  <p>{{ benefit.description }}</p>
                </div>
              </div>
            </div>
          </div>

          <div class="modal-stats" v-if="selectedAdvantage?.stats">
            <h3>Thống kê</h3>
            <div class="stats-grid">
              <div
                v-for="(stat, index) in selectedAdvantage?.stats"
                :key="index"
                class="stat-item"
              >
                <div class="stat-number">{{ stat.number }}</div>
                <div class="stat-label">{{ stat.label }}</div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button class="btn-primary" @click="closeModal">
            Đăng ký tham quan
          </button>
          <button class="btn-secondary" @click="closeModal">
            Liên hệ tư vấn
          </button>
        </div>
      </div>
    </div> -->

    <AdvantageDialog
      :showModal="showModal"
      :selectedAdvantage="selectedAdvantage"
      @close="closeModal"
    />
  </div>
</template>

<script>
import { ref, onMounted, onUnmounted } from "vue";
import "./style.scss";
import AdvantageDialog from "./dialog.vue";
export default {
  name: "Advantages",
  components: {
    AdvantageDialog,
  },
  setup() {
    const currentTestimonial = ref(0);
    const showModal = ref(false);
    const selectedAdvantage = ref(null);
    let testimonialInterval = null;

    const advantages = ref([
      {
        icon: "fas fa-medal",
        title: "Chất lượng giáo dục hàng đầu",
        description:
          "Được công nhận trong top 500 trường giáo dục tốt nhất châu Á",
        detailedDescription:
          "Hoa Sen áp dụng chương trình giáo dục tiên tiến, kết hợp phương pháp giảng dạy truyền thống và hiện đại. Chúng tôi cam kết mang đến cho trẻ nền tảng giáo dục vững chắc, phát triển toàn diện về trí tuệ, thể chất và nhân cách.",
        color: "linear-gradient(135deg, #667eea 0%, #764ba2 100%)",
        features: [
          "Chương trình giáo dục chuẩn ",
          "Đội ngũ giáo viên chất lượng",
          "Phương pháp giảng dạy hiện đại",
        ],
        benefits: [
          {
            icon: "fas fa-brain",
            title: "Phát triển trí tuệ",
            description:
              "Kích thích tư duy sáng tạo và khả năng giải quyết vấn đề",
          },
          {
            icon: "fas fa-heart",
            title: "Phát triển cảm xúc",
            description: "Nuôi dưỡng tình yêu thương và sự đồng cảm",
          },
          {
            icon: "fas fa-users",
            title: "Kỹ năng xã hội",
            description: "Học cách giao tiếp và làm việc nhóm hiệu quả",
          },
        ],
        stats: [
          { number: "98%", label: "Phụ huynh hài lòng" },
          { number: "15+", label: "Năm kinh nghiệm" },
          { number: "500+", label: "Học sinh tốt nghiệp" },
        ],
      },
      {
        icon: "fas fa-users",
        title: "Đội ngũ giáo viên xuất sắc",
        description:
          "Giáo viên được đào tạo bài bản với trình độ chuyên môn cao",
        detailedDescription:
          "Đội ngũ giáo viên của Hoa Sen đều có trình độ chuyên môn cao, được đào tạo bài bản và có nhiều năm kinh nghiệm trong lĩnh vực giáo dục mầm non. Họ không chỉ là những người truyền đạt kiến thức mà còn là những người bạn đồng hành, hướng dẫn trẻ phát triển toàn diện.",
        color: "linear-gradient(135deg, #f093fb 0%, #f5576c 100%)",
        features: [
          "Thạc sĩ, Tiến sĩ chuyên ngành",
          "Kinh nghiệm giảng dạy phong phú",
          "Tâm huyết với nghề giáo dục",
        ],
        benefits: [
          {
            icon: "fas fa-graduation-cap",
            title: "Chuyên môn cao",
            description: "100% giáo viên có bằng cử nhân trở lên",
          },
          {
            icon: "fas fa-clock",
            title: "Kinh nghiệm dày dặn",
            description: "Trung bình 8+ năm kinh nghiệm giảng dạy",
          },
          {
            icon: "fas fa-award",
            title: "Được công nhận",
            description: "Nhiều giáo viên đạt danh hiệu xuất sắc",
          },
        ],
        stats: [
          { number: "50+", label: "Giáo viên" },
          { number: "1:8", label: "Tỷ lệ GV/HS" },
          { number: "95%", label: "Có bằng thạc sĩ" },
        ],
      },
      {
        icon: "fas fa-building",
        title: "Cơ sở vật chất hiện đại bậc nhất",
        description:
          "Trang thiết bị học tập và vui chơi đạt tiêu chuẩn quốc tế",
        detailedDescription:
          "Hoa Sen đầu tư mạnh mẽ vào cơ sở vật chất với các phòng học được trang bị đầy đủ thiết bị hiện đại, khu vui chơi an toàn và không gian xanh thoáng mát. Tất cả đều được thiết kế theo tiêu chuẩn quốc tế, đảm bảo môi trường học tập tốt nhất cho trẻ.",
        color: "linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)",
        features: [
          "Phòng học thông minh với nhiều thiết bị hiện đại",
          "Khu vui chơi an toàn",
          "Thiết bị giáo dục hiện đại",
        ],
        benefits: [
          {
            icon: "fas fa-shield-alt",
            title: "An toàn tuyệt đối",
            description: "Hệ thống camera 24/7 và bảo vệ chuyên nghiệp",
          },
          {
            icon: "fas fa-leaf",
            title: "Môi trường xanh",
            description: "Không gian thoáng mát với nhiều cây xanh",
          },
          {
            icon: "fas fa-laptop",
            title: "Công nghệ hiện đại",
            description: "Trang bị máy tính và thiết bị học tập tiên tiến",
          },
        ],
        stats: [
          { number: "2000m²", label: "Diện tích" },
          { number: "20+", label: "Phòng học" },
          { number: "100%", label: "Thiết bị hiện đại" },
        ],
      },
      {
        icon: "fas fa-heart",
        title: "Môi trường yêu thương",
        description: "Không gian học tập ấm áp, thân thiện và an toàn cho trẻ",
        detailedDescription:
          "Tại Hoa Sen, chúng tôi tạo ra một môi trường giáo dục đầy yêu thương, nơi mỗi em bé đều được quan tâm, chăm sóc tận tình. Không khí gia đình ấm áp giúp trẻ cảm thấy thoải mái và hạnh phúc khi đến trường.",
        color: "linear-gradient(135deg, #fa709a 0%, #fee140 100%)",
        features: [
          "Chăm sóc tận tình từng bé",
          "Môi trường an toàn 100%",
          "Phát triển toàn diện",
        ],
        benefits: [
          {
            icon: "fas fa-smile",
            title: "Hạnh phúc",
            description: "Trẻ luôn vui vẻ và hào hứng đến trường",
          },
          {
            icon: "fas fa-handshake",
            title: "Thân thiện",
            description: "Mối quan hệ tốt đẹp giữa thầy cô và học sinh",
          },
          {
            icon: "fas fa-home",
            title: "Như gia đình",
            description: "Cảm giác ấm áp và gần gũi như ở nhà",
          },
        ],
        stats: [
          { number: "100%", label: "Trẻ hạnh phúc" },
          { number: "0", label: "Tai nạn" },
          { number: "24/7", label: "Chăm sóc" },
        ],
      },
      {
        icon: "fas fa-globe",
        title: "Kết nối quốc tế",
        description: "Hợp tác với các trường danh tiếng trên thế giới",
        detailedDescription:
          "Hoa Sen có mạng lưới hợp tác rộng khắp với các tổ chức giáo dục quốc tế, mang đến cho học sinh cơ hội tiếp cận với nền giáo dục tiên tiến nhất thế giới. Chương trình trao đổi và học bổng quốc tế giúp mở rộng tầm nhìn cho trẻ.",
        color: "linear-gradient(135deg, #a8edea 0%, #fed6e3 100%)",
        features: [
          "Chương trình trao đổi quốc tế",
          "Giáo viên nước ngoài",
          "Chuẩn giáo dục thế giới",
        ],
        benefits: [
          {
            icon: "fas fa-language",
            title: "Đa ngôn ngữ",
            description: "Học tiếng Anh và các ngôn ngữ khác",
          },
          {
            icon: "fas fa-plane",
            title: "Cơ hội du học",
            description: "Chương trình trao đổi với các trường quốc tế",
          },
          {
            icon: "fas fa-world",
            title: "Tầm nhìn toàn cầu",
            description: "Hiểu biết về văn hóa và giáo dục thế giới",
          },
        ],
        stats: [
          { number: "10+", label: "Quốc gia hợp tác" },
          { number: "5", label: "Giáo viên nước ngoài" },
          { number: "50+", label: "Học bổng/năm" },
        ],
      },
      {
        icon: "fas fa-chart-line",
        title: "Kết quả xuất sắc",
        description: "Tỷ lệ học sinh đạt thành tích cao trong các kỳ thi",
        detailedDescription:
          "Với phương pháp giáo dục hiệu quả và đội ngũ giáo viên tận tâm, học sinh của Hoa Sen luôn đạt được những thành tích xuất sắc. Không chỉ về mặc học thuật mà còn phát triển toàn diện các kỹ năng sống và tư duy sáng tạo.",
        color: "linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%)",
        features: [
          "98% phụ huynh hài lòng",
          "Thành tích học tập vượt trội",
          "Phát triển kỹ năng toàn diện",
        ],
        benefits: [
          {
            icon: "fas fa-trophy",
            title: "Thành tích cao",
            description: "Nhiều giải thưởng trong các cuộc thi",
          },
          {
            icon: "fas fa-star",
            title: "Xuất sắc",
            description: "95% học sinh đạt điểm giỏi trở lên",
          },
          {
            icon: "fas fa-rocket",
            title: "Phát triển nhanh",
            description: "Tiến bộ vượt bậc sau mỗi học kỳ",
          },
        ],
        stats: [
          { number: "95%", label: "Điểm giỏi" },
          { number: "100+", label: "Giải thưởng" },
          { number: "98%", label: "Hài lòng" },
        ],
      },
    ]);

    const rankings = ref([
      {
        position: "#1",
        title: "Trường mầm non tốt nhất Việt Nam",
        description: "Được bình chọn bởi Hiệp hội Giáo dục Việt Nam",
      },
      {
        position: "#15",
        title: "Top 50 trường mầm non châu Á",
        description: "Xếp hạng bởi Tổ chức Giáo dục Quốc tế",
      },
      {
        position: "#3",
        title: "Trường có môi trường học tập tốt nhất",
        description: "Đánh giá bởi Hiệp hội Phụ huynh Việt Nam",
      },
    ]);

    const comparisons = ref([
      {
        feature: "Chất lượng giáo viên",
        hoaSen: "Thạc sĩ, Tiến sĩ 100%",
        others: "Đa dạng trình độ",
      },
      {
        feature: "Tỷ lệ giáo viên/học sinh",
        hoaSen: "1:8",
        others: "1:15",
      },
      {
        feature: "Cơ sở vật chất",
        hoaSen: "Hiện đại, đầy đủ",
        others: "Cơ bản",
      },
      {
        feature: "Chương trình học",
        hoaSen: "Chuẩn quốc tế",
        others: "Theo quy định",
      },
      {
        feature: "Hoạt động ngoại khóa",
        hoaSen: "Phong phú, đa dạng",
        others: "Hạn chế",
      },
    ]);

    const testimonials = ref([
      {
        name: "Chị Nguyễn Thị Lan",
        role: "Phụ huynh học sinh Minh An",
        avatar: "/src/assets/images/avatars/avatar-1.png",
        content:
          "Con tôi đã thay đổi rất nhiều kể từ khi học tại Hoa Sen. Chất lượng giáo dục thực sự vượt trội so với các trường khác.",
      },
      {
        name: "Anh Trần Văn Nam",
        role: "Phụ huynh học sinh Bảo Ngọc",
        avatar: "/src/assets/images/avatars/avatar-2.png",
        content:
          "Tôi rất ấn tượng với đội ngũ giáo viên và cơ sở vật chất tại đây. Thực sự xứng đáng với danh tiếng top đầu châu Á.",
      },
      {
        name: "Chị Lê Thị Hoa",
        role: "Phụ huynh học sinh Quang Minh",
        avatar: "/src/assets/images/avatars/avatar-3.png",
        content:
          "Môi trường học tập tại Hoa Sen thực sự tuyệt vời. Con tôi rất hạnh phúc và phát triển toàn diện.",
      },
    ]);

    const nextTestimonial = () => {
      currentTestimonial.value =
        (currentTestimonial.value + 1) % testimonials.value.length;
    };

    const prevTestimonial = () => {
      currentTestimonial.value =
        currentTestimonial.value === 0
          ? testimonials.value.length - 1
          : currentTestimonial.value - 1;
    };

    onMounted(() => {
      // Auto-play testimonials
      testimonialInterval = setInterval(nextTestimonial, 5000);

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

    onUnmounted(() => {
      if (testimonialInterval) {
        clearInterval(testimonialInterval);
      }
    });

    const openModal = (advantage, index) => {
      selectedAdvantage.value = advantage;
      showModal.value = true;
      document.body.style.overflow = "hidden";
    };

    const closeModal = () => {
      showModal.value = false;
      selectedAdvantage.value = null;
      document.body.style.overflow = "auto";
    };

    return {
      advantages,
      rankings,
      comparisons,
      testimonials,
      currentTestimonial,
      showModal,
      selectedAdvantage,
      nextTestimonial,
      prevTestimonial,
      openModal,
      closeModal,
    };
  },
};
</script>
<style lang="scss">
@use "./style.scss";
</style>
