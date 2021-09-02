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
        v-for="category in categories"
        :key="category.id"
        :to="{ name: 'typing.setting', params: { categoryId: category.id } }"
      >
        <button class="btn btn-blue">{{ category.name }}</button>
      </router-link>
    </div>
  </div>
</template>

<script>
import { INTERNAL_SERVER_ERROR } from "../util";
export default {
  data() {
    return {
      categories: [],
    };
  },
  computed: {
    isLogin() {
      return this.$store.getters["auth/isLogin"];
    },
    username() {
      return this.$store.getters["auth/userName"];
    },
  },
  mounted() {
    this.getCategories();
  },
  methods: {
    async getCategories() {
      const response = await axios
        .get("/api/category")
        .catch((error) => error.response || error);

      if (response.status === INTERNAL_SERVER_ERROR) {
        this.$store.commit("error/setCode", response.status);
      } else {
        this.categories = response.data;
      }
    },
  },
};
</script>
