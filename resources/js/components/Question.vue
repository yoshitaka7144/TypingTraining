<template>
  <div id="question" class="contents">
    <p class="title">問題一覧</p>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>カテゴリー</th>
          <th>問題</th>
          <th>かな</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="question in questions" :key="question.id">
          <td>{{ question.id }}</td>
          <td>{{ question.category }}</td>
          <td>{{ question.text }}</td>
          <td>{{ question.kana }}</td>
        </tr>
      </tbody>
    </table>
    <router-link v-bind:to="{ name: 'question.create' }">問題作成</router-link>
  </div>
</template>

<script>
import { INTERNAL_SERVER_ERROR } from "../util";
export default {
  data() {
    return {
      questions: [],
    };
  },
  methods: {
    async getQuestions() {
      var response = await axios
        .get("api/question")
        .catch((error) => error.response || error);

      if (response.status === INTERNAL_SERVER_ERROR) {
        this.$store.commit("error/setCode", response.status);
      } else {
        this.questions = response.data;
      }
    },
  },
  created() {
    this.getQuestions();
  },
};
</script>
