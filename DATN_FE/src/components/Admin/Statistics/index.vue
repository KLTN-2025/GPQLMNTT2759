<template>
  <div class="page-header education-theme">
    <div class="container-fluid">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="page-header-content">
            <div class="page-icon">
              <i class="fas fa-chart-pie"></i>
            </div>
            <div class="page-info">
              <h1 class="page-title">Thống Kê & Phân Tích</h1>
              <p class="page-subtitle">
                Dashboard thống kê toàn diện về hoạt động trường học
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-6 text-end">
          <nav class="breadcrumb-nav">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <i class="fas fa-home"></i>
                <a href="javascript: void(0);">Admin</a>
              </li>
              <li class="breadcrumb-item active">
                <i class="fas fa-chart-pie"></i>
                Thống Kê
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>

  <!-- Filter Section -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="filter-card">
        <div class="filter-header">
          <h5 class="filter-title">
            <i class="fas fa-filter me-2"></i>
            Bộ Lọc Thời Gian
          </h5>
        </div>
        <div class="filter-body">
          <div class="row">
            <div class="col-md-3 mb-3">
              <label class="form-label">Kỳ thống kê</label>
              <select class="form-select" v-model="period" @change="updateCharts">
                <option value="week">Tuần này</option>
                <option value="month">Tháng này</option>
                <option value="quarter">Quý này</option>
                <option value="semester">Học kỳ</option>
                <option value="year">Năm này</option>
                <option value="custom">Tùy chọn</option>
              </select>
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label">Từ ngày</label>
              <input type="date" class="form-control" v-model="dateFrom">
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label">Đến ngày</label>
              <input type="date" class="form-control" v-model="dateTo">
            </div>
            <div class="col-md-3 mb-3 d-flex align-items-end">
              <div class="btn-group w-100">
                <button class="btn btn-primary" @click="updateCharts">
                  <i class="fas fa-search me-1"></i>Áp dụng
                </button>
                <button class="btn btn-outline-secondary" @click="resetFilters">
                  <i class="fas fa-redo me-1"></i>Reset
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Statistics Overview -->
  <div class="row mb-4">
    <div class="col-xl-2 col-md-4 col-sm-6">
      <div class="stats-card stats-primary">
        <div class="stats-icon">
          <i class="fas fa-user-friends"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">{{ totalStudents }}</h3>
          <p class="stats-label">Học Sinh</p>
        </div>
      </div>
    </div>
    <div class="col-xl-2 col-md-4 col-sm-6">
      <div class="stats-card stats-success">
        <div class="stats-icon">
          <i class="fas fa-chalkboard-teacher"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">{{ totalTeachers }}</h3>
          <p class="stats-label">Giáo Viên</p>
        </div>
      </div>
    </div>
    <div class="col-xl-2 col-md-4 col-sm-6">
      <div class="stats-card stats-warning">
        <div class="stats-icon">
          <i class="fas fa-graduation-cap"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">{{ totalClasses }}</h3>
          <p class="stats-label">Lớp Học</p>
        </div>
      </div>
    </div>
    <div class="col-xl-2 col-md-4 col-sm-6">
      <div class="stats-card stats-info">
        <div class="stats-icon">
          <i class="fas fa-check-circle"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">{{ attendanceRate }}%</h3>
          <p class="stats-label">Đi Học</p>
        </div>
      </div>
    </div>
    <div class="col-xl-2 col-md-4 col-sm-6">
      <div class="stats-card stats-danger">
        <div class="stats-icon">
          <i class="fas fa-hospital"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">{{ healthStatus }}</h3>
          <p class="stats-label">Sức Khỏe</p>
        </div>
      </div>
    </div>
    <div class="col-xl-2 col-md-4 col-sm-6">
      <div class="stats-card stats-secondary">
        <div class="stats-icon">
          <i class="fas fa-utensils"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">{{ mealRate }}%</h3>
          <p class="stats-label">Dinh Dưỡng</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Comparative Statistics -->
  <div class="row mb-4">
    <div class="col-xl-12">
      <div class="management-card">
        <div class="card-header-custom">
          <div class="header-content">
            <div class="header-icon">
              <i class="fas fa-chart-bar"></i>
            </div>
            <div class="header-text">
              <h5 class="card-title">So Sánh Dữ Liệu</h5>
              <p class="card-subtitle">So sánh giữa các kỳ học</p>
            </div>
          </div>
          <select class="form-select form-select-sm" style="width: auto;">
            <option value="attendance">Điểm danh</option>
            <option value="financial">Tài chính</option>
            <option value="health">Sức khỏe</option>
            <option value="meal">Ăn uống</option>
          </select>
        </div>
        <div class="card-body">
          <canvas id="comparisonChart" height="80"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- Multiple Charts Row -->
  <div class="row mb-4">
    <!-- Student Growth Chart -->
    <div class="col-xl-8">
      <div class="management-card">
        <div class="card-header-custom">
          <div class="header-content">
            <div class="header-icon">
              <i class="fas fa-chart-line"></i>
            </div>
            <div class="header-text">
              <h5 class="card-title">Tăng Trưởng Học Sinh</h5>
              <p class="card-subtitle">Biểu đồ tăng trưởng theo tháng</p>
            </div>
          </div>
        </div>
        <div class="card-body">
          <canvas id="studentGrowthChart" height="300"></canvas>
        </div>
      </div>
    </div>

    <!-- Gender Distribution -->
    <div class="col-xl-4">
      <div class="management-card">
        <div class="card-header-custom">
          <div class="header-content">
            <div class="header-icon">
              <i class="fas fa-users"></i>
            </div>
            <div class="header-text">
              <h5 class="card-title">Phân Bổ Giới Tính</h5>
              <p class="card-subtitle">Tỷ lệ Nam/Nữ</p>
            </div>
          </div>
        </div>
        <div class="card-body">
          <canvas id="genderChart" height="300"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- More Charts Row 1 -->
  <div class="row mb-4">
    <!-- Age Distribution -->
    <div class="col-xl-6">
      <div class="management-card">
        <div class="card-header-custom">
          <div class="header-content">
            <div class="header-icon">
              <i class="fas fa-birthday-cake"></i>
            </div>
            <div class="header-text">
              <h5 class="card-title">Phân Bổ Độ Tuổi</h5>
              <p class="card-subtitle">Số lượng học sinh theo độ tuổi</p>
            </div>
          </div>
        </div>
        <div class="card-body">
          <canvas id="ageChart" height="300"></canvas>
        </div>
      </div>
    </div>

    <!-- Financial Statistics -->
    <div class="col-xl-6">
      <div class="management-card">
        <div class="card-header-custom">
          <div class="header-content">
            <div class="header-icon">
              <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="header-text">
              <h5 class="card-title">Thống Kê Tài Chính</h5>
              <p class="card-subtitle">Thu học phí theo tháng</p>
            </div>
          </div>
        </div>
        <div class="card-body">
          <canvas id="financialChart" height="300"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- More Charts Row 2 -->
  <div class="row mb-4">
    <!-- Health Statistics -->
    <div class="col-xl-6">
      <div class="management-card">
        <div class="card-header-custom">
          <div class="header-content">
            <div class="header-icon">
              <i class="fas fa-heartbeat"></i>
            </div>
            <div class="header-text">
              <h5 class="card-title">Thống Kê Sức Khỏe</h5>
              <p class="card-subtitle">Tình trạng sức khỏe học sinh</p>
            </div>
          </div>
        </div>
        <div class="card-body">
          <canvas id="healthChart" height="300"></canvas>
        </div>
      </div>
    </div>

    <!-- Attendance Heatmap -->
    <div class="col-xl-6">
      <div class="management-card">
        <div class="card-header-custom">
          <div class="header-content">
            <div class="header-icon">
              <i class="fas fa-calendar-check"></i>
            </div>
            <div class="header-text">
              <h5 class="card-title">Chuyên Cần Theo Lớp</h5>
              <p class="card-subtitle">Tỷ lệ đi học theo từng lớp</p>
            </div>
          </div>
        </div>
        <div class="card-body">
          <canvas id="attendanceChart" height="300"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- Financial Breakdown -->
  <div class="row mb-4">
    <div class="col-xl-12">
      <div class="management-card">
        <div class="card-header-custom">
          <div class="header-content">
            <div class="header-icon">
              <i class="fas fa-chart-pie"></i>
            </div>
            <div class="header-text">
              <h5 class="card-title">Phân Tích Tài Chính</h5>
              <p class="card-subtitle">Cơ cấu thu chi của trường</p>
            </div>
          </div>
        </div>
        <div class="card-body">
          <canvas id="financialBreakdownChart" height="100"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- Detailed Statistics -->
  <div class="row mb-4">
    <!-- Class Statistics Table -->
    <div class="col-xl-6">
      <div class="management-card">
        <div class="card-header-custom">
          <div class="header-content">
            <div class="header-icon">
              <i class="fas fa-table"></i>
            </div>
            <div class="header-text">
              <h5 class="card-title">Thống Kê Theo Lớp</h5>
              <p class="card-subtitle">Chi tiết từng lớp học</p>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="table-container">
            <table class="table table-modern">
              <thead>
                <tr>
                  <th>Lớp</th>
                  <th class="text-center">Học Sinh</th>
                  <th class="text-center">Giáo Viên</th>
                  <th class="text-center">Tỷ Lệ Đi Học</th>
                  <th class="text-center">Sức Khỏe TB</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(cls, index) in classStats" :key="index" class="table-row-hover">
                  <td>
                    <div class="class-badge-lite">{{ cls.name }}</div>
                  </td>
                  <td class="text-center">
                    <span class="stat-number">{{ cls.students }}</span>
                  </td>
                  <td class="text-center">
                    <span class="stat-number">{{ cls.teachers }}</span>
                  </td>
                  <td class="text-center">
                    <div class="attendance-progress">
                      <div class="progress-bar-mini" :style="{ width: cls.attendance + '%' }"></div>
                      <span class="attendance-text">{{ cls.attendance }}%</span>
                    </div>
                  </td>
                  <td class="text-center">
                    <span class="health-badge" :class="getHealthClass(cls.health)">
                      <i :class="getHealthIcon(cls.health)"></i>
                      {{ cls.health }}%
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Activities -->
    <div class="col-xl-6">
      <div class="management-card">
        <div class="card-header-custom">
          <div class="header-content">
            <div class="header-icon">
              <i class="fas fa-history"></i>
            </div>
            <div class="header-text">
              <h5 class="card-title">Hoạt Động Gần Đây</h5>
              <p class="card-subtitle">Timeline hoạt động hệ thống</p>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="activity-timeline">
            <div class="activity-item" v-for="activity in recentActivities" :key="activity.id">
              <div class="activity-icon" :class="activity.type">
                <i :class="activity.icon"></i>
              </div>
              <div class="activity-content">
                <h6 class="activity-title">{{ activity.title }}</h6>
                <p class="activity-description">{{ activity.description }}</p>
                <small class="activity-time">{{ activity.time }}</small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Export Section -->
  <div class="row">
    <div class="col-12">
      <div class="management-card">
        <div class="card-header-custom">
          <div class="header-content">
            <div class="header-icon">
              <i class="fas fa-download"></i>
            </div>
            <div class="header-text">
              <h5 class="card-title">Xuất Báo Cáo</h5>
              <p class="card-subtitle">Tải về các báo cáo thống kê</p>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="export-actions">
            <button class="btn btn-primary btn-modern me-2" @click="exportPDF">
              <i class="fas fa-file-pdf"></i>
              Báo Cáo PDF
            </button>
            <button class="btn btn-success btn-modern me-2" @click="exportExcel">
              <i class="fas fa-file-excel"></i>
              Báo Cáo Excel
            </button>
            <button class="btn btn-info btn-modern me-2" @click="exportCSV">
              <i class="fas fa-file-csv"></i>
              Xuất CSV
            </button>
            <button class="btn btn-warning btn-modern me-2" @click="exportCharts">
              <i class="fas fa-images"></i>
              Biểu Đồ PNG
            </button>
            <button class="btn btn-secondary btn-modern" @click="exportAll">
              <i class="fas fa-download"></i>
              Tổng Hợp Tất Cả
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import baseRequestAdmin from "../../../core/baseRequestAdmin";
import Chart from 'chart.js/auto';
import jsPDF from 'jspdf';
import 'jspdf-autotable';
import * as XLSX from 'xlsx';

export default {
  name: 'Statistics',
  data() {
    return {
      totalStudents: 324,
      totalTeachers: 28,
      totalClasses: 12,
      attendanceRate: 94.2,
      healthStatus: 'Bình thường',
      mealRate: 98,
      period: 'month',
      dateFrom: '',
      dateTo: '',
      classStats: [
        { name: 'Lớp Mầm', students: 25, teachers: 2, attendance: 96, health: 95 },
        { name: 'Lớp Chồi', students: 28, teachers: 2, attendance: 94, health: 93 },
        { name: 'Lớp Lá', students: 30, teachers: 2, attendance: 92, health: 91 },
        { name: 'Mẫu Giáo 1', students: 27, teachers: 2, attendance: 95, health: 94 },
        { name: 'Mẫu Giáo 2', students: 29, teachers: 2, attendance: 93, health: 92 },
      ],
      recentActivities: [
        {
          id: 1,
          type: 'success',
          icon: 'fas fa-user-plus',
          title: 'Thêm học sinh mới',
          description: 'Nguyễn Văn A đã được thêm vào lớp Mầm',
          time: '2 giờ trước'
        },
        {
          id: 2,
          type: 'info',
          icon: 'fas fa-calendar-alt',
          title: 'Cập nhật lịch học',
          description: 'Lịch học tuần mới đã được cập nhật',
          time: '4 giờ trước'
        },
        {
          id: 3,
          type: 'warning',
          icon: 'fas fa-dollar-sign',
          title: 'Thu học phí',
          description: 'Đã thu học phí tháng 12 cho 45 học sinh',
          time: '6 giờ trước'
        },
        {
          id: 4,
          type: 'primary',
          icon: 'fas fa-file-alt',
          title: 'Báo cáo tháng',
          description: 'Báo cáo thống kê tháng 11 đã được xuất',
          time: '1 ngày trước'
        }
      ]
    };
  },

  mounted() {
    this.loadStatisticsData();
    this.$nextTick(() => {
      this.initAllCharts();
    });
  },

  methods: {
    loadStatisticsData() {
      baseRequestAdmin
        .get("admin/thong-ke/data")
        .then((res) => {
          if (res.data.status) {
            this.totalStudents = res.data.data.tong_hoc_sinh || 324;
            this.totalTeachers = res.data.data.tong_giao_vien || 28;
            this.totalClasses = res.data.data.tong_lop || 12;
            this.attendanceRate = res.data.data.ti_le_di_hoc || 94.2;
            this.healthStatus = res.data.data.tinh_trang_suc_khoe || 'Bình thường';
            this.mealRate = res.data.data.ti_le_dinh_duong || 98;
          }
        })
        .catch(() => {
          console.log("Using default statistics data");
        });
    },

    initAllCharts() {
      this.initComparisonChart();
      this.initStudentGrowthChart();
      this.initGenderChart();
      this.initAgeChart();
      this.initFinancialChart();
      this.initHealthChart();
      this.initAttendanceChart();
      this.initFinancialBreakdownChart();
    },

    updateCharts() {
      this.initAllCharts();
    },

    resetFilters() {
      this.period = 'month';
      this.dateFrom = '';
      this.dateTo = '';
      this.updateCharts();
    },

    initComparisonChart() {
      const ctx = document.getElementById('comparisonChart');
      if (!ctx) return;

      const labels = ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6'];
      new Chart(ctx, {
        type: 'line',
        data: {
          labels: labels,
          datasets: [
            {
              label: 'Học kỳ I',
              data: [280, 285, 290, 295, 300, 305],
              borderColor: 'rgb(102, 126, 234)',
              backgroundColor: 'rgba(102, 126, 234, 0.1)',
              tension: 0.4,
              fill: true
            },
            {
              label: 'Học kỳ II',
              data: [310, 315, 318, 320, 322, 324],
              borderColor: 'rgb(75, 192, 192)',
              backgroundColor: 'rgba(75, 192, 192, 0.1)',
              tension: 0.4,
              fill: true
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          interaction: {
            mode: 'index',
            intersect: false
          },
          scales: {
            y: {
              beginAtZero: false,
              min: 270
            }
          }
        }
      });
    },

    initStudentGrowthChart() {
      const ctx = document.getElementById('studentGrowthChart');
      if (!ctx) return;

      const labels = ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'];
      const data = [280, 285, 290, 295, 300, 305, 310, 315, 318, 320, 322, 324];

      new Chart(ctx, {
        type: 'line',
        data: {
          labels: labels,
          datasets: [{
            label: 'Học sinh',
            data: data,
            borderColor: 'rgb(102, 126, 234)',
            backgroundColor: 'rgba(102, 126, 234, 0.1)',
            tension: 0.4,
            fill: true,
            borderWidth: 3
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false
            }
          },
          scales: {
            y: {
              beginAtZero: false,
              min: 270
            }
          }
        }
      });
    },

    initGenderChart() {
      const ctx = document.getElementById('genderChart');
      if (!ctx) return;

      new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: ['Nam', 'Nữ'],
          datasets: [{
            data: [52, 48],
            backgroundColor: [
              'rgba(54, 162, 235, 0.8)',
              'rgba(255, 99, 132, 0.8)'
            ],
            borderWidth: 2
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'bottom'
            }
          }
        }
      });
    },

    initAgeChart() {
      const ctx = document.getElementById('ageChart');
      if (!ctx) return;

      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['3 tuổi', '4 tuổi', '5 tuổi', '6 tuổi'],
          datasets: [{
            label: 'Số học sinh',
            data: [85, 98, 78, 63],
            backgroundColor: [
              'rgba(255, 99, 132, 0.8)',
              'rgba(54, 162, 235, 0.8)',
              'rgba(255, 205, 86, 0.8)',
              'rgba(75, 192, 192, 0.8)'
            ],
            borderWidth: 2
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false
            }
          },
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    },

    initFinancialChart() {
      const ctx = document.getElementById('financialChart');
      if (!ctx) return;

      const data = [95, 98, 102, 105, 110, 115, 118, 120, 122, 125, 128, 124.5];

      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
          datasets: [{
            label: 'Thu học phí (triệu VNĐ)',
            data: data,
            backgroundColor: 'rgba(75, 192, 192, 0.8)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 2
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false
            }
          },
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    },

    initHealthChart() {
      const ctx = document.getElementById('healthChart');
      if (!ctx) return;

      new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: ['Bình thường', 'Có triệu chứng nhẹ', 'Cần theo dõi', 'Khác'],
          datasets: [{
            data: [89, 8, 2, 1],
            backgroundColor: [
              'rgba(75, 192, 192, 0.8)',
              'rgba(255, 206, 86, 0.8)',
              'rgba(255, 99, 132, 0.8)',
              'rgba(153, 102, 255, 0.8)'
            ],
            borderWidth: 2
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'bottom'
            }
          }
        }
      });
    },

    initAttendanceChart() {
      const ctx = document.getElementById('attendanceChart');
      if (!ctx) return;

      new Chart(ctx, {
        type: 'radar',
        data: {
          labels: ['Lớp Mầm', 'Lớp Chồi', 'Lớp Lá', 'Mẫu Giáo 1', 'Mẫu Giáo 2'],
          datasets: [{
            label: 'Tỷ lệ đi học',
            data: [96, 94, 92, 95, 93],
            backgroundColor: 'rgba(102, 126, 234, 0.2)',
            borderColor: 'rgb(102, 126, 234)',
            borderWidth: 2
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            r: {
              beginAtZero: false,
              min: 85,
              max: 100
            }
          }
        }
      });
    },

    initFinancialBreakdownChart() {
      const ctx = document.getElementById('financialBreakdownChart');
      if (!ctx) return;

      new Chart(ctx, {
        type: 'pie',
        data: {
          labels: ['Học phí', 'Lương giáo viên', 'Cơ sở vật chất', 'Hoạt động', 'Khác'],
          datasets: [{
            data: [60, 25, 8, 5, 2],
            backgroundColor: [
              'rgba(75, 192, 192, 0.8)',
              'rgba(54, 162, 235, 0.8)',
              'rgba(255, 205, 86, 0.8)',
              'rgba(255, 99, 132, 0.8)',
              'rgba(153, 102, 255, 0.8)'
            ],
            borderWidth: 2
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'bottom'
            }
          }
        }
      });
    },

    getHealthClass(health) {
      if (health >= 90) return 'health-excellent';
      if (health >= 80) return 'health-good';
      if (health >= 70) return 'health-fair';
      return 'health-poor';
    },

    getHealthIcon(health) {
      if (health >= 90) return 'fas fa-check-circle text-success';
      if (health >= 80) return 'fas fa-check text-success';
      if (health >= 70) return 'fas fa-exclamation-triangle text-warning';
      return 'fas fa-times-circle text-danger';
    },

    exportPDF() {
      try {
        const doc = new jsPDF();

        doc.setFontSize(20);
        doc.setTextColor(102, 126, 234);
        doc.text('BÁO CÁO THỐNG KÊ', 105, 20, { align: 'center' });

        doc.setFontSize(12);
        doc.setTextColor(44, 62, 80);
        doc.text(`Ngày xuất: ${new Date().toLocaleDateString('vi-VN')}`, 20, 35);

        doc.setFontSize(14);
        doc.text('Tổng quan hệ thống:', 20, 50);

        doc.setFontSize(11);
        doc.text(`- Tổng học sinh: ${this.totalStudents}`, 20, 60);
        doc.text(`- Tổng giáo viên: ${this.totalTeachers}`, 20, 67);
        doc.text(`- Lớp học: ${this.totalClasses}`, 20, 74);
        doc.text(`- Tỷ lệ đi học: ${this.attendanceRate}%`, 20, 81);
        doc.text(`- Tỷ lệ dinh dưỡng: ${this.mealRate}%`, 20, 88);

        doc.autoTable({
          startY: 100,
          head: [['#', 'Lớp', 'Học sinh', 'Giáo viên', 'Đi học', 'Sức khỏe']],
          body: this.classStats.map((cls, index) => [
            index + 1,
            cls.name,
            cls.students,
            cls.teachers,
            cls.attendance + '%',
            cls.health + '%'
          ]),
          styles: { fontSize: 9 },
          headStyles: { fillColor: [102, 126, 234], textColor: 255 }
        });

        const filename = `bao-cao-thong-ke-${new Date().toISOString().split('T')[0]}.pdf`;
        doc.save(filename);
        this.$toast.success('Đã xuất PDF thành công!');
      } catch (err) {
        this.$toast.error('Lỗi khi xuất PDF: ' + err.message);
      }
    },

    exportExcel() {
      try {
        const classData = this.classStats.map((cls, index) => ({
          'STT': index + 1,
          'Lớp': cls.name,
          'Số học sinh': cls.students,
          'Số giáo viên': cls.teachers,
          'Tỷ lệ đi học (%)': cls.attendance,
          'Tỷ lệ sức khỏe (%)': cls.health
        }));

        const summaryData = [{
          'Tổng học sinh': this.totalStudents,
          'Tổng giáo viên': this.totalTeachers,
          'Lớp học': this.totalClasses,
          'Tỷ lệ đi học (%)': this.attendanceRate,
          'Tỷ lệ dinh dưỡng (%)': this.mealRate
        }];

        const wb = XLSX.utils.book_new();
        const summaryWs = XLSX.utils.json_to_sheet(summaryData);
        const classWs = XLSX.utils.json_to_sheet(classData);

        XLSX.utils.book_append_sheet(wb, summaryWs, 'Tổng quan');
        XLSX.utils.book_append_sheet(wb, classWs, 'Thống kê lớp');

        const filename = `bao-cao-thong-ke-${new Date().toISOString().split('T')[0]}.xlsx`;
        XLSX.writeFile(wb, filename);
        this.$toast.success('Đã xuất Excel thành công!');
      } catch (err) {
        this.$toast.error('Lỗi khi xuất Excel: ' + err.message);
      }
    },

    exportCSV() {
      try {
        const data = this.classStats.map((cls, index) => ({
          'STT': index + 1,
          'Lớp': cls.name,
          'Số học sinh': cls.students,
          'Tỷ lệ đi học (%)': cls.attendance
        }));

        const ws = XLSX.utils.json_to_sheet(data);
        const csv = XLSX.utils.sheet_to_csv(ws);

        const blob = new Blob(['\uFEFF' + csv], { type: 'text/csv;charset=utf-8;' });
        const filename = `bao-cao-thong-ke-${new Date().toISOString().split('T')[0]}.csv`;

        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = filename;
        link.click();

        this.$toast.success('Đã xuất CSV thành công!');
      } catch (err) {
        this.$toast.error('Lỗi khi xuất CSV: ' + err.message);
      }
    },

    exportCharts() {
      this.$toast.info("Tính năng xuất biểu đồ đang phát triển");
    },

    exportAll() {
      this.exportPDF();
      setTimeout(() => this.exportExcel(), 1000);
      setTimeout(() => this.exportCSV(), 2000);
    }
  }
};
</script>

<style lang="scss">
@use "./style.scss";
</style>