<template>
  <div id="system-error" class="contents">
    <p class="title">システムエラーが発生しました。</p>
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