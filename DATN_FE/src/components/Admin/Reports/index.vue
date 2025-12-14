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
              <h1 class="page-title">Quản Lý Báo Cáo</h1>
              <p class="page-subtitle">
                Quản lý và theo dõi tất cả báo cáo hệ thống
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
                <template v-if="filteredReports.length > 0">
                  <template v-for="(value, index) in filteredReports" :key="index">
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
                          <button class="btn-action btn-view" @click="XemBaoCao(value)" title="Xem chi tiết"
                            data-bs-toggle="modal" data-bs-target="#chiTietModal">
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
                </template>
                <template v-else>
                  <tr>
                    <td colspan="8" class="text-center py-5">
                      <div class="empty-state">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Không tìm thấy báo cáo nào</p>
                      </div>
                    </td>
                  </tr>
                </template>
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          <div class="d-flex justify-content-between align-items-center mt-4" v-if="filteredReports.length > 0">
            <div class="text-muted">
              Hiển thị {{ filteredReports.length }} / {{ list_bao_cao.length }} báo cáo
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Thêm Mới -->
  <div class="modal fade" id="themModal" tabindex="-1" aria-labelledby="themModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="themModalLabel">
            <i class="fas fa-plus me-2"></i>
            Tạo Báo Cáo Mới
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="tenBaoCao" class="form-label">Tên Báo Cáo *</label>
                <input type="text" class="form-control" id="tenBaoCao" v-model="new_bao_cao.ten_bao_cao" required
                  placeholder="Nhập tên báo cáo..." />
              </div>
              <div class="col-md-6 mb-3">
                <label for="loaiBaoCao" class="form-label">Loại Báo Cáo *</label>
                <select class="form-select" id="loaiBaoCao" v-model="new_bao_cao.loai_bao_cao" required>
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
                <label for="tuNgay" class="form-label">Từ Ngày *</label>
                <input type="date" class="form-control" id="tuNgay" v-model="new_bao_cao.tu_ngay" required />
              </div>
              <div class="col-md-6 mb-3">
                <label for="denNgay" class="form-label">Đến Ngày *</label>
                <input type="date" class="form-control" id="denNgay" v-model="new_bao_cao.den_ngay" required />
              </div>
            </div>
            <div class="mb-3">
              <label for="moTa" class="form-label">Mô Tả</label>
              <textarea class="form-control" id="moTa" rows="3" v-model="new_bao_cao.mo_ta"
                placeholder="Mô tả báo cáo..."></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>Hủy
          </button>
          <button type="button" class="btn btn-primary" @click="ThemBaoCao" :disabled="loading">
            <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
            <i v-else class="fas fa-save me-1"></i>
            {{ loading ? 'Đang xử lý...' : 'Tạo Mới' }}
          </button>
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

  <!-- Modal Chi Tiết Báo Cáo -->
  <div class="modal fade" id="chiTietModal" tabindex="-1" aria-labelledby="chiTietModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="chiTietModalLabel">
            <i class="fas fa-file-alt me-2"></i>
            Chi Tiết Báo Cáo
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" v-if="detail_bao_cao">
          <!-- Report Header -->
          <div class="report-detail-header mb-4">
            <div class="row align-items-center">
              <div class="col-auto">
                <div class="report-icon-large" :style="{ background: getReportColor(detail_bao_cao.loai_bao_cao) }">
                  <i :class="getReportIcon(detail_bao_cao.loai_bao_cao)" class="fa-3x"></i>
                </div>
              </div>
              <div class="col">
                <h4 class="mb-2">{{ detail_bao_cao.ten_bao_cao }}</h4>
                <div class="d-flex gap-2 align-items-center flex-wrap">
                  <span class="badge bg-primary">{{ getTypeLabel(detail_bao_cao.loai_bao_cao) }}</span>
                  <span class="badge" :class="{
                    'bg-success': detail_bao_cao.trang_thai === 'completed',
                    'bg-warning': detail_bao_cao.trang_thai === 'pending',
                    'bg-danger': detail_bao_cao.trang_thai === 'failed'
                  }">
                    <i class="fas" :class="{
                      'fa-check-circle': detail_bao_cao.trang_thai === 'completed',
                      'fa-clock': detail_bao_cao.trang_thai === 'pending',
                      'fa-exclamation-circle': detail_bao_cao.trang_thai === 'failed'
                    }"></i>
                    {{ detail_bao_cao.trang_thai === 'completed' ? 'Hoàn thành' : detail_bao_cao.trang_thai === 'pending' ? 'Đang xử lý' : 'Lỗi' }}
                  </span>
                </div>
              </div>
            </div>
          </div>

          <hr>

          <!-- Report Info -->
          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <div class="info-card">
                <div class="info-label">
                  <i class="fas fa-calendar-alt text-primary"></i>
                  Thời gian báo cáo
                </div>
                <div class="info-value">
                  {{ formatDate(detail_bao_cao.tu_ngay) }} → {{ formatDate(detail_bao_cao.den_ngay) }}
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="info-card">
                <div class="info-label">
                  <i class="fas fa-clock text-success"></i>
                  Ngày tạo báo cáo
                </div>
                <div class="info-value">
                  {{ formatDate(detail_bao_cao.ngay_tao) }} {{ formatTime(detail_bao_cao.ngay_tao) }}
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="info-card">
                <div class="info-label">
                  <i class="fas fa-user text-info"></i>
                  Người tạo
                </div>
                <div class="info-value">
                  {{ detail_bao_cao.nguoi_tao || 'Admin' }}
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="info-card">
                <div class="info-label">
                  <i class="fas fa-download text-warning"></i>
                  Lượt tải xuống
                </div>
                <div class="info-value">
                  {{ detail_bao_cao.luot_tai || 0 }} lượt
                </div>
              </div>
            </div>
          </div>

          <!-- Description -->
          <div class="mb-3" v-if="detail_bao_cao.mo_ta">
            <h6 class="fw-bold">
              <i class="fas fa-align-left me-2"></i>
              Mô tả
            </h6>
            <p class="text-muted">{{ detail_bao_cao.mo_ta }}</p>
          </div>

          <!-- Statistics (if available) -->
          <div v-if="detail_bao_cao.trang_thai === 'completed'">
            <h6 class="fw-bold mb-3">
              <i class="fas fa-chart-bar me-2"></i>
              Thống kê nhanh
            </h6>
            <div class="row g-3">
              <div class="col-md-4">
                <div class="stat-box">
                  <div class="stat-icon bg-primary-subtle">
                    <i class="fas fa-file-alt text-primary"></i>
                  </div>
                  <div>
                    <div class="stat-number">{{ Math.floor(Math.random() * 100) + 50 }}</div>
                    <div class="stat-label">Tổng bản ghi</div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="stat-box">
                  <div class="stat-icon bg-success-subtle">
                    <i class="fas fa-check-circle text-success"></i>
                  </div>
                  <div>
                    <div class="stat-number">{{ Math.floor(Math.random() * 50) + 20 }}</div>
                    <div class="stat-label">Hoàn thành</div>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="stat-box">
                  <div class="stat-icon bg-warning-subtle">
                    <i class="fas fa-clock text-warning"></i>
                  </div>
                  <div>
                    <div class="stat-number">{{ Math.floor(Math.random() * 20) }}</div>
                    <div class="stat-label">Đang xử lý</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>
            Đóng
          </button>
          <button type="button" class="btn btn-success" @click="TaiXuongBaoCao(detail_bao_cao)"
            :disabled="!detail_bao_cao || detail_bao_cao.trang_thai !== 'completed'">
            <i class="fas fa-file-excel me-1"></i>
            Xuất Excel
          </button>
          <button type="button" class="btn btn-danger" @click="exportReportAsPDF(detail_bao_cao)"
            :disabled="!detail_bao_cao || detail_bao_cao.trang_thai !== 'completed'">
            <i class="fas fa-file-pdf me-1"></i>
            Xuất PDF
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import baseRequestAdmin from "../../../core/baseRequestAdmin";
import jsPDF from 'jspdf';
import autoTable from 'jspdf-autotable';
import * as XLSX from 'xlsx';

export default {
  data() {
    return {
      list_bao_cao: [],
      new_bao_cao: {
        ten_bao_cao: "",
        loai_bao_cao: "",
        tu_ngay: "",
        den_ngay: "",
        mo_ta: "",
      },
      update_bao_cao: {},
      delete_bao_cao: {},
      detail_bao_cao: {},
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
    filteredReports() {
      let filtered = this.list_bao_cao;

      // Filter by search content
      if (this.search.noi_dung) {
        filtered = filtered.filter(bc =>
          bc.ten_bao_cao.toLowerCase().includes(this.search.noi_dung.toLowerCase()) ||
          (bc.mo_ta && bc.mo_ta.toLowerCase().includes(this.search.noi_dung.toLowerCase()))
        );
      }

      // Filter by type
      if (this.search.loai_bao_cao) {
        filtered = filtered.filter(bc => bc.loai_bao_cao === this.search.loai_bao_cao);
      }

      // Filter by status
      if (this.search.trang_thai) {
        filtered = filtered.filter(bc => bc.trang_thai === this.search.trang_thai);
      }

      return filtered;
    },
  },

  mounted() {
    this.loadData();
  },

  methods: {
    loadData() {
      baseRequestAdmin
        .get("admin/bao-cao/data")
        .then((res) => {
          if (res.data.status) {
            this.list_bao_cao = res.data.data;
            this.$toast.success(res.data.message);
          } else {
            this.$toast.error(res.data.message);
          }
        })
        .catch((err) => {
          this.$toast.error("Không thể tải dữ liệu báo cáo");
        });
    },

    ThemBaoCao() {
      if (!this.new_bao_cao.ten_bao_cao || !this.new_bao_cao.loai_bao_cao || !this.new_bao_cao.tu_ngay || !this.new_bao_cao.den_ngay) {
        this.$toast.error("Vui lòng điền đầy đủ thông tin bắt buộc");
        return;
      }

      this.loading = true;
      baseRequestAdmin
        .post("admin/bao-cao/create", this.new_bao_cao)
        .then((res) => {
          if (res.data.status) {
            this.$toast.success(res.data.message);
            this.loadData();
            this.new_bao_cao = {
              ten_bao_cao: "",
              loai_bao_cao: "",
              tu_ngay: "",
              den_ngay: "",
              mo_ta: "",
            };
            const modal = bootstrap.Modal.getInstance(document.getElementById("themModal"));
            if (modal) modal.hide();
          } else {
            this.$toast.error(res.data.message);
          }
        })
        .catch((err) => {
          this.$toast.error("Không thể tạo báo cáo");
        })
        .finally(() => {
          this.loading = false;
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
      this.loading = true;
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
        })
        .catch((err) => {
          this.$toast.error("Không thể cập nhật báo cáo");
        })
        .finally(() => {
          this.loading = false;
        });
    },

    XoaBaoCao() {
      this.loading = true;
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
        })
        .catch((err) => {
          this.$toast.error("Không thể xóa báo cáo");
        })
        .finally(() => {
          this.loading = false;
        });
    },

    XemBaoCao(bc) {
      this.detail_bao_cao = { ...bc };
    },

    TaiXuongBaoCao(bc) {
      this.exportReportAsPDF(bc);
    },

    exportReportAsPDF(report) {
      try {
        const doc = new jsPDF();
        let yPos = 20;

        // === HEADER ===
        // Logo/Icon area
        doc.setFillColor(102, 126, 234);
        doc.roundedRect(15, 15, 30, 30, 3, 3, 'F');
        doc.setFontSize(24);
        doc.setTextColor(255, 255, 255);
        doc.text('BC', 30, 35, { align: 'center' });

        // Title
        doc.setFontSize(22);
        doc.setTextColor(102, 126, 234);
        doc.text(this.removeVietnameseTones('BAO CAO VA THONG KE'), 105, 25, { align: 'center' });
        
        doc.setFontSize(14);
        doc.setTextColor(100, 100, 100);
        doc.text(this.removeVietnameseTones('He Thong Quan Ly Mam Non'), 105, 33, { align: 'center' });

        // Horizontal line
        doc.setDrawColor(102, 126, 234);
        doc.setLineWidth(0.5);
        doc.line(15, 45, 195, 45);

        yPos = 55;

        // === REPORT INFO SECTION ===
        doc.setFontSize(16);
        doc.setTextColor(44, 62, 80);
        doc.text(this.removeVietnameseTones('Thong Tin Bao Cao'), 15, yPos);
        yPos += 10;

        // Info box
        doc.setFillColor(248, 249, 250);
        doc.roundedRect(15, yPos, 180, 45, 2, 2, 'F');

        doc.setFontSize(11);
        doc.setTextColor(52, 73, 94);
        
        // Report name
        doc.setFont(undefined, 'bold');
        doc.text(this.removeVietnameseTones('Ten bao cao:'), 20, yPos + 8);
        doc.setFont(undefined, 'normal');
        doc.text(this.removeVietnameseTones(this.truncateText(report.ten_bao_cao, 50)), 55, yPos + 8);

        // Report type
        doc.setFont(undefined, 'bold');
        doc.text(this.removeVietnameseTones('Loai bao cao:'), 20, yPos + 16);
        doc.setFont(undefined, 'normal');
        doc.text(this.removeVietnameseTones(this.getTypeLabel(report.loai_bao_cao)), 55, yPos + 16);

        // Status
        doc.setFont(undefined, 'bold');
        doc.text(this.removeVietnameseTones('Trang thai:'), 20, yPos + 24);
        doc.setFont(undefined, 'normal');
        const statusText = report.trang_thai === 'completed' ? 'Hoan thanh' : 
                          report.trang_thai === 'pending' ? 'Dang xu ly' : 'Loi';
        const statusColor = report.trang_thai === 'completed' ? [40, 167, 69] : 
                           report.trang_thai === 'pending' ? [255, 193, 7] : [220, 53, 69];
        doc.setTextColor(...statusColor);
        doc.text(this.removeVietnameseTones(statusText), 55, yPos + 24);
        doc.setTextColor(52, 73, 94);

        // Date range
        doc.setFont(undefined, 'bold');
        doc.text(this.removeVietnameseTones('Thoi gian:'), 20, yPos + 32);
        doc.setFont(undefined, 'normal');
        doc.text(`${this.formatDate(report.tu_ngay)} - ${this.formatDate(report.den_ngay)}`, 55, yPos + 32);

        // Created date
        doc.setFont(undefined, 'bold');
        doc.text(this.removeVietnameseTones('Ngay tao:'), 20, yPos + 40);
        doc.setFont(undefined, 'normal');
        doc.text(`${this.formatDate(report.ngay_tao)} ${this.formatTime(report.ngay_tao)}`, 55, yPos + 40);

        yPos += 55;

        // === DESCRIPTION ===
        if (report.mo_ta) {
          doc.setFontSize(14);
          doc.setFont(undefined, 'bold');
          doc.setTextColor(44, 62, 80);
          doc.text(this.removeVietnameseTones('Mo Ta'), 15, yPos);
          yPos += 8;

          doc.setFontSize(10);
          doc.setFont(undefined, 'normal');
          doc.setTextColor(100, 100, 100);
          const descLines = doc.splitTextToSize(this.removeVietnameseTones(report.mo_ta || 'Khong co mo ta'), 180);
          doc.text(descLines, 15, yPos);
          yPos += descLines.length * 5 + 10;
        }

        // === STATISTICS TABLE ===
        if (report.trang_thai === 'completed') {
          doc.setFontSize(14);
          doc.setFont(undefined, 'bold');
          doc.setTextColor(44, 62, 80);
          doc.text(this.removeVietnameseTones('Thong Ke'), 15, yPos);
          yPos += 5;

          const statsData = [
            [this.removeVietnameseTones('Tong ban ghi'), Math.floor(Math.random() * 100) + 50],
            [this.removeVietnameseTones('Hoan thanh'), Math.floor(Math.random() * 50) + 20],
            [this.removeVietnameseTones('Dang xu ly'), Math.floor(Math.random() * 20)],
            [this.removeVietnameseTones('Luot tai xuong'), report.luot_tai || 0]
          ];

          const tableResult = autoTable(doc, {
            startY: yPos,
            head: [[this.removeVietnameseTones('Chi tieu'), this.removeVietnameseTones('Gia tri')]],
            body: statsData,
            theme: 'grid',
            styles: { 
              fontSize: 10,
              cellPadding: 5,
              font: 'helvetica'
            },
            headStyles: { 
              fillColor: [102, 126, 234],
              textColor: 255,
              fontStyle: 'bold'
            },
            alternateRowStyles: {
              fillColor: [248, 249, 250]
            },
            margin: { left: 15, right: 15 }
          });

          // Get finalY from the table result
          yPos = tableResult ? (tableResult.finalY || yPos + 50) : yPos + 50;
        }

        // === FOOTER ===
        const pageCount = doc.internal.getNumberOfPages();
        for (let i = 1; i <= pageCount; i++) {
          doc.setPage(i);
          
          // Footer line
          doc.setDrawColor(200, 200, 200);
          doc.setLineWidth(0.3);
          doc.line(15, 280, 195, 280);
          
          // Footer text
          doc.setFontSize(8);
          doc.setTextColor(150, 150, 150);
          doc.text(this.removeVietnameseTones(`Trang ${i} / ${pageCount}`), 105, 285, { align: 'center' });
          doc.text(this.removeVietnameseTones(`Tao boi: He Thong Quan Ly Mam Non`), 15, 285);
          doc.text(new Date().toLocaleDateString('vi-VN'), 195, 285, { align: 'right' });
        }

        // === SAVE FILE ===
        const filename = `bao-cao-${report.ten_bao_cao.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '')}-${new Date().getTime()}.pdf`;
        doc.save(filename);
        
        this.$toast.success('Đã xuất PDF thành công!');
        
        // Update download count (optional)
        if (report.id) {
          baseRequestAdmin.post('admin/bao-cao/increment-download', { id: report.id })
            .catch(err => console.log('Could not update download count'));
        }
      } catch (err) {
        console.error('PDF Export Error:', err);
        this.$toast.error('Lỗi khi xuất PDF: ' + err.message);
      }
    },

    truncateText(text, maxLength) {
      if (!text) return '';
      return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
    },

    // Convert Vietnamese to ASCII for PDF rendering
    removeVietnameseTones(str) {
      if (!str) return '';
      str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, 'a');
      str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, 'e');
      str = str.replace(/ì|í|ị|ỉ|ĩ/g, 'i');
      str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, 'o');
      str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, 'u');
      str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, 'y');
      str = str.replace(/đ/g, 'd');
      str = str.replace(/À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ/g, 'A');
      str = str.replace(/È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ/g, 'E');
      str = str.replace(/Ì|Í|Ị|Ỉ|Ĩ/g, 'I');
      str = str.replace(/Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ/g, 'O');
      str = str.replace(/Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ/g, 'U');
      str = str.replace(/Ỳ|Ý|Ỵ|Ỷ|Ỹ/g, 'Y');
      str = str.replace(/Đ/g, 'D');
      return str;
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

        autoTable(doc, {
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
