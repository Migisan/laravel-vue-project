const state = {
  content: ""
};

const mutations = {
  /**
   * メッセージ設定
   *
   * @param {*} state
   * @param {*} {content, timeout}
   */
  setContent(state, { content, timeout }) {
    state.content = content;

    if (typeof timeout === "undefined") {
      timeout = 3000;
    }

    setTimeout(() => (state.content = ""), timeout);
  }
};

export default {
  namespaced: true,
  state,
  mutations
};
