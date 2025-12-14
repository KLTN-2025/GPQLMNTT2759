<template>
    <div class="dashboard-page">
        <!-- Header Section -->
        <div class="page-header education-theme">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="page-header-content">
                            <div class="page-icon">
                                <i class="bx bx-home"></i>
                            </div>
                            <div class="page-info">
                                <h1 class="page-title">Bảng Điều Khiển</h1>
                                <p class="page-subtitle">Chào mừng, {{ teacherName }} - {{ currentDate }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="time-display">
                            <i class="bx bx-time"></i>
                            <span>{{ currentTime }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-section">
            <div class="container-fluid">
                <div class="row g-4">
                    <div class="col-xl-3 col-md-6">
                        <div class="stats-card stats-primary">
                            <div class="stats-content-wrapper">
                                <div class="stats-icon">
                                    <i class="bx bx-group"></i>
                                </div>
                                <div class="stats-content">
                                    <div class="stats-number">{{ totalStudents }}</div>
                                    <div class="stats-label">Tổng học sinh</div>
                                    <div class="stats-subtitle">{{ className }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="stats-card stats-success">
                            <div class="stats-content-wrapper">
                                <div class="stats-icon">
                                    <i class="bx bx-check-circle"></i>
                                </div>
                                <div class="stats-content">
                                    <div class="stats-number">{{ attendanceRate }}%</div>
                                    <div class="stats-label">Điểm danh hôm nay</div>
                                    <div class="stats-change positive">
                                        <i class="bx bx-up-arrow-alt"></i> +2.5%
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="stats-card stats-warning">
                            <div class="stats-content-wrapper">
                                <div class="stats-icon">
                                    <i class="bx bx-file"></i>
                                </div>
                                <div class="stats-content">
                                    <div class="stats-number">{{ pendingTasks }}</div>
                                    <div class="stats-label">Công việc cần xử lý</div>
                                    <div class="stats-subtitle">Hạn trong tuần</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="stats-card stats-info">
                            <div class="stats-content-wrapper">
                                <div class="stats-icon">
                                    <i class="bx bx-message-dots"></i>
                                </div>
                                <div class="stats-content">
                                    <div class="stats-number">{{ unreadMessages }}</div>
                                    <div class="stats-label">Tin nhắn chưa đọc</div>
                                    <div class="stats-subtitle">Từ phụ huynh</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Row -->
        <div class="content-section">
            <div class="container-fluid">
                <div class="row g-4 mb-4">
                    <!-- Today's Schedule -->
                    <div class="col-xl-4">
                        <div class="dashboard-card">
                            <div class="card-header-custom">
                                <div class="header-content">
                                    <div class="header-icon">
                                        <i class="bx bx-calendar"></i>
                                    </div>
                                    <div class="header-text">
                                        <h5 class="card-title">Lịch dạy hôm nay</h5>
                                    </div>
                                </div>
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
                                            <span class="badge" :class="'bg-' + schedule.status">
                                                {{ schedule.statusText }}
                                            </span>
                                        </div>
                                    </div>
                                    <div v-if="todaySchedule.length === 0" class="empty-state">
                                        <i class="bx bx-calendar-x"></i>
                                        <p>Không có lịch dạy hôm nay</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Chart -->
                    <div class="col-xl-8">
                        <div class="dashboard-card">
                            <div class="card-header-custom">
                                <div class="header-content">
                                    <div class="header-icon">
                                        <i class="bx bx-line-chart"></i>
                                    </div>
                                    <div class="header-text">
                                        <h5 class="card-title">Tình hình điểm danh trong tuần</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <v-chart class="chart" :option="attendanceChartOption" autoresize />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Second Row -->
                <div class="row g-4 mb-4">
                    <div class="col-xl-6">
                        <div class="dashboard-card">
                            <div class="card-header-custom">
                                <div class="header-content">
                                    <div class="header-icon">
                                        <i class="bx bx-trending-up"></i>
                                    </div>
                                    <div class="header-text">
                                        <h5 class="card-title">Tỷ lệ hoàn thành các hoạt động (%)</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <v-chart class="chart" :option="performanceChartOption" autoresize />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="dashboard-card">
                            <div class="card-header-custom">
                                <div class="header-content">
                                    <div class="header-icon">
                                        <i class="bx bx-pie-chart-alt-2"></i>
                                    </div>
                                    <div class="header-text">
                                        <h5 class="card-title">Phân bố giới tính lớp học</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <v-chart class="chart" :option="classDistributionOption" autoresize />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Third Row -->
                <div class="row g-4 mb-4">
                    <div class="col-xl-4">
                        <div class="dashboard-card">
                            <div class="card-header-custom">
                                <div class="header-content">
                                    <div class="header-icon">
                                        <i class="bx bx-bell"></i>
                                    </div>
                                    <div class="header-text">
                                        <h5 class="card-title">Thông báo & Nhắc nhở</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="notifications-list">
                                    <div v-for="(notification, index) in notifications" :key="index"
                                        class="notification-item" :class="'alert-' + notification.type">
                                        <div class="notification-icon">
                                            <i :class="'bx ' + notification.icon"></i>
                                        </div>
                                        <div class="notification-content">
                                            <h6>{{ notification.title }}</h6>
                                            <p>{{ notification.message }}</p>
                                            <small>{{ notification.time }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="dashboard-card">
                            <div class="card-header-custom">
                                <div class="header-content">
                                    <div class="header-icon">
                                        <i class="bx bx-user-check"></i>
                                    </div>
                                    <div class="header-text">
                                        <h5 class="card-title">Học sinh cần chú ý</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="student-list">
                                    <div v-for="(student, index) in attentionStudents" :key="index"
                                        class="student-item">
                                        <div class="student-avatar">
                                            <img :src="student.avatar" :alt="student.name" />
                                        </div>
                                        <div class="student-info">
                                            <h6>{{ student.name }}</h6>
                                            <p>{{ student.className }}</p>
                                        </div>
                                        <div class="student-status">
                                            <span class="badge" :class="'bg-' + student.statusColor">
                                                {{ student.status }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="dashboard-card">
                            <div class="card-header-custom">
                                <div class="header-content">
                                    <div class="header-icon">
                                        <i class="bx bx-bolt"></i>
                                    </div>
                                    <div class="header-text">
                                        <h5 class="card-title">Thao tác nhanh</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="quick-actions">
                                    <button class="btn btn-quick-action" @click="takeAttendance">
                                        <i class="bx bx-check-double"></i>
                                        <span>Điểm danh</span>
                                    </button>
                                    <button class="btn btn-quick-action" @click="createAssignment">
                                        <i class="bx bx-book-add"></i>
                                        <span>Tạo bài tập</span>
                                    </button>
                                    <button class="btn btn-quick-action" @click="viewSchedule">
                                        <i class="bx bx-calendar-event"></i>
                                        <span>Xem lịch dạy</span>
                                    </button>
                                    <button class="btn btn-quick-action" @click="messageParents">
                                        <i class="bx bx-message-square-dots"></i>
                                        <span>Nhắn phụ huynh</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tasks Table -->
                <div class="row">
                    <div class="col-12">
                        <div class="dashboard-card">
                            <div class="card-header-custom">
                                <div class="header-content">
                                    <div class="header-icon">
                                        <i class="bx bx-task"></i>
                                    </div>
                                    <div class="header-text">
                                        <h5 class="card-title">Công việc cần hoàn thành</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-container">
                                    <table class="table table-modern">
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
                                                    <span class="badge" :class="'bg-' + task.statusColor">
                                                        {{ task.status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge" :class="'bg-' + task.priorityColor">
                                                        {{ task.priority }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <button class="btn-action btn-edit" title="Chỉnh sửa">
                                                            <i class="bx bx-edit"></i>
                                                        </button>
                                                        <button class="btn-action btn-view" title="Hoàn thành">
                                                            <i class="bx bx-check"></i>
                                                        </button>
                                                    </div>
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
                { name: "Có mặt", type: "bar", stack: "total", data: [28, 29, 27, 30, 29], itemStyle: { color: "#10b981" } },
                { name: "Vắng mặt", type: "bar", stack: "total", data: [1, 0, 2, 0, 1], itemStyle: { color: "#ef4444" } },
                { name: "Đi muộn", type: "bar", stack: "total", data: [1, 1, 1, 0, 0], itemStyle: { color: "#f59e0b" } },
            ],
        });

        const performanceChartOption = ref({
            tooltip: { trigger: "axis" },
            legend: { data: ["Điểm danh", "Hoàn thành bài tập", "Tham gia hoạt động"] },
            grid: { left: "3%", right: "4%", bottom: "3%", containLabel: true },
            xAxis: { type: "category", boundaryGap: false, data: ["T2", "T3", "T4", "T5", "T6"] },
            yAxis: { type: "value", max: 100 },
            series: [
                { name: "Điểm danh", type: "line", data: [93, 97, 90, 100, 97], smooth: true, itemStyle: { color: "#667eea" } },
                { name: "Hoàn thành bài tập", type: "line", data: [85, 88, 90, 87, 92], smooth: true, itemStyle: { color: "#10b981" } },
                { name: "Tham gia hoạt động", type: "line", data: [95, 93, 97, 93, 100], smooth: true, itemStyle: { color: "#f59e0b" } },
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
                    { value: 16, name: "Nam", itemStyle: { color: "#667eea" } },
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
            currentDate, currentTime, teacherName, totalStudents, className, attendanceRate,
            pendingTasks, unreadMessages, todaySchedule, notifications, attentionStudents, tasks,
            attendanceChartOption, performanceChartOption, classDistributionOption,
            takeAttendance, createAssignment, viewSchedule, messageParents,
        };
    },
};
</script>

<style lang="scss" scoped>
@use "../teacher-styles.scss" as teacher;

.dashboard-page {
    padding-bottom: 2rem;
    background: #f5f7fa;
    min-height: 100vh;

    .page-header {
        .time-display {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.2);
            padding: 0.75rem 1.25rem;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;

            i {
                font-size: 1.25rem;
            }
        }
    }
}

.stats-section {
    margin-bottom: 2rem;
    padding: 0 1rem;

    .stats-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        height: 100%;

        &:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        }

        .stats-content-wrapper {
            display: flex;
            align-items: center;
            gap: 1.25rem;

            .stats-icon {
                width: 64px;
                height: 64px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.75rem;
                color: white;
                flex-shrink: 0;
            }

            .stats-content {
                flex: 1;
                min-width: 0;

                .stats-number {
                    font-size: 2rem;
                    font-weight: 700;
                    color: #2c3e50;
                    line-height: 1.2;
                    margin-bottom: 0.25rem;
                }

                .stats-label {
                    font-size: 0.875rem;
                    color: #6c757d;
                    font-weight: 600;
                    margin-bottom: 0.25rem;
                }

                .stats-subtitle {
                    font-size: 0.8125rem;
                    color: #94a3b8;
                }

                .stats-change {
                    font-size: 0.8125rem;
                    display: flex;
                    align-items: center;
                    gap: 0.25rem;

                    &.positive {
                        color: #10b981;
                    }
                }
            }
        }

        &.stats-primary .stats-icon {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        &.stats-success .stats-icon {
            background: #10b981;
        }

        &.stats-warning .stats-icon {
            background: #f59e0b;
        }

        &.stats-info .stats-icon {
            background: #3b82f6;
        }
    }
}

.content-section {
    padding: 0 1rem;
}

.dashboard-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    height: 100%;

    .card-header-custom {
        background: #ffffff;
        padding: 1.5rem;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;

        .header-content {
            display: flex;
            align-items: center;
            gap: 1rem;

            .header-icon {
                width: 48px;
                height: 48px;
                background: linear-gradient(135deg, #667eea, #764ba2);
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-size: 1.25rem;
                flex-shrink: 0;
            }

            .header-text .card-title {
                font-size: 1.25rem;
                font-weight: 600;
                margin: 0;
                color: #2c3e50;
            }
        }
    }

    .card-body {
        padding: 1.5rem;
    }
}

.schedule-list {
    max-height: 400px;
    overflow-y: auto;

    .schedule-item {
        display: flex;
        gap: 1rem;
        padding: 1rem;
        border-left: 3px solid #e9ecef;
        margin-bottom: 1rem;
        background: #f8f9fa;
        border-radius: 8px;
        transition: all 0.2s ease;

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
            font-size: 0.9rem;
        }

        .schedule-info {
            flex: 1;

            h6 {
                margin: 0 0 0.25rem 0;
                font-weight: 600;
                color: #2c3e50;
                font-size: 0.95rem;
            }

            p {
                margin: 0 0 0.5rem 0;
                color: #6c757d;
                font-size: 0.85rem;
            }

            .badge {
                font-size: 0.75rem;
                padding: 0.25rem 0.5rem;
            }
        }
    }

    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: #6c757d;

        i {
            font-size: 3rem;
            margin-bottom: 1rem;
            display: block;
        }

        p {
            margin: 0;
        }
    }
}

.chart-container {
    width: 100%;
    height: 300px;
    position: relative;

    .chart {
        width: 100% !important;
        height: 100% !important;
    }
}

.notifications-list {
    max-height: 400px;
    overflow-y: auto;

    .notification-item {
        display: flex;
        gap: 1rem;
        padding: 1rem;
        margin-bottom: 1rem;
        border-radius: 8px;
        border: none;
        background: #f8f9fa;

        &.alert-warning {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
        }

        &.alert-info {
            background: #dbeafe;
            border-left: 4px solid #3b82f6;
        }

        &.alert-success {
            background: #d1fae5;
            border-left: 4px solid #10b981;
        }

        .notification-icon {
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .notification-content {
            flex: 1;

            h6 {
                margin: 0 0 0.25rem 0;
                font-weight: 600;
                color: #2c3e50;
                font-size: 0.95rem;
            }

            p {
                margin: 0 0 0.25rem 0;
                font-size: 0.875rem;
                color: #6c757d;
            }

            small {
                font-size: 0.75rem;
                color: #94a3b8;
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
        gap: 1rem;
        padding: 1rem;
        margin-bottom: 1rem;
        background: #f8f9fa;
        border-radius: 8px;
        transition: all 0.2s ease;

        &:hover {
            background: #e9ecef;
            transform: translateX(4px);
        }

        .student-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;

            img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
        }

        .student-info {
            flex: 1;
            min-width: 0;

            h6 {
                margin: 0 0 0.25rem 0;
                font-weight: 600;
                color: #2c3e50;
                font-size: 0.95rem;
            }

            p {
                margin: 0;
                font-size: 0.85rem;
                color: #6c757d;
            }
        }

        .student-status .badge {
            padding: 0.4rem 0.8rem;
            font-size: 0.75rem;
        }
    }
}

.quick-actions {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;

    .btn-quick-action {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem;
        background: #f8f9fa;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        font-weight: 500;
        color: #2c3e50;
        transition: all 0.2s ease;
        text-align: left;

        i {
            font-size: 1.25rem;
            color: #667eea;
        }

        &:hover {
            background: #667eea;
            color: white;
            border-color: #667eea;
            transform: translateX(4px);

            i {
                color: white;
            }
        }
    }
}

.table-container {
    overflow-x: auto;

    .table-modern {
        width: 100%;
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;

        thead {
            background: #f8f9fa;

            th {
                border: none;
                padding: 1rem;
                font-weight: 600;
                color: #2c3e50;
                font-size: 0.8125rem;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                border-bottom: 2px solid #e9ecef;
                white-space: nowrap;
            }
        }

        tbody {
            tr {
                transition: background-color 0.2s ease;
                border-bottom: 1px solid #f1f3f4;

                &:hover {
                    background: #f8f9fa;
                }

                td {
                    border: none;
                    padding: 1rem;
                    vertical-align: middle;
                    color: #2c3e50;
                }
            }
        }
    }
}

.action-buttons {
    display: flex;
    gap: 0.5rem;

    .btn-action {
        width: 32px;
        height: 32px;
        border: none;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        cursor: pointer;

        &.btn-edit {
            background: #3b82f6;
            color: white;

            &:hover {
                background: #2563eb;
            }
        }

        &.btn-view {
            background: #10b981;
            color: white;

            &:hover {
                background: #059669;
            }
        }
    }
}

@media (max-width: 768px) {
    .stats-section {
        .stats-card {
            .stats-content-wrapper {
                .stats-icon {
                    width: 56px;
                    height: 56px;
                    font-size: 1.5rem;
                }

                .stats-content .stats-number {
                    font-size: 1.75rem;
                }
            }
        }
    }

    .dashboard-card {
        .card-header-custom {
            padding: 1.25rem;

            .header-content {
                .header-icon {
                    width: 40px;
                    height: 40px;
                    font-size: 1.1rem;
                }

                .header-text .card-title {
                    font-size: 1.1rem;
                }
            }
        }
    }
}
</style>
