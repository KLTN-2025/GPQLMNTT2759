<template>
    <div class="reports-page">
        <div class="page-header mb-4">
            <h2 class="page-title">
                <i class="bx bx-file me-2"></i>Báo Cáo Học Tập
            </h2>
            <p class="page-subtitle">Tạo và quản lý báo cáo học tập</p>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <label class="form-label">Loại báo cáo</label>
                        <select class="form-select">
                            <option>Báo cáo tuần</option>
                            <option>Báo cáo tháng</option>
                            <option>Báo cáo học kỳ</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <label class="form-label">Thời gian</label>
                        <input type="month" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body d-flex align-items-end">
                        <button class="btn btn-primary me-2">
                            <i class="bx bx-search me-2"></i>Xem báo cáo
                        </button>
                        <button class="btn btn-success">
                            <i class="bx bx-plus me-2"></i>Tạo báo cáo mới
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Danh sách báo cáo</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tiêu đề</th>
                                        <th>Loại</th>
                                        <th>Thời gian</th>
                                        <th>Ngày tạo</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="report in reports" :key="report.id">
                                        <td><strong>{{ report.title }}</strong></td>
                                        <td>{{ report.type }}</td>
                                        <td>{{ report.period }}</td>
                                        <td>{{ report.createdDate }}</td>
                                        <td>
                                            <span class="badge" :class="'bg-' + report.statusColor">{{ report.status
                                                }}</span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-primary me-1">
                                                <i class="bx bx-show"></i>
                                            </button>
                                            <button class="btn btn-sm btn-success me-1">
                                                <i class="bx bx-download"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue';

export default {
    name: 'Reports',
    setup() {
        const reports = ref([
            { id: 1, title: 'Báo cáo tháng 9/2024', type: 'Tháng', period: '09/2024', createdDate: '30/09/2024', status: 'Hoàn thành', statusColor: 'success' },
            { id: 2, title: 'Báo cáo tuần 01-05/10', type: 'Tuần', period: '01-05/10/2024', createdDate: '05/10/2024', status: 'Đang soạn', statusColor: 'warning' },
        ]);

        return { reports };
    }
};
</script>

<style scoped>
.reports-page {
    padding: 20px;
}
</style>
