const state = {
  code: null
};

const mutations = {
  /**
   * ステータスコード設定
   *
   * @param {*} state
   * @param {*} code
   */
  setCode(state, code) {
    state.code = code;
  }
};

export default {
  namespaced: true,
  state,
  mutations
};
