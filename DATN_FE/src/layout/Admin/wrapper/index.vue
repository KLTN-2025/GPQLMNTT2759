<template>
  <div class="admin-wrapper">
    <div class="admin-header-wrapper">
      <TopAdmin :isSidebarOpen="isSidebarOpen" @toggleSidebar="toggleSidebar"></TopAdmin>
    </div>
    <div class="admin-page-wrapper">
      <div class="admin-page-content">
        <MenuAdmin :isSidebarOpen="isSidebarOpen" @closeSidebar="closeSidebar"
          @sidebarCollapsed="handleSidebarCollapsed"></MenuAdmin>
        <div class="admin-main-content" :class="{ 'collapsed': isSidebarCollapsed }">
          <router-view></router-view>
        </div>
      </div>
    </div>
    <BotAdmin></BotAdmin>
  </div>
</template>
<script>
import { ref } from 'vue';
import TopAdmin from "../components/Top/index.vue";
import BotAdmin from "../components/Bottom/index.vue";
import MenuAdmin from "../components/Menu/test.vue";
import "../../../assets/js/bootstrap.bundle.min.js";
import "../../../assets/js/jquery.min.js";
import "../../../assets/plugins/simplebar/js/simplebar.min.js";
import "../../../assets/plugins/metismenu/js/metisMenu.min.js";
import "../../../assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js";
import "../../../assets/js/index.js";
import "../../../assets/js/app.js";
import "../../../assets/js/pace.min.js";

export default {
  name: "app",
  components: {
    TopAdmin, MenuAdmin, BotAdmin
  },
  setup() {
    const isSidebarOpen = ref(false);
    const isSidebarCollapsed = ref(false);

    const toggleSidebar = () => {
      isSidebarOpen.value = !isSidebarOpen.value;
    };

    const closeSidebar = () => {
      isSidebarOpen.value = false;
    };

    const handleSidebarCollapsed = (collapsed) => {
      isSidebarCollapsed.value = collapsed;
    };

    return {
      isSidebarOpen,
      isSidebarCollapsed,
      toggleSidebar,
      closeSidebar,
      handleSidebarCollapsed
    };
  },
  mounted() {
    // Đảm bảo scroll về đầu trang khi component được mount
    window.scrollTo(0, 0);
  }
}
</script>
<style>
/* Import essential CSS, keeping app.css for Admin compatibility */
@import "../../../assets/plugins/simplebar/css/simplebar.css";
@import "../../../assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css";
@import "../../../assets/plugins/metismenu/css/metisMenu.min.css";
@import "../../../assets/css/pace.min.css";
@import "../../../assets/css/bootstrap.min.css";
@import "../../../assets/css/bootstrap-extended.css";
@import url("https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap");
@import "../../../assets/css/app.css";
@import "../../../assets/css/icons.css";
@import "../../../assets/css/dark-theme.css";
@import "../../../assets/css/semi-dark.css";
@import "../../../assets/css/header-colors.css";
@import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css");
@import "../../../assets/css/admin-layout.css";

/* Admin Layout Styles */
.admin-wrapper {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  background: #f8f9fa;
}

.admin-header-wrapper {
  position: fixed;
  top: 0;
  width: 100%;
  z-index: 1000;
  background: white;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.admin-page-wrapper {
  flex: 1;
  padding-top: 80px;
  /* Space for fixed header */
}

.admin-page-content {
  padding: 0;
  display: flex;
  min-height: calc(100vh - 80px);
}

.admin-main-content {
  flex: 1;
  margin-left: 280px;
  /* Width of sidebar */
  padding: 20px;
  min-height: calc(100vh - 80px);
  background: white;
  border-radius: 8px 0 0 0;
  box-shadow: -2px 0 4px rgba(0, 0, 0, 0.05);
  transition: margin-left 0.3s ease;
}

.admin-main-content.collapsed {
  margin-left: 70px;
}

/* Mobile responsive */
@media (max-width: 992px) {
  .admin-main-content {
    margin-left: 0;
    padding: 15px;
    border-radius: 0;
  }

  .admin-page-wrapper {
    padding-top: 70px;
  }
}
</style>