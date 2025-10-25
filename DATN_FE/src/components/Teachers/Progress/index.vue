<template>
    <div class="progress-page">
        <div class="page-header mb-4">
            <h2 class="page-title">
                <i class="bx bx-trending-up me-2"></i>Tiến Độ Học Tập
            </h2>
            <p class="page-subtitle">Theo dõi tiến độ học tập của học sinh</p>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Tiến độ học tập - Lớp Mầm 1A</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Học sinh</th>
                                        <th>Toán</th>
                                        <th>Tiếng Việt</th>
                                        <th>Vận động</th>
                                        <th>Âm nhạc</th>
                                        <th>Mỹ thuật</th>
                                        <th>Trung bình</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(student, index) in students" :key="student.id">
                                        <td>{{ index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img :src="student.avatar" class="student-avatar me-2"
                                                    :alt="student.name" />
                                                <strong>{{ student.name }}</strong>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="progress-bar-wrapper">
                                                <div class="progress">
                                                    <div class="progress-bar bg-primary"
                                                        :style="{ width: student.math + '%' }">{{ student.math }}%</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="progress-bar-wrapper">
                                                <div class="progress">
                                                    <div class="progress-bar bg-success"
                                                        :style="{ width: student.vietnamese + '%' }">{{
                                                        student.vietnamese }}%</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="progress-bar-wrapper">
                                                <div class="progress">
                                                    <div class="progress-bar bg-info"
                                                        :style="{ width: student.physical + '%' }">{{ student.physical
                                                        }}%</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="progress-bar-wrapper">
                                                <div class="progress">
                                                    <div class="progress-bar bg-warning"
                                                        :style="{ width: student.music + '%' }">{{ student.music }}%
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="progress-bar-wrapper">
                                                <div class="progress">
                                                    <div class="progress-bar bg-danger"
                                                        :style="{ width: student.art + '%' }">{{ student.art }}%</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ student.average }}%</span>
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
    name: 'Progress',
    setup() {
        const students = ref([
            { id: 1, name: 'Nguyễn Văn A', math: 85, vietnamese: 90, physical: 95, music: 88, art: 92, average: 90, avatar: '/src/assets/images/avatars/avatar-1.png' },
            { id: 2, name: 'Trần Thị B', math: 92, vietnamese: 88, physical: 90, music: 85, art: 90, average: 89, avatar: '/src/assets/images/avatars/avatar-2.png' },
            { id: 3, name: 'Lê Văn C', math: 78, vietnamese: 82, physical: 85, music: 90, art: 88, average: 85, avatar: '/src/assets/images/avatars/avatar-3.png' },
        ]);

        return { students };
    }
};
</script>

<style scoped>
.progress-page {
    padding: 20px;
}

.student-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.progress-bar-wrapper {
    min-width: 120px;
}

.progress {
    height: 25px;
    border-radius: 12px;
}

.progress-bar {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 600;
}
</style>
