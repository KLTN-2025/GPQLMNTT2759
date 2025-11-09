<template>
    <div class="notebook-page">
        <div class="page-header mb-4">
            <h2 class="page-title">
                <i class="bx bx-notebook me-2"></i>Sổ Liên Lạc
            </h2>
            <p class="page-subtitle">Trao đổi thông tin với phụ huynh</p>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3" v-for="student in students" :key="student.id">
                <div class="card student-notebook-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <img :src="student.avatar" class="student-avatar me-3" :alt="student.name" />
                            <div>
                                <h6 class="mb-0">{{ student.name }}</h6>
                                <small class="text-muted">{{ student.parentName }}</small>
                            </div>
                        </div>
                        <div class="notebook-stats">
                            <div class="stat-item">
                                <i class="bx bx-message text-primary"></i>
                                <span>{{ student.messageCount }} tin nhắn</span>
                            </div>
                            <div class="stat-item">
                                <i class="bx bx-time text-warning"></i>
                                <span>{{ student.lastUpdate }}</span>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-sm w-100 mt-3">
                            <i class="bx bx-edit me-2"></i>Viết nhận xét
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue';

export default {
    name: 'Notebook',
    setup() {
        const students = ref([
            { id: 1, name: 'Nguyễn Văn A', parentName: 'Nguyễn Văn X', messageCount: 5, lastUpdate: 'Hôm qua', avatar: '/src/assets/images/avatars/avatar-1.png' },
            { id: 2, name: 'Trần Thị B', parentName: 'Trần Văn Y', messageCount: 3, lastUpdate: '2 ngày trước', avatar: '/src/assets/images/avatars/avatar-2.png' },
            { id: 3, name: 'Lê Văn C', parentName: 'Lê Thị Z', messageCount: 8, lastUpdate: 'Hôm nay', avatar: '/src/assets/images/avatars/avatar-3.png' },
        ]);

        return { students };
    }
};
</script>

<style scoped>
.notebook-page {
    padding: 20px;
}

.student-notebook-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.student-notebook-card:hover {
    transform: translateY(-5px);
}

.student-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
}

.notebook-stats {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.9rem;
    color: #6c757d;
}
</style>
