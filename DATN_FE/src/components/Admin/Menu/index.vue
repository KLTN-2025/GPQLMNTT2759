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
          <h3 class="stats-number">{{ list_thuc_don.length }}</h3>
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
          <h3 class="stats-number">{{ list_mon_an.length }}</h3>
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
          <h3 class="stats-number">
            {{
              list_thuc_don.filter((menu) => {
                if (!menu.ngay_ap_dung) return false;
                const menuDate = new Date(menu.ngay_ap_dung);
                menuDate.setHours(0, 0, 0, 0);
                return (
                  menuDate.getTime() >= currentWeekRange.start.getTime() &&
                  menuDate.getTime() <= currentWeekRange.end.getTime());
              }).length}} </h3>
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
          <h3 class="stats-number">{{ averageRating }}</h3>
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
            <div v-for="(mealData, index) in mealTypeStats" :key="mealData.type || index" class="menu-chart-item">
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
      <div class="dashboard-card h-100">
        <div class="card-header-custom">
          <div class="header-content">
            <div class="header-icon">
              <i class="fas fa-chart-pie"></i>
            </div>
            <div class="header-text">
              <h5 class="card-title">Phân Loại Món Ăn</h5>
              <p class="card-subtitle">{{ list_mon_an.length }} món trong thực đơn</p>
            </div>
          </div>
        </div>
        <div class="card-body p-4">
          <!-- Món chính -->
          <div class="dish-category-item mb-4">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <div class="d-flex align-items-center gap-2">
                <div class="category-icon category-icon-main">
                  <i class="fas fa-drumstick-bite"></i>
                </div>
                <span class="category-label fw-semibold">Món chính</span>
              </div>
              <div class="d-flex align-items-center gap-2">
                <span class="category-count">{{ dishCategoryCounts.chinh }}</span>
                <span class="category-percentage text-muted">{{ calculateDishPercentage(dishCategoryCounts.chinh)
                  }}%</span>
              </div>
            </div>
            <div class="progress" style="height: 8px; border-radius: 10px;">
              <div class="progress-bar bg-primary" role="progressbar"
                :style="{ width: calculateDishPercentage(dishCategoryCounts.chinh) + '%' }"
                :aria-valuenow="calculateDishPercentage(dishCategoryCounts.chinh)" aria-valuemin="0"
                aria-valuemax="100">
              </div>
            </div>
          </div>

          <!-- Món phụ -->
          <div class="dish-category-item mb-4">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <div class="d-flex align-items-center gap-2">
                <div class="category-icon category-icon-side">
                  <i class="fas fa-leaf"></i>
                </div>
                <span class="category-label fw-semibold">Món phụ</span>
              </div>
              <div class="d-flex align-items-center gap-2">
                <span class="category-count">{{ dishCategoryCounts.phu }}</span>
                <span class="category-percentage text-muted">{{ calculateDishPercentage(dishCategoryCounts.phu)
                  }}%</span>
              </div>
            </div>
            <div class="progress" style="height: 8px; border-radius: 10px;">
              <div class="progress-bar bg-success" role="progressbar"
                :style="{ width: calculateDishPercentage(dishCategoryCounts.phu) + '%' }"
                :aria-valuenow="calculateDishPercentage(dishCategoryCounts.phu)" aria-valuemin="0" aria-valuemax="100">
              </div>
            </div>
          </div>

          <!-- Món canh -->
          <div class="dish-category-item mb-4">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <div class="d-flex align-items-center gap-2">
                <div class="category-icon category-icon-soup">
                  <i class="fas fa-bowl-food"></i>
                </div>
                <span class="category-label fw-semibold">Món canh</span>
              </div>
              <div class="d-flex align-items-center gap-2">
                <span class="category-count">{{ dishCategoryCounts.canh }}</span>
                <span class="category-percentage text-muted">{{ calculateDishPercentage(dishCategoryCounts.canh)
                  }}%</span>
              </div>
            </div>
            <div class="progress" style="height: 8px; border-radius: 10px;">
              <div class="progress-bar bg-info" role="progressbar"
                :style="{ width: calculateDishPercentage(dishCategoryCounts.canh) + '%' }"
                :aria-valuenow="calculateDishPercentage(dishCategoryCounts.canh)" aria-valuemin="0" aria-valuemax="100">
              </div>
            </div>
          </div>

          <!-- Tráng miệng -->
          <div class="dish-category-item mb-4">
            <div class="d-flex align-items-center justify-content-between mb-2">
              <div class="d-flex align-items-center gap-2">
                <div class="category-icon category-icon-dessert">
                  <i class="fas fa-ice-cream"></i>
                </div>
                <span class="category-label fw-semibold">Tráng miệng</span>
              </div>
              <div class="d-flex align-items-center gap-2">
                <span class="category-count">{{ dishCategoryCounts.trangmieng }}</span>
                <span class="category-percentage text-muted">{{ calculateDishPercentage(dishCategoryCounts.trangmieng)
                  }}%</span>
              </div>
            </div>
            <div class="progress" style="height: 8px; border-radius: 10px;">
              <div class="progress-bar bg-warning" role="progressbar"
                :style="{ width: calculateDishPercentage(dishCategoryCounts.trangmieng) + '%' }"
                :aria-valuenow="calculateDishPercentage(dishCategoryCounts.trangmieng)" aria-valuemin="0"
                aria-valuemax="100">
              </div>
            </div>
          </div>

          <!-- Summary Footer -->
          <div class="pt-3 mt-2 border-top">
            <div class="d-flex align-items-center justify-content-between">
              <div class="d-flex align-items-center gap-2">
                <i class="fas fa-check-circle text-success"></i>
                <small class="text-muted">Tất cả đang hoạt động</small>
              </div>
              <div>
                <span class="badge bg-light text-dark border">
                  <i class="fas fa-utensils me-1"></i>
                  {{ list_mon_an.length }} món
                </span>
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
              <h5 class="card-title">Thực Đơn Theo Tuần</h5>
              <p class="card-subtitle">Quản lý thực đơn theo từng tuần</p>
            </div>
          </div>
          <div class="header-actions">
            <button class="btn btn-week-nav" @click="changeWeek(-1)">
              <i class="fas fa-chevron-left"></i> Tuần trước
            </button>
            <button class="btn btn-week-nav" @click="changeWeek(1)">
              Tuần sau <i class="fas fa-chevron-right"></i>
            </button>
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
          <div class="modal fade" id="themModal" tabindex="-1" aria-labelledby="themModalLabel" aria-hidden="true"
            @hidden.bs.modal="dishSearchQuery = ''">
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
                        <select class="form-select" id="loaiBua" v-model="create_thuc_don.id_bua_an" required>
                          <option value="">Chọn loại bữa</option>
                          <option value="1">Bữa sáng</option>
                          <option value="2">Bữa phụ sáng</option>
                          <option value="3">Bữa trưa</option>
                          <option value="4">Bữa phụ chiều</option>
                          <option value="5">Bữa chiều</option>
                        </select>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <label for="ngayApDung" class="form-label">Ngày Áp Dụng *</label>
                        <input type="date" class="form-control" id="ngayApDung" v-model="create_thuc_don.ngay"
                          required />
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
                        <div class="mb-3">
                          <label class="form-label">Chọn Món Ăn *</label>
                          <div class="dish-selection-header mb-3">
                            <div class="dish-search">
                              <div class="search-icon">
                                <i class="fas fa-search"></i>
                              </div>
                              <input type="text" class="form-control" v-model="dishSearchQuery"
                                placeholder="Tìm kiếm món ăn..." />
                            </div>
                            <div class="dish-selection-info">
                              <span class="selected-count">
                                Đã chọn: <strong>{{ create_thuc_don.id_mon_ans?.length || 0 }}</strong> món
                              </span>
                            </div>
                          </div>
                          <div class="dish-selection" v-if="filteredDishes.length > 0">
                            <div v-for="dish in filteredDishes" :key="dish.id" class="dish-option">
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" :value="dish.id" :id="'dish-' + dish.id"
                                  v-model="create_thuc_don.id_mon_ans">
                                <label class="form-check-label" :for="'dish-' + dish.id">
                                  <div class="dish-option-content">
                                    <div class="dish-image-wrapper">
                                      <img :src="dish.hinh_anh || '/default-dish.jpg'" :alt="dish.ten_mon"
                                        class="dish-option-image" />
                                      <div class="dish-check-overlay"
                                        v-if="create_thuc_don.id_mon_ans?.includes(dish.id)">
                                        <i class="fas fa-check"></i>
                                      </div>
                                    </div>
                                    <div class="dish-option-info">
                                      <span class="dish-name">{{ dish.ten_mon }}</span>
                                      <small class="dish-category">
                                        <i class="fas fa-tag"></i>
                                        {{ dishCategoryLabels[dish.danh_muc] || dish.danh_muc }}
                                      </small>
                                      <small class="dish-type" v-if="dish.loai_mon">
                                        <i class="fas fa-utensils"></i>
                                        {{ dish.loai_mon }}
                                      </small>
                                    </div>
                                  </div>
                                </label>
                              </div>
                            </div>
                          </div>
                          <div class="dish-empty-state" v-else>
                            <i class="fas fa-utensils fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-0">
                              {{ dishSearchQuery ? 'Không tìm thấy món ăn nào' : 'Chưa có món ăn nào' }}
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="dishSearchQuery = ''">
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
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="themMonAnModalLabel">
                    <i class="fas fa-plus me-2"></i>
                    Thêm Món Ăn Mới
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="mb-3">
                          <label for="tenMon" class="form-label">Tên Món *</label>
                          <input type="text" class="form-control" id="tenMon" v-model="create_mon_an.ten_mon"
                            required />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label for="loaiMon" class="form-label">Loại Món *</label>
                          <input type="text" class="form-control" id="loaiMon" v-model="create_mon_an.loai_mon"
                            placeholder="VD: Cháo, Cơm, Phở..." required />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label for="nguonGoc" class="form-label">Nguồn Gốc</label>
                          <input type="text" class="form-control" id="nguonGoc" v-model="create_mon_an.nguon_goc"
                            placeholder="VD: Việt Nam" />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="mb-3">
                          <label for="moTa" class="form-label">Mô Tả</label>
                          <textarea class="form-control" id="moTa" v-model="create_mon_an.mo_ta" rows="3"
                            placeholder="Nhập mô tả về món ăn..."></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="mb-3">
                          <label for="ghiChu" class="form-label">Ghi Chú</label>
                          <textarea class="form-control" id="ghiChu" v-model="create_mon_an.ghi_chu" rows="2"
                            placeholder="Nhập ghi chú về món ăn..."></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3">
                        <div class="mb-3">
                          <label for="calo" class="form-label">Calo (kcal)</label>
                          <input type="number" class="form-control" id="calo" v-model="create_mon_an.calo" min="0" />
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="mb-3">
                          <label for="protein" class="form-label">Protein (g)</label>
                          <input type="number" class="form-control" id="protein" v-model="create_mon_an.protein" min="0"
                            step="0.1" />
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="mb-3">
                          <label for="carb" class="form-label">Carb (g)</label>
                          <input type="number" class="form-control" id="carb" v-model="create_mon_an.carb" min="0"
                            step="0.1" />
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="mb-3">
                          <label for="fat" class="form-label">Fat (g)</label>
                          <input type="number" class="form-control" id="fat" v-model="create_mon_an.fat" min="0"
                            step="0.1" />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="mb-3">
                          <label for="hinhAnh" class="form-label">Hình Ảnh</label>
                          <input type="file" class="form-control" id="hinhAnh" accept="image/*"
                            @change="(e) => { const file = e.target.files[0]; if (file) { this.create_mon_an.hinh_anh = file; const reader = new FileReader(); reader.onload = (evt) => { this.create_mon_an.imagePreview = evt.target.result; }; reader.readAsDataURL(file); } }" />
                          <small class="form-text text-muted">Chọn hình ảnh cho món ăn</small>
                        </div>
                      </div>
                    </div>
                    <div v-if="create_mon_an.imagePreview" class="row">
                      <div class="col-md-12">
                        <div class="mb-3">
                          <label class="form-label">Xem Trước Hình Ảnh</label>
                          <div class="image-preview">
                            <img :src="create_mon_an.imagePreview" alt="Preview" class="preview-image" />
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
          <div v-if="loading" class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Đang tải...</span>
            </div>
          </div>
          <div v-else>
            <div class="week-title">{{ weekTitle }}</div>
            <div class="schedule-calendar">
              <!-- Header: Ngày -->
              <div class="schedule-header-row">
                <div class="schedule-shift-column">Bữa Ăn</div>
                <div class="schedule-day-header" v-for="day in weekDays" :key="day.name">
                  <div class="day-name">{{ day.name }}</div>
                  <div class="day-date">{{ day.date }}</div>
                </div>
              </div>

              <!-- Content: Bữa sáng -->
              <div class="schedule-content-row">
                <div class="schedule-shift-label schedule-shift-morning">
                  <i class="fas fa-sun"></i>
                  <span>Bữa sáng</span>
                </div>
                <div class="schedule-cell" v-for="(day, idx) in weekDays" :key="'sang-' + idx">
                  <div v-if="getMenuForDay(day.date, 'sang')" class="schedule-item schedule-morning schedule-registered"
                    @click="viewMenuDetails(getMenuForDay(day.date, 'sang'))">
                    <div class="menu-item-content">
                      <div class="menu-item-name">{{ getMenuForDay(day.date, 'sang').ten_thuc_don }}</div>
                      <div class="menu-item-dishes">{{ getMenuForDay(day.date, 'sang').so_mon || 0 }} món</div>
                      <div class="schedule-status-success">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ statusMeta[getMenuForDay(day.date, 'sang').trang_thai]?.label || 'Đang áp dụng'
                        }}</span>
                      </div>
                    </div>
                  </div>
                  <div v-else class="schedule-empty-cell schedule-add" @click="openAddModalForDay(day.date, 'sang')"
                    title="Nhấn để thêm thực đơn">
                    <i class="fas fa-plus"></i>
                    <span class="add-text">Thêm thực đơn</span>
                  </div>
                </div>
              </div>

              <!-- Content: Bữa trưa -->
              <div class="schedule-content-row">
                <div class="schedule-shift-label schedule-shift-afternoon">
                  <i class="fas fa-sun"></i>
                  <span>Bữa trưa</span>
                </div>
                <div class="schedule-cell" v-for="(day, idx) in weekDays" :key="'trua-' + idx">
                  <div v-if="getMenuForDay(day.date, 'trua')"
                    class="schedule-item schedule-afternoon schedule-registered"
                    @click="viewMenuDetails(getMenuForDay(day.date, 'trua'))">
                    <div class="menu-item-content">
                      <div class="menu-item-name">{{ getMenuForDay(day.date, 'trua').ten_thuc_don }}</div>
                      <div class="menu-item-dishes">{{ getMenuForDay(day.date, 'trua').so_mon || 0 }} món</div>
                      <div class="schedule-status-success">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ statusMeta[getMenuForDay(day.date, 'trua').trang_thai]?.label || 'Đang áp dụng'
                        }}</span>
                      </div>
                    </div>
                  </div>
                  <div v-else class="schedule-empty-cell schedule-add" @click="openAddModalForDay(day.date, 'trua')"
                    title="Nhấn để thêm thực đơn">
                    <i class="fas fa-plus"></i>
                    <span class="add-text">Thêm thực đơn</span>
                  </div>
                </div>
              </div>

              <!-- Content: Bữa chiều -->
              <div class="schedule-content-row">
                <div class="schedule-shift-label schedule-shift-evening">
                  <i class="fas fa-moon"></i>
                  <span>Bữa chiều</span>
                </div>
                <div class="schedule-cell" v-for="(day, idx) in weekDays" :key="'chieu-' + idx">
                  <div v-if="getMenuForDay(day.date, 'chieu')"
                    class="schedule-item schedule-evening schedule-registered"
                    @click="viewMenuDetails(getMenuForDay(day.date, 'chieu'))">
                    <div class="menu-item-content">
                      <div class="menu-item-name">{{ getMenuForDay(day.date, 'chieu').ten_thuc_don }}</div>
                      <div class="menu-item-dishes">{{ getMenuForDay(day.date, 'chieu').so_mon || 0 }} món</div>
                      <div class="schedule-status-success">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ statusMeta[getMenuForDay(day.date, 'chieu').trang_thai]?.label || 'Đang áp dụng'
                        }}</span>
                      </div>
                    </div>
                  </div>
                  <div v-else class="schedule-empty-cell schedule-add" @click="openAddModalForDay(day.date, 'chieu')"
                    title="Nhấn để thêm thực đơn">
                    <i class="fas fa-plus"></i>
                    <span class="add-text">Thêm thực đơn</span>
                  </div>
                </div>
              </div>
            </div>
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
                              <small class="dish-category">{{ dishCategoryLabels[dish.danh_muc] || dish.danh_muc
                              }}</small>
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
              <strong>Loại bữa:</strong> {{ mealTypeLabels[delete_thuc_don.loai_bua] || delete_thuc_don.loai_bua }}<br>
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
                  <i :class="mealTypeIcons[detail_thuc_don.loai_bua] || 'fas fa-utensils'"></i>
                  {{ mealTypeLabels[detail_thuc_don.loai_bua] || detail_thuc_don.loai_bua }}
                </span>
                <span class="badge" :class="detail_thuc_don.trang_thai === 'active' ? 'bg-success' : 'bg-secondary'">
                  {{ statusMeta[detail_thuc_don.trang_thai]?.label || 'Chưa rõ' }}
                </span>
              </div>
              <p class="mb-1"><strong>Ngày áp dụng:</strong> {{ formatDate(detail_thuc_don.ngay_ap_dung) }}</p>
              <p class="mb-0"><strong>Số món:</strong> {{ detail_thuc_don.so_mon || 0 }} món</p>
            </div>
          </div>
          <hr>
          <h6 class="mb-3">Danh Sách Món Ăn</h6>
          <div class="row" v-if="detail_thuc_don.mon_an && detail_thuc_don.mon_an.length > 0">
            <div v-for="dish in detail_thuc_don.mon_an" :key="dish.id" class="col-md-12 mb-3">
              <div class="card dish-card">
                <div class="card-body">
                  <div class="d-flex align-items-start mb-3">
                    <img :src="dish.hinh_anh || '/default-dish.jpg'" :alt="dish.ten_mon" class="me-3 rounded"
                      style="width: 80px; height: 80px; object-fit: cover;" />
                    <div class="flex-grow-1">
                      <h6 class="mb-1">{{ dish.ten_mon }}</h6>
                      <small class="text-muted">{{ dishCategoryLabels[dish.danh_muc] || dish.loai_mon }}</small>
                      <p v-if="dish.mo_ta" class="text-muted small mt-1 mb-0">{{ dish.mo_ta }}</p>
                    </div>
                  </div>

                  <!-- Nutritional Information -->
                  <div class="nutrition-info" v-if="dish.calo || dish.protein || dish.carb || dish.fat">
                    <div class="row g-2">
                      <div class="col-6 col-md-3" v-if="dish.calo">
                        <div class="nutrition-card nutrition-calo">
                          <div class="nutrition-icon">🔥</div>
                          <div class="nutrition-content">
                            <div class="nutrition-value">{{ dish.calo }}</div>
                            <div class="nutrition-label">kcal</div>
                          </div>
                        </div>
                      </div>
                      <div class="col-6 col-md-3" v-if="dish.protein">
                        <div class="nutrition-card nutrition-protein">
                          <div class="nutrition-icon">💪</div>
                          <div class="nutrition-content">
                            <div class="nutrition-value">{{ dish.protein }}</div>
                            <div class="nutrition-label">Protein (g)</div>
                          </div>
                        </div>
                      </div>
                      <div class="col-6 col-md-3" v-if="dish.carb">
                        <div class="nutrition-card nutrition-carb">
                          <div class="nutrition-icon">🍚</div>
                          <div class="nutrition-content">
                            <div class="nutrition-value">{{ dish.carb }}</div>
                            <div class="nutrition-label">Carbs (g)</div>
                          </div>
                        </div>
                      </div>
                      <div class="col-6 col-md-3" v-if="dish.fat">
                        <div class="nutrition-card nutrition-fat">
                          <div class="nutrition-icon">🥑</div>
                          <div class="nutrition-content">
                            <div class="nutrition-value">{{ dish.fat }}</div>
                            <div class="nutrition-label">Fat (g)</div>
                          </div>
                        </div>
                      </div>
                    </div>
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
          <button type="button" class="btn btn-primary" @click="openUpdateModal(detail_thuc_don)">
            <i class="fas fa-edit me-1"></i>
            Sửa Thực Đơn
          </button>
          <button type="button" class="btn btn-danger" @click="openDeleteModal(detail_thuc_don)">
            <i class="fas fa-trash me-1"></i>
            Xóa Thực Đơn
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
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    const sundayStart = new Date(today);
    sundayStart.setDate(today.getDate() - today.getDay());
    const sundayEnd = new Date(sundayStart);
    sundayEnd.setDate(sundayStart.getDate() + 6);
    sundayEnd.setHours(23, 59, 59, 999);
    const mondayStart = new Date(today);
    mondayStart.setDate(today.getDate() - (today.getDay() === 0 ? 6 : today.getDay() - 1));
    mondayStart.setHours(0, 0, 0, 0);

    return {
      list_thuc_don: [],
      list_mon_an: [],
      create_thuc_don: {
        ten_thuc_don: "",
        id_bua_an: "",
        ngay: "",
        mo_ta: "",
        trang_thai: "active",
        id_mon_ans: [],
      },
      create_mon_an: {
        ten_mon: "",
        loai_mon: "",
        mo_ta: "",
        ghi_chu: "",
        nguon_goc: "",
        calo: "",
        protein: "",
        carb: "",
        fat: "",
        hinh_anh: null,
        imagePreview: null,
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
      dishSearchQuery: "",
      mealTypeDefinitions: [
        { type: "sang", name: "Bữa sáng", icon: "fas fa-sun", badge: "meal-sang" },
        { type: "trua", name: "Bữa trưa", icon: "fas fa-sun", badge: "meal-trua" },
        { type: "chieu", name: "Bữa chiều", icon: "fas fa-moon", badge: "meal-chieu" },
      ],
      mealTypeLabels: {
        sang: "Bữa sáng",
        trua: "Bữa trưa",
        chieu: "Bữa chiều",
      },
      mealTypeBadges: {
        sang: "meal-sang",
        trua: "meal-trua",
        chieu: "meal-chieu",
      },
      mealTypeIcons: {
        sang: "fas fa-sun",
        trua: "fas fa-sun",
        chieu: "fas fa-moon",
      },
      dishCategoryLabels: {
        chinh: "Món chính",
        phu: "Món phụ",
        canh: "Món canh",
        trangmieng: "Tráng miệng",
      },
      dishCategoryCounts: {
        chinh: 0,
        phu: 0,
        canh: 0,
        trangmieng: 0,
      },
      statusMeta: {
        active: {
          label: "Đang áp dụng",
          icon: "fas fa-check-circle",
          badge: "status-active",
        },
        inactive: {
          label: "Không áp dụng",
          icon: "fas fa-times-circle",
          badge: "status-inactive",
        },
      },
      defaultDishImage: "/default-dish.jpg",
      averageRating: "4.8",
      mealTypeStats: [],
      weeklyMenuPreview: [],
      weeklyDays: ["Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6"],
      currentWeekRange: {
        start: sundayStart,
        end: sundayEnd,
      },
      weekStartMonday: mondayStart,
      currentWeek: new Date(),
    };
  },

  computed: {
    weekTitle() {
      const start = this.getWeekStart(this.currentWeek);
      const end = new Date(start);
      end.setDate(start.getDate() + 4); // Thứ 2 đến Thứ 6 (5 ngày)
      return `${this.formatDateForDisplay(start)} - ${this.formatDateForDisplay(end)}`;
    },
    weekDays() {
      const start = this.getWeekStart(this.currentWeek);
      const days = ['Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6'];
      return days.map((name, index) => {
        const date = new Date(start);
        date.setDate(start.getDate() + index);
        return {
          name,
          date: this.formatDateForDisplay(date),
          dateObj: date
        };
      });
    },
    filteredDishes() {
      if (!this.dishSearchQuery) {
        return this.list_mon_an;
      }
      const query = this.dishSearchQuery.toLowerCase();
      return this.list_mon_an.filter(dish => {
        const nameMatch = dish.ten_mon?.toLowerCase().includes(query);
        const categoryMatch = this.dishCategoryLabels[dish.danh_muc]?.toLowerCase().includes(query);
        const typeMatch = dish.loai_mon?.toLowerCase().includes(query);
        return nameMatch || categoryMatch || typeMatch;
      });
    },
  },

  mounted() {
    this.loadData();
    this.loadMonAn();
  },

  methods: {
    getWeekStart(date) {
      const d = new Date(date);
      const day = d.getDay();
      const diff = d.getDate() - day + (day === 0 ? -6 : 1); // Thứ 2 là ngày đầu tuần
      d.setDate(diff);
      d.setHours(0, 0, 0, 0);
      return d;
    },
    formatDateForDisplay(date) {
      if (!date) return "";
      const dateObj = date instanceof Date ? date : new Date(date);
      return dateObj.toLocaleDateString('vi-VN', { day: '2-digit', month: '2-digit', year: 'numeric' });
    },
    calculateDishPercentage(count) {
      const total = this.list_mon_an.length || 0;
      if (total === 0) return 0;
      return Math.round((count / total) * 100);
    },
    formatDateForAPI(date) {
      if (!date) return "";
      const dateObj = date instanceof Date ? date : new Date(date);
      const year = dateObj.getFullYear();
      const month = String(dateObj.getMonth() + 1).padStart(2, '0');
      const day = String(dateObj.getDate()).padStart(2, '0');
      return `${year}-${month}-${day}`;
    },
    changeWeek(step) {
      const n = new Date(this.currentWeek);
      n.setDate(n.getDate() + step * 7);
      this.currentWeek = n;
      this.loadData();
    },
    getMenuForDay(dateStr, loaiBua) {
      return this.list_thuc_don.find(menu => {
        if (menu.loai_bua !== loaiBua) return false;
        if (!menu.ngay_ap_dung) return false;
        const menuDate = this.formatDateForDisplay(new Date(menu.ngay_ap_dung));
        return menuDate === dateStr;
      });
    },
    openAddModalForDay(dateStr, loaiBua) {
      // Convert dateStr từ format dd/mm/yyyy sang yyyy-mm-dd
      const parts = dateStr.split('/');
      const ngayApDung = `${parts[2]}-${parts[1]}-${parts[0]}`;

      // Map loại bữa (sang/trua/chieu) sang ID bữa ăn
      const mealTypeToId = {
        'sang': 1,      // Bữa sáng
        'trua': 3,      // Bữa trưa  
        'chieu': 5      // Bữa chiều
      };

      this.create_thuc_don.ngay = ngayApDung;
      this.create_thuc_don.id_bua_an = mealTypeToId[loaiBua] || '';

      const modal = new bootstrap.Modal(document.getElementById('themModal'));
      modal.show();
    },
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

    loadData() {
      baseRequestAdmin
        .get("admin/thuc-don/data")
        .then((res) => {
          if (res.data.status) {
            // Map backend data to frontend format
            this.list_thuc_don = (res.data.data || []).map(menu => {
              // Map id_bua_an sang loại bữa (sang/trua/chieu)
              const idToMealType = {
                1: 'sang',   // Bữa sáng
                2: 'sang',   // Bữa phụ sáng -> cũng là sáng
                3: 'trua',   // Bữa trưa
                4: 'chieu',  // Bữa phụ chiều -> cũng là chiều
                5: 'chieu'   // Bữa chiều
              };

              const loaiBua = idToMealType[menu.id_bua_an] || '';

              return {
                id: menu.id,
                ten_thuc_don: menu.ten_thuc_don,
                mo_ta: menu.mo_ta,
                ngay_ap_dung: menu.ngay, // Map 'ngay' -> 'ngay_ap_dung'
                loai_bua: loaiBua,
                id_bua_an: menu.id_bua_an,
                so_mon: menu.so_mon || 0,
                mon_an: menu.mon_ans || [], // Danh sách món ăn
                trang_thai: 'active', // Default status
              };
            });

            this.$toast.success(res.data.message);
            const totalMenus = this.list_thuc_don.length || 0;
            this.mealTypeStats = this.mealTypeDefinitions.map((definition) => {
              const menus = this.list_thuc_don.filter(
                (menu) => menu.loai_bua === definition.type
              );
              const activeCount = menus.filter((menu) => menu.trang_thai === "active").length;
              return {
                ...definition,
                mealName: definition.name,
                menuCount: menus.length,
                activeCount,
                inactiveCount: menus.length - activeCount,
                percentage: totalMenus > 0 ? Math.round((menus.length / totalMenus) * 100) : 0,
              };
            });
            this.weeklyMenuPreview = this.weeklyDays.map((dayName, index) => {
              const dayDate = new Date(this.weekStartMonday);
              dayDate.setDate(this.weekStartMonday.getDate() + index);
              dayDate.setHours(0, 0, 0, 0);
              const menusForDay = this.list_thuc_don.filter((menu) => {
                if (!menu.ngay_ap_dung) return false;
                const menuDate = new Date(menu.ngay_ap_dung);
                menuDate.setHours(0, 0, 0, 0);
                return (
                  menuDate.getTime() === dayDate.getTime() && menu.trang_thai === "active"
                );
              });
              const meals = ["sang", "trua", "chieu"].map((mealType) => {
                const menu = menusForDay.find((item) => item.loai_bua === mealType);
                const dish =
                  menu && Array.isArray(menu.mon_an) && menu.mon_an.length > 0
                    ? menu.mon_an[0]
                    : {};
                return {
                  type: mealType,
                  dish: {
                    name: dish.ten_mon || "Chưa có",
                    image: dish.hinh_anh || this.defaultDishImage,
                  },
                };
              });
              return {
                day: index,
                dayName,
                date: dayDate.toLocaleDateString("vi-VN", {
                  day: "2-digit",
                  month: "2-digit",
                }),
                meals,
              };
            });
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
            this.list_mon_an = res.data.data || [];
            this.dishCategoryCounts = ["chinh", "phu", "canh", "trangmieng"].reduce(
              (acc, category) => {
                acc[category] = this.list_mon_an.filter(
                  (dish) => dish.danh_muc === category
                ).length;
                return acc;
              },
              { chinh: 0, phu: 0, canh: 0, trangmieng: 0 }
            );
          }
        })
        .catch((err) => {
          console.log("Không thể tải danh sách món ăn");
        });
    },

    ThemThucDon() {
      this.loading = true;

      // Debug: Log dữ liệu trước khi gửi
      console.log('=== DEBUG: Thêm Thực Đơn ===');
      console.log('Data gửi đi:', JSON.stringify(this.create_thuc_don, null, 2));

      baseRequestAdmin
        .post("admin/thuc-don/create", this.create_thuc_don)
        .then((res) => {
          console.log('Response từ server:', res.data);
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
          console.error('Lỗi khi tạo thực đơn:', err.response?.data || err);
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
      // Validate
      if (!this.create_mon_an.ten_mon) {
        this.$toast.error("Vui lòng nhập tên món");
        return;
      }
      if (!this.create_mon_an.loai_mon) {
        this.$toast.error("Vui lòng nhập loại món");
        return;
      }

      this.loading = true;

      // Tạo FormData để gửi file
      const formData = new FormData();
      formData.append('ten_mon', this.create_mon_an.ten_mon);
      formData.append('loai_mon', this.create_mon_an.loai_mon);
      formData.append('mo_ta', this.create_mon_an.mo_ta || '');
      formData.append('ghi_chu', this.create_mon_an.ghi_chu || '');
      formData.append('nguon_goc', this.create_mon_an.nguon_goc || '');
      formData.append('calo', this.create_mon_an.calo || 0);
      formData.append('protein', this.create_mon_an.protein || 0);
      formData.append('carb', this.create_mon_an.carb || 0);
      formData.append('fat', this.create_mon_an.fat || 0);
      if (this.create_mon_an.hinh_anh) {
        formData.append('hinh_anh', this.create_mon_an.hinh_anh);
      }

      // Gửi FormData - baseRequestAdmin sẽ tự động set headers và Content-Type
      baseRequestAdmin
        .post("admin/mon-an/create", formData)
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

      // Map loại bữa sang ID bữa ăn
      const mealTypeToId = {
        'sang': 1,
        'trua': 3,
        'chieu': 5
      };

      // Transform data để match với backend
      const dataToSend = {
        id: this.update_thuc_don.id,
        ten_thuc_don: this.update_thuc_don.ten_thuc_don,
        ngay: this.update_thuc_don.ngay_ap_dung, // Map ngay_ap_dung -> ngay
        id_bua_an: mealTypeToId[this.update_thuc_don.loai_bua] || this.update_thuc_don.loai_bua, // Map loai_bua -> id_bua_an
        mo_ta: this.update_thuc_don.mo_ta,
        id_mon_ans: this.update_thuc_don.mon_an_ids || [], // Map mon_an_ids -> id_mon_ans
      };

      console.log('=== DEBUG: Cập Nhật Thực Đơn ===');
      console.log('Data gửi đi:', JSON.stringify(dataToSend, null, 2));

      baseRequestAdmin
        .post("admin/thuc-don/update", dataToSend)
        .then((res) => {
          console.log('Response từ server:', res.data);
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
          console.error('Lỗi khi cập nhật:', err.response?.data || err);
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
            this.list_thuc_don = res.data.data || [];
            const totalMenus = this.list_thuc_don.length || 0;
            this.mealTypeStats = this.mealTypeDefinitions.map((definition) => {
              const menus = this.list_thuc_don.filter(
                (menu) => menu.loai_bua === definition.type
              );
              const activeCount = menus.filter((menu) => menu.trang_thai === "active").length;
              return {
                ...definition,
                mealName: definition.name,
                menuCount: menus.length,
                activeCount,
                inactiveCount: menus.length - activeCount,
                percentage: totalMenus > 0 ? Math.round((menus.length / totalMenus) * 100) : 0,
              };
            });
            this.weeklyMenuPreview = this.weeklyDays.map((dayName, index) => {
              const dayDate = new Date(this.weekStartMonday);
              dayDate.setDate(this.weekStartMonday.getDate() + index);
              dayDate.setHours(0, 0, 0, 0);
              const menusForDay = this.list_thuc_don.filter((menu) => {
                if (!menu.ngay_ap_dung) return false;
                const menuDate = new Date(menu.ngay_ap_dung);
                menuDate.setHours(0, 0, 0, 0);
                return (
                  menuDate.getTime() === dayDate.getTime() && menu.trang_thai === "active"
                );
              });
              const meals = ["sang", "trua", "chieu"].map((mealType) => {
                const menu = menusForDay.find((item) => item.loai_bua === mealType);
                const dish =
                  menu && Array.isArray(menu.mon_an) && menu.mon_an.length > 0
                    ? menu.mon_an[0]
                    : {};
                return {
                  type: mealType,
                  dish: {
                    name: dish.ten_mon || "Chưa có",
                    image: dish.hinh_anh || this.defaultDishImage,
                  },
                };
              });
              return {
                day: index,
                dayName,
                date: dayDate.toLocaleDateString("vi-VN", {
                  day: "2-digit",
                  month: "2-digit",
                }),
                meals,
              };
            });
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
      // Đóng modal chi tiết
      const detailModal = bootstrap.Modal.getInstance(document.getElementById("xemChiTietModal"));
      if (detailModal) {
        detailModal.hide();
      }

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

      // Mở modal cập nhật
      setTimeout(() => {
        const updateModal = new bootstrap.Modal(document.getElementById("capNhatModal"));
        updateModal.show();
      }, 300);
    },

    openDeleteModal(menu) {
      // Đóng modal chi tiết
      const detailModal = bootstrap.Modal.getInstance(document.getElementById("xemChiTietModal"));
      if (detailModal) {
        detailModal.hide();
      }

      // Set dữ liệu cho modal xóa
      this.delete_thuc_don = {
        id: menu.id || "",
        ten_thuc_don: menu.ten_thuc_don || "",
        loai_bua: menu.loai_bua || "",
        ngay_ap_dung: menu.ngay_ap_dung || "",
      };

      // Mở modal xóa
      setTimeout(() => {
        const deleteModal = new bootstrap.Modal(document.getElementById("xoaModal"));
        deleteModal.show();
      }, 300);
    },


    resetCreateForm() {
      this.create_thuc_don = {
        ten_thuc_don: "",
        id_bua_an: "",
        ngay: "",
        mo_ta: "",
        trang_thai: "active",
        id_mon_ans: [],
      };
      this.dishSearchQuery = "";
    },

    resetCreateMonAnForm() {
      this.create_mon_an = {
        ten_mon: "",
        loai_mon: "",
        mo_ta: "",
        ghi_chu: "",
        nguon_goc: "",
        calo: "",
        protein: "",
        carb: "",
        fat: "",
        hinh_anh: null,
        imagePreview: null,
      };
    },
  },
};
</script>

<style lang="scss">
@use "./style.scss";
</style>
