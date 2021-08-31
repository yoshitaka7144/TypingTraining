<template>
  <div id="typing">
    <select name="" id="" v-model="selectQuestionCount">
      <option :value="n" v-for="n in questions.length" :key="n">
        {{ n }}
      </option>
    </select>
    <button class="btn btn-blue" @click="show">スタート</button>
    <TypingModal :questions="questions" :questionCount="selectQuestionCount" />
  </div>
</template>
<script>
import { INTERNAL_SERVER_ERROR } from "../util";
import TypingModal from "./TypingModal.vue";
export default {
  components: { TypingModal },
  props: {
    category: String,
  },
  data() {
    return {
      questions: [],
      selectQuestionCount: 1,
    };
  },
  methods: {
    async getQuestions() {
      var response = await axios
        .get("/api/question/list/" + this.category)
        .catch((error) => error.response || error);

      if (response.status === INTERNAL_SERVER_ERROR) {
        this.$store.commit("error/setCode", response.status);
      } else {
        this.questions = response.data;
      }
    },
    show() {
      this.$modal.show("typing-modal");
    },
  },
  mounted() {
    this.getQuestions();
  },
};
</script>