import axios from "axios";
import { OK, UNPROCESSABLE_ENTITY } from "../util/status";

const state = {
  user: null,
  articles: null,
  // currentPage: 0,
  // lastPage: 0,
  apiStatus: null,
  updateErrorMessages: null
};

const getters = {};

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
   * 記事設定
   *
   * @param {*} state
   * @param {*} articles
   */
  setArticles(state, articles) {
    state.articles = articles;
  },
  /**
   * 現在ページ設定
   *
   * @param {*} state
   * @param {*} currentPage
   */
  // setCurrentPage(state, currentPage) {
  //   state.currentPage = currentPage;
  // },
  /**
   * 最後のページ設定
   *
   * @param {*} state
   * @param {*} lastPage
   */
  // setLastPage(state, lastPage) {
  //   state.lastPage = lastPage;
  // },
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
   * 更新エラーメッセージ設定
   *
   * @param {*} state
   * @param {*} messages
   */
  setUpdateErrorMessages(state, messages) {
    state.updateErrorMessages = messages;
  }
};

const actions = {
  /**
   * ユーザーデータ取得アクション
   *
   * @param {*} context
   * @param {*} id
   */
  async getUserData(context, id) {
    // API実行
    context.commit("setApiStatus", null);
    const response = await axios.get(`/api/users/${id}`);
    console.log(response);

    // 成功
    if (response.status === OK) {
      context.commit("setApiStatus", true);
      context.commit("setUser", response.data.user);
      context.commit("setArticles", response.data.articles);
      // context.commit("setArticles", response.data.articles.data);
      // context.commit("setCurrentPage", response.data.articles.current_page);
      // context.commit("setLastPage", response.data.articles.last_page);
      return false;
    }

    // 失敗
    context.commit("setApiStatus", false);
    context.commit("error/setCode", response.status, { root: true });
  },
  /**
   * ユーザー更新アクション
   *
   * @param {*} context
   * @param {*} {id, data}
   */
  async update(context, { id, data }) {
    // データ加工
    const formData = new FormData();
    Object.keys(data).forEach(key => {
      formData.append(key, data[key]);
    });

    // API実行
    context.commit("setApiStatus", null);
    const response = await axios.post(`/api/users/${id}`, formData, {
      headers: {
        "X-HTTP-Method-Override": "PATCH"
      }
    });
    console.log(response);

    // 成功
    if (response.status === OK) {
      context.commit("setApiStatus", true);
      context.commit(
        "message/setContent",
        {
          content: "ユーザーが更新されました",
          timeout: 6000
        },
        { root: true }
      );
      return false;
    }

    // 失敗
    context.commit("setApiStatus", false);
    if (response.status === UNPROCESSABLE_ENTITY) {
      // バリデーションエラー
      context.commit("setUpdateErrorMessages", response.data.errors);
    } else {
      // システムエラー
      context.commit("error/setCode", response.status, { root: true });
    }
  },
  /**
   * ユーザー削除アクション
   *
   * @param {*} context
   * @param {*} id
   */
  async delete(context, id) {
    // API実行
    context.commit("setApiStatus", null);
    const response = await axios.delete(`/api/users/${id}`);
    console.log(response);

    // 成功
    if (response.status === OK) {
      context.commit("setApiStatus", true);
      context.commit(
        "message/setContent",
        {
          content: "ユーザーが退会しました",
          timeout: 6000
        },
        { root: true }
      );
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
