import { getCookieValue } from "./util/cookie";

window.axios = require("axios");

// Ajaxリクエストであることを示すヘッダーを付与
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

window.axios.interceptors.request.use(config => {
  // クッキーからCSRFトークンを取得して、ヘッダーに添付
  config.headers["X-XSRF-TOKEN"] = getCookieValue("XSRF-TOKEN");

  return config;
});

// レスポンス後の処理を上書き
window.axios.interceptors.response.use(
  // 成功時
  response => response,
  // 失敗時
  error => error.response || error
);
