<template>
    <div class="page-header education-theme">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-header-content">
                        <div class="page-icon">
                            <i class="fas fa-hamburger"></i>
                        </div>
                        <div class="page-info">
                            <h1 class="page-title">Quản lý Món Ăn</h1>
                            <p class="page-subtitle">
                                Quản lý danh sách món ăn trong hệ thống
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <nav class="breadcrumb-nav">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <i class="fas fa-school"></i>
                                <a href="javascript: void(0);">Quản lý</a>
                            </li>
                            <li class="breadcrumb-item">
                                <i class="fas fa-utensils"></i>
                                <router-link to="/admin/thuc-don">Thực Đơn</router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="fas fa-hamburger"></i>
                                Món Ăn
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stats-card stats-primary">
                <div class="stats-icon">
                    <i class="fas fa-hamburger"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number">{{ list_mon_an.length }}</h3>
                    <p class="stats-label">Tổng Món Ăn</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card stats-success">
                <div class="stats-icon">
                    <i class="fas fa-utensils"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number">
                        {{list_mon_an.filter((ma) => ma.loai_mon === 'Cháo').length}}
                    </h3>
                    <p class="stats-label">Cháo</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card stats-warning">
                <div class="stats-icon">
                    <i class="fas fa-soup"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number">
                        {{list_mon_an.filter((ma) => ma.loai_mon === 'Cơm').length}}
                    </h3>
                    <p class="stats-label">Cơm</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="stats-card stats-info">
                <div class="stats-icon">
                    <i class="fas fa-cookie"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-number">
                        {{list_mon_an.filter((ma) => ma.loai_mon === 'Phở').length}}
                    </h3>
                    <p class="stats-label">Phở</p>
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
                            <i class="fas fa-hamburger"></i>
                        </div>
                        <div class="header-text">
                            <h5 class="card-title">Danh Sách Món Ăn</h5>
                            <p class="card-subtitle">Quản lý thông tin món ăn trong hệ thống</p>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-modern" data-bs-toggle="modal" data-bs-target="#themModal">
                        <i class="fas fa-plus"></i>
                        Thêm Món Ăn
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
                                <input v-on:change="TiemKiem()" v-model="search.noi_dung" type="text"
                                    class="search-input" placeholder="Tìm kiếm theo tên món ăn..." />
                            </div>

                            <div class="search-filters">
                                <select v-on:change="TiemKiem()" class="filter-select" v-model="search.loai_mon">
                                    <option value="">Tất cả loại món</option>
                                    <option value="Cháo">Cháo</option>
                                    <option value="Cơm">Cơm</option>
                                    <option value="Phở">Phở</option>
                                    <option value="Bún">Bún</option>
                                    <option value="Mì">Mì</option>
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
                                    <th>Món Ăn</th>
                                    <th class="text-center">Hình Ảnh</th>
                                    <th class="text-center">Loại Món</th>
                                    <th class="text-center">Calo</th>
                                    <th class="text-center">Protein</th>
                                    <th class="text-center">Carb</th>
                                    <th class="text-center">Fat</th>
                                    <th class="text-center">Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="list_mon_an.length === 0">
                                    <td colspan="9" class="text-center py-4">
                                        <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                        <p class="text-muted mb-0">Chưa có dữ liệu món ăn</p>
                                    </td>
                                </tr>
                                <tr v-for="(value, index) in list_mon_an" :key="value.id || index"
                                    class="table-row-hover">
                                    <td class="text-center table-index">
                                        {{ index + 1 }}
                                    </td>
                                    <td class="food-info">
                                        <div class="food-container">
                                            <div class="food-details">
                                                <span class="food-name">{{ value.ten_mon }}</span>
                                                <small class="food-description">{{ value.mo_ta || 'Chưa có mô tả'
                                                }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="food-image-container">
                                            <img :src="value.hinh_anh || '/default-food.jpg'" :alt="value.ten_mon"
                                                class="food-image" />
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="category-badge">
                                            {{ value.loai_mon || 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="calories-info">
                                            <i class="fas fa-fire text-warning me-1"></i>
                                            <span>{{ value.calo || 0 }} kcal</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span>{{ value.protein || 0 }}g</span>
                                    </td>
                                    <td class="text-center">
                                        <span>{{ value.carb || 0 }}g</span>
                                    </td>
                                    <td class="text-center">
                                        <span>{{ value.fat || 0 }}g</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="action-buttons">
                                            <button class="btn-action btn-edit" @click="OpenUpdateModal(value)"
                                                data-bs-toggle="modal" data-bs-target="#capNhatModal" title="Chỉnh sửa">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn-action btn-delete" @click="OpenDeleteModal(value)"
                                                data-bs-toggle="modal" data-bs-target="#xoaModal" title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Thêm Món Ăn -->
    <div class="modal fade" id="themModal" tabindex="-1" aria-labelledby="themModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="themModalLabel">
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
                                    <input type="text" class="form-control" id="loaiMon"
                                        v-model="create_mon_an.loai_mon" placeholder="VD: Cháo, Cơm, Phở..." required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nguonGoc" class="form-label">Nguồn Gốc</label>
                                    <input type="text" class="form-control" id="nguonGoc"
                                        v-model="create_mon_an.nguon_goc" placeholder="VD: Việt Nam" />
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
                                    <input type="number" class="form-control" id="calo" v-model="create_mon_an.calo"
                                        min="0" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="protein" class="form-label">Protein (g)</label>
                                    <input type="number" class="form-control" id="protein"
                                        v-model="create_mon_an.protein" min="0" step="0.1" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="carb" class="form-label">Carb (g)</label>
                                    <input type="number" class="form-control" id="carb" v-model="create_mon_an.carb"
                                        min="0" step="0.1" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="fat" class="form-label">Fat (g)</label>
                                    <input type="number" class="form-control" id="fat" v-model="create_mon_an.fat"
                                        min="0" step="0.1" />
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

    <!-- Modal Cập Nhật Món Ăn -->
    <div class="modal fade" id="capNhatModal" tabindex="-1" aria-labelledby="capNhatModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="capNhatModalLabel">
                        <i class="fas fa-edit me-2"></i>
                        Cập Nhật Thông Tin Món Ăn
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="updateTenMon" class="form-label">Tên Món *</label>
                                    <input type="text" class="form-control" id="updateTenMon"
                                        v-model="update_mon_an.ten_mon" required />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="updateLoaiMon" class="form-label">Loại Món *</label>
                                    <input type="text" class="form-control" id="updateLoaiMon"
                                        v-model="update_mon_an.loai_mon" placeholder="VD: Cháo, Cơm, Phở..." required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="updateNguonGoc" class="form-label">Nguồn Gốc</label>
                                    <input type="text" class="form-control" id="updateNguonGoc"
                                        v-model="update_mon_an.nguon_goc" placeholder="VD: Việt Nam" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="updateMoTa" class="form-label">Mô Tả</label>
                                    <textarea class="form-control" id="updateMoTa" v-model="update_mon_an.mo_ta"
                                        rows="3" placeholder="Nhập mô tả về món ăn..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="updateGhiChu" class="form-label">Ghi Chú</label>
                                    <textarea class="form-control" id="updateGhiChu" v-model="update_mon_an.ghi_chu"
                                        rows="2" placeholder="Nhập ghi chú về món ăn..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="updateCalo" class="form-label">Calo (kcal)</label>
                                    <input type="number" class="form-control" id="updateCalo"
                                        v-model="update_mon_an.calo" min="0" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="updateProtein" class="form-label">Protein (g)</label>
                                    <input type="number" class="form-control" id="updateProtein"
                                        v-model="update_mon_an.protein" min="0" step="0.1" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="updateCarb" class="form-label">Carb (g)</label>
                                    <input type="number" class="form-control" id="updateCarb"
                                        v-model="update_mon_an.carb" min="0" step="0.1" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="updateFat" class="form-label">Fat (g)</label>
                                    <input type="number" class="form-control" id="updateFat" v-model="update_mon_an.fat"
                                        min="0" step="0.1" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="updateHinhAnh" class="form-label">Hình Ảnh</label>
                                    <input type="file" class="form-control" id="updateHinhAnh" accept="image/*"
                                        @change="(e) => { const file = e.target.files[0]; if (file) { this.update_mon_an.hinh_anh = file; const reader = new FileReader(); reader.onload = (evt) => { this.update_mon_an.imagePreview = evt.target.result; }; reader.readAsDataURL(file); } }" />
                                    <small class="form-text text-muted">Chọn hình ảnh mới để thay thế</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="updateIsBlock" class="form-label">Trạng Thái</label>
                                    <select class="form-select" id="updateIsBlock" v-model="update_mon_an.is_block">
                                        <option :value="0">Hoạt động</option>
                                        <option :value="1">Khóa</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div v-if="update_mon_an.imagePreview || update_mon_an.hinh_anh" class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Xem Trước Hình Ảnh</label>
                                    <div class="image-preview">
                                        <img :src="update_mon_an.imagePreview || update_mon_an.hinh_anh" alt="Preview"
                                            class="preview-image" />
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
                    <button type="button" class="btn btn-primary" @click="CapNhatMonAn" :disabled="loading">
                        <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
                        <i v-else class="fas fa-save me-1"></i>
                        {{ loading ? 'Đang xử lý...' : 'Cập Nhật' }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Xóa Món Ăn -->
    <div class="modal fade" id="xoaModal" tabindex="-1" aria-labelledby="xoaModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="xoaModalLabel">
                        <i class="fas fa-exclamation-triangle me-2 text-warning"></i>
                        Xác Nhận Xóa Món Ăn
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <div class="mb-3">
                            <i class="fas fa-hamburger text-danger" style="font-size: 3rem;"></i>
                        </div>
                        <h6>Bạn có chắc chắn muốn xóa món ăn này không?</h6>
                        <div class="alert alert-warning" role="alert">
                            <strong>Thông tin món ăn:</strong><br>
                            <strong>Tên món:</strong> {{ delete_mon_an.ten_mon }}<br>
                            <strong>Loại món:</strong> {{ delete_mon_an.loai_mon || 'N/A' }}
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
                    <button type="button" class="btn btn-danger" @click="XoaMonAn" :disabled="loading">
                        <i v-if="loading" class="fas fa-spinner fa-spin me-1"></i>
                        <i v-else class="fas fa-trash me-1"></i>
                        {{ loading ? 'Đang xử lý...' : 'Xóa Món Ăn' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import baseRequestAdmin from "../../../core/baseRequestAdmin";

export default {
    data() {
        return {
            list_mon_an: [],
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
            update_mon_an: {
                id: "",
                ten_mon: "",
                loai_mon: "",
                mo_ta: "",
                ghi_chu: "",
                nguon_goc: "",
                calo: "",
                protein: "",
                carb: "",
                fat: "",
                is_block: 0,
                hinh_anh: null,
                imagePreview: null,
            },
            delete_mon_an: {
                id: "",
                ten_mon: "",
                loai_mon: "",
            },
            search: {
                noi_dung: "",
                loai_mon: "",
            },
            loading: false,
            modalOpen: false,
        };
    },

    mounted() {
        this.loadData();
    },

    methods: {
        loadData() {
            baseRequestAdmin
                .get("admin/mon-an/data")
                .then((res) => {
                    if (res.data.status) {
                        this.list_mon_an = res.data.data;
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
                        this.$toast.error("Có lỗi xảy ra khi thêm món ăn");
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        CapNhatMonAn() {
            // Validate
            if (!this.update_mon_an.id) {
                this.$toast.error("Không tìm thấy ID món ăn");
                return;
            }
            if (!this.update_mon_an.ten_mon) {
                this.$toast.error("Vui lòng nhập tên món");
                return;
            }
            if (!this.update_mon_an.loai_mon) {
                this.$toast.error("Vui lòng nhập loại món");
                return;
            }

            this.loading = true;

            // Tạo FormData để gửi file
            const formData = new FormData();
            formData.append('id', this.update_mon_an.id);
            formData.append('ten_mon', this.update_mon_an.ten_mon);
            formData.append('loai_mon', this.update_mon_an.loai_mon);
            formData.append('mo_ta', this.update_mon_an.mo_ta || '');
            formData.append('ghi_chu', this.update_mon_an.ghi_chu || '');
            formData.append('nguon_goc', this.update_mon_an.nguon_goc || '');
            formData.append('calo', this.update_mon_an.calo || 0);
            formData.append('protein', this.update_mon_an.protein || 0);
            formData.append('carb', this.update_mon_an.carb || 0);
            formData.append('fat', this.update_mon_an.fat || 0);
            formData.append('is_block', this.update_mon_an.is_block || 0);
            if (this.update_mon_an.hinh_anh) {
                formData.append('hinh_anh', this.update_mon_an.hinh_anh);
            }

            // Gửi FormData - baseRequestAdmin sẽ tự động set headers và Content-Type
            baseRequestAdmin
                .post("admin/mon-an/update", formData)
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
                        this.$toast.error("Có lỗi xảy ra khi cập nhật món ăn");
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        XoaMonAn() {
            // Validate
            if (!this.delete_mon_an.id) {
                this.$toast.error("Không tìm thấy ID món ăn");
                return;
            }

            this.loading = true;

            const deleteData = {
                id: this.delete_mon_an.id
            };

            baseRequestAdmin
                .post("admin/mon-an/delete", deleteData)
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.loadData();
                        this.delete_mon_an = {
                            id: "",
                            ten_mon: "",
                            loai_mon: "",
                        };
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
                        this.$toast.error("Có lỗi xảy ra khi xóa món ăn");
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        TiemKiem() {
            // Chuẩn bị dữ liệu tìm kiếm - chỉ gửi các field có giá trị
            const searchData = {};

            if (this.search.noi_dung && this.search.noi_dung.trim()) {
                searchData.noi_dung = this.search.noi_dung.trim();
            }

            if (this.search.loai_mon && this.search.loai_mon.trim()) {
                searchData.loai_mon = this.search.loai_mon.trim();
            }

            baseRequestAdmin
                .post("admin/mon-an/search", searchData)
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.list_mon_an = res.data.data;
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

        resetCreateForm() {
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

        OpenUpdateModal(value) {
            // Reset form first
            this.update_mon_an = {
                id: "",
                ten_mon: "",
                loai_mon: "",
                mo_ta: "",
                ghi_chu: "",
                nguon_goc: "",
                calo: "",
                protein: "",
                carb: "",
                fat: "",
                is_block: 0,
                hinh_anh: null,
                imagePreview: null,
            };

            // Then assign values
            this.$nextTick(() => {
                this.update_mon_an = {
                    id: value.id ? String(value.id) : "",
                    ten_mon: value.ten_mon || "",
                    loai_mon: value.loai_mon || "",
                    mo_ta: value.mo_ta || "",
                    ghi_chu: value.ghi_chu || "",
                    nguon_goc: value.nguon_goc || "",
                    calo: (value.calo !== undefined && value.calo !== null) ? String(value.calo) : "",
                    protein: (value.protein !== undefined && value.protein !== null) ? String(value.protein) : "",
                    carb: (value.carb !== undefined && value.carb !== null) ? String(value.carb) : "",
                    fat: (value.fat !== undefined && value.fat !== null) ? String(value.fat) : "",
                    is_block: value.is_block !== undefined ? value.is_block : 0,
                    hinh_anh: value.hinh_anh || null,
                    imagePreview: null,
                };
            });
        },

        OpenDeleteModal(value) {
            this.delete_mon_an = {
                id: value.id ? String(value.id) : "",
                ten_mon: value.ten_mon || "",
                loai_mon: value.loai_mon || "",
            };
        },
    },
};
</script>

<style lang="scss">
@use "./style.scss";

.food-info {
    .food-container {
        display: flex;
        align-items: center;
        gap: 1rem;

        .food-details {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            min-width: 0;

            .food-name {
                font-weight: 600;
                color: #2c3e50;
                font-size: 1rem;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .food-description {
                font-size: 0.85rem;
                color: #6c757d;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
        }
    }
}

.food-image-container {
    display: flex;
    justify-content: center;
    align-items: center;

    .food-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #e9ecef;
    }
}

.category-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 500;
    font-size: 0.85rem;

    &.category-primary {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }

    &.category-success {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
    }

    &.category-warning {
        background: linear-gradient(135deg, #ffc107, #ff9800);
        color: white;
    }

    &.category-info {
        background: linear-gradient(135deg, #17a2b8, #6f42c1);
        color: white;
    }
}

.calories-info {
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 500;
}

.price-info {
    .price-value {
        font-weight: 600;
        color: #28a745;
    }
}

.image-preview {
    margin-top: 0.5rem;

    .preview-image {
        max-width: 100%;
        max-height: 200px;
        border-radius: 8px;
        border: 2px solid #e9ecef;
    }
}
</style>
