import Vue from "vue";
import Vuex from "vuex";

import auth from "./auth";
import error from "./error";
import message from "./message";
import article from "./article";
import user from "./user";
import like from "./like";

Vue.use(Vuex);

const store = new Vuex.Store({
  modules: {
    auth,
    error,
    message,
    article,
    user,
    like
  }
});

export default store;
