<template>
  <div class="container">
    <Header />
    <div class="main-container">
      <Router-view />
    </div>
    <Footer />
  </div>
</template>
<script>
import { INTERNAL_SERVER_ERROR } from "../util";
import Header from "./Header.vue";
import Footer from "./Footer.vue";

export default {
  components: {
    Header,
    Footer,
  },
  computed: {
    errorCode() {
      return this.$store.state.error.code;
    },
  },
  watch: {
    errorCode: {
      handler(val) {
        if (val === INTERNAL_SERVER_ERROR) {
          this.$router.push({ name: "systemError" });
        }
      },
      immediate: true,
    },
    $route() {
      this.$store.commit("error/setCode", null);
    },
  },
};
</script>
