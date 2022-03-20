import ExampleComponent from "../../components/ExampleComponent";

const { mount } = require(`@vue/test-utils`);

describe("ExampleComponent", () => {
  test("サンプルテスト", () => {
    const wrapper = mount(ExampleComponent);
    expect(wrapper.find(".card-header").text()).toBe("Example Component");
    expect(wrapper.find(".card-body").text()).toBe("I'm an example component.");
    console.log("テストしましたよ。");
  });
});
