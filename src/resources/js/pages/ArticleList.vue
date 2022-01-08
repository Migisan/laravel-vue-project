<template>
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
    <Pagination :current-page="currentPage" :last-page="lastPage" />
  </div>
</template>

<script>
import ArticleForm from "../components/ArticleForm.vue";
import Article from "../components/Article.vue";
import Pagination from "../components/Pagination.vue";

export default {
  props: {
    page: {
      type: Number,
      required: false,
      default: 1
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
     * 記事一覧
     */
    articles() {
      return this.$store.state.article.articles;
    },
    /**
     * 現在のページ
     */
    currentPage() {
      return this.$store.state.article.currentPage;
    },
    /**
     * 最後のページ
     */
    lastPage() {
      return this.$store.state.article.lastPage;
    },
    /**
     * APIステータスチェック
     */
    apiStatus() {
      return this.$store.state.article.apiStatus;
    }
  },
  methods: {
    /**
     * 記事更新フォームの表示
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
          if (this.currentPage === 1) {
            // 1ページ目
            this.$router.go({
              path: "/",
              force: true
            });
          } else {
            // 2ページ目以降
            this.$router.push("/", e => {
              console.log(e);
            });
          }
        }
      }
    }
  },
  watch: {
    $route: {
      async handler() {
        await this.$store.dispatch("article/getArticleList", this.page);
      },
      immediate: true
    }
  }
};
</script>
