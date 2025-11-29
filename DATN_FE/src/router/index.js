import { createRouter, createWebHistory } from "vue-router"; // cài vue-router: npm install vue-router@next --save

const routes = [
  // {
  //     path : '/',
  //     component: ()=>import('../layout/wrapper/index.vue')
  // },
  {
    path: "/",
    component: () => import("../components/Client/HomePage/index.vue"),
    meta: { layout: "client" },
  },
  {
    path: "/login",
    component: () => import("../components/Client/Auth/Login/index.vue"),
    meta: { layout: "auth" },
  },
  {
    path: "/blog",
    component: () => import("../components/Client/Blog/index.vue"),
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
    path: "/meal",
    component: () => import("../components/Client/Meal/index.vue"),
    meta: { layout: "client" },
  },
  {
    path: "/instructPayment",
    component: () => import("../components/Client/InstructPayment/index.vue"),
    meta: { layout: "client" },
  },
  {
    path: "/tuition",
    component: () => import("../components/Client/Tuition/index.vue"),
    meta: { layout: "client" },
  },
  {
    path: "/registration",
    component: () => import("../components/Client/Registration/index.vue"),
    meta: { layout: "client" },
  },
  {
    path: "/activities",
    component: () => import("../components/Client/Activities/index.vue"),
    meta: { layout: "client" },
  },
  {
    path: "/advantages",
    component: () => import("../components/Client/Advantage/index.vue"),
    meta: { layout: "client" },
  },
  {
    path: "/parent-mail-box",
    component: () => import("../components/Client/ParentMailbox/index.vue"),
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
    path: "/study-schedule",
    component: () => import("../components/Client/StudySchedule/index.vue"),
    meta: { layout: "client" },
  },
  {
    path: "/re-password",
    component: () => import("../components/Client/Auth/RePassWord/index.vue"),
    meta: { layout: "auth" },
  },
  {
    path: "/new-password",
    component: () => import("../components/Client/Auth/NewPassWord/index.vue"),
    meta: { layout: "auth" },
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes: routes,
});

export default router;
