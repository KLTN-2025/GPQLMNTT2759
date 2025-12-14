<template>
  <!-- Overlay for mobile -->
  <div v-if="isMobileMenu && isSidebarOpen" class="sidebar-overlay show" @click="closeSidebar"></div>

  <!-- Menu dọc cố định -->
  <div class="sidebar-menu" :class="{
    show: isSidebarOpen || !isMobileMenu,
    collapsed: isCollapsed && !isMobileMenu,
    hovered: isHovered && isCollapsed && !isMobileMenu
  }" @mouseenter="handleMouseEnterWithDelay" @mouseleave="handleMouseLeaveWithDelay">
    <div class="sidebar-header">
      <div class="header-content" v-show="!isCollapsed || isHovered">
        <h4>Menu</h4>
      </div>
      <div class="header-actions">
        <button class="collapse-btn" @click="toggleCollapse" :title="isCollapsed ? 'Mở rộng menu' : 'Thu gọn menu'">
          <i class="bx" :class="isCollapsed ? 'bx-menu' : 'bx-menu'"></i>
        </button>
      </div>
    </div>

    <div class="sidebar-content">
      <div class="sidebar-item" @click="goToDashboard" :title="isCollapsed ? 'Dashboard' : ''">
        <i class="bx bx-home"></i>
        <span v-show="!isCollapsed || isHovered">Dashboard</span>
      </div>

      <div class="sidebar-item" @click="toggleSubMenu('nhanSu')" :title="isCollapsed ? 'Nhân Sự' : ''">
        <i class="fa-solid fa-users"></i>
        <span v-show="!isCollapsed || isHovered">Nhân Sự</span>
        <i v-show="!isCollapsed || isHovered" class="bx"
          :class="activeSubMenu === 'nhanSu' ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
      </div>
      <div v-show="activeSubMenu === 'nhanSu' && (!isCollapsed || isHovered)" class="sidebar-sub">
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
        <div class="sub-item" @click="goToLichLamViec">
          <i class="bx bx-calendar-check"></i>
          <span>Lịch Làm Việc</span>
        </div>
      </div>

      <div class="sidebar-item" @click="toggleSubMenu('hocSinh')" :title="isCollapsed ? 'Học Sinh & PH' : ''">
        <i class="fa-solid fa-graduation-cap"></i>
        <span v-show="!isCollapsed || isHovered">Học Sinh & PH</span>
        <i v-show="!isCollapsed || isHovered" class="bx"
          :class="activeSubMenu === 'hocSinh' ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
      </div>
      <div v-show="activeSubMenu === 'hocSinh' && (!isCollapsed || isHovered)" class="sidebar-sub">
        <div class="sub-item" @click="goToHocSinh">
          <i class="fa-solid fa-user-pen"></i>
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

      <div class="sidebar-item" @click="goToLopHoc" :title="isCollapsed ? 'Lớp Học' : ''">
        <i class="bx bx-book"></i>
        <span v-show="!isCollapsed || isHovered">Lớp Học</span>
      </div>
      <div class="sidebar-item" @click="goToSucKhoe" :title="isCollapsed ? 'Sức Khỏe' : ''">
        <i class="bx bx-heart"></i>
        <span v-show="!isCollapsed || isHovered">Sức Khỏe</span>
      </div>
      <div class="sidebar-item" @click="goToHocPhi" :title="isCollapsed ? 'Học Phí' : ''">
        <i class="bx bx-money"></i>
        <span v-show="!isCollapsed || isHovered">Học Phí</span>
      </div>
      <div class="sidebar-item" @click="toggleSubMenu('thucDon')" :title="isCollapsed ? 'Thực Đơn' : ''">
        <i class="bx bx-restaurant"></i>
        <span v-show="!isCollapsed || isHovered">Thực Đơn</span>
        <i v-show="!isCollapsed || isHovered" class="bx"
          :class="activeSubMenu === 'thucDon' ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
      </div>
      <div v-show="activeSubMenu === 'thucDon' && (!isCollapsed || isHovered)" class="sidebar-sub">
        <div class="sub-item" @click="goToThucDon">
          <i class="bx bx-restaurant"></i>
          <span>Thực Đơn</span>
        </div>
        <div class="sub-item" @click="goToMonAn">
          <i class="bx bx-hamburger"></i>
          <span>Món Ăn</span>
        </div>
      </div>

      <div class="sidebar-item" @click="toggleSubMenu('noiDung')" :title="isCollapsed ? 'Nội Dung' : ''">
        <i class="fas fa-file-alt"></i>
        <span v-show="!isCollapsed || isHovered">Nội Dung</span>
        <i v-show="!isCollapsed || isHovered" class="bx"
          :class="activeSubMenu === 'noiDung' ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
      </div>
      <div v-show="activeSubMenu === 'noiDung' && (!isCollapsed || isHovered)" class="sidebar-sub">
        <div class="sub-item" @click="goToThongBao">
          <i class="fas fa-bell"></i>
          <span>Thông Báo</span>
        </div>
        <div class="sub-item" @click="goToBaiViet">
          <i class="fas fa-newspaper"></i>
          <span>Bài Viết</span>
        </div>
      </div>

      <div class="sidebar-item" @click="toggleSubMenu('baoCao')" :title="isCollapsed ? 'Báo cáo & TK' : ''">
        <i class="bx bx-bar-chart"></i>
        <span v-show="!isCollapsed || isHovered">Báo cáo & TK</span>
        <i v-show="!isCollapsed || isHovered" class="bx"
          :class="activeSubMenu === 'baoCao' ? 'bx-chevron-up' : 'bx-chevron-down'"></i>
      </div>
      <div v-show="activeSubMenu === 'baoCao' && (!isCollapsed || isHovered)" class="sidebar-sub">
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
import { ref, onMounted, onUnmounted } from "vue";
import { useRouter } from "vue-router";

const props = defineProps({
  isSidebarOpen: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(["closeSidebar", "sidebarCollapsed"]);

const hoverNhanSu = ref(false);
const hoverHocSinh = ref(false);
const hoverBaoCao = ref(false);
const open = ref(["Settings"]);

const isMobileMenu = ref(false);
const activeSubMenu = ref(null);
const isCollapsed = ref(false);
const isHovered = ref(false);

const router = useRouter();

// Check if we're on mobile
function checkMobile() {
  isMobileMenu.value = window.innerWidth < 992;
}

function toggleSubMenu(menu) {
  // Cho phép mở submenu khi menu chưa thu gọn hoặc đang hover
  if (isCollapsed.value && !isHovered.value) return;

  // Nếu đang hover và menu collapsed, chỉ cho phép mở submenu
  if (isCollapsed.value && isHovered.value) {
    activeSubMenu.value = activeSubMenu.value === menu ? null : menu;
  } else {
    // Logic bình thường khi menu không collapsed
    activeSubMenu.value = activeSubMenu.value === menu ? null : menu;
  }
}

function toggleCollapse() {
  isCollapsed.value = !isCollapsed.value;
  // Đóng tất cả submenu khi thu gọn
  if (isCollapsed.value) {
    activeSubMenu.value = null;
    isHovered.value = false; // Đảm bảo hover state được reset
  }
  // Lưu trạng thái vào localStorage
  localStorage.setItem('sidebarCollapsed', isCollapsed.value.toString());
  // Emit event để thông báo cho parent component
  emit('sidebarCollapsed', isCollapsed.value);
}

function handleMouseEnter() {
  if (isCollapsed.value && !isMobileMenu.value) {
    isHovered.value = true;
  }
}

function handleMouseLeave() {
  if (isCollapsed.value && !isMobileMenu.value) {
    isHovered.value = false;
  }
}

// Thêm timeout để tránh flicker khi di chuột nhanh
let hoverTimeout = null;

function handleMouseEnterWithDelay() {
  if (hoverTimeout) {
    clearTimeout(hoverTimeout);
  }
  if (isCollapsed.value && !isMobileMenu.value) {
    isHovered.value = true;
    // Không tự động mở submenu khi hover, để người dùng tự chọn
  }
}

function handleMouseLeaveWithDelay() {
  hoverTimeout = setTimeout(() => {
    if (isCollapsed.value && !isMobileMenu.value) {
      isHovered.value = false;
      // Đóng tất cả submenu khi hover ra ngoài
      activeSubMenu.value = null;
    }
  }, 100);
}

function closeSidebar() {
  emit("closeSidebar");
}

function handleResize() {
  checkMobile();
  // Tự động đóng sidebar khi chuyển về desktop
  if (!isMobileMenu.value) {
    emit("closeSidebar");
  }
}

onMounted(() => {
  checkMobile();
  handleResize();
  window.addEventListener("resize", handleResize);

  // Load trạng thái thu gọn từ localStorage
  const savedCollapsedState = localStorage.getItem('sidebarCollapsed');
  if (savedCollapsedState !== null) {
    isCollapsed.value = savedCollapsedState === 'true';
    // Emit event để thông báo trạng thái ban đầu
    emit('sidebarCollapsed', isCollapsed.value);
  }
});

onUnmounted(() => {
  window.removeEventListener("resize", handleResize);
});

// Navigation functions
function goToDashboard() {
  router.push("/admin");
}
function goToPhanQuyen() {
  router.push("/admin/phan-quyen");
}
function goToNhanVien() {
  router.push("/admin/nhan-vien");
}
function goToGiaoVien() {
  router.push("/admin/giao-vien");
}
function goToHocSinh() {
  router.push("/admin/hoc-sinh");
}
function goToPhuHuynh() {
  router.push("/admin/phu-huynh");
}
function goToDiemDanh() {
  router.push("/admin/diem-danh");
}
function goToLopHoc() {
  router.push("/admin/lop-hoc");
}
function goToSucKhoe() {
  router.push("/admin/suc-khoe");
}
function goToHocPhi() {
  router.push("/admin/hoc-phi");
}
function goToThucDon() {
  router.push("/admin/thuc-don");
}
function goToMonAn() {
  router.push("/admin/mon-an");
}
function goToThongBao() {
  router.push("/admin/thong-bao");
}
function goToBaiViet() {
  router.push("/admin/bai-viet");
}
function goToLichLamViec() {
  router.push("/admin/lich-lam-viec");
}
function goToTaiChinh() {
  router.push("/admin/tai-chinh");
}
function goToBaoCao() {
  router.push("/admin/bao-cao");
}
function goToThongKe() {
  router.push("/admin/thong-ke");
}
</script>

<style lang="scss">
@use "./style.scss";

.sidebar-menu {
  width: 280px;
  background: #fff;
  border-right: 1px solid #e0e0e0;
  padding: 0;
  margin-top: 0;

  position: fixed;
  /* Cố định menu */
  top: 80px;
  /* Position below header */
  left: 0;
  height: calc(100vh - 80px);
  overflow-y: auto;
  box-shadow: 2px 0 15px rgba(0, 0, 0, 0.1);
  transform: translateX(0);
  z-index: 999;
  transition: width 0.3s ease, z-index 0.3s ease;

  &.collapsed {
    width: 70px;
  }

  &.hovered {
    width: 280px;
    z-index: 1001;
    box-shadow: 2px 0 20px rgba(0, 0, 0, 0.15);

    .sidebar-header {
      .header-content {
        opacity: 1;
        transition: opacity 0.3s ease;
      }
    }
  }

  .sidebar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    border-bottom: 1px solid #e9ecef;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    min-height: 60px;

    .header-content {
      flex: 1;
      transition: opacity 0.3s ease;
    }

    .header-actions {
      display: flex;
      align-items: center;
    }

    .collapse-btn {
      background: rgba(255, 255, 255, 0.2);
      border: none;
      border-radius: 8px;
      padding: 8px;
      color: white;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 36px;
      height: 36px;

      &:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.05);
      }

      i {
        font-size: 18px;
      }
    }

    h4 {
      margin: 0;
      font-size: 1.2rem;
      font-weight: 600;
    }
  }

  .sidebar-content {
    padding: 0;
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
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    transition: all 0.3s ease;
    position: relative;
    white-space: nowrap;

    &:hover {
      background-color: #f8f9fa;
      color: #667eea;
      padding-left: 25px;
    }

    i {
      font-size: 18px;
      width: 20px;
      text-align: center;
      flex-shrink: 0;
    }

    span {
      font-size: 17px;
      font-family: "Times New Roman";
      transition: opacity 0.3s ease;
      overflow: hidden;
    }

    .bx-chevron-down,
    .bx-chevron-up {
      font-size: 16px;
      transition: transform 0.3s ease;
      margin-left: auto;
    }
  }

  &.collapsed {
    .sidebar-item {
      padding: 15px 10px;
      justify-content: center;

      &:hover {
        padding-left: 10px;
      }

      span {
        opacity: 0;
        width: 0;
      }

      .bx-chevron-down,
      .bx-chevron-up {
        display: none;
      }
    }
  }

  &.hovered {
    .sidebar-item {
      padding: 15px 20px;
      justify-content: flex-start;
      transition: all 0.3s ease;

      &:hover {
        padding-left: 25px;
      }

      span {
        opacity: 1;
        width: auto;
        transition: opacity 0.3s ease, width 0.3s ease;
      }

      .bx-chevron-down,
      .bx-chevron-up {
        display: block;
        transition: opacity 0.3s ease;
      }
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

  &.collapsed {
    .sidebar-sub {
      display: none;
    }
  }

  &.hovered {
    .sidebar-sub {
      display: block;
      animation: slideDown 0.3s ease;
      background: #f8f9fa;
      border-left: 3px solid #667eea;
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

/* Mobile responsive */
@media (max-width: 992px) {
  .sidebar-menu {
    transform: translateX(-100%);
    transition: transform 0.3s ease;
    z-index: 1000;
  }

  .sidebar-menu.show {
    transform: translateX(0);
  }

  .sidebar-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;
    display: none;
  }

  .sidebar-overlay.show {
    display: block;
  }
}

/* Tooltip styles for collapsed menu */
.sidebar-menu.collapsed .sidebar-item {
  position: relative;

  &::after {
    content: attr(title);
    position: absolute;
    left: 100%;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 14px;
    white-space: nowrap;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    z-index: 1000;
    margin-left: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  }

  &::before {
    content: '';
    position: absolute;
    left: 100%;
    top: 50%;
    transform: translateY(-50%);
    border: 5px solid transparent;
    border-right-color: rgba(0, 0, 0, 0.8);
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    z-index: 1000;
    margin-left: 5px;
  }

  &:hover::after,
  &:hover::before {
    opacity: 1;
    visibility: visible;
  }
}
</style>
