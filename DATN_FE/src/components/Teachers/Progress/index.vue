<template>
    <div class="progress-page">
        <!-- Header Section -->
        <div class="page-header education-theme">
            <div class="container-fluid">
                <div class="page-header-content">
                    <div class="page-icon">
                        <i class="bx bx-trending-up"></i>
                    </div>
                    <div class="page-info">
                        <h1 class="page-title">Tiến Độ Học Tập</h1>
                        <p class="page-subtitle">Theo dõi tiến độ học tập của học sinh</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Content -->
        <div class="progress-section">
            <div class="container-fluid">
                <div class="management-card">
                    <div class="card-header-custom">
                        <div class="header-content">
                            <div class="header-icon">
                                <i class="bx bx-line-chart"></i>
                            </div>
                            <div class="header-text">
                                <h5 class="card-title">Tiến độ học tập - Lớp Mầm 1A</h5>
                                <p class="card-subtitle">Theo dõi tiến độ học tập các môn học</p>
                            </div>
                        </div>
                        <div class="header-actions">
                            <div class="search-wrapper">
                                <i class="bx bx-search"></i>
                                <input type="text" placeholder="Tìm kiếm học sinh..." v-model="searchQuery"
                                    class="search-input" />
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div v-if="filteredStudents.length === 0" class="empty-state">
                            <i class="bx bx-user-x"></i>
                            <h3>Không tìm thấy học sinh</h3>
                            <p>Thử tìm kiếm với từ khóa khác</p>
                        </div>
                        <div v-else class="table-container">
                            <table class="table table-modern">
                                <thead>
                                    <tr>
                                        <th class="col-index">STT</th>
                                        <th class="col-student">Học sinh</th>
                                        <th class="col-subject">Toán</th>
                                        <th class="col-subject">Tiếng Việt</th>
                                        <th class="col-subject">Vận động</th>
                                        <th class="col-subject">Âm nhạc</th>
                                        <th class="col-subject">Mỹ thuật</th>
                                        <th class="col-average">Trung bình</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(student, index) in filteredStudents" :key="student.id"
                                        class="student-row">
                                        <td class="col-index">
                                            <span class="index-badge">{{ index + 1 }}</span>
                                        </td>
                                        <td class="col-student">
                                            <div class="student-container">
                                                <div class="student-avatar-wrapper">
                                                    <img :src="student.avatar" :alt="student.name" class="avatar-img"
                                                        @error="handleImageError" />
                                                </div>
                                                <div class="student-details">
                                                    <span class="student-name">{{ student.name }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col-subject">
                                            <div class="progress-wrapper">
                                                <div class="progress-bar-custom">
                                                    <div class="progress-fill progress-math"
                                                        :style="{ width: student.math + '%' }">
                                                        <span class="progress-text">{{ student.math }}%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col-subject">
                                            <div class="progress-wrapper">
                                                <div class="progress-bar-custom">
                                                    <div class="progress-fill progress-vietnamese"
                                                        :style="{ width: student.vietnamese + '%' }">
                                                        <span class="progress-text">{{ student.vietnamese }}%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col-subject">
                                            <div class="progress-wrapper">
                                                <div class="progress-bar-custom">
                                                    <div class="progress-fill progress-physical"
                                                        :style="{ width: student.physical + '%' }">
                                                        <span class="progress-text">{{ student.physical }}%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col-subject">
                                            <div class="progress-wrapper">
                                                <div class="progress-bar-custom">
                                                    <div class="progress-fill progress-music"
                                                        :style="{ width: student.music + '%' }">
                                                        <span class="progress-text">{{ student.music }}%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col-subject">
                                            <div class="progress-wrapper">
                                                <div class="progress-bar-custom">
                                                    <div class="progress-fill progress-art"
                                                        :style="{ width: student.art + '%' }">
                                                        <span class="progress-text">{{ student.art }}%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col-average">
                                            <span class="badge badge-average" :class="getAverageClass(student.average)">
                                                {{ student.average }}%
                                            </span>
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
import { ref, computed } from 'vue';

export default {
    name: 'Progress',
    setup() {
        const searchQuery = ref('');

        const students = ref([
            {
                id: 1,
                name: 'Nguyễn Văn A',
                math: 85,
                vietnamese: 90,
                physical: 95,
                music: 88,
                art: 92,
                average: 90,
                avatar: '/src/assets/images/avatars/avatar-1.png'
            },
            {
                id: 2,
                name: 'Trần Thị B',
                math: 92,
                vietnamese: 88,
                physical: 90,
                music: 85,
                art: 90,
                average: 89,
                avatar: '/src/assets/images/avatars/avatar-2.png'
            },
            {
                id: 3,
                name: 'Lê Văn C',
                math: 78,
                vietnamese: 82,
                physical: 85,
                music: 90,
                art: 88,
                average: 85,
                avatar: '/src/assets/images/avatars/avatar-3.png'
            },
        ]);

        const filteredStudents = computed(() => {
            if (!searchQuery.value) return students.value;
            const query = searchQuery.value.toLowerCase();
            return students.value.filter(student =>
                student.name?.toLowerCase().includes(query)
            );
        });

        const getAverageClass = (average) => {
            if (average >= 90) return 'badge-excellent';
            if (average >= 80) return 'badge-good';
            if (average >= 70) return 'badge-average';
            return 'badge-poor';
        };

        const handleImageError = (event) => {
            event.target.src = 'https://ui-avatars.com/api/?name=' + encodeURIComponent(event.target.alt) + '&background=667eea&color=fff&size=128';
        };

        return {
            students,
            searchQuery,
            filteredStudents,
            getAverageClass,
            handleImageError
        };
    }
};
</script>

<style lang="scss">
@use './style.scss';
</style>
