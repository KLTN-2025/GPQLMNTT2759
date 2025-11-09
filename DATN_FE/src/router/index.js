import { createRouter, createWebHistory } from "vue-router";
import checkAdmin from "./checkAdmin";
import checkTeacher from "./checkTeacher";
const routes = [
  // Client Routes

  {
    path: "/",
    component: () => import("../components/Client/HomePage/index.vue"),
    meta: { layout: "client" },
  },
  {
    path: "/login",
    component: () => import("../components/Client/Login/index.vue"),
    meta: { layout: "blank" },
  },
  {
    path: "/blog",
    component: () => import("../components/Client/Blog/index.vue"),
    meta: { layout: "client" },
  },

  {
    path: "/contact",
    component: () => import("../components/Client/Contact/index.vue"),
    meta: { layout: "client" },
  },
  {
    path: "/recruitment",
    component: () => import("../components/Client/Recruitment/index.vue"),
    meta: { layout: "client" },
  },
  {
    path: "/auth",
    component: () => import("../components/Client/Auth/index.vue"),
    meta: { layout: "client" },
  },
  {
    path: "/parent-mail-box",
    component: () => import("../components/Client/ParentMailbox/index.vue"),
    meta: { layout: "client" },
  },
  {
    path: "/blog-detail",
    component: () => import("../components/Client/BlogDetail/index.vue"),
    meta: { layout: "client" },
  },
  {
    path: "/school-blog",
    component: () => import("../components/Client/SchoolBlog/index.vue"),
    meta: { layout: "client" },
  },

  {
    path: "/teachers",
    component: () => import("../components/Client/Teachers/index.vue"),
    meta: { layout: "client" },
  },
  {
    path: "/educationSystem",
    component: () => import("../components/Client/EducationSystem/index.vue"),
    meta: { layout: "client" },
  },
  {
    path: "/advantages",
    component: () => import("../components/Client/Advantage/index.vue"),
    meta: { layout: "client" },
  },

  {
    path: "/activities",
    component: () => import("../components/Client/Activities/index.vue"),
    meta: { layout: "client" },
  },
  {
    path: "/meal",
    component: () => import("../components/Client/Meal/index.vue"),
    meta: { layout: "client" },
  },
  {
    path: "/notebook",
    component: () => import("../components/Client/Notebook/index.vue"),
    meta: { layout: "client" },
  },
  {
    path: "/notebook-detail",
    component: () => import("../components/Client/NotebookDetail/index.vue"),
    meta: { layout: "client" },
  },
  {
    path: "/tuition",
    component: () => import("../components/Client/Tuition/index.vue"),
    meta: { layout: "client" },
  },

  {
    path: "/instructPayment",
    component: () => import("../components/Client/InstructPayment/index.vue"),
    meta: { layout: "client" },
  },
  {
    path: "/registration",
    component: () => import("../components/Client/Registration/index.vue"),
    meta: { layout: "client" },
  },
  {
    path: "/programme",
    component: () => import("../components/Client/Programme/index.vue"),
    meta: { layout: "client" },
  },

  {
    path: "/middle-programme",
    component: () => import("../components/Client/MiddleProgram/index.vue"),
    meta: { layout: "client" },
  },
  {
    path: "/big-programme",
    component: () => import("../components/Client/BigProgram/index.vue"),
    meta: { layout: "client" },
  },
  {
    path: "/paymentHistory",
    component: () => import("../components/Client/PaymentHistory/index.vue"),
    meta: { layout: "client" },
  },
  {
    path: "/privacy",
    component: () => import("../components/Client/Privacy/index.vue"),
    meta: { layout: "client" },
  },
  {
    path: "/events",
    component: () => import("../components/Client/Events/index.vue"),
    meta: { layout: "client" },
  },
  {
    path: "/study-schedule",
    component: () => import("../components/Client/StudySchedule/index.vue"),
    meta: { layout: "client" },
  },

  // {  
  //     path : '/register',
  //     component: ()=>import('../components/Client/Register/index.vue'),
  //     meta:{ layout : 'blank' },
  // },

  // TEACHER ROUTES
  // TEACHER - Login
  {
    path: "/teacher/login",
    component: () => import("../components/Teachers/Login/index.vue"),
    meta: { layout: "blank" },
  },
  // TEACHER - Dashboard
  {
    path: "/teacher/dashboard",
    component: () => import("../components/Teachers/Dashboard/index.vue"),
    meta: { layout: "teacher" },
  },
  // TEACHER - My Class
  {
    path: "/teacher/my-class",
    component: () => import("../components/Teachers/MyClass/index.vue"),
    meta: { layout: "teacher" },
    beforeEnter: checkTeacher,
  },
  // TEACHER - Attendance
  {
    path: "/teacher/attendance",
    component: () => import("../components/Teachers/Attendance/index.vue"),
    meta: { layout: "teacher" },
    beforeEnter: checkTeacher,
  },
  // TEACHER - Assignments
  {
    path: "/teacher/assignments",
    component: () => import("../components/Teachers/Assignments/index.vue"),
    meta: { layout: "teacher" },
  },
  // TEACHER - Schedule
  {
    path: "/teacher/schedule",
    component: () => import("../components/Teachers/Schedule/index.vue"),
    meta: { layout: "teacher" },
  },
  // TEACHER - Notes
  {
    path: "/teacher/notes",
    component: () => import("../components/Teachers/Notes/index.vue"),
    meta: { layout: "teacher" },
  },
  // TEACHER - Notebook
  {
    path: "/teacher/notebook",
    component: () => import("../components/Teachers/Notebook/index.vue"),
    meta: { layout: "teacher" },
  },
  // TEACHER - Messages
  {
    path: "/teacher/messages",
    component: () => import("../components/Teachers/Messages/index.vue"),
    meta: { layout: "teacher" },
  },
  // TEACHER - Health
  {
    path: "/teacher/health",
    component: () => import("../components/Teachers/Health/index.vue"),
    meta: { layout: "teacher" },
  },
  // TEACHER - Teaching Plan
  {
    path: "/teacher/teaching-plan",
    component: () => import("../components/Teachers/TeachingPlan/index.vue"),
    meta: { layout: "teacher" },
    beforeEnter: checkTeacher,
  },
  // TEACHER - Gallery
  {
    path: "/teacher/gallery",
    component: () => import("../components/Teachers/Gallery/index.vue"),
    meta: { layout: "teacher" },
    beforeEnter: checkTeacher,
  },
  // TEACHER - Reports
  {
    path: "/teacher/reports",
    component: () => import("../components/Teachers/Reports/index.vue"),
    meta: { layout: "teacher" },
  },
  // TEACHER - Progress
  {
    path: "/teacher/progress",
    component: () => import("../components/Teachers/Progress/index.vue"),
    meta: { layout: "teacher" },
  },
  // TEACHER - Profile
  {
    path: "/teacher/profile",
    component: () => import("../components/Teachers/Profile/index.vue"),
    meta: { layout: "teacher" },
  },



  // Admin Routes
  // ADMIN - Login
  {
    path: "/admin/login",
    component: () => import("../components/Admin/Login/index.vue"),
    meta: { layout: "blank" },
  },
  // ADMIN - Dashboard
  {
    path: "/admin/dashboard",
    component: () => import("../components/Admin/Dashboard/index.vue"),
    beforeEnter: checkAdmin,
  },

  {
    path: "/admin/student-stats",
    component: () => import("../components/Admin/ToStudents/index.vue"),
    beforeEnter: checkAdmin,
  },
  // ADMIN - Học Sinh
  {
    path: "/admin/hoc-sinh",
    component: () => import("../components/Admin/Students/index.vue"),
    beforeEnter: checkAdmin,

  },
  // ADMIN - Nhân Viên
  {
    path: "/admin/nhan-vien",
    component: () => import("../components/Admin/Staff/index.vue"),
    beforeEnter: checkAdmin,

  },
  // ADMIN - Giáo Viên
  {
    path: "/admin/giao-vien",
    component: () => import("../components/Admin/Teachers/index.vue"),
  },
  // ADMIN - Phụ Huynh
  {
    path: "/admin/phu-huynh",
    component: () => import("../components/Admin/Parents/index.vue"),
  },

  // ADMIN - Điểm danh
  {
    path: "/admin/diem-danh",
    component: () => import("../components/Admin/Attendance/index.vue"),
  },
  // ADMIN - Lớp Học
  {
    path: "/admin/lop-hoc",
    component: () => import("../components/Admin/Classes/index.vue"),
    beforeEnter: checkAdmin,

  },
  // ADMIN - Phân Quyền
  {
    path: "/admin/phan-quyen",
    component: () => import("../components/Admin/Permissions/index.vue"),
    beforeEnter: checkAdmin,

  },
  // ADMIN - Báo cáo
  {
    path: "/admin/bao-cao",
    component: () => import("../components/Admin/Reports/index.vue"),
    beforeEnter: checkAdmin,

  },
  // ADMIN - Thực đơn
  {
    path: "/admin/thuc-don",
    component: () => import("../components/Admin/Menu/index.vue"),
    beforeEnter: checkAdmin,
  },
  // ADMIN - Tài chính
  {
    path: "/admin/tai-chinh",
    component: () => import("../components/Admin/Finance/index.vue"),
    beforeEnter: checkAdmin,
  },
  // ADMIN - Profile
  {
    path: "/admin/profile",
    component: () => import("../components/Admin/Profile/index.vue"),
    beforeEnter: checkAdmin,
  },
  // ADMIN - Thống kê
  {
    path: "/admin/thong-ke",
    component: () => import("../components/Admin/Statistics/index.vue"),
    beforeEnter: checkAdmin,

  },
  // ADMIN - Sức Khoẻ
  {
    path: "/admin/suc-khoe",
    component: () => import("../components/Admin/Health/index.vue"),
    beforeEnter: checkAdmin,
  },
  // ADMIN - Học phí
  {
    path: "/admin/hoc-phi",
    component: () => import("../components/Admin/Tuition/index.vue"),
    beforeEnter: checkAdmin,
  },
  // ADMIN - Chi tiết loại phí
  {
    path: "/admin/hoc-phi/chi-tiet",
    component: () => import("../components/Admin/Tuition/Detail.vue"),
    beforeEnter: checkAdmin,
  },
  // ADMIN - Thực đơn
  {
    path: "/admin/thong-bao",
    component: () => import("../components/Admin/Notifications/index.vue"),
    beforeEnter: checkAdmin,

  },
  // ADMIN - Bài Viết
  {
    path: "/admin/bai-viet",
    component: () => import("../components/Admin/Articles/index.vue"),
    beforeEnter: checkAdmin,
  },

];

const router = createRouter({
  history: createWebHistory(),
  routes: routes,
  scrollBehavior(to, from, savedPosition) {
    // Nếu có savedPosition (khi người dùng sử dụng nút back/forward), sử dụng vị trí đó
    if (savedPosition) {
      return savedPosition;
    }

    // Nếu chuyển đến cùng một route với hash, cuộn đến element đó
    if (to.hash) {
      return {
        el: to.hash,
        behavior: 'smooth'
      };
    }

    // Luôn cuộn về đầu trang khi chuyển route
    return {
      top: 0,
      behavior: 'smooth',
      // Đảm bảo cuộn đúng container cho Admin layout
      left: 0
    };
  }
});

export default router;
