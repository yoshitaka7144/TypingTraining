<template>
  <div id="home">
    <div class="top-image">
      <img :src="'./image/top.png'" alt="" />
    </div>

    <div class="main">
      <div class="member-menu menu">
        <p class="title">会員メニュー</p>
        <div v-if="!isLogin" class="menu-btn">
          <router-link :to="{ name: 'login' }">
            <button class="btn btn-green">ログイン/新規登録</button>
          </router-link>
        </div>
        <div v-else class="menu-btn">
          <router-link :to="{ name: 'question' }">
            <button class="btn btn-green">問題編集</button>
          </router-link>
          <button class="btn btn-red" @click="logout">ログアウト</button>
        </div>
        <p class="message" v-if="!isLogin">
          ログインユーザーは問題編集、履歴機能が利用可能です。
        </p>
        <table v-if="isLogin" class="user-info-table">
          <tr>
            <th>ユーザー名</th>
            <td>{{ userName }}</td>
          </tr>
          <tr>
            <th>総タイプ数</th>
            <td>{{ userTypeCount }}</td>
          </tr>
          <tr>
            <th>平均WPM</th>
            <td>{{ averageWpm }}</td>
          </tr>
        </table>
      </div>

      <div class="typing-menu menu">
        <p class="title">タイピングメニュー</p>
        <div class="item-wrapper">
          <div
            class="item"
            v-for="category in categories"
            :key="category.id"
            @click="showTypingModal(category.id)"
          >
            <p>{{ category.name }}</p>
            <p>{{ category.description }}</p>
          </div>
        </div>
      </div>

      <div class="history menu" v-if="isLogin && existsHistory">
        <p class="title">履歴データ</p>
        <label for="category-select">対象カテゴリー：</label>
        <select
          id="category-select"
          class="history-category-select"
          v-model="selectCategoryId"
        >
          <option value="">全て</option>
          <option
            v-for="category in categories"
            :key="category.id"
            :value="category.id"
          >
            {{ category.name }}
          </option>
        </select>
        <ul class="pagination">
          <li
            :class="currentPage === 1 ? 'disabled' : ''"
            @click="changeHistoryPage(currentPage - 1)"
          >
            <font-awesome-icon :icon="['fas', 'angle-double-left']" />
          </li>
          <li
            v-for="page in startPageRange"
            :key="page"
            @click="changeHistoryPage(page)"
            :class="isActive(page) ? 'active' : ''"
          >
            {{ page }}
          </li>
          <li v-show="startDot" class="disabled">...</li>
          <li
            v-for="page in centerPageRange"
            :key="page"
            @click="changeHistoryPage(page)"
            :class="isActive(page) ? 'active' : ''"
          >
            {{ page }}
          </li>
          <li v-show="endDot" class="disabled">...</li>
          <li
            v-for="page in endPageRange"
            :key="page"
            @click="changeHistoryPage(page)"
            :class="isActive(page) ? 'active' : ''"
          >
            {{ page }}
          </li>
          <li
            :class="currentPage >= lastPage ? 'disabled' : ''"
            @click="changeHistoryPage(currentPage + 1)"
          >
            <font-awesome-icon :icon="['fas', 'angle-double-right']" />
          </li>
        </ul>
        <div class="history-data">
          <table class="history-table">
            <thead>
              <tr>
                <th v-if="selectCategoryId === ''">カテゴリー</th>
                <th>WPM</th>
                <th>正答率</th>
                <th>ミスキー</th>
                <th>日付</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="history in histories" :key="history.id">
                <td v-if="selectCategoryId === ''">{{ history.category }}</td>
                <td>{{ history.wpm }}</td>
                <td>{{ history.correct_percentage }}</td>
                <td>{{ history.miss_key }}</td>
                <td>{{ history.created_at }}</td>
              </tr>
            </tbody>
          </table>
          <div class="history-graph">
            <HistoryChart
              :chartData="chartData"
              :options="chartOptions"
              :height="400"
            />
          </div>
        </div>
      </div>
      <div class="history menu" v-if="isLogin && !existsHistory">
        <p class="title">履歴データ</p>
        <p class="message">まだ履歴データがありません。</p>
        <label for="category-select">対象カテゴリー：</label>
        <select
          id="category-select"
          class="history-category-select"
          v-model="selectCategoryId"
        >
          <option value="">全て</option>
          <option
            v-for="category in categories"
            :key="category.id"
            :value="category.id"
          >
            {{ category.name }}
          </option>
        </select>
      </div>
    </div>
    <TypingModal
      :categoryId="categoryId"
      :updateParentPage="loadMemberInfo"
      :initCategoryId="initCategoryId"
    />
  </div>
</template>

<script>
import { INTERNAL_SERVER_ERROR } from "../util";
import TypingModal from "./TypingModal.vue";
import HistoryChart from "./HistoryChart.vue";
export default {
  components: {
    TypingModal,
    HistoryChart,
  },
  data() {
    return {
      // カテゴリーデータ
      categories: [],
      // 履歴データ
      histories: [],
      // グラフwpm間隔
      wpmStepSize: 50,
      // ページング用：1ページあたりの件数
      perPage: 5,
      // ページング用：現在のページ数
      currentPage: 1,
      // ページング用：最大ページ数
      lastPage: "",
      // ページング用：ページングの中間表示
      range: 5, // 奇数
      // ページング用：ページング先頭と中間の間のドット表示
      startDot: false,
      // ページング用：ページング末尾と中間の間のドット表示
      endDot: false,
      // グラフデータ
      chartData: {},
      // グラフオプション
      chartOptions: {},
      // カテゴリーID
      categoryId: "",
      // ユーザー情報：総タイプ数
      userTypeCount: "",
      // ユーザー情報：平均wpm
      userAverageWpm: "",
      // 選択カテゴリーID
      selectCategoryId: "",
    };
  },
  computed: {
    isLogin() {
      return this.$store.getters["auth/isLogin"];
    },
    userName() {
      return this.$store.getters["auth/userName"];
    },
    userId() {
      return this.$store.getters["auth/userId"];
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
    existsHistory() {
      return Object.keys(this.histories).length > 0;
    },
    averageWpm() {
      return this.userAverageWpm !== ""
        ? Math.floor(this.userAverageWpm)
        : "---";
    },
    apiStatus() {
      return this.$store.state.auth.apiStatus;
    },
  },
  mounted() {
    this.getCategories();
    if (this.isLogin) {
      this.loadMemberInfo();
    }
  },
  methods: {
    // ユーザー情報取得
    async getUserInfo() {
      const response = await axios
        .get("/api/user/" + this.userId)
        .catch((error) => error.response || error);

      if (response.status === INTERNAL_SERVER_ERROR) {
        this.$store.commit("error/setCode", response.status);
      } else {
        this.userTypeCount = response.data.type_count;
      }
    },
    // 平均wpm取得
    async getUserAverageWpm() {
      const params = {
        userId: this.userId,
      };
      const response = await axios
        .get("/api/history/averageWpm", { params })
        .catch((error) => error.response || error);

      if (response.status === INTERNAL_SERVER_ERROR) {
        this.$store.commit("error/setCode", response.status);
      } else {
        this.userAverageWpm = response.data;
      }
    },
    // カテゴリーデータ取得
    async getCategories() {
      const response = await axios
        .get("/api/category")
        .catch((error) => error.response || error);

      if (response.status === INTERNAL_SERVER_ERROR) {
        this.$store.commit("error/setCode", response.status);
      } else {
        this.categories = response.data;
      }
    },
    // 履歴データ取得
    async getHistory(topPage = 0) {
      const params = {
        categoryId: this.selectCategoryId,
        userId: this.userId,
        perPage: this.perPage,
        page: topPage === 0 ? this.currentPage : 1,
      };
      const response = await axios
        .get("/api/history", { params })
        .catch((error) => error.response || error);

      if (response.status === INTERNAL_SERVER_ERROR) {
        this.$store.commit("error/setCode", response.status);
      } else {
        const histories = response.data;
        this.currentPage = histories.current_page;
        this.lastPage = histories.last_page;
        this.histories = histories.data;
        // グラフデータ作成
        this.createHistoryChartData();
      }
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
    changeHistoryPage(page) {
      if (1 <= page && page <= this.lastPage) {
        this.currentPage = page;
        this.getHistory();
      }
    },
    isActive(page) {
      return this.currentPage === page;
    },
    // グラフデータ作成
    createHistoryChartData() {
      if (!this.existsHistory) {
        return;
      }
      let labels = [];
      let wpmData = [];
      let correctPercentageData = [];

      this.histories.forEach((history) => {
        labels.push(history.created_at.slice(5, 16));
        wpmData.push(history.wpm);
        correctPercentageData.push(history.correct_percentage);
      });
      let maxWpm = wpmData.reduce((a, b) => {
        return a > b ? a : b;
      });
      let minWpm = wpmData.reduce((a, b) => {
        return a < b ? a : b;
      });
      // wpmのグラフ表示最大値
      const maxWpmScale =
        Math.ceil(maxWpm / this.wpmStepSize) * this.wpmStepSize;
      // wpmのグラフ表示最小値
      const minWpmScale =
        (Math.ceil(minWpm / this.wpmStepSize) - 1) * this.wpmStepSize;
      // データが無い場合、空で埋める
      for (let i = labels.length; i < this.perPage; i++) {
        labels.push("");
        wpmData.push(null);
        correctPercentageData.push(null);
      }

      this.chartData = {
        labels: labels,
        datasets: [
          {
            type: "line",
            label: "正答率(%)",
            datalabels: {
              display: false,
            },
            data: correctPercentageData,
            backgroundColor: "#7dd093",
            borderColor: "#7dd093",
            borderWidth: 2,
            pointStyle: "circle",
            pointRadius: 4,
            backgroundColor: "#e0f7c7",
            fill: false,
            lineTension: 0.3,
            yAxisID: "y-axis-1",
          },
          {
            type: "bar",
            label: "wpm",
            datalabels: {
              display: true,
              anchor: "end",
              align: "end",
              offset: 0,
              padding: 0,
              color: "#a5a1a1",
              font: {
                size: 16,
              },
            },
            data: wpmData,
            backgroundColor: "#60d0e4",
            borderColor: "#60d0e4",
            yAxisID: "y-axis-2",
          },
        ],
      };

      this.chartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        scales: {
          xAxes: [
            {
              gridLines: {
                display: false,
              },
            },
          ],
          yAxes: [
            {
              id: "y-axis-1",
              position: "right",
              ticks: {
                max: 100,
                min: 0,
                stepSize: 20,
                fontColor: "#1a7940",
                fontSize: 14,
              },
              gridLines: {
                display: false,
              },
            },
            {
              id: "y-axis-2",
              position: "left",
              ticks: {
                max: maxWpmScale,
                min: minWpmScale,
                stepSize: this.wpmStepSize,
                fontColor: "#4883da",
                fontSize: 14,
              },
              gridLines: {
                borderDash: [5, 5],
              },
            },
          ],
        },
      };
    },
    // タイピング用モーダルウィンドウ表示
    showTypingModal(categoryId) {
      this.categoryId = categoryId;
      this.$modal.show("modal-typing");
    },
    // カテゴリーID初期化
    initCategoryId() {
      this.categoryId = "";
    },
    // ユーザー情報読み込み
    loadMemberInfo() {
      this.getHistory();
      this.getUserInfo();
      this.getUserAverageWpm();
    },
    // ログアウト
    async logout() {
      await this.$store.dispatch("auth/logout");

      if (this.apiStatus) {
        this.$router.push("/", function () {});
      }
    },
  },
  watch: {
    // 選択カテゴリーID変化時に問題取得
    selectCategoryId() {
      this.getHistory(1);
    },
  },
};
</script>
