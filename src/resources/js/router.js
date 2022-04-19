import Vue from "vue";
import VueRouter from "vue-router";

import ArticleList from "./pages/ArticleList.vue";
import ArticleDetail from "./pages/ArticleDetail.vue";
import LikeList from "./pages/LikeList.vue";
import Login from "./pages/Login.vue";
import UserDetail from "./pages/UserDetail.vue";
import UserUpdate from "./pages/UserUpdate.vue";
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
    path: "/article",
    component: ArticleDetail,
    props: route => {
      const id = route.query.id;
      return { id: /^[1-9][0-9]*$/.test(id) ? id * 1 : 1 };
    }
  },
  {
    path: "/likes",
    component: LikeList,
    props: route => {
      const id = route.query.id;
      return { id: /^[1-9][0-9]*$/.test(id) ? id * 1 : 1 };
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
    path: "/user",
    component: UserDetail,
    props: route => {
      const id = route.query.id;
      return { id: /^[1-9][0-9]*$/.test(id) ? id * 1 : 1 };
    }
  },
  {
    path: "/user/update",
    component: UserUpdate,
    props: route => {
      const id = route.query.id;
      return { id: /^[1-9][0-9]*$/.test(id) ? id * 1 : 1 };
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
