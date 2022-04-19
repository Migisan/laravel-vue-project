<template>
  <div class="like_list">
    <h2>いいねした人</h2>
    <div v-if="likes">
      <div v-if="likes.length === 0" class="like_nothing">
        いいねはありません。
      </div>
      <ul v-else>
        <li v-for="like in likes" :key="like.user.id" class="like_item">
          <router-link :to="`/user/?id=${like.user.id}`">
            <div class="like_item_user_icon">
              <img
                :src="like.user.image_path"
                :alt="like.user.name + 'のプロフィール画像'"
              />
            </div>
            <div class="like_item_user_info">
              <div class="like_item_user_name">{{ like.user.name }}</div>
            </div>
          </router-link>
        </li>
      </ul>
    </div>
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
    return {};
  },
  computed: {
    /**
     * いいね一覧
     */
    likes() {
      return this.$store.state.like.likes;
    },
    /**
     * APIステータスチェック
     */
    apiStatus() {
      return this.$store.state.like.apiStatus;
    }
  },
  methods: {},
  watch: {
    $route: {
      async handler() {
        await this.$store.dispatch("like/getLikeList", this.id);
      },
      immediate: true
    }
  }
};
</script>
