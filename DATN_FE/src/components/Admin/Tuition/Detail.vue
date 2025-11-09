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
                            <div class="fee-icon-large" :class="getFeeTypeClass(feeDetail?.loai_phi)">
                                <i :class="getFeeTypeIcon(feeDetail?.loai_phi)" style="font-size: 3rem;"></i>
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
                                <template v-for="(value, index) in list_hoc_sinh" :key="index">
                                    <tr class="table-row-hover">
                                        <td class="text-center table-index">
                                            {{ index + 1 }}
                                        </td>
                                        <td class="student-info">
                                            <div class="student-container">
                                                <div class="student-avatar"
                                                    :class="getPaymentStatusClass(value.trang_thai)">
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
                                            <span class="class-badge">{{ value.lop_hoc }}</span>
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
                                            <span class="payment-status-badge"
                                                :class="getPaymentStatusBadgeClass(value.trang_thai)">
                                                <i :class="getPaymentStatusIcon(value.trang_thai)"></i>
                                                {{ getPaymentStatusText(value.trang_thai) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="due-date">
                                                <div class="due-date-text"
                                                    :class="getDueDateClass(value.han_thanh_toan)">
                                                    {{ formatDate(value.han_thanh_toan) }}
                                                </div>
                                                <small class="due-date-status">{{
                                                    getDueDateStatus(value.han_thanh_toan) }}</small>
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
                                </template>
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
        const feeId = this.$route.query.id;
        const feeType = this.$route.query.loai_phi;
        if (feeId) {
            this.loadFeeDetail(feeId);
            this.loadStudentList(feeId, feeType);
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

        getFeeTypeLabel(type) {
            const labels = {
                'hoc_phi_co_ban': 'Học phí cơ bản',
                'phi_an_uong': 'Phí ăn uống',
                'phi_hoat_dong': 'Phí hoạt động'
            };
            return labels[type] || type;
        },

        getFeeTypeIcon(type) {
            switch (type) {
                case 'hoc_phi_co_ban':
                    return 'fas fa-graduation-cap';
                case 'phi_an_uong':
                    return 'fas fa-utensils';
                case 'phi_hoat_dong':
                    return 'fas fa-running';
                default:
                    return 'fas fa-money-bill-wave';
            }
        },

        getFeeTypeClass(type) {
            return {
                'fee-basic': type === 'hoc_phi_co_ban',
                'fee-meal': type === 'phi_an_uong',
                'fee-activity': type === 'phi_hoat_dong',
            };
        },

        getPaymentStatusClass(status) {
            return {
                'payment-paid': status === 'paid',
                'payment-pending': status === 'pending',
                'payment-overdue': status === 'overdue',
            };
        },

        getPaymentStatusBadgeClass(status) {
            return {
                'status-paid': status === 'paid',
                'status-pending': status === 'pending',
                'status-overdue': status === 'overdue',
            };
        },

        getPaymentStatusIcon(status) {
            switch (status) {
                case 'paid':
                    return 'fas fa-check-circle';
                case 'pending':
                    return 'fas fa-clock';
                case 'overdue':
                    return 'fas fa-exclamation-triangle';
                default:
                    return 'fas fa-question';
            }
        },

        getPaymentStatusText(status) {
            switch (status) {
                case 'paid':
                    return 'Đã thanh toán';
                case 'pending':
                    return 'Chưa thanh toán';
                case 'overdue':
                    return 'Quá hạn';
                default:
                    return 'Chưa rõ';
            }
        },

        getDueDateClass(dueDate) {
            if (!dueDate) return 'text-muted';
            const today = new Date();
            const due = new Date(dueDate);
            today.setHours(0, 0, 0, 0);
            due.setHours(0, 0, 0, 0);
            if (due < today) {
                return 'text-danger';
            } else if (due.getTime() - today.getTime() < 7 * 24 * 60 * 60 * 1000) {
                return 'text-warning';
            }
            return 'text-success';
        },

        getDueDateStatus(dueDate) {
            if (!dueDate) return '';
            const today = new Date();
            const due = new Date(dueDate);
            today.setHours(0, 0, 0, 0);
            due.setHours(0, 0, 0, 0);
            if (due < today) {
                return 'Quá hạn';
            } else if (due.getTime() - today.getTime() < 7 * 24 * 60 * 60 * 1000) {
                return 'Sắp đến hạn';
            }
            return 'Còn thời gian';
        },

        loadFeeDetail(feeId) {
            baseRequestAdmin
                .get(`admin/loai-phi/${feeId}`)
                .then((res) => {
                    if (res.data.status) {
                        this.feeDetail = res.data.data;
                    }
                })
                .catch((err) => {
                    console.log("Không thể tải chi tiết loại phí");
                });
        },

        loadStudentList(feeId, feeType) {
            baseRequestAdmin
                .get(`admin/loai-phi/${feeId}/hoc-sinh`, { params: { loai_phi: feeType } })
                .then((res) => {
                    if (res.data.status) {
                        this.list_hoc_sinh = res.data.data;
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
                        this.$toast.error("Có lỗi xảy ra khi tải danh sách học sinh");
                    }
                });
        },

        TiemKiem() {
            const feeId = this.$route.query.id;
            const feeType = this.$route.query.loai_phi;
            const searchData = { ...this.search, loai_phi_id: feeId };
            baseRequestAdmin
                .post("admin/loai-phi/search-students", searchData)
                .then((res) => {
                    if (res.data.status) {
                        this.$toast.success(res.data.message);
                        this.list_hoc_sinh = res.data.data;
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
@use "../shared-styles";
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
    padding: 0.5rem 1rem;
    border-radius: 20px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    font-weight: 500;
    font-size: 0.85rem;
}
</style>
