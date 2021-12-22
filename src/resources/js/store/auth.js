import axios from "axios";
import { CREATED, OK, UNPROCESSABLE_ENTITY } from "../util/status";

const state = {
  user: null,
  apiStatus: null,
  registerErrorMessages: null,
  loginErrorMessages: null
};

const getters = {
  // ログインチェック
  check: state => !!state.user,
  // ログイン中のユーザー名
  username: state => (state.user ? state.user.name : "")
};

const mutations = {
  /**
   * ユーザー設定
   *
   * @param {*} state
   * @param {*} user
   */
  setUser(state, user) {
    state.user = user;
  },
  /**
   * APIステータス設定
   *
   * @param {*} state
   * @param {*} status
   */
  setApiStatus(state, status) {
    state.apiStatus = status;
  },
  /**
   * ユーザー登録エラーメッセージ設定
   *
   * @param {*} state
   * @param {*} messages
   */
  setRegisterErrorMessages(state, messages) {
    state.registerErrorMessages = messages;
  },
  /**
   * ログインエラーメッセージ設定
   *
   * @param {*} state
   * @param {*} messages
   */
  setLoginErrorMessages(state, messages) {
    state.loginErrorMessages = messages;
  }
};

const actions = {
  /**
   * ユーザー登録アクション
   *
   * @param {*} context
   * @param {*} data
   */
  async register(context, data) {
    // データ加工
    const formData = new FormData();
    Object.keys(data).forEach(key => {
      formData.append(key, data[key]);
    });

    // API実行
    context.commit("setApiStatus", null);
    const response = await axios.post("/api/register", formData);
    console.log(response);

    // 成功
    if (response.status === CREATED) {
      context.commit("setApiStatus", true);
      context.commit("setUser", response.data);
      return false;
    }

    // 失敗
    context.commit("setApiStatus", false);
    if (response.status === UNPROCESSABLE_ENTITY) {
      // バリデーションエラー
      context.commit("setRegisterErrorMessages", response.data.errors);
    } else {
      // システムエラー
      context.commit("error/setCode", response.status, { root: true });
    }
  },
  /**
   * ログインアクション
   *
   * @param {*} context
   * @param {*} data
   */
  async login(context, data) {
    // API実行
    context.commit("setApiStatus", null);
    const response = await axios.post("/api/login", data);
    console.log(response);

    // 成功
    if (response.status === OK) {
      context.commit("setApiStatus", true);
      context.commit("setUser", response.data);
      return false;
    }

    // 失敗
    context.commit("setApiStatus", false);
    if (response.status === UNPROCESSABLE_ENTITY) {
      // バリデーションエラー
      context.commit("setLoginErrorMessages", response.data.errors);
    } else {
      // システムエラー
      context.commit("error/setCode", response.status, { root: true });
    }
  },
  /**
   * ログアウトアクション
   *
   * @param {*} context
   */
  async logout(context) {
    // API実行
    context.commit("setApiStatus", null);
    const response = await axios.post("/api/logout");
    console.log(response);

    // 成功
    if (response.status === OK) {
      context.commit("setApiStatus", true);
      context.commit("setUser", null);
      return false;
    }

    // 失敗
    context.commit("setApiStatus", false);
    context.commit("error/setCode", response.status, { root: true });
  },
  /**
   * 現在ログイン中のユーザー取得アクション
   *
   * ブラウザリロード対策
   *
   * @param {*} context
   */
  async currentUser(context) {
    // API実行
    context.commit("setApiStatus", null);
    const response = await axios.get("api/login_user");
    const user = response.data || null;
    console.log(response);

    // 成功
    if (response.status === OK) {
      context.commit("setApiStatus", true);
      context.commit("setUser", user);
      return false;
    }

    // 失敗
    context.commit("setApiStatus", false);
    context.commit("error/setCode", response.status, { root: true });
  }
};

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
};
