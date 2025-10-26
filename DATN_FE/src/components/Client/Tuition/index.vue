<template>
  <div class="tuition-container">
    <div class="summer-program">
      <h2 class="program-title animate-on-scroll" data-animation="fade-up">
        CHƯƠNG TRÌNH HỌC PHÍ
      </h2>
      <div class="program-list">
        <div
          class="program-box animate-on-scroll"
          data-animation="fade-up"
          data-delay="200"
        >
          <h3 class="program-name">VƯỜN ƯM BÉ VÀO LỚP MẦM</h3>
          <img
            src="../../../assets/images/Home/1_638505759099380765.jpg"
            alt="Vườn ươm"
            class="program-image"
          />
          <div class="program-content">
            <p>
              <strong>Đối tượng:</strong><br />
              Học sinh sinh năm 2025 chuẩn bị vào lớp mầm tại trường mầm non
              Sky-Line và các trường mầm non khác trong khu vực.
            </p>
            <p>
              <strong>Thời gian:</strong><br />
              9/6/2025 – 18/7/2025 (6 tuần)
            </p>
            <p>
              <strong>Địa điểm học tập và sinh hoạt:</strong><br />
              Các cơ sở (2, 3, 4, 5) thuộc Hệ thống Giáo dục Sky-Line
            </p>
            <p>
              <strong>Học phí:</strong><br />
              8.500.000 VNĐ/trọn khóa 6 tuần (đã bao gồm chi phí học tập, tài
              liệu, hoạt động và ăn uống trong ngày)
            </p>
            <button class="detail-button" @click="showProgramDetail('mam')">
              Chi tiết chương trình học
            </button>
          </div>
        </div>

        <!-- Box 2 -->
        <div
          class="program-box animate-on-scroll"
          data-animation="fade-up"
          data-delay="400"
        >
          <h3 class="program-name">VƯỜN ƯM BÉ VÀO LỚP CHỒI</h3>
          <img
            src="../../../assets/images/Home/1_638505759099380765.jpg"
            alt="Mùa hè sáng tạo"
            class="program-image"
          />
          <div class="program-content">
            <p>
              <strong>Đối tượng:</strong><br />Học sinh sinh năm 2025 chuẩn bị
              vào lớp chòi tại trường mầm non Sky-Line và các trường mầm non
              khác trong khu vực.
            </p>
            <p>
              <strong>Thời gian:</strong><br />9/6/2025 – 18/7/2025 (6 tuần)
            </p>
            <p>
              <strong>Địa điểm học tập và sinh hoạt:</strong><br />Các cơ sở (2,
              3, 4, 5) thuộc Hệ thống Giáo dục Sky-Line
            </p>
            <p>
              <strong>Học phí:</strong><br />7.900.000 VNĐ/trọn khóa 6 tuần (bao
              gồm chi phí học tập, trải nghiệm sáng tạo và ăn uống)
            </p>
            <button class="detail-button" @click="showProgramDetail('choi')">
              Chi tiết chương trình học
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal chi tiết chương trình -->
    <div v-if="showModal" class="modal-overlay" @click="closeModal">
      <div class="modal-content" @click.stop>
        <div class="modal-header">
          <h3>{{ currentProgram.title }}</h3>
          <button class="close-button" @click="closeModal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="detail-section">
            <h4>📚 Nội dung chương trình</h4>
            <ul>
              <li v-for="content in currentProgram.contents" :key="content">
                {{ content }}
              </li>
            </ul>
          </div>

          <div class="detail-section">
            <h4>🎯 Mục tiêu</h4>
            <ul>
              <li v-for="goal in currentProgram.goals" :key="goal">
                {{ goal }}
              </li>
            </ul>
          </div>

          <div class="detail-section">
            <h4>📋 Thông tin thêm</h4>
            <div class="info-grid">
              <div class="info-item">
                <strong>Số lượng học sinh:</strong>
                <span>{{ currentProgram.studentCount }}</span>
              </div>
              <div class="info-item">
                <strong>Giáo viên:</strong>
                <span>{{ currentProgram.teachers }}</span>
              </div>
              <div class="info-item">
                <strong>Hoạt động ngoại khóa:</strong>
                <span>{{ currentProgram.activities }}</span>
              </div>
              <div class="info-item">
                <strong>Đăng ký:</strong>
                <span>{{ currentProgram.registration }}</span>
              </div>
            </div>
          </div>

          <div class="detail-section">
            <h4>💰 Chi phí chi tiết</h4>
            <div class="cost-breakdown">
              <div
                v-for="cost in currentProgram.costs"
                :key="cost.item"
                class="cost-item"
              >
                <span>{{ cost.item }}</span>
                <span>{{ cost.amount }}</span>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="register-button" @click="goToRegistration">Đăng ký ngay</button>
          <button class="contact-button">Liên hệ tư vấn</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { useRouter } from "vue-router";

export default {
  name: "TuitionComponent",
  setup() {
    const router = useRouter();

    const goToRegistration = () => {
      router.push("/registration");
    };

    return {
      goToRegistration,
    };
  },
  data() {
    return {
      showModal: false,
      currentProgram: {},
      programDetails: {
        mam: {
          title: "VƯỜN ƯM BÉ VÀO LỚP MẦM",
          contents: [
            "Làm quen với môi trường học tập mới",
            "Phát triển kỹ năng giao tiếp và xã hội",
            "Rèn luyện thói quen sinh hoạt tự lập",
            "Khám phá thế giới xung quanh qua trò chơi",
            "Phát triển vận động tinh và thô",
            "Học tập qua các hoạt động vui chơi",
          ],
          goals: [
            "Giúp trẻ thích nghi với môi trường học đường",
            "Phát triển toàn diện về thể chất và tinh thần",
            "Xây dựng nền tảng cho việc học tập sau này",
            "Tăng cường sự tự tin và độc lập của trẻ",
          ],
          studentCount: "15-20 trẻ/lớp",
          teachers: "2 giáo viên chính + 1 trợ giảng",
          activities: "Vẽ tranh, ca hát, múa, thể dục, nấu ăn",
          registration: "Từ 1/5/2025 đến 31/5/2025",
          costs: [
            { item: "Học phí", amount: "7.000.000 VNĐ" },
            { item: "Ăn uống", amount: "1.200.000 VNĐ" },
            { item: "Tài liệu", amount: "200.000 VNĐ" },
            { item: "Hoạt động", amount: "100.000 VNĐ" },
            { item: "Tổng cộng", amount: "8.500.000 VNĐ" },
          ],
        },
        choi: {
          title: "VƯỜN ƯM BÉ VÀO LỚP CHỒI",
          contents: [
            "Phát triển khả năng ngôn ngữ và giao tiếp",
            "Rèn luyện kỹ năng vận động cơ bản",
            "Học tập qua trải nghiệm và khám phá",
            "Phát triển tư duy logic và sáng tạo",
            "Xây dựng thói quen học tập tích cực",
            "Tăng cường kỹ năng sống cần thiết",
          ],
          goals: [
            "Chuẩn bị tốt nhất cho bậc học tiếp theo",
            "Phát triển khả năng tự học và tự nghiên cứu",
            "Xây dựng tính cách tích cực và lạc quan",
            "Tăng cường khả năng làm việc nhóm",
          ],
          studentCount: "18-22 trẻ/lớp",
          teachers: "2 giáo viên chính + 1 trợ giảng",
          activities: "Thí nghiệm khoa học, làm vườn, nấu ăn, thể thao",
          registration: "Từ 1/5/2025 đến 31/5/2025",
          costs: [
            { item: "Học phí", amount: "6.500.000 VNĐ" },
            { item: "Ăn uống", amount: "1.100.000 VNĐ" },
            { item: "Tài liệu", amount: "200.000 VNĐ" },
            { item: "Hoạt động", amount: "100.000 VNĐ" },
            { item: "Tổng cộng", amount: "7.900.000 VNĐ" },
          ],
        },
      },
    };
  },
  mounted() {
    this.initScrollAnimations();
  },
  methods: {
    showProgramDetail(programType) {
      this.currentProgram = this.programDetails[programType];
      this.showModal = true;
      document.body.style.overflow = "hidden";
    },
    closeModal() {
      this.showModal = false;
      document.body.style.overflow = "auto";
    },
    initScrollAnimations() {
      const observerOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px",
      };

      const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            const element = entry.target;
            const animation = element.dataset.animation;
            const delay = element.dataset.delay || 0;

            setTimeout(() => {
              element.classList.add("animate-visible");
            }, delay);

            observer.unobserve(element);
          }
        });
      }, observerOptions);

      // Quan sát tất cả các element có class animate-on-scroll
      const animateElements = document.querySelectorAll(".animate-on-scroll");
      animateElements.forEach((el) => {
        observer.observe(el);
      });
    },
  },
  beforeUnmount() {
    // Cleanup observer nếu cần
    if (this.observer) {
      this.observer.disconnect();
    }
    // Reset body overflow
    document.body.style.overflow = "auto";
  },
};
</script>

<style lang="scss">
@use "./style.scss";
</style>
