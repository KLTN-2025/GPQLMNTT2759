<template>
  <div class="activities-container">
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
        <div class="hero-badge animate-fade-up">🎯 Hoạt động đa dạng</div>
        <h1 class="hero-title animate-fade-up delay-200">
          Các Hoạt Động Thường Xuyên
        </h1>
        <p class="hero-subtitle animate-fade-up delay-400">
          Nơi kết nối sự đoàn kết của các học sinh trong trường qua những hoạt
          động bổ ích và ý nghĩa
        </p>
        <div class="hero-stats animate-fade-up delay-600">
          <div class="stat-card">
            <div class="stat-icon">🎨</div>
            <div class="stat-number">20+</div>
            <div class="stat-label">Hoạt động</div>
          </div>
          <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-number">500+</div>
            <div class="stat-label">Học sinh tham gia</div>
          </div>
          <div class="stat-card">
            <div class="stat-icon">🏆</div>
            <div class="stat-number">50+</div>
            <div class="stat-label">Giải thưởng</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Activities Categories -->
    <section class="categories-section">
      <div class="container">
        <div class="section-header">
          <h2 class="section-title animate-fade-up">Danh Mục Hoạt Động</h2>
          <p class="section-subtitle animate-fade-up delay-200">
            Khám phá các hoạt động phong phú và đa dạng tại Hoa Sen
          </p>
        </div>

        <div class="categories-filter">
          <button
            v-for="category in categories"
            :key="category.id"
            @click="selectedCategory = category.id"
            :class="[
              'filter-btn',
              { active: selectedCategory === category.id },
            ]"
          >
            <i :class="category.icon"></i>
            {{ category.name }}
          </button>
        </div>

        <div class="activities-grid">
          <div
            class="activity-card animate-slide-up"
            v-for="(activity, index) in filteredActivities"
            :key="activity.id"
            :style="{ animationDelay: index * 100 + 'ms' }"
            @click="openActivityModal(activity)"
          >
            <div class="card-image">
              <img :src="activity.image" :alt="activity.title" />
              <div class="card-overlay">
                <div class="overlay-content">
                  <i class="fas fa-eye"></i>
                  <span>Xem chi tiết</span>
                </div>
              </div>
            </div>
            <div class="card-content">
              <div class="card-category">{{ activity.categoryName }}</div>
              <h3>{{ activity.title }}</h3>
              <p>{{ activity.description }}</p>
              <div class="card-meta">
                <div class="meta-item">
                  <i class="fas fa-users"></i>
                  <span>{{ activity.participants }} học sinh</span>
                </div>
                <div class="meta-item">
                  <i class="fas fa-clock"></i>
                  <span>{{ activity.duration }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Schedule Section -->
    <section class="schedule-section">
      <div class="container">
        <h2 class="section-title animate-fade-up">Lịch Trình Hoạt Động</h2>
        <div class="schedule-calendar">
          <div class="calendar-header">
            <button @click="previousWeek" class="nav-btn">
              <i class="fas fa-chevron-left"></i>
            </button>
            <h3>{{ currentWeekText }}</h3>
            <button @click="nextWeek" class="nav-btn">
              <i class="fas fa-chevron-right"></i>
            </button>
          </div>
          <div class="calendar-grid">
            <div v-for="day in weekDays" :key="day.date" class="day-column">
              <div class="day-header">
                <div class="day-name">{{ day.name }}</div>
                <div class="day-date">{{ day.date }}</div>
              </div>
              <div class="day-activities">
                <div
                  v-for="activity in day.activities"
                  :key="activity.id"
                  class="schedule-item"
                  :style="{ background: activity.color }"
                >
                  <div class="schedule-time">{{ activity.time }}</div>
                  <div class="schedule-title">{{ activity.title }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Gallery Section -->
    <section class="gallery-section">
      <div class="container">
        <h2 class="section-title animate-fade-up">Thư Viện Ảnh Hoạt Động</h2>
        <div class="gallery-grid">
          <div
            v-for="(image, index) in galleryImages"
            :key="index"
            class="gallery-item animate-zoom-in"
            :style="{ animationDelay: index * 50 + 'ms' }"
            @click="openGallery(index)"
          >
            <img :src="image.src" :alt="image.alt" />
            <div class="gallery-overlay">
              <i class="fas fa-search-plus"></i>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Registration CTA -->
    <section class="cta-section">
      <div class="container">
        <div class="cta-content animate-fade-up">
          <h2>Tham Gia Các Hoạt Động Cùng Chúng Tôi</h2>
          <p>
            Đăng ký ngay để con bạn có cơ hội tham gia các hoạt động bổ ích và
            phát triển toàn diện
          </p>
          <div class="cta-buttons">
            <button class="btn-primary">Đăng ký tham gia</button>
            <button class="btn-secondary">Xem lịch trình</button>
          </div>
        </div>
      </div>
    </section>

    <!-- Activity Modal -->
    <div
      v-if="showActivityModal"
      class="modal-overlay"
      @click="closeActivityModal"
    >
      <div class="modal-content" @click.stop>
        <div class="modal-header">
          <h2>{{ selectedActivity?.title }}</h2>
          <button class="close-btn" @click="closeActivityModal">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="modal-body">
          <img
            :src="selectedActivity?.image"
            :alt="selectedActivity?.title"
            class="modal-image"
          />
          <div class="modal-info">
            <div class="info-section">
              <h3>Mô tả hoạt động</h3>
              <p>{{ selectedActivity?.fullDescription }}</p>
            </div>
            <div class="info-section">
              <h3>Thông tin chi tiết</h3>
              <div class="info-grid">
                <div class="info-item">
                  <i class="fas fa-users"></i>
                  <span>{{ selectedActivity?.participants }} học sinh</span>
                </div>
                <div class="info-item">
                  <i class="fas fa-clock"></i>
                  <span>{{ selectedActivity?.duration }}</span>
                </div>
                <div class="info-item">
                  <i class="fas fa-calendar"></i>
                  <span>{{ selectedActivity?.frequency }}</span>
                </div>
                <div class="info-item">
                  <i class="fas fa-map-marker-alt"></i>
                  <span>{{ selectedActivity?.location }}</span>
                </div>
              </div>
            </div>
            <div class="info-section" v-if="selectedActivity?.benefits">
              <h3>Lợi ích</h3>
              <ul class="benefits-list">
                <li v-for="benefit in selectedActivity.benefits" :key="benefit">
                  <i class="fas fa-check-circle"></i>
                  {{ benefit }}
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn-primary" @click="closeActivityModal">
            Đăng ký tham gia
          </button>
          <button class="btn-secondary" @click="closeActivityModal">
            Đóng
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, computed, onMounted, onUnmounted, watch, nextTick } from "vue";
import "./style.scss";

export default {
  name: "Activities",
  setup() {
    const selectedCategory = ref("all");
    const showActivityModal = ref(false);
    const selectedActivity = ref(null);
    const currentWeek = ref(0);

    const categories = ref([
      { id: "all", name: "Tất cả", icon: "fas fa-th-large" },
      { id: "sports", name: "Thể thao", icon: "fas fa-running" },
      { id: "arts", name: "Nghệ thuật", icon: "fas fa-palette" },
      { id: "music", name: "Âm nhạc", icon: "fas fa-music" },
      { id: "science", name: "Khoa học", icon: "fas fa-flask" },
      { id: "social", name: "Xã hội", icon: "fas fa-handshake" },
    ]);

    const activities = ref([
      {
        id: 1,
        title: "Bơi lội cơ bản",
        description: "Học các kỹ thuật bơi cơ bản và an toàn dước",
        fullDescription:
          "Khóa học bơi lội cơ bản giúp trẻ làm quen với môi trường nước, học các kỹ thuật bơi tự do, bơi ếch và các kỹ năng an toàn dước. Được hướng dẫn bởi các huấn luyện viên chuyên nghiệp.",
        image:
          "/src/assets/images/Home/YpjdabYJIx5l2wCNYI5TJSrrfWhsDAApdqf4QSgK.jpeg",
        category: "sports",
        categoryName: "Thể thao",
        participants: 15,
        duration: "45 phút",
        frequency: "Thứ 2, 4, 6",
        location: "Bể bơi trường",
        benefits: [
          "Tăng cường sức khỏe tim mạch",
          "Phát triển cơ bắp toàn thân",
          "Học kỹ năng an toàn dước",
          "Tăng sự tự tin",
        ],
      }, // ← THÊM DẤU CHẤM PHẨY TẠI ĐÂY
      {
        id: 2,
        title: "Nhảy múa sáng tạo",
        description: "Phát triển khả năng biểu đạt qua các động tác nhảy múa",
        fullDescription:
          "Lớp nhảy múa sáng tạo giúp trẻ phát triển khả năng biểu đạt cảm xúc, tăng cường sự linh hoạt và phối hợp động tác. Các em sẽ học nhiều thể loại nhảy từ cổ điển đến hiện đại.",
        image: "/src/assets/images/Home/2-6.jpg",
        category: "arts",
        categoryName: "Nghệ thuật",
        participants: 20,
        duration: "60 phút",
        frequency: "Thứ 3, 5, 7",
        location: "Phòng múa",
        benefits: [
          "Phát triển khả năng biểu đạt",
          "Tăng cường sự linh hoạt",
          "Cải thiện phối hợp vận động",
          "Xây dựng sự tự tin",
        ],
      },
      {
        id: 3,
        title: "Khoa học thực hành",
        description: "Khám phá thế giới khoa học qua các thí nghiệm thú vị",
        fullDescription:
          "Chương trình khoa học thực hành giúp trẻ khám phá thế giới xung quanh qua các thí nghiệm đơn giản và an toàn. Các em sẽ học về vật lý, hóa học, sinh học một cách sinh động.",
        image:
          "/src/assets/images/Home/hoat-dong-ngoai-khoa-o-truong-tieu-hoc-3.png",
        category: "science",
        categoryName: "Khoa học",
        participants: 12,
        duration: "90 phút",
        frequency: "Thứ 4, 6",
        location: "Phòng thí nghiệm",
        benefits: [
          "Kích thích tò mò khoa học",
          "Phát triển tư duy logic",
          "Học cách quan sát và phân tích",
          "Tăng cường kỹ năng thực hành",
        ],
      },
      {
        id: 4,
        title: "Hoạt động nhóm",
        description: "Xây dựng tinh thần đồng đội và kỹ năng làm việc nhóm",
        fullDescription:
          "Các hoạt động nhóm được thiết kế để giúp trẻ học cách hợp tác, chia sẻ và giải quyết vấn đề cùng nhau. Thông qua các trò chơi và dự án nhóm, trẻ sẽ phát triển kỹ năng xã hội.",
        image:
          "/src/assets/images/Home/truong-mamnon-17072776867411513472472.jpg",
        category: "social",
        categoryName: "Xã hội",
        participants: 25,
        duration: "75 phút",
        frequency: "Thứ 2, 5",
        location: "Sân chơi",
        benefits: [
          "Phát triển kỹ năng giao tiếp",
          "Học cách hợp tác",
          "Xây dựng tình bạn",
          "Tăng cường tinh thần đồng đội",
        ],
      },
      {
        id: 5,
        title: "Sáng tác nghệ thuật",
        description:
          "Phát triển khả năng sáng tạo qua vẽ tranh và làm đồ thủ công",
        fullDescription:
          "Lớp sáng tác nghệ thuật khuyến khích trẻ thể hiện sự sáng tạo qua nhiều hình thức như vẽ tranh, nặn đất sét, làm đồ thủ công. Giúp trẻ phát triển khả năng thẩm mỹ và tư duy sáng tạo.",
        image: "/src/assets/images/Home/1_638505759099380765.jpg",
        category: "arts",
        categoryName: "Nghệ thuật",
        participants: 18,
        duration: "90 phút",
        frequency: "Thứ 3, 6",
        location: "Phòng mỹ thuật",
        benefits: [
          "Phát triển tư duy sáng tạo",
          "Cải thiện kỹ năng vận động tinh",
          "Tăng cường khả năng thẩm mỹ",
          "Học cách biểu đạt cảm xúc",
        ],
      },
      {
        id: 6,
        title: "Âm nhạc và hát",
        description: "Phát triển khả năng âm nhạc và giọng hát",
        fullDescription:
          "Chương trình âm nhạc giúp trẻ làm quen với các nhạc cụ, học hát và phát triển khả năng cảm thụ âm nhạc. Các em sẽ tham gia vào các buổi biểu diễn và hòa nhạc nhỏ.",
        image: "/src/assets/images/Home/unnamed.jpg",
        category: "music",
        categoryName: "Âm nhạc",
        participants: 16,
        duration: "60 phút",
        frequency: "Thứ 2, 4, 6",
        location: "Phòng âm nhạc",
        benefits: [
          "Phát triển khả năng âm nhạc",
          "Cải thiện trí nhớ",
          "Tăng cường sự tự tin",
          "Học cách làm việc nhóm",
        ],
      },
    ]);

    const galleryImages = ref([
      {
        src: "/src/assets/images/Home/YpjdabYJIx5l2wCNYI5TJSrrfWhsDAApdqf4QSgK.jpeg",
        alt: "Hoạt động bơi lội",
      },
      { src: "/src/assets/images/Home/2-6.jpg", alt: "Hoạt động nhảy múa" },
      {
        src: "/src/assets/images/Home/hoat-dong-ngoai-khoa-o-truong-tieu-hoc-3.png",
        alt: "Hoạt động khoa học",
      },
      {
        src: "/src/assets/images/Home/truong-mamnon-17072776867411513472472.jpg",
        alt: "Hoạt động nhóm",
      },
      {
        src: "/src/assets/images/Home/1_638505759099380765.jpg",
        alt: "Hoạt động sáng tạo",
      },
      { src: "/src/assets/images/Home/unnamed.jpg", alt: "Hoạt động âm nhạc" },
    ]);

    const weekDays = ref([
      {
        name: "Thứ 2",
        date: "15/01",
        activities: [
          { id: 1, title: "Bơi lội", time: "8:00", color: "#3498db" },
          { id: 2, title: "Hoạt động nhóm", time: "14:00", color: "#e74c3c" },
        ],
      },
      {
        name: "Thứ 3",
        date: "16/01",
        activities: [
          { id: 3, title: "Nhảy múa", time: "9:00", color: "#9b59b6" },
          { id: 4, title: "Sáng tác", time: "15:00", color: "#f39c12" },
        ],
      },
      {
        name: "Thứ 4",
        date: "17/01",
        activities: [
          { id: 5, title: "Khoa học", time: "8:30", color: "#27ae60" },
          { id: 6, title: "Âm nhạc", time: "14:30", color: "#e67e22" },
        ],
      },
      {
        name: "Thứ 5",
        date: "18/01",
        activities: [
          { id: 7, title: "Bơi lội", time: "8:00", color: "#3498db" },
          { id: 8, title: "Hoạt động nhóm", time: "15:00", color: "#e74c3c" },
        ],
      },
      {
        name: "Thứ 6",
        date: "19/01",
        activities: [
          { id: 9, title: "Nhảy múa", time: "9:00", color: "#9b59b6" },
          { id: 10, title: "Khoa học", time: "14:00", color: "#27ae60" },
        ],
      },
      {
        name: "Thứ 7",
        date: "20/01",
        activities: [
          { id: 11, title: "Nhảy múa", time: "9:00", color: "#9b59b6" },
          { id: 12, title: "Sáng tác", time: "14:00", color: "#f39c12" },
        ],
      },
    ]);

    const filteredActivities = computed(() => {
      if (selectedCategory.value === "all") {
        return activities.value;
      }
      return activities.value.filter(
        (activity) => activity.category === selectedCategory.value
      );
    });

    const currentWeekText = computed(() => {
      return `Tuần ${currentWeek.value + 1} - Tháng 1, 2024`;
    });

    const openActivityModal = (activity) => {
      selectedActivity.value = activity;
      showActivityModal.value = true;
      document.body.style.overflow = "hidden";
    };

    const closeActivityModal = () => {
      showActivityModal.value = false;
      selectedActivity.value = null;
      document.body.style.overflow = "auto";
    };

    const previousWeek = () => {
      if (currentWeek.value > 0) {
        currentWeek.value--;
      }
    };

    const nextWeek = () => {
      if (currentWeek.value < 3) {
        currentWeek.value++;
      }
    };

    const openGallery = (index) => {
      console.log("Open gallery at index:", index);
    };

    let observer = null;

    const initializeAnimations = () => {
      if (observer) {
        observer.disconnect();
      }

      const observerOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px",
      };

      observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("animate");
          }
        });
      }, observerOptions);

      document
        .querySelectorAll(
          ".animate-fade-up, .animate-slide-up, .animate-zoom-in"
        )
        .forEach((el) => {
          observer.observe(el);
        });
    };

    watch(selectedCategory, () => {
      nextTick(() => {
        initializeAnimations();
      });
    });

    onMounted(() => {
      initializeAnimations();
    });

    onUnmounted(() => {
      if (observer) {
        observer.disconnect();
      }
      document.body.style.overflow = "auto";
    });

    return {
      categories,
      activities,
      galleryImages,
      weekDays,
      selectedCategory,
      showActivityModal,
      selectedActivity,
      currentWeek,
      filteredActivities,
      currentWeekText,
      openActivityModal,
      closeActivityModal,
      previousWeek,
      nextWeek,
      openGallery,
    };
  },
};
</script>

<style lang="scss">
@use "./style.scss";
</style>
