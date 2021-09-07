<template>
  <modal
    class="modal-question-edit"
    name="modal-question-edit"
    :resizable="false"
    :clickToClose="false"
    :width="'60%'"
    :height="'50%'"
    @before-open="beforeOpen"
  >
    <div class="header">
      <button class="btn btn-red" @click="hide">
        <i class="fas fa-times"></i>
      </button>
    </div>
    <div class="main">
      <div
        id="question-edit"
        class="contents"
        v-if="options.mode === 1 || options.mode === 2"
      >
        <p class="title">問題作成</p>
        <form>
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

          <label v-if="options.mode === 2">ID：{{ options.questionId }}</label>

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
            <button
              v-if="options.mode === 1"
              type="button"
              class="btn btn-blue"
              @click="register"
            >
              登録
            </button>
            <button
              v-if="options.mode === 2"
              type="button"
              class="btn btn-blue"
              @click="update"
            >
              更新
            </button>
          </div>
        </form>
      </div>

      <div class="question-delete" v-if="options.mode === 3">
        <button class="btn btn-red" @click="deleteQuestion">削除</button>
        <button class="btn btn-gray" @click="hide">戻る</button>
      </div>
    </div>
  </modal>
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
  props: {
    options: {
      mode: "",
      questionId: "",
      updateParentPage: null,
    },
  },
  data() {
    return {
      registerErrorMessages: "",
      registerForm: {
        categoryId: "",
        text: "",
        kana: "",
        roman: "",
        editorUserId: this.$store.getters["auth/userId"],
      },
      selectOptions: "",
      textPlaceholder: REGISTER_QUESTION_TEXT_ERROR_LIMIT,
      textError: "",
      kanaPlaceholder: REGISTER_QUESTION_KANA_ERROR_LIMIT,
      kanaError: "",
      romanPlaceholder: REGISTER_QUESTION_ROMAN_ERROR_LIMIT,
      romanError: "",
    };
  },
  methods: {
    hide() {
      this.clear();
      this.$modal.hide("modal-question-edit");
    },
    async deleteQuestion() {
      const response = await axios
        .delete("/api/question/" + this.options.questionId)
        .catch((error) => error.response || error);

      if (response.status === INTERNAL_SERVER_ERROR) {
        this.$store.commit("error/setCode", response.status);
      } else {
        // 問題一覧の1ページ目を表示する為に引数有りで呼び出す
        this.options.updateParentPage(1);

        // モーダルウィンドウを閉じる
        this.hide();
      }
    },
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
      const response = await axios
        .get("/api/question/" + this.options.questionId)
        .catch((error) => error.response || error);

      if (response.status === INTERNAL_SERVER_ERROR) {
        this.$store.commit("error/setCode", response.status);
      } else {
        this.registerForm.categoryId = response.data.category_id;
        this.registerForm.text = response.data.text;
        this.registerForm.kana = response.data.kana;
        this.registerForm.roman = response.data.roman;
      }
    },
    async update() {
      const response = await axios
        .put("/api/question/" + this.options.questionId, this.registerForm)
        .catch((error) => error.response || error);

      if (response.status === OK) {
        this.options.updateParentPage();
        // モーダルウィンドウを閉じる
        this.hide();
      } else if (response.status === UNPROCESSABLE_ENTITY) {
        this.registerErrorMessages = response.data.errors;
      } else {
        this.$store.commit("error/setCode", response.status);
      }
    },
    async register() {
      const response = await axios
        .post("/api/question", this.registerForm)
        .catch((error) => error.response || error);

      if (response.status === CREATED) {
        this.options.updateParentPage();
        // モーダルウィンドウを閉じる
        this.hide();
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
    clear() {
      this.registerForm = {
        categoryId: "",
        text: "",
        kana: "",
        roman: "",
      };
      this.registerErrorMessages = "";
      this.selectOptions = "";
      this.textError = "";
      this.kanaError = "";
      this.romanError = "";
    },
    beforeOpen() {
      if (this.options.mode === 1) {
        this.getCategories();
      } else if (this.options.mode === 2) {
        this.getCategories();
        this.getQuestion();
      }
    },
  },
  computed: {},
  watch: {
    "registerForm.text": function (val) {
      if (val.length < 1) {
        this.textError = REGISTER_QUESTION_TEXT_ERROR_REQUIRE;
      } else if (val.length > REGISTER_QUESTION_TEXT_MAX_NUMBER) {
        this.textError = REGISTER_QUESTION_TEXT_ERROR_LIMIT;
      } else {
        if (!val.match(/^[0-9ぁ-んァ-ヶ一-龠々ー、。,\.]+$/u)) {
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
        if (!val.match(/^[0-9ぁ-んー、。,\.]+$/u)) {
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