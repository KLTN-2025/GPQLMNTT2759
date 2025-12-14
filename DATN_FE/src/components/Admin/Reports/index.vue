<template>
  <div class="page-header education-theme">
    <div class="container-fluid">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="page-header-content">
            <div class="page-icon">
              <i class="fas fa-chart-line"></i>
            </div>
            <div class="page-info">
              <h1 class="page-title">Báo Cáo & Thống Kê</h1>
              <p class="page-subtitle">
                Quản lý và theo dõi báo cáo tổng hợp hệ thống
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-6 text-end">
          <nav class="breadcrumb-nav">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <i class="fas fa-home"></i>
                <a href="javascript: void(0);">Hệ thống</a>
              </li>
              <li class="breadcrumb-item active">
                <i class="fas fa-chart-line"></i>
                Báo Cáo
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>

  <!-- Statistics Overview -->
  <div class="row mb-4">
    <div class="col-xl-3 col-md-6">
      <div class="stats-card stats-primary">
        <div class="stats-icon">
          <i class="fas fa-file-alt"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">{{ list_bao_cao.length }}</h3>
          <p class="stats-label">Tổng Báo Cáo</p>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="stats-card stats-success">
        <div class="stats-icon">
          <i class="fas fa-check-circle"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">{{ completedReports }}</h3>
          <p class="stats-label">Đã Hoàn Thành</p>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="stats-card stats-warning">
        <div class="stats-icon">
          <i class="fas fa-clock"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">{{ pendingReports }}</h3>
          <p class="stats-label">Đang Xử Lý</p>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="stats-card stats-info">
        <div class="stats-icon">
          <i class="fas fa-download"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">{{ downloadedReports }}</h3>
          <p class="stats-label">Lượt Tải Xuống</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Charts Section -->
  <div class="row mb-4">
    <div class="col-xl-8">
      <div class="management-card">
        <div class="card-header-custom">
          <div class="header-content">
            <div class="header-icon">
              <i class="fas fa-chart-bar"></i>
            </div>
            <div class="header-text">
              <h5 class="card-title">Thống Kê Báo Cáo Theo Loại</h5>
              <p class="card-subtitle">Phân tích dữ liệu báo cáo theo từng loại</p>
            </div>
          </div>
          <div class="chart-actions">
            <button class="btn btn-outline-primary btn-sm me-2" @click="exportChart">
              <i class="fas fa-file-export"></i> Xuất Biểu Đồ
            </button>
            <select class="form-select form-select-sm" style="width: auto;">
              <option value="week">Tuần này</option>
              <option value="month">Tháng này</option>
              <option value="quarter">Quý này</option>
              <option value="year">Năm này</option>
            </select>
          </div>
        </div>
        <div class="card-body">
          <canvas id="reportTypeChart" height="300"></canvas>
        </div>
      </div>
    </div>
    <div class="col-xl-4">
      <div class="management-card">
        <div class="card-header-custom">
          <div class="header-content">
            <div class="header-icon">
              <i class="fas fa-chart-pie"></i>
            </div>
            <div class="header-text">
              <h5 class="card-title">Phân Bổ Báo Cáo</h5>
              <p class="card-subtitle">Tỷ lệ báo cáo theo loại</p>
            </div>
          </div>
        </div>
        <div class="card-body">
          <canvas id="reportDistributionChart" height="300"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- Report Trends -->
  <div class="row mb-4">
    <div class="col-xl-12">
      <div class="management-card">
        <div class="card-header-custom">
          <div class="header-content">
            <div class="header-icon">
              <i class="fas fa-chart-area"></i>
            </div>
            <div class="header-text">
              <h5 class="card-title">Xu Hướng Báo Cáo</h5>
              <p class="card-subtitle">Biểu đồ xu hướng báo cáo theo thời gian</p>
            </div>
          </div>
        </div>
        <div class="card-body">
          <canvas id="reportTrendChart" height="100"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- Reports Table -->
  <div class="row">
    <div class="col-lg-12">
      <div class="management-card">
        <div class="card-header-custom">
          <div class="header-content">
            <div class="header-icon">
              <i class="fas fa-table"></i>
            </div>
            <div class="header-text">
              <h5 class="card-title">Danh Sách Báo Cáo</h5>
              <p class="card-subtitle">Quản lý tất cả báo cáo hệ thống</p>
            </div>
          </div>
          <div class="header-actions">
            <button class="btn btn-outline-success btn-sm me-2" @click="exportAllReportsExcel">
              <i class="fas fa-file-excel"></i> Excel
            </button>
            <button class="btn btn-outline-danger btn-sm me-2" @click="exportAllReportsPDF">
              <i class="fas fa-file-pdf"></i> PDF
            </button>
            <button class="btn btn-primary btn-modern" data-bs-toggle="modal" data-bs-target="#themModal">
              <i class="fas fa-plus"></i>
              Tạo Báo Cáo Mới
            </button>
          </div>
        </div>

        <div class="card-body">
          <!-- Search Container -->
          <div class="search-container mb-4">
            <div class="search-input-group">
              <div class="form-search">
                <div class="search-icon">
                  <i class="fas fa-search"></i>
                </div>
                <input v-model="search.noi_dung" type="text" class="search-input"
                  placeholder="Tìm kiếm theo tên báo cáo..." />
              </div>

              <div class="search-filters">
                <select v-model="search.loai_bao_cao" class="filter-select">
                  <option value="">Tất cả loại</option>
                  <option value="financial">Tài chính</option>
                  <option value="student">Học sinh</option>
                  <option value="activity">Hoạt động</option>
                  <option value="attendance">Điểm danh</option>
                  <option value="health">Sức khỏe</option>
                </select>
                <select v-model="search.trang_thai" class="filter-select">
                  <option value="">Tất cả trạng thái</option>
                  <option value="completed">Hoàn thành</option>
                  <option value="pending">Đang xử lý</option>
                  <option value="failed">Lỗi</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Table -->
          <div class="table-container">
            <div class="">
              <table class="table table-modern">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>Báo Cáo</th>
                    <th class="text-center">Loại</th>
                    <th class="text-center">Thời Gian</th>
                    <th class="text-center">Ngày Tạo</th>
                    <th class="text-center">Trạng Thái</th>
                    <th class="text-center">Thao Tác</th>
                  </tr>
                </thead>
                <tbody>
                  <template v-for="(value, index) in list_bao_cao" :key="index">
                    <tr class="table-row-hover">
                      <td class="text-center table-index">
                        {{ index + 1 }}
                      </td>
                      <td class="report-info">
                        <div class="report-container">
                          <div class="report-icon" :style="{ background: getReportColor(value.loai_bao_cao) }">
                            <i :class="getReportIcon(value.loai_bao_cao)"></i>
                          </div>
                          <div class="report-details">
                            <span class="report-name">{{ value.ten_bao_cao }}</span>
                            <small class="report-description">{{ value.mo_ta || 'Không có mô tả' }}</small>
                          </div>
                        </div>
                      </td>
                      <td class="text-center">
                        <span class="type-badge">
                          {{ getTypeLabel(value.loai_bao_cao) }}
                        </span>
                      </td>
                      <td class="text-center report-details-info">
                        <div class="info-group">
                          <div class="info-item">
                            <i class="fas fa-calendar-alt"></i>
                            <span>{{ formatDate(value.tu_ngay) }} - {{ formatDate(value.den_ngay) }}</span>
                          </div>
                        </div>
                      </td>
                      <td class="text-center">
                        <div class="date-info">
                          <span class="date">{{ formatDate(value.ngay_tao) }}</span>
                          <small class="time">{{ formatTime(value.ngay_tao) }}</small>
                        </div>
                      </td>
                      <td class="text-center">
                        <button v-on:click="DoiTrangThai(value)" v-if="value.trang_thai == 'completed'"
                          class="btn status-badge status-active">
                          <i class="fas fa-check-circle"></i>
                          Hoàn Thành
                        </button>
                        <button v-on:click="DoiTrangThai(value)" v-else-if="value.trang_thai == 'pending'"
                          class="btn status-badge status-pending">
                          <i class="fas fa-clock"></i>
                          Đang Xử Lý
                        </button>
                        <button v-on:click="DoiTrangThai(value)" v-else class="btn status-badge status-failed">
                          <i class="fas fa-exclamation-circle"></i>
                          Lỗi
                        </button>
                      </td>
                      <td class="text-center">
                        <div class="action-buttons">
                          <button class="btn-action btn-view" @click="XemBaoCao(value)" title="Xem">
                            <i class="fas fa-eye"></i>
                          </button>
                          <button class="btn-action btn-download" @click="TaiXuongBaoCao(value)"
                            :disabled="value.trang_thai !== 'completed'" title="Tải xuống">
                            <i class="fas fa-download"></i>
                          </button>
                          <button class="btn-action btn-edit" @click="Object.assign(update_bao_cao, value)"
                            data-bs-toggle="modal" data-bs-target="#capNhatModal" title="Chỉnh sửa">
                            <i class="fas fa-edit"></i>
                          </button>
                          <button class="btn-action btn-delete" @click="Object.assign(delete_bao_cao, value)"
                            data-bs-toggle="modal" data-bs-target="#xoaModal" title="Xóa">
                            <i class="fas fa-trash"></i>
                          </button>
                        </div>
                      </td>
                    </tr>
                  </template>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Cập Nhật -->
  <div class="modal fade" id="capNhatModal" tabindex="-1" aria-labelledby="capNhatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="capNhatModalLabel">
            <i class="fas fa-edit me-2"></i>
            Cập Nhật Báo Cáo
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="updateTenBaoCao" class="form-label">Tên Báo Cáo *</label>
                <input type="text" class="form-control" id="updateTenBaoCao" v-model="update_bao_cao.ten_bao_cao"
                  required />
              </div>
              <div class="col-md-6 mb-3">
                <label for="updateLoaiBaoCao" class="form-label">Loại Báo Cáo *</label>
                <select class="form-select" id="updateLoaiBaoCao" v-model="update_bao_cao.loai_bao_cao" required>
                  <option value="">Chọn loại</option>
                  <option value="financial">Tài chính</option>
                  <option value="student">Học sinh</option>
                  <option value="activity">Hoạt động</option>
                  <option value="attendance">Điểm danh</option>
                  <option value="health">Sức khỏe</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="updateTuNgay" class="form-label">Từ Ngày *</label>
                <input type="date" class="form-control" id="updateTuNgay" v-model="update_bao_cao.tu_ngay" required />
              </div>
              <div class="col-md-6 mb-3">
                <label for="updateDenNgay" class="form-label">Đến Ngày *</label>
                <input type="date" class="form-control" id="updateDenNgay" v-model="update_bao_cao.den_ngay" required />
              </div>
            </div>
            <div class="mb-3">
              <label for="updateMoTa" class="form-label">Mô Tả</label>
              <textarea class="form-control" id="updateMoTa" rows="3" v-model="update_bao_cao.mo_ta"
                placeholder="Mô tả báo cáo..."></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>Hủy
          </button>
          <button type="button" class="btn btn-primary" @click="CapNhatBaoCao" :disabled="loading">
            <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
            <i v-else class="fas fa-save me-1"></i>
            {{ loading ? 'Đang xử lý...' : 'Cập Nhật' }}
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Xóa -->
  <div class="modal fade" id="xoaModal" tabindex="-1" aria-labelledby="xoaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="xoaModalLabel">
            <i class="fas fa-exclamation-triangle me-2 text-warning"></i>
            Xác Nhận Xóa
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="text-center">
            <div class="mb-3">
              <i class="fas fa-file-alt text-danger" style="font-size: 3rem;"></i>
            </div>
            <h6>Bạn có chắc muốn xóa báo cáo này?</h6>
            <div class="alert alert-warning mt-3">
              <strong>Tên:</strong> {{ delete_bao_cao.ten_bao_cao }}<br>
              <strong>Loại:</strong> {{ getTypeLabel(delete_bao_cao.loai_bao_cao) }}
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>Hủy
          </button>
          <button type="button" class="btn btn-danger" @click="XoaBaoCao" :disabled="loading">
            <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
            <i v-else class="fas fa-trash me-1"></i>
            {{ loading ? 'Đang xử lý...' : 'Xóa' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import baseRequestAdmin from "../../../core/baseRequestAdmin";
import Chart from 'chart.js/auto';
import jsPDF from 'jspdf';
import 'jspdf-autotable';
import * as XLSX from 'xlsx';

export default {
  data() {
    return {
      list_bao_cao: [],
      update_bao_cao: {},
      delete_bao_cao: {},
      search: {
        noi_dung: "",
        trang_thai: "",
        loai_bao_cao: "",
      },
      loading: false,
    };
  },

  computed: {
    completedReports() {
      return this.list_bao_cao.filter((bc) => bc.trang_thai == 'completed').length;
    },
    pendingReports() {
      return this.list_bao_cao.filter((bc) => bc.trang_thai == 'pending').length;
    },
    downloadedReports() {
      return this.list_bao_cao.reduce((total, bc) => total + (bc.luot_tai || 0), 0);
    },
  },

  mounted() {
    this.loadData();
    this.$nextTick(() => {
      this.initCharts();
    });
  },

  methods: {
    loadData() {
      baseRequestAdmin
        .get("admin/bao-cao/data")
        .then((res) => {
          if (res.data.status) {
            this.list_bao_cao = res.data.data;
            this.$toast.success(res.data.message);
            this.$nextTick(() => {
              this.initCharts();
            });
          } else {
            this.$toast.error(res.data.message);
          }
        })
        .catch((err) => {
          this.$toast.error("Không thể tải dữ liệu báo cáo");
        });
    },

    initCharts() {
      this.initTypeChart();
      this.initDistributionChart();
      this.initTrendChart();
    },

    initTypeChart() {
      const ctx = document.getElementById('reportTypeChart');
      if (!ctx) return;

      const labels = ['Tài chính', 'Học sinh', 'Hoạt động', 'Điểm danh', 'Sức khỏe'];
      const data = labels.map(label => {
        return this.list_bao_cao.filter(bc => {
          const labelMap = {
            'Tài chính': 'financial',
            'Học sinh': 'student',
            'Hoạt động': 'activity',
            'Điểm danh': 'attendance',
            'Sức khỏe': 'health'
          };
          return bc.loai_bao_cao === labelMap[label];
        }).length;
      });

      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
            label: 'Số lượng báo cáo',
            data: data,
            backgroundColor: [
              'rgba(255, 99, 132, 0.7)',
              'rgba(54, 162, 235, 0.7)',
              'rgba(255, 206, 86, 0.7)',
              'rgba(75, 192, 192, 0.7)',
              'rgba(153, 102, 255, 0.7)'
            ],
            borderColor: [
              'rgba(255, 99, 132, 1)',
              'rgba(54, 162, 235, 1)',
              'rgba(255, 206, 86, 1)',
              'rgba(75, 192, 192, 1)',
              'rgba(153, 102, 255, 1)'
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

    initDistributionChart() {
      const ctx = document.getElementById('reportDistributionChart');
      if (!ctx) return;

      const labels = ['Hoàn thành', 'Đang xử lý', 'Lỗi'];
      const completed = this.completedReports;
      const pending = this.pendingReports;
      const failed = this.list_bao_cao.filter(bc => bc.trang_thai === 'failed').length;

      new Chart(ctx, {
        type: 'doughnut',
        data: {
          labels: labels,
          datasets: [{
            data: [completed, pending, failed],
            backgroundColor: [
              'rgba(75, 192, 192, 0.7)',
              'rgba(255, 206, 86, 0.7)',
              'rgba(255, 99, 132, 0.7)'
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

    initTrendChart() {
      const ctx = document.getElementById('reportTrendChart');
      if (!ctx) return;

      const labels = [];
      const data = [];
      for (let i = 11; i >= 0; i--) {
        const date = new Date();
        date.setDate(date.getDate() - i);
        labels.push(date.toLocaleDateString('vi-VN', { day: '2-digit', month: '2-digit' }));
        data.push(Math.floor(Math.random() * 20) + 5);
      }

      new Chart(ctx, {
        type: 'line',
        data: {
          labels: labels,
          datasets: [{
            label: 'Số báo cáo',
            data: data,
            borderColor: 'rgb(102, 126, 234)',
            backgroundColor: 'rgba(102, 126, 234, 0.1)',
            tension: 0.4,
            fill: true
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    },

    DoiTrangThai(payload) {
      baseRequestAdmin
        .post("admin/bao-cao/change-status", payload)
        .then((res) => {
          if (res.data.status) {
            this.$toast.success(res.data.message);
            this.loadData();
          } else {
            this.$toast.error(res.data.message);
          }
        });
    },

    CapNhatBaoCao() {
      baseRequestAdmin
        .post("admin/bao-cao/update", this.update_bao_cao)
        .then((res) => {
          if (res.data.status) {
            this.$toast.success(res.data.message);
            this.loadData();
            const modal = bootstrap.Modal.getInstance(document.getElementById("capNhatModal"));
            if (modal) modal.hide();
          } else {
            this.$toast.error(res.data.message);
          }
        });
    },

    XoaBaoCao() {
      baseRequestAdmin
        .post("admin/bao-cao/delete", this.delete_bao_cao)
        .then((res) => {
          if (res.data.status) {
            this.$toast.success(res.data.message);
            this.loadData();
            const modal = bootstrap.Modal.getInstance(document.getElementById("xoaModal"));
            if (modal) modal.hide();
          } else {
            this.$toast.error(res.data.message);
          }
        });
    },

    XemBaoCao(bc) {
      this.$toast.info(`Xem báo cáo: ${bc.ten_bao_cao}`);
    },

    TaiXuongBaoCao(bc) {
      this.exportReportAsPDF(bc);
    },

    exportChart() {
      this.exportChartsAsImage();
    },

    exportReportAsPDF(report) {
      try {
        const doc = new jsPDF();

        // Header
        doc.setFontSize(20);
        doc.setTextColor(102, 126, 234);
        doc.text('BÁO CÁO & THỐNG KÊ', 105, 20, { align: 'center' });

        doc.setFontSize(12);
        doc.setTextColor(44, 62, 80);
        doc.text(`Loại: ${this.getTypeLabel(report.loai_bao_cao)}`, 20, 35);
        doc.text(`Ngày tạo: ${this.formatDate(report.ngay_tao)}`, 20, 42);
        doc.text(`Trạng thái: ${report.trang_thai}`, 20, 49);

        // Content
        doc.setFontSize(14);
        doc.text('Thông tin báo cáo:', 20, 60);

        doc.setFontSize(10);
        doc.text(`Tên báo cáo: ${report.ten_bao_cao}`, 20, 70);
        doc.text(`Mô tả: ${report.mo_ta || 'Không có'}`, 20, 77);
        doc.text(`Thời gian: ${this.formatDate(report.tu_ngay)} - ${this.formatDate(report.den_ngay)}`, 20, 84);

        // Table
        doc.autoTable({
          startY: 95,
          head: [['#', 'Tên báo cáo', 'Loại', 'Trạng thái']],
          body: [[
            1,
            report.ten_bao_cao,
            this.getTypeLabel(report.loai_bao_cao),
            report.trang_thai === 'completed' ? 'Hoàn thành' : report.trang_thai === 'pending' ? 'Đang xử lý' : 'Lỗi'
          ]],
          styles: { fontSize: 10 },
          headStyles: { fillColor: [102, 126, 234], textColor: 255 }
        });

        // Save
        const filename = `bao-cao-${report.ten_bao_cao.toLowerCase().replace(/\s+/g, '-')}.pdf`;
        doc.save(filename);
        this.$toast.success('Đã xuất PDF thành công!');
      } catch (err) {
        this.$toast.error('Lỗi khi xuất PDF: ' + err.message);
      }
    },

    exportAllReportsPDF() {
      try {
        const doc = new jsPDF();

        // Header
        doc.setFontSize(20);
        doc.setTextColor(102, 126, 234);
        doc.text('DANH SÁCH BÁO CÁO', 105, 20, { align: 'center' });

        // Table
        const tableData = this.list_bao_cao.map((bc, index) => [
          index + 1,
          bc.ten_bao_cao,
          this.getTypeLabel(bc.loai_bao_cao),
          bc.ngay_tao ? this.formatDate(bc.ngay_tao) : 'N/A',
          bc.trang_thai === 'completed' ? 'Hoàn thành' : bc.trang_thai === 'pending' ? 'Đang xử lý' : 'Lỗi'
        ]);

        doc.autoTable({
          startY: 30,
          head: [['#', 'Tên báo cáo', 'Loại', 'Ngày tạo', 'Trạng thái']],
          body: tableData,
          styles: { fontSize: 9 },
          headStyles: { fillColor: [102, 126, 234], textColor: 255 }
        });

        // Save
        const filename = `danh-sach-bao-cao-${new Date().toISOString().split('T')[0]}.pdf`;
        doc.save(filename);
        this.$toast.success('Đã xuất tất cả báo cáo thành PDF!');
      } catch (err) {
        this.$toast.error('Lỗi khi xuất PDF: ' + err.message);
      }
    },

    exportAllReportsExcel() {
      try {
        // Prepare data
        const data = this.list_bao_cao.map((bc, index) => ({
          'STT': index + 1,
          'Tên báo cáo': bc.ten_bao_cao,
          'Loại': this.getTypeLabel(bc.loai_bao_cao),
          'Từ ngày': this.formatDate(bc.tu_ngay),
          'Đến ngày': this.formatDate(bc.den_ngay),
          'Ngày tạo': this.formatDate(bc.ngay_tao),
          'Trạng thái': bc.trang_thai === 'completed' ? 'Hoàn thành' : bc.trang_thai === 'pending' ? 'Đang xử lý' : 'Lỗi',
          'Mô tả': bc.mo_ta || 'Không có'
        }));

        // Create workbook
        const wb = XLSX.utils.book_new();
        const ws = XLSX.utils.json_to_sheet(data);

        // Set column widths
        const colWidths = [
          { wch: 5 },  // STT
          { wch: 30 }, // Tên báo cáo
          { wch: 15 }, // Loại
          { wch: 12 }, // Từ ngày
          { wch: 12 }, // Đến ngày
          { wch: 12 }, // Ngày tạo
          { wch: 12 }, // Trạng thái
          { wch: 40 }  // Mô tả
        ];
        ws['!cols'] = colWidths;

        // Add worksheet to workbook
        XLSX.utils.book_append_sheet(wb, ws, 'Danh sách báo cáo');

        // Save
        const filename = `danh-sach-bao-cao-${new Date().toISOString().split('T')[0]}.xlsx`;
        XLSX.writeFile(wb, filename);
        this.$toast.success('Đã xuất Excel thành công!');
      } catch (err) {
        this.$toast.error('Lỗi khi xuất Excel: ' + err.message);
      }
    },

    exportChartsAsImage() {
      this.$toast.info("Tính năng xuất biểu đồ đang phát triển");
    },

    formatDate(dateString) {
      if (!dateString) return "";
      return new Date(dateString).toLocaleDateString("vi-VN");
    },

    formatTime(dateString) {
      if (!dateString) return "";
      return new Date(dateString).toLocaleTimeString("vi-VN", {
        hour: '2-digit',
        minute: '2-digit'
      });
    },

    getReportIcon(type) {
      const icons = {
        financial: 'fas fa-dollar-sign',
        student: 'fas fa-user-graduate',
        activity: 'fas fa-calendar-alt',
        attendance: 'fas fa-check-square',
        health: 'fas fa-heartbeat'
      };
      return icons[type] || 'fas fa-file-alt';
    },

    getReportColor(type) {
      const colors = {
        financial: '#e74c3c',
        student: '#3498db',
        activity: '#2ecc71',
        attendance: '#f39c12',
        health: '#e91e63'
      };
      return colors[type] || '#95a5a6';
    },

    getTypeLabel(type) {
      const labels = {
        financial: 'Tài chính',
        student: 'Học sinh',
        activity: 'Hoạt động',
        attendance: 'Điểm danh',
        health: 'Sức khỏe'
      };
      return labels[type] || 'Khác';
    },
  },
};
</script>

<style lang="scss">
@use "./style.scss";
</style>