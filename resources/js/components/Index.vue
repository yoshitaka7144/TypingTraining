<template>
  <div>
    <p>home</p>
    <div v-if="!isLogin">
      <router-link :to="{ name: 'login' }">
        <button class="btn btn-green">ログイン</button>
      </router-link>
    </div>
    <div v-if="isLogin">
      <p>{{ username }}でログインしています</p>
      <router-link :to="{ name: 'question' }">
        <button class="btn btn-green">問題編集</button>
      </router-link>
    </div>
    <div>
      <router-link
        :to="{ name: 'typing.setting', params: { category: 'aaa' } }"
      >
        <button class="btn btn-blue">aaa</button>
      </router-link>
      <router-link
        :to="{ name: 'typing.setting', params: { category: 'bbb' } }"
      >
        <button class="btn btn-blue">bbb</button>
      </router-link>
      <router-link
        :to="{ name: 'typing.setting', params: { category: 'test3' } }"
      >
        <button class="btn btn-blue">test3</button>
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
  computed: {
    isLogin() {
      return this.$store.getters["auth/isLogin"];
    },
    username() {
      return this.$store.getters["auth/username"];
    },
  },
};
</script>
