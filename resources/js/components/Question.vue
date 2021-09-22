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
        <button class="btn btn-gray btn-clear" @click="searchClear">
          解除
        </button>
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
              <font-awesome-icon :icon="['fas', 'edit']" />
            </button>
          </td>
          <td>
            <button
              v-if="userRole === 2 || question.editor_user_id === userId"
              class="btn btn-red"
              @click="modalShow(3, question.id)"
            >
              <font-awesome-icon :icon="['far', 'trash-alt']" />
            </button>
          </td>
          <td>
            <button class="btn btn-gray" @click="testModalShow(question.id)">
              <font-awesome-icon :icon="['far', 'keyboard']" />
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
    <TypingTestModal :testModalOptions="testModalOptions" />
  </div>
</template>

<script>
import { INTERNAL_SERVER_ERROR } from "../util";
import QuestionEditModal from "./QuestionEditModal.vue";
import TypingTestModal from "./TypingTestModal.vue";
export default {
  data() {
    return {
      // 問題データ
      questions: [],
      // モーダル設定
      modalOptions: {
        // mode:1（作成）,2（更新）3（削除）
        mode: "",
        // 問題ID
        questionId: "",
        // ページ更新用処理
        updateParentPage: this.getQuestions,
      },
      // 編集者のみ設定
      isOnlyEditor: false,
      // 並び替え列名
      orderColumn: "id",
      // 並び替え順
      orderType: "asc",
      // 1ページあたりの件数
      perPage: 5,
      // 現在のページ数
      currentPage: 1,
      // 最大ページ数
      lastPage: "",
      // ページングの中間表示
      range: 5, // 奇数
      // ページング先頭と中間の間のドット表示
      startDot: false,
      // ページング末尾と中間の間のドット表示
      endDot: false,
      // 検索対象列select
      selectOptions: [
        { value: "questions.id", name: "ID" },
        { value: "categories.name", name: "カテゴリー" },
        { value: "text", name: "問題" },
        { value: "kana", name: "かな" },
        { value: "roman", name: "タイピング文字" },
      ],
      // 検索対象列名
      searchColumn: "",
      // 検索対象テキスト
      searchText: "",
      // 検索状態フラグ
      isSearched: false,
      // タイピングテストモーダル用
      testModalOptions: {
        // 問題ID
        questionId: "",
      },
    };
  },
  components: {
    // 問題編集モーダル
    QuestionEditModal,
    // タイピングテストモーダル
    TypingTestModal,
  },
  methods: {
    // 問題一覧取得
    async getQuestions(topPage = 0) {
      // api用パラメータ
      const params = {
        perPage: this.perPage,
        page: topPage === 0 ? this.currentPage : 1,
        orderColumn: this.orderColumn,
        orderType: this.orderType,
        editorUserId: this.isOnlyEditor ? this.userId : null,
        searchColumn: this.isSearched ? this.searchColumn : null,
        searchText: this.isSearched ? this.searchText : null,
      };
      // api呼び出し
      const response = await axios
        .get("/api/question", { params })
        .catch((error) => error.response || error);

      if (response.status === INTERNAL_SERVER_ERROR) {
        // エラー時
        this.$store.commit("error/setCode", response.status);
      } else {
        const questions = response.data;
        this.currentPage = questions.current_page;
        this.lastPage = questions.last_page;
        this.questions = questions.data;
      }
    },
    // 編集用モーダルウィンドウ表示
    modalShow(mode, id = "") {
      // モード設定（作成：1、更新：2、削除：3）
      this.modalOptions.mode = mode;
      // 問題ID設定
      this.modalOptions.questionId = id;
      // モーダルウィンドウ表示
      this.$modal.show("modal-question-edit");
    },
    // タイピングテストモーダルウィンドウ表示
    testModalShow(id) {
      // 問題ID設定
      this.testModalOptions.questionId = id;
      // モーダルウィンドウ表示
      this.$modal.show("modal-typing-test");
    },
    // ページング用配列作成
    createRange(start, end) {
      const range = [];
      for (let i = start; i <= end; i++) {
        range.push(i);
      }
      return range;
    },
    // ページング
    changeQuestionPage(page) {
      if (1 <= page && page <= this.lastPage) {
        this.currentPage = page;
        this.getQuestions();
      }
    },
    // ページアクティブ状態
    isActive(page) {
      return this.currentPage === page;
    },
    // 並び替え変更
    orderChange(columnName) {
      if (this.orderColumn !== columnName) {
        this.orderColumn = columnName;
        this.orderType = "asc";
      } else {
        this.orderType = this.orderType === "desc" ? "asc" : "desc";
      }
      this.getQuestions(1);
    },
    // 検索条件で問題取得
    searchQuestion() {
      // 対象列未選択または検索テキストが空の場合は何もしない
      if (this.searchColumn === "" || this.searchText.length <= 0) {
        return;
      }
      this.isSearched = true;
      this.getQuestions(1);
    },
    // 検索条件クリア
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
