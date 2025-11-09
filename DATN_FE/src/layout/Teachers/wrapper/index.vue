<template>
    <div class="teacher-wrapper">
        <div class="teacher-header-wrapper">
            <TopTeacher :isSidebarOpen="isSidebarOpen" @toggleSidebar="toggleSidebar"></TopTeacher>
            <MenuTeacher :isSidebarOpen="isSidebarOpen" @closeSidebar="closeSidebar"></MenuTeacher>
        </div>
        <div class="teacher-page-wrapper">
            <div class="teacher-page-content">
                <router-view></router-view>
            </div>
        </div>
        <BotTeacher></BotTeacher>
    </div>
</template>

<script>
import { ref } from 'vue';
import TopTeacher from "../components/Top/index.vue";
import BotTeacher from "../components/Bottom/index.vue";
import MenuTeacher from "../components/Menu/index.vue";
import "../../../assets/js/bootstrap.bundle.min.js";
import "../../../assets/js/jquery.min.js";
import "../../../assets/plugins/simplebar/js/simplebar.min.js";
import "../../../assets/plugins/metismenu/js/metisMenu.min.js";
import "../../../assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js";
import "../../../assets/js/index.js";
import "../../../assets/js/app.js";
import "../../../assets/js/pace.min.js";

export default {
    name: "TeacherLayout",
    components: {
        TopTeacher, MenuTeacher, BotTeacher
    },
    setup() {
        const isSidebarOpen = ref(false);

        const toggleSidebar = () => {
            isSidebarOpen.value = !isSidebarOpen.value;
        };

        const closeSidebar = () => {
            isSidebarOpen.value = false;
        };

        return {
            isSidebarOpen,
            toggleSidebar,
            closeSidebar
        };
    },
    mounted() {
        // Đảm bảo scroll về đầu trang khi component được mount
        window.scrollTo(0, 0);
    }
}
</script>

<style>
/* Import only essential CSS, excluding app.css to avoid conflicts */
@import "../../../assets/plugins/simplebar/css/simplebar.css";
@import "../../../assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css";
@import "../../../assets/plugins/metismenu/css/metisMenu.min.css";
@import "../../../assets/css/pace.min.css";
@import "../../../assets/css/bootstrap.min.css";
@import "../../../assets/css/bootstrap-extended.css";
@import url("https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap");
@import "../../../assets/css/icons.css";
@import "../../../assets/css/dark-theme.css";
@import "../../../assets/css/semi-dark.css";
@import "../../../assets/css/header-colors.css";
@import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css");

/* Import Teacher-specific CSS */
@import "../../../assets/css/teacher-layout.css";
</style>
