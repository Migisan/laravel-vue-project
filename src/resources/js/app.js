import Vue from "vue";
import router from "./router";
import store from "./store";
import "./bootstrap";

import App from "./App.vue";

const createApp = async () => {
  // アプリケーション起動時、ログイン中のユーザーを確認
  await store.dispatch("auth/currentUser");

  new Vue({
    el: "#app",
    router,
    store,
    components: { App },
    template: "<App />"
  });
};

createApp();
