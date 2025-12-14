<template>
    <div class="gallery-page">
        <!-- Header Section -->
        <div class="page-header education-theme">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="page-header-content">
                            <div class="page-icon">
                                <i class="bx bx-images"></i>
                            </div>
                            <div class="page-info">
                                <h1 class="page-title">Album Hình Ảnh Lớp Học</h1>
                                <p class="page-subtitle">Quản lý và chia sẻ hình ảnh hoạt động lớp</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <button class="btn btn-create" data-bs-toggle="modal" data-bs-target="#addAlbumModal">
                            <i class="bx bx-plus"></i>
                            Tạo Album Mới
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="stats-section">
            <div class="container-fluid">
                <div class="row g-4">
                    <div class="col-xl-3 col-md-6">
                        <div class="stats-card stats-primary">
                            <div class="stats-content-wrapper">
                                <div class="stats-icon">
                                    <i class="bx bx-folder"></i>
                                </div>
                                <div class="stats-content">
                                    <div class="stats-number">{{ albums.length }}</div>
                                    <div class="stats-label">Tổng Album</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="stats-card stats-success">
                            <div class="stats-content-wrapper">
                                <div class="stats-icon">
                                    <i class="bx bx-image"></i>
                                </div>
                                <div class="stats-content">
                                    <div class="stats-number">{{ totalImages }}</div>
                                    <div class="stats-label">Tổng Hình Ảnh</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="stats-card stats-warning">
                            <div class="stats-content-wrapper">
                                <div class="stats-icon">
                                    <i class="bx bx-calendar"></i>
                                </div>
                                <div class="stats-content">
                                    <div class="stats-number">{{ thisMonthAlbums }}</div>
                                    <div class="stats-label">Album Tháng Này</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="stats-card stats-info">
                            <div class="stats-content-wrapper">
                                <div class="stats-icon">
                                    <i class="bx bx-show"></i>
                                </div>
                                <div class="stats-content">
                                    <div class="stats-number">{{ totalViews }}</div>
                                    <div class="stats-label">Tổng Lượt Xem</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter -->
        <div class="filters-section">
            <div class="container-fluid">
                <div class="filter-card">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="filter-label">Loại Album</label>
                            <select class="form-select" v-model="filterType" @change="loadAlbums">
                                <option value="">Tất cả</option>
                                <option value="Học tập">Học tập</option>
                                <option value="Ngoại khóa">Ngoại khóa</option>
                                <option value="Sự kiện">Sự kiện</option>
                                <option value="Sinh hoạt">Sinh hoạt</option>
                                <option value="Khác">Khác</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="filter-label">Từ ngày</label>
                            <input type="date" class="form-control" v-model="filterStartDate" @change="loadAlbums" />
                        </div>
                        <div class="col-md-3">
                            <label class="filter-label">Đến ngày</label>
                            <input type="date" class="form-control" v-model="filterEndDate" @change="loadAlbums" />
                        </div>
                        <div class="col-md-3">
                            <label class="filter-label">Tìm kiếm</label>
                            <div class="search-input-wrapper">
                                <i class="bx bx-search"></i>
                                <input type="text" class="search-input" v-model="searchText" @input="loadAlbums"
                                    placeholder="Tìm theo tên album..." />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Albums Grid -->
        <div class="albums-section">
            <div class="container-fluid">
                <div v-if="albums.length === 0" class="empty-state">
                    <i class="bx bx-folder-open"></i>
                    <h3>Chưa có album nào</h3>
                    <p>Hãy tạo album mới để bắt đầu chia sẻ hình ảnh</p>
                    <button class="btn btn-create" data-bs-toggle="modal" data-bs-target="#addAlbumModal">
                        <i class="bx bx-plus"></i>
                        Tạo Album Mới
                    </button>
                </div>
                <div v-else class="row g-4">
                    <div class="col-xl-3 col-md-4 col-sm-6" v-for="album in albums" :key="album.id">
                        <div class="album-card">
                            <div class="album-cover" @click="viewAlbum(album)">
                                <img :src="album.hinh_anh_dai_dien || '/default-album.jpg'" :alt="album.ten_album"
                                    @error="handleImageError" />
                                <div class="album-overlay">
                                    <div class="album-info-overlay">
                                        <h5>{{ album.ten_album }}</h5>
                                        <p>
                                            <i class="bx bx-image"></i>
                                            {{ album.so_luong_anh || 0 }} ảnh
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="album-body">
                                <div class="album-header-info">
                                    <span class="badge" :class="'bg-' + getTypeColor(album.loai_album)">
                                        {{ album.loai_album }}
                                    </span>
                                    <small class="album-date">
                                        <i class="bx bx-calendar"></i>
                                        {{ formatDate(album.ngay_tao) }}
                                    </small>
                                </div>
                                <p class="album-description">{{ truncateText(album.mo_ta, 80) || 'Không có mô tả' }}</p>
                                <div class="album-footer-info">
                                    <small class="album-views">
                                        <i class="bx bx-show"></i>
                                        {{ album.luot_xem || 0 }} lượt xem
                                    </small>
                                    <div class="album-actions">
                                        <button class="btn-action btn-view" @click.stop="viewAlbum(album)" title="Xem">
                                            <i class="bx bx-show"></i>
                                        </button>
                                        <button class="btn-action btn-edit" @click.stop="editAlbum(album)"
                                            data-bs-toggle="modal" data-bs-target="#editAlbumModal" title="Chỉnh sửa">
                                            <i class="bx bx-edit"></i>
                                        </button>
                                        <button class="btn-action btn-delete" @click.stop="deleteAlbum(album)"
                                            data-bs-toggle="modal" data-bs-target="#deleteAlbumModal" title="Xóa">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Album Modal -->
        <div class="modal fade" id="addAlbumModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header-custom">
                        <div class="modal-header-content">
                            <div class="modal-icon">
                                <i class="bx bx-plus"></i>
                            </div>
                            <div>
                                <h5 class="modal-title">Tạo Album Mới</h5>
                            </div>
                        </div>
                        <button type="button" class="btn-close-custom" data-bs-dismiss="modal">
                            <i class="bx bx-x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-section">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">Tên Album <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" v-model="newAlbum.ten_album" required
                                            placeholder="Nhập tên album..." />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Loại Album <span class="text-danger">*</span></label>
                                        <select class="form-select" v-model="newAlbum.loai_album" required>
                                            <option value="">Chọn loại</option>
                                            <option value="Học tập">Học tập</option>
                                            <option value="Ngoại khóa">Ngoại khóa</option>
                                            <option value="Sự kiện">Sự kiện</option>
                                            <option value="Sinh hoạt">Sinh hoạt</option>
                                            <option value="Khác">Khác</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Ngày Tạo <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" v-model="newAlbum.ngay_tao" required />
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Hình Ảnh Đại Diện (URL)</label>
                                        <input type="url" class="form-control" v-model="newAlbum.hinh_anh_dai_dien"
                                            placeholder="https://example.com/image.jpg" />
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Mô Tả</label>
                                        <textarea class="form-control" rows="3" v-model="newAlbum.mo_ta"
                                            placeholder="Mô tả về album..."></textarea>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check-custom">
                                            <input class="form-check-input" type="checkbox"
                                                v-model="newAlbum.gui_thong_bao" id="sendNotification" />
                                            <label class="form-check-label" for="sendNotification">
                                                Gửi thông báo đến phụ huynh khi tạo album
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer-custom">
                        <button type="button" class="btn btn-secondary-custom" data-bs-dismiss="modal">
                            <i class="bx bx-x"></i>
                            Hủy
                        </button>
                        <button type="button" class="btn btn-primary-custom" @click="saveAlbum" :disabled="loading">
                            <i v-if="loading" class="bx bx-loader-alt bx-spin"></i>
                            <i v-else class="bx bx-save"></i>
                            {{ loading ? 'Đang lưu...' : 'Tạo Album' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Album Modal -->
        <div class="modal fade" id="editAlbumModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header-custom">
                        <div class="modal-header-content">
                            <div class="modal-icon">
                                <i class="bx bx-edit"></i>
                            </div>
                            <div>
                                <h5 class="modal-title">Chỉnh Sửa Album</h5>
                            </div>
                        </div>
                        <button type="button" class="btn-close-custom" data-bs-dismiss="modal">
                            <i class="bx bx-x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-section">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">Tên Album <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" v-model="editAlbumData.ten_album"
                                            required />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Loại Album <span class="text-danger">*</span></label>
                                        <select class="form-select" v-model="editAlbumData.loai_album" required>
                                            <option value="">Chọn loại</option>
                                            <option value="Học tập">Học tập</option>
                                            <option value="Ngoại khóa">Ngoại khóa</option>
                                            <option value="Sự kiện">Sự kiện</option>
                                            <option value="Sinh hoạt">Sinh hoạt</option>
                                            <option value="Khác">Khác</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Ngày Tạo <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" v-model="editAlbumData.ngay_tao"
                                            required />
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Hình Ảnh Đại Diện (URL)</label>
                                        <input type="url" class="form-control"
                                            v-model="editAlbumData.hinh_anh_dai_dien" />
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Mô Tả</label>
                                        <textarea class="form-control" rows="3"
                                            v-model="editAlbumData.mo_ta"></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer-custom">
                        <button type="button" class="btn btn-secondary-custom" data-bs-dismiss="modal">
                            <i class="bx bx-x"></i>
                            Hủy
                        </button>
                        <button type="button" class="btn btn-primary-custom" @click="updateAlbum" :disabled="loading">
                            <i v-if="loading" class="bx bx-loader-alt bx-spin"></i>
                            <i v-else class="bx bx-save"></i>
                            {{ loading ? 'Đang cập nhật...' : 'Cập Nhật' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Album Modal -->
        <div class="modal fade" id="deleteAlbumModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header-custom">
                        <div class="modal-header-content">
                            <div class="modal-icon modal-icon-danger">
                                <i class="bx bx-trash"></i>
                            </div>
                            <div>
                                <h5 class="modal-title">Xác Nhận Xóa</h5>
                            </div>
                        </div>
                        <button type="button" class="btn-close-custom" data-bs-dismiss="modal">
                            <i class="bx bx-x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="delete-confirm-content">
                            <p>Bạn có chắc chắn muốn xóa album <strong>"{{ deleteAlbumData.ten_album }}"</strong>?</p>
                            <p class="text-danger">
                                <i class="bx bx-error-circle"></i>
                                <small>Hành động này sẽ xóa tất cả hình ảnh trong album!</small>
                            </p>
                        </div>
                    </div>
                    <div class="modal-footer-custom">
                        <button type="button" class="btn btn-secondary-custom" data-bs-dismiss="modal">
                            <i class="bx bx-x"></i>
                            Hủy
                        </button>
                        <button type="button" class="btn btn-danger-custom" @click="confirmDelete" :disabled="loading">
                            <i v-if="loading" class="bx bx-loader-alt bx-spin"></i>
                            <i v-else class="bx bx-trash"></i>
                            {{ loading ? 'Đang xóa...' : 'Xóa' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- View Album Modal -->
        <div class="modal fade" id="viewAlbumModal" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header-custom">
                        <div class="modal-header-content">
                            <div class="modal-icon">
                                <i class="bx bx-images"></i>
                            </div>
                            <div>
                                <h5 class="modal-title">{{ selectedAlbum.ten_album || 'Album' }}</h5>
                                <p class="modal-subtitle">
                                    <span class="badge" :class="'bg-' + getTypeColor(selectedAlbum.loai_album)">
                                        {{ selectedAlbum.loai_album }}
                                    </span>
                                    <small class="ms-2">
                                        <i class="bx bx-image"></i>
                                        {{ selectedAlbum.so_luong_anh || 0 }} ảnh
                                    </small>
                                </p>
                            </div>
                        </div>
                        <div class="modal-header-actions">
                            <button class="btn btn-add-images" @click="addImagesToAlbum" data-bs-toggle="modal"
                                data-bs-target="#addImagesModal">
                                <i class="bx bx-plus"></i>
                                Thêm Ảnh
                            </button>
                            <button type="button" class="btn-close-custom" data-bs-dismiss="modal">
                                <i class="bx bx-x"></i>
                            </button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div v-if="albumImages.length === 0" class="empty-images">
                            <i class="bx bx-image"></i>
                            <p>Chưa có hình ảnh nào</p>
                            <button class="btn btn-primary" @click="addImagesToAlbum">
                                <i class="bx bx-plus"></i>
                                Thêm ảnh đầu tiên
                            </button>
                        </div>
                        <div v-else class="images-grid">
                            <div class="image-item" v-for="image in albumImages" :key="image.id">
                                <img :src="image.url" :alt="image.ten" class="image-thumbnail" />
                                <div class="image-overlay">
                                    <button class="btn-image-action btn-delete" @click="deleteImage(image)">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, computed, onMounted, getCurrentInstance } from 'vue';
import baseRequestTeacher from '../../../core/baseRequestTeacher';

export default {
    name: 'Gallery',
    setup() {
        const { proxy } = getCurrentInstance();
        const albums = ref([]);
        const albumImages = ref([]);
        const loading = ref(false);
        const filterType = ref('');
        const filterStartDate = ref('');
        const filterEndDate = ref('');
        const searchText = ref('');
        const selectedAlbum = ref({});

        const newAlbum = ref({
            ten_album: '',
            loai_album: '',
            ngay_tao: new Date().toISOString().split('T')[0],
            hinh_anh_dai_dien: '',
            mo_ta: '',
            gui_thong_bao: false
        });

        const editAlbumData = ref({
            id: '',
            ten_album: '',
            loai_album: '',
            ngay_tao: '',
            hinh_anh_dai_dien: '',
            mo_ta: ''
        });

        const deleteAlbumData = ref({
            id: '',
            ten_album: ''
        });

        const totalImages = computed(() => {
            return albums.value.reduce((sum, album) => sum + (album.so_luong_anh || 0), 0);
        });

        const thisMonthAlbums = computed(() => {
            const now = new Date();
            return albums.value.filter(album => {
                const albumDate = new Date(album.ngay_tao);
                return albumDate.getMonth() === now.getMonth() && albumDate.getFullYear() === now.getFullYear();
            }).length;
        });

        const totalViews = computed(() => {
            return albums.value.reduce((sum, album) => sum + (album.luot_xem || 0), 0);
        });

        const loadAlbums = () => {
            loading.value = true;
            const params = {
                loai_album: filterType.value,
                tu_ngay: filterStartDate.value,
                den_ngay: filterEndDate.value,
                tim_kiem: searchText.value
            };
            baseRequestTeacher
                .post('teacher/hinh-anh-lop-hoc/data', params)
                .then((res) => {
                    if (res.data.status) {
                        albums.value = res.data.data || [];
                        if (proxy.$toast) {
                            proxy.$toast.success(res.data.message);
                        }
                    } else {
                        if (proxy.$toast) {
                            proxy.$toast.error(res.data.message);
                        }
                    }
                })
                .catch((err) => {
                    console.error(err);
                    if (proxy.$toast) {
                        proxy.$toast.error('Có lỗi xảy ra khi tải dữ liệu');
                    }
                })
                .finally(() => {
                    loading.value = false;
                });
        };

        const saveAlbum = () => {
            loading.value = true;
            baseRequestTeacher
                .post('teacher/hinh-anh-lop-hoc/create', newAlbum.value)
                .then((res) => {
                    if (res.data.status) {
                        if (proxy.$toast) {
                            proxy.$toast.success(res.data.message);
                        }
                        loadAlbums();
                        resetNewAlbum();
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addAlbumModal'));
                        if (modal) modal.hide();
                    } else {
                        if (proxy.$toast) {
                            proxy.$toast.error(res.data.message);
                        }
                    }
                })
                .catch((err) => {
                    console.error(err);
                    if (proxy.$toast) {
                        proxy.$toast.error('Có lỗi xảy ra khi tạo album');
                    }
                })
                .finally(() => {
                    loading.value = false;
                });
        };

        const editAlbum = (album) => {
            editAlbumData.value = { ...album };
        };

        const updateAlbum = () => {
            loading.value = true;
            baseRequestTeacher
                .post('teacher/hinh-anh-lop-hoc/update', editAlbumData.value)
                .then((res) => {
                    if (res.data.status) {
                        if (proxy.$toast) {
                            proxy.$toast.success(res.data.message);
                        }
                        loadAlbums();
                        const modal = bootstrap.Modal.getInstance(document.getElementById('editAlbumModal'));
                        if (modal) modal.hide();
                    } else {
                        if (proxy.$toast) {
                            proxy.$toast.error(res.data.message);
                        }
                    }
                })
                .catch((err) => {
                    console.error(err);
                    if (proxy.$toast) {
                        proxy.$toast.error('Có lỗi xảy ra khi cập nhật');
                    }
                })
                .finally(() => {
                    loading.value = false;
                });
        };

        const deleteAlbum = (album) => {
            deleteAlbumData.value = { id: album.id, ten_album: album.ten_album };
        };

        const confirmDelete = () => {
            loading.value = true;
            baseRequestTeacher
                .post('teacher/hinh-anh-lop-hoc/delete', deleteAlbumData.value)
                .then((res) => {
                    if (res.data.status) {
                        if (proxy.$toast) {
                            proxy.$toast.success(res.data.message);
                        }
                        loadAlbums();
                        const modal = bootstrap.Modal.getInstance(document.getElementById('deleteAlbumModal'));
                        if (modal) modal.hide();
                    } else {
                        if (proxy.$toast) {
                            proxy.$toast.error(res.data.message);
                        }
                    }
                })
                .catch((err) => {
                    console.error(err);
                    if (proxy.$toast) {
                        proxy.$toast.error('Có lỗi xảy ra khi xóa');
                    }
                })
                .finally(() => {
                    loading.value = false;
                });
        };

        const viewAlbum = (album) => {
            selectedAlbum.value = album;
            loadAlbumImages(album.id);
            const modalElement = document.getElementById('viewAlbumModal');
            if (modalElement) {
                const modal = new bootstrap.Modal(modalElement);
                modal.show();
            }
        };

        const loadAlbumImages = (albumId) => {
            baseRequestTeacher
                .get(`teacher/hinh-anh-lop-hoc/images/${albumId}`)
                .then((res) => {
                    if (res.data.status) {
                        albumImages.value = res.data.data || [];
                    }
                })
                .catch((err) => {
                    console.error('Error loading images:', err);
                    albumImages.value = [];
                });
        };

        const addImagesToAlbum = () => {
            alert('Tính năng thêm ảnh đang được phát triển');
        };

        const deleteImage = (image) => {
            if (confirm('Bạn có chắc chắn muốn xóa hình ảnh này?')) {
                baseRequestTeacher
                    .post('teacher/hinh-anh-lop-hoc/delete-image', { id: image.id })
                    .then((res) => {
                        if (res.data.status) {
                            if (proxy.$toast) {
                                proxy.$toast.success(res.data.message);
                            }
                            loadAlbumImages(selectedAlbum.value.id);
                            loadAlbums();
                        }
                    })
                    .catch((err) => {
                        console.error(err);
                    });
            }
        };

        const resetNewAlbum = () => {
            newAlbum.value = {
                ten_album: '',
                loai_album: '',
                ngay_tao: new Date().toISOString().split('T')[0],
                hinh_anh_dai_dien: '',
                mo_ta: '',
                gui_thong_bao: false
            };
        };

        const formatDate = (dateString) => {
            if (!dateString) return '';
            const date = new Date(dateString);
            return date.toLocaleDateString('vi-VN');
        };

        const truncateText = (text, length) => {
            if (!text) return '';
            if (text.length <= length) return text;
            return text.substring(0, length) + '...';
        };

        const getTypeColor = (type) => {
            const colors = {
                'Học tập': 'primary',
                'Ngoại khóa': 'success',
                'Sự kiện': 'warning',
                'Sinh hoạt': 'info',
                'Khác': 'secondary'
            };
            return colors[type] || 'secondary';
        };

        const handleImageError = (event) => {
            event.target.src = 'https://via.placeholder.com/400x300?text=Album+Image';
        };

        onMounted(() => {
            loadAlbums();
        });

        return {
            albums,
            albumImages,
            loading,
            filterType,
            filterStartDate,
            filterEndDate,
            searchText,
            selectedAlbum,
            newAlbum,
            editAlbumData,
            deleteAlbumData,
            totalImages,
            thisMonthAlbums,
            totalViews,
            loadAlbums,
            saveAlbum,
            editAlbum,
            updateAlbum,
            deleteAlbum,
            confirmDelete,
            viewAlbum,
            addImagesToAlbum,
            deleteImage,
            formatDate,
            truncateText,
            getTypeColor,
            handleImageError
        };
    }
};
</script>

<style lang="scss">
@use './style.scss';
</style>
