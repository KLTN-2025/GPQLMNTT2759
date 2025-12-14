<template>
    <div class="page-header education-theme">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-header-content">
                        <div class="page-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="page-info">
                            <h1 class="page-title">{{ feeDetail?.ten_loai_phi || 'Chi Tiết Loại Phí' }}</h1>
                            <p class="page-subtitle">
                                Danh sách học sinh liên quan đến loại phí này
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
                            <li class="breadcrumb-item">
                                <i class="fas fa-money-bill-wave"></i>
                                <router-link to="/admin/hoc-phi">Học Phí</router-link>
                            </li>
                            <li class="breadcrumb-item active">
                                <i class="fas fa-list"></i>
                                Chi Tiết
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Fee Info Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center">
                            <div class="fee-icon-large" :class="{
                                'fee-basic': feeDetail?.loai_phi === 'hoc_phi_co_ban',
                                'fee-meal': feeDetail?.loai_phi === 'phi_an_uong',
                                'fee-activity': feeDetail?.loai_phi === 'phi_hoat_dong'
                            }">
                                <i :class="feeDetail?.loai_phi === 'hoc_phi_co_ban' ? 'fas fa-graduation-cap' :
                                    feeDetail?.loai_phi === 'phi_an_uong' ? 'fas fa-utensils' :
                                        feeDetail?.loai_phi === 'phi_hoat_dong' ? 'fas fa-running' :
                                            'fas fa-money-bill-wave'" style="font-size: 3rem;"></i>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <h4>{{ feeDetail?.ten_loai_phi }}</h4>
                            <p class="text-muted">{{ feeDetail?.mo_ta || 'Chưa có mô tả' }}</p>
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="stat-box">
                                        <div class="stat-label">Số học sinh</div>
                                        <div class="stat-value">{{ list_hoc_sinh.length }}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="stat-box">
                                        <div class="stat-label">Tổng số tiền</div>
                                        <div class="stat-value">{{ formatCurrency(feeDetail?.tong_tien) }}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="stat-box">
                                        <div class="stat-label">Đã thu</div>
                                        <div class="stat-value text-success">{{ formatCurrency(feeDetail?.da_thu) }}
                                        </div>
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
            <div class="management-card">
                <div class="card-header-custom">
                    <div class="header-content">
                        <div class="header-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="header-text">
                            <h5 class="card-title">Danh Sách Học Sinh</h5>
                            <p class="card-subtitle">Học sinh liên quan đến loại phí: {{ feeDetail?.ten_loai_phi }}</p>
                        </div>
                    </div>
                    <button class="btn btn-secondary btn-modern" @click="$router.push('/admin/hoc-phi')">
                        <i class="fas fa-arrow-left"></i>
                        Quay Lại
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
                                    class="search-input" placeholder="Tìm kiếm theo tên học sinh..." />
                            </div>

                            <div class="search-filters">
                                <select v-on:change="TiemKiem()" class="filter-select" v-model="search.lop_hoc">
                                    <option value="">Tất cả lớp</option>
                                    <option value="Lớp Mầm">Lớp Mầm</option>
                                    <option value="Lớp Chồi">Lớp Chồi</option>
                                    <option value="Lớp Lá">Lớp Lá</option>
                                </select>
                                <select v-on:change="TiemKiem()" class="filter-select" v-model="search.trang_thai">
                                    <option value="">Tất cả trạng thái</option>
                                    <option value="paid">Đã thanh toán</option>
                                    <option value="pending">Chưa thanh toán</option>
                                    <option value="overdue">Quá hạn</option>
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
                                    <th class="text-center">Lớp</th>
                                    <th class="text-center">Số Tiền</th>
                                    <th class="text-center">Đã Thanh Toán</th>
                                    <th class="text-center">Còn Lại</th>
                                    <th class="text-center">Trạng Thái</th>
                                    <th class="text-center">Hạn Thanh Toán</th>
                                    <th class="text-center">Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-if="list_hoc_sinh.length === 0">
                                    <td colspan="9" class="text-center py-4">
                                        <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                        <p class="text-muted mb-0">Chưa có dữ liệu học sinh</p>
                                    </td>
                                </tr>
                                <tr v-for="(value, index) in list_hoc_sinh" :key="value.id || index"
                                    class="table-row-hover">
                                    <td class="text-center table-index">
                                        {{ index + 1 }}
                                    </td>
                                    <td class="student-info">
                                        <div class="student-container">
                                            <div class="student-avatar" :class="{
                                                'payment-paid': value.trang_thai === 'paid',
                                                'payment-pending': value.trang_thai === 'pending',
                                                'payment-overdue': value.trang_thai === 'overdue'
                                            }">
                                                <img :src="value.avatar || '/default-avatar.jpg'"
                                                    :alt="value.ten_hoc_sinh" class="avatar-img" />
                                            </div>
                                            <div class="student-details">
                                                <span class="student-name">{{ value.ten_hoc_sinh }}</span>
                                                <small class="student-id">Mã: {{ value.ma_hoc_sinh }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="class-badge">
                                            <i class="fas fa-graduation-cap"></i>
                                            {{ value.lop_hoc }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="amount-info">
                                            <div class="total-amount">{{ formatCurrency(value.so_tien) }}</div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="payment-info">
                                            <div class="paid-amount">{{ formatCurrency(value.da_thanh_toan) }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="remaining-amount"
                                            :class="value.con_lai > 0 ? 'text-warning' : 'text-success'">
                                            {{ formatCurrency(value.con_lai) }}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="payment-status-badge" :class="{
                                            'status-paid': value.trang_thai === 'paid',
                                            'status-pending': value.trang_thai === 'pending',
                                            'status-overdue': value.trang_thai === 'overdue'
                                        }">
                                            <i :class="value.trang_thai === 'paid' ? 'fas fa-check-circle' :
                                                value.trang_thai === 'pending' ? 'fas fa-clock' :
                                                    value.trang_thai === 'overdue' ? 'fas fa-exclamation-triangle' :
                                                        'fas fa-question'"></i>
                                            <template v-if="value.trang_thai === 'paid'">Đã thanh toán</template>
                                            <template v-else-if="value.trang_thai === 'pending'">Chưa thanh
                                                toán</template>
                                            <template v-else-if="value.trang_thai === 'overdue'">Quá hạn</template>
                                            <template v-else>Chưa rõ</template>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="due-date">
                                            <div class="due-date-text" :class="!value.han_thanh_toan ? 'text-muted' :
                                                (() => {
                                                    const today = new Date();
                                                    const due = new Date(value.han_thanh_toan);
                                                    today.setHours(0, 0, 0, 0);
                                                    due.setHours(0, 0, 0, 0);
                                                    if (due < today) return 'text-danger';
                                                    if (due.getTime() - today.getTime() < 7 * 24 * 60 * 60 * 1000) return 'text-warning';
                                                    return 'text-success';
                                                })()">
                                                {{ formatDate(value.han_thanh_toan) }}
                                            </div>
                                            <small class="due-date-status">
                                                <template v-if="!value.han_thanh_toan"></template>
                                                <template v-else>
                                                    <template v-if="(() => {
                                                        const today = new Date();
                                                        const due = new Date(value.han_thanh_toan);
                                                        today.setHours(0, 0, 0, 0);
                                                        due.setHours(0, 0, 0, 0);
                                                        return due < today;
                                                    })()">Quá hạn</template>
                                                    <template v-else-if="(() => {
                                                        const today = new Date();
                                                        const due = new Date(value.han_thanh_toan);
                                                        today.setHours(0, 0, 0, 0);
                                                        due.setHours(0, 0, 0, 0);
                                                        return due.getTime() - today.getTime() < 7 * 24 * 60 * 60 * 1000;
                                                    })()">Sắp đến hạn</template>
                                                    <template v-else>Còn thời gian</template>
                                                </template>
                                            </small>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="action-buttons">
                                            <button class="btn-action btn-payment" @click="processPayment(value)"
                                                title="Thanh toán" v-if="value.con_lai > 0">
                                                <i class="fas fa-credit-card"></i>
                                            </button>
                                            <button class="btn-action btn-view" @click="viewStudentDetails(value)"
                                                title="Xem chi tiết">
                                                <i class="fas fa-eye"></i>
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
</template>

<script>
import axios from "axios";
import baseRequestAdmin from "../../../core/baseRequestAdmin";

export default {
    data() {
        return {
            feeDetail: {},
            list_hoc_sinh: [],
            search: {
                noi_dung: "",
                lop_hoc: "",
                trang_thai: "",
            },
            loading: false,
        };
    },

    mounted() {
        const classId = this.$route.query.id; // id lớp học
        if (classId) {
            this.loadClassDetail(classId);
        } else {
            this.$router.push('/admin/hoc-phi');
        }
    },

    methods: {
        formatCurrency(amount) {
            if (!amount) return "0 VNĐ";
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(amount);
        },

        formatDate(dateString) {
            if (!dateString) return "";
            const date = new Date(dateString);
            return date.toLocaleDateString("vi-VN");
        },

        loadClassDetail(classId) {
            if (!classId) {
                this.$toast.error("Không tìm thấy ID lớp học");
                return;
            }

            this.loading = true;
            baseRequestAdmin
                .get(`admin/hoc-phi/chi-tiet-hoc-phi/data?id=${classId}`)
                .then((res) => {
                    if (res.data.status) {
                        // Lấy dữ liệu từ response - cấu trúc: data.feeDetail và data.list_hoc_sinh
                        const feeDetailData = res.data.data.feeDetail || {};
                        const listHocSinhData = res.data.data.list_hoc_sinh || [];

                        // Gán thông tin loại phí
                        this.feeDetail = {
                            ...feeDetailData
                        };

                        // Gán danh sách học sinh - dữ liệu đã đầy đủ từ backend
                        this.list_hoc_sinh = Array.isArray(listHocSinhData) ? listHocSinhData : [];

                        console.log('Loaded feeDetail:', this.feeDetail);
                        console.log('Loaded students:', this.list_hoc_sinh.length, this.list_hoc_sinh);
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
                        this.$toast.error("Có lỗi xảy ra khi tải chi tiết lớp học");
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        TiemKiem() {
            // Tìm kiếm local trong danh sách học sinh đã load
            const classId = this.$route.query.id;
            if (!classId) {
                this.$toast.error("Không tìm thấy ID lớp học");
                return;
            }

            // Reload lại dữ liệu với filter
            this.loading = true;
            baseRequestAdmin
                .get(`admin/hoc-phi/chi-tiet-hoc-phi/data?id=${classId}`)
                .then((res) => {
                    if (res.data.status) {
                        const feeDetailData = res.data.data.feeDetail || {};
                        let listHocSinhData = res.data.data.list_hoc_sinh || [];

                        // Filter theo tên học sinh
                        if (this.search.noi_dung && this.search.noi_dung.trim()) {
                            const searchTerm = this.search.noi_dung.trim().toLowerCase();
                            listHocSinhData = listHocSinhData.filter(hs =>
                                (hs.ten_hoc_sinh || '').toLowerCase().includes(searchTerm)
                            );
                        }

                        // Filter theo lớp học (nếu có)
                        if (this.search.lop_hoc && this.search.lop_hoc.trim()) {
                            listHocSinhData = listHocSinhData.filter(hs =>
                                (hs.lop_hoc || '').includes(this.search.lop_hoc)
                            );
                        }

                        // Filter theo trạng thái (nếu có)
                        if (this.search.trang_thai && this.search.trang_thai.trim()) {
                            listHocSinhData = listHocSinhData.filter(hs =>
                                hs.trang_thai === this.search.trang_thai
                            );
                        }

                        // Gán danh sách học sinh đã filter
                        this.list_hoc_sinh = Array.isArray(listHocSinhData) ? listHocSinhData : [];

                        this.$toast.success("Tìm kiếm thành công");
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
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        viewStudentDetails(student) {
            // Navigate to student detail page
            this.$router.push(`/admin/hoc-sinh/${student.id}`);
        },

        processPayment(payment) {
            // Implement process payment functionality
            alert(`Xử lý thanh toán cho: ${payment.ten_hoc_sinh}`);
        },
    },
};
</script>

<style lang="scss">
@use "../admin-styles.scss";
@use "./style.scss";

.fee-icon-large {
    width: 120px;
    height: 120px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    color: white;

    &.fee-basic {
        background: linear-gradient(135deg, #667eea, #764ba2);
    }

    &.fee-meal {
        background: linear-gradient(135deg, #28a745, #20c997);
    }

    &.fee-activity {
        background: linear-gradient(135deg, #17a2b8, #6f42c1);
    }
}

.stat-box {
    text-align: center;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 10px;

    .stat-label {
        font-size: 0.85rem;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2c3e50;
    }
}

.class-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.6rem 1.2rem;
    border-radius: 50px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    font-weight: 600;
    font-size: 0.9rem;
    white-space: nowrap;
    box-shadow: 0 4px 6px rgba(102, 126, 234, 0.25);
    min-width: 140px;

    i {
        font-size: 1rem;
        opacity: 0.9;
    }
}
</style>
