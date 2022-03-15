<template>
  <div v-if="user" class="user_detail">
    <div class="user_detail_header">
      <div class="user_icon">
        <img :src="user.image_path" :alt="user.name + 'のプロフィール画像'" />
      </div>
      <div class="user_info">
        <div class="user_name">{{ user.name }}</div>
      </div>
      <div v-if="user.id === authid" class="user_button">
        <button>
          <router-link :to="`/user/update/?id=${user.id}`">
            プロフィール更新
          </router-link>
        </button>
      </div>
    </div>
    <div class="article_list">
      <ArticleForm
        key="update"
        v-if="formShowFlg"
        v-model="formShowFlg"
        :editArticle="editArticle"
      />
      <div v-if="articles">
        <div v-if="articles.length === 0" class="article_nothing">
          投稿がありません。
        </div>
        <ul v-else>
          <Article
            v-for="article in articles"
            :key="article.id"
            :article="article"
            @eventArticleForm="showArticleForm"
            @eventArticleDelete="deleteArticle"
          />
        </ul>
      </div>
      <!-- <Pagination :current-page="currentPage" :last-page="lastPage" /> -->
    </div>
  </div>
</template>

<script>
import ArticleForm from "../components/ArticleForm.vue";
import Article from "../components/Article.vue";
import Pagination from "../components/Pagination.vue";

export default {
  props: {
    id: {
      type: Number,
      required: true
    }
  },
  components: {
    ArticleForm,
    Article,
    Pagination
  },
  data() {
    return {
      formShowFlg: false,
      editArticle: null
    };
  },
  computed: {
    /**
     * ログイン中のユーザID
     */
    authid() {
      return this.$store.getters["auth/userid"];
    },
    /**
     * ユーザー
     */
    user() {
      return this.$store.state.user.user;
    },
    /**
     * 記事一覧
     */
    articles() {
      return this.$store.state.user.articles;
    },
    /**
     * 現在のページ
     */
    // currentPage() {
    //   return this.$store.state.article.currentPage;
    // },
    /**
     * 最後のページ
     */
    // lastPage() {
    //   return this.$store.state.article.lastPage;
    // },
    /**
     * APIステータスチェック
     */
    apiStatus() {
      return this.$store.state.user.apiStatus;
    }
  },
  methods: {
    /**
     * 記事編集モーダルの表示
     */
    showArticleForm(editArticle) {
      this.editArticle = editArticle;
      this.formShowFlg = !this.formShowFlg;
    },
    /**
     * 記事の削除
     */
    async deleteArticle(ArticleId) {
      if (confirm("本当に削除しますか？")) {
        await this.$store.dispatch("article/delete", ArticleId);
        // リダイレクト
        if (this.apiStatus) {
          this.$router.go({
            path: `/user/?id=${this.user.id}`,
            force: true
          });
        }
      }
    }
  },
  watch: {
    $route: {
      async handler() {
        await this.$store.dispatch("user/getUserData", this.id);
      },
      immediate: true
    }
  }
};
</script>
