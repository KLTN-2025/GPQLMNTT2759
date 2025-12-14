<template>
  <div class="page-header education-theme">
    <div class="container-fluid">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="page-header-content">
            <div class="page-icon">
              <i class="fas fa-heartbeat"></i>
            </div>
            <div class="page-info">
              <h1 class="page-title">Quản lý Sức Khỏe</h1>
              <p class="page-subtitle">
                Theo dõi và quản lý sức khỏe học sinh
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <nav class="breadcrumb-nav">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <i class="fas fa-school"></i>
                <a href="javascript: void(0);">Quản lý</a>
              </li>
              <li class="breadcrumb-item active">
                <i class="fas fa-heartbeat"></i>
                Sức Khỏe
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>

  <!-- Dashboard Section -->
  <div class="row mb-4">
    <div class="col-xl-3 col-md-6">
      <div class="stats-card stats-primary">
        <div class="stats-icon">
          <i class="fas fa-users"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">{{ getTotalStudents() }}</h3>
          <p class="stats-label">Tổng Học Sinh</p>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="stats-card stats-success">
        <div class="stats-icon">
          <i class="fas fa-heart"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">
            {{ getHealthStatusCount('good') }}
          </h3>
          <p class="stats-label">Sức Khỏe Tốt</p>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="stats-card stats-warning">
        <div class="stats-icon">
          <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">
            {{ getHealthStatusCount('monitor') }}
          </h3>
          <p class="stats-label">Cần Theo Dõi</p>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="stats-card stats-danger">
        <div class="stats-icon">
          <i class="fas fa-user-injured"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">
            {{ getHealthStatusCount('intervention') }}
          </h3>
          <p class="stats-label">Cần Can Thiệp</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Health Dashboard Charts -->
  <div class="row mb-4">
    <div class="col-lg-8">
      <div class="dashboard-card">
        <div class="card-header-custom">
          <div class="header-content">
            <div class="header-icon">
              <i class="fas fa-chart-bar"></i>
            </div>
            <div class="header-text">
              <h5 class="card-title">Tình Trạng Sức Khỏe Theo Lớp</h5>
              <p class="card-subtitle">Phân tích sức khỏe học sinh theo từng lớp</p>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="health-chart-container">
            <div v-for="(classData, index) in getClassHealthData()" :key="index" class="health-chart-item">
              <div class="chart-header">
                <div class="class-info">
                  <span class="class-name">{{ classData.className }}</span>
                  <span class="student-count">{{ classData.totalStudents }} học sinh</span>
                </div>
                <div class="health-percentage">
                  <span class="percentage">{{ classData.healthPercentage }}%</span>
                  <small>sức khỏe tốt</small>
                </div>
              </div>
              <div class="progress-container">
                <div class="progress-bar">
                  <div class="progress-fill good" :style="{ width: classData.goodPercentage + '%' }"></div>
                  <div class="progress-fill monitor" :style="{ width: classData.monitorPercentage + '%' }"></div>
                  <div class="progress-fill intervention" :style="{ width: classData.interventionPercentage + '%' }">
                  </div>
                </div>
                <div class="progress-labels">
                  <span class="label good">{{ classData.goodCount }} tốt</span>
                  <span class="label monitor">{{ classData.monitorCount }} theo dõi</span>
                  <span class="label intervention">{{ classData.interventionCount }} can thiệp</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="dashboard-card">
        <div class="card-header-custom">
          <div class="header-content">
            <div class="header-icon">
              <i class="fas fa-calendar-check"></i>
            </div>
            <div class="header-text">
              <h5 class="card-title">Lịch Khám Sức Khỏe</h5>
              <p class="card-subtitle">Thống kê khám sức khỏe tháng này</p>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="health-stats">
            <div class="stat-item">
              <div class="stat-icon">
                <i class="fas fa-stethoscope"></i>
              </div>
              <div class="stat-content">
                <div class="stat-title">Khám định kỳ</div>
                <div class="stat-value">{{ getTotalStudents() }}/{{ getTotalStudents() }}</div>
                <div class="stat-status completed">Hoàn thành</div>
              </div>
            </div>
            <div class="stat-item">
              <div class="stat-icon">
                <i class="fas fa-syringe"></i>
              </div>
              <div class="stat-content">
                <div class="stat-title">Tiêm chủng</div>
                <div class="stat-value">{{ getVaccinationCount() }}/{{ getTotalStudents() }}</div>
                <div class="stat-status in-progress">Đang thực hiện</div>
              </div>
            </div>
            <div class="stat-item">
              <div class="stat-icon">
                <i class="fas fa-user-md"></i>
              </div>
              <div class="stat-content">
                <div class="stat-title">Khám chuyên khoa</div>
                <div class="stat-value">{{ getSpecialistCount() }}/{{ getTotalStudents() }}</div>
                <div class="stat-status pending">Cần theo dõi</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12">
      <div class="management-card" :class="{ 'no-hover': modalOpen }">
        <div class="card-header-custom">
          <div class="header-content">
            <div class="header-icon">
              <i class="fas fa-heartbeat"></i>
            </div>
            <div class="header-text">
              <h5 class="card-title">Danh Sách Sức Khỏe Học Sinh</h5>
              <p class="card-subtitle">Quản lý thông tin sức khỏe học sinh</p>
            </div>
          </div>
          <button class="btn btn-primary btn-modern" data-bs-toggle="modal" data-bs-target="#themModal">
            <i class="fas fa-plus"></i>
            Thêm Khám Sức Khỏe
          </button>


        </div>

        <div class="card-body">
          <!-- Search Container -->
          <div class="search-container mb-4">
            <div class="search-input-group">
              <div class="form-search">
                <div class="search-icon">
                  <i class="fas fa-search"></i>
                </div>
                <input v-on:change="TiemKiem()" v-on:keyup.enter="TiemKiem()" v-model="search.noi_dung" type="text"
                  class="search-input" placeholder="Tìm kiếm theo tên học sinh..." />
              </div>

              <div class="search-filters">
                <select v-on:change="TiemKiem()" class="filter-select" v-model="search.id_lop">
                  <option value="" selected>Tất cả lớp</option>
                  <template v-for="(lop) in list_lop_hoc" :key="lop.id">
                    <option :value="lop.id">{{ lop.ten_lop }}</option>

                  </template>

                </select>
                <select v-on:change="TiemKiem()" class="filter-select" v-model="search.tinh_trang_suc_khoe">
                  <option value="" selected>Tất cả tình trạng</option>
                  <option value="1">Sức khỏe tốt</option>
                  <option value="2">Cần theo dõi</option>
                  <option value="3">Cần can thiệp</option>
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
                  <th>Học Sinh</th>
                  <th class="text-center">Thông Tin Sức Khỏe</th>
                  <th class="text-center">Tình Trạng</th>
                  <th class="text-center">Lần Khám Cuối</th>
                  <th class="text-center">Thao Tác</th>
                </tr>
              </thead>
              <tbody>
                <template v-for="(value, index) in list_kham_suc_khoe" :key="index">
                  <tr class="table-row-hover">
                    <td class="text-center table-index">
                      {{ index + 1 }}
                    </td>
                    <td class="student-info">
                      <div class="student-container">
                        <div class="student-avatar">
                          <img :src="value.avatar || '/default-avatar.jpg'" :alt="value.ho_va_ten" class="avatar-img" />
                        </div>
                        <div class="student-details">
                          <span class="student-name">{{ value.ho_va_ten }}</span>
                          <small class="student-class">{{ value.ten_lop }}</small>
                        </div>
                      </div>
                    </td>
                    <td class="text-center health-info">
                      <div class="health-metrics">
                        <div class="metric-item">
                          <i class="fas fa-ruler-vertical"></i>
                          <span>{{ value.chieu_cao }}cm</span>
                        </div>
                        <div class="metric-item">
                          <i class="fas fa-weight-scale"></i>
                          <span>{{ value.can_nang }}kg</span>
                        </div>
                        <div class="metric-item">
                          <i class="fas fa-eye"></i>
                          <span v-if="value.thi_luc == 1">Tốt</span>
                          <span v-else-if="value.thi_luc == 2">Hơi kém</span>
                          <span v-else-if="value.thi_luc == 3">Kém</span>
                          <span v-else>Chưa rõ</span>
                        </div>
                        <div class="metric-item">
                          <i class="fas fa-tooth"></i>
                          <span v-if="value.rang_mieng == 1">Tốt</span>
                          <span v-else-if="value.rang_mieng == 2">Bình thường</span>
                          <span v-else-if="value.rang_mieng == 3">Cần chăm sóc</span>
                          <span v-else>Chưa rõ</span>
                        </div>
                      </div>
                    </td>
                    <td class="text-center">
                      <button v-if="value.tinh_trang_suc_khoe == 1" class="btn btn-success">Sức Khoẻ Tốt</button>
                      <button v-else-if="value.tinh_trang_suc_khoe == 2" class="btn btn-warning">Cần Theo Dõi</button>
                      <button v-else-if="value.tinh_trang_suc_khoe == 3" class="btn btn-danger">Cần Can Thiệp</button>
                      <button v-else class="btn btn-secondary">Chưa Rõ</button>
                    </td>
                    <td class="text-center">
                      <div class="last-checkup">
                        <div class="checkup-date">{{ formatDate(value.ngay_kham) }}</div>
                        <small v-if="value.loai_kham == 1" class="checkup-type">Khám Định Kỳ</small>
                        <small v-else-if="value.loai_kham == 2" class="checkup-type">Khám Cấp Cứu</small>
                        <small v-else class="checkup-type">Chưa Rõ</small>
                      </div>
                    </td>
                    <td class="text-center">
                      <div class="action-buttons">
                        <button class="btn-action btn-view" @click="viewHealthDetails(value)" title="Xem chi tiết">
                          <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn-action btn-edit" @click="Object.assign(update_kham_suc_khoe, value)"
                          data-bs-toggle="modal" data-bs-target="#capNhatModal" title="Chỉnh sửa">
                          <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-action btn-delete" @click="Object.assign(delete_kham_suc_khoe, value)"
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
  <!-- Modal Thêm Khám Sức Khỏe -->
  <div class="modal fade" id="themModal" tabindex="-1" aria-labelledby="themModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="themModalLabel">
            <i class="fas fa-stethoscope me-2"></i>
            Thêm Khám Sức Khỏe
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="row">
              <div class="col-md-6">
                <label for="hocSinh" class="form-label">Học Sinh *</label>
                <select class="form-select" id="hocSinh" v-model="create_kham_suc_khoe.id_hoc_sinh" required>
                  <option value="">Chọn học sinh</option>
                  <option v-for="hs in list_hoc_sinh" :key="hs.id" :value="hs.id">
                    {{ hs.ho_va_ten }} - {{ hs.ten_lop }}
                  </option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="ngayKham" class="form-label">Ngày Khám *</label>
                <input type="date" class="form-control" id="ngayKham" v-model="create_kham_suc_khoe.ngay_kham"
                  required />
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="chieuCao" class="form-label">Chiều Cao (cm) *</label>
                <input type="number" class="form-control" id="chieuCao" v-model="create_kham_suc_khoe.chieu_cao"
                  min="50" max="200" required />
              </div>
              <div class="col-md-6">
                <label for="canNang" class="form-label">Cân Nặng (kg) *</label>
                <input type="number" step="0.1" class="form-control" id="canNang"
                  v-model="create_kham_suc_khoe.can_nang" min="5" max="100" required />
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="thiLuc" class="form-label">Thị Lực *</label>
                <select class="form-select" id="thiLuc" v-model="create_kham_suc_khoe.thi_luc" required>
                  <option value="">Chọn thị lực</option>
                  <option value="1">Bình thường</option>
                  <option value="2">Hơi kém</option>
                  <option value="3">Kém</option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="rangMieng" class="form-label">Răng Miệng *</label>
                <select class="form-select" id="rangMieng" v-model="create_kham_suc_khoe.rang_mieng" required>
                  <option value="">Chọn tình trạng</option>
                  <option value="1">Tốt</option>
                  <option value="2">Bình thường</option>
                  <option value="3">Cần chăm sóc</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="tinhTrangSucKhoe" class="form-label">Tình Trạng Sức Khỏe *</label>
                <select class="form-select" id="tinhTrangSucKhoe" v-model="create_kham_suc_khoe.tinh_trang_suc_khoe"
                  required>
                  <option value="">Chọn tình trạng</option>
                  <option value="1">Sức khỏe tốt</option>
                  <option value="2">Cần theo dõi</option>
                  <option value="3">Cần can thiệp</option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="loaiKham" class="form-label">Loại Khám *</label>
                <select class="form-select" id="loaiKham" v-model="create_kham_suc_khoe.loai_kham" required>
                  <option value="">Chọn loại khám</option>
                  <option value="1">Khám định kỳ</option>
                  <option value="2">Khám cấp cứu</option>
                  <option value="3">Khám chuyên khoa</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <label for="ghiChu" class="form-label">Ghi Chú</label>
                <textarea class="form-control" id="ghiChu" rows="3" v-model="create_kham_suc_khoe.ghi_chu"
                  placeholder="Nhập ghi chú về sức khỏe học sinh..."></textarea>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>
            Hủy
          </button>
          <button type="button" class="btn btn-primary" @click="ThemKhamSucKhoe" :disabled="loading">
            <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
            <i v-else class="fas fa-save me-1"></i>
            {{ loading ? 'Đang xử lý...' : 'Thêm Khám Sức Khỏe' }}
          </button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Cập Nhật Khám Sức Khỏe -->
  <div class="modal fade" id="capNhatModal" tabindex="-1" aria-labelledby="capNhatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="capNhatModalLabel">
            <i class="fas fa-edit me-2"></i>
            Cập Nhật Khám Sức Khỏe
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateHocSinh" class="form-label">Học Sinh *</label>
                  <select class="form-select" id="updateHocSinh" v-model="update_kham_suc_khoe.id_hoc_sinh" required>
                    <option value="">Chọn học sinh</option>
                    <option v-for="hs in list_hoc_sinh" :key="hs.id" :value="hs.id">
                      {{ hs.ho_va_ten }} - {{ hs.lop_hoc }}
                    </option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateNgayKham" class="form-label">Ngày Khám *</label>
                  <input type="date" class="form-control" id="updateNgayKham" v-model="update_kham_suc_khoe.ngay_kham"
                    required />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateChieuCao" class="form-label">Chiều Cao (cm) *</label>
                  <input type="number" class="form-control" id="updateChieuCao" v-model="update_kham_suc_khoe.chieu_cao"
                    min="50" max="200" required />
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateCanNang" class="form-label">Cân Nặng (kg) *</label>
                  <input type="number" step="0.1" class="form-control" id="updateCanNang"
                    v-model="update_kham_suc_khoe.can_nang" min="5" max="100" required />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateThiLuc" class="form-label">Thị Lực *</label>
                  <select class="form-select" id="updateThiLuc" v-model="update_kham_suc_khoe.thi_luc" required>
                    <option value="">Chọn thị lực</option>
                    <option value="1">Bình thường</option>
                    <option value="2">Hơi kém</option>
                    <option value="3">Kém</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateRangMieng" class="form-label">Răng Miệng *</label>
                  <select class="form-select" id="updateRangMieng" v-model="update_kham_suc_khoe.rang_mieng" required>
                    <option value="">Chọn tình trạng</option>
                    <option value="1">Tốt</option>
                    <option value="2">Bình thường</option>
                    <option value="3">Cần chăm sóc</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateTinhTrangSucKhoe" class="form-label">Tình Trạng Sức Khỏe *</label>
                  <select class="form-select" id="updateTinhTrangSucKhoe"
                    v-model="update_kham_suc_khoe.tinh_trang_suc_khoe" required>
                    <option value="">Chọn tình trạng</option>
                    <option value="1">Sức khỏe tốt</option>
                    <option value="2">Cần theo dõi</option>
                    <option value="3">Cần can thiệp</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateLoaiKham" class="form-label">Loại Khám *</label>
                  <select class="form-select" id="updateLoaiKham" v-model="update_kham_suc_khoe.loai_kham" required>
                    <option value="">Chọn loại khám</option>
                    <option value="1">Khám định kỳ</option>
                    <option value="2">Khám cấp cứu</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label for="updateGhiChu" class="form-label">Ghi Chú</label>
              <textarea class="form-control" id="updateGhiChu" rows="3" v-model="update_kham_suc_khoe.ghi_chu"
                placeholder="Nhập ghi chú về sức khỏe học sinh..."></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>
            Hủy
          </button>
          <button type="button" class="btn btn-primary" @click="CapNhatKhamSucKhoe" :disabled="loading">
            <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
            <i v-else class="fas fa-save me-1"></i>
            {{ loading ? 'Đang xử lý...' : 'Cập Nhật' }}
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Xóa Khám Sức Khỏe -->
  <div class="modal fade" id="xoaModal" tabindex="-1" aria-labelledby="xoaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="xoaModalLabel">
            <i class="fas fa-exclamation-triangle me-2 text-warning"></i>
            Xác Nhận Xóa Khám Sức Khỏe
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="text-center">
            <div class="mb-3">
              <i class="fas fa-stethoscope text-danger" style="font-size: 3rem;"></i>
            </div>
            <h6>Bạn có chắc chắn muốn xóa thông tin khám sức khỏe này không?</h6>
            <div class="alert alert-warning" role="alert">
              <strong>Thông tin khám sức khỏe:</strong><br>
              <strong>Học sinh:</strong> {{ delete_kham_suc_khoe.ten_hoc_sinh }}<br>
              <strong>Ngày khám:</strong> {{ formatDate(delete_kham_suc_khoe.ngay_kham) }}<br>
              <strong>Loại khám:</strong> {{ delete_kham_suc_khoe.loai_kham }}
            </div>
            <p class="text-muted">
              <i class="fas fa-info-circle me-1"></i>
              Hành động này không thể hoàn tác!
            </p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>
            Hủy
          </button>
          <button type="button" class="btn btn-danger" @click="XoaKhamSucKhoe" :disabled="loading">
            <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
            <i v-else class="fas fa-trash me-1"></i>
            {{ loading ? 'Đang xử lý...' : 'Xóa Khám Sức Khỏe' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import baseRequestAdmin from "../../../core/baseRequestAdmin";

export default {
  data() {
    return {
      list_kham_suc_khoe: [],
      list_hoc_sinh: [],
      create_kham_suc_khoe: {
        id_hoc_sinh: "",
        ngay_kham: "",
        chieu_cao: "",
        can_nang: "",
        thi_luc: "",
        rang_mieng: "",
        tinh_trang_suc_khoe: "",
        loai_kham: "",
        ghi_chu: "",
      },
      update_kham_suc_khoe: {
        id: "",
        id_hoc_sinh: "",
        ngay_kham: "",
        chieu_cao: "",
        can_nang: "",
        thi_luc: "",
        rang_mieng: "",
        tinh_trang_suc_khoe: "",
        loai_kham: "",
        ghi_chu: "",
      },
      delete_kham_suc_khoe: {
        id: "",
        ten_hoc_sinh: "",
        ngay_kham: "",
        loai_kham: "",
      },
      search: {
        noi_dung: "",
        id_lop: "",
        tinh_trang_suc_khoe: "",
      },
      list_lop_hoc: [],
      loading: false,
    };
  },

  mounted() {
    this.loadData();
    this.loadLopHoc();
    this.loadHocSinh();
  },

  methods: {
    formatDate(dateString) {
      if (!dateString) return "";
      const date = new Date(dateString);
      return date.toLocaleDateString("vi-VN");
    },

    getTotalStudents() {
      return this.list_kham_suc_khoe.length;
    },

    getHealthStatusCount(status) {
      return this.list_kham_suc_khoe.filter(item => item.tinh_trang_suc_khoe === status).length;
    },

    getClassHealthData() {
      const classes = ['Lớp Mầm', 'Lớp Chồi', 'Lớp Lá'];
      return classes.map(className => {
        const classStudents = this.list_kham_suc_khoe.filter(item => item.lop_hoc === className);
        const totalStudents = classStudents.length;
        const goodCount = classStudents.filter(item => item.tinh_trang_suc_khoe === 'good').length;
        const monitorCount = classStudents.filter(item => item.tinh_trang_suc_khoe === 'monitor').length;
        const interventionCount = classStudents.filter(item => item.tinh_trang_suc_khoe === 'intervention').length;

        return {
          className,
          totalStudents,
          goodCount,
          monitorCount,
          interventionCount,
          goodPercentage: totalStudents > 0 ? Math.round((goodCount / totalStudents) * 100) : 0,
          monitorPercentage: totalStudents > 0 ? Math.round((monitorCount / totalStudents) * 100) : 0,
          interventionPercentage: totalStudents > 0 ? Math.round((interventionCount / totalStudents) * 100) : 0,
          healthPercentage: totalStudents > 0 ? Math.round((goodCount / totalStudents) * 100) : 0,
        };
      });
    },

    getVaccinationCount() {
      // Mock data - trong thực tế sẽ lấy từ API
      return Math.floor(this.getTotalStudents() * 0.8);
    },

    getSpecialistCount() {
      // Mock data - trong thực tế sẽ lấy từ API
      return Math.floor(this.getTotalStudents() * 0.15);
    },

    loadLopHoc() {
      baseRequestAdmin
        .get("admin/lop-hoc/data")
        .then((res) => {
          if (res.data.status) {
            this.list_lop_hoc = res.data.data;
            this.$toast.success(res.data.message);
          } else {
            this.$toast.error(res.data.message);
          }
        })
        .catch((err) => {
          const listErr = err.response?.data?.errors;
          if (listErr) {
            Object.values(listErr).forEach((error) => {
              this.$toast.error(error[0]);
            });
          } else {
            this.$toast.error("Có lỗi xảy ra khi tải dữ liệu");
          }
        });
    },
    loadData() {
      baseRequestAdmin
        .get("admin/suc-khoe/data")
        .then((res) => {
          if (res.data.status) {
            this.list_kham_suc_khoe = res.data.data;
            this.$toast.success(res.data.message);
          } else {
            this.$toast.error(res.data.message);
          }
        })
        .catch((err) => {
          const listErr = err.response?.data?.errors;
          if (listErr) {
            Object.values(listErr).forEach((error) => {
              this.$toast.error(error[0]);
            });
          } else {
            this.$toast.error("Có lỗi xảy ra khi tải dữ liệu");
          }
        });
    },

    loadHocSinh() {
      baseRequestAdmin
        .get("admin/hoc-sinh/data")
        .then((res) => {
          if (res.data.status) {
            this.list_hoc_sinh = res.data.data;
          }
        })
        .catch((err) => {
          console.log("Không thể tải danh sách học sinh");
        });
    },

    ThemKhamSucKhoe() {
      this.loading = true;
      baseRequestAdmin
        .post("admin/suc-khoe/create", this.create_kham_suc_khoe)
        .then((res) => {
          if (res.data.status) {
            this.$toast.success(res.data.message);
            this.loadData();
            this.resetCreateForm();
            // Đóng modal
            const modal = bootstrap.Modal.getInstance(document.getElementById("themModal"));
            if (modal) modal.hide();
          } else {
            this.$toast.error(res.data.message);
          }
        })
        .catch((err) => {
          const listErr = err.response?.data?.errors;
          if (listErr) {
            Object.values(listErr).forEach((error) => {
              this.$toast.error(error[0]);
            });
          } else {
            this.$toast.error("Có lỗi xảy ra khi thêm khám sức khỏe");
          }
        })
        .finally(() => {
          this.loading = false;
        });
    },

    CapNhatKhamSucKhoe() {
      this.loading = true;
      baseRequestAdmin
        .post("admin/suc-khoe/update", this.update_kham_suc_khoe)
        .then((res) => {
          if (res.data.status) {
            this.$toast.success(res.data.message);
            this.loadData();
            // Đóng modal
            const modal = bootstrap.Modal.getInstance(document.getElementById("capNhatModal"));
            if (modal) modal.hide();
          } else {
            this.$toast.error(res.data.message);
          }
        })
        .catch((err) => {
          const listErr = err.response?.data?.errors;
          if (listErr) {
            Object.values(listErr).forEach((error) => {
              this.$toast.error(error[0]);
            });
          } else {
            this.$toast.error("Có lỗi xảy ra khi cập nhật khám sức khỏe");
          }
        })
        .finally(() => {
          this.loading = false;
        });
    },

    XoaKhamSucKhoe() {
      this.loading = true;
      baseRequestAdmin
        .post("admin/suc-khoe/delete", this.delete_kham_suc_khoe)
        .then((res) => {
          if (res.data.status) {
            this.$toast.success(res.data.message);
            this.loadData();
            this.delete_kham_suc_khoe = {};
            // Đóng modal
            const modal = bootstrap.Modal.getInstance(document.getElementById("xoaModal"));
            if (modal) modal.hide();
          } else {
            this.$toast.error(res.data.message);
          }
        })
        .catch((err) => {
          const listErr = err.response?.data?.errors;
          if (listErr) {
            Object.values(listErr).forEach((error) => {
              this.$toast.error(error[0]);
            });
          } else {
            this.$toast.error("Có lỗi xảy ra khi xóa khám sức khỏe");
          }
        })
        .finally(() => {
          this.loading = false;
        });
    },

    TiemKiem() {
      baseRequestAdmin
        .post("admin/suc-khoe/search", this.search)
        .then((res) => {
          if (res.data.status) {
            this.$toast.success(res.data.message);
            this.list_kham_suc_khoe = res.data.data;
          } else {
            this.$toast.error(res.data.message);
          }
        })
        .catch((err) => {
          const listErr = err.response?.data?.errors;
          if (listErr) {
            Object.values(listErr).forEach((error) => {
              this.$toast.error(error[0]);
            });
          } else {
            this.$toast.error("Có lỗi xảy ra khi tìm kiếm");
          }
        });
    },

    viewHealthDetails(health) {
      // Implement view health details functionality
      alert(`Xem chi tiết sức khỏe: ${health.ten_hoc_sinh}`);
    },

    resetCreateForm() {
      this.create_kham_suc_khoe = {
        id_hoc_sinh: "",
        ngay_kham: "",
        chieu_cao: "",
        can_nang: "",
        thi_luc: "",
        rang_mieng: "",
        tinh_trang_suc_khoe: "",
        loai_kham: "",
        ghi_chu: "",
      };
    },
  },
};
</script>

<style lang="scss">
@use "./style.scss";
</style>