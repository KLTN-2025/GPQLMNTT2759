<template>
    <div class="schedule-page">
        <div class="page-header mb-4">
            <h2 class="page-title">
                <i class="bx bx-calendar me-2"></i>Lịch Dạy
            </h2>
            <p class="page-subtitle">Lịch giảng dạy trong tuần</p>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered schedule-table">
                        <thead>
                            <tr>
                                <th>Giờ</th>
                                <th>Thứ 2</th>
                                <th>Thứ 3</th>
                                <th>Thứ 4</th>
                                <th>Thứ 5</th>
                                <th>Thứ 6</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(time, index) in timeSlots" :key="index">
                                <td class="time-cell">{{ time }}</td>
                                <td v-for="day in 5" :key="day" :class="getClassForCell(index, day)">
                                    <div v-if="schedule[index] && schedule[index][day]">
                                        <strong>{{ schedule[index][day].subject }}</strong>
                                        <br><small>{{ schedule[index][day].room }}</small>
                                    </div>
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
import { ref } from 'vue';

export default {
    name: 'Schedule',
    setup() {
        const timeSlots = ref([
            '07:30 - 09:00',
            '09:30 - 11:00',
            '14:00 - 15:30',
            '15:45 - 16:30'
        ]);

        const schedule = ref({
            0: {
                1: { subject: 'Toán', room: 'Phòng 1A' },
                2: { subject: 'Tiếng Việt', room: 'Phòng 1A' },
                3: { subject: 'Khoa học', room: 'Phòng 1A' },
                4: { subject: 'Toán', room: 'Phòng 1A' },
                5: { subject: 'Âm nhạc', room: 'Phòng nhạc' }
            },
            1: {
                1: { subject: 'Tiếng Việt', room: 'Phòng 1A' },
                2: { subject: 'Mỹ thuật', room: 'Phòng 1A' },
                3: { subject: 'Toán', room: 'Phòng 1A' },
                4: { subject: 'Tiếng Việt', room: 'Phòng 1A' },
                5: { subject: 'Thể dục', room: 'Sân chơi' }
            }
        });

        const getClassForCell = (row, col) => {
            return schedule.value[row] && schedule.value[row][col] ? 'has-class' : '';
        };

        return { timeSlots, schedule, getClassForCell };
    }
};
</script>

<style scoped>
.schedule-page {
    padding: 20px;
}

.schedule-table {
    margin: 0;
}

.schedule-table th {
    background: #667eea;
    color: white;
    text-align: center;
    padding: 15px;
}

.time-cell {
    background: #f8f9fa;
    font-weight: 600;
    text-align: center;
}

.has-class {
    background: #e7f3ff;
}

.schedule-table td {
    padding: 12px;
    vertical-align: middle;
}
</style>
