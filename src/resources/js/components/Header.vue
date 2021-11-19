<template>
  <header class="header">
    <div class="container">
      <h1 class="title">
        <router-link to="/">
          アプリ名
        </router-link>
      </h1>
      <nav class="navbar">
        <ul>
          <li v-if="isLogin">
            <button @click="logout">Logout</button>
          </li>
          <li v-else>
            <router-link to="/login">Login / Register</router-link>
          </li>
          <li v-if="isLogin">
            <span>{{ username }}</span>
          </li>
        </ul>
      </nav>
    </div>
  </header>
</template>

<script>
export default {
  methods: {
    /**
     * ログアウト処理
     */
    async logout() {
      await this.$store.dispatch("auth/logout");
      if (this.apiStatus) {
        this.$router.push("/login");
      }
    }
  },
  computed: {
    /**
     * ログインチェック
     */
    isLogin() {
      return this.$store.getters["auth/check"];
    },
    /**
     * ログイン中のユーザー名
     */
    username() {
      return this.$store.getters["auth/username"];
    },
    /**
     * APIステータスチェック
     */
    apiStatus() {
      return this.$store.state.auth.apiStatus;
    }
  }
};
</script>
