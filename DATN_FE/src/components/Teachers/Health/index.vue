<template>
    <div class="health-page">
        <div class="page-header mb-4">
            <h2 class="page-title">
                <i class="bx bx-heart me-2"></i>Sức Khỏe
            </h2>
            <p class="page-subtitle">Theo dõi sức khỏe học sinh</p>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Hồ sơ sức khỏe - Lớp Mầm 1A</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Học sinh</th>
                                        <th>Chiều cao (cm)</th>
                                        <th>Cân nặng (kg)</th>
                                        <th>BMI</th>
                                        <th>Nhóm máu</th>
                                        <th>Ghi chú sức khỏe</th>
                                        <th>Thao tác</th>
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
                                        <td>{{ student.height }}</td>
                                        <td>{{ student.weight }}</td>
                                        <td>
                                            <span class="badge" :class="'bg-' + student.bmiStatus">{{ student.bmi
                                                }}</span>
                                        </td>
                                        <td>{{ student.bloodType }}</td>
                                        <td>{{ student.healthNote }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary">
                                                <i class="bx bx-edit"></i>
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
    name: 'Health',
    setup() {
        const students = ref([
            { id: 1, name: 'Nguyễn Văn A', height: '105', weight: '17', bmi: '15.4', bmiStatus: 'success', bloodType: 'O', healthNote: 'Khỏe mạnh', avatar: '/src/assets/images/avatars/avatar-1.png' },
            { id: 2, name: 'Trần Thị B', height: '102', weight: '16', bmi: '15.1', bmiStatus: 'success', bloodType: 'A', healthNote: 'Bình thường', avatar: '/src/assets/images/avatars/avatar-2.png' },
            { id: 3, name: 'Lê Văn C', height: '108', weight: '19', bmi: '16.3', bmiStatus: 'warning', bloodType: 'B', healthNote: 'Hơi thừa cân', avatar: '/src/assets/images/avatars/avatar-3.png' },
        ]);

        return { students };
    }
};
</script>

<style scoped>
.health-page {
    padding: 20px;
}

.student-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}
</style>
