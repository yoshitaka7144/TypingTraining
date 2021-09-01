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
          <th>タイピング文字</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="question in questions" :key="question.id">
          <td>{{ question.id }}</td>
          <td>{{ question.category }}</td>
          <td>{{ question.text }}</td>
          <td>{{ question.kana }}</td>
          <td>{{ question.roman }}</td>
          <td>
            <router-link
              v-if="userRole === 2 || question.editor_id === userId"
              :to="{
                name: 'question.edit',
                params: { questionId: question.id },
              }"
            >
              <button class="btn btn-blue">編集</button>
            </router-link>
          </td>
          <td>
            <button
              v-if="userRole === 2 || question.editor_id === userId"
              class="btn btn-red"
              @click="modalShow(question.id)"
            >
              削除
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <router-link v-bind:to="{ name: 'question.create' }">問題作成</router-link>
    <Modal :modalOption="modalOption" />
  </div>
</template>

<script>
import { INTERNAL_SERVER_ERROR } from "../util";
import Modal from "./Modal.vue";
export default {
  data() {
    return {
      questions: [],
      modalOption: {
        action: "",
        targetQuestionId: "",
        afterConfirmationFunction: "",
      },
    };
  },
  components: {
    Modal,
  },
  methods: {
    async getQuestions() {
      var response = await axios
        .get("/api/question")
        .catch((error) => error.response || error);

      if (response.status === INTERNAL_SERVER_ERROR) {
        this.$store.commit("error/setCode", response.status);
      } else {
        this.questions = response.data;
      }
    },
    async deleteQuestion(id) {
      var response = await axios
        .delete("/api/question/" + id)
        .catch((error) => error.response || error);

      if (response.status === INTERNAL_SERVER_ERROR) {
        this.$store.commit("error/setCode", response.status);
      } else {
        this.getQuestions();
      }
    },
    modalShow(id) {
      this.modalOption.action = "削除";
      this.modalOption.targetQuestionId = id;
      this.modalOption.afterConfirmationFunction = this.deleteQuestion;
      this.$modal.show("modal");
    },
  },
  computed: {
    userId() {
      return this.$store.getters["auth/userId"];
    },
    userRole() {
      return this.$store.getters["auth/userRole"];
    },
  },
  created() {
    this.getQuestions();
  },
};
</script>
