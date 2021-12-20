<template>
  <div class="pagination">
    <div class="prev">
      <router-link v-if="!isFirstPage" :to="`/?page=${currentPage - 1}`">
        前へ
      </router-link>
    </div>
    <div class="next">
      <router-link v-if="!isLastPage" :to="`/?page=${currentPage + 1}`">
        次へ
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    currentPage: {
      type: Number,
      required: true
    },
    lastPage: {
      type: Number,
      required: true
    }
  },
  computed: {
    /**
     * 先頭ページチェック
     */
    isFirstPage() {
      return this.currentPage === 1;
    },
    /**
     * 末尾ページチェック
     */
    isLastPage() {
      return this.currentPage === this.lastPage;
    }
  }
};
</script>
