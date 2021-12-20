<template>
  <div>
    <Header />
    <main class="main">
      <div class="container">
        <Message />
        <RouterView />
      </div>
    </main>
    <Footer />
  </div>
</template>

<script>
import Header from "./components/Header.vue";
import Footer from "./components/Footer.vue";
import Message from "./components/Message.vue";

import { NOT_FOUND, UNAUTHORIZED, INTERNAL_SERVER_ERROR } from "./util/status";

export default {
  components: {
    Header,
    Footer,
    Message
  },
  computed: {
    errorCode() {
      return this.$store.state.error.code;
    }
  },
  watch: {
    errorCode: {
      async handler(val) {
        if (val === INTERNAL_SERVER_ERROR) {
          this.$router.push("/500");
        } else if (val === UNAUTHORIZED) {
          // トークンリフレッシュ
          await axios.get("/api/refresh_token");
          // ユーザーをクリア
          this.$store.commit("auth/setUser", null);
          // ログイン画面へリダイレクト
          this.$router.push("/login");
        } else if (val === NOT_FOUND) {
          this.$router.push("/not_found");
        }
      },
      immediate: true
    },
    $route() {
      this.$store.commit("error/setCode", null);
    }
  }
};
</script>
