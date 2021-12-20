import Vue from "vue";
import VueRouter from "vue-router";

import ArticleList from "./pages/ArticleList.vue";
import Login from "./pages/Login.vue";
import SystemError from "./pages/errors/SystemError.vue";
import NotFound from "./pages/errors/NotFound.vue";

import store from "./store";

Vue.use(VueRouter);

const routes = [
  {
    path: "/",
    component: ArticleList,
    props: route => {
      const page = route.query.page;
      return { page: /^[1-9][0-9]*$/.test(page) ? page * 1 : 1 };
    }
  },
  {
    path: "/login",
    component: Login,
    beforeEnter(to, from, next) {
      if (store.getters["auth/check"]) {
        next("/");
      } else {
        next();
      }
    }
  },
  {
    path: "/500",
    component: SystemError
  },
  {
    path: "*",
    component: NotFound
  }
];

const router = new VueRouter({
  mode: "history",
  scrollBehavior() {
    return { x: 0, y: 0 };
  },
  routes
});

export default router;
