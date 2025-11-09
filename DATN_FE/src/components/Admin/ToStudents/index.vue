<template>
  <div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
      <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
          <div>
            <h4 class="mb-0">Thống Kê Chi Tiết Học Sinh</h4>
            <p class="text-muted mb-0">
              Tổng quan về tình hình học sinh tại Mầm non Laura
            </p>
          </div>
          <div class="page-title-right">
            <button class="btn btn-primary" @click="goBack">
              <i class="bx bx-arrow-back me-2"></i>Quay lại Dashboard
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Stats Overview -->
    <div class="row mb-4">
      <div class="col-xl-3 col-md-6">
        <div class="card stats-card stats-primary">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="stats-icon">
                <i class="bx bx-user-plus"></i>
              </div>
              <div class="stats-content">
                <h3 class="stats-number">324</h3>
                <p class="stats-label">Tổng học sinh</p>
                <div class="stats-change positive">
                  <i class="bx bx-up-arrow-alt"></i> +12 (3.8%)
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="card stats-card stats-success">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="stats-icon">
                <i class="bx bx-check-circle"></i>
              </div>
              <div class="stats-content">
                <h3 class="stats-number">305</h3>
                <p class="stats-label">Đang học</p>
                <div class="stats-change positive">
                  <i class="bx bx-up-arrow-alt"></i> +8 (2.7%)
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="card stats-card stats-warning">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="stats-icon">
                <i class="bx bx-pause-circle"></i>
              </div>
              <div class="stats-content">
                <h3 class="stats-number">19</h3>
                <p class="stats-label">Nghỉ phép</p>
                <div class="stats-change negative">
                  <i class="bx bx-down-arrow-alt"></i> -3 (13.6%)
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="card stats-card stats-info">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="stats-icon">
                <i class="bx bx-user-x"></i>
              </div>
              <div class="stats-content">
                <h3 class="stats-number">0</h3>
                <p class="stats-label">Đã nghỉ học</p>
                <div class="stats-change neutral">
                  <i class="bx bx-minus"></i> 0 (0%)
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Charts Section -->
    <div class="row mb-4">
      <!-- Student Growth Chart -->
      <div class="col-xl-8">
        <div class="card chart-card">
          <div class="card-header">
            <h5 class="card-title">
              <i class="bx bx-trending-up me-2"></i>Biểu đồ tăng trưởng học sinh
            </h5>
            <div class="card-actions">
              <button class="btn btn-sm btn-outline-primary active">
                6 tháng
              </button>
              <button class="btn btn-sm btn-outline-secondary">1 năm</button>
              <button class="btn btn-sm btn-outline-secondary">2 năm</button>
            </div>
          </div>
          <div class="card-body">
            <div class="chart-container" style="height: 350px">
              <canvas id="studentGrowthChart"></canvas>
            </div>
          </div>
        </div>
      </div>

      <!-- Class Distribution -->
      <div class="col-xl-4">
        <div class="card chart-card">
          <div class="card-header">
            <h5 class="card-title">
              <i class="bx bx-pie-chart me-2"></i>Phân bố theo lớp
            </h5>
          </div>
          <div class="card-body">
            <div class="chart-container" style="height: 350px">
              <canvas id="classDistributionChart"></canvas>
            </div>
            <div class="class-stats mt-3">
              <div class="class-stat-item">
                <span class="class-color" style="background-color: #ff6384"></span>
                <span class="class-name">Lớp Mầm</span>
                <span class="class-count">108 học sinh</span>
              </div>
              <div class="class-stat-item">
                <span class="class-color" style="background-color: #36a2eb"></span>
                <span class="class-name">Lớp Chồi</span>
                <span class="class-count">108 học sinh</span>
              </div>
              <div class="class-stat-item">
                <span class="class-color" style="background-color: #ffcd56"></span>
                <span class="class-name">Lớp Lá</span>
                <span class="class-count">108 học sinh</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Gender and Age Statistics -->
    <div class="row mb-4">
      <div class="col-xl-6">
        <div class="card stats-detail-card">
          <div class="card-header">
            <h5 class="card-title">
              <i class="bx bx-male-female me-2"></i>Thống kê theo giới tính
            </h5>
          </div>
          <div class="card-body">
            <div class="gender-stats">
              <div class="gender-item">
                <div class="gender-icon male">
                  <i class="bx bx-male"></i>
                </div>
                <div class="gender-info">
                  <h4>168</h4>
                  <p>Nam (51.9%)</p>
                </div>
              </div>
              <div class="gender-item">
                <div class="gender-icon female">
                  <i class="bx bx-female"></i>
                </div>
                <div class="gender-info">
                  <h4>156</h4>
                  <p>Nữ (48.1%)</p>
                </div>
              </div>
            </div>
            <div class="progress-container mt-3">
              <div class="progress">
                <div class="progress-bar bg-primary" style="width: 51.9%"></div>
                <div class="progress-bar bg-pink" style="width: 48.1%"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-6">
        <div class="card stats-detail-card">
          <div class="card-header">
            <h5 class="card-title">
              <i class="bx bx-calendar me-2"></i>Thống kê theo độ tuổi
            </h5>
          </div>
          <div class="card-body">
            <div class="age-stats">
              <div class="age-item">
                <div class="age-range">3-4 tuổi</div>
                <div class="age-count">108 học sinh</div>
                <div class="age-bar">
                  <div class="age-progress" style="width: 33.3%"></div>
                </div>
              </div>
              <div class="age-item">
                <div class="age-range">4-5 tuổi</div>
                <div class="age-count">108 học sinh</div>
                <div class="age-bar">
                  <div class="age-progress" style="width: 33.3%"></div>
                </div>
              </div>
              <div class="age-item">
                <div class="age-range">5-6 tuổi</div>
                <div class="age-count">108 học sinh</div>
                <div class="age-bar">
                  <div class="age-progress" style="width: 33.3%"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Students Table -->
    <div class="row mb-4">
      <div class="col-12">
        <div class="card table-card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
              <i class="bx bx-list-ul me-2"></i>Học sinh mới nhập học
            </h5>
            <button class="btn btn-primary" @click="viewAllStudents">
              <i class="bx bx-show me-2"></i>Xem tất cả
            </button>
          </div>
          <div class="card-body">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Họ và tên</th>
                  <th>Lớp</th>
                  <th>Giới tính</th>
                  <th>Ngày sinh</th>
                  <th>Ngày nhập học</th>
                  <th>Trạng thái</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(student, index) in recentStudents" :key="index">
                  <td>{{ index + 1 }}</td>
                  <td>
                    <div class="d-flex align-items-center">
                      <div class="student-avatar me-2">
                        <img :src="student.avatar || '/default-avatar.png'" :alt="student.name" class="rounded-circle"
                          width="32" height="32" />
                      </div>
                      <span class="fw-medium">{{ student.name }}</span>
                    </div>
                  </td>
                  <td>
                    <span class="badge bg-info">{{ student.class }}</span>
                  </td>
                  <td>{{ student.gender }}</td>
                  <td>{{ student.birthDate }}</td>
                  <td>{{ student.enrollDate }}</td>
                  <td>
                    <span class="badge" :class="getStatusClass(student.status)">{{ student.status }}</span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="row">
      <div class="col-12">
        <div class="card action-card">
          <div class="card-body">
            <div class="d-flex justify-content-center gap-3">
              <button class="btn btn-primary btn-lg" @click="viewAllStudents">
                <i class="bx bx-list-ul me-2"></i>Quản lý học sinh
              </button>
              <button class="btn btn-success btn-lg" @click="addNewStudent">
                <i class="bx bx-user-plus me-2"></i>Thêm học sinh mới
              </button>
              <button class="btn btn-info btn-lg" @click="exportReport">
                <i class="bx bx-download me-2"></i>Xuất báo cáo
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, onUnmounted } from "vue";
import { useRouter } from "vue-router";
import Chart from "chart.js/auto";

export default {
  name: "StudentStats",
  setup() {
    const router = useRouter();
    const recentStudents = ref([
      {
        name: "Nguyễn Văn An",
        class: "Lớp Mầm",
        gender: "Nam",
        birthDate: "15/03/2020",
        enrollDate: "01/12/2024",
        status: "Đang học",
        avatar: "",
      },
      {
        name: "Trần Thị Bình",
        class: "Lớp Chồi",
        gender: "Nữ",
        birthDate: "22/07/2019",
        enrollDate: "28/11/2024",
        status: "Đang học",
        avatar: "",
      },
      {
        name: "Lê Minh Cường",
        class: "Lớp Lá",
        gender: "Nam",
        birthDate: "10/01/2018",
        enrollDate: "25/11/2024",
        status: "Đang học",
        avatar: "",
      },
      {
        name: "Phạm Thị Dung",
        class: "Lớp Mầm",
        gender: "Nữ",
        birthDate: "05/09/2020",
        enrollDate: "20/11/2024",
        status: "Đang học",
        avatar: "",
      },
      {
        name: "Hoàng Văn Em",
        class: "Lớp Chồi",
        gender: "Nam",
        birthDate: "18/12/2019",
        enrollDate: "15/11/2024",
        status: "Đang học",
        avatar: "",
      },
    ]);

    const goBack = () => {
      router.push("/admin/dashboard");
    };

    const viewAllStudents = () => {
      router.push("/admin/hoc-sinh");
    };

    const addNewStudent = () => {
      router.push("/admin/hoc-sinh");
    };

    const exportReport = () => {
      // Logic xuất báo cáo
      alert("Chức năng xuất báo cáo đang được phát triển");
    };

    const getStatusClass = (status) => {
      switch (status) {
        case "Đang học":
          return "bg-success";
        case "Nghỉ phép":
          return "bg-warning";
        case "Đã nghỉ học":
          return "bg-danger";
        default:
          return "bg-secondary";
      }
    };

    onMounted(() => {
      // Student Growth Chart
      const growthCtx = document.getElementById("studentGrowthChart");
      if (growthCtx) {
        new Chart(growthCtx, {
          type: "line",
          data: {
            labels: [
              "T7/2024",
              "T8/2024",
              "T9/2024",
              "T10/2024",
              "T11/2024",
              "T12/2024",
            ],
            datasets: [
              {
                label: "Tổng học sinh",
                data: [298, 305, 312, 318, 320, 324],
                borderColor: "rgb(75, 192, 192)",
                backgroundColor: "rgba(75, 192, 192, 0.1)",
                tension: 0.4,
                fill: true,
              },
              {
                label: "Học sinh mới",
                data: [12, 15, 8, 10, 6, 12],
                borderColor: "rgb(255, 99, 132)",
                backgroundColor: "rgba(255, 99, 132, 0.1)",
                tension: 0.4,
                fill: true,
              },
            ],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                position: "top",
              },
            },
            scales: {
              y: {
                beginAtZero: false,
                min: 280,
              },
            },
          },
        });
      }

      // Class Distribution Chart
      const distributionCtx = document.getElementById("classDistributionChart");
      if (distributionCtx) {
        new Chart(distributionCtx, {
          type: "doughnut",
          data: {
            labels: ["Lớp Mầm", "Lớp Chồi", "Lớp Lá"],
            datasets: [
              {
                data: [108, 108, 108],
                backgroundColor: [
                  "rgba(255, 99, 132, 0.8)",
                  "rgba(54, 162, 235, 0.8)",
                  "rgba(255, 205, 86, 0.8)",
                ],
                borderColor: [
                  "rgba(255, 99, 132, 1)",
                  "rgba(54, 162, 235, 1)",
                  "rgba(255, 205, 86, 1)",
                ],
                borderWidth: 2,
              },
            ],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                display: false,
              },
            },
          },
        });
      }
    });

    return {
      recentStudents,
      goBack,
      viewAllStudents,
      addNewStudent,
      exportReport,
      getStatusClass,
    };
  },
};
</script>

<style scoped>
.page-title-box {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 25px;
  border-radius: 15px;
  margin-bottom: 30px;
}

.page-title-box h4 {
  color: white;
  margin: 0;
  font-weight: 600;
}

.page-title-box p {
  color: rgba(255, 255, 255, 0.8);
  margin: 5px 0 0 0;
}

.stats-card {
  border: none;
  border-radius: 15px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
  overflow: hidden;
}

.stats-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
}

.stats-primary {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
}

.stats-success {
  background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
  color: white;
}

.stats-warning {
  background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
  color: white;
}

.stats-info {
  background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
  color: white;
}

.stats-icon {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.2);
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 15px;
}

.stats-icon i {
  font-size: 24px;
}

.stats-number {
  font-size: 2.5rem;
  font-weight: 700;
  margin: 0;
  line-height: 1;
}

.stats-label {
  font-size: 0.9rem;
  margin: 5px 0;
  opacity: 0.9;
}

.stats-change {
  font-size: 0.8rem;
  font-weight: 500;
}

.stats-change.positive {
  color: #d4edda;
}

.stats-change.negative {
  color: #f8d7da;
}

.stats-change.neutral {
  color: #e2e3e5;
}

.chart-card,
.stats-detail-card,
.table-card,
.action-card {
  border: none;
  border-radius: 15px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.card-header {
  background: #f8f9fa;
  border-bottom: 1px solid #e9ecef;
  border-radius: 15px 15px 0 0 !important;
  padding: 20px;
}

.card-title {
  font-weight: 600;
  color: #495057;
  margin: 0;
}

.card-actions {
  margin-top: 15px;
}

.card-actions .btn {
  margin-right: 10px;
  border-radius: 20px;
}

.class-stats {
  padding-top: 15px;
  border-top: 1px solid #e9ecef;
}

.class-stat-item {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
}

.class-color {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  margin-right: 10px;
}

.class-name {
  flex: 1;
  font-weight: 500;
}

.class-count {
  color: #6c757d;
  font-size: 0.9rem;
}

.gender-stats {
  display: flex;
  justify-content: space-around;
  text-align: center;
}

.gender-item {
  flex: 1;
}

.gender-icon {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 15px;
  font-size: 2rem;
}

.gender-icon.male {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
}

.gender-icon.female {
  background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
  color: white;
}

.gender-info h4 {
  font-size: 2rem;
  font-weight: 700;
  margin: 0;
  color: #495057;
}

.gender-info p {
  color: #6c757d;
  margin: 5px 0 0 0;
}

.progress-container {
  padding: 0 20px;
}

.progress {
  height: 8px;
  border-radius: 10px;
  overflow: hidden;
}

.bg-pink {
  background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%) !important;
}

.age-stats {
  space-y: 15px;
}

.age-item {
  margin-bottom: 20px;
}

.age-range {
  font-weight: 600;
  color: #495057;
  margin-bottom: 5px;
}

.age-count {
  color: #6c757d;
  font-size: 0.9rem;
  margin-bottom: 8px;
}

.age-bar {
  height: 8px;
  background: #e9ecef;
  border-radius: 10px;
  overflow: hidden;
}

.age-progress {
  height: 100%;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 10px;
  transition: width 0.3s ease;
}

.table-responsive {
  border-radius: 10px;
  overflow: hidden;
}

.table {
  margin: 0;
}

.table th {
  background: #f8f9fa;
  border: none;
  font-weight: 600;
  color: #495057;
  padding: 15px;
}

.table td {
  border: none;
  padding: 15px;
  vertical-align: middle;
}

.table-hover tbody tr:hover {
  background-color: #f8f9fa;
}

.student-avatar img {
  object-fit: cover;
}

.fw-medium {
  font-weight: 500;
}

.action-card .card-body {
  padding: 30px;
}

.btn-lg {
  padding: 12px 30px;
  border-radius: 25px;
  font-weight: 500;
}

@media (max-width: 768px) {
  .stats-number {
    font-size: 2rem;
  }

  .gender-stats {
    flex-direction: column;
    gap: 20px;
  }

  .d-flex.gap-3 {
    flex-direction: column;
    gap: 15px !important;
  }
}
</style>
