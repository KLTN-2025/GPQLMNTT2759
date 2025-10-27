<template>
  <div class="payment-guide-container">
    <!-- Hero Section -->
    <section class="hero-section">
      <div class="hero-content">
        <div class="hero-icon">
            <div class="item-card">
                 <i class="mdi mdi-credit-card-outline"></i>
            </div>
         
        </div>
        <h1 class="hero-title">Hướng Dẫn Thanh Toán</h1>
        <p class="hero-subtitle">
          Hướng dẫn chi tiết các phương thức thanh toán học phí tại Hoa Sen
        </p>
      </div>
    </section>

    <!-- Payment Methods Section -->
    <section class="payment-methods">
      <div class="container">
        <h2 class="section-title">Các Phương Thức Thanh Toán</h2>
        <div class="methods-grid">
          <div
            class="method-card"
            v-for="(method, index) in paymentMethods"
            :key="index"
            @click="selectMethod(method)"
            :class="{ active: selectedMethod?.id === method.id }"
          >
            <div class="method-icon">
              <i :class="method.icon"></i>
            </div>
            <h3>{{ method.name }}</h3>
            <p>{{ method.description }}</p>
            <div class="method-features">
              <span
                v-for="feature in method.features"
                :key="feature"
                class="feature-tag"
              >
                {{ feature }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Step by Step Guide -->
    <section class="step-guide" v-if="selectedMethod">
      <div class="container">
        <h2 class="section-title">
          Hướng Dẫn Thanh Toán {{ selectedMethod.name }}
        </h2>
        <div class="steps-container">
          <div
            class="step-item"
            v-for="(step, index) in selectedMethod.steps"
            :key="index"
          >
            <div class="step-number">{{ index + 1 }}</div>
            <div class="step-content">
              <h3>{{ step.title }}</h3>
              <p>{{ step.description }}</p>
              <div v-if="step.image" class="step-image">
                <img :src="step.image" :alt="step.title" />
              </div>
              <div v-if="step.note" class="step-note">
                <i class="mdi mdi-information-outline"></i>
                {{ step.note }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Important Information -->
    <section class="important-info">
      <div class="container">
        <h2 class="section-title">Thông Tin Quan Trọng</h2>
        <div class="info-grid">
          <div class="info-card">
            <div class="info-icon">
              <i class="mdi mdi-clock-outline"></i>
            </div>
            <h3>Thời Gian Thanh Toán</h3>
            <ul>
              <li>Học phí tháng: Trước ngày 5 hàng tháng</li>
              <li>Học phí học kỳ: Trước ngày khai giảng</li>
              <li>Phí dịch vụ: Theo thông báo của nhà trường</li>
            </ul>
          </div>

          <div class="info-card">
            <div class="info-icon">
              <i class="mdi mdi-receipt-text-outline"></i>
            </div>
            <h3>Hóa Đơn & Biên Lai</h3>
            <ul>
              <li>Lưu giữ biên lai thanh toán</li>
              <li>Hóa đơn điện tử sẽ được gửi qua email</li>
              <li>Liên hệ kế toán nếu có sai sót</li>
            </ul>
          </div>

          <div class="info-card">
            <div class="info-icon">
              <i class="mdi mdi-phone-outline"></i>
            </div>
            <h3>Hỗ Trợ Thanh Toán</h3>
            <ul>
              <li>Hotline: 1900-xxxx</li>
              <li>Email: ketoan@hoasen.edu.vn</li>
              <li>Thời gian: 8:00 - 17:00 (T2-T6)</li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
      <div class="container">
        <h2 class="section-title">Câu Hỏi Thường Gặp</h2>
        <div class="faq-list">
          <div
            class="faq-item"
            v-for="(faq, index) in faqs"
            :key="index"
            @click="toggleFaq(index)"
          >
            <div class="faq-question">
              <h3>{{ faq.question }}</h3>
              <i
                class="mdi"
                :class="faq.open ? 'mdi-chevron-up' : 'mdi-chevron-down'"
              ></i>
            </div>
            <transition name="fade-slide">
              <div class="faq-answer" v-show="faq.open">
                <p>{{ faq.answer }}</p>
              </div>
            </transition>
          </div>
        </div>
      </div>
    </section>

    


    <div
      class="newsletter-container"
      data-animation="fade-up"
    >
      <div class="newsletter-content">
        <div
          class="newsletter-text"
          data-animation="slide-left"
        >
          <h2>Hãy để lại thông tin nếu cần</h2>
          <p>
            Đội ngũ nhân viên nhân sẽ tư vấn và giải đáp các vấn đề còn thắc mắc
            của các quý phụ huynh
          </p>
        </div>
        <div
          class="newsletter-form"
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
</template>

<script>
import { ref, reactive } from "vue";
import "./style.scss";

export default {
  name: "PaymentGuide",
  setup() {
    const selectedMethod = ref(null);

    const paymentMethods = ref([
      {
        id: 1,
        name: "Chuyển Khoản Ngân Hàng",
        description: "Thanh toán qua chuyển khoản ngân hàng",
        icon: "mdi mdi-bank",
        features: ["An toàn", "Nhanh chóng", "24/7"],
        steps: [
          {
            title: "Đăng nhập Internet Banking",
            description: "Truy cập ứng dụng hoặc website ngân hàng của bạn",
            note: "Đảm bảo kết nối internet ổn định",
          },
          {
            title: "Chọn chức năng chuyển khoản",
            description: 'Tìm và chọn "Chuyển khoản" hoặc "Transfer"',
          },
          {
            title: "Nhập thông tin người nhận",
            description:
              "Số tài khoản: 1234567890 - Ngân hàng Vietcombank - Chủ TK: Trường Mầm Non Hoa Sen",
            note: "Kiểm tra kỹ thông tin trước khi chuyển",
          },
          {
            title: "Nhập số tiền và nội dung",
            description: 'Nội dung: "Họ tên học sinh - Lớp - Tháng thanh toán"',
            note: "Nội dung chuyển khoản rất quan trọng để đối soát",
          },
          {
            title: "Xác nhận và hoàn tất",
            description: "Kiểm tra lại thông tin và xác nhận giao dịch",
            note: "Lưu lại biên lai để đối soát",
          },
        ],
      },
      {
        id: 2,
        name: "Thanh Toán Tại Trường",
        description: "Thanh toán trực tiếp tại phòng kế toán",
        icon: "mdi mdi-school",
        features: ["Trực tiếp", "Hỗ trợ tận tình", "Biên lai ngay"],
        steps: [
          {
            title: "Chuẩn bị giấy tờ",
            description: "Mang theo CMND/CCCD và sổ học bạ của bé",
          },
          {
            title: "Đến phòng kế toán",
            description: "Phòng kế toán tầng 1, thời gian: 8:00-17:00 (T2-T6)",
          },
          {
            title: "Khai báo thông tin",
            description:
              "Cung cấp thông tin học sinh và khoản phí cần thanh toán",
          },
          {
            title: "Thanh toán",
            description: "Thanh toán bằng tiền mặt hoặc thẻ ATM",
          },
          {
            title: "Nhận biên lai",
            description: "Kiểm tra thông tin trên biên lai và lưu giữ cẩn thận",
          },
        ],
      },
      {
        id: 3,
        name: "Ví Điện Tử",
        description: "Thanh toán qua MoMo, ZaloPay, VNPay",
        icon: "mdi mdi-wallet",
        features: ["Tiện lợi", "Ưu đãi", "Tích điểm"],
        steps: [
          {
            title: "Mở ứng dụng ví điện tử",
            description: "Chọn ứng dụng MoMo, ZaloPay hoặc VNPay",
          },
          {
            title: "Quét mã QR",
            description: "Quét mã QR thanh toán được cung cấp bởi nhà trường",
          },
          {
            title: "Nhập số tiền",
            description: "Nhập chính xác số tiền cần thanh toán",
          },
          {
            title: "Nhập nội dung",
            description: 'Ghi rõ: "Họ tên học sinh - Lớp - Tháng thanh toán"',
          },
          {
            title: "Xác nhận thanh toán",
            description: "Nhập mã PIN hoặc xác thực sinh trắc học để hoàn tất",
          },
        ],
      },
    ]);

    const faqs = reactive([
      {
        question: "Tôi có thể thanh toán học phí muộn được không?",
        answer:
          "Bạn có thể thanh toán muộn nhưng sẽ bị tính phí phạt 50,000đ/ngày. Vui lòng liên hệ phòng kế toán để được hỗ trợ.",
        open: false,
      },
      {
        question: "Làm sao để kiểm tra lịch sử thanh toán?",
        answer:
          'Bạn có thể kiểm tra lịch sử thanh toán trong mục "Lịch sử thanh toán" trên website hoặc liên hệ phòng kế toán.',
        open: false,
      },
      {
        question: "Tôi chuyển nhầm số tiền thì phải làm sao?",
        answer:
          "Vui lòng liên hệ ngay với phòng kế toán qua hotline 1900-xxxx để được hỗ trợ xử lý.",
        open: false,
      },
      {
        question: "Có được hoàn tiền học phí không?",
        answer:
          "Học phí có thể được hoàn trả trong một số trường hợp đặc biệt theo quy định của nhà trường. Vui lòng liên hệ để được tư vấn cụ thể.",
        open: false,
      },
    ]);

    const selectMethod = (method) => {
      selectedMethod.value = method;
    };

    const toggleFaq = (index) => {
      faqs[index].open = !faqs[index].open;
    };

    return {
      selectedMethod,
      paymentMethods,
      faqs,
      selectMethod,
      toggleFaq,
    };
  },
};
</script>
