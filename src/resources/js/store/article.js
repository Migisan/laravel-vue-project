import axios from "axios";
import { CREATED, OK, UNPROCESSABLE_ENTITY } from "../util/status";

const state = {
  articles: null,
  currentPage: 0,
  lastPage: 0,
  article: null,
  apiStatus: null,
  storeErrorMessages: null
};

const getters = {};

const mutations = {
  /**
   * 記事一覧設定
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
   * 記事設定
   *
   * @param {*} state
   * @param {*} article
   */
  setArticle(state, article) {
    state.article = article;
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
   * 記事一覧取得アクション
   *
   * @param {*} context
   * @param {*} page
   */
  async getArticleList(context, page) {
    // API実行
    context.commit("setApiStatus", null);
    const response = await axios.get(`/api/articles/?page=${page}`);
    console.log(response);

    // 成功
    if (response.status === OK) {
      context.commit("setApiStatus", true);
      context.commit("setArticles", response.data.data);
      context.commit("setCurrentPage", response.data.meta.current_page);
      context.commit("setLastPage", response.data.meta.last_page);
      return false;
    }

    // 失敗
    context.commit("setApiStatus", false);
    context.commit("error/setCode", response.status, { root: true });
  },
  /**
   * 記事データ取得アクション
   *
   * @param {*} context
   * @param {*} id
   */
  async getArticleData(context, id) {
    // API実行
    context.commit("setApiStatus", null);
    const response = await axios.get(`/api/articles/${id}`);
    console.log(response);

    // 成功
    if (response.status === OK) {
      context.commit("setApiStatus", true);
      context.commit("setArticle", response.data);
      return false;
    }

    // 失敗
    context.commit("setApiStatus", false);
    context.commit("error/setCode", response.status, { root: true });
  },
  /**
   * 記事投稿アクション
   *
   * @param {*} context
   * @param {*} data
   */
  async store(context, data) {
    // API実行
    context.commit("setApiStatus", null);
    const response = await axios.post("/api/articles", data);
    console.log(response);

    // 成功
    if (response.status === CREATED) {
      context.commit("setApiStatus", true);
      await context.dispatch("getArticleList", context.state.currentPage);
      context.commit(
        "message/setContent",
        {
          content: "記事が投稿されました",
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
  },
  /**
   * 記事更新アクション
   *
   * @param {*} context
   * @param {*} {id, data}
   */
  async update(context, { id, data }) {
    // API実行
    context.commit("setApiStatus", null);
    const response = await axios.patch(`/api/articles/${id}`, data);
    console.log(response);

    // 成功
    if (response.status === OK) {
      context.commit("setApiStatus", true);
      await context.dispatch("getArticleList", context.state.currentPage);
      context.commit(
        "message/setContent",
        {
          content: "記事が更新されました",
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
  },
  /**
   * 記事削除アクション
   *
   * @param {*} context
   * @param {*} id
   */
  async delete(context, id) {
    // API実行
    context.commit("setApiStatus", null);
    const response = await axios.delete(`/api/articles/${id}`);
    console.log(response);

    // 成功
    if (response.status === OK) {
      context.commit("setApiStatus", true);
      return false;
    }

    // 失敗
    context.commit("setApiStatus", false);
    context.commit("error/setCode", response.status, { root: true });
  },
  /**
   * いいねつけるアクション
   *
   * @param {*} context
   * @param {*} id
   */
  async addLike(context, id) {
    // API実行
    context.commit("setApiStatus", null);
    const response = await axios.post(`/api/articles/${id}/add_like`);
    console.log(response);

    // 成功
    if (response.status === OK) {
      context.commit("setApiStatus", true);

      // 記事
      if (
        context.state.article &&
        context.state.article.id === response.data.id
      ) {
        context.commit("setArticle", response.data);
      }

      // 記事一覧
      const articles = Array.from(context.state.articles);
      const changeArticleIndex = articles.findIndex(article => {
        return article.id === response.data.id;
      });
      if (changeArticleIndex > -1) {
        articles.splice(changeArticleIndex, 1, response.data);
        context.commit("setArticles", articles);
      }

      return false;
    }

    // 失敗
    context.commit("setApiStatus", false);
    context.commit("error/setCode", response.status, { root: true });
  },
  /**
   * いいね外すアクション
   *
   * @param {*} context
   * @param {*} id
   */
  async deleteLike(context, id) {
    // API実行
    context.commit("setApiStatus", null);
    const response = await axios.post(`/api/articles/${id}/delete_like`);
    console.log(response);

    // 成功
    if (response.status === OK) {
      context.commit("setApiStatus", true);

      // 記事
      if (
        context.state.article &&
        context.state.article.id === response.data.id
      ) {
        context.commit("setArticle", response.data);
      }

      // 記事一覧
      const articles = Array.from(context.state.articles);
      const changeArticleIndex = articles.findIndex(article => {
        return article.id === response.data.id;
      });
      if (changeArticleIndex > -1) {
        articles.splice(changeArticleIndex, 1, response.data);
        context.commit("setArticles", articles);
      }

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
