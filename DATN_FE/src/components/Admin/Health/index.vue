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
          <h3 class="stats-number">{{ totalStudents }}</h3>
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
          <h3 class="stats-number">{{ healthStatusSummary.good }}</h3>
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
          <h3 class="stats-number">{{ healthStatusSummary.monitor }}</h3>
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
          <h3 class="stats-number">{{ healthStatusSummary.intervention }}</h3>
          <p class="stats-label">Cần Can Thiệp</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Health Dashboard Charts -->
  <div class="row mb-4">
    <!-- Left Column: Class Health Stats -->
    <div class="col-lg-8">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-header bg-transparent border-0 pt-4 px-4">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <h5 class="fw-bold mb-1 text-dark">Thống Kê Sức Khỏe Lớp</h5>
              <p class="text-muted small mb-0">Top 3 lớp có sĩ số đông nhất</p>
            </div>
            <div class="icon-box bg-primary bg-opacity-10 text-primary rounded-circle p-3">
              <i class="fas fa-chart-pie fa-lg"></i>
            </div>
          </div>
        </div>
        <div class="card-body px-4">
          <div v-for="(cls, idx) in classHealthData" :key="idx" class="mb-4 last-no-mb">
            <div class="d-flex justify-content-between align-items-end mb-2">
              <div>
                <h6 class="fw-bold mb-0 text-dark">{{ cls.className }}</h6>
                <small class="text-muted">{{ cls.totalStudents }} học sinh</small>
              </div>
              <div class="text-end">
                <span class="fs-5 fw-bold text-success">{{ cls.healthPercentage }}%</span>
                <small class="d-block text-muted" style="font-size: 0.75rem;">Đạt chuẩn</small>
              </div>
            </div>
            <div class="progress" style="height: 10px; border-radius: 10px;">
              <div class="progress-bar bg-success" :style="{ width: cls.goodPercentage + '%' }" title="Tốt"></div>
              <div class="progress-bar bg-warning" :style="{ width: cls.monitorPercentage + '%' }" title="Theo dõi">
              </div>
              <div class="progress-bar bg-danger" :style="{ width: cls.interventionPercentage + '%' }"
                title="Can thiệp"></div>
              <div class="progress-bar bg-dark" :style="{ width: cls.criticalPercentage + '%' }" title="Nguy kịch">
              </div>
            </div>
            <div class="d-flex justify-content-between mt-2 text-xs text-muted">
              <span><i class="fas fa-circle text-success me-1" style="font-size: 8px;"></i>{{ cls.goodCount }}
                Tốt</span>
              <span><i class="fas fa-circle text-warning me-1" style="font-size: 8px;"></i>{{ cls.monitorCount }} Theo
                dõi</span>
              <span><i class="fas fa-circle text-danger me-1" style="font-size: 8px;"></i>{{ cls.interventionCount }}
                Can thiệp</span>
              <span v-if="cls.criticalCount > 0"><i class="fas fa-circle text-dark me-1" style="font-size: 8px;"></i>{{
                cls.criticalCount }} Nguy kịch</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column: Schedule Timeline -->
    <div class="col-lg-4">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-header bg-transparent border-0 pt-4 px-4">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <h5 class="fw-bold mb-1 text-dark">Tiến Độ Y Tế</h5>
              <p class="text-muted small mb-0">Hoạt động trong tháng</p>
            </div>
            <div class="icon-box bg-info bg-opacity-10 text-info rounded-circle p-3">
              <i class="fas fa-tasks fa-lg"></i>
            </div>
          </div>
        </div>
        <div class="card-body px-4 pt-2">
          <!-- Timeline Item 1 -->
          <div class="d-flex mb-4">
            <div class="flex-shrink-0 d-flex flex-column align-items-center me-3">
              <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center"
                style="width: 36px; height: 36px; box-shadow: 0 4px 6px rgba(40, 167, 69, 0.3);">
                <i class="fas fa-check"></i>
              </div>
              <div class="h-100 border-start my-1" style="width: 2px; background-color: #e9ecef;"></div>
            </div>
            <div class="flex-grow-1 pb-2">
              <h6 class="fw-bold mb-1">Khám Định Kỳ</h6>
              <div class="progress mb-2" style="height: 6px;">
                <div class="progress-bar bg-success" style="width: 100%"></div>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">Hoàn thành 100%</small>
                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2">Đã xong</span>
              </div>
            </div>
          </div>

          <!-- Timeline Item 2 -->
          <div class="d-flex mb-4">
            <div class="flex-shrink-0 d-flex flex-column align-items-center me-3">
              <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                style="width: 36px; height: 36px; box-shadow: 0 4px 6px rgba(13, 110, 253, 0.3);">
                <i class="fas fa-syringe"></i>
              </div>
              <div class="h-100 border-start my-1" style="width: 2px; background-color: #e9ecef;"></div>
            </div>
            <div class="flex-grow-1 pb-2">
              <h6 class="fw-bold mb-1">Tiêm Chủng</h6>
              <div class="progress mb-2" style="height: 6px;">
                <div class="progress-bar bg-primary" :style="{ width: (vaccinationCount / totalStudents * 100) + '%' }">
                </div>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">{{ vaccinationCount }}/{{ totalStudents }} bé</small>
                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2">Đang chạy</span>
              </div>
            </div>
          </div>

          <!-- Timeline Item 3: Cấp Cứu -->
          <div class="d-flex">
            <div class="flex-shrink-0 d-flex flex-column align-items-center me-3">
              <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center"
                style="width: 36px; height: 36px; box-shadow: 0 4px 6px rgba(220, 53, 69, 0.3);">
                <i class="fas fa-ambulance"></i>
              </div>
            </div>
            <div class="flex-grow-1">
              <h6 class="fw-bold mb-1">Trường Hợp Cấp Cứu</h6>
              <div class="progress mb-2" style="height: 6px;">
                <div class="progress-bar bg-danger" :style="{ width: (emergencyCount / totalStudents * 100) + '%' }">
                </div>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">{{ emergencyCount }}/{{ totalStudents }} ca</small>
                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2">Theo dõi</span>
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
          <!-- Search & Filter Container -->
          <div class="row p-3 ">
            <div class="col-lg-8 col-md-12">
              <div class="input-group shadow-sm">
                <span class="input-group-text bg-white border-end-0 ps-3">
                  <i class="fas fa-search text-muted"></i>
                </span>
                <input v-on:change="TiemKiem()" v-on:keyup.enter="TiemKiem()" v-model="search.noi_dung" type="text"
                  class="form-control border-start-0 ps-0 py-2" placeholder="Tìm kiếm tên học sinh..."
                  style="border-left: none; box-shadow: none;" />
              </div>
            </div>

            <div class="col-lg-2 col-md-6">
              <div class="input-group shadow-sm">
                <span class="input-group-text bg-white border-end-0 ps-3">
                  <i class="fas fa-filter text-muted"></i>
                </span>
                <select v-on:change="TiemKiem()" class="form-select border-start-0 ps-0 py-2" v-model="search.id_lop"
                  style="cursor: pointer; border-left: none; box-shadow: none;">
                  <option value="" selected>Tất cả lớp</option>
                  <template v-for="(lop) in list_lop_hoc" :key="lop.id">
                    <option :value="lop.id">{{ lop.ten_lop }}</option>
                  </template>
                </select>
              </div>
            </div>

            <div class="col-lg-2 col-md-6">
              <div class="input-group shadow-sm">
                <span class="input-group-text bg-white border-end-0 ps-3">
                  <i class="fas fa-heartbeat text-muted"></i>
                </span>
                <select v-on:change="TiemKiem()" class="form-select border-start-0 ps-0 py-2"
                  v-model="search.tinh_trang_suc_khoe" style="cursor: pointer; border-left: none; box-shadow: none;">
                  <option value="" selected>Tất cả tình trạng</option>
                  <option value="3" class="text-success">💚 Tốt</option>
                  <option value="2" class="text-warning">💛 Cần theo dõi</option>
                  <option value="1" class="text-danger">❤️ Cần can thiệp</option>
                  <option value="0" class="text-dark">⚫ Nguy hiểm</option>
                </select>
              </div>
            </div>
          </div>

          <!-- Health Records Table -->
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead class="table-light">
                <tr>
                  <th class="text-center" style="width: 60px;">#</th>
                  <th style="min-width: 200px;">Học Sinh</th>
                  <th class="text-center" style="min-width: 180px;">Chỉ Số Cơ Bản</th>
                  <th class="text-center" style="min-width: 150px;">Sức Khỏe Chi Tiết</th>
                  <th class="text-center" style="min-width: 130px;">Tình Trạng</th>
                  <th class="text-center" style="min-width: 150px;">Thông Tin Khám</th>
                  <th class="text-center" style="width: 150px;">Thao Tác</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(value, index) in list_kham_suc_khoe" :key="index">
                  <!-- STT -->
                  <td class="text-center fw-semibold text-muted">
                    {{ index + 1 }}
                  </td>

                  <!-- Student Info -->
                  <td>
                    <div class="d-flex align-items-center">
                      <img :src="value.avatar || '/default-avatar.jpg'" :alt="value.ho_va_ten"
                        class="rounded-circle me-3 border" style="width: 45px; height: 45px; object-fit: cover;" />
                      <div>
                        <div class="fw-bold text-dark mb-0">{{ value.ho_va_ten }}</div>
                        <small class="text-muted">
                          <i class="fas fa-school me-1"></i>{{ value.ten_lop }}
                        </small>
                      </div>
                    </div>
                  </td>

                  <!-- Basic Metrics -->
                  <td class="text-center">
                    <div class="d-flex justify-content-center gap-3">
                      <div>
                        <i class="fas fa-ruler-vertical text-primary me-1"></i>
                        <span class="fw-semibold">{{ value.chieu_cao }}</span>
                        <small class="text-muted">cm</small>
                      </div>
                      <div>
                        <i class="fas fa-weight-scale text-success me-1"></i>
                        <span class="fw-semibold">{{ value.can_nang }}</span>
                        <small class="text-muted">kg</small>
                      </div>
                    </div>
                  </td>

                  <!-- Health Details -->
                  <td class="text-center">
                    <div class="d-flex justify-content-center gap-2">
                      <span class="badge bg-light text-dark border" style="font-size: 0.75rem;">
                        <i class="fas fa-eye me-1"></i>
                        <span v-if="value.thi_luc == 1">Tốt</span>
                        <span v-else-if="value.thi_luc == 2">Khá</span>
                        <span v-else-if="value.thi_luc == 3">TB</span>
                        <span v-else-if="value.thi_luc == 4">Yếu</span>
                        <span v-else>-</span>
                      </span>
                      <span class="badge bg-light text-dark border" style="font-size: 0.75rem;">
                        <i class="fas fa-tooth me-1"></i>
                        <span v-if="value.rang_mieng == 1">Tốt</span>
                        <span v-else-if="value.rang_mieng == 2">Khá</span>
                        <span v-else-if="value.rang_mieng == 3">TB</span>
                        <span v-else-if="value.rang_mieng == 4">Yếu</span>
                        <span v-else>-</span>
                      </span>
                    </div>
                  </td>

                  <!-- Health Status -->
                  <td class="text-center">
                    <span class="badge rounded-pill px-3 py-2" :class="{
                      'bg-success': value.tinh_trang_suc_khoe == 3,
                      'bg-warning text-dark': value.tinh_trang_suc_khoe == 2,
                      'bg-danger': value.tinh_trang_suc_khoe == 1,
                      'bg-dark': value.tinh_trang_suc_khoe == 0
                    }">
                      <i class="fas fa-heart me-1"></i>
                      <span v-if="value.tinh_trang_suc_khoe == 3">Tốt</span>
                      <span v-else-if="value.tinh_trang_suc_khoe == 2">Theo dõi</span>
                      <span v-else-if="value.tinh_trang_suc_khoe == 1">Can thiệp</span>
                      <span v-else-if="value.tinh_trang_suc_khoe == 0">Nguy kịch</span>
                      <span v-else>Chưa rõ</span>
                    </span>
                  </td>

                  <!-- Exam Info -->
                  <td class="text-center">
                    <div class="fw-semibold text-dark mb-1">{{ formatDate(value.ngay_kham) }}</div>
                    <small class="text-muted">
                      <span v-if="value.loai_kham == 1">
                        <i class="fas fa-calendar-check text-primary me-1"></i>Định kỳ
                      </span>
                      <span v-else-if="value.loai_kham == 0">
                        <i class="fas fa-ambulance text-danger me-1"></i>Cấp cứu
                      </span>
                      <span v-else>Chưa rõ</span>
                    </small>
                  </td>

                  <!-- Actions -->
                  <td class="text-center">
                    <div class="action-buttons">
                      <button class="btn-action btn-edit" @click="Object.assign(update_kham_suc_khoe, value)"
                        data-bs-toggle="modal" data-bs-target="#capNhatModal" title="Chỉnh sửa">
                        <i class="fas fa-edit"></i>
                      </button>
                      <button class="btn-action btn-view" @click="viewHealthDetails(value)" title="Xem chi tiết">
                        <i class="fas fa-eye"></i>
                      </button>
                      <button class="btn-action btn-delete" @click="Object.assign(delete_kham_suc_khoe, value)"
                        data-bs-toggle="modal" data-bs-target="#xoaModal" title="Xóa">
                        <i class="fas fa-trash"></i>
                      </button>
                    </div>
                  </td>
                </tr>

                <!-- Empty State -->
                <tr v-if="list_kham_suc_khoe.length === 0">
                  <td colspan="7" class="text-center py-5">
                    <i class="fas fa-heartbeat text-muted mb-3" style="font-size: 3rem; opacity: 0.3;"></i>
                    <h6 class="text-muted mb-2">Không tìm thấy hồ sơ sức khỏe</h6>
                    <p class="text-muted small mb-0">Thử thay đổi bộ lọc hoặc thêm hồ sơ mới</p>
                  </td>
                </tr>
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
                  <option value="1">Tốt</option>
                  <option value="2">Khá</option>
                  <option value="3">Trung bình</option>
                  <option value="4">Yếu</option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="rangMieng" class="form-label">Răng Miệng *</label>
                <select class="form-select" id="rangMieng" v-model="create_kham_suc_khoe.rang_mieng" required>
                  <option value="">Chọn tình trạng</option>
                  <option value="1">Tốt</option>
                  <option value="2">Khá</option>
                  <option value="3">Trung bình</option>
                  <option value="4">Yếu</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <label for="tinhTrangSucKhoe" class="form-label">Tình Trạng Sức Khỏe *</label>
                <select class="form-select" id="tinhTrangSucKhoe" v-model="create_kham_suc_khoe.tinh_trang_suc_khoe"
                  required>
                  <option value="">Chọn tình trạng</option>
                  <option value="3">Tốt</option>
                  <option value="2">Cần theo dõi</option>
                  <option value="1">Cần can thiệp</option>
                  <option value="0">Nguy hiểm</option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="loaiKham" class="form-label">Loại Khám *</label>
                <select class="form-select" id="loaiKham" v-model="create_kham_suc_khoe.loai_kham" required>
                  <option value="">Chọn loại khám</option>
                  <option value="1">Định kỳ</option>
                  <option value="0">Cấp cứu</option>
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
                    <option value="1">Tốt</option>
                    <option value="2">Khá</option>
                    <option value="3">Trung bình</option>
                    <option value="4">Yếu</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateRangMieng" class="form-label">Răng Miệng *</label>
                  <select class="form-select" id="updateRangMieng" v-model="update_kham_suc_khoe.rang_mieng" required>
                    <option value="">Chọn tình trạng</option>
                    <option value="1">Tốt</option>
                    <option value="2">Khá</option>
                    <option value="3">Trung bình</option>
                    <option value="4">Yếu</option>
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
                    <option value="3">Tốt</option>
                    <option value="2">Cần theo dõi</option>
                    <option value="1">Cần can thiệp</option>
                    <option value="0">Nguy hiểm</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateLoaiKham" class="form-label">Loại Khám *</label>
                  <select class="form-select" id="updateLoaiKham" v-model="update_kham_suc_khoe.loai_kham" required>
                    <option value="">Chọn loại khám</option>
                    <option value="1">Định kỳ</option>
                    <option value="0">Cấp cứu</option>
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

  computed: {
    totalStudents() {
      return this.list_kham_suc_khoe.length || 0;
    },
    healthStatusSummary() {
      return this.list_kham_suc_khoe.reduce(
        (acc, item) => {
          const key = this.normalizeHealthStatusKey(item.tinh_trang_suc_khoe);
          if (acc[key] !== undefined) {
            acc[key] += 1;
          } else {
            acc.unknown += 1;
          }
          return acc;
        },
        { good: 0, monitor: 0, intervention: 0, critical: 0, unknown: 0 }
      );
    },
    classHealthData() {
      // Group bởi id_hoc_sinh để lấy lần khám mới nhất
      const studentLatestExams = {};
      this.list_kham_suc_khoe.forEach((item) => {
        const studentId = item.id_hoc_sinh;
        if (!studentLatestExams[studentId] || new Date(item.ngay_kham) > new Date(studentLatestExams[studentId].ngay_kham)) {
          studentLatestExams[studentId] = item;
        }
      });

      // Group theo lớp với unique students
      const buckets = {};
      Object.values(studentLatestExams).forEach((item) => {
        const className = item.ten_lop || item.lop_hoc || "Chưa phân lớp";
        if (!buckets[className]) {
          buckets[className] = {
            total: 0,
            counts: { good: 0, monitor: 0, intervention: 0, critical: 0 },
          };
        }
        buckets[className].total += 1;
        const key = this.normalizeHealthStatusKey(item.tinh_trang_suc_khoe);
        if (buckets[className].counts[key] !== undefined) {
          buckets[className].counts[key] += 1;
        }
      });

      return Object.keys(buckets)
        .map((className) => {
          const bucket = buckets[className];
          const total = bucket.total || 0;
          const { good, monitor, intervention, critical } = bucket.counts;
          const toPercent = (count) => (total > 0 ? Math.round((count / total) * 100) : 0);
          return {
            className,
            totalStudents: total,
            goodCount: good,
            monitorCount: monitor,
            interventionCount: intervention,
            criticalCount: critical,
            goodPercentage: toPercent(good),
            monitorPercentage: toPercent(monitor),
            interventionPercentage: toPercent(intervention),
            criticalPercentage: toPercent(critical),
            healthPercentage: toPercent(good),
          };
        })
        .sort((a, b) => b.totalStudents - a.totalStudents) // Sắp xếp theo số học sinh giảm dần
        .slice(0, 3);
    },
    vaccinationCount() {
      return Math.floor(this.totalStudents * 0.8);
    },
    emergencyCount() {
      return this.list_kham_suc_khoe.filter(item => item.loai_kham == 0).length;
    },
    healthStatusDescriptor() {
      const descriptors = {
        good: {
          label: "Sức Khoẻ Tốt",
          icon: "fas fa-smile-beam",
          pillClass: "is-good",
        },
        monitor: {
          label: "Cần Theo Dõi",
          icon: "fas fa-exclamation-circle",
          pillClass: "is-monitor",
        },
        intervention: {
          label: "Cần Can Thiệp",
          icon: "fas fa-user-md",
          pillClass: "is-intervention",
        },
        unknown: {
          label: "Chưa rõ",
          icon: "fas fa-question-circle",
          pillClass: "is-unknown",
        },
      };
      return (status) => descriptors[this.normalizeHealthStatusKey(status)] || descriptors.unknown;
    },
  },

  methods: {
    formatDate(dateString) {
      if (!dateString) return "";
      const date = new Date(dateString);
      return date.toLocaleDateString("vi-VN");
    },

    normalizeHealthStatusKey(status) {
      const value = String(status ?? "").toLowerCase();
      if (["3", "good", "tot", "suc_khoe_tot"].includes(value)) return "good";
      if (["2", "monitor", "theo doi", "can_theo_doi"].includes(value)) return "monitor";
      if (["1", "intervention", "can thiep", "can_can_thiep"].includes(value)) return "intervention";
      if (["0", "critical", "nguy kich", "nguy_kich"].includes(value)) return "critical";
      return "unknown";
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
