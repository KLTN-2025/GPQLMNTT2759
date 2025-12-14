<template>
  <div class="payment-history-container">
    <div class="payment-wrapper">
      <h2 class="title">
        <i class="mdi mdi-credit-card-outline"></i>
        LỊCH SỬ THANH TOÁN
      </h2>

      <div class="filter-section">
        <div class="filter-row">
          <div class="filter-item">
            <label for="schoolYear">Chọn Năm học:</label>
            <select
              id="schoolYear"
              v-model="selectedSchoolYear"
              class="form-select"
            >
              <option value="">Chọn Năm học</option>
              <option value="2023-2024">2023-2024</option>
              <option value="2024-2025">2024-2025</option>
              <option value="2025-2026">2025-2026</option>
            </select>
          </div>

          <div class="filter-item">
            <label for="semester">Chọn Học kỳ:</label>
            <select
              id="semester"
              v-model="selectedSemester"
              class="form-select"
            >
              <option value="">Chọn Học kỳ</option>
              <option value="1">Học kỳ 1</option>
              <option value="2">Học kỳ 2</option>
              <option value="3">Học kỳ 3</option>
            </select>
          </div>
        </div>
      </div>

      <div class="payment-content">
        <div v-if="!hasPaymentData" class="no-data-message">
          <i class="mdi mdi-information-outline"></i>
          <p>Chưa có Hóa đơn Học phí cho Học kỳ này</p>
        </div>

        <div v-else class="payment-table-wrapper">
          <table class="payment-table">
            <thead>
              <tr>
                <th>STT</th>
                <th>Mã hóa đơn</th>
                <th>Ngày thanh toán</th>
                <th>Học phí</th>
                <th>Phí ăn</th>
                <th>Phí khác</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(payment, index) in paymentHistory" :key="payment.id">
                <td>{{ index + 1 }}</td>
                <td>{{ payment.invoiceCode }}</td>
                <td>{{ formatDate(payment.paymentDate) }}</td>
                <td>{{ formatCurrency(payment.tuitionFee) }}</td>
                <td>{{ formatCurrency(payment.mealFee) }}</td>
                <td>{{ formatCurrency(payment.otherFee) }}</td>
                <td class="total-amount">
                  {{ formatCurrency(payment.totalAmount) }}
                </td>
                <td>
                  <span :class="['status-badge', payment.status.toLowerCase()]">
                    {{ payment.status }}
                  </span>
                </td>
                <td>
                  <button
                    class="btn-detail"
                    @click="viewDetail(payment)"
                    title="Xem chi tiết"
                  >
                    <i class="mdi mdi-eye"></i>
                  </button>
                  <button
                    class="btn-download"
                    @click="downloadInvoice(payment)"
                    title="Tải hóa đơn"
                  >
                    <i class="mdi mdi-download"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from "vue";

const selectedSchoolYear = ref("");
const selectedSemester = ref("");
const paymentHistory = ref([]);

const samplePaymentData = [
  {
    id: 1,
    invoiceCode: "HD001",
    paymentDate: "2024-01-15",
    tuitionFee: 2500000,
    mealFee: 800000,
    otherFee: 200000,
    totalAmount: 3500000,
    status: "Đã thanh toán",
  },
  {
    id: 2,
    invoiceCode: "HD002",
    paymentDate: "2024-02-15",
    tuitionFee: 2500000,
    mealFee: 800000,
    otherFee: 150000,
    totalAmount: 3450000,
    status: "Đã thanh toán",
  },
  {
    id: 3,
    invoiceCode: "HD003",
    paymentDate: null,
    tuitionFee: 2500000,
    mealFee: 800000,
    otherFee: 200000,
    totalAmount: 3500000,
    status: "Chưa thanh toán",
  },
];

// Computed properties
const hasPaymentData = computed(() => {
  if (!selectedSchoolYear.value || !selectedSemester.value) {
    return false;
  }
  return paymentHistory.value.length > 0;
});

// Methods
const formatCurrency = (amount) => {
  return new Intl.NumberFormat("vi-VN", {
    style: "currency",
    currency: "VND",
  }).format(amount);
};

const formatDate = (dateString) => {
  if (!dateString) return "Chưa thanh toán";
  return new Date(dateString).toLocaleDateString("vi-VN");
};

const viewDetail = (payment) => {
  // Handle view detail logic
  console.log("View detail for:", payment);
  // You can open a modal or navigate to detail page
};

const downloadInvoice = (payment) => {
  // Handle download invoice logic
  console.log("Download invoice for:", payment);
  // You can trigger file download here
};

const loadPaymentHistory = () => {
  // Simulate API call based on selected year and semester
  if (selectedSchoolYear.value && selectedSemester.value) {
    // Replace this with actual API call
    paymentHistory.value = samplePaymentData;
  } else {
    paymentHistory.value = [];
  }
};

// Watchers
watch([selectedSchoolYear, selectedSemester], () => {
  loadPaymentHistory();
});

// Lifecycle
onMounted(() => {
  // Initialize component
});
</script>

<style lang="scss">
@import "./style.scss";
</style>
