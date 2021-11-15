import { getCookieValue } from "./util/cookie";

window.axios = require("axios");

// Ajaxリクエストであることを示すヘッダーを付与
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

window.axios.interceptors.request.use(config => {
  // クッキーからCSRFトークンを取得して、ヘッダーに添付
  config.headers["X-XSRF-TOKEN"] = getCookieValue("XSRF-TOKEN");

  return config;
});
