<template>
    <div class="gallery-page">
        <div class="page-header mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="page-title">
                        <i class="bx bx-images me-2"></i>Album Hình Ảnh Lớp Học
                    </h2>
                    <p class="page-subtitle">Quản lý và chia sẻ hình ảnh hoạt động lớp</p>
                </div>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAlbumModal">
                    <i class="bx bx-plus me-1"></i>Tạo Album Mới
                </button>
            </div>
        </div>

        <!-- Statistics -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card stat-card stat-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon"><i class="bx bx-folder"></i></div>
                            <div class="stat-content">
                                <h3 class="stat-number">{{ albums.length }}</h3>
                                <p class="stat-label">Tổng Album</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card stat-card stat-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon"><i class="bx bx-image"></i></div>
                            <div class="stat-content">
                                <h3 class="stat-number">{{ totalImages }}</h3>
                                <p class="stat-label">Tổng Hình Ảnh</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card stat-card stat-warning">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon"><i class="bx bx-calendar"></i></div>
                            <div class="stat-content">
                                <h3 class="stat-number">{{ thisMonthAlbums }}</h3>
                                <p class="stat-label">Album Tháng Này</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card stat-card stat-info">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon"><i class="bx bx-show"></i></div>
                            <div class="stat-content">
                                <h3 class="stat-number">{{ totalViews }}</h3>
                                <p class="stat-label">Tổng Lượt Xem</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <label class="form-label">Loại Album</label>
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
                        <label class="form-label">Từ ngày</label>
                        <input type="date" class="form-control" v-model="filterStartDate" @change="loadAlbums" />
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Đến ngày</label>
                        <input type="date" class="form-control" v-model="filterEndDate" @change="loadAlbums" />
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tìm kiếm</label>
                        <input type="text" class="form-control" v-model="searchText" @input="loadAlbums"
                            placeholder="Tìm theo tên album..." />
                    </div>
                </div>
            </div>
        </div>

        <!-- Albums Grid -->
        <div class="row" v-if="albums.length > 0">
            <div class="col-md-4 mb-4" v-for="album in albums" :key="album.id">
                <div class="card album-card">
                    <div class="album-cover" @click="viewAlbum(album)">
                        <img :src="album.hinh_anh_dai_dien || '/default-album.jpg'" :alt="album.ten_album" />
                        <div class="album-overlay">
                            <div class="album-info">
                                <h5>{{ album.ten_album }}</h5>
                                <p><i class="bx bx-image me-1"></i>{{ album.so_luong_anh }} ảnh</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge" :class="getTypeClass(album.loai_album)">{{ album.loai_album }}</span>
                            <small class="text-muted">
                                <i class="bx bx-calendar me-1"></i>{{ formatDate(album.ngay_tao) }}
                            </small>
                        </div>
                        <p class="album-description">{{ truncateText(album.mo_ta, 80) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="bx bx-show me-1"></i>{{ album.luot_xem || 0 }} lượt xem
                            </small>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-primary" @click="viewAlbum(album)">
                                    <i class="bx bx-show"></i>
                                </button>
                                <button class="btn btn-sm btn-warning" @click="editAlbum(album)" data-bs-toggle="modal"
                                    data-bs-target="#editAlbumModal">
                                    <i class="bx bx-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" @click="deleteAlbum(album)" data-bs-toggle="modal"
                                    data-bs-target="#deleteAlbumModal">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-else class="text-center py-5">
            <i class="bx bx-folder-open" style="font-size: 4rem; color: #ccc;"></i>
            <p class="text-muted mt-3">Chưa có album nào</p>
        </div>

        <!-- Add Album Modal -->
        <div class="modal fade" id="addAlbumModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bx bx-plus me-2"></i>Tạo Album Mới
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label class="form-label">Tên Album *</label>
                                <input type="text" class="form-control" v-model="newAlbum.ten_album" required />
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Loại Album *</label>
                                    <select class="form-select" v-model="newAlbum.loai_album" required>
                                        <option value="">Chọn loại</option>
                                        <option value="Học tập">Học tập</option>
                                        <option value="Ngoại khóa">Ngoại khóa</option>
                                        <option value="Sự kiện">Sự kiện</option>
                                        <option value="Sinh hoạt">Sinh hoạt</option>
                                        <option value="Khác">Khác</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Ngày Tạo *</label>
                                    <input type="date" class="form-control" v-model="newAlbum.ngay_tao" required />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Hình Ảnh Đại Diện (URL)</label>
                                <input type="url" class="form-control" v-model="newAlbum.hinh_anh_dai_dien"
                                    placeholder="https://example.com/image.jpg" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mô Tả</label>
                                <textarea class="form-control" rows="3" v-model="newAlbum.mo_ta"
                                    placeholder="Mô tả về album..."></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Gửi Thông Báo Đến Phụ Huynh</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" v-model="newAlbum.gui_thong_bao" />
                                    <label class="form-check-label">Gửi thông báo khi tạo album</label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-primary" @click="saveAlbum" :disabled="loading">
                            <i v-if="loading" class="bx bx-loader-alt bx-spin me-1"></i>
                            <i v-else class="bx bx-save me-1"></i>
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
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bx bx-edit me-2"></i>Chỉnh Sửa Album
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label class="form-label">Tên Album *</label>
                                <input type="text" class="form-control" v-model="editAlbumData.ten_album" required />
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Loại Album *</label>
                                    <select class="form-select" v-model="editAlbumData.loai_album" required>
                                        <option value="">Chọn loại</option>
                                        <option value="Học tập">Học tập</option>
                                        <option value="Ngoại khóa">Ngoại khóa</option>
                                        <option value="Sự kiện">Sự kiện</option>
                                        <option value="Sinh hoạt">Sinh hoạt</option>
                                        <option value="Khác">Khác</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Ngày Tạo *</label>
                                    <input type="date" class="form-control" v-model="editAlbumData.ngay_tao" required />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Hình Ảnh Đại Diện (URL)</label>
                                <input type="url" class="form-control" v-model="editAlbumData.hinh_anh_dai_dien" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mô Tả</label>
                                <textarea class="form-control" rows="3" v-model="editAlbumData.mo_ta"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-primary" @click="updateAlbum" :disabled="loading">
                            <i v-if="loading" class="bx bx-loader-alt bx-spin me-1"></i>
                            <i v-else class="bx bx-save me-1"></i>
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
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bx bx-trash me-2 text-danger"></i>Xác Nhận Xóa
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Bạn có chắc chắn muốn xóa album "<strong>{{ deleteAlbumData.ten_album }}</strong>"?</p>
                        <p class="text-danger"><small>Hành động này sẽ xóa tất cả hình ảnh trong album!</small></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-danger" @click="confirmDelete" :disabled="loading">
                            <i v-if="loading" class="bx bx-loader-alt bx-spin me-1"></i>
                            <i v-else class="bx bx-trash me-1"></i>
                            {{ loading ? 'Đang xóa...' : 'Xóa' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- View Album Modal (for viewing images) -->
        <div class="modal fade" id="viewAlbumModal" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ selectedAlbum.ten_album }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <span class="badge" :class="getTypeClass(selectedAlbum.loai_album)">{{
                                    selectedAlbum.loai_album }}</span>
                                <small class="text-muted ms-2">
                                    <i class="bx bx-image me-1"></i>{{ selectedAlbum.so_luong_anh }} ảnh
                                </small>
                            </div>
                            <button class="btn btn-sm btn-primary" @click="addImagesToAlbum" data-bs-toggle="modal"
                                data-bs-target="#addImagesModal">
                                <i class="bx bx-plus me-1"></i>Thêm Ảnh
                            </button>
                        </div>
                        <div class="row" v-if="albumImages.length > 0">
                            <div class="col-md-3 mb-3" v-for="image in albumImages" :key="image.id">
                                <div class="image-item">
                                    <img :src="image.url" :alt="image.ten" class="img-thumbnail" />
                                    <div class="image-actions">
                                        <button class="btn btn-sm btn-danger" @click="deleteImage(image)">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-else class="text-center py-5">
                            <i class="bx bx-image" style="font-size: 3rem; color: #ccc;"></i>
                            <p class="text-muted mt-3">Chưa có hình ảnh nào</p>
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
                        albums.value = res.data.data;
                        proxy.$toast?.success(res.data.message);
                    } else {
                        proxy.$toast?.error(res.data.message);
                    }
                })
                .catch((err) => {
                    proxy.$toast?.error('Có lỗi xảy ra khi tải dữ liệu');
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
                        proxy.$toast?.success(res.data.message);
                        loadAlbums();
                        resetNewAlbum();
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addAlbumModal'));
                        if (modal) modal.hide();
                    } else {
                        proxy.$toast?.error(res.data.message);
                    }
                })
                .catch((err) => {
                    proxy.$toast?.error('Có lỗi xảy ra khi tạo album');
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
                        proxy.$toast?.success(res.data.message);
                        loadAlbums();
                        const modal = bootstrap.Modal.getInstance(document.getElementById('editAlbumModal'));
                        if (modal) modal.hide();
                    } else {
                        proxy.$toast?.error(res.data.message);
                    }
                })
                .catch((err) => {
                    proxy.$toast?.error('Có lỗi xảy ra khi cập nhật');
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
                        proxy.$toast?.success(res.data.message);
                        loadAlbums();
                        const modal = bootstrap.Modal.getInstance(document.getElementById('deleteAlbumModal'));
                        if (modal) modal.hide();
                    } else {
                        proxy.$toast?.error(res.data.message);
                    }
                })
                .catch((err) => {
                    proxy.$toast?.error('Có lỗi xảy ra khi xóa');
                })
                .finally(() => {
                    loading.value = false;
                });
        };

        const viewAlbum = (album) => {
            selectedAlbum.value = album;
            loadAlbumImages(album.id);
            const modal = new bootstrap.Modal(document.getElementById('viewAlbumModal'));
            modal.show();
        };

        const loadAlbumImages = (albumId) => {
            baseRequestTeacher
                .get(`teacher/hinh-anh-lop-hoc/images/${albumId}`)
                .then((res) => {
                    if (res.data.status) {
                        albumImages.value = res.data.data;
                    }
                })
                .catch((err) => {
                    console.error('Error loading images:', err);
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
                            proxy.$toast?.success(res.data.message);
                            loadAlbumImages(selectedAlbum.value.id);
                            loadAlbums();
                        }
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

        const getTypeClass = (type) => {
            const classes = {
                'Học tập': 'bg-primary',
                'Ngoại khóa': 'bg-success',
                'Sự kiện': 'bg-warning',
                'Sinh hoạt': 'bg-info',
                'Khác': 'bg-secondary'
            };
            return classes[type] || 'bg-secondary';
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
            getTypeClass
        };
    }
};
</script>

<style scoped>
.gallery-page {
    padding: 20px;
}

.stat-card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    margin-right: 15px;
}

.stat-primary .stat-icon {
    background: linear-gradient(135deg, #667eea, #764ba2);
}

.stat-success .stat-icon {
    background: linear-gradient(135deg, #28a745, #20c997);
}

.stat-warning .stat-icon {
    background: linear-gradient(135deg, #ffc107, #fd7e14);
}

.stat-info .stat-icon {
    background: linear-gradient(135deg, #17a2b8, #6f42c1);
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
    color: #2c3e50;
}

.stat-label {
    font-size: 0.9rem;
    color: #6c757d;
    margin: 0;
}

.album-card {
    border: none;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.album-card:hover {
    transform: translateY(-5px);
}

.album-cover {
    position: relative;
    height: 200px;
    overflow: hidden;
    cursor: pointer;
}

.album-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.album-card:hover .album-cover img {
    transform: scale(1.1);
}

.album-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
    display: flex;
    align-items: flex-end;
    padding: 20px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.album-card:hover .album-overlay {
    opacity: 1;
}

.album-info {
    color: white;
}

.album-info h5 {
    margin: 0;
    font-weight: 600;
}

.album-description {
    font-size: 0.9rem;
    color: #6c757d;
    margin: 0.5rem 0;
}

.image-item {
    position: relative;
}

.image-item:hover .image-actions {
    opacity: 1;
}

.image-actions {
    position: absolute;
    top: 5px;
    right: 5px;
    opacity: 0;
    transition: opacity 0.3s ease;
}
</style>
