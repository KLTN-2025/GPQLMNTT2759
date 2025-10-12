<template>
    <div class="header-menu-container">
        <!-- Overlay cho mobile -->
        <div v-if="isMobileMenu && props.isSidebarOpen" class="sidebar-overlay" @click="closeSidebar"></div>

        <!-- Menu ngang (chỉ hiện khi đủ màn hình) -->
        <div class="header-menu" v-if="!isMobileMenu">
            <div class="form-nav">
                <div class="nav-menu">
                    <div class="item-home" @click="goToDashboard">Dashboard</div>

                    <!-- Nhân Sự -->
                    <div class="post-wrapper" @mouseenter="hoverNhanSu = true" @mouseleave="hoverNhanSu = false">
                        <div class="item-home">Nhân Sự</div>
                        <transition name="fade-slide">
                            <v-card class="blog-dropdown" v-show="hoverNhanSu">
                                <v-list v-model:opened="open">
                                    <v-list-item @click="goToPhanQuyen" title="Phân Quyền" />
                                    <v-list-item @click="goToNhanVien" title="Nhân Viên" />
                                    <v-list-item @click="goToGiaoVien" title="Giáo Viên" />
                                </v-list>
                            </v-card>
                        </transition>
                    </div>

                    <!-- Học Sinh & PH -->
                    <div class="post-wrapper" @mouseenter="hoverHocSinh = true" @mouseleave="hoverHocSinh = false">
                        <div class="item-home">Học Sinh & PH</div>
                        <transition name="fade-slide">
                            <v-card class="blog-dropdown" v-show="hoverHocSinh">
                                <v-list v-model:opened="open">
                                    <v-list-item @click="goToHocSinh" title="Học Sinh" />
                                    <v-list-item @click="goToPhuHuynh" title="Phụ Huynh" />
                                    <v-list-item @click="goToDiemDanh" title="Điểm Danh" />
                                </v-list>
                            </v-card>
                        </transition>
                    </div>

                    <div class="item-home" @click="goToLopHoc">Lớp Học</div>
                    <div class="item-home" @click="goToSucKhoe">Sức Khỏe</div>
                    <div class="item-home" @click="goToHocPhi">Học Phí</div>
                    <div class="item-home" @click="goToThucDon">Thực Đơn</div>

                    <!-- Báo cáo -->
                    <div class="post-wrapper" @mouseenter="hoverBaoCao = true" @mouseleave="hoverBaoCao = false">
                        <div class="item-home">Báo cáo & TK</div>
                        <transition name="fade-slide">
                            <v-card class="blog-dropdown" v-show="hoverBaoCao">
                                <v-list v-model:opened="open">
                                    <v-list-item @click="goToTaiChinh" title="Tài Chính" />
                                    <v-list-item @click="goToBaoCao" title="Báo Cáo" />
                                    <v-list-item @click="goToThongKe" title="Thống Kê" />
                                </v-list>
                            </v-card>
                        </transition>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu dọc (sidebar khi màn nhỏ) -->
        <div class="sidebar-menu" v-else :class="{ show: props.isSidebarOpen }">
            <div class="sidebar-header">
                <h4>Menu</h4>
                <button class="close-btn" @click="closeSidebar">
                    <i class="bx bx-x"></i>
                </button>
            </div>

            <div class="sidebar-item" @click="goToDashboard">
                <i class="bx bx-home"></i>
                <span>Dashboard</span>
            </div>

            <div class="sidebar-item" @click="toggleSubMenu('nhanSu')">
                <i class="bx bx-group"></i>
                <span>Nhân Sự</span>
                <i class="bx" :class="activeSubMenu === 'nhanSu' ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
            </div>
            <div v-show="activeSubMenu === 'nhanSu'" class="sidebar-sub">
                <div class="sub-item" @click="goToPhanQuyen">
                    <i class="bx bx-shield"></i>
                    <span>Phân Quyền</span>
                </div>
                <div class="sub-item" @click="goToNhanVien">
                    <i class="bx bx-user"></i>
                    <span>Nhân Viên</span>
                </div>
                <div class="sub-item" @click="goToGiaoVien">
                    <i class="bx bx-chalkboard"></i>
                    <span>Giáo Viên</span>
                </div>
            </div>

            <div class="sidebar-item" @click="toggleSubMenu('hocSinh')">
                <i class="bx bx-child"></i>
                <span>Học Sinh & PH</span>
                <i class="bx" :class="activeSubMenu === 'hocSinh' ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
            </div>
            <div v-show="activeSubMenu === 'hocSinh'" class="sidebar-sub">
                <div class="sub-item" @click="goToHocSinh">
                    <i class="bx bx-child"></i>
                    <span>Học Sinh</span>
                </div>
                <div class="sub-item" @click="goToPhuHuynh">
                    <i class="bx bx-user-circle"></i>
                    <span>Phụ Huynh</span>
                </div>
                <div class="sub-item" @click="goToDiemDanh">
                    <i class="bx bx-check-square"></i>
                    <span>Điểm Danh</span>
                </div>
            </div>

            <div class="sidebar-item" @click="goToLopHoc">
                <i class="bx bx-book"></i>
                <span>Lớp Học</span>
            </div>
            <div class="sidebar-item" @click="goToSucKhoe">
                <i class="bx bx-heart"></i>
                <span>Sức Khỏe</span>
            </div>
            <div class="sidebar-item" @click="goToHocPhi">
                <i class="bx bx-money"></i>
                <span>Học Phí</span>
            </div>
            <div class="sidebar-item" @click="goToThucDon">
                <i class="bx bx-restaurant"></i>
                <span>Thực Đơn</span>
            </div>

            <div class="sidebar-item" @click="toggleSubMenu('baoCao')">
                <i class="bx bx-bar-chart"></i>
                <span>Báo cáo & TK</span>
                <i class="bx" :class="activeSubMenu === 'baoCao' ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
            </div>
            <div v-show="activeSubMenu === 'baoCao'" class="sidebar-sub">
                <div class="sub-item" @click="goToTaiChinh">
                    <i class="bx bx-wallet"></i>
                    <span>Tài Chính</span>
                </div>
                <div class="sub-item" @click="goToBaoCao">
                    <i class="bx bx-file"></i>
                    <span>Báo Cáo</span>
                </div>
                <div class="sub-item" @click="goToThongKe">
                    <i class="bx bx-pie-chart"></i>
                    <span>Thống Kê</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, defineProps, defineEmits } from "vue";
import { useRouter } from "vue-router";

const props = defineProps({
    isSidebarOpen: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['closeSidebar']);

const hoverNhanSu = ref(false);
const hoverHocSinh = ref(false);
const hoverBaoCao = ref(false);
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
    isMobileMenu.value = window.innerWidth < 992; // breakpoint
    // Tự động đóng sidebar khi chuyển về desktop
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
function goToDashboard() { router.push("/admin/dashboard"); }
function goToPhanQuyen() { router.push("/admin/phan-quyen"); }
function goToNhanVien() { router.push("/admin/nhan-vien"); }
function goToGiaoVien() { router.push("/admin/giao-vien"); }
function goToHocSinh() { router.push("/admin/hoc-sinh"); }
function goToPhuHuynh() { router.push("/admin/phu-huynh"); }
function goToDiemDanh() { router.push("/admin/diem-danh"); }
function goToLopHoc() { router.push("/admin/lop-hoc"); }
function goToSucKhoe() { router.push("/admin/suc-khoe"); }
function goToHocPhi() { router.push("/admin/hoc-phi"); }
function goToThucDon() { router.push("/admin/thuc-don"); }
function goToTaiChinh() { router.push("/admin/tai-chinh"); }
function goToBaoCao() { router.push("/admin/bao-cao"); }
function goToThongKe() { router.push("/admin/thong-ke"); }
</script>

<style lang="scss">
@use "./style.scss";

/* Overlay cho mobile */
.sidebar-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;
}

/* Sidebar menu styles */
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
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        transition: all 0.3s ease;
        position: relative;

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

/* Responsive adjustments */
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

.sidebar-menu.show {
    transform: translateX(0);
}
</style>