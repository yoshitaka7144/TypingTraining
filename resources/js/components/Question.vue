<template>
  <div id="question" class="contents">
    <div class="title-area">
      <p class="title">タイピング問題一覧</p>
      <router-link v-bind:to="{ name: 'index' }">
        <button class="btn btn-gray">トップページへ戻る</button>
      </router-link>
    </div>

    <div class="setting">
      <div class="search-area">
        <select id="select-column" class="form-select" v-model="searchColumn">
          <option disabled value="">対象列を選択して下さい</option>
          <option
            v-for="option in selectOptions"
            :key="option.value"
            :value="option.value"
          >
            {{ option.name }}
          </option>
        </select>
        <input
          type="text"
          id="search-text"
          v-model="searchText"
          placeholder="検索文字列を入力"
        />
        <button class="btn btn-search" @click="searchQuestion">
          <font-awesome-icon :icon="['fas', 'search']" />
        </button>
        <button class="btn btn-gray btn-clear" @click="searchClear">解除</button>
      </div>
      <div class="setting-area" v-if="userRole !== 2">
        <input
          type="checkbox"
          class="form-checkbox"
          id="onlyEditor"
          v-model="isOnlyEditor"
        />
        <label for="onlyEditor">編集可能データのみ表示</label>
      </div>
      <div class="btn-wrapper">
        <button class="btn btn-green" @click="modalShow(1)">問題作成</button>
      </div>
    </div>
    <table>
      <thead>
        <tr>
          <th @click="orderChange('id')">
            ID<span v-if="orderColumn === 'id'">
              <font-awesome-icon
                v-if="orderType === 'desc'"
                :icon="['fas', 'caret-up']"
                class="icon"
              />
              <font-awesome-icon
                v-else
                :icon="['fas', 'caret-down']"
                class="icon"
              />
            </span>
          </th>
          <th @click="orderChange('category')">
            カテゴリー<span v-if="orderColumn === 'category'">
              <font-awesome-icon
                v-if="orderType === 'desc'"
                :icon="['fas', 'caret-up']"
                class="icon"
              />
              <font-awesome-icon
                v-else
                :icon="['fas', 'caret-down']"
                class="icon"
              />
            </span>
          </th>
          <th @click="orderChange('text')">
            問題<span v-if="orderColumn === 'text'">
              <font-awesome-icon
                v-if="orderType === 'desc'"
                :icon="['fas', 'caret-up']"
                class="icon"
              />
              <font-awesome-icon
                v-else
                :icon="['fas', 'caret-down']"
                class="icon"
              />
            </span>
          </th>
          <th @click="orderChange('kana')">
            かな<span v-if="orderColumn === 'kana'">
              <font-awesome-icon
                v-if="orderType === 'desc'"
                :icon="['fas', 'caret-up']"
                class="icon"
              />
              <font-awesome-icon
                v-else
                :icon="['fas', 'caret-down']"
                class="icon"
              />
            </span>
          </th>
          <th @click="orderChange('roman')">
            タイピング文字<span v-if="orderColumn === 'roman'">
              <font-awesome-icon
                v-if="orderType === 'desc'"
                :icon="['fas', 'caret-up']"
                class="icon"
              />
              <font-awesome-icon
                v-else
                :icon="['fas', 'caret-down']"
                class="icon"
              />
            </span>
          </th>
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
        <font-awesome-icon :icon="['fas', 'angle-double-left']" />
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
        <font-awesome-icon :icon="['fas', 'angle-double-right']" />
      </li>
    </ul>

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
      isOnlyEditor: false,
      orderColumn: "id",
      orderType: "asc",
      perPage: 5,
      currentPage: 1,
      lastPage: "",
      range: 5, // 奇数
      startDot: false,
      endDot: false,
      selectOptions: [
        { value: "questions.id", name: "ID" },
        { value: "categories.name", name: "カテゴリー" },
        { value: "text", name: "問題" },
        { value: "kana", name: "かな" },
        { value: "roman", name: "タイピング文字" },
      ],
      searchColumn: "",
      searchText: "",
      isSearched: false,
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
        orderColumn: this.orderColumn,
        orderType: this.orderType,
        editorUserId: this.isOnlyEditor ? this.userId : null,
        searchColumn: this.isSearched ? this.searchColumn : null,
        searchText: this.isSearched ? this.searchText : null,
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
    modalShow(mode, id = "") {
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
    orderChange(columnName) {
      if (this.orderColumn !== columnName) {
        this.orderColumn = columnName;
        this.orderType = "asc";
      } else {
        this.orderType = this.orderType === "desc" ? "asc" : "desc";
      }
      this.getQuestions(1);
    },
    searchQuestion() {
      if (this.searchColumn === "" || this.searchText.length <= 0) {
        // エラーメッセージ表示

        return;
      }
      this.isSearched = true;
      this.getQuestions(1);
    },
    searchClear() {
      this.searchColumn = "";
      this.searchText = "";
      this.isSearched = false;
      this.getQuestions(1);
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
        this.endDot = false;
        this.startDot = false;
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
  watch: {
    isOnlyEditor() {
      this.getQuestions(1);
    },
  },
};
</script>
