import axios from "axios";

const state = {
  user: null
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
    const response = await axios.post("/api/register", data);
    console.log(response);
    context.commit("setUser", response.data);
  },
  /**
   * ログインアクション
   *
   * @param {*} context
   * @param {*} data
   */
  async login(context, data) {
    const response = await axios.post("/api/login", data);
    console.log(response);
    context.commit("setUser", response.data);
  },
  /**
   * ログアウトアクション
   *
   * @param {*} context
   */
  async logout(context) {
    const response = await axios.post("/api/logout");
    console.log(response);
    context.commit("setUser", null);
  },
  /**
   * 現在ログイン中のユーザー取得アクション
   *
   * ブラウザリロード対策
   *
   * @param {*} context
   */
  async currentUser(context) {
    const response = await axios.get("api/login_user");
    console.log(response);
    const user = response.data || null;
    context.commit("setUser", user);
  }
};

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
};
