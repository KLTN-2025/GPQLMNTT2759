<template>
    <div class="attendance-page">
        <div class="page-header mb-4">
            <h2 class="page-title">
                <i class="bx bx-check-square me-2"></i>Điểm Danh
            </h2>
            <p class="page-subtitle">Quản lý điểm danh học sinh hàng ngày</p>
        </div>

        <!-- Date & Class Selection -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <label class="form-label"><i class="bx bx-calendar me-2"></i>Ngày điểm danh</label>
                        <input type="date" class="form-control" v-model="selectedDate" />
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <label class="form-label"><i class="bx bx-time me-2"></i>Buổi học</label>
                        <select class="form-select" v-model="selectedSession">
                            <option value="morning">Buổi sáng</option>
                            <option value="afternoon">Buổi chiều</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Stats -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stat-card present">
                    <div class="stat-icon"><i class="bx bx-check"></i></div>
                    <div class="stat-info">
                        <h3>{{ presentCount }}</h3>
                        <p>Có mặt</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card absent">
                    <div class="stat-icon"><i class="bx bx-x"></i></div>
                    <div class="stat-info">
                        <h3>{{ absentCount }}</h3>
                        <p>Vắng mặt</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card late">
                    <div class="stat-icon"><i class="bx bx-time"></i></div>
                    <div class="stat-info">
                        <h3>{{ lateCount }}</h3>
                        <p>Đi muộn</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card total">
                    <div class="stat-icon"><i class="bx bx-group"></i></div>
                    <div class="stat-info">
                        <h3>{{ totalStudents }}</h3>
                        <p>Tổng số</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance List -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Danh sách điểm danh - Lớp Mầm 1A</h5>
                <button class="btn btn-success" @click="saveAttendance">
                    <i class="bx bx-save me-2"></i>Lưu điểm danh
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Học sinh</th>
                                <th class="text-center">Có mặt</th>
                                <th class="text-center">Vắng mặt</th>
                                <th class="text-center">Đi muộn</th>
                                <th>Ghi chú</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(student, index) in students" :key="student.id">
                                <td>{{ index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img :src="student.avatar" class="student-avatar me-2" :alt="student.name" />
                                        <div>
                                            <strong>{{ student.name }}</strong>
                                            <br><small class="text-muted">{{ student.parentName }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <input type="radio" :name="'attendance-' + student.id" value="present"
                                        v-model="student.status" class="form-check-input status-present" />
                                </td>
                                <td class="text-center">
                                    <input type="radio" :name="'attendance-' + student.id" value="absent"
                                        v-model="student.status" class="form-check-input status-absent" />
                                </td>
                                <td class="text-center">
                                    <input type="radio" :name="'attendance-' + student.id" value="late"
                                        v-model="student.status" class="form-check-input status-late" />
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm" v-model="student.note"
                                        placeholder="Ghi chú..." />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, computed } from 'vue';

export default {
    name: 'Attendance',
    setup() {
        const selectedDate = ref(new Date().toISOString().split('T')[0]);
        const selectedSession = ref('morning');

        const students = ref([
            { id: 1, name: 'Nguyễn Văn A', parentName: 'Nguyễn Văn X', status: 'present', note: '', avatar: '/src/assets/images/avatars/avatar-1.png' },
            { id: 2, name: 'Trần Thị B', parentName: 'Trần Văn Y', status: 'present', note: '', avatar: '/src/assets/images/avatars/avatar-2.png' },
            { id: 3, name: 'Lê Văn C', parentName: 'Lê Thị Z', status: 'late', note: 'Đi muộn 15 phút', avatar: '/src/assets/images/avatars/avatar-3.png' },
            { id: 4, name: 'Phạm Thị D', parentName: 'Phạm Văn K', status: 'absent', note: 'Ốm', avatar: '/src/assets/images/avatars/avatar-4.png' },
            { id: 5, name: 'Hoàng Văn E', parentName: 'Hoàng Thị L', status: 'present', note: '', avatar: '/src/assets/images/avatars/avatar-5.png' },
        ]);

        const presentCount = computed(() => students.value.filter(s => s.status === 'present').length);
        const absentCount = computed(() => students.value.filter(s => s.status === 'absent').length);
        const lateCount = computed(() => students.value.filter(s => s.status === 'late').length);
        const totalStudents = computed(() => students.value.length);

        const saveAttendance = () => {
            alert('Đã lưu điểm danh thành công!');
        };

        return {
            selectedDate,
            selectedSession,
            students,
            presentCount,
            absentCount,
            lateCount,
            totalStudents,
            saveAttendance
        };
    }
};
</script>

<style scoped>
.attendance-page {
    padding: 20px;
}

.page-header {
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 15px;
}

.page-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.page-subtitle {
    color: #6c757d;
    margin: 0;
}

.stat-card {
    padding: 20px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    gap: 15px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.stat-card.present {
    background: linear-gradient(135deg, #5cb85c 0%, #4cae4c 100%);
    color: white;
}

.stat-card.absent {
    background: linear-gradient(135deg, #d9534f 0%, #c9302c 100%);
    color: white;
}

.stat-card.late {
    background: linear-gradient(135deg, #f0ad4e 0%, #ec971f 100%);
    color: white;
}

.stat-card.total {
    background: linear-gradient(135deg, #5bc0de 0%, #46b8da 100%);
    color: white;
}

.stat-icon {
    font-size: 2.5rem;
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.stat-info h3 {
    margin: 0;
    font-size: 2rem;
    font-weight: 700;
}

.stat-info p {
    margin: 0;
    font-size: 0.9rem;
}

.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.card-header {
    background: #f8f9fa;
    border-bottom: 2px solid #e9ecef;
    padding: 1.25rem;
    border-radius: 15px 15px 0 0;
}

.student-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.status-present:checked {
    background-color: #5cb85c;
    border-color: #5cb85c;
}

.status-absent:checked {
    background-color: #d9534f;
    border-color: #d9534f;
}

.status-late:checked {
    background-color: #f0ad4e;
    border-color: #f0ad4e;
}

.form-check-input {
    cursor: pointer;
    width: 20px;
    height: 20px;
}
</style>
