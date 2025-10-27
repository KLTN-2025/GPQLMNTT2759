<template>
  <div class="registration-container">
    <div class="registration-header">
      <h1 class="page-title">ĐĂNG KÝ NHẬP HỌC</h1>
      <p class="page-subtitle">
        Vui lòng điền đầy đủ thông tin để hoàn tất đăng ký
      </p>
    </div>

    <form @submit.prevent="submitRegistration" class="registration-form">
      <!-- Thông tin học sinh -->
      <div class="form-section">
        <h3 class="section-title">Thông tin học sinh</h3>
        <div class="form-grid">
          <div class="form-group">
            <label for="studentName">Họ và tên học sinh *</label>
            <input
              type="text"
              id="studentName"
              v-model="formData.studentName"
              required
              placeholder="Nhập họ và tên đầy đủ"
            />
          </div>

          <div class="form-group">
            <label for="birthDate">Ngày sinh *</label>
            <input
              type="date"
              id="birthDate"
              v-model="formData.birthDate"
              required
            />
          </div>

          <div class="form-group">
            <label for="gender">Giới tính *</label>
            <select id="gender" v-model="formData.gender" required>
              <option value="">Chọn giới tính</option>
              <option value="male">Nam</option>
              <option value="female">Nữ</option>
            </select>
          </div>

          <div class="form-group">
            <label for="address">Địa chỉ thường trú *</label>
            <input
              type="text"
              id="address"
              v-model="formData.address"
              required
              placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành phố"
            />
          </div>
        </div>
      </div>

      <!-- Thông tin phụ huynh -->
      <div class="form-section">
        <h3 class="section-title">Thông tin phụ huynh</h3>

        <!-- Thông tin bố -->
        <div class="parent-info">
          <h4>Thông tin bố</h4>
          <div class="form-grid">
            <div class="form-group">
              <label for="fatherName">Họ và tên bố *</label>
              <input
                type="text"
                id="fatherName"
                v-model="formData.fatherName"
                required
                placeholder="Nhập họ và tên bố"
              />
            </div>

            <div class="form-group">
              <label for="fatherPhone">Số điện thoại bố *</label>
              <input
                type="tel"
                id="fatherPhone"
                v-model="formData.fatherPhone"
                required
                placeholder="Nhập số điện thoại"
              />
            </div>

            <div class="form-group">
              <label for="fatherJob">Nghề nghiệp bố</label>
              <input
                type="text"
                id="fatherJob"
                v-model="formData.fatherJob"
                placeholder="Nhập nghề nghiệp"
              />
            </div>

            <div class="form-group">
              <label for="fatherEmail">Email bố</label>
              <input
                type="email"
                id="fatherEmail"
                v-model="formData.fatherEmail"
                placeholder="Nhập email"
              />
            </div>
          </div>
        </div>

        <!-- Thông tin mẹ -->
        <div class="parent-info">
          <h4>Thông tin mẹ</h4>
          <div class="form-grid">
            <div class="form-group">
              <label for="motherName">Họ và tên mẹ *</label>
              <input
                type="text"
                id="motherName"
                v-model="formData.motherName"
                required
                placeholder="Nhập họ và tên mẹ"
              />
            </div>

            <div class="form-group">
              <label for="motherPhone">Số điện thoại mẹ *</label>
              <input
                type="tel"
                id="motherPhone"
                v-model="formData.motherPhone"
                required
                placeholder="Nhập số điện thoại"
              />
            </div>

            <div class="form-group">
              <label for="motherJob">Nghề nghiệp mẹ</label>
              <input
                type="text"
                id="motherJob"
                v-model="formData.motherJob"
                placeholder="Nhập nghề nghiệp"
              />
            </div>

            <div class="form-group">
              <label for="motherEmail">Email mẹ</label>
              <input
                type="email"
                id="motherEmail"
                v-model="formData.motherEmail"
                placeholder="Nhập email"
              />
            </div>
          </div>
        </div>
      </div>

      <!-- Thông tin nghiệp vụ trường học -->
      <div class="form-section">
        <h3 class="section-title">Thông tin đăng ký học</h3>
        <div class="form-grid">
          <div class="form-group">
            <label for="program">Chương trình học *</label>
            <select
              id="program"
              v-model="formData.program"
              required
              @change="updateProgramInfo"
            >
              <option value="">Chọn chương trình học</option>
              <option value="mam">Vườn ươm bé vào lớp Mầm</option>
              <option value="choi">Vườn ươm bé vào lớp Chồi</option>
            </select>
          </div>

          <div class="form-group">
            <label for="campus">Cơ sở học tập *</label>
            <select id="campus" v-model="formData.campus" required>
              <option value="">Chọn cơ sở</option>
              <option value="campus2">Cơ sở 2 - Sky-Line</option>
              <option value="campus3">Cơ sở 3 - Sky-Line</option>
              <option value="campus4">Cơ sở 4 - Sky-Line</option>
              <option value="campus5">Cơ sở 5 - Sky-Line</option>
            </select>
          </div>

          <div class="form-group">
            <label for="startDate">Ngày bắt đầu học</label>
            <input
              type="date"
              id="startDate"
              :value="programInfo.startDate"
              readonly
              class="readonly-field"
            />
          </div>

          <div class="form-group">
            <label for="endDate">Ngày kết thúc</label>
            <input
              type="date"
              id="endDate"
              :value="programInfo.endDate"
              readonly
              class="readonly-field"
            />
          </div>

          <div class="form-group">
            <label for="tuitionFee">Học phí</label>
            <input
              type="text"
              id="tuitionFee"
              readonly
              :value="programInfo.tuitionFee"
              class="readonly-field"
            />
          </div>

          <div class="form-group">
            <label for="paymentMethod">Phương thức thanh toán *</label>
            <select
              id="paymentMethod"
              v-model="formData.paymentMethod"
              required
            >
              <option value="">Chọn phương thức</option>
              <option value="full">Thanh toán một lần</option>
              <option value="installment">Thanh toán theo đợt</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Thông tin bổ sung -->
      <div class="form-section">
        <h3 class="section-title">Thông tin bổ sung</h3>
        <div class="form-grid">
          <div class="form-group full-width">
            <label for="healthInfo">Tình trạng sức khỏe của trẻ</label>
            <textarea
              id="healthInfo"
              v-model="formData.healthInfo"
              placeholder="Mô tả tình trạng sức khỏe, dị ứng, bệnh lý (nếu có)..."
              rows="3"
            ></textarea>
          </div>

          <div class="form-group full-width">
            <label for="specialNeeds">Nhu cầu đặc biệt</label>
            <textarea
              id="specialNeeds"
              v-model="formData.specialNeeds"
              placeholder="Các nhu cầu đặc biệt về chế độ ăn, học tập..."
              rows="3"
            ></textarea>
          </div>

          <div class="form-group full-width">
            <label for="notes">Ghi chú thêm</label>
            <textarea
              id="notes"
              v-model="formData.notes"
              placeholder="Các thông tin khác mà phụ huynh muốn chia sẻ..."
              rows="3"
            ></textarea>
          </div>
        </div>
      </div>

      <!-- Điều khoản -->
      <div class="form-section">
        <div class="terms-section">
          <label class="checkbox-label">
            <input type="checkbox" v-model="formData.agreeTerms" required />
            <span class="checkmark"></span>
            Tôi đã đọc và đồng ý với
            <a href="#" @click.prevent="showTerms">điều khoản và điều kiện</a>
            của trường
          </label>
        </div>
      </div>

      <!-- Nút submit -->
      <div class="form-actions">
        <button type="button" @click="goBack" class="btn-secondary">
          Quay lại
        </button>
        <button
          type="submit"
          class="btn-primary"
          :disabled="!formData.agreeTerms"
        >
          Gửi đăng ký
        </button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  name: "RegistrationComponent",
  data() {
    return {
      formData: {
        // Thông tin học sinh
        studentName: "",
        birthDate: "",
        gender: "",
        address: "",

        // Thông tin phụ huynh
        fatherName: "",
        fatherPhone: "",
        fatherJob: "",
        fatherEmail: "",
        motherName: "",
        motherPhone: "",
        motherJob: "",
        motherEmail: "",

        // Thông tin nghiệp vụ
        program: "",
        campus: "",
        startDate: "",
        endDate: "",
        paymentMethod: "",

        // Thông tin bổ sung
        healthInfo: "",
        specialNeeds: "",
        notes: "",
        agreeTerms: false,
      },
      programInfo: {
        startDate: "",
        endDate: "",
        tuitionFee: "",
      },
      programs: {
        mam: {
          startDate: "2025-06-09",
          endDate: "2025-07-18",
          tuitionFee: "8.500.000 VNĐ",
        },
        choi: {
          startDate: "2025-06-09",
          endDate: "2025-07-18",
          tuitionFee: "7.900.000 VNĐ",
        },
      },
    };
  },
  methods: {
    updateProgramInfo() {
      if (this.formData.program && this.programs[this.formData.program]) {
        this.programInfo = { ...this.programs[this.formData.program] };
        this.formData.startDate = this.programInfo.startDate;
        this.formData.endDate = this.programInfo.endDate;
      } else {
        this.programInfo = {
          startDate: "",
          endDate: "",
          tuitionFee: "",
        };
      }
    },

    submitRegistration() {
      // Validate form
      if (!this.validateForm()) {
        return;
      }

      // Simulate API call
      this.showSuccessMessage();
    },

    validateForm() {
      // Basic validation
      const requiredFields = [
        "studentName",
        "birthDate",
        "gender",
        "address",
        "fatherName",
        "fatherPhone",
        "motherName",
        "motherPhone",
        "program",
        "campus",
        "paymentMethod",
      ];

      for (let field of requiredFields) {
        if (!this.formData[field]) {
          alert(`Vui lòng điền đầy đủ thông tin: ${this.getFieldLabel(field)}`);
          return false;
        }
      }

      if (!this.formData.agreeTerms) {
        alert("Vui lòng đồng ý với điều khoản và điều kiện");
        return false;
      }

      return true;
    },

    getFieldLabel(field) {
      const labels = {
        studentName: "Họ và tên học sinh",
        birthDate: "Ngày sinh",
        gender: "Giới tính",
        address: "Địa chỉ",
        fatherName: "Họ và tên bố",
        fatherPhone: "Số điện thoại bố",
        motherName: "Họ và tên mẹ",
        motherPhone: "Số điện thoại mẹ",
        program: "Chương trình học",
        campus: "Cơ sở học tập",
        paymentMethod: "Phương thức thanh toán",
      };
      return labels[field] || field;
    },

    showSuccessMessage() {
      alert(
        "Đăng ký thành công! Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất."
      );
      this.$router.push("/tuition");
    },

    showTerms() {
      alert("Điều khoản và điều kiện sẽ được hiển thị ở đây");
    },

    goBack() {
      this.$router.go(-1);
    },
  },
};
</script>

<style lang="scss">
@use "./style.scss";
</style>
