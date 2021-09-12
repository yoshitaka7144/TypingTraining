<template>
  <div id="not-found" class="contents">
    <p class="title">指定されたページは存在しません。</p>
    <div class="btn-wrapper">
      <router-link v-bind:to="{ name: 'index' }">
        <button class="btn btn-gray">トップページへ戻る</button>
      </router-link>
    </div>
  </div>
</template>

<script>
export default {};
</script>
