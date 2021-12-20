<template>
  <div v-show="value" class="article_form" @click="closeForm">
    <form class="form" @submit.prevent="submit" @click.stop>
      <div class="form-row">
        <label for="title">タイトル</label>
        <input type="text" id="title" v-model="form.title" />
        <div v-if="storeErrors" class="errors">
          <ul v-if="storeErrors.title">
            <li v-for="msg in storeErrors.title" :key="msg">
              {{ msg }}
            </li>
          </ul>
        </div>
      </div>
      <div class="form-row">
        <label for="body">本文</label>
        <textarea id="body" v-model="form.body" />
        <div v-if="storeErrors" class="errors">
          <ul v-if="storeErrors.body">
            <li v-for="msg in storeErrors.body" :key="msg">
              {{ msg }}
            </li>
          </ul>
        </div>
      </div>
      <button type="submit">{{ editArticle ? "更新" : "投稿" }}</button>
    </form>
  </div>
</template>

<script>
export default {
  props: {
    value: {
      type: Boolean,
      required: true
    },
    editArticle: {
      type: Object,
      required: false
    }
  },
  data() {
    return {
      // 投稿
      form: {
        title: "",
        body: ""
      }
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
     * エラーコードチェック
     */
    errorCode() {
      return this.$store.state.error.code;
    },
    /**
     * 投稿エラーチェック
     */
    storeErrors() {
      return this.$store.state.article.storeErrorMessages;
    }
  },
  created() {
    this.clearError();
    if (!this.editArticle) return;
    this.form.title = this.editArticle.title;
    this.form.body = this.editArticle.body;
  },
  methods: {
    /**
     * エラー初期化
     */
    clearError() {
      this.$store.commit("article/setStoreErrorMessages", null);
    },
    /**
     * フォームを閉じる処理
     */
    closeForm() {
      // フォームをクリア
      this.form = {
        title: "",
        body: ""
      };
      // フォームを閉じる
      this.$emit("input", false);
    },
    /**
     * 投稿処理
     */
    async submit() {
      console.log(this.form);

      if (this.editArticle) {
        // 更新
        await this.$store.dispatch("article/update", {
          id: this.editArticle.id,
          data: this.form
        });
      } else {
        // 登録
        await this.$store.dispatch("article/store", this.form);
      }

      if (this.apiStatus || this.errorCode !== null) {
        this.closeForm();
      }
    }
  }
};
</script>
