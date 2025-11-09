<template>
  <div class="teachers-container">
    <!-- Animated Background -->
    <div class="animated-bg">
      <div class="floating-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        <div class="shape shape-4"></div>
      </div>
    </div>

    <!-- Header Section -->
    <div class="teachers-header">
      <div class="header-content">
        <div class="header-badge">✨ Đội ngũ chuyên nghiệp</div>
        <h1 class="main-title">
          <span class="gradient-text">Đội Ngũ Giảng Viên</span>
          <span class="title-highlight">Xuất Sắc</span>
        </h1>
        <p class="subtitle">
          Các chuyên gia hàng đầu trong lĩnh vực giáo dục mầm non với kinh
          nghiệm quốc tế
        </p>
        <div class="stats-row">
          <div class="stat-item">
            <span class="stat-number">50+</span>
            <span class="stat-label">Giảng viên</span>
          </div>
          <div class="stat-item">
            <span class="stat-number">15+</span>
            <span class="stat-label">Năm kinh nghiệm</span>
          </div>
          <div class="stat-item">
            <span class="stat-number">1000+</span>
            <span class="stat-label">Học sinh</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
      <div class="filter-container">
        <button
          v-for="category in categories"
          :key="category.id"
          :class="['filter-btn', { active: selectedCategory === category.id }]"
          @click="filterTeachers(category.id)"
        >
          <i :class="category.icon"></i>
          {{ category.name }}
        </button>
      </div>
    </div>

    <!-- Teachers Grid -->
    <div class="teachers-grid">
      <div
        v-for="(teacher, index) in filteredTeachers"
        :key="teacher.id"
        class="teacher-card"
        :style="{ animationDelay: `${index * 0.1}s` }"
        @click="selectTeacher(teacher)"
      >
        <div class="card-glow"></div>
        <div class="teacher-image-container">
          <div class="image-frame">
            <img
              :src="teacher.image"
              :alt="teacher.name"
              class="teacher-image"
            />
            <div class="image-overlay">
              <div class="overlay-content">
                <div class="action-buttons">
                  <button class="action-btn primary">
                    <i class="fas fa-eye"></i>
                  </button>
                  <button class="action-btn secondary">
                    <i class="fas fa-heart"></i>
                  </button>
                </div>
                <span class="view-text">Xem chi tiết</span>
              </div>
            </div>
          </div>
          <div class="experience-badge">{{ teacher.experience }} năm</div>
        </div>

        <div class="teacher-info">
          <div class="teacher-header">
            <h3 class="teacher-name">{{ teacher.name }}</h3>
            <div class="rating">
              <i v-for="n in 5" :key="n" class="fas fa-star"></i>
              <span class="rating-text">5.0</span>
            </div>
          </div>

          <p class="teacher-title">{{ teacher.title }}</p>
          <p class="teacher-specialization">
            <i class="fas fa-graduation-cap"></i>
            {{ teacher.specialization }}
          </p>

          <div class="teacher-stats">
            <div class="stat">
              <div class="stat-icon">
                <i class="fas fa-users"></i>
              </div>
              <div class="stat-content">
                <span class="stat-number">{{ teacher.students }}</span>
                <span class="stat-label">Học sinh</span>
              </div>
            </div>
            <div class="stat">
              <div class="stat-icon">
                <i class="fas fa-award"></i>
              </div>
              <div class="stat-content">
                <span class="stat-number">{{
                  teacher.achievements.length
                }}</span>
                <span class="stat-label">Giải thưởng</span>
              </div>
            </div>
          </div>

          <div class="card-footer">
            <button class="contact-btn">
              <i class="fas fa-message"></i>
              Liên hệ
            </button>
            <div class="social-links">
              <a href="#" class="social-link">
                <i class="fab fa-linkedin"></i>
              </a>
              <a href="#" class="social-link">
                <i class="fab fa-twitter"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Teacher Detail Modal -->
    <div v-if="selectedTeacher" class="modal-overlay" @click="closeModal">
      <div class="modal-content" @click.stop>
        <div class="modal-header">
          <button class="close-btn" @click="closeModal">
            <i class="fas fa-times"></i>
          </button>
        </div>

        <div class="modal-body">
          <div class="modal-left">
            <div class="teacher-profile">
              <div class="profile-image">
                <img :src="selectedTeacher.image" :alt="selectedTeacher.name" />
                <div class="profile-badge">
                  <i class="fas fa-check"></i>
                </div>
              </div>

              <div class="profile-info">
                <h2>{{ selectedTeacher.name }}</h2>
                <p class="profile-title">{{ selectedTeacher.title }}</p>
                <div class="profile-rating">
                  <div class="stars">
                    <i v-for="n in 5" :key="n" class="fas fa-star"></i>
                  </div>
                  <span>5.0 ({{ selectedTeacher.students }} đánh giá)</span>
                </div>
              </div>

              <div class="quick-stats">
                <div class="quick-stat">
                  <i class="fas fa-graduation-cap"></i>
                  <span>{{ selectedTeacher.degree }}</span>
                </div>
                <div class="quick-stat">
                  <i class="fas fa-university"></i>
                  <span>{{ selectedTeacher.university }}</span>
                </div>
                <div class="quick-stat">
                  <i class="fas fa-clock"></i>
                  <span>{{ selectedTeacher.experience }} năm kinh nghiệm</span>
                </div>
              </div>
            </div>
          </div>

          <div class="modal-right">
            <div class="content-tabs">
              <button
                v-for="tab in tabs"
                :key="tab.id"
                :class="['tab-btn', { active: activeTab === tab.id }]"
                @click="activeTab = tab.id"
              >
                <i :class="tab.icon"></i>
                {{ tab.name }}
              </button>
            </div>

            <div class="tab-content">
              <div v-if="activeTab === 'overview'" class="tab-panel">
                <h3>Giới thiệu</h3>
                <p>{{ selectedTeacher.description }}</p>

                <div class="specializations">
                  <h4>Chuyên môn</h4>
                  <div class="spec-tags">
                    <span class="spec-tag">{{
                      selectedTeacher.specialization
                    }}</span>
                    <span class="spec-tag">Giáo dục mầm non</span>
                    <span class="spec-tag">Phát triển trẻ em</span>
                  </div>
                </div>
              </div>

              <div v-if="activeTab === 'achievements'" class="tab-panel">
                <h3>Thành tích nổi bật</h3>
                <div class="achievements-list">
                  <div
                    v-for="(achievement, index) in selectedTeacher.achievements"
                    :key="index"
                    class="achievement-item"
                  >
                    <div class="achievement-icon">
                      <i class="fas fa-trophy"></i>
                    </div>
                    <span>{{ achievement }}</span>
                  </div>
                </div>
              </div>

              <div v-if="activeTab === 'contact'" class="tab-panel">
                <h3>Thông tin liên hệ</h3>
                <div class="contact-form">
                  <div class="form-group">
                    <label>Họ và tên</label>
                    <input type="text" placeholder="Nhập họ và tên của bạn" />
                  </div>
                  <div class="form-group">
                    <label>Email</label>
                    <input type="email" placeholder="Nhập email của bạn" />
                  </div>
                  <div class="form-group">
                    <label>Tin nhắn</label>
                    <textarea placeholder="Nhập tin nhắn của bạn"></textarea>
                  </div>
                  <button class="submit-btn">
                    <i class="fas fa-paper-plane"></i>
                    Gửi tin nhắn
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, computed } from "vue";

export default {
  name: "Teachers",
  setup() {
    const selectedTeacher = ref(null);
    const selectedCategory = ref("all");
    const activeTab = ref("overview");

    const categories = ref([
      { id: "all", name: "Tất cả", icon: "fas fa-th-large" },
      { id: "math", name: "Toán học", icon: "fas fa-calculator" },
      { id: "language", name: "Ngôn ngữ", icon: "fas fa-language" },
      { id: "art", name: "Nghệ thuật", icon: "fas fa-palette" },
      { id: "psychology", name: "Tâm lý", icon: "fas fa-brain" },
    ]);

    const tabs = ref([
      { id: "overview", name: "Tổng quan", icon: "fas fa-user" },
      { id: "achievements", name: "Thành tích", icon: "fas fa-trophy" },
      { id: "contact", name: "Liên hệ", icon: "fas fa-envelope" },
    ]);

    const teachers = ref([
      {
        id: 1,
        name: "GS. Matthew Paul",
        title: "Giáo sư Toán học",
        specialization: "Toán học & Trí tuệ nhân tạo",
        category: "math",
        experience: 15,
        students: 200,
        degree: "Tiến sĩ Toán học",
        university: "Đại học Harvard",
        image:
          "/src/assets/images/Home/nhung-tong-thong-ty-phu-ceo-dinh-dam-the-gioi-nao-tung-hoc-o-harvarddocx-1565796550062.webp",
        description:
          "Giáo sư tiến sĩ, hiện đang công tác và làm việc tại mầm non Hoa Sen, trưởng bộ môn toán học, chuyên viên nghiên cứu trí tuệ nhân tạo. Với hơn 15 năm kinh nghiệm trong lĩnh vực giáo dục, ông đã đào tạo hàng trăm học sinh xuất sắc.",
        achievements: [
          "Giải thưởng Giáo viên xuất sắc năm 2023",
          "Tác giả 20+ bài báo khoa học quốc tế",
          "Chuyên gia tư vấn chương trình giáo dục STEM",
        ],
      },
      {
        id: 2,
        name: "TS. Sarah Johnson",
        title: "Tiến sĩ Tâm lý học",
        specialization: "Tâm lý học trẻ em",
        category: "psychology",
        experience: 12,
        students: 150,
        degree: "Tiến sĩ Tâm lý học",
        university: "Đại học Stanford",
        image:
          "/src/assets/images/Home/olympia-dang-khanh-linh-1-crop-1743583035511.webp",
        description:
          "Tiến sĩ Tâm lý học trẻ em, chuyên gia phát triển nhận thức và kỹ năng xã hội cho trẻ mầm non. Có 12 năm kinh nghiệm trong việc nghiên cứu và ứng dụng các phương pháp giáo dục hiện đại.",
        achievements: [
          "Chứng chỉ chuyên gia tâm lý trẻ em quốc tế",
          "Tác giả cuốn sách 'Phát triển tâm lý trẻ mầm non'",
          "Diễn giả tại 15+ hội thảo giáo dục quốc tế",
        ],
      },
      {
        id: 3,
        name: "GS. Emily Chen",
        title: "Giáo sư Ngôn ngữ học",
        specialization: "Giáo dục song ngữ",
        category: "language",
        experience: 18,
        students: 300,
        degree: "Tiến sĩ Ngôn ngữ học",
        university: "Đại học Cambridge",
        image: "/src/assets/images/Home/anh-6-17184525388231291139336.webp",
        description:
          "Giáo sư ngôn ngữ học, chuyên về phương pháp giảng dạy song ngữ cho trẻ em. Với kinh nghiệm 18 năm, bà đã phát triển nhiều chương trình giáo dục ngôn ngữ tiên tiến.",
        achievements: [
          "Giải thưởng Excellence in Language Education 2022",
          "Chủ nhiệm 10+ dự án nghiên cứu quốc tế",
          "Cố vấn chương trình song ngữ cho 50+ trường học",
        ],
      },
      {
        id: 4,
        name: "TS. Michael Brown",
        title: "Tiến sĩ Khoa học Giáo dục",
        specialization: "Phương pháp Montessori",
        category: "psychology",
        experience: 14,
        students: 180,
        degree: "Tiến sĩ Khoa học Giáo dục",
        university: "Đại học Oxford",
        image: "/src/assets/images/Home/Nguyen-Chi-Hieu.jpg",
        description:
          "Tiến sĩ Khoa học Giáo dục, chuyên gia về phương pháp Montessori và giáo dục sáng tạo cho trẻ mầm non. Ông đã đào tạo nhiều thế hệ giáo viên mầm non chuyên nghiệp.",
        achievements: [
          "Chứng chỉ Montessori Master Teacher",
          "Founder của 5 trung tâm giáo dục Montessori",
          "Tác giả 15+ cuốn sách về giáo dục mầm non",
        ],
      },
      {
        id: 5,
        name: "ThS. Lisa Wang",
        title: "Thạc sĩ Nghệ thuật",
        specialization: "Giáo dục nghệ thuật",
        category: "art",
        experience: 10,
        students: 120,
        degree: "Thạc sĩ Nghệ thuật và Âm nhạc",
        university: "Đại học Yale",
        image: "/src/assets/images/Home/vuducminh.jpg",
        description:
          "Thạc sĩ Nghệ thuật và Âm nhạc, chuyên viên phát triển khả năng sáng tạo và thẩm mỹ cho trẻ em qua các hoạt động nghệ thuật. Bà có tài năng đặc biệt trong việc kích thích sự sáng tạo của trẻ.",
        achievements: [
          "Giải thưởng Giáo viên nghệ thuật xuất sắc 2023",
          "Tổ chức 20+ triển lãm nghệ thuật trẻ em",
          "Phát triển chương trình giáo dục nghệ thuật tích hợp",
        ],
      },
      {
        id: 6,
        name: "GS. Phan Văn Trường",
        title: "Giáo sư Văn học",
        specialization: "Văn học & Văn hóa Việt Nam",
        category: "language",
        experience: 25,
        students: 400,
        degree: "Tiến sĩ Văn học",
        university: "Đại học Quốc gia Hà Nội",
        image: "/src/assets/images/Home/giao-su-phan-van-truong.webp",
        description:
          "Giáo sư Văn học và Ngôn ngữ Việt Nam, chuyên gia về phương pháp giảng dạy tiếng Việt và văn hóa truyền thống cho trẻ em. Ông là một trong những chuyên gia hàng đầu về giáo dục văn hóa Việt Nam.",
        achievements: [
          "Giải thưởng Hồ Chí Minh về Văn học và Nghệ thuật",
          "Tác giả 30+ tác phẩm về văn học thiếu nhi",
          "Cố vấn chương trình giáo dục văn hóa dân tộc",
        ],
      },
    ]);

    const filteredTeachers = computed(() => {
      if (selectedCategory.value === "all") {
        return teachers.value;
      }
      return teachers.value.filter(
        (teacher) => teacher.category === selectedCategory.value
      );
    });

    const selectTeacher = (teacher) => {
      selectedTeacher.value = teacher;
      activeTab.value = "overview";
    };

    const closeModal = () => {
      selectedTeacher.value = null;
    };

    const filterTeachers = (categoryId) => {
      selectedCategory.value = categoryId;
    };

    return {
      teachers,
      filteredTeachers,
      selectedTeacher,
      selectedCategory,
      activeTab,
      categories,
      tabs,
      selectTeacher,
      closeModal,
      filterTeachers,
    };
  },
};
</script>
<style lang="scss">
@use "./style.scss";
</style>
