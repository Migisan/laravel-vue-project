import Vuex from "vuex";
import auth from "../../store/auth";
import { createLocalVue } from "@vue/test-utils";

const localVue = createLocalVue();
localVue.use(Vuex);

let action;
const testedAction = (context = {}, payload = {}) => {
  return auth.actions[action](context, payload);
};

describe("store/auth.js", () => {
  let store;
  beforeEach(() => {
    store = new Vuex.Store(auth);
  });
  describe("getters", () => {
    const userTestData = {
      id: 1,
      name: "ユーザー名",
      email: "test@example.com",
      image_path: "/user/image.png",
      updated: "2022-01-01 00:00:00"
    };

    test("checkLoginの初期値", () => {
      expect(store.getters["checkLogin"]).toBe(false);
    });
    test("checkLoginの取得", () => {
      store.replaceState({
        user: userTestData
      });
      expect(store.getters["checkLogin"]).toBe(true);
    });
    test("useridの初期値", () => {
      expect(store.getters["userid"]).toBe(0);
    });
    test("useridの取得", () => {
      store.replaceState({
        user: userTestData
      });
      expect(store.getters["userid"]).toBe(1);
    });
    test("usernameの初期値", () => {
      expect(store.getters["username"]).toBe("");
    });
    test("usernameの取得", () => {
      store.replaceState({
        user: userTestData
      });
      expect(store.getters["username"]).toBe("ユーザー名");
    });
  });
});
