import ExampleComponent from "../../components/ExampleComponent";

const { mount } = require(`@vue/test-utils`);

describe("サンプルコンポーネントのテスト", () => {
  test("サンプルテスト", () => {
    const component = mount(ExampleComponent);
    console.log("テストしましたよ。");
    expect(component.isVueInstance()).toBeTruthy();
  });
});
