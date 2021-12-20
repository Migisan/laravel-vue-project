<template>
  <div v-show="message" class="message">
    {{ message }}
  </div>
</template>

<script>
export default {
  computed: {
    /**
     * メッセージチェック
     */
    message() {
      return this.$store.state.message.content;
    }
  }
};
</script>
