import Vue from "vue";
import router from "./router";
import store from "./store";
import vuetify from "./vuetify";
import "./bootstrap";
import "./fontawesome";

import App from "./App.vue";

const createApp = async () => {
  // アプリケーション起動時、ログイン中のユーザーを確認
  await store.dispatch("auth/currentUser");

  new Vue({
    el: "#app",
    router,
    store,
    // vuetify,
    components: { App },
    template: "<App />"
  });
};

createApp();
