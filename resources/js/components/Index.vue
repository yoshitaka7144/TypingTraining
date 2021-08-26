<template>
  <div>
    <p>home</p>
    <p v-if="isLogin">{{ username }}でログインしています</p>
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
