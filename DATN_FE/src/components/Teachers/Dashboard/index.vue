<template>
    <div class="container-fluid teacher-dashboard">
        <!-- Welcome Section -->
        <div class="welcome-section text-center mb-4">
            <div class="school-banner">
                <h2 class="welcome-title">CHÀO MỪNG GIÁO VIÊN</h2>
                <p class="welcome-subtitle">Nơi chia sẻ tri thức - Vì sự phát triển của học sinh</p>
                <div class="welcome-info">
                    <span class="badge bg-primary me-2">
                        <i class="bx bx-calendar me-1"></i>{{ currentDate }}
                    </span>
                    <span class="badge bg-success me-2">
                        <i class="bx bx-time me-1"></i>{{ currentTime }}
                    </span>
                    <span class="badge bg-info">
                        <i class="bx bx-user me-1"></i>Xin chào, {{ teacherName }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card stat-card stat-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon"><i class="bx bx-group"></i></div>
                            <div class="stat-content">
                                <h3 class="stat-number">{{ totalStudents }}</h3>
                                <p class="stat-label">Tổng học sinh</p>
                                <div class="stat-change">
                                    <small class="text-muted">{{ className }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card stat-card stat-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon"><i class="bx bx-check-circle"></i></div>
                            <div class="stat-content">
                                <h3 class="stat-number">{{ attendanceRate }}%</h3>
                                <p class="stat-label">Tỷ lệ điểm danh hôm nay</p>
                                <div class="stat-change positive">
                                    <i class="bx bx-up-arrow-alt"></i> +2.5%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card stat-card stat-warning">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon"><i class="bx bx-file"></i></div>
                            <div class="stat-content">
                                <h3 class="stat-number">{{ pendingTasks }}</h3>
                                <p class="stat-label">Công việc cần xử lý</p>
                                <div class="stat-change">
                                    <small class="text-muted">Hạn trong tuần</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card stat-card stat-info">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="stat-icon"><i class="bx bx-message-dots"></i></div>
                            <div class="stat-content">
                                <h3 class="stat-number">{{ unreadMessages }}</h3>
                                <p class="stat-label">Tin nhắn chưa đọc</p>
                                <div class="stat-change">
                                    <small class="text-muted">Từ phụ huynh</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Row -->
        <div class="row mb-4">
            <!-- Today's Schedule -->
            <div class="col-xl-4 mb-3">
                <div class="card dashboard-card h-100">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="bx bx-calendar me-2"></i>Lịch dạy hôm nay
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="schedule-list">
                            <div v-for="(schedule, index) in todaySchedule" :key="index" class="schedule-item"
                                :class="{ active: schedule.isNow }">
                                <div class="schedule-time">
                                    <i class="bx bx-time-five"></i>
                                    {{ schedule.time }}
                                </div>
                                <div class="schedule-info">
                                    <h6>{{ schedule.className }}</h6>
                                    <p>{{ schedule.subject }}</p>
                                    <span class="badge" :class="'bg-' + schedule.status">{{ schedule.statusText
                                    }}</span>
                                </div>
                            </div>
                            <div v-if="todaySchedule.length === 0" class="text-center text-muted py-4">
                                <i class="bx bx-calendar-x" style="font-size: 3rem;"></i>
                                <p class="mt-2">Không có lịch dạy hôm nay</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Student Attendance Overview -->
            <div class="col-xl-8 mb-3">
                <div class="card dashboard-card h-100">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="bx bx-line-chart me-2"></i>Tình hình điểm danh trong tuần
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="height: 300px">
                            <v-chart class="chart" :option="attendanceChartOption" autoresize />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Row -->
        <div class="row mb-4">
            <div class="col-xl-6 mb-3">
                <div class="card dashboard-card h-100">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="bx bx-trending-up me-2"></i>Tỷ lệ hoàn thành các hoạt động (%)
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="height: 300px">
                            <v-chart class="chart" :option="performanceChartOption" autoresize />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 mb-3">
                <div class="card dashboard-card h-100">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="bx bx-pie-chart-alt-2 me-2"></i>Phân bố giới tính lớp học
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="height: 300px">
                            <v-chart class="chart" :option="classDistributionOption" autoresize />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Third Row -->
        <div class="row mb-4">
            <div class="col-xl-4 mb-3">
                <div class="card dashboard-card h-100">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="bx bx-bell me-2"></i>Thông báo & Nhắc nhở
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="notifications-list">
                            <div v-for="(notification, index) in notifications" :key="index"
                                class="notification-item alert" :class="'alert-' + notification.type">
                                <div class="notification-icon">
                                    <i :class="'bx ' + notification.icon"></i>
                                </div>
                                <div class="notification-content">
                                    <h6>{{ notification.title }}</h6>
                                    <p>{{ notification.message }}</p>
                                    <small class="text-muted">{{ notification.time }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 mb-3">
                <div class="card dashboard-card h-100">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="bx bx-user-check me-2"></i>Học sinh cần chú ý
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="student-list">
                            <div v-for="(student, index) in attentionStudents" :key="index" class="student-item">
                                <div class="student-avatar">
                                    <img :src="student.avatar" :alt="student.name" />
                                </div>
                                <div class="student-info">
                                    <h6>{{ student.name }}</h6>
                                    <p class="text-muted">{{ student.className }}</p>
                                </div>
                                <div class="student-status">
                                    <span class="badge" :class="'bg-' + student.statusColor">{{ student.status }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 mb-3">
                <div class="card dashboard-card h-100">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="bx bx-bolt me-2"></i>Thao tác nhanh
                        </h5>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="quick-actions flex-grow-1 d-flex flex-column justify-content-center">
                            <button class="btn btn-outline-primary btn-lg w-100 mb-3" @click="takeAttendance">
                                <i class="bx bx-check-double me-2"></i>Điểm danh
                            </button>
                            <button class="btn btn-outline-secondary btn-lg w-100 mb-3" @click="createAssignment">
                                <i class="bx bx-book-add me-2"></i>Tạo bài tập
                            </button>
                            <button class="btn btn-outline-secondary btn-lg w-100 mb-3" @click="viewSchedule">
                                <i class="bx bx-calendar-event me-2"></i>Xem lịch dạy
                            </button>
                            <button class="btn btn-outline-secondary btn-lg w-100" @click="messageParents">
                                <i class="bx bx-message-square-dots me-2"></i>Nhắn phụ huynh
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tasks Table -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card dashboard-card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="bx bx-task me-2"></i>Công việc cần hoàn thành
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Công việc</th>
                                        <th>Lớp</th>
                                        <th>Hạn chót</th>
                                        <th>Trạng thái</th>
                                        <th>Ưu tiên</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(task, index) in tasks" :key="index">
                                        <td>
                                            <i :class="'bx ' + task.icon + ' me-2'"></i>
                                            {{ task.name }}
                                        </td>
                                        <td>{{ task.class }}</td>
                                        <td>{{ task.deadline }}</td>
                                        <td>
                                            <span class="badge" :class="'bg-' + task.statusColor">{{ task.status
                                            }}</span>
                                        </td>
                                        <td>
                                            <span class="badge" :class="'bg-' + task.priorityColor">{{ task.priority
                                            }}</span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-primary me-1">
                                                <i class="bx bx-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-success">
                                                <i class="bx bx-check"></i>
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

        <!-- Quote -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card motto-card">
                    <div class="card-body text-center">
                        <h3 class="motto-title">
                            <i class="bx bx-quote-left me-2"></i>
                            "Giáo dục không phải là việc đổ đầy một cái thùng, mà là thắp sáng ngọn lửa"
                            <i class="bx bx-quote-right ms-2"></i>
                        </h3>
                        <p class="motto-subtitle">- William Butler Yeats</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted, onUnmounted } from "vue";
import { useRouter } from "vue-router";
import { use } from "echarts/core";
import { CanvasRenderer } from "echarts/renderers";
import { PieChart, BarChart, LineChart } from "echarts/charts";
import { TitleComponent, TooltipComponent, LegendComponent, GridComponent } from "echarts/components";
import VChart from "vue-echarts";

use([CanvasRenderer, PieChart, BarChart, LineChart, TitleComponent, TooltipComponent, LegendComponent, GridComponent]);

export default {
    name: "TeacherDashboard",
    components: { VChart },
    setup() {
        const router = useRouter();
        const currentDate = ref("");
        const currentTime = ref("");
        let timeInterval = null;

        const teacherName = ref("Nguyễn Thị Mai");
        const totalStudents = ref(30);
        const totalClasses = ref(1);
        const className = ref("Lớp Mầm 1A");
        const attendanceRate = ref(96.5);
        const pendingTasks = ref(5);
        const unreadMessages = ref(8);

        const todaySchedule = ref([
            { time: "07:30 - 09:00", className: "Lớp Mầm 1A", subject: "Toán - Làm quen với số", status: "success", statusText: "Hoàn thành", isNow: false },
            { time: "09:30 - 11:00", className: "Lớp Mầm 1A", subject: "Tiếng Việt - Học chữ cái", status: "primary", statusText: "Đang diễn ra", isNow: true },
            { time: "14:00 - 15:30", className: "Lớp Mầm 1A", subject: "Âm nhạc - Bài hát thiếu nhi", status: "secondary", statusText: "Sắp diễn ra", isNow: false },
            { time: "15:45 - 16:30", className: "Lớp Mầm 1A", subject: "Hoạt động ngoài trời", status: "secondary", statusText: "Sắp diễn ra", isNow: false },
        ]);

        const notifications = ref([
            { type: "warning", icon: "bx-error-circle", title: "Nhắc nhở điểm danh", message: "Cần điểm danh buổi chiều cho lớp Mầm 1A", time: "30 phút trước" },
            { type: "info", icon: "bx-info-circle", title: "Họp phụ huynh", message: "Họp phụ huynh lớp Mầm 1A vào thứ 7 tuần này", time: "5 giờ trước" },
            { type: "success", icon: "bx-check-circle", title: "Bài tập", message: "Đã hoàn thành chấm bài tập về nhà", time: "1 ngày trước" },
        ]);

        const attentionStudents = ref([
            { name: "Nguyễn Văn A", className: "Lớp Mầm 1A", avatar: "/src/assets/images/avatars/avatar-1.png", status: "Vắng mặt", statusColor: "danger" },
            { name: "Trần Thị B", className: "Lớp Mầm 1A", avatar: "/src/assets/images/avatars/avatar-2.png", status: "Ốm", statusColor: "warning" },
            { name: "Lê Văn C", className: "Lớp Mầm 1A", avatar: "/src/assets/images/avatars/avatar-3.png", status: "Tiến bộ", statusColor: "success" },
            { name: "Phạm Thị D", className: "Lớp Mầm 1A", avatar: "/src/assets/images/avatars/avatar-4.png", status: "Cần hỗ trợ", statusColor: "info" },
        ]);

        const tasks = ref([
            { name: "Chấm bài tập về nhà", class: "Lớp Mầm 1A", deadline: "Hôm nay, 17:00", status: "Đang xử lý", statusColor: "warning", priority: "Cao", priorityColor: "danger", icon: "bx-edit" },
            { name: "Chuẩn bị giáo án tuần sau", class: "Lớp Mầm 1A", deadline: "Thứ 6, 30/09", status: "Chưa bắt đầu", statusColor: "secondary", priority: "Trung bình", priorityColor: "warning", icon: "bx-book" },
            { name: "Gửi thông báo cho phụ huynh", class: "Lớp Mầm 1A", deadline: "Mai, 10:00", status: "Chưa bắt đầu", statusColor: "secondary", priority: "Cao", priorityColor: "danger", icon: "bx-message" },
            { name: "Cập nhật sổ liên lạc", class: "Lớp Mầm 1A", deadline: "Thứ 5, 02/10", status: "Chưa bắt đầu", statusColor: "secondary", priority: "Thấp", priorityColor: "info", icon: "bx-notebook" },
        ]);

        const attendanceChartOption = ref({
            tooltip: { trigger: "axis", axisPointer: { type: "shadow" } },
            legend: { data: ["Có mặt", "Vắng mặt", "Đi muộn"] },
            grid: { left: "3%", right: "4%", bottom: "3%", containLabel: true },
            xAxis: { type: "category", data: ["T2", "T3", "T4", "T5", "T6"] },
            yAxis: { type: "value", max: 30 },
            series: [
                { name: "Có mặt", type: "bar", stack: "total", data: [28, 29, 27, 30, 29], itemStyle: { color: "#5cb85c" } },
                { name: "Vắng mặt", type: "bar", stack: "total", data: [1, 0, 2, 0, 1], itemStyle: { color: "#d9534f" } },
                { name: "Đi muộn", type: "bar", stack: "total", data: [1, 1, 1, 0, 0], itemStyle: { color: "#f0ad4e" } },
            ],
        });

        const performanceChartOption = ref({
            tooltip: { trigger: "axis" },
            legend: { data: ["Điểm danh", "Hoàn thành bài tập", "Tham gia hoạt động"] },
            grid: { left: "3%", right: "4%", bottom: "3%", containLabel: true },
            xAxis: { type: "category", boundaryGap: false, data: ["T2", "T3", "T4", "T5", "T6"] },
            yAxis: { type: "value", max: 100 },
            series: [
                { name: "Điểm danh", type: "line", data: [93, 97, 90, 100, 97], smooth: true, itemStyle: { color: "#5470c6" } },
                { name: "Hoàn thành bài tập", type: "line", data: [85, 88, 90, 87, 92], smooth: true, itemStyle: { color: "#91cc75" } },
                { name: "Tham gia hoạt động", type: "line", data: [95, 93, 97, 93, 100], smooth: true, itemStyle: { color: "#fac858" } },
            ],
        });

        const classDistributionOption = ref({
            tooltip: { trigger: "item", formatter: "{b}: {c} học sinh ({d}%)" },
            legend: { orient: "vertical", left: "left" },
            series: [{
                name: "Giới tính",
                type: "pie",
                radius: ["40%", "70%"],
                avoidLabelOverlap: false,
                itemStyle: { borderRadius: 10, borderColor: "#fff", borderWidth: 2 },
                label: { show: true, formatter: "{b}: {c}" },
                emphasis: { label: { show: true, fontSize: 16, fontWeight: "bold" } },
                data: [
                    { value: 16, name: "Nam", itemStyle: { color: "#5470c6" } },
                    { value: 14, name: "Nữ", itemStyle: { color: "#ec4899" } },
                ],
            }],
        });

        const updateDateTime = () => {
            const now = new Date();
            currentDate.value = now.toLocaleDateString("vi-VN", { weekday: "long", year: "numeric", month: "long", day: "numeric" });
            currentTime.value = now.toLocaleTimeString("vi-VN", { hour: "2-digit", minute: "2-digit", second: "2-digit" });
        };

        const takeAttendance = () => router.push("/teacher/attendance");
        const createAssignment = () => router.push("/teacher/assignments/create");
        const viewSchedule = () => router.push("/teacher/schedule");
        const messageParents = () => router.push("/teacher/messages");

        onMounted(() => {
            updateDateTime();
            timeInterval = setInterval(updateDateTime, 1000);
        });

        onUnmounted(() => {
            if (timeInterval) clearInterval(timeInterval);
        });

        return {
            currentDate, currentTime, teacherName, totalStudents, totalClasses, className, attendanceRate,
            pendingTasks, unreadMessages, todaySchedule, notifications, attentionStudents, tasks,
            attendanceChartOption, performanceChartOption, classDistributionOption,
            takeAttendance, createAssignment, viewSchedule, messageParents,
        };
    },
};
</script>

<style lang="scss" scoped>
.teacher-dashboard {
    padding: 1.5rem;
}

.welcome-section {
    margin-bottom: 2rem;

    .school-banner {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2.5rem;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);

        .welcome-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .welcome-subtitle {
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
            opacity: 0.95;
        }

        .welcome-info {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;

            .badge {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
                font-weight: 500;
            }
        }
    }
}

.stat-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    cursor: pointer;

    &:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin-right: 1rem;
    }

    &.stat-primary .stat-icon {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    &.stat-success .stat-icon {
        background: linear-gradient(135deg, #5cb85c 0%, #4cae4c 100%);
        color: white;
    }

    &.stat-warning .stat-icon {
        background: linear-gradient(135deg, #f0ad4e 0%, #ec971f 100%);
        color: white;
    }

    &.stat-info .stat-icon {
        background: linear-gradient(135deg, #5bc0de 0%, #46b8da 100%);
        color: white;
    }

    .stat-content {
        flex: 1;

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            color: #2c3e50;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #7f8c8d;
            margin-bottom: 0.25rem;
        }

        .stat-change {
            font-size: 0.85rem;

            &.positive {
                color: #5cb85c;
            }
        }
    }
}

.dashboard-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);

    .card-header {
        background: #f8f9fa;
        border-bottom: 2px solid #e9ecef;
        border-radius: 12px 12px 0 0;
        padding: 1.25rem;

        .card-title {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;

            i {
                color: #667eea;
            }
        }
    }

    .card-body {
        padding: 1.25rem;
    }
}

.schedule-list {
    max-height: 400px;
    overflow-y: auto;

    .schedule-item {
        display: flex;
        padding: 1rem;
        border-left: 4px solid #e9ecef;
        margin-bottom: 1rem;
        background: #f8f9fa;
        border-radius: 8px;
        transition: all 0.3s ease;

        &:hover {
            background: #e9ecef;
        }

        &.active {
            border-left-color: #667eea;
            background: #f0f2ff;
        }

        .schedule-time {
            min-width: 120px;
            font-weight: 600;
            color: #667eea;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .schedule-info {
            flex: 1;

            h6 {
                margin: 0 0 0.25rem 0;
                font-weight: 600;
                color: #2c3e50;
            }

            p {
                margin: 0 0 0.5rem 0;
                color: #7f8c8d;
                font-size: 0.9rem;
            }

            .badge {
                font-size: 0.75rem;
            }
        }
    }
}

.notifications-list {
    max-height: 400px;
    overflow-y: auto;

    .notification-item {
        display: flex;
        padding: 1rem;
        margin-bottom: 1rem;
        border-radius: 8px;
        border: none;

        .notification-icon {
            font-size: 1.5rem;
            margin-right: 1rem;
        }

        .notification-content {
            flex: 1;

            h6 {
                margin: 0 0 0.25rem 0;
                font-weight: 600;
            }

            p {
                margin: 0 0 0.25rem 0;
                font-size: 0.9rem;
            }

            small {
                font-size: 0.8rem;
            }
        }
    }
}

.student-list {
    max-height: 400px;
    overflow-y: auto;

    .student-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        margin-bottom: 1rem;
        background: #f8f9fa;
        border-radius: 8px;
        transition: all 0.3s ease;

        &:hover {
            background: #e9ecef;
            transform: translateX(5px);
        }

        .student-avatar {
            width: 50px;
            height: 50px;
            margin-right: 1rem;

            img {
                width: 100%;
                height: 100%;
                border-radius: 50%;
                object-fit: cover;
            }
        }

        .student-info {
            flex: 1;

            h6 {
                margin: 0 0 0.25rem 0;
                font-weight: 600;
                color: #2c3e50;
            }

            p {
                margin: 0;
                font-size: 0.85rem;
            }
        }

        .student-status .badge {
            padding: 0.4rem 0.8rem;
        }
    }
}

.quick-actions .btn {
    font-weight: 500;
    border-width: 2px;
    transition: all 0.3s ease;

    &:hover {
        transform: scale(1.02);
    }

    i {
        font-size: 1.2rem;
    }
}

.table {
    th {
        font-weight: 600;
        color: #2c3e50;
        border-bottom: 2px solid #dee2e6;
    }

    td {
        vertical-align: middle;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
    }
}

.motto-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);

    .card-body {
        padding: 2rem;
    }

    .motto-title {
        color: white;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    }

    .motto-subtitle {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.1rem;
        margin: 0;
    }
}

.chart-container {
    width: 100%;
    position: relative;

    .chart {
        width: 100% !important;
        height: 100% !important;
    }
}

@media (max-width: 768px) {
    .welcome-section .school-banner {
        padding: 1.5rem;

        .welcome-title {
            font-size: 1.5rem;
        }

        .welcome-subtitle {
            font-size: 1rem;
        }
    }

    .stat-card .stat-icon {
        width: 50px;
        height: 50px;
        font-size: 1.5rem;
    }

    .stat-content .stat-number {
        font-size: 1.5rem;
    }
}
</style>
