<template>
    <div class="assignments-page">
        <div class="page-header mb-4">
            <h2 class="page-title">
                <i class="bx bx-book me-2"></i>Bài Tập
            </h2>
            <p class="page-subtitle">Quản lý bài tập và đánh giá học sinh</p>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <button class="btn btn-primary btn-lg">
                    <i class="bx bx-plus me-2"></i>Tạo bài tập mới
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3" v-for="assignment in assignments" :key="assignment.id">
                <div class="card assignment-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title">{{ assignment.title }}</h5>
                            <span class="badge" :class="'bg-' + assignment.statusColor">{{ assignment.status }}</span>
                        </div>
                        <p class="card-text">{{ assignment.description }}</p>
                        <div class="assignment-meta">
                            <div class="meta-item">
                                <i class="bx bx-calendar"></i>
                                <span>{{ assignment.dueDate }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="bx bx-user"></i>
                                <span>{{ assignment.submitted }}/{{ assignment.total }} đã nộp</span>
                            </div>
                        </div>
                        <div class="mt-3 d-flex gap-2">
                            <button class="btn btn-sm btn-primary flex-fill">Xem chi tiết</button>
                            <button class="btn btn-sm btn-outline-secondary">Chỉnh sửa</button>
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
    name: 'Assignments',
    setup() {
        const assignments = ref([
            { id: 1, title: 'Tập viết chữ A, B, C', description: 'Luyện tập viết các chữ cái đầu tiên', dueDate: '25/10/2024', submitted: 28, total: 30, status: 'Đang diễn ra', statusColor: 'primary' },
            { id: 2, title: 'Đếm số từ 1-10', description: 'Bài tập về số học cơ bản', dueDate: '20/10/2024', submitted: 30, total: 30, status: 'Hoàn thành', statusColor: 'success' },
            { id: 3, title: 'Vẽ tranh gia đình', description: 'Vẽ và tô màu tranh về gia đình', dueDate: '30/10/2024', submitted: 0, total: 30, status: 'Chưa bắt đầu', statusColor: 'secondary' },
        ]);

        return { assignments };
    }
};
</script>

<style scoped>
.assignments-page {
    padding: 20px;
}

.page-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #2c3e50;
}

.assignment-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.assignment-card:hover {
    transform: translateY(-5px);
}

.assignment-meta {
    display: flex;
    flex-direction: column;
    gap: 8px;
    padding-top: 12px;
    border-top: 1px solid #e9ecef;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #6c757d;
    font-size: 0.9rem;
}
</style>
