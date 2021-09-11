<template>
  <div id="home">
    <div class="top-image">
      <img :src="'./image/top.jpg'" alt="" />
    </div>

    <div class="main">
      <div class="member-menu menu">
        <p class="title">会員メニュー</p>
        <div v-if="!isLogin" class="menu-btn">
          <router-link :to="{ name: 'login' }">
            <button class="btn btn-green">ログイン</button>
          </router-link>
        </div>
        <div v-else class="menu-btn">
          <router-link :to="{ name: 'question' }">
            <button class="btn btn-green">問題編集</button>
          </router-link>
          <button class="btn btn-red" @click="logout">ログアウト</button>
        </div>
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
        <div class="btn-wrapper">
          <button
            class="btn btn-blue"
            v-for="category in categories"
            :key="category.id"
            @click="showTypingModal(category.id)"
          >
            {{ category.name }}
          </button>
        </div>
      </div>

      <div class="history menu" v-if="isLogin && existsHistory">
        <p class="title">履歴データ</p>
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
                <th>カテゴリー</th>
                <th>WPM</th>
                <th>正答率</th>
                <th>ミスキー</th>
                <th>日付</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="history in histories" :key="history.id">
                <td>{{ history.category }}</td>
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
      categories: [],
      histories: [],
      perPage: 5,
      currentPage: 1,
      lastPage: "",
      range: 5, // 奇数
      startDot: false,
      endDot: false,
      chartData: {},
      chartOptions: {},
      categoryId: "",
      userTypeCount: "",
      userAverageWpm: "",
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
    async getHistory(topPage = 0) {
      const params = {
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
        this.createHistoryChartData();
      }
    },
    createRange(start, end) {
      const range = [];
      for (let i = start; i <= end; i++) {
        range.push(i);
      }
      return range;
    },
    changeHistoryPage(page) {
      if (1 <= page && page <= this.lastPage) {
        this.currentPage = page;
        this.getHistory();
      }
    },
    isActive(page) {
      return this.currentPage === page;
    },
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
      const maxWpm = wpmData.reduce((a, b) => {
        a > b ? a : b;
      });
      const minWpm = wpmData.reduce((a, b) => {
        a < b ? a : b;
      });

      this.chartData = {
        labels: labels,
        datasets: [
          {
            type: "bar",
            label: "wpm",
            data: wpmData,
            backgroundColor: "lightblue",
            yAxisID: "y-axis-1",
          },
          {
            type: "line",
            label: "正答率(%)",
            data: correctPercentageData,
            borderColor: "#CFD8DC",
            fill: false,
            lineTension: 0.3,
            yAxisID: "y-axis-2",
          },
        ],
      };

      this.chartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        scales: {
          xAxes: [{}],
          yAxes: [
            {
              id: "y-axis-1",
              position: "left",
              ticks: {
                max: maxWpm > 400 ? maxWpm : 400,
                min: minWpm,
                stepSize: 50,
              },
            },
            {
              id: "y-axis-2",
              position: "right",
              ticks: {
                max: 100,
                min: 0,
                stepSize: 10,
              },
            },
          ],
        },
      };
    },
    showTypingModal(categoryId) {
      this.categoryId = categoryId;
      this.$modal.show("modal-typing");
    },
    initCategoryId() {
      this.categoryId = "";
    },
    loadMemberInfo() {
      this.getHistory();
      this.getUserInfo();
      this.getUserAverageWpm();
    },
    async logout() {
      await this.$store.dispatch("auth/logout");

      if (this.apiStatus) {
        this.$router.push("/", function () {});
      }
    },
  },
};
</script>
