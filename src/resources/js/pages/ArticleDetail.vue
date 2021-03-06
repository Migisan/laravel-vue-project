<template>
  <div v-if="article" class="article_detail">
    <div class="article">
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
      <h2 class="article_title">{{ article.title }}</h2>
      <p class="article_body">{{ article.body }}</p>
      <div class="article_more">
        <div class="article_comments">
          <span class="" @click="formShowFlg = !formShowFlg">
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
          <router-link :to="`/likes/?id=${article.id}`">
            {{ article.likes_count }}いいね
          </router-link>
        </div>
      </div>
    </div>
    <form v-if="formShowFlg" class="comment_form" @submit.prevent="submit">
      <textarea v-model="comment"></textarea>
      <button type="submit">コメント投稿</button>
    </form>
    <ul v-if="comments" class="comment_list">
      <li v-for="comment in comments" :key="comment.id" class="comment">
        <div class="comment_icon">
          <router-link :to="`/user/?id=${comment.user.id}`">
            <img
              :src="comment.user.image_path"
              :alt="comment.user.name + 'のプロフィール画像'"
            />
          </router-link>
        </div>
        <div class="comment_text">
          <div class="comment_header">
            <div class="comment_username">{{ comment.user.name }}</div>
            <div class="comment_updated_at">{{ comment.updated_at }}</div>
          </div>
          <p class="comment_body">{{ comment.comment }}</p>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    id: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      modalShowFlg: false,
      formShowFlg: false,
      comment: ""
    };
  },
  computed: {
    /**
     * 記事
     */
    article() {
      return this.$store.state.article.article;
    },
    /**
     * コメント
     */
    comments() {
      return this.$store.state.comment.comments;
    },
    /**
     * APIステータスチェック
     */
    apiStatus() {
      return this.$store.state.comment.apiStatus;
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
     * コメント投稿エラーチェック
     */
    storeErrors() {
      return this.$store.state.comment.storeErrorMessages;
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
     * コメントフォームを開く
     */
    openForm() {
      // フォームを開く
      this.formShowFlg = true;
    },
    /**
     * コメントフォームを閉じる
     */
    closeForm() {
      // フォームをクリア
      this.comment = "";
      // フォームを閉じる
      this.formShowFlg = false;
    },
    /**
     * コメント投稿
     */
    async submit() {
      console.log(this.comment);

      // 登録
      await this.$store.dispatch("comment/store", {
        article_id: this.id,
        comment: this.comment
      });

      if (this.apiStatus || this.errorCode !== null) {
        this.closeForm();
      }
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
  },
  watch: {
    $route: {
      async handler() {
        await this.$store.dispatch("article/getArticleData", this.id);
        await this.$store.dispatch("comment/getCommentList", this.id);
      },
      immediate: true
    }
  }
};
</script>
