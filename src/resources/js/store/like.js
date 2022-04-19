import axios from "axios";
import { CREATED, OK, UNPROCESSABLE_ENTITY } from "../util/status";

const state = {
  likes: null,
  // currentPage: 0,
  // lastPage: 0,
  apiStatus: null
  // storeErrorMessages: null
};

const getters = {};

const mutations = {
  /**
   * いいね一覧設定
   *
   * @param {*} state
   * @param {*} likes
   */
  setLikes(state, likes) {
    state.likes = likes;
  },
  /**
   * 現在ページ設定
   *
   * @param {*} state
   * @param {*} currentPage
   */
  setCurrentPage(state, currentPage) {
    state.currentPage = currentPage;
  },
  /**
   * 最後のページ設定
   *
   * @param {*} state
   * @param {*} lastPage
   */
  setLastPage(state, lastPage) {
    state.lastPage = lastPage;
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
   * 記事投稿エラーメッセージ設定
   *
   * @param {*} state
   * @param {*} messages
   */
  setStoreErrorMessages(state, messages) {
    state.storeErrorMessages = messages;
  }
};

const actions = {
  /**
   * いいね一覧取得アクション
   *
   * @param {*} context
   * @param {*} id
   */
  async getLikeList(context, id) {
    // API実行
    context.commit("setApiStatus", null);
    const response = await axios.get(`/api/likes`, {
      params: { article_id: id }
    });
    console.log(response);

    // 成功
    if (response.status === OK) {
      context.commit("setApiStatus", true);
      context.commit("setLikes", response.data);
      // context.commit("setCurrentPage", response.data.meta.current_page);
      // context.commit("setLastPage", response.data.meta.last_page);
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
