<template>
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Quản lý Điểm Danh</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                        <li class="breadcrumb-item active">Điểm Danh</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="py-4">
        <div class="card shadow border-0 rounded-4">
            <div class="card-body">
                <!-- Tiêu đề + Bộ lọc (cùng một hàng) -->
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
                    <h5 class="fw-bold mb-0">📋 Điểm danh</h5>
                    <div class="d-flex flex-wrap gap-2">
                        <input type="date" class="form-control w-auto" v-model="selectedDate" />
                        <select class="form-select w-auto" v-model="selectedClass">
                            <option disabled value="">Chọn lớp</option>
                            <option value="Lá">Lớp Lá</option>
                            <option value="Chồi">Lớp Chồi</option>
                        </select>
                    </div>
                </div>


                <!-- Ngày lớp -->
                <h6 class="mb-4 text-muted">📅 Lớp {{ selectedClass }} - Ngày {{ selectedDate }}</h6>

                <!-- Grid học sinh -->
                <div class="row g-4">
                    <div class="col-12 col-md-6 col-lg-4" v-for="student in students" :key="student.id">
                        <div
                            class="p-4 border rounded-4 h-100 shadow-sm d-flex flex-column justify-content-between hover-scale">
                            <div>
                                <h6 class="fw-bold mb-2">{{ student.name }}</h6>
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <button class="btn btn-sm btn-success rounded-circle"
                                        :class="{ 'opacity-50': student.status !== 'present' }"
                                        @click="updateStatus(student, 'present')">✔</button>
                                    <button class="btn btn-sm btn-danger rounded-circle"
                                        :class="{ 'opacity-50': student.status !== 'absent' }"
                                        @click="updateStatus(student, 'absent')">✖</button>
                                    <button class="btn btn-sm btn-warning rounded-circle"
                                        :class="{ 'opacity-50': student.status !== 'late' }"
                                        @click="updateStatus(student, 'late')">⏰</button>
                                </div>
                            </div>
                            <div class="mt-auto">
                                <span class="text-muted">Trạng thái:</span>
                                <span class="fw-semibold" :class="getStatusClass(student.status)">
                                    {{ getStatusText(student.status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Tổng kết + Nút lưu (trên cùng một hàng) -->
                <div class="mt-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="text-muted ">
                        Tổng: {{ students.length }} |
                        Có mặt: {{ countStatus('present') }} |
                        Vắng: {{ countStatus('absent') }} |
                        Muộn: {{ countStatus('late') }}
                    </div>
                    <button class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
                        💾 Lưu điểm danh
                    </button>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            selectedDate: '2024-03-20',
            selectedClass: 'Lá',
            students: [
                { id: 1, name: 'Nguyễn Phương Anh', status: 'present' },
                { id: 2, name: 'Trần Minh Khôi', status: 'present' },
                { id: 3, name: 'Lê Thị Thu', status: 'present' },
            ]
        };
    },
    methods: {
        updateStatus(student, status) {
            student.status = status;
        },
        getStatusText(status) {
            switch (status) {
                case 'present': return 'Có mặt';
                case 'absent': return 'Vắng mặt';
                case 'late': return 'Đi muộn';
                default: return 'Chưa rõ';
            }
        },
        getStatusClass(status) {
            return {
                'text-success': status === 'present',
                'text-danger': status === 'absent',
                'text-warning': status === 'late',
            };
        },
        countStatus(status) {
            return this.students.filter(s => s.status === status).length;
        }
    }
};
</script>

<style scoped>
.hover-scale {
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.hover-scale:hover {
    transform: scale(1.03);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
}

button.rounded-circle {
    width: 36px;
    height: 36px;
    font-size: 18px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: 0.2s ease;
}

button.rounded-circle:hover {
    transform: scale(1.05);
}

.page-title-box {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 30px;
}

.page-title-box h4 {
    color: white;
    margin: 0;
}

.breadcrumb {
    background: transparent;
    margin: 0;
}

.breadcrumb-item a {
    color: rgba(255, 255, 255, 0.8);
}

.breadcrumb-item.active {
    color: white;
}
</style>
