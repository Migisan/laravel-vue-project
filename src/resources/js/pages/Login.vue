<template>
  <div class="login">
    <!-- タブ -->
    <ul class="tab">
      <li
        class="tab-item"
        :class="{ 'tab-active': tab === 'login' }"
        @click="changeTab('login')"
      >
        Login
      </li>
      <li
        class="tab-item"
        :class="{ 'tab-active': tab === 'register' }"
        @click="changeTab('register')"
      >
        Register
      </li>
    </ul>
    <!-- タブ ここまで -->
    <!-- 画面 -->
    <div class="panels">
      <div class="panel" v-show="tab === 'login'">
        ログイン画面
        <form class="form" @submit.prevent="login">
          <div class="form-row">
            <label for="login-email">メールアドレス</label>
            <input type="text" id="login-email" v-model="loginForm.email" />
            <div v-if="loginErrors" class="errors">
              <ul v-if="loginErrors.email">
                <li v-for="msg in loginErrors.email" :key="msg">
                  {{ msg }}
                </li>
              </ul>
            </div>
          </div>
          <div class="form-row">
            <label for="login-password">パスワード</label>
            <input
              type="password"
              id="login-password"
              v-model="loginForm.password"
            />
            <div v-if="loginErrors" class="errors">
              <ul v-if="loginErrors.password">
                <li v-for="msg in loginErrors.password" :key="msg">
                  {{ msg }}
                </li>
              </ul>
            </div>
          </div>
          <button type="submit">ログイン</button>
        </form>
      </div>
      <div class="panel" v-show="tab === 'register'">
        ユーザー登録画面
        <form class="form" @submit.prevent="register">
          <div class="form-row">
            <label for="name">名前</label>
            <input type="text" id="name" v-model="registerForm.name" />
            <div v-if="registerErrors" class="errors">
              <ul v-if="registerErrors.name">
                <li v-for="msg in registerErrors.name" :key="msg">
                  {{ msg }}
                </li>
              </ul>
            </div>
          </div>
          <div class="form-row">
            <label for="email">メールアドレス</label>
            <input type="text" id="email" v-model="registerForm.email" />
            <div v-if="registerErrors" class="errors">
              <ul v-if="registerErrors.email">
                <li v-for="msg in registerErrors.email" :key="msg">
                  {{ msg }}
                </li>
              </ul>
            </div>
          </div>
          <div class="form-row">
            <label for="image">プロフィール画像</label>
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
                v-show="registerForm.image"
                id="previewArea"
                :class="{ enter: isEnter }"
              ></div>
              <div v-show="!registerForm.image" :class="{ enter: isEnter }">
                プロフィール画像を選択してください。
              </div>
            </div>
            <div v-if="registerErrors" class="errors">
              <ul v-if="registerErrors.image">
                <li v-for="msg in registerErrors.image" :key="msg">
                  {{ msg }}
                </li>
              </ul>
            </div>
          </div>
          <div class="form-row">
            <label for="password">パスワード</label>
            <input
              type="password"
              id="password"
              v-model="registerForm.password"
            />
            <div v-if="registerErrors" class="errors">
              <ul v-if="registerErrors.password">
                <li v-for="msg in registerErrors.password" :key="msg">
                  {{ msg }}
                </li>
              </ul>
            </div>
          </div>
          <div class="form-row">
            <label for="password-confirmation">確認用パスワード</label>
            <input
              type="password"
              id="password-confirmation"
              v-model="registerForm.password_confirmation"
            />
            <div v-if="registerErrors" class="errors">
              <ul v-if="registerErrors.password_confirmation">
                <li
                  v-for="msg in registerErrors.password_confirmation"
                  :key="msg"
                >
                  {{ msg }}
                </li>
              </ul>
            </div>
          </div>
          <button type="submit">ユーザー登録</button>
        </form>
      </div>
    </div>
    <!-- 画面 ここまで -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      // タブ
      tab: "login",
      // ドラッグ&ドロップエリア,
      isEnter: false,
      // ログイン
      loginForm: {
        email: "",
        password: ""
      },
      // ユーザー登録
      registerForm: {
        name: "",
        email: "",
        image: null,
        password: "",
        password_confirmation: ""
      }
    };
  },
  computed: {
    /**
     * APIステータスチェック
     */
    apiStatus() {
      return this.$store.state.auth.apiStatus;
    },
    /**
     * ログインエラーチェック
     */
    loginErrors() {
      return this.$store.state.auth.loginErrorMessages;
    },
    /**
     * ユーザー登録エラーチェック
     */
    registerErrors() {
      return this.$store.state.auth.registerErrorMessages;
    }
  },
  created() {
    this.clearError();
  },
  methods: {
    /**
     * エラー初期化
     */
    clearError() {
      this.$store.commit("auth/setLoginErrorMessages", null);
      this.$store.commit("auth/setRegisterErrorMessages", null);
    },
    /**
     * タブ切り替え
     *
     * @param selectTab 選択タブ
     */
    changeTab(selectTab) {
      this.tab = selectTab;
    },
    /**
     * プロフィール画像のアップロード
     */
    uploadImage(event) {
      const file = event.target.files[0];
      this.registerForm.image = file;
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
      this.registerForm.image = file;
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
     * ログイン処理
     */
    async login() {
      console.log(this.loginForm);
      await this.$store.dispatch("auth/login", this.loginForm);
      if (this.apiStatus) {
        this.$router.push("/");
      }
    },
    /**
     * ユーザー登録処理
     */
    async register() {
      console.log(this.registerForm);
      await this.$store.dispatch("auth/register", this.registerForm);
      if (this.apiStatus) {
        this.$router.push("/");
      }
    }
  }
};
</script>
