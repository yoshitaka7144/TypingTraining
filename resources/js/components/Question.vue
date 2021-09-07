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
            <button
              v-if="userRole === 2 || question.editor_user_id === userId"
              class="btn btn-blue"
              @click="modalShow(2, question.id)"
            >
              編集
            </button>
          </td>
          <td>
            <button
              v-if="userRole === 2 || question.editor_user_id === userId"
              class="btn btn-red"
              @click="modalShow(3, question.id)"
            >
              削除
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <ul class="pagination">
      <li
        :class="currentPage === 1 ? 'disabled' : ''"
        @click="changeQuestionPage(currentPage - 1)"
      >
        <i class="fas fa-angle-double-left"></i>
      </li>
      <li
        v-for="page in startPageRange"
        :key="page"
        @click="changeQuestionPage(page)"
        :class="isActive(page) ? 'active' : ''"
      >
        {{ page }}
      </li>
      <li v-show="startDot" class="disabled">...</li>
      <li
        v-for="page in centerPageRange"
        :key="page"
        @click="changeQuestionPage(page)"
        :class="isActive(page) ? 'active' : ''"
      >
        {{ page }}
      </li>
      <li v-show="endDot" class="disabled">...</li>
      <li
        v-for="page in endPageRange"
        :key="page"
        @click="changeQuestionPage(page)"
        :class="isActive(page) ? 'active' : ''"
      >
        {{ page }}
      </li>
      <li
        :class="currentPage >= lastPage ? 'disabled' : ''"
        @click="changeQuestionPage(currentPage + 1)"
      >
        <i class="fas fa-angle-double-right"></i>
      </li>
    </ul>
    <button class="btn btn-blue" @click="modalShow(1)">問題作成</button>
    <QuestionEditModal :options="modalOptions" />
  </div>
</template>

<script>
import { INTERNAL_SERVER_ERROR } from "../util";
import QuestionEditModal from "./QuestionEditModal.vue";
export default {
  data() {
    return {
      questions: [],
      modalOptions: {
        mode: "",
        questionId: "",
        updateParentPage: this.getQuestions,
      },
      perPage: 5,
      currentPage: 1,
      lastPage: "",
      range: 5, // 奇数
      startDot: false,
      endDot: false,
    };
  },
  components: {
    QuestionEditModal,
  },
  methods: {
    async getQuestions(topPage = 0) {
      const params = {
        perPage: this.perPage,
        page: topPage === 0 ? this.currentPage : 1,
      };
      const response = await axios
        .get("/api/question", { params })
        .catch((error) => error.response || error);

      if (response.status === INTERNAL_SERVER_ERROR) {
        this.$store.commit("error/setCode", response.status);
      } else {
        const questions = response.data;
        this.currentPage = questions.current_page;
        this.lastPage = questions.last_page;
        this.questions = questions.data;
      }
    },
    modalShow(mode, id) {
      this.modalOptions.mode = mode;
      this.modalOptions.questionId = id;
      this.$modal.show("modal-question-edit");
    },
    createRange(start, end) {
      const range = [];
      for (let i = start; i <= end; i++) {
        range.push(i);
      }
      return range;
    },
    changeQuestionPage(page) {
      if (1 <= page && page <= this.lastPage) {
        this.currentPage = page;
        this.getQuestions();
      }
    },
    isActive(page) {
      return this.currentPage === page;
    },
  },
  computed: {
    userId() {
      return this.$store.getters["auth/userId"];
    },
    userRole() {
      return this.$store.getters["auth/userRole"];
    },
    isShortSize() {
      return this.lastPage < this.range + 5;
    },
    startPageRange() {
      if (this.isShortSize) {
        return this.createRange(1, this.lastPage);
      } else {
        return this.createRange(1, 2);
      }
    },
    endPageRange() {
      if (this.isShortSize) {
        return [];
      } else {
        return this.createRange(this.lastPage - 1, this.lastPage);
      }
    },
    centerPageRange() {
      if (this.isShortSize) {
        return [];
      } else {
        let start, end;
        if (this.currentPage <= this.range) {
          start = 3;
          end = this.range + 2;
          this.startDot = false;
          this.endDot = true;
        } else if (this.currentPage > this.lastPage - this.range) {
          start = this.lastPage - this.range - 1;
          end = this.lastPage - 2;
          this.startDot = true;
          this.endDot = false;
        } else {
          start = this.currentPage - Math.floor(this.range / 2);
          end = this.currentPage + Math.floor(this.range / 2);
          this.startDot = true;
          this.endDot = true;
        }
        return this.createRange(start, end);
      }
    },
  },
  created() {
    this.getQuestions();
  },
};
</script>
