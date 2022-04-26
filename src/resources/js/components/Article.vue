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
        <div class="article_updated_at">{{ article.updated_at }}</div>
      </div>
      <div v-show="dotShowFlg" class="article_dot" @click="toggleModal">
        <i class="fas fa-ellipsis-v"></i>
      </div>
      <ul v-show="modalShowFlg" class="article_modal">
        <li @click="showArticleForm">編集</li>
        <li @click="deleteArticle">削除</li>
      </ul>
    </div>
    <h2 class="article_title">
      <router-link :to="`/article/?id=${article.id}`">
        {{ article.title }}
      </router-link>
    </h2>
    <p class="article_body">{{ article.body }}</p>
    <div class="article_detail">
      <div class="article_comments">
        <span class="">
          <i class="far fa-comment"></i>
        </span>
        {{ article.comments_count }}コメント
      </div>
      <div class="article_likes">
        <span v-if="isLike" class="heart" @click="deleteLike" key="like">
          <i class="fas fa-heart like"></i>
        </span>
        <span v-else class="heart" @click="addLike" key="not-like">
          <i class="far fa-heart not-like"></i>
        </span>
        {{ article.likes_count }}いいね
      </div>
    </div>
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
     * ログイン中のユーザID
     */
    authid() {
      return this.$store.getters["auth/userid"];
    },
    /**
     * モーダル表示ボタンフラグ
     */
    dotShowFlg() {
      return this.authid === this.article.user.id;
    },
    /**
     * いいね切り替え
     */
    isLike() {
      return this.article.like_user_ids.includes(this.authid);
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
    },
    /**
     * いいねをつける
     */
    async addLike() {
      await this.$store.dispatch("article/addLike", this.article.id);
    },
    /**
     * いいねを外す
     */
    async deleteLike() {
      await this.$store.dispatch("article/deleteLike", this.article.id);
    }
  }
};
</script>
