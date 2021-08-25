<template>
  <div>
    <p>home</p>
    <p v-if="isLogined">{{ username }}でログインしています</p>
  </div>
</template>

<script>
export default {
  computed: {
    isLogined() {
      return this.$store.getters["auth/isLogined"];
    },
    username() {
      return this.$store.getters["auth/username"];
    },
  },
};
</script>
