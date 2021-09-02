<template>
  <div id="question-create" class="contents">
    <p class="title">問題編集</p>
    <form @submit.prevent="update">
      <div v-if="updateErrorMessages" class="errors-area">
        <ul v-if="updateErrorMessages.categoryId">
          <li v-for="msg in updateErrorMessages.categoryId" :key="msg">
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
        <ul v-if="updateErrorMessages.roman">
          <li v-for="msg in updateErrorMessages.roman" :key="msg">
            {{ msg }}
          </li>
        </ul>
      </div>
      <label>ID：{{ questionId }}</label>

      <label for="question-category">カテゴリー</label>
      <select id="question-category" v-model="updateForm.categoryId">
        <option disabled value="">選択して下さい</option>
        <option
          v-for="option in selectOptions"
          :value="option.id"
          :key="option.id"
        >
          {{ option.name }}
        </option>
      </select>

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
      <label for="question-roman">タイピング文字</label>
      <input
        type="text"
        id="question-roman"
        v-model="updateForm.roman"
        autocomplete="off"
        :placeholder="romanPlaceholder"
      />
      <p class="error" v-if="romanError">{{ romanError }}</p>
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
  INTERNAL_SERVER_ERROR,
  REGISTER_QUESTION_CATEGORY_MAX_NUMBER,
  REGISTER_QUESTION_CATEGORY_ERROR_REQUIRE,
  REGISTER_QUESTION_CATEGORY_ERROR_LIMIT,
  REGISTER_QUESTION_TEXT_MAX_NUMBER,
  REGISTER_QUESTION_TEXT_ERROR_REQUIRE,
  REGISTER_QUESTION_TEXT_ERROR_LIMIT,
  REGISTER_QUESTION_TEXT_ERROR_PATTERN,
  REGISTER_QUESTION_KANA_MAX_NUMBER,
  REGISTER_QUESTION_KANA_ERROR_REQUIRE,
  REGISTER_QUESTION_KANA_ERROR_LIMIT,
  REGISTER_QUESTION_KANA_ERROR_PATTERN,
  REGISTER_QUESTION_ROMAN_MAX_NUMBER,
  REGISTER_QUESTION_ROMAN_ERROR_REQUIRE,
  REGISTER_QUESTION_ROMAN_ERROR_LIMIT,
  REGISTER_QUESTION_ROMAN_ERROR_PATTERN,
} from "../util";
export default {
  props: {
    questionId: Number,
  },
  data() {
    return {
      updateErrorMessages: "",
      updateForm: {
        categoryId: "",
        text: "",
        kana: "",
        roman: "",
        editorId: this.$store.getters["auth/userId"],
      },
      selectOptions: [],
      textPlaceholder: REGISTER_QUESTION_TEXT_ERROR_LIMIT,
      textError: "",
      kanaPlaceholder: REGISTER_QUESTION_KANA_ERROR_LIMIT,
      kanaError: "",
      romanPlaceholder: REGISTER_QUESTION_ROMAN_ERROR_LIMIT,
      romanError: "",
    };
  },
  methods: {
    async getCategories() {
      const response = await axios
        .get("/api/category")
        .catch((error) => error.response || error);

      if (response.status === INTERNAL_SERVER_ERROR) {
        this.$store.commit("error/setCode", response.status);
      } else {
        this.selectOptions = response.data;
      }
    },
    async getQuestion() {
      var response = await axios
        .get("/api/question/" + this.questionId)
        .catch((error) => error.response || error);

      if (response.status === INTERNAL_SERVER_ERROR) {
        this.$store.commit("error/setCode", response.status);
      } else {
        this.updateForm.categoryId = response.data.category_id;
        this.updateForm.text = response.data.text;
        this.updateForm.kana = response.data.kana;
        this.updateForm.roman = response.data.roman;
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
    this.getCategories();
    this.getQuestion();
  },
  watch: {
    "updateForm.text": function (val) {
      if (val.length < 1) {
        this.textError = REGISTER_QUESTION_TEXT_ERROR_REQUIRE;
      } else if (val.length > REGISTER_QUESTION_TEXT_MAX_NUMBER) {
        this.textError = REGISTER_QUESTION_TEXT_ERROR_LIMIT;
      } else {
        if (!val.match(/^[ぁ-んァ-ヶ一-龠々ー、。,\.]+$/u)) {
          this.textError = REGISTER_QUESTION_TEXT_ERROR_PATTERN;
        } else {
          this.textError = "";
        }
      }
    },
    "updateForm.kana": function (val) {
      if (val.length < 1) {
        this.kanaError = REGISTER_QUESTION_KANA_ERROR_REQUIRE;
      } else if (val.length > REGISTER_QUESTION_KANA_MAX_NUMBER) {
        this.kanaError = REGISTER_QUESTION_KANA_ERROR_LIMIT;
      } else {
        if (!val.match(/^[ぁ-んー、。,\.]+$/u)) {
          this.kanaError = REGISTER_QUESTION_KANA_ERROR_PATTERN;
        } else {
          this.kanaError = "";
        }
      }
    },
    "updateForm.roman": function (val) {
      if (val.length < 1) {
        this.romanError = REGISTER_QUESTION_ROMAN_ERROR_REQUIRE;
      } else if (val.length > REGISTER_QUESTION_ROMAN_MAX_NUMBER) {
        this.romanError = REGISTER_QUESTION_ROMAN_ERROR_LIMIT;
      } else {
        if (!val.match(/^[a-zA-Z0-9\-,\.]+$/u)) {
          this.romanError = REGISTER_QUESTION_ROMAN_ERROR_PATTERN;
        } else {
          this.romanError = "";
        }
      }
    },
  },
};
</script>
