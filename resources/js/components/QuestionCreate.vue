<template>
  <form @submit.prevent="register">
    <input type="text" v-model="registerForm.category" />
    <input type="text" v-model="registerForm.text" />
    <input type="text" v-model="registerForm.kana" />
    <button type="submit">登録</button>
  </form>
</template>
<script>
export default {
  data() {
    return {
      registerForm: {
        category: "",
        text: "",
        kana: "",
      },
    };
  },
  methods: {
    register() {
      axios.post("/api/question", this.registerForm).then((res) => {
        this.$router.push({ name: "question" });
      });
    },
  },
};
</script>
