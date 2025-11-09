<template>
  <div class="page-header education-theme">
    <div class="container-fluid">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="page-header-content">
            <div class="page-icon">
              <i class="fas fa-utensils"></i>
            </div>
            <div class="page-info">
              <h1 class="page-title">Quản lý Thực Đơn</h1>
              <p class="page-subtitle">
                Quản lý thực đơn và món ăn cho học sinh
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
                <i class="fas fa-utensils"></i>
                Thực Đơn
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
          <i class="fas fa-utensils"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">{{ getTotalMenus() }}</h3>
          <p class="stats-label">Tổng Thực Đơn</p>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="stats-card stats-success">
        <div class="stats-icon">
          <i class="fas fa-hamburger"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">{{ getTotalDishes() }}</h3>
          <p class="stats-label">Món Ăn</p>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="stats-card stats-warning">
        <div class="stats-icon">
          <i class="fas fa-calendar-week"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">{{ getWeeklyMenus() }}</h3>
          <p class="stats-label">Thực Đơn Tuần</p>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="stats-card stats-info">
        <div class="stats-icon">
          <i class="fas fa-star"></i>
        </div>
        <div class="stats-content">
          <h3 class="stats-number">{{ getAverageRating() }}</h3>
          <p class="stats-label">Đánh Giá TB</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Menu Dashboard Charts -->
  <div class="row mb-4">
    <div class="col-lg-8">
      <div class="dashboard-card">
        <div class="card-header-custom">
          <div class="header-content">
            <div class="header-icon">
              <i class="fas fa-chart-bar"></i>
            </div>
            <div class="header-text">
              <h5 class="card-title">Thực Đơn Theo Loại Bữa</h5>
              <p class="card-subtitle">Phân tích thực đơn theo từng loại bữa ăn</p>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="menu-chart-container">
            <div v-for="(mealData, index) in getMealTypeData()" :key="index" class="menu-chart-item">
              <div class="chart-header">
                <div class="meal-info">
                  <span class="meal-name">{{ mealData.mealName }}</span>
                  <span class="menu-count">{{ mealData.menuCount }} thực đơn</span>
                </div>
                <div class="menu-percentage">
                  <span class="percentage">{{ mealData.percentage }}%</span>
                  <small>tổng thực đơn</small>
                </div>
              </div>
              <div class="progress-container">
                <div class="progress-bar">
                  <div class="progress-fill" :style="{ width: mealData.percentage + '%' }"></div>
                </div>
                <div class="progress-labels">
                  <span class="label">{{ mealData.activeCount }} đang áp dụng</span>
                  <span class="label">{{ mealData.inactiveCount }} không áp dụng</span>
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
              <i class="fas fa-chart-pie"></i>
            </div>
            <div class="header-text">
              <h5 class="card-title">Thống Kê Món Ăn</h5>
              <p class="card-subtitle">Phân tích món ăn theo danh mục</p>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="dish-stats">
            <div class="stat-item">
              <div class="stat-icon">
                <i class="fas fa-drumstick-bite"></i>
              </div>
              <div class="stat-content">
                <div class="stat-title">Món chính</div>
                <div class="stat-value">{{ getDishCountByCategory('chinh') }} món</div>
                <div class="stat-status active">Đang sử dụng</div>
              </div>
            </div>
            <div class="stat-item">
              <div class="stat-icon">
                <i class="fas fa-leaf"></i>
              </div>
              <div class="stat-content">
                <div class="stat-title">Món phụ</div>
                <div class="stat-value">{{ getDishCountByCategory('phu') }} món</div>
                <div class="stat-status active">Đang sử dụng</div>
              </div>
            </div>
            <div class="stat-item">
              <div class="stat-icon">
                <i class="fas fa-bowl-food"></i>
              </div>
              <div class="stat-content">
                <div class="stat-title">Món canh</div>
                <div class="stat-value">{{ getDishCountByCategory('canh') }} món</div>
                <div class="stat-status active">Đang sử dụng</div>
              </div>
            </div>
            <div class="stat-item">
              <div class="stat-icon">
                <i class="fas fa-ice-cream"></i>
              </div>
              <div class="stat-content">
                <div class="stat-title">Tráng miệng</div>
                <div class="stat-value">{{ getDishCountByCategory('trangmieng') }} món</div>
                <div class="stat-status active">Đang sử dụng</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Weekly Menu Preview -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="dashboard-card">
        <div class="card-header-custom">
          <div class="header-content">
            <div class="header-icon">
              <i class="fas fa-calendar-week"></i>
            </div>
            <div class="header-text">
              <h5 class="card-title">Thực Đơn Tuần Này</h5>
              <p class="card-subtitle">Xem trước thực đơn trong tuần</p>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="weekly-menu-grid">
            <div v-for="day in getWeeklyMenuData()" :key="day.day" class="day-menu-card">
              <div class="day-header">
                <h6 class="day-name">{{ day.dayName }}</h6>
                <small class="day-date">{{ day.date }}</small>
              </div>
              <div class="day-meals">
                <div v-for="meal in day.meals" :key="meal.type" class="meal-item">
                  <div class="meal-type">{{ getMealTypeLabel(meal.type) }}</div>
                  <div class="dish-info">
                    <img :src="meal.dish.image" :alt="meal.dish.name" class="dish-image" />
                    <span class="dish-name">{{ meal.dish.name }}</span>
                  </div>
                </div>
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
              <i class="fas fa-utensils"></i>
            </div>
            <div class="header-text">
              <h5 class="card-title">Danh Sách Thực Đơn</h5>
              <p class="card-subtitle">Quản lý thông tin thực đơn và món ăn</p>
            </div>
          </div>
          <div class="header-actions">
            <button class="btn btn-success btn-modern" data-bs-toggle="modal" data-bs-target="#themModal">
              <i class="fas fa-plus"></i>
              Thêm Thực Đơn
            </button>
            <button class="btn btn-info btn-modern" data-bs-toggle="modal" data-bs-target="#themMonAnModal">
              <i class="fas fa-hamburger"></i>
              Thêm Món Ăn
            </button>
          </div>

          <!-- Modal Thêm Thực Đơn -->
          <div class="modal fade" id="themModal" tabindex="-1" aria-labelledby="themModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="themModalLabel">
                    <i class="fas fa-plus me-2"></i>
                    Thêm Thực Đơn
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form>
                    <div class="row">
                      <div class="col-md-6">
                        <label for="tenThucDon" class="form-label">Tên Thực Đơn *</label>
                        <input type="text" class="form-control" id="tenThucDon" v-model="create_thuc_don.ten_thuc_don"
                          required />
                      </div>
                      <div class="col-md-6">
                        <label for="loaiBua" class="form-label">Loại Bữa *</label>
                        <select class="form-select" id="loaiBua" v-model="create_thuc_don.loai_bua" required>
                          <option value="">Chọn loại bữa</option>
                          <option value="sang">Bữa sáng</option>
                          <option value="trua">Bữa trưa</option>
                          <option value="chieu">Bữa chiều</option>
                        </select>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <label for="ngayApDung" class="form-label">Ngày Áp Dụng *</label>
                        <input type="date" class="form-control" id="ngayApDung" v-model="create_thuc_don.ngay_ap_dung"
                          required />
                      </div>
                      <div class="col-md-6">
                        <label for="trangThai" class="form-label">Trạng Thái</label>
                        <select v-model="create_thuc_don.trang_thai" class="form-select">
                          <option value="active">Đang áp dụng</option>
                          <option value="inactive">Không áp dụng</option>
                        </select>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <label for="moTa" class="form-label">Mô Tả</label>
                        <textarea class="form-control" id="moTa" v-model="create_thuc_don.mo_ta" rows="3"
                          placeholder="Mô tả về thực đơn..."></textarea>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <label class="form-label">Chọn Món Ăn</label>
                        <div class="dish-selection">
                          <div v-for="dish in list_mon_an" :key="dish.id" class="dish-option">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" :value="dish.id" :id="'dish' + dish.id"
                                v-model="create_thuc_don.mon_an_ids">
                              <label class="form-check-label" :for="'dish' + dish.id">
                                <div class="dish-option-content">
                                  <img :src="dish.hinh_anh || '/default-dish.jpg'" :alt="dish.ten_mon"
                                    class="dish-option-image" />
                                  <div class="dish-option-info">
                                    <span class="dish-name">{{ dish.ten_mon }}</span>
                                    <small class="dish-category">{{ getDishCategoryLabel(dish.danh_muc) }}</small>
                                  </div>
                                </div>
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>
                    Hủy
                  </button>
                  <button type="button" class="btn btn-primary" @click="ThemThucDon" :disabled="loading">
                    <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
                    <i v-else class="fas fa-save me-1"></i>
                    {{ loading ? 'Đang xử lý...' : 'Thêm Thực Đơn' }}
                  </button>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal Thêm Món Ăn -->
          <div class="modal fade" id="themMonAnModal" tabindex="-1" aria-labelledby="themMonAnModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="themMonAnModalLabel">
                    <i class="fas fa-hamburger me-2"></i>
                    Thêm Món Ăn
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form>
                    <div class="row">
                      <div class="col-md-6">
                        <label for="tenMon" class="form-label">Tên Món Ăn *</label>
                        <input type="text" class="form-control" id="tenMon" v-model="create_mon_an.ten_mon" required />
                      </div>
                      <div class="col-md-6">
                        <label for="danhMuc" class="form-label">Danh Mục *</label>
                        <select class="form-select" id="danhMuc" v-model="create_mon_an.danh_muc" required>
                          <option value="">Chọn danh mục</option>
                          <option value="chinh">Món chính</option>
                          <option value="phu">Món phụ</option>
                          <option value="canh">Món canh</option>
                          <option value="trangmieng">Tráng miệng</option>
                        </select>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <label for="calories" class="form-label">Calories</label>
                        <input type="number" class="form-control" id="calories" v-model="create_mon_an.calories"
                          min="0" />
                      </div>
                      <div class="col-md-6">
                        <label for="gia" class="form-label">Giá (VNĐ)</label>
                        <input type="number" class="form-control" id="gia" v-model="create_mon_an.gia" min="0" />
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <label for="moTaMon" class="form-label">Mô Tả</label>
                        <textarea class="form-control" id="moTaMon" v-model="create_mon_an.mo_ta" rows="3"
                          placeholder="Mô tả về món ăn..."></textarea>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <label for="hinhAnh" class="form-label">Hình Ảnh</label>
                        <input type="file" class="form-control" id="hinhAnh" @change="handleImageUpload"
                          accept="image/*" />
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>
                    Hủy
                  </button>
                  <button type="button" class="btn btn-primary" @click="ThemMonAn" :disabled="loading">
                    <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
                    <i v-else class="fas fa-save me-1"></i>
                    {{ loading ? 'Đang xử lý...' : 'Thêm Món Ăn' }}
                  </button>
                </div>
              </div>
            </div>
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
                <input v-on:change="TiemKiem()" v-model="search.noi_dung" type="text" class="search-input"
                  placeholder="Tìm kiếm theo tên thực đơn..." />
              </div>

              <div class="search-filters">
                <select v-on:change="TiemKiem()" class="filter-select" v-model="search.loai_bua">
                  <option value="">Tất cả loại bữa</option>
                  <option value="sang">Bữa sáng</option>
                  <option value="trua">Bữa trưa</option>
                  <option value="chieu">Bữa chiều</option>
                </select>
                <select v-on:change="TiemKiem()" class="filter-select" v-model="search.trang_thai">
                  <option value="">Tất cả trạng thái</option>
                  <option value="active">Đang áp dụng</option>
                  <option value="inactive">Không áp dụng</option>
                </select>
                <select v-on:change="TiemKiem()" class="filter-select" v-model="search.ngay_ap_dung">
                  <option value="">Tất cả ngày</option>
                  <option value="today">Hôm nay</option>
                  <option value="week">Tuần này</option>
                  <option value="month">Tháng này</option>
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
                  <th>Thực Đơn</th>
                  <th class="text-center">Loại Bữa</th>
                  <th class="text-center">Ngày Áp Dụng</th>
                  <th class="text-center">Số Món</th>
                  <th class="text-center">Trạng Thái</th>
                  <th class="text-center">Thao Tác</th>
                </tr>
              </thead>
              <tbody>
                <template v-for="(value, index) in list_thuc_don" :key="index">
                  <tr class="table-row-hover">
                    <td class="text-center table-index">
                      {{ index + 1 }}
                    </td>
                    <td class="menu-info">
                      <div class="menu-container">
                        <div class="menu-image">
                          <img :src="value.hinh_anh || '/default-menu.jpg'" :alt="value.ten_thuc_don"
                            class="menu-img" />
                        </div>
                        <div class="menu-details">
                          <span class="menu-name">{{ value.ten_thuc_don }}</span>
                          <small class="menu-description">{{ value.mo_ta }}</small>
                        </div>
                      </div>
                    </td>
                    <td class="text-center">
                      <span class="meal-type-badge" :class="getMealTypeBadgeClass(value.loai_bua)">
                        <i :class="getMealTypeIcon(value.loai_bua)"></i>
                        {{ getMealTypeLabel(value.loai_bua) }}
                      </span>
                    </td>
                    <td class="text-center">
                      <div class="date-info">
                        <div class="date-text">{{ formatDate(value.ngay_ap_dung) }}</div>
                        <small class="date-status">{{ getDateStatus(value.ngay_ap_dung) }}</small>
                      </div>
                    </td>
                    <td class="text-center">
                      <div class="dish-count">
                        <div class="count-number">{{ value.so_mon }}</div>
                        <small class="count-label">món ăn</small>
                      </div>
                    </td>
                    <td class="text-center">
                      <span class="status-badge" :class="getStatusBadgeClass(value.trang_thai)">
                        <i :class="getStatusIcon(value.trang_thai)"></i>
                        {{ getStatusLabel(value.trang_thai) }}
                      </span>
                    </td>
                    <td class="text-center">
                      <div class="action-buttons">
                        <button class="btn-action btn-view" @click="viewMenuDetails(value)" title="Xem chi tiết">
                          <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn-action btn-edit" @click="openUpdateModal(value)" data-bs-toggle="modal"
                          data-bs-target="#capNhatModal" title="Chỉnh sửa">
                          <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-action btn-delete" @click="Object.assign(delete_thuc_don, value)"
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

  <!-- Modal Cập Nhật Thực Đơn -->
  <div class="modal fade" id="capNhatModal" tabindex="-1" aria-labelledby="capNhatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="capNhatModalLabel">
            <i class="fas fa-edit me-2"></i>
            Cập Nhật Thực Đơn
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateTenThucDon" class="form-label">Tên Thực Đơn *</label>
                  <input type="text" class="form-control" id="updateTenThucDon" v-model="update_thuc_don.ten_thuc_don"
                    required />
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateLoaiBua" class="form-label">Loại Bữa *</label>
                  <select class="form-select" id="updateLoaiBua" v-model="update_thuc_don.loai_bua" required>
                    <option value="">Chọn loại bữa</option>
                    <option value="sang">Bữa sáng</option>
                    <option value="trua">Bữa trưa</option>
                    <option value="chieu">Bữa chiều</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateNgayApDung" class="form-label">Ngày Áp Dụng *</label>
                  <input type="date" class="form-control" id="updateNgayApDung"
                    :value="formatDateForInput(update_thuc_don.ngay_ap_dung)"
                    @input="update_thuc_don.ngay_ap_dung = $event.target.value" required />
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="updateTrangThai" class="form-label">Trạng Thái</label>
                  <select v-model="update_thuc_don.trang_thai" class="form-select">
                    <option value="active">Đang áp dụng</option>
                    <option value="inactive">Không áp dụng</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="mb-3">
                  <label for="updateMoTa" class="form-label">Mô Tả</label>
                  <textarea class="form-control" id="updateMoTa" v-model="update_thuc_don.mo_ta" rows="3"
                    placeholder="Mô tả về thực đơn..."></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="mb-3">
                  <label class="form-label">Chọn Món Ăn</label>
                  <div class="dish-selection">
                    <div v-for="dish in list_mon_an" :key="dish.id" class="dish-option">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" :value="dish.id" :id="'update-dish' + dish.id"
                          v-model="update_thuc_don.mon_an_ids">
                        <label class="form-check-label" :for="'update-dish' + dish.id">
                          <div class="dish-option-content">
                            <img :src="dish.hinh_anh || '/default-dish.jpg'" :alt="dish.ten_mon"
                              class="dish-option-image" />
                            <div class="dish-option-info">
                              <span class="dish-name">{{ dish.ten_mon }}</span>
                              <small class="dish-category">{{ getDishCategoryLabel(dish.danh_muc) }}</small>
                            </div>
                          </div>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i>
            Hủy
          </button>
          <button type="button" class="btn btn-primary" @click="CapNhatThucDon" :disabled="loading">
            <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
            <i v-else class="fas fa-save me-1"></i>
            {{ loading ? 'Đang xử lý...' : 'Cập Nhật' }}
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Xóa Thực Đơn -->
  <div class="modal fade" id="xoaModal" tabindex="-1" aria-labelledby="xoaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="xoaModalLabel">
            <i class="fas fa-exclamation-triangle me-2 text-warning"></i>
            Xác Nhận Xóa Thực Đơn
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="text-center">
            <div class="mb-3">
              <i class="fas fa-utensils text-danger" style="font-size: 3rem;"></i>
            </div>
            <h6>Bạn có chắc chắn muốn xóa thực đơn này không?</h6>
            <div class="alert alert-warning" role="alert">
              <strong>Thông tin thực đơn:</strong><br>
              <strong>Tên:</strong> {{ delete_thuc_don.ten_thuc_don }}<br>
              <strong>Loại bữa:</strong> {{ getMealTypeLabel(delete_thuc_don.loai_bua) }}<br>
              <strong>Ngày áp dụng:</strong> {{ formatDate(delete_thuc_don.ngay_ap_dung) }}
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
          <button type="button" class="btn btn-danger" @click="XoaThucDon" :disabled="loading">
            <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
            <i v-else class="fas fa-trash me-1"></i>
            {{ loading ? 'Đang xử lý...' : 'Xóa Thực Đơn' }}
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Xem Chi Tiết Thực Đơn -->
  <div class="modal fade" id="xemChiTietModal" tabindex="-1" aria-labelledby="xemChiTietModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="xemChiTietModalLabel">
            <i class="fas fa-eye me-2"></i>
            Chi Tiết Thực Đơn
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
            @click="modalOpen = false"></button>
        </div>
        <div class="modal-body" v-if="detail_thuc_don && detail_thuc_don.ten_thuc_don">
          <div class="row mb-3">
            <div class="col-md-4">
              <img :src="detail_thuc_don.hinh_anh || '/default-menu.jpg'" :alt="detail_thuc_don.ten_thuc_don"
                class="img-fluid rounded" style="max-height: 200px; width: 100%; object-fit: cover;" />
            </div>
            <div class="col-md-8">
              <h5>{{ detail_thuc_don.ten_thuc_don }}</h5>
              <p class="text-muted">{{ detail_thuc_don.mo_ta }}</p>
              <div class="d-flex gap-3 mb-2">
                <span class="badge bg-primary">
                  <i :class="getMealTypeIcon(detail_thuc_don.loai_bua)"></i>
                  {{ getMealTypeLabel(detail_thuc_don.loai_bua) }}
                </span>
                <span class="badge" :class="detail_thuc_don.trang_thai === 'active' ? 'bg-success' : 'bg-secondary'">
                  {{ getStatusLabel(detail_thuc_don.trang_thai) }}
                </span>
              </div>
              <p class="mb-1"><strong>Ngày áp dụng:</strong> {{ formatDate(detail_thuc_don.ngay_ap_dung) }}</p>
              <p class="mb-0"><strong>Số món:</strong> {{ detail_thuc_don.so_mon || 0 }} món</p>
            </div>
          </div>
          <hr>
          <h6 class="mb-3">Danh Sách Món Ăn</h6>
          <div class="row" v-if="detail_thuc_don.mon_an && detail_thuc_don.mon_an.length > 0">
            <div v-for="dish in detail_thuc_don.mon_an" :key="dish.id" class="col-md-6 mb-3">
              <div class="card">
                <div class="card-body d-flex align-items-center">
                  <img :src="dish.hinh_anh || '/default-dish.jpg'" :alt="dish.ten_mon" class="me-3 rounded"
                    style="width: 60px; height: 60px; object-fit: cover;" />
                  <div>
                    <h6 class="mb-1">{{ dish.ten_mon }}</h6>
                    <small class="text-muted">{{ getDishCategoryLabel(dish.danh_muc) }}</small>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div v-else class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            Thực đơn này chưa có món ăn nào.
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="modalOpen = false">
            <i class="fas fa-times me-1"></i>
            Đóng
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
      list_thuc_don: [],
      list_mon_an: [],
      create_thuc_don: {
        ten_thuc_don: "",
        loai_bua: "",
        ngay_ap_dung: "",
        mo_ta: "",
        trang_thai: "active",
        mon_an_ids: [],
      },
      create_mon_an: {
        ten_mon: "",
        danh_muc: "",
        mo_ta: "",
        calories: "",
        gia: "",
        hinh_anh: "",
      },
      update_thuc_don: {
        id: "",
        ten_thuc_don: "",
        loai_bua: "",
        ngay_ap_dung: "",
        mo_ta: "",
        trang_thai: "",
        mon_an_ids: [],
      },
      delete_thuc_don: {
        id: "",
        ten_thuc_don: "",
        loai_bua: "",
        ngay_ap_dung: "",
      },
      detail_thuc_don: {},
      search: {
        noi_dung: "",
        loai_bua: "",
        trang_thai: "",
        ngay_ap_dung: "",
      },
      loading: false,
      modalOpen: false,
    };
  },

  mounted() {
    this.loadData();
    this.loadMonAn();
  },

  methods: {
    formatDate(dateString) {
      if (!dateString) return "";
      const date = new Date(dateString);
      return date.toLocaleDateString("vi-VN");
    },

    formatDateForInput(dateString) {
      if (!dateString) return "";
      const date = new Date(dateString);
      const year = date.getFullYear();
      const month = String(date.getMonth() + 1).padStart(2, '0');
      const day = String(date.getDate()).padStart(2, '0');
      return `${year}-${month}-${day}`;
    },

    getTotalMenus() {
      return this.list_thuc_don.length;
    },

    getTotalDishes() {
      return this.list_mon_an.length;
    },

    getWeeklyMenus() {
      const today = new Date();
      today.setHours(0, 0, 0, 0);
      const dayOfWeek = today.getDay();
      const weekStart = new Date(today);
      weekStart.setDate(today.getDate() - dayOfWeek);
      const weekEnd = new Date(weekStart);
      weekEnd.setDate(weekStart.getDate() + 6);
      weekEnd.setHours(23, 59, 59, 999);

      return this.list_thuc_don.filter(menu => {
        const menuDate = new Date(menu.ngay_ap_dung);
        menuDate.setHours(0, 0, 0, 0);
        return menuDate >= weekStart && menuDate <= weekEnd;
      }).length;
    },

    getAverageRating() {
      // Mock data for rating
      return "4.8";
    },

    getMealTypeData() {
      const mealTypes = [
        { type: 'sang', name: 'Bữa sáng' },
        { type: 'trua', name: 'Bữa trưa' },
        { type: 'chieu', name: 'Bữa chiều' }
      ];

      return mealTypes.map(mealType => {
        const menus = this.list_thuc_don.filter(menu => menu.loai_bua === mealType.type);
        const totalMenus = this.list_thuc_don.length;
        const activeMenus = menus.filter(menu => menu.trang_thai === 'active');
        const inactiveMenus = menus.filter(menu => menu.trang_thai === 'inactive');

        return {
          mealName: mealType.name,
          menuCount: menus.length,
          activeCount: activeMenus.length,
          inactiveCount: inactiveMenus.length,
          percentage: totalMenus > 0 ? Math.round((menus.length / totalMenus) * 100) : 0,
        };
      });
    },

    getDishCountByCategory(category) {
      return this.list_mon_an.filter(dish => dish.danh_muc === category).length;
    },

    getWeeklyMenuData() {
      const days = ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6'];
      const today = new Date();
      today.setHours(0, 0, 0, 0);
      const dayOfWeek = today.getDay();
      const weekStart = new Date(today);
      weekStart.setDate(today.getDate() - (dayOfWeek === 0 ? 6 : dayOfWeek - 1)); // Thứ 2 là ngày đầu tuần

      return days.map((dayName, index) => {
        const dayDate = new Date(weekStart);
        dayDate.setDate(weekStart.getDate() + index);
        dayDate.setHours(0, 0, 0, 0);

        // Tìm thực đơn cho ngày này
        const menusForDay = this.list_thuc_don.filter(menu => {
          const menuDate = new Date(menu.ngay_ap_dung);
          menuDate.setHours(0, 0, 0, 0);
          return menuDate.getTime() === dayDate.getTime() && menu.trang_thai === 'active';
        });

        // Nhóm món ăn theo loại bữa
        const meals = ['sang', 'trua', 'chieu'].map(mealType => {
          const menu = menusForDay.find(m => m.loai_bua === mealType);
          if (menu && menu.mon_an && menu.mon_an.length > 0) {
            const firstDish = menu.mon_an[0];
            return {
              type: mealType,
              dish: {
                name: firstDish.ten_mon || 'Chưa có',
                image: firstDish.hinh_anh || '/default-dish.jpg'
              }
            };
          }
          return {
            type: mealType,
            dish: {
              name: 'Chưa có',
              image: '/default-dish.jpg'
            }
          };
        });

        return {
          day: index,
          dayName,
          date: dayDate.toLocaleDateString('vi-VN', { day: '2-digit', month: '2-digit' }),
          meals
        };
      });
    },

    getMealTypeLabel(type) {
      const labels = {
        sang: 'Bữa sáng',
        trua: 'Bữa trưa',
        chieu: 'Bữa chiều'
      };
      return labels[type] || type;
    },

    getMealTypeBadgeClass(type) {
      return {
        'meal-sang': type === 'sang',
        'meal-trua': type === 'trua',
        'meal-chieu': type === 'chieu',
      };
    },

    getMealTypeIcon(type) {
      switch (type) {
        case 'sang':
          return 'fas fa-sun';
        case 'trua':
          return 'fas fa-sun';
        case 'chieu':
          return 'fas fa-moon';
        default:
          return 'fas fa-utensils';
      }
    },

    getDishCategoryLabel(category) {
      const labels = {
        chinh: 'Món chính',
        phu: 'Món phụ',
        canh: 'Món canh',
        trangmieng: 'Tráng miệng'
      };
      return labels[category] || category;
    },

    getStatusLabel(status) {
      switch (status) {
        case 'active':
          return 'Đang áp dụng';
        case 'inactive':
          return 'Không áp dụng';
        default:
          return 'Chưa rõ';
      }
    },

    getStatusBadgeClass(status) {
      return {
        'status-active': status === 'active',
        'status-inactive': status === 'inactive',
      };
    },

    getStatusIcon(status) {
      switch (status) {
        case 'active':
          return 'fas fa-check-circle';
        case 'inactive':
          return 'fas fa-times-circle';
        default:
          return 'fas fa-question';
      }
    },

    getDateStatus(dateString) {
      if (!dateString) return '';
      const date = new Date(dateString);
      date.setHours(0, 0, 0, 0);
      const today = new Date();
      today.setHours(0, 0, 0, 0);
      const dateTime = date.getTime();
      const todayTime = today.getTime();

      if (dateTime < todayTime) {
        return 'Đã qua';
      } else if (dateTime === todayTime) {
        return 'Hôm nay';
      } else {
        return 'Sắp tới';
      }
    },

    loadData() {
      baseRequestAdmin
        .get("admin/thuc-don/data")
        .then((res) => {
          if (res.data.status) {
            this.list_thuc_don = res.data.data;
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

    loadMonAn() {
      baseRequestAdmin
        .get("admin/mon-an/data")
        .then((res) => {
          if (res.data.status) {
            this.list_mon_an = res.data.data;
          }
        })
        .catch((err) => {
          console.log("Không thể tải danh sách món ăn");
        });
    },

    ThemThucDon() {
      this.loading = true;
      baseRequestAdmin
        .post("admin/thuc-don/create", this.create_thuc_don)
        .then((res) => {
          if (res.data.status) {
            this.$toast.success(res.data.message);
            this.loadData();
            this.resetCreateForm();
            // Đóng modal
            const modal = bootstrap.Modal.getInstance(document.getElementById("themModal"));
            if (modal) {
              modal.hide();
              this.modalOpen = false;
            }
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
            this.$toast.error("Có lỗi xảy ra khi thêm thực đơn");
          }
        })
        .finally(() => {
          this.loading = false;
        });
    },

    ThemMonAn() {
      this.loading = true;
      baseRequestAdmin
        .post("admin/mon-an/create", this.create_mon_an)
        .then((res) => {
          if (res.data.status) {
            this.$toast.success(res.data.message);
            this.loadMonAn();
            this.resetCreateMonAnForm();
            // Đóng modal
            const modal = bootstrap.Modal.getInstance(document.getElementById("themMonAnModal"));
            if (modal) {
              modal.hide();
              this.modalOpen = false;
            }
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
            this.$toast.error("Có lỗi xảy ra khi thêm món ăn");
          }
        })
        .finally(() => {
          this.loading = false;
        });
    },

    CapNhatThucDon() {
      this.loading = true;
      baseRequestAdmin
        .post("admin/thuc-don/update", this.update_thuc_don)
        .then((res) => {
          if (res.data.status) {
            this.$toast.success(res.data.message);
            this.loadData();
            // Đóng modal
            const modal = bootstrap.Modal.getInstance(document.getElementById("capNhatModal"));
            if (modal) {
              modal.hide();
              this.modalOpen = false;
            }
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
            this.$toast.error("Có lỗi xảy ra khi cập nhật thực đơn");
          }
        })
        .finally(() => {
          this.loading = false;
        });
    },

    XoaThucDon() {
      this.loading = true;
      baseRequestAdmin
        .post("admin/thuc-don/delete", this.delete_thuc_don)
        .then((res) => {
          if (res.data.status) {
            this.$toast.success(res.data.message);
            this.loadData();
            this.delete_thuc_don = {};
            // Đóng modal
            const modal = bootstrap.Modal.getInstance(document.getElementById("xoaModal"));
            if (modal) {
              modal.hide();
              this.modalOpen = false;
            }
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
            this.$toast.error("Có lỗi xảy ra khi xóa thực đơn");
          }
        })
        .finally(() => {
          this.loading = false;
        });
    },

    TiemKiem() {
      baseRequestAdmin
        .post("admin/thuc-don/search", this.search)
        .then((res) => {
          if (res.data.status) {
            this.$toast.success(res.data.message);
            this.list_thuc_don = res.data.data;
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

    viewMenuDetails(menu) {
      // Hiển thị thông tin chi tiết thực đơn trong modal
      this.modalOpen = true;
      this.detail_thuc_don = { ...menu };
      const modalElement = document.getElementById("xemChiTietModal");
      if (modalElement) {
        const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
        modal.show();
        // Reset modalOpen khi modal đóng
        modalElement.addEventListener('hidden.bs.modal', () => {
          this.modalOpen = false;
        }, { once: true });
      }
    },

    openUpdateModal(menu) {
      // Clone menu để tránh reference
      this.update_thuc_don = {
        id: menu.id || "",
        ten_thuc_don: menu.ten_thuc_don || "",
        loai_bua: menu.loai_bua || "",
        ngay_ap_dung: menu.ngay_ap_dung || "",
        mo_ta: menu.mo_ta || "",
        trang_thai: menu.trang_thai || "active",
        mon_an_ids: menu.mon_an_ids || menu.mon_an?.map(m => m.id) || [],
      };
    },

    handleImageUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.create_mon_an.hinh_anh = file;
      }
    },

    resetCreateForm() {
      this.create_thuc_don = {
        ten_thuc_don: "",
        loai_bua: "",
        ngay_ap_dung: "",
        mo_ta: "",
        trang_thai: "active",
        mon_an_ids: [],
      };
    },

    resetCreateMonAnForm() {
      this.create_mon_an = {
        ten_mon: "",
        danh_muc: "",
        mo_ta: "",
        calories: "",
        gia: "",
        hinh_anh: "",
      };
    },
  },
};
</script>

<style lang="scss">
@use "./style.scss";
</style>