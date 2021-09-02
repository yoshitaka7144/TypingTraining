<template>
  <div id="question-create" class="contents">
    <p class="title">問題作成</p>
    <form @submit.prevent="register">
      <div v-if="registerErrorMessages" class="errors-area">
        <ul v-if="registerErrorMessages.categoryId">
          <li v-for="msg in registerErrorMessages.categoryId" :key="msg">
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
      <select id="question-category" v-model="registerForm.categoryId">
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
  INTERNAL_SERVER_ERROR,
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
  data() {
    return {
      registerErrorMessages: "",
      registerForm: {
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
        this.selectOptions = response.data;
      }
    },
    async register() {
      const response = await axios
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
      const response = await axios
        .post("/api/roman", this.registerForm)
        .catch((error) => error.response || error);

      if (response.status === OK) {
        const xmlData = new window.DOMParser().parseFromString(
          response.data,
          "text/xml"
        );
        const romanList = xmlData.querySelectorAll("Word > Roman");
        const furiganaList = xmlData.querySelectorAll("Word > Furigana");
        let roman = "";
        let furigana = "";
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
    "registerForm.text": function (val) {
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
    "registerForm.kana": function (val) {
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
    "registerForm.roman": function (val) {
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
