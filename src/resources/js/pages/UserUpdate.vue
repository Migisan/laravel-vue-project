<template>
  <div v-if="user" class="user_update">
    <form class="form" @submit.prevent="submit">
      <div class="form-row">
        <!-- <label for="image">プロフィール画像</label> -->
        <input
          type="file"
          id="image"
          class="input-hidden"
          @change="uploadImage"
        />
        <div
          class="upload"
          @click="clickUploadImage"
          @dragenter.prevent="dragEnter"
          @dragleave.prevent="dragLeave"
          @dragover.prevent
          @drop.prevent="dropUploadImage"
        >
          <div
            v-show="form.image"
            id="previewArea"
            :class="{ enter: isEnter }"
          ></div>
          <div v-show="!form.image" :class="{ enter: isEnter }">
            <img
              :src="user.image_path"
              :alt="user.name + 'のプロフィール画像'"
            />
          </div>
        </div>
        <div v-if="updateErrors" class="errors">
          <ul v-if="updateErrors.image">
            <li v-for="msg in updateErrors.image" :key="msg">
              {{ msg }}
            </li>
          </ul>
        </div>
      </div>
      <div class="form-row">
        <label for="name">名前</label>
        <input type="text" id="name" v-model="form.name" />
        <div v-if="updateErrors" class="errors">
          <ul v-if="updateErrors.name">
            <li v-for="msg in updateErrors.name" :key="msg">
              {{ msg }}
            </li>
          </ul>
        </div>
      </div>
      <div class="form-row">
        <label for="email">メールアドレス</label>
        <input type="text" id="email" v-model="form.email" />
        <div v-if="updateErrors" class="errors">
          <ul v-if="updateErrors.email">
            <li v-for="msg in updateErrors.email" :key="msg">
              {{ msg }}
            </li>
          </ul>
        </div>
      </div>
      <button type="submit">更新</button>
    </form>
    <button class="button-delete" @click="deleteUser">退会する</button>
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
  components: {},
  data() {
    return {
      // ドラッグ&ドロップエリア,
      isEnter: false,
      // フォーム
      form: {
        name: "",
        email: "",
        image: null
      }
    };
  },
  computed: {
    /**
     * ユーザー
     */
    user() {
      return this.$store.state.user.user;
    },
    /**
     * APIステータスチェック
     */
    apiStatus() {
      return this.$store.state.user.apiStatus;
    },
    /**
     * 更新エラーチェック
     */
    updateErrors() {
      return this.$store.state.user.updateErrorMessages;
    }
  },
  created() {
    if (!this.user) return;
    this.form.name = this.user.name;
    this.form.email = this.user.email;
  },
  methods: {
    /**
     * プロフィール画像のアップロード
     */
    uploadImage(event) {
      const file = event.target.files[0];
      this.form.image = file;
      this.previewImage(file);
    },
    /**
     * アップロードボタンのクリック
     */
    clickUploadImage(event) {
      document.getElementById("image").click();
    },
    /**
     * ドラッグエンター(枠内入った)
     */
    dragEnter() {
      this.isEnter = true;
    },
    /**
     * ドラッグリーブ(枠内出た)
     */
    dragLeave() {
      this.isEnter = false;
    },
    /**
     * アップロードファイルのドロップ
     */
    dropUploadImage(event) {
      this.isEnter = false;
      const file = event.dataTransfer.files[0];
      this.form.image = file;
      this.previewImage(file);
    },
    /**
     * 画像のサムネイル表示
     */
    previewImage(file) {
      if (!file) return;

      const reader = new FileReader();
      const previewArea = document.getElementById("previewArea");
      const previewImg = document.getElementById("previewImg");

      if (previewImg) {
        previewArea.removeChild(previewImg);
      }

      reader.readAsDataURL(file);

      reader.onload = () => {
        const img = document.createElement("img");
        img.setAttribute("src", String(reader.result));
        img.setAttribute("id", "previewImg");
        previewArea.appendChild(img);
      };
    },
    /**
     * ユーザー更新処理
     */
    async submit() {
      console.log(this.form);
      await this.$store.dispatch("user/update", {
        id: this.user.id,
        data: this.form
      });
      if (this.apiStatus) {
        this.$router.push(`/user/?id=${this.user.id}`);
      }
    },
    /**
     * ユーザーの削除
     */
    async deleteUser() {
      if (confirm("本当に退会しますか？")) {
        await this.$store.dispatch("user/delete", this.user.id);
        await this.$store.dispatch("auth/logout");
        // リダイレクト
        if (this.apiStatus) {
          this.$router.push("/");
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
