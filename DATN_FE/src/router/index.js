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
    path: "/blog",
    component: () => import("../components/Client/Blog/index.vue"),
    meta: { layout: "client" },
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes: routes,
});

export default router;
