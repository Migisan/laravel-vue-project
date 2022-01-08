<template>
  <li class="article">
    <div class="article_header">
      <div class="article_icon">
        <router-link :to="`/user/?id=${article.user.id}`">
          <img
            :src="article.user.image_path"
            :alt="article.user.name + 'のプロフィール画像'"
          />
        </router-link>
      </div>
      <div class="article_info">
        <div class="article_username">{{ article.user.name }}</div>
        <div class="article_created_at">{{ article.created_at }}</div>
      </div>
      <div v-show="dotShowFlg" class="article_dot" @click="toggleModal">
        <i class="fas fa-ellipsis-v"></i>
      </div>
      <ul v-show="modalShowFlg" class="article_modal">
        <li @click="showArticleForm">編集</li>
        <li @click="deleteArticle">削除</li>
      </ul>
    </div>
    <h2>{{ article.title }}</h2>
    <p>{{ article.body }}</p>
  </li>
</template>

<script>
export default {
  props: {
    article: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      dotShowFlg: false,
      modalShowFlg: false
    };
  },
  computed: {
    /**
     * APIステータスチェック
     */
    apiStatus() {
      return this.$store.state.article.apiStatus;
    },
    /**
     * ログインユーザー
     */
    auth() {
      return this.$store.state.auth.user;
    },
    /**
     * 現在のページ
     */
    currentPage() {
      return this.$store.state.article.currentPage;
    }
  },
  created() {
    if (this.auth) {
      this.dotShowFlg = this.auth.id === this.article.user.id;
    }
  },
  methods: {
    /**
     * モーダルの表示切り替え
     */
    toggleModal() {
      this.modalShowFlg = !this.modalShowFlg;
    },
    /**
     * 記事編集モーダルの表示
     */
    showArticleForm() {
      this.toggleModal();
      this.$emit("eventArticleForm", this.article);
    },
    /**
     * 記事の削除
     */
    deleteArticle() {
      this.toggleModal();
      this.$emit("eventArticleDelete", this.article.id);
    }
  }
};
</script>
