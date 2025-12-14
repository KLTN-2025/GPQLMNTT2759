<template>
  <div class="school-blog-container">
    <div class="school-blog-main">
      <!-- Hero Section -->
      <div class="hero-section animate-on-scroll" data-animation="fade-up">
        <div class="hero-content">
          <h1 class="hero-title">Nhà Trường Hoa Sen</h1>
          <p class="hero-subtitle">
            Khám phá câu chuyện, tầm nhìn và sứ mệnh của chúng tôi trong việc
            nuôi dưỡng và phát triển thế hệ tương lai
          </p>
        </div>
        <div class="hero-image">
          <img src="../../../assets/images/Home/IMG_3071-scaled (1).jpg" alt="Trường Mầm Non Hoa Sen"
            class="hero-img" />
        </div>
      </div>

      <!-- About School Section -->
      <div class="about-section animate-on-scroll" data-animation="fade-up">
        <div class="section-header">
          <h2>Về Chúng Tôi</h2>
          <div class="divider"></div>
        </div>
        <div class="about-content">
          <div class="about-text">
            <p>
              Trường Mầm Non Hoa Sen được thành lập với sứ mệnh mang đến môi
              trường giáo dục chất lượng cao, an toàn và thân thiện cho các em
              nhỏ. Chúng tôi tin rằng mỗi đứa trẻ đều là một bông hoa sen quý
              giá, cần được chăm sóc và nuôi dưỡng để nở rộ những tiềm năng tốt
              đẹp nhất.
            </p>
            <p>
              Với đội ngũ giáo viên giàu kinh nghiệm, cơ sở vật chất hiện đại và
              chương trình giáo dục tiên tiến, chúng tôi cam kết tạo ra một môi
              trường học tập vui vẻ, sáng tạo và phát triển toàn diện cho trẻ.
            </p>
          </div>
          <div class="about-stats">
            <div class="stat-item animate-on-scroll" data-animation="slide-up" data-delay="100">
              <div class="stat-number">15+</div>
              <div class="stat-label">Năm Kinh Nghiệm</div>
            </div>
            <div class="stat-item animate-on-scroll" data-animation="slide-up" data-delay="200">
              <div class="stat-number">500+</div>
              <div class="stat-label">Học Sinh</div>
            </div>
            <div class="stat-item animate-on-scroll" data-animation="slide-up" data-delay="300">
              <div class="stat-number">30+</div>
              <div class="stat-label">Giáo Viên</div>
            </div>
            <div class="stat-item animate-on-scroll" data-animation="slide-up" data-delay="400">
              <div class="stat-number">98%</div>
              <div class="stat-label">Hài Lòng</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Mission & Vision Section -->
      <div class="mission-vision-section">
        <div class="mission-vision-grid">
          <div class="mission-card animate-on-scroll" data-animation="slide-left">
            <div class="card-icon">
              <i class="fas fa-bullseye"></i>
            </div>
            <h3>Sứ Mệnh</h3>
            <p>
              Tạo ra môi trường giáo dục an toàn, thân thiện và chất lượng cao,
              giúp trẻ phát triển toàn diện về thể chất, trí tuệ, cảm xúc và xã
              hội.
            </p>
          </div>
          <div class="vision-card animate-on-scroll" data-animation="slide-right">
            <div class="card-icon">
              <i class="fas fa-eye"></i>
            </div>
            <h3>Tầm Nhìn</h3>
            <p>
              Trở thành trường mầm non hàng đầu, được tin tưởng bởi phụ huynh và
              yêu thích bởi trẻ em, góp phần xây dựng thế hệ tương lai vững
              mạnh.
            </p>
          </div>
        </div>
      </div>

      <!-- School News Section -->
      <div class="school-news-section animate-on-scroll" data-animation="fade-up">
        <div class="section-header">
          <h2>Tin Tức Nhà Trường</h2>
          <div class="divider"></div>
        </div>
        <div class="news-grid">
          <!-- Template -->
          <template v-for="(value, index) in list_bai_viet" :key="index">
            <div class="news-item animate-on-scroll" data-animation="fade-up" :data-delay="100 * (index + 1)">
              <div class="news-image">
                <img :src="value.hinh_anh" :alt="value.tieu_de" />
              </div>
              <div class="news-content">
                <div class="news-meta">
                  <span class="news-date">{{ formatDate(value.ngay_dang) }}</span>
                  <span class="news-category">{{ value.danh_muc ?? 'Thông Báo' }}</span>
                </div>
                <h3 class="news-title">{{ value.tieu_de }}</h3>
                <p class="news-excerpt">{{ value.noi_dung }}</p>
                <router-link class="read-more-btn btn btn-outline-danger w-100" :to="`/blog-detail/${value.id}`">
                  Đọc thêm
                </router-link>
              </div>
            </div>
          </template>

        </div>
      </div>

      <!-- Facilities Section -->
      <div class="facilities-section animate-on-scroll" data-animation="fade-up">
        <div class="section-header">
          <h2>Cơ Sở Vật Chất</h2>
          <div class="divider"></div>
        </div>
        <div class="facilities-grid">
          <div class="facility-item animate-on-scroll" data-animation="zoom-in" data-delay="100">
            <div class="facility-icon">
              <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <h4>Phòng Học Hiện Đại</h4>
            <p>Trang bị đầy đủ thiết bị học tập, âm thanh, ánh sáng tối ưu</p>
          </div>
          <div class="facility-item animate-on-scroll" data-animation="zoom-in" data-delay="200">
            <div class="facility-icon">
              <i class="fas fa-gamepad"></i>
            </div>
            <h4>Khu Vui Chơi An Toàn</h4>
            <p>Sân chơi rộng rãi với đồ chơi an toàn, phù hợp lứa tuổi</p>
          </div>
          <div class="facility-item animate-on-scroll" data-animation="zoom-in" data-delay="300">
            <div class="facility-icon">
              <i class="fas fa-utensils"></i>
            </div>
            <h4>Bếp Ăn Sạch Sẽ</h4>
            <p>
              Đảm bảo vệ sinh an toàn thực phẩm, thực đơn cân bằng dinh dưỡng
            </p>
          </div>
          <div class="facility-item animate-on-scroll" data-animation="zoom-in" data-delay="400">
            <div class="facility-icon">
              <i class="fas fa-shield-alt"></i>
            </div>
            <h4>Hệ Thống An Ninh</h4>
            <p>Camera giám sát 24/7, kiểm soát ra vào nghiêm ngặt</p>
          </div>
        </div>
      </div>

      <!-- Contact Section -->
      <div class="contact-section animate-on-scroll" data-animation="fade-up">
        <div class="contact-content">
          <div class="contact-info">
            <h3>Liên Hệ Với Chúng Tôi</h3>
            <p>
              Hãy liên hệ để được tư vấn chi tiết về chương trình học và đăng ký
              cho bé yêu của bạn.
            </p>
            <div class="contact-details">
              <div class="contact-item">
                <i class="fas fa-phone"></i>
                <span>0123 456 789</span>
              </div>
              <div class="contact-item">
                <i class="fas fa-envelope"></i>
                <span>info@hoasen.edu.vn</span>
              </div>
              <div class="contact-item">
                <i class="fas fa-map-marker-alt"></i>
                <span>123 Đường ABC, Quận XYZ, TP.HCM</span>
              </div>
            </div>
          </div>
          <div class="contact-form">
            <h4>Đăng Ký Tham Quan</h4>
            <form @submit.prevent="submitForm">
              <div class="form-group">
                <input type="text" placeholder="Họ và tên phụ huynh" v-model="form.parentName" />
              </div>
              <div class="form-group">
                <input type="text" placeholder="Số điện thoại" v-model="form.phone" />
              </div>
              <div class="form-group">
                <input type="email" placeholder="Email" v-model="form.email" />
              </div>
              <div class="form-group">
                <textarea placeholder="Ghi chú" v-model="form.note"></textarea>
              </div>
              <button type="submit" class="submit-btn">Gửi Đăng Ký</button>
            </form>
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
      form: {
        parentName: "",
        phone: "",
        email: "",
        note: ""
      }
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
@use "./style.scss";
</style>
