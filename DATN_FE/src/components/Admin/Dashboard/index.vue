<template>
  <div class="container-fluid">
    <!-- Welcome Section -->
    <div class="welcome-section text-center">
      <div class="school-banner">
        <h2 class="welcome-title">CHÀO MỪNG ĐẾN VỚI HỆ THỐNG QUẢN LÝ</h2>

        <p class="welcome-subtitle">
          Nơi ươm mầm tương lai - Vì sự phát triển toàn diện của trẻ
        </p>
        <div class="welcome-info">
          <span class="badge me-2">
            <i class="bx bx-calendar me-1"></i>{{ currentDate }}
          </span>
          <span class="badge me-2">
            <i class="bx bx-time me-1"></i>{{ currentTime }}
          </span>
          <span class="badge">
            <i class="bx bx-user me-1"></i>Xin chào, Admin
          </span>
        </div>
      </div>
    </div>

    <div class="form-item row mb-4">
      <div class="col-xl-3 col-md-6">
        <div class="card stat-card stat-primary" @click="navigateToStudents">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="stat-icon">
                <i class="bx bx-user-plus"></i>
              </div>
              <div class="stat-content">
                <h3 class="stat-number">324</h3>
                <p class="stat-label">Tổng học sinh</p>
                <div class="stat-change positive">
                  <i class="bx bx-up-arrow-alt"></i> +12 (3.8%)
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="card stat-card stat-success">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="stat-icon">
                <i class="color-icon bx bx-chalkboard"></i>
              </div>
              <div class="stat-content">
                <h3 class="stat-number">28</h3>
                <p class="stat-label">Giáo viên</p>
                <div class="stat-change positive">
                  <i class="bx bx-up-arrow-alt"></i> +2 (7.7%)
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="card stat-card stat-warning">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="stat-icon">
                <i class="bx bx-home"></i>
              </div>
              <div class="stat-content">
                <h3 class="stat-number">12</h3>
                <p class="stat-label">Lớp học</p>
                <div class="stat-change positive">
                  <i class="bx bx-up-arrow-alt"></i> +1 (9.1%)
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="card stat-card stat-info">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="stat-icon">
                <i class="bx bx-dollar"></i>
              </div>
              <div class="stat-content">
                <h3 class="stat-number">94.2%</h3>
                <p class="stat-label">Tỷ lệ đi học</p>
                <div class="stat-change positive">
                  <i class="bx bx-up-arrow-alt"></i> +2.1%
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mb-4">
      <div class="col-xl-4">
        <div class="card dashboard-card">
          <div class="card-header">
            <h5 class="card-title">
              <i class="bx bx-pie-chart me-2"></i>Phân bố lớp học
            </h5>
          </div>
          <div class="card-body">
            <div
              class="chart-container"
              style="height: 350px; position: relative"
            >
              <v-chart
                class="chart"
                :option="option"
                autoresize
                style="width: 100%; height: 100%"
              />
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-8">
        <div class="card dashboard-card">
          <div class="card-header">
            <h5 class="card-title">
              <i class="bx bx-trending-up me-2"></i>Xu hướng số lượng học sinh
              theo tháng
            </h5>
          </div>
          <div class="card-body">
            <div
              class="chart-container"
              style="height: 350px; position: relative"
            >
              <v-chart
                class="chart"
                :option="trendOption"
                autoresize
                style="width: 100%; height: 100%"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mb-4">
      <div class="col-xl-4">
        <div class="card dashboard-card h-100">
          <div class="card-header">
            <h5 class="card-title">
              <i class="bx bx-user me-2"></i>Tỷ lệ giới tính
            </h5>
          </div>
          <div class="card-body">
            <div
              class="chart-container"
              style="height: 300px; position: relative"
            >
              <v-chart
                class="chart"
                :option="genderOption"
                autoresize
                style="width: 100%; height: 100%"
              />
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-8">
        <div class="card dashboard-card h-100">
          <div class="card-header">
            <h5 class="card-title">
              <i class="bx bx-dollar me-2"></i>Báo cáo thu chi theo tháng
            </h5>
          </div>
          <div class="card-body">
            <div
              class="chart-container"
              style="height: 300px; position: relative"
            >
              <v-chart
                class="chart"
                :option="revenueOption"
                autoresize
                style="width: 100%; height: 100%"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mb-4">
      <div class="col-xl-4">
        <div class="card dashboard-card h-100">
          <div class="card-header">
            <h5 class="card-title">
              <i class="bx bx-check-circle me-2"></i>Điểm danh hôm nay
            </h5>
          </div>
          <div class="card-body d-flex flex-column">
            <div class="attendance-stats flex-grow-1">
              <div class="attendance-item">
                <div class="attendance-icon present">
                  <i class="bx bx-check"></i>
                </div>
                <div class="attendance-info">
                  <h4 class="attendance-number">305</h4>
                  <p class="attendance-label">Có mặt</p>
                </div>
              </div>
              <div class="attendance-item">
                <div class="attendance-icon absent">
                  <i class="bx bx-x"></i>
                </div>
                <div class="attendance-info">
                  <h4 class="attendance-number">19</h4>
                  <p class="attendance-label">Vắng mặt</p>
                </div>
              </div>
              <div class="attendance-item">
                <div class="attendance-icon late">
                  <i class="bx bx-time"></i>
                </div>
                <div class="attendance-info">
                  <h4 class="attendance-number">8</h4>
                  <p class="attendance-label">Đi muộn</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-4">
        <div class="card dashboard-card h-100">
          <div class="card-header">
            <h5 class="card-title">
              <i class="bx bx-bell me-2"></i>Thông báo & Cảnh báo
            </h5>
          </div>
          <div class="card-body">
            <div class="notifications-list">
              <div class="notification-item alert alert-warning">
                <div class="notification-icon">
                  <i class="bx bx-exclamation-triangle"></i>
                </div>
                <div class="notification-content">
                  <h6>Học phí tháng 12</h6>
                  <p>15 học sinh chưa đóng học phí, hạn cuối: 20/12</p>
                </div>
              </div>
              <div class="notification-item alert alert-info">
                <div class="notification-icon">
                  <i class="bx bx-info-circle"></i>
                </div>
                <div class="notification-content">
                  <h6>Lễ tổng kết năm học</h6>
                  <p>Lễ tổng kết sẽ diễn ra vào ngày 25/12/2024</p>
                </div>
              </div>
              <div class="notification-item alert alert-success">
                <div class="notification-icon">
                  <i class="bx bx-check-circle"></i>
                </div>
                <div class="notification-content">
                  <h6>Kiểm tra sức khỏe</h6>
                  <p>Hoàn thành kiểm tra sức khỏe cho 324 học sinh</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-4">
        <div class="card dashboard-card h-100">
          <div class="card-header">
            <h5 class="card-title">
              <i class="bx bx-bolt me-2"></i>Thao tác nhanh
            </h5>
          </div>
          <div class="card-body d-flex flex-column">
            <div
              class="quick-actions flex-grow-1 d-flex flex-column justify-content-center"
            >
              <button
                class="btn btn-outline-primary btn-lg w-100 mb-3"
                @click="openStudentDialog"
              >
                <i class="bx bx-user-plus me-2"></i>Thêm học sinh mới
              </button>
              <button class="btn btn-outline-secondary btn-lg w-100 mb-3">
                <i class="bx bx-calendar me-2"></i>Tạo lịch học tuần
              </button>
              <button class="btn btn-outline-secondary btn-lg w-100 mb-3">
                <i class="bx bx-file me-2"></i>Tạo báo cáo hôm nay
              </button>
              <button class="btn btn-outline-secondary btn-lg w-100">
                <i class="bx bx-bell me-2"></i>Tạo thông báo mới
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mb-4">
      <div class="col-xl-6">
        <div class="card dashboard-card">
          <div class="card-header">
            <h5 class="card-title">
              <i class="bx bx-bell me-2"></i>Thông báo & Cảnh báo
            </h5>
          </div>
          <div class="card-body">
            <div class="notifications-list">
              <div class="notification-item alert alert-warning">
                <div class="notification-icon">
                  <i class="bx bx-exclamation-triangle"></i>
                </div>
                <div class="notification-content">
                  <h6>Học phí tháng 12</h6>
                  <p>15 học sinh chưa đóng học phí, hạn cuối: 20/12</p>
                </div>
              </div>
              <div class="notification-item alert alert-info">
                <div class="notification-icon">
                  <i class="bx bx-info-circle"></i>
                </div>
                <div class="notification-content">
                  <h6>Lễ tổng kết năm học</h6>
                  <p>Lễ tổng kết sẽ diễn ra vào ngày 25/12/2024</p>
                </div>
              </div>
              <div class="notification-item alert alert-success">
                <div class="notification-icon">
                  <i class="bx bx-check-circle"></i>
                </div>
                <div class="notification-content">
                  <h6>Kiểm tra sức khỏe</h6>
                  <p>Hoàn thành kiểm tra sức khỏe cho 324 học sinh</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mb-4">
      <div class="col-12">
        <div class="card dashboard-card">
          <div class="card-body">
            <div class="row text-center">
              <div class="col-md-3">
                <div class="footer-stat">
                  <i class="bx bx-heart text-danger"></i>
                  <h4>98.5%</h4>
                  <p>Phụ huynh hài lòng</p>
                </div>
              </div>
              <div class="col-md-3">
                <div class="footer-stat">
                  <i class="bx bx-award text-warning"></i>
                  <h4>15</h4>
                  <p>Giải thưởng năm</p>
                </div>
              </div>
              <div class="col-md-3">
                <div class="footer-stat">
                  <i class="bx bx-calendar-check text-success"></i>
                  <h4>365</h4>
                  <p>Ngày hoạt động</p>
                </div>
              </div>
              <div class="col-md-3">
                <div class="footer-stat">
                  <i class="bx bx-star text-primary"></i>
                  <h4>4.9/5</h4>
                  <p>Đánh giá trung bình</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mb-4">
      <div class="col-12">
        <div class="card motto-card">
          <div class="card-body text-center">
            <h3 class="motto-title">
              <i class="bx bx-quote-left me-2"></i>
              "Mầm non Laura - Nơi trẻ em được yêu thương, học hỏi và phát triển
              toàn diện"
              <i class="bx bx-quote-right ms-2"></i>
            </h3>
            <p class="motto-subtitle">
              Vì tương lai tươi sáng của những mầm non Việt Nam
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <StudentDialog
    :isVisible="showStudentDialog"
    @close="closeStudentDialog"
    @submit="handleStudentSubmit"
  />
</template>

<script>
import { ref, onMounted, onUnmounted } from "vue";
import { useRouter } from "vue-router";
import StudentDialog from "./Dialog.vue";
import { use } from "echarts/core";
import { CanvasRenderer } from "echarts/renderers";
import { PieChart, BarChart, LineChart } from "echarts/charts";
import {
  TitleComponent,
  TooltipComponent,
  LegendComponent,
  ToolboxComponent,
  GridComponent,
} from "echarts/components";
import VChart from "vue-echarts";
use([
  CanvasRenderer,
  PieChart,
  BarChart,
  LineChart,
  TitleComponent,
  TooltipComponent,
  LegendComponent,
  ToolboxComponent,
  GridComponent,
]);

export default {
  name: "Dashboard",
  components: {
    StudentDialog,
    VChart,
  },

  setup() {
    const currentDate = ref("");
    const currentTime = ref("");
    let timeInterval = null;
    const router = useRouter();
    const showStudentDialog = ref(false);

    const openStudentDialog = () => {
      showStudentDialog.value = true;
    };

    const closeStudentDialog = () => {
      showStudentDialog.value = false;
    };

    const handleStudentSubmit = (data) => {
      console.log("Dữ liệu học sinh:", data);
      closeStudentDialog();
    };

    const updateDateTime = () => {
      const now = new Date();
      currentDate.value = now.toLocaleDateString("vi-VN", {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric",
      });
      currentTime.value = now.toLocaleTimeString("vi-VN", {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
      });
    };
    const navigateToStudents = () => {
      router.push("/admin/student-stats"); // Cập nhật đường dẫn
    };
    onMounted(() => {
      updateDateTime();
      timeInterval = setInterval(updateDateTime, 1000);

      // Student Overview Chart
      const studentOverviewCtx = document.getElementById(
        "studentOverviewChart"
      );
      if (studentOverviewCtx) {
        new Chart(studentOverviewCtx, {
          type: "line",
          data: {
            labels: [
              "T1",
              "T2",
              "T3",
              "T4",
              "T5",
              "T6",
              "T7",
              "T8",
              "T9",
              "T10",
              "T11",
              "T12",
            ],
            datasets: [
              {
                label: "Học sinh",
                data: [
                  280, 285, 290, 295, 300, 305, 310, 315, 318, 320, 322, 324,
                ],
                borderColor: "rgb(75, 192, 192)",
                backgroundColor: "rgba(75, 192, 192, 0.1)",
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
                display: false,
              },
            },
            scales: {
              y: {
                beginAtZero: false,
                min: 270,
              },
            },
          },
        });
      }
    });

    onUnmounted(() => {
      if (timeInterval) {
        clearInterval(timeInterval);
      }
    });

    return {
      currentDate,
      currentTime,
      showStudentDialog,
      navigateToStudents,
      openStudentDialog,
      closeStudentDialog,
      handleStudentSubmit,
      option: {
        title: {
          text: "Phân bố lớp học",
          subtext: "Dữ liệu thống kê",
          left: "center",
          textStyle: {
            fontSize: 16,
            fontWeight: "bold",
          },
        },
        tooltip: {
          trigger: "item",
          formatter: "{a} <br/>{b}: {c} ({d}%)",
        },
        legend: {
          orient: "vertical",
          left: "left",
          textStyle: {
            fontSize: 12,
          },
        },
        series: [
          {
            name: "Lớp học",
            type: "pie",
            radius: ["40%", "70%"],
            center: ["50%", "60%"],
            data: [
              { value: 4, name: "Lớp Mầm", itemStyle: { color: "#5470c6" } },
              { value: 4, name: "Lớp Chồi", itemStyle: { color: "#91cc75" } },
              { value: 4, name: "Lớp Lá", itemStyle: { color: "#fac858" } },
            ],
            emphasis: {
              itemStyle: {
                shadowBlur: 10,
                shadowOffsetX: 0,
                shadowColor: "rgba(0, 0, 0, 0.5)",
              },
            },
          },
        ],
      },
      trendOption: {
        tooltip: {
          trigger: "axis",
          axisPointer: {
            type: "cross",
            crossStyle: { color: "#999" },
          },
        },
        toolbox: {
          feature: {
            dataView: { show: true, readOnly: false },
            magicType: { show: true, type: ["line", "bar"] },
            restore: { show: true },
            saveAsImage: { show: true },
          },
        },
        legend: {
          data: ["Số lượng học sinh", "Tăng trưởng (%)"],
        },
        xAxis: [
          {
            type: "category",
            data: [
              "Th1",
              "Th2",
              "Th3",
              "Th4",
              "Th5",
              "Th6",
              "Th7",
              "Th8",
              "Th9",
              "Th10",
              "Th11",
              "Th12",
            ],
            axisPointer: { type: "shadow" },
          },
        ],
        yAxis: [
          {
            type: "value",
            name: "Số lượng học sinh",
            min: 0,
            max: 500,
            interval: 50,
            axisLabel: { formatter: "{value} HS" },
          },
          {
            type: "value",
            name: "Tăng trưởng",
            min: -10,
            max: 30,
            interval: 5,
            axisLabel: { formatter: "{value} %" },
          },
        ],
        series: [
          {
            name: "Số lượng học sinh",
            type: "bar",
            tooltip: {
              valueFormatter: (value) => value + " HS",
            },
            data: [120, 132, 101, 134, 90, 230, 210, 250, 280, 300, 320, 400],
          },
          {
            name: "Tăng trưởng (%)",
            type: "line",
            yAxisIndex: 1,
            tooltip: {
              valueFormatter: (value) => value + " %",
            },
            data: [5, 8, 3, 6, -2, 10, 8, 12, 15, 5, 3, 7],
          },
        ],
      },
      genderOption: {
        tooltip: {
          trigger: "item",
          formatter: "{b}: {c} ({d}%)",
        },
        legend: {
          top: "5%",
          left: "center",
        },
        series: [
          {
            name: "Giới tính",
            type: "pie",
            radius: ["40%", "70%"],
            center: ["50%", "60%"],
            startAngle: 180,
            endAngle: 360,
            data: [
              { value: 320, name: "Nam", itemStyle: { color: "#5470c6" } },
              { value: 280, name: "Nữ", itemStyle: { color: "#91cc75" } },
            ],
            label: {
              show: true,
              formatter: "{b}: {d}%",
            },
            emphasis: {
              itemStyle: {
                shadowBlur: 10,
                shadowOffsetX: 0,
                shadowColor: "rgba(0, 0, 0, 0.5)",
              },
            },
          },
        ],
      },
      revenueOption: {
        tooltip: {
          trigger: "axis",
          axisPointer: { type: "cross" },
        },
        legend: {
          data: ["Thu", "Chi", "Dòng tiền ròng"],
        },
        xAxis: [
          {
            type: "category",
            data: [
              "T1",
              "T2",
              "T3",
              "T4",
              "T5",
              "T6",
              "T7",
              "T8",
              "T9",
              "T10",
              "T11",
              "T12",
            ],
          },
        ],
        yAxis: [
          {
            type: "value",
            name: "Số tiền (VNĐ)",
            axisLabel: { formatter: "{value} triệu" },
          },
        ],
        series: [
          {
            name: "Thu",
            type: "bar",
            data: [120, 200, 150, 80, 70, 110, 130, 200, 170, 250, 300, 280],
            itemStyle: { color: "#5470c6" },
          },
          {
            name: "Chi",
            type: "bar",
            data: [100, 180, 120, 60, 90, 100, 110, 150, 160, 200, 260, 240],
            itemStyle: { color: "#91cc75" },
          },
          {
            name: "Dòng tiền ròng",
            type: "line",
            data: [20, 20, 30, 20, -20, 10, 20, 50, 10, 50, 40, 40],
            itemStyle: { color: "#fac858" },
            lineStyle: { width: 3 },
          },
        ],
      },
    };
  },
};
</script>

<style lang="scss">
@use "./style.scss";
.chart {
  width: 100% !important;
  height: 350px !important;
}

.chart-container {
  position: relative;
  width: 100%;
  height: 350px;

  .chart {
    position: absolute;
    top: 0;
    left: 0;
    width: 100% !important;
    height: 100% !important;
  }
}
</style>
