<template>
  <div>
    <table>
      <thead>
        <tr>
          <th>カテゴリー</th>
          <th>問題</th>
          <th>かな</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(question, index) in questions" :key="index">
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
export default {
  data() {
    return {
      questions: [],
    };
  },
  methods: {
    getQuestions() {
      axios.get("api/question").then((res) => {
        this.questions = res.data;
      });
    },
  },
  mounted() {
    this.getQuestions();
  },
};
</script>
