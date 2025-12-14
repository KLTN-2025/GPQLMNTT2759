<template>
    <div class="header-menu-container">
        <!-- Overlay cho mobile -->
        <div v-if="isMobileMenu && props.isSidebarOpen" class="sidebar-overlay" @click="closeSidebar"></div>

        <!-- Menu ngang (desktop) -->
        <div class="header-menu" v-if="!isMobileMenu">
            <div class="form-nav">
                <div class="nav-menu">
                    <div class="item-home" @click="goToDashboard">Dashboard</div>
                    <div class="item-home" @click="goToMyClass">Lớp học</div>
                    <div class="item-home" @click="goToAttendance">Điểm danh</div>

                    <!-- Hoạt động -->
                    <div class="post-wrapper" @mouseenter="hoverActivity = true" @mouseleave="hoverActivity = false">
                        <div class="item-home">Hoạt động</div>
                        <transition name="fade-slide">
                            <v-card class="blog-dropdown" v-show="hoverActivity">
                                <v-list v-model:opened="open">
                                    <v-list-item @click="goToSchedule" title="Lịch làm việc" />
                                    <v-list-item @click="goToLessonPlan" title="Kế hoạch dạy học" />
                                    <v-list-item @click="goToNotes" title="Ghi chú" />
                                </v-list>
                            </v-card>
                        </transition>
                    </div>
                    <div class="item-home" @click="goToMessages">Tin nhắn</div>
                    <div class="item-home" @click="goToHealth">Sức khỏe</div>

                    <!-- Báo cáo -->
                    <div class="post-wrapper" @mouseenter="hoverReport = true" @mouseleave="hoverReport = false">
                        <div class="item-home">Báo cáo</div>
                        <transition name="fade-slide">
                            <v-card class="blog-dropdown" v-show="hoverReport">
                                <v-list v-model:opened="open">
                                    <v-list-item @click="goToReports" title="Báo cáo học tập" />
                                    <v-list-item @click="goToProgress" title="Tiến độ học tập" />
                                </v-list>
                            </v-card>
                        </transition>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu dọc (mobile sidebar) -->
        <div class="sidebar-menu" v-else :class="{ show: props.isSidebarOpen }">
            <div class="sidebar-header">
                <h4>Menu Giáo Viên</h4>
                <button class="close-btn" @click="closeSidebar">
                    <i class="bx bx-x"></i>
                </button>
            </div>

            <div class="sidebar-item" @click="goToDashboard">
                <i class="bx bx-home"></i>
                <span>Dashboard</span>
            </div>

            <div class="sidebar-item" @click="goToMyClass">
                <i class="bx bx-book-reader"></i>
                <span>Lớp học của tôi</span>
            </div>

            <div class="sidebar-item" @click="goToAttendance">
                <i class="bx bx-check-square"></i>
                <span>Điểm danh</span>
            </div>

            <div class="sidebar-item" @click="toggleSubMenu('activity')">
                <i class="bx bx-spreadsheet"></i>
                <span>Hoạt động</span>
                <i class="bx" :class="activeSubMenu === 'activity' ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
            </div>
            <div v-show="activeSubMenu === 'activity'" class="sidebar-sub">
                <div class="sub-item" @click="goToSchedule">
                    <i class="bx bx-calendar"></i>
                    <span>Lịch làm việc</span>
                </div>
                <div class="sub-item" @click="goToLessonPlan">
                    <i class="bx bx-book-open"></i>
                    <span>Kế hoạch dạy học</span>
                </div>
                <div class="sub-item" @click="goToNotes">
                    <i class="bx bx-edit"></i>
                    <span>Ghi chú</span>
                </div>
            </div>

            <div class="sidebar-item" @click="goToMessages">
                <i class="bx bx-message"></i>
                <span>Tin nhắn</span>
            </div>

            <div class="sidebar-item" @click="goToHealth">
                <i class="bx bx-heart"></i>
                <span>Sức khỏe</span>
            </div>

            <div class="sidebar-item" @click="toggleSubMenu('report')">
                <i class="bx bx-bar-chart"></i>
                <span>Báo cáo</span>
                <i class="bx" :class="activeSubMenu === 'report' ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
            </div>
            <div v-show="activeSubMenu === 'report'" class="sidebar-sub">
                <div class="sub-item" @click="goToReports">
                    <i class="bx bx-file"></i>
                    <span>Báo cáo học tập</span>
                </div>
                <div class="sub-item" @click="goToProgress">
                    <i class="bx bx-trending-up"></i>
                    <span>Tiến độ học tập</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import { useRouter } from "vue-router";

const props = defineProps({
    isSidebarOpen: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['closeSidebar']);

const hoverActivity = ref(false);
const hoverReport = ref(false);
const open = ref(["Settings"]);

const isMobileMenu = ref(false);
const activeSubMenu = ref(null);

const router = useRouter();

function toggleSubMenu(menu) {
    activeSubMenu.value = activeSubMenu.value === menu ? null : menu;
}

function closeSidebar() {
    emit('closeSidebar');
}

function handleResize() {
    isMobileMenu.value = window.innerWidth < 992;
    if (!isMobileMenu.value) {
        emit('closeSidebar');
    }
}

onMounted(() => {
    handleResize();
    window.addEventListener("resize", handleResize);
});

onUnmounted(() => {
    window.removeEventListener("resize", handleResize);
});

// Navigation functions
function goToDashboard() { router.push("/teacher"); closeSidebar(); }
function goToMyClass() { router.push("/teacher/my-class"); closeSidebar(); }
function goToAttendance() { router.push("/teacher/attendance"); closeSidebar(); }
function goToSchedule() { router.push("/teacher/schedule"); closeSidebar(); }
function goToLessonPlan() { router.push("/teacher/lesson-plan"); closeSidebar(); }
function goToNotes() { router.push("/teacher/notes"); closeSidebar(); }
function goToMessages() { router.push("/teacher/messages"); closeSidebar(); }
function goToHealth() { router.push("/teacher/health"); closeSidebar(); }
function goToReports() { router.push("/teacher/reports"); closeSidebar(); }
function goToProgress() { router.push("/teacher/progress"); closeSidebar(); }
</script>

<style lang="scss" scoped>
.header-menu-container {
    padding: 0;
    margin-top: 0;
    height: auto;
    position: relative;
    z-index: 999;
    background-color: #fff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.header-menu {
    width: 100%;
    background-color: #fff;
    border-bottom: 1px solid #e0e0e0;
    position: relative;
    z-index: 998;
}

.form-nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.nav-menu {
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 0 20px;
    width: 100%;
    justify-content: flex-start;
}

.item-home {
    padding: 15px 20px;
    font-weight: 500;
    cursor: pointer;
    border-bottom: 3px solid transparent;
    transition: all 0.3s ease;
    color: #333;
    font-size: 16px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;

    &:hover {
        background-color: #f8f9fa;
        border-bottom-color: #667eea;
        color: #667eea;
    }
}

.post-wrapper {
    position: relative;
    cursor: pointer;
}

.blog-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    min-width: 200px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    z-index: 1000;
    margin-top: 0;
}

.fade-slide-enter-active,
.fade-slide-leave-active {
    transition: all 0.3s ease;
}

.fade-slide-enter-from {
    opacity: 0;
    transform: translateY(-10px);
}

.fade-slide-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}

.sidebar-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;
}

.sidebar-menu {
    width: 280px;
    background: #fff;
    border-right: 1px solid #e0e0e0;
    padding: 0;
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    z-index: 1001;
    overflow-y: auto;
    box-shadow: 2px 0 15px rgba(0, 0, 0, 0.1);
    transform: translateX(-100%);
    transition: transform 0.3s ease;

    &.show {
        transform: translateX(0);
    }

    .sidebar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
        border-bottom: 1px solid #e9ecef;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;

        h4 {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .close-btn {
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            padding: 5px;
            border-radius: 50%;
            transition: background-color 0.3s ease;

            &:hover {
                background-color: rgba(255, 255, 255, 0.2);
            }
        }
    }

    .sidebar-item {
        padding: 15px 20px;
        font-weight: 500;
        cursor: pointer;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        gap: 12px;
        color: #333;
        font-size: 16px;
        transition: all 0.3s ease;

        &:hover {
            background-color: #f8f9fa;
            color: #667eea;
            padding-left: 25px;
        }

        i {
            font-size: 18px;
            width: 20px;
            text-align: center;
        }

        span {
            flex: 1;
        }

        .bx-chevron-down,
        .bx-chevron-up {
            font-size: 16px;
            transition: transform 0.3s ease;
        }
    }

    .sidebar-sub {
        background: #f8f9fa;
        border-left: 3px solid #667eea;
        animation: slideDown 0.3s ease;

        .sub-item {
            padding: 12px 20px 12px 50px;
            cursor: pointer;
            color: #666;
            font-size: 14px;
            transition: all 0.3s ease;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            align-items: center;
            gap: 10px;

            &:hover {
                background-color: #e9ecef;
                color: #667eea;
                padding-left: 55px;
            }

            &:last-child {
                border-bottom: none;
            }

            i {
                font-size: 16px;
                width: 16px;
                text-align: center;
            }
        }
    }
}

@keyframes slideDown {
    from {
        opacity: 0;
        max-height: 0;
    }

    to {
        opacity: 1;
        max-height: 300px;
    }
}

@media (max-width: 991px) {
    .header-menu-container {
        padding: 0;
        margin-top: 0;
        height: auto;
        position: relative;
        z-index: 1000;
        box-shadow: none;
    }

    .sidebar-menu {
        transform: translateX(-100%);

        &.show {
            transform: translateX(0);
        }
    }
}
</style>
