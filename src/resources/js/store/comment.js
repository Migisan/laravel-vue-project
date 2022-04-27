import axios from "axios";
import { CREATED, OK, UNPROCESSABLE_ENTITY } from "../util/status";

const state = {
  comments: null,
  apiStatus: null,
  storeErrorMessages: null
};

const getters = {};

const mutations = {
  /**
   * コメント一覧設定
   *
   * @param {*} state
   * @param {*} comments
   */
  setComments(state, comments) {
    state.comments = comments;
  },
  /**
   * APIステータス設定
   *
   * @param {*} state
   * @param {*} status
   */
  setApiStatus(state, status) {
    state.apiStatus = status;
  }
};

const actions = {
  /**
   * コメント投稿アクション
   *
   * @param {*} context
   * @param {*} data
   */
  async store(context, data) {
    // API実行
    context.commit("setApiStatus", null);
    const response = await axios.post("/api/comments", data);
    console.log(response);

    // 成功
    if (response.status === CREATED) {
      context.commit("setApiStatus", true);
      await context.dispatch("article/getArticleData", data.article_id, {
        root: true
      });
      // コメント一覧データ取得し直し
      // await context.dispatch("getCommentList", data.article_id);
      context.commit(
        "message/setContent",
        {
          content: "コメントが投稿されました",
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
      context.commit("setStoreErrorMessages", response.data.errors);
    } else {
      // システムエラー
      context.commit("error/setCode", response.status, { root: true });
    }
  }
};

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
};
