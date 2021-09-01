<template>
  <div id="question-create" class="contents">
    <p class="title">問題作成</p>
    <form @submit.prevent="register">
      <div v-if="registerErrorMessages" class="errors-area">
        <ul v-if="registerErrorMessages.category">
          <li v-for="msg in registerErrorMessages.category" :key="msg">
            {{ msg }}
          </li>
        </ul>
        <ul v-if="registerErrorMessages.text">
          <li v-for="msg in registerErrorMessages.text" :key="msg">
            {{ msg }}
          </li>
        </ul>
        <ul v-if="registerErrorMessages.kana">
          <li v-for="msg in registerErrorMessages.kana" :key="msg">
            {{ msg }}
          </li>
        </ul>
        <ul v-if="registerErrorMessages.roman">
          <li v-for="msg in registerErrorMessages.roman" :key="msg">
            {{ msg }}
          </li>
        </ul>
      </div>
      <label for="question-category">カテゴリー</label>
      <input
        type="text"
        id="question-category"
        v-model="registerForm.category"
        autocomplete="off"
        :placeholder="categoryPlaceholder"
      />
      <p class="error" v-if="categoryError">{{ categoryError }}</p>
      <label for="question-text">問題</label>
      <input
        type="text"
        id="question-text"
        v-model="registerForm.text"
        autocomplete="off"
        :placeholder="textPlaceholder"
      />
      <p class="error" v-if="textError">{{ textError }}</p>
      <label for="question-kana">かな</label>
      <input
        type="text"
        id="question-kana"
        v-model="registerForm.kana"
        autocomplete="off"
        :placeholder="kanaPlaceholder"
      />
      <p class="error" v-if="kanaError">{{ kanaError }}</p>
      <label for="question-roman">タイピング文字</label>
      <input
        type="text"
        id="question-roman"
        v-model="registerForm.roman"
        autocomplete="off"
        :placeholder="romanPlaceholder"
      />
      <p class="error" v-if="romanError">{{ romanError }}</p>
      <div class="btn-wrapper">
        <button type="button" class="btn btn-green" @click="getRoman">
          かな、タイピング文字生成
        </button>
        <button type="submit" class="btn btn-blue">登録</button>
      </div>
    </form>
    <router-link v-bind:to="{ name: 'question' }">問題一覧</router-link>
  </div>
</template>
<script>
import {
  OK,
  CREATED,
  UNPROCESSABLE_ENTITY,
  REGISTER_QUESTION_CATEGORY_MAX_NUMBER,
  REGISTER_QUESTION_CATEGORY_ERROR_REQUIRE,
  REGISTER_QUESTION_CATEGORY_ERROR_LIMIT,
  REGISTER_QUESTION_TEXT_MAX_NUMBER,
  REGISTER_QUESTION_TEXT_ERROR_REQUIRE,
  REGISTER_QUESTION_TEXT_ERROR_LIMIT,
  REGISTER_QUESTION_KANA_MAX_NUMBER,
  REGISTER_QUESTION_KANA_ERROR_REQUIRE,
  REGISTER_QUESTION_KANA_ERROR_LIMIT,
  REGISTER_QUESTION_ROMAN_MAX_NUMBER,
  REGISTER_QUESTION_ROMAN_ERROR_REQUIRE,
  REGISTER_QUESTION_ROMAN_ERROR_LIMIT,
} from "../util";
export default {
  data() {
    return {
      registerErrorMessages: "",
      registerForm: {
        category: "",
        text: "",
        kana: "",
        roman: "",
      },
      categoryPlaceholder: REGISTER_QUESTION_CATEGORY_ERROR_LIMIT,
      categoryError: "",
      textPlaceholder: REGISTER_QUESTION_TEXT_ERROR_LIMIT,
      textError: "",
      kanaPlaceholder: REGISTER_QUESTION_KANA_ERROR_LIMIT,
      kanaError: "",
      romanPlaceholder: REGISTER_QUESTION_ROMAN_ERROR_LIMIT,
      romanError: "",
    };
  },
  methods: {
    async register() {
      var response = await axios
        .post("/api/question", this.registerForm)
        .catch((error) => error.response || error);

      if (response.status === CREATED) {
        this.$router.push({ name: "question" });
      } else if (response.status === UNPROCESSABLE_ENTITY) {
        this.registerErrorMessages = response.data.errors;
      } else {
        this.$store.commit("error/setCode", response.status);
      }
    },
    async getRoman() {
      if (this.registerForm.text.length <= 0) {
        return;
      }
      var response = await axios
        .post("/api/roman", this.registerForm)
        .catch((error) => error.response || error);

      if (response.status === OK) {
        var xmlData = new window.DOMParser().parseFromString(
          response.data,
          "text/xml"
        );
        var romanList = xmlData.querySelectorAll("Word > Roman");
        var furiganaList = xmlData.querySelectorAll("Word > Furigana");
        var roman = "";
        var furigana = "";
        Array.from(romanList).forEach((item) => {
          roman += item.textContent;
        });
        Array.from(furiganaList).forEach((item) => {
          furigana += item.textContent;
        });
        this.registerForm.roman = roman;
        this.registerForm.kana = furigana;
      } else {
        this.$store.commit("error/setCode", response.status);
      }
    },
  },
  watch: {
    "registerForm.category": function (val) {
      if (val.length < 1) {
        this.categoryError = REGISTER_QUESTION_CATEGORY_ERROR_REQUIRE;
      } else if (val.length > REGISTER_QUESTION_CATEGORY_MAX_NUMBER) {
        this.categoryError = REGISTER_QUESTION_CATEGORY_ERROR_LIMIT;
      } else {
        this.categoryError = "";
      }
    },
    "registerForm.text": function (val) {
      if (val.length < 1) {
        this.textError = REGISTER_QUESTION_TEXT_ERROR_REQUIRE;
      } else if (val.length > REGISTER_QUESTION_TEXT_MAX_NUMBER) {
        this.textError = REGISTER_QUESTION_TEXT_ERROR_LIMIT;
      } else {
        this.textError = "";
      }
    },
    "registerForm.kana": function (val) {
      if (val.length < 1) {
        this.kanaError = REGISTER_QUESTION_KANA_ERROR_REQUIRE;
      } else if (val.length > REGISTER_QUESTION_KANA_MAX_NUMBER) {
        this.kanaError = REGISTER_QUESTION_KANA_ERROR_LIMIT;
      } else {
        this.kanaError = "";
      }
    },
    "registerForm.roman": function (val) {
      if (val.length < 1) {
        this.romanError = REGISTER_QUESTION_ROMAN_ERROR_REQUIRE;
      } else if (val.length > REGISTER_QUESTION_ROMAN_MAX_NUMBER) {
        this.romanError = REGISTER_QUESTION_ROMAN_ERROR_LIMIT;
      } else {
        this.romanError = "";
      }
    },
  },
};
</script>
