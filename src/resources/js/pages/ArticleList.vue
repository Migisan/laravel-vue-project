<template>
  <div class="article_list">
    <ArticleForm
      key="update"
      v-if="formShowFlg"
      v-model="formShowFlg"
      :editArticle="editArticle"
    />
    <ul>
      <Article
        v-for="article in articles"
        :key="article.id"
        :article="article"
        @eventArticleForm="showArticleForm"
      />
    </ul>
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
    showArticleForm(editArticle) {
      this.editArticle = editArticle;
      this.formShowFlg = !this.formShowFlg;
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
