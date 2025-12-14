<template>
  <div class="finance-dashboard">
    <!-- Modern Header Section -->
    <div class="finance-header">
      <div class="header-content">
        <div class="header-left">
          <h1 class="page-title">
            <i class="bx bx-wallet me-2"></i>
            Quản lý Tài chính
          </h1>
          <p class="page-subtitle">Theo dõi và quản lý tài chính trường mầm non</p>
        </div>
        <div class="header-right">
          <div class="breadcrumb-nav">
            <span class="breadcrumb-item">Admin</span>
            <i class="bx bx-chevron-right"></i>
            <span class="breadcrumb-item active">Tài chính</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Modern Stats Cards -->
    <div class="stats-grid">
      <div class="stat-card revenue-card">
        <div class="stat-icon">
          <i class="bx bx-trending-up"></i>
        </div>
        <div class="stat-content">
          <h3 class="stat-value">124.5M</h3>
          <p class="stat-label">Tổng thu tháng</p>
          <div class="stat-change positive">
            <i class="bx bx-up-arrow-alt"></i>
            <span>+12.5%</span>
          </div>
        </div>
      </div>

      <div class="stat-card expense-card">
        <div class="stat-icon">
          <i class="bx bx-trending-down"></i>
        </div>
        <div class="stat-content">
          <h3 class="stat-value">60.8M</h3>
          <p class="stat-label">Tổng chi tháng</p>
          <div class="stat-change negative">
            <i class="bx bx-down-arrow-alt"></i>
            <span>-5.2%</span>
          </div>
        </div>
      </div>

      <div class="stat-card profit-card">
        <div class="stat-icon">
          <i class="bx bx-dollar"></i>
        </div>
        <div class="stat-content">
          <h3 class="stat-value">63.7M</h3>
          <p class="stat-label">Lợi nhuận</p>
          <div class="stat-change positive">
            <i class="bx bx-up-arrow-alt"></i>
            <span>+18.3%</span>
          </div>
        </div>
      </div>

      <div class="stat-card students-card">
        <div class="stat-icon">
          <i class="bx bx-user"></i>
        </div>
        <div class="stat-content">
          <h3 class="stat-value">156</h3>
          <p class="stat-label">Học sinh đóng phí</p>
          <div class="stat-change neutral">
            <i class="bx bx-minus"></i>
            <span>0%</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Charts Section -->
    <div class="charts-section">
      <div class="chart-container main-chart">
        <div class="chart-header">
          <h3 class="chart-title">
            <i class="bx bx-line-chart me-2"></i>
            Biểu đồ thu chi theo tháng
          </h3>
          <div class="chart-controls">
            <select class="period-select">
              <option value="12">12 tháng</option>
              <option value="6">6 tháng</option>
              <option value="3">3 tháng</option>
            </select>
          </div>
        </div>
        <div class="chart-body">
          <canvas id="revenueChart"></canvas>
        </div>
      </div>

      <div class="chart-container pie-chart">
        <div class="chart-header">
          <h3 class="chart-title">
            <i class="bx bx-pie-chart me-2"></i>
            Phân bổ chi phí
          </h3>
        </div>
        <div class="chart-body">
          <canvas id="expenseChart"></canvas>
        </div>
      </div>
    </div>

    <!-- Additional Charts Section -->
    <div class="additional-charts">
      <div class="chart-container bar-chart">
        <div class="chart-header">
          <h3 class="chart-title">
            <i class="bx bx-bar-chart-alt-2 me-2"></i>
            Thu nhập theo lớp học
          </h3>
        </div>
        <div class="chart-body">
          <canvas id="classRevenueChart"></canvas>
        </div>
      </div>

      <div class="chart-container area-chart">
        <div class="chart-header">
          <h3 class="chart-title">
            <i class="bx bx-trending-up me-2"></i>
            Xu hướng tăng trưởng
          </h3>
        </div>
        <div class="chart-body">
          <canvas id="growthChart"></canvas>
        </div>
      </div>

      <div class="chart-container doughnut-chart">
        <div class="chart-header">
          <h3 class="chart-title">
            <i class="bx bx-doughnut-chart me-2"></i>
            Tỷ lệ học sinh đóng phí
          </h3>
        </div>
        <div class="chart-body">
          <canvas id="paymentStatusChart"></canvas>
        </div>
      </div>
    </div>

    <!-- Statistics Cards -->
    <div class="statistics-section">
      <h3 class="section-title">
        <i class="bx bx-stats me-2"></i>
        Thống kê chi tiết
      </h3>

      <div class="stats-cards-grid">
        <div class="stat-card-small">
          <div class="stat-icon-small">
            <i class="bx bx-calendar"></i>
          </div>
          <div class="stat-info">
            <h4>Tháng này</h4>
            <p class="stat-number">124.5M <span class="stat-trend positive">+12.5%</span></p>            
          </div>
        </div>

        <div class="stat-card-small">
          <div class="stat-icon-small">
            <i class="bx bx-calendar-check"></i>
          </div>
          <div class="stat-info">
            <h4>Tháng trước</h4>
            <p class="stat-number">110.8M <span class="stat-trend positive">+8.2%</span></p>            
          </div>
        </div>

        <div class="stat-card-small">
          <div class="stat-icon-small">
            <i class="bx bx-trophy"></i>
          </div>
          <div class="stat-info">
            <h4>Tháng cao nhất</h4>
            <p class="stat-number">135.2M <span class="stat-trend neutral">T3/2024</span></p>            
          </div>
        </div>

        <div class="stat-card-small">
          <div class="stat-icon-small">
            <i class="bx bx-trending-up"></i>
          </div>
          <div class="stat-info">
            <h4>Tăng trưởng TB</h4>
            <p class="stat-number">15.3% <span class="stat-trend positive">/tháng</span></p>            
          </div>
        </div>

        <div class="stat-card-small">
          <div class="stat-icon-small">
            <i class="bx bx-user-check"></i>
          </div>
          <div class="stat-info">
            <h4>Tỷ lệ đóng phí</h4>
            <p class="stat-number">94.2% <span class="stat-trend positive">+2.1%</span></p>            
          </div>
        </div>

        <div class="stat-card-small">
          <div class="stat-icon-small">
            <i class="bx bx-time"></i>
          </div>
          <div class="stat-info">
            <h4>Trung bình/HS</h4>
            <p class="stat-number">2.8M <span class="stat-trend positive">+0.3M</span></p>            
          </div>
        </div>
      </div>
    </div>

    <!-- Financial Details -->
    <div class="details-section">
      <div class="detail-card">
        <div class="card-header">
          <h3 class="card-title">
            <i class="bx bx-receipt me-2"></i>
            Chi tiết thu học phí
          </h3>
          <button class="btn-icon">
            <i class="bx bx-dots-vertical-rounded"></i>
          </button>
        </div>
        <div class="card-body">
          <div class="table-container">
            <table class="modern-table">
              <thead>
                <tr>
                  <th>Lớp</th>
                  <th>Số học sinh</th>
                  <th>Học phí/lớp</th>
                  <th>Tổng thu</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <div class="class-info">
                      <div class="class-icon">🌱</div>
                      <span>Lớp Mầm</span>
                    </div>
                  </td>
                  <td><span class="badge-count">25</span></td>
                  <td><span class="amount">2.5M</span></td>
                  <td><span class="total-amount success">62.5M</span></td>
                </tr>
                <tr>
                  <td>
                    <div class="class-info">
                      <div class="class-icon">🌿</div>
                      <span>Lớp Chồi</span>
                    </div>
                  </td>
                  <td><span class="badge-count">28</span></td>
                  <td><span class="amount">2.8M</span></td>
                  <td><span class="total-amount success">78.4M</span></td>
                </tr>
                <tr>
                  <td>
                    <div class="class-info">
                      <div class="class-icon">🌳</div>
                      <span>Lớp Lá</span>
                    </div>
                  </td>
                  <td><span class="badge-count">30</span></td>
                  <td><span class="amount">3.0M</span></td>
                  <td><span class="total-amount success">90.0M</span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="detail-card">
        <div class="card-header">
          <h3 class="card-title">
            <i class="bx bx-money me-2"></i>
            Chi tiết chi phí
          </h3>
          <button class="btn-icon">
            <i class="bx bx-dots-vertical-rounded"></i>
          </button>
        </div>
        <div class="card-body">
          <div class="table-container">
            <table class="modern-table">
              <thead>
                <tr>
                  <th>Danh mục</th>
                  <th>Số tiền</th>
                  <th>Tỷ lệ</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <div class="expense-info">
                      <div class="expense-icon">👩‍🏫</div>
                      <span>Lương giáo viên</span>
                    </div>
                  </td>
                  <td><span class="expense-amount">45.6M</span></td>
                  <td><span class="percentage">75%</span></td>
                </tr>
                <tr>
                  <td>
                    <div class="expense-info">
                      <div class="expense-icon">⚙️</div>
                      <span>Chi phí vận hành</span>
                    </div>
                  </td>
                  <td><span class="expense-amount">15.2M</span></td>
                  <td><span class="percentage">25%</span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Tuition Management Section -->
    <div class="tuition-management">
      <h3 class="section-title">
        <i class="bx bx-credit-card me-2"></i>
        Quản lý học phí
      </h3>

      <div class="tuition-cards">
        <div class="tuition-card">
          <div class="card-header">
            <h4 class="card-title">
              <i class="bx bx-user-check me-2"></i>
              Học phí theo học sinh
            </h4>
            <button class="btn-add">
              <i class="bx bx-plus"></i>
            </button>
          </div>
          <div class="card-body">
            <div class="student-fee-list">
              <div class="student-fee-item">
                <div class="student-info">
                  <div class="avatar">A</div>
                  <div class="info">
                    <h5>Nguyễn Văn An</h5>
                    <p>Lớp Mầm - Tháng 12/2024</p>
                  </div>
                </div>
                <div class="fee-details">
                  <span class="fee-amount">2.5M</span>
                  <span class="fee-status paid">Đã đóng</span>
                </div>
              </div>
              <div class="student-fee-item">
                <div class="student-info">
                  <div class="avatar">B</div>
                  <div class="info">
                    <h5>Trần Thị Bình</h5>
                    <p>Lớp Chồi - Tháng 12/2024</p>
                  </div>
                </div>
                <div class="fee-details">
                  <span class="fee-amount">2.8M</span>
                  <span class="fee-status pending">Chưa đóng</span>
                </div>
              </div>
              <div class="student-fee-item">
                <div class="student-info">
                  <div class="avatar">C</div>
                  <div class="info">
                    <h5>Lê Văn Cường</h5>
                    <p>Lớp Lá - Tháng 12/2024</p>
                  </div>
                </div>
                <div class="fee-details">
                  <span class="fee-amount">3.0M</span>
                  <span class="fee-status partial">Còn thiếu</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="tuition-card">
          <div class="card-header">
            <h4 class="card-title">
              <i class="bx bx-calculator me-2"></i>
              Tính toán học phí tự động
            </h4>
          </div>
          <div class="card-body">
            <div class="fee-calculation">
              <div class="calculation-item">
                <span class="label">Học phí cơ bản:</span>
                <span class="value">2.0M</span>
              </div>
              <div class="calculation-item">
                <span class="label">Ăn sáng:</span>
                <span class="value">+200K</span>
              </div>
              <div class="calculation-item">
                <span class="label">Bán trú:</span>
                <span class="value">+300K</span>
              </div>
              <div class="calculation-item">
                <span class="label">Xe đưa đón:</span>
                <span class="value">+150K</span>
              </div>
              <div class="calculation-item total">
                <span class="label">Tổng cộng:</span>
                <span class="value">2.65M</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Payment Methods Section -->
    <div class="payment-methods">
      <h3 class="section-title">
        <i class="bx bx-credit-card me-2"></i>
        Phương thức thanh toán
      </h3>

      <div class="payment-cards">
        <div class="payment-card vnpay">
          <div class="payment-icon">
            <i class="bx bx-credit-card"></i>
          </div>
          <h4>VNPay</h4>
          <p>Thanh toán qua thẻ</p>
          <div class="payment-stats">
            <span class="amount">45.2M</span>
            <span class="count">156 giao dịch</span>
          </div>
        </div>

        <div class="payment-card momo">
          <div class="payment-icon">
            <i class="bx bx-mobile"></i>
          </div>
          <h4>MoMo</h4>
          <p>Ví điện tử</p>
          <div class="payment-stats">
            <span class="amount">32.8M</span>
            <span class="count">89 giao dịch</span>
          </div>
        </div>

        <div class="payment-card zalopay">
          <div class="payment-icon">
            <i class="bx bx-mobile"></i>
          </div>
          <h4>ZaloPay</h4>
          <p>Ví điện tử</p>
          <div class="payment-stats">
            <span class="amount">28.5M</span>
            <span class="count">67 giao dịch</span>
          </div>
        </div>

        <div class="payment-card cash">
          <div class="payment-icon">
            <i class="bx bx-money"></i>
          </div>
          <h4>Tiền mặt</h4>
          <p>Thanh toán trực tiếp</p>
          <div class="payment-stats">
            <span class="amount">18.0M</span>
            <span class="count">45 giao dịch</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Expense Management Section -->
    <div class="expense-management">
      <h3 class="section-title">
        <i class="bx bx-receipt me-2"></i>
        Quản lý chi phí hoạt động
      </h3>

      <div class="expense-tabs">
        <button class="tab-btn active" data-tab="fixed">Chi phí cố định</button>
        <button class="tab-btn" data-tab="variable">Chi phí phát sinh</button>
        <button class="tab-btn" data-tab="salary">Lương nhân viên</button>
      </div>

      <div class="expense-content">
        <div class="tab-content active" id="fixed">
          <div class="expense-list">
            <div class="expense-item">
              <div class="expense-icon">⚡</div>
              <div class="expense-info">
                <h5>Điện</h5>
                <p>Tháng 12/2024</p>
              </div>
              <div class="expense-amount">2.5M</div>
              <div class="expense-status paid">Đã thanh toán</div>
            </div>
            <div class="expense-item">
              <div class="expense-icon">💧</div>
              <div class="expense-info">
                <h5>Nước</h5>
                <p>Tháng 12/2024</p>
              </div>
              <div class="expense-amount">800K</div>
              <div class="expense-status paid">Đã thanh toán</div>
            </div>
            <div class="expense-item">
              <div class="expense-icon">🌐</div>
              <div class="expense-info">
                <h5>Internet</h5>
                <p>Tháng 12/2024</p>
              </div>
              <div class="expense-amount">500K</div>
              <div class="expense-status pending">Chưa thanh toán</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="actions-section">
      <div class="action-buttons">
        <button class="action-btn primary">
          <i class="bx bx-plus"></i>
          <span>Thêm khoản thu</span>
        </button>
        <button class="action-btn success">
          <i class="bx bx-download"></i>
          <span>Xuất báo cáo</span>
        </button>
        <button class="action-btn info">
          <i class="bx bx-calendar"></i>
          <span>Xem lịch sử</span>
        </button>
        <button class="action-btn warning">
          <i class="bx bx-cog"></i>
          <span>Cài đặt</span>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { onMounted } from 'vue'
import Chart from 'chart.js/auto'

export default {
  name: 'TaiChinh',
  setup() {
    onMounted(() => {
      // Revenue Chart
      const revenueCtx = document.getElementById('revenueChart')
      if (revenueCtx) {
        new Chart(revenueCtx, {
          type: 'line',
          data: {
            labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
            datasets: [{
              label: 'Thu học phí',
              data: [95, 98, 102, 105, 110, 115, 118, 120, 122, 125, 128, 124.5],
              borderColor: 'rgb(75, 192, 192)',
              backgroundColor: 'rgba(75, 192, 192, 0.2)',
              tension: 0.4
            }, {
              label: 'Chi phí',
              data: [55, 58, 60, 62, 65, 68, 70, 72, 75, 78, 80, 60.8],
              borderColor: 'rgb(255, 99, 132)',
              backgroundColor: 'rgba(255, 99, 132, 0.2)',
              tension: 0.4
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            aspectRatio: 2,
            plugins: {
              legend: {
                position: 'top',
              },
              title: {
                display: true,
                text: 'Thu chi theo tháng (triệu VNĐ)'
              }
            },
            scales: {
              y: {
                beginAtZero: true
              }
            },
            layout: {
              padding: {
                top: 20,
                bottom: 20,
                left: 20,
                right: 20
              }
            }
          }
        })
      }

      // Expense Chart
      const expenseCtx = document.getElementById('expenseChart')
      if (expenseCtx) {
        new Chart(expenseCtx, {
          type: 'doughnut',
          data: {
            labels: ['Lương giáo viên', 'Chi phí vận hành', 'Cơ sở vật chất', 'Khác'],
            datasets: [{
              data: [60, 20, 15, 5],
              backgroundColor: [
                'rgba(255, 99, 132, 0.8)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 206, 86, 0.8)',
                'rgba(75, 192, 192, 0.8)'
              ],
              borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
              ],
              borderWidth: 2
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            aspectRatio: 1,
            plugins: {
              legend: {
                position: 'bottom',
              }
            },
            layout: {
              padding: {
                top: 20,
                bottom: 20,
                left: 20,
                right: 20
              }
            }
          }
        })
      }

      // Class Revenue Chart
      const classRevenueCtx = document.getElementById('classRevenueChart')
      if (classRevenueCtx) {
        new Chart(classRevenueCtx, {
          type: 'bar',
          data: {
            labels: ['Lớp Mầm', 'Lớp Chồi', 'Lớp Lá', 'Lớp Tổng hợp'],
            datasets: [{
              label: 'Thu nhập (triệu VNĐ)',
              data: [62.5, 78.4, 90.0, 45.2],
              backgroundColor: [
                'rgba(16, 185, 129, 0.8)',
                'rgba(59, 130, 246, 0.8)',
                'rgba(139, 92, 246, 0.8)',
                'rgba(245, 158, 11, 0.8)'
              ],
              borderColor: [
                'rgba(16, 185, 129, 1)',
                'rgba(59, 130, 246, 1)',
                'rgba(139, 92, 246, 1)',
                'rgba(245, 158, 11, 1)'
              ],
              borderWidth: 2,
              borderRadius: 8
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            aspectRatio: 2,
            plugins: {
              legend: {
                display: false
              }
            },
            scales: {
              y: {
                beginAtZero: true,
                grid: {
                  color: 'rgba(0, 0, 0, 0.1)'
                }
              },
              x: {
                grid: {
                  display: false
                }
              }
            },
            layout: {
              padding: {
                top: 20,
                bottom: 20,
                left: 20,
                right: 20
              }
            }
          }
        })
      }

      // Growth Chart
      const growthCtx = document.getElementById('growthChart')
      if (growthCtx) {
        new Chart(growthCtx, {
          type: 'line',
          data: {
            labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
            datasets: [{
              label: 'Tăng trưởng (%)',
              data: [5, 8, 12, 15, 18, 22, 25, 28, 30, 32, 35, 38],
              borderColor: 'rgba(16, 185, 129, 1)',
              backgroundColor: 'rgba(16, 185, 129, 0.1)',
              tension: 0.4,
              fill: true
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            aspectRatio: 2,
            plugins: {
              legend: {
                display: false
              }
            },
            scales: {
              y: {
                beginAtZero: true,
                grid: {
                  color: 'rgba(0, 0, 0, 0.1)'
                }
              },
              x: {
                grid: {
                  display: false
                }
              }
            },
            layout: {
              padding: {
                top: 20,
                bottom: 20,
                left: 20,
                right: 20
              }
            }
          }
        })
      }

      // Payment Status Chart
      const paymentStatusCtx = document.getElementById('paymentStatusChart')
      if (paymentStatusCtx) {
        new Chart(paymentStatusCtx, {
          type: 'doughnut',
          data: {
            labels: ['Đã đóng phí', 'Chưa đóng phí', 'Quá hạn'],
            datasets: [{
              data: [156, 8, 2],
              backgroundColor: [
                'rgba(16, 185, 129, 0.8)',
                'rgba(245, 158, 11, 0.8)',
                'rgba(239, 68, 68, 0.8)'
              ],
              borderColor: [
                'rgba(16, 185, 129, 1)',
                'rgba(245, 158, 11, 1)',
                'rgba(239, 68, 68, 1)'
              ],
              borderWidth: 2
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            aspectRatio: 1,
            plugins: {
              legend: {
                position: 'bottom',
              }
            },
            layout: {
              padding: {
                top: 20,
                bottom: 20,
                left: 20,
                right: 20
              }
            }
          }
        })
      }
    })

    return {}
  }
}
</script>

<style scoped>
@import "./style.scss";
</style>
