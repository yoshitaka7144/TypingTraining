<template>
  <div id="question-create" class="contents">
    <p class="title">問題編集</p>
    <form @submit.prevent="update">
      <div v-if="updateErrorMessages" class="errors-area">
        <ul v-if="updateErrorMessages.category">
          <li v-for="msg in updateErrorMessages.category" :key="msg">
            {{ msg }}
          </li>
        </ul>
        <ul v-if="updateErrorMessages.text">
          <li v-for="msg in updateErrorMessages.text" :key="msg">
            {{ msg }}
          </li>
        </ul>
        <ul v-if="updateErrorMessages.kana">
          <li v-for="msg in updateErrorMessages.kana" :key="msg">
            {{ msg }}
          </li>
        </ul>
      </div>
      <label>ID：{{ questionId }}</label>
      <label for="question-category">カテゴリー</label>
      <input
        type="text"
        id="question-category"
        v-model="updateForm.category"
        autocomplete="off"
        :placeholder="categoryPlaceholder"
      />
      <p class="error" v-if="categoryError">{{ categoryError }}</p>
      <label for="question-text">問題</label>
      <input
        type="text"
        id="question-text"
        v-model="updateForm.text"
        autocomplete="off"
        :placeholder="textPlaceholder"
      />
      <p class="error" v-if="textError">{{ textError }}</p>
      <label for="question-kana">かな</label>
      <input
        type="text"
        id="question-kana"
        v-model="updateForm.kana"
        autocomplete="off"
        :placeholder="kanaPlaceholder"
      />
      <p class="error" v-if="kanaError">{{ kanaError }}</p>
      <div class="btn-wrapper">
        <button type="submit" class="btn btn-blue">更新</button>
      </div>
    </form>
    <router-link v-bind:to="{ name: 'question' }">問題一覧</router-link>
  </div>
</template>
<script>
import {
  OK,
  UNPROCESSABLE_ENTITY,
  REGISTER_QUESTION_CATEGORY_MAX_NUMBER,
  REGISTER_QUESTION_TEXT_MAX_NUMBER,
  REGISTER_QUESTION_KANA_MAX_NUMBER,
  REGISTER_QUESTION_CATEGORY_ERROR_REQUIRE,
  REGISTER_QUESTION_TEXT_ERROR_REQUIRE,
  REGISTER_QUESTION_KANA_ERROR_REQUIRE,
  REGISTER_QUESTION_CATEGORY_ERROR_LIMIT,
  REGISTER_QUESTION_TEXT_ERROR_LIMIT,
  REGISTER_QUESTION_KANA_ERROR_LIMIT,
  INTERNAL_SERVER_ERROR,
} from "../util";
export default {
  props: {
    questionId: Number,
  },
  data() {
    return {
      updateErrorMessages: "",
      updateForm: {
        category: "",
        text: "",
        kana: "",
      },
      categoryPlaceholder: REGISTER_QUESTION_CATEGORY_ERROR_LIMIT,
      categoryError: "",
      textPlaceholder: REGISTER_QUESTION_TEXT_ERROR_LIMIT,
      textError: "",
      kanaPlaceholder: REGISTER_QUESTION_KANA_ERROR_LIMIT,
      kanaError: "",
    };
  },
  methods: {
    async getQuestion() {
      var response = await axios
        .get("/api/question/" + this.questionId)
        .catch((error) => error.response || error);

      if (response.status === INTERNAL_SERVER_ERROR) {
        this.$store.commit("error/setCode", response.status);
      } else {
        this.updateForm = response.data;
      }
    },
    async update() {
      var response = await axios
        .put("/api/question/" + this.questionId, this.updateForm)
        .catch((error) => error.response || error);

      if (response.status === OK) {
        this.$router.push({ name: "question" });
      } else if (response.status === UNPROCESSABLE_ENTITY) {
        this.updateErrorMessages = response.data.errors;
      } else {
        this.$store.commit("error/setCode", response.status);
      }
    },
  },
  created() {
    this.getQuestion();
  },
  watch: {
    "updateForm.category": function (val) {
      if (val.length < 1) {
        this.categoryError = REGISTER_QUESTION_CATEGORY_ERROR_REQUIRE;
      } else if (val.length > REGISTER_QUESTION_CATEGORY_MAX_NUMBER) {
        this.categoryError = REGISTER_QUESTION_CATEGORY_ERROR_LIMIT;
      } else {
        this.categoryError = "";
      }
    },
    "updateForm.text": function (val) {
      if (val.length < 1) {
        this.textError = REGISTER_QUESTION_TEXT_ERROR_REQUIRE;
      } else if (val.length > REGISTER_QUESTION_TEXT_MAX_NUMBER) {
        this.textError = REGISTER_QUESTION_TEXT_ERROR_LIMIT;
      } else {
        this.textError = "";
      }
    },
    "updateForm.kana": function (val) {
      if (val.length < 1) {
        this.kanaError = REGISTER_QUESTION_KANA_ERROR_REQUIRE;
      } else if (val.length > REGISTER_QUESTION_KANA_MAX_NUMBER) {
        this.kanaError = REGISTER_QUESTION_KANA_ERROR_LIMIT;
      } else {
        this.kanaError = "";
      }
    },
  },
};
</script>
