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
          <template v-if="isLogin">
            <li>
              <router-link :to="`/user/?id=${userid}`">
                <span>{{ username }}</span>
              </router-link>
            </li>
            <li>
              <button @click="showArticleForm = !showArticleForm">
                投稿する
              </button>
            </li>
            <li>
              <button @click="logout">Logout</button>
            </li>
          </template>
          <template v-else>
            <li>
              <router-link to="/login">Login / Register</router-link>
            </li>
          </template>
        </ul>
      </nav>
    </div>
    <ArticleForm key="store" v-if="showArticleForm" v-model="showArticleForm" />
  </header>
</template>

<script>
import ArticleForm from "./ArticleForm.vue";

export default {
  components: {
    ArticleForm
  },
  data() {
    return {
      showArticleForm: false
    };
  },
  computed: {
    /**
     * ログインチェック
     */
    isLogin() {
      return this.$store.getters["auth/check"];
    },
    /**
     * ログイン中のユーザID
     */
    userid() {
      return this.$store.getters["auth/userid"];
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
  },
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
  }
};
</script>
