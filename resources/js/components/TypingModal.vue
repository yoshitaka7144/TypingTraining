<template>
  <modal
    class="modal"
    name="typing-modal"
    :resizable="true"
    :clickToClose="false"
    :width="'80%'"
    :height="'70%'"
  >
    <div class="modal-header">
      <button class="btn btn-red" @click="hide">
        <i class="fas fa-times"></i>
      </button>
    </div>
    <div class="modal-main">
      <div class="" v-if="phase === 1">
        <button class="btn btn-blue" @click="start">スタート</button>
      </div>

      <div class="" v-if="phase === 2">
        <p>{{ displayText }}</p>
        <p>{{ displayKana }}</p>
        <p>
          <span class="inputed">{{ displayInputedRoman }}</span
          >{{ displayRoman }}
        </p>
      </div>

      <div id="keyboard-container">
        <div class="" v-if="phase === 3">
          <p>結果画面</p>
          <p>正しいタイプ数：{{ correctTypeCount }}</p>
          <p>ミスタイプ数：{{ missTypeCount }}</p>
          <p>時間：{{ typeTime }}</p>
          <p>WPM：{{ wpm }}</p>
          <p>正答率：{{ correctPercentage }}</p>
          <p>{{ missTypeKeyHash }}</p>
        </div>
        <div id="keyboard">
          <div class="row">
            <div class="key"></div>
            <div
              id="key-1"
              class="key"
              :class="{ 'target-key': '1' === roman[romanIndex] }"
              :style="missTypeKeyStyle['1']"
            >
              1
            </div>
            <div
              id="key-2"
              class="key"
              :class="{ 'target-key': '2' === roman[romanIndex] }"
              :style="missTypeKeyStyle['2']"
            >
              2
            </div>
            <div
              id="key-3"
              class="key"
              :class="{ 'target-key': '3' === roman[romanIndex] }"
              :style="missTypeKeyStyle['3']"
            >
              3
            </div>
            <div
              id="key-4"
              class="key"
              :class="{ 'target-key': '4' === roman[romanIndex] }"
              :style="missTypeKeyStyle['4']"
            >
              4
            </div>
            <div
              id="key-5"
              class="key"
              :class="{ 'target-key': '5' === roman[romanIndex] }"
              :style="missTypeKeyStyle['5']"
            >
              5
            </div>
            <div
              id="key-6"
              class="key"
              :class="{ 'target-key': '6' === roman[romanIndex] }"
              :style="missTypeKeyStyle['6']"
            >
              6
            </div>
            <div
              id="key-7"
              class="key"
              :class="{ 'target-key': '7' === roman[romanIndex] }"
              :style="missTypeKeyStyle['7']"
            >
              7
            </div>
            <div
              id="key-8"
              class="key"
              :class="{ 'target-key': '8' === roman[romanIndex] }"
              :style="missTypeKeyStyle['8']"
            >
              8
            </div>
            <div
              id="key-9"
              class="key"
              :class="{ 'target-key': '9' === roman[romanIndex] }"
              :style="missTypeKeyStyle['9']"
            >
              9
            </div>
            <div
              id="key-0"
              class="key"
              :class="{ 'target-key': '0' === roman[romanIndex] }"
              :style="missTypeKeyStyle['0']"
            >
              0
            </div>
            <div
              id="key--"
              class="key"
              :class="{ 'target-key': '-' === roman[romanIndex] }"
              :style="missTypeKeyStyle['-']"
            >
              -
            </div>
            <div class="key"></div>
            <div class="key"></div>
            <div class="key"></div>
          </div>

          <div class="row">
            <div id="key-tab" class="key"></div>
            <div
              id="key-q"
              class="key"
              :class="{ 'target-key': 'q' === roman[romanIndex] }"
              :style="missTypeKeyStyle['q']"
            >
              Q
            </div>
            <div
              id="key-w"
              class="key"
              :class="{ 'target-key': 'w' === roman[romanIndex] }"
              :style="missTypeKeyStyle['w']"
            >
              W
            </div>
            <div
              id="key-e"
              class="key"
              :class="{ 'target-key': 'e' === roman[romanIndex] }"
              :style="missTypeKeyStyle['e']"
            >
              E
            </div>
            <div
              id="key-r"
              class="key"
              :class="{ 'target-key': 'r' === roman[romanIndex] }"
              :style="missTypeKeyStyle['r']"
            >
              R
            </div>
            <div
              id="key-t"
              class="key"
              :class="{ 'target-key': 't' === roman[romanIndex] }"
              :style="missTypeKeyStyle['t']"
            >
              T
            </div>
            <div
              id="key-y"
              class="key"
              :class="{ 'target-key': 'y' === roman[romanIndex] }"
              :style="missTypeKeyStyle['y']"
            >
              Y
            </div>
            <div
              id="key-u"
              class="key"
              :class="{ 'target-key': 'u' === roman[romanIndex] }"
              :style="missTypeKeyStyle['u']"
            >
              U
            </div>
            <div
              id="key-i"
              class="key"
              :class="{ 'target-key': 'i' === roman[romanIndex] }"
              :style="missTypeKeyStyle['i']"
            >
              I
            </div>
            <div
              id="key-o"
              class="key"
              :class="{ 'target-key': 'o' === roman[romanIndex] }"
              :style="missTypeKeyStyle['o']"
            >
              O
            </div>
            <div
              id="key-p"
              class="key"
              :class="{ 'target-key': 'p' === roman[romanIndex] }"
              :style="missTypeKeyStyle['p']"
            >
              P
            </div>
            <div class="key"></div>
            <div class="key"></div>
            <div id="key-enter-1"></div>
          </div>

          <div class="row">
            <div id="key-caps" class="key"></div>
            <div
              id="key-a"
              class="key"
              :class="{ 'target-key': 'a' === roman[romanIndex] }"
              :style="missTypeKeyStyle['a']"
            >
              A
            </div>
            <div
              id="key-s"
              class="key"
              :class="{ 'target-key': 's' === roman[romanIndex] }"
              :style="missTypeKeyStyle['s']"
            >
              S
            </div>
            <div
              id="key-d"
              class="key"
              :class="{ 'target-key': 'd' === roman[romanIndex] }"
              :style="missTypeKeyStyle['d']"
            >
              D
            </div>
            <div
              id="key-f"
              class="key"
              :class="{ 'target-key': 'f' === roman[romanIndex] }"
              :style="missTypeKeyStyle['f']"
            >
              F
            </div>
            <div
              id="key-g"
              class="key"
              :class="{ 'target-key': 'g' === roman[romanIndex] }"
              :style="missTypeKeyStyle['g']"
            >
              G
            </div>
            <div
              id="key-h"
              class="key"
              :class="{ 'target-key': 'h' === roman[romanIndex] }"
              :style="missTypeKeyStyle['h']"
            >
              H
            </div>
            <div
              id="key-j"
              class="key"
              :class="{ 'target-key': 'j' === roman[romanIndex] }"
              :style="missTypeKeyStyle['j']"
            >
              J
            </div>
            <div
              id="key-k"
              class="key"
              :class="{ 'target-key': 'k' === roman[romanIndex] }"
              :style="missTypeKeyStyle['k']"
            >
              K
            </div>
            <div
              id="key-l"
              class="key"
              :class="{ 'target-key': 'l' === roman[romanIndex] }"
              :style="missTypeKeyStyle['l']"
            >
              L
            </div>
            <div class="key"></div>
            <div class="key"></div>
            <div class="key"></div>
            <div id="key-enter-2"></div>
          </div>

          <div class="row">
            <div id="key-shift-left" class="key"></div>
            <div
              id="key-z"
              class="key"
              :class="{ 'target-key': 'z' === roman[romanIndex] }"
              :style="missTypeKeyStyle['z']"
            >
              Z
            </div>
            <div
              id="key-x"
              class="key"
              :class="{ 'target-key': 'x' === roman[romanIndex] }"
              :style="missTypeKeyStyle['x']"
            >
              X
            </div>
            <div
              id="key-c"
              class="key"
              :class="{ 'target-key': 'c' === roman[romanIndex] }"
              :style="missTypeKeyStyle['c']"
            >
              C
            </div>
            <div
              id="key-v"
              class="key"
              :class="{ 'target-key': 'v' === roman[romanIndex] }"
              :style="missTypeKeyStyle['v']"
            >
              V
            </div>
            <div
              id="key-b"
              class="key"
              :class="{ 'target-key': 'b' === roman[romanIndex] }"
              :style="missTypeKeyStyle['b']"
            >
              B
            </div>
            <div
              id="key-n"
              class="key"
              :class="{ 'target-key': 'n' === roman[romanIndex] }"
              :style="missTypeKeyStyle['n']"
            >
              N
            </div>
            <div
              id="key-m"
              class="key"
              :class="{ 'target-key': 'm' === roman[romanIndex] }"
              :style="missTypeKeyStyle['m']"
            >
              M
            </div>
            <div
              id="key-,"
              class="key"
              :class="{ 'target-key': ',' === roman[romanIndex] }"
              :style="missTypeKeyStyle[',']"
            >
              ,
            </div>
            <div
              id="key-."
              class="key"
              :class="{ 'target-key': '.' === roman[romanIndex] }"
              :style="missTypeKeyStyle['.']"
            >
              .
            </div>
            <div class="key"></div>
            <div class="key"></div>
            <div id="key-shift-right" class="key"></div>
          </div>

          <div class="row">
            <div id="key-ctrl" class="key"></div>
            <div class="key"></div>
            <div class="key"></div>
            <div class="key"></div>
            <div class="key"></div>
            <div
              id="key-space"
              class="key"
              :class="{ 'target-key': 0 === roman.length }"
            ></div>
            <div class="key"></div>
            <div class="key"></div>
            <div class="key"></div>
            <div class="key"></div>
            <div class="key"></div>
            <div class="key"></div>
          </div>
        </div>
      </div>

      <div id="hand-container" v-if="phase === 1 || phase === 2">
        <div id="hand" class="">
          <div id="hand-left" class="">
            <div
              id="left-little"
              class="finger finger-little"
              :class="{ 'target-finger': isLeftLittle }"
            ></div>
            <div
              id="left-ring"
              class="finger finger-ring"
              :class="{ 'target-finger': isLeftRing }"
            ></div>
            <div
              id="left-middle"
              class="finger finger-middle"
              :class="{ 'target-finger': isLeftMiddle }"
            ></div>
            <div
              id="left-index"
              class="finger finger-index"
              :class="{ 'target-finger': isLeftIndex }"
            ></div>
            <div id="left-thumb" class="finger finger-thumb"></div>
          </div>
          <div id="hand-right" class="">
            <div id="right-thumb" class="finger finger-thumb"></div>
            <div
              id="right-index"
              class="finger finger-index"
              :class="{ 'target-finger': isRightIndex }"
            ></div>
            <div
              id="right-middle"
              class="finger finger-middle"
              :class="{ 'target-finger': isRightMiddle }"
            ></div>
            <div
              id="right-ring"
              class="finger finger-ring"
              :class="{ 'target-finger': isRightRing }"
            ></div>
            <div
              id="right-little"
              class="finger finger-little"
              :class="{ 'target-finger': isRightLittle }"
            ></div>
          </div>
        </div>
      </div>

      <div id="history-container" v-if="isLogin && phase === 3">
        <div class="table-area">
          <table class="history-table">
            <thead>
              <tr>
                <th>WPM</th>
                <th>正答率</th>
                <th>ミスしたキー</th>
                <th>日付</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="history in histories" :key="history.id">
                <td>{{ history.wpm }}</td>
                <td>{{ history.correct_percentage }}</td>
                <td>{{ history.miss_key }}</td>
                <td>{{ history.created_at }}</td>
              </tr>
            </tbody>
          </table>
          <ul class="pagination">
            <li
              :class="currentPage === 1 ? 'disabled' : ''"
              @click="changeHistoryPage(currentPage - 1)"
            >
              <i class="fas fa-angle-double-left"></i>
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
              <i class="fas fa-angle-double-right"></i>
            </li>
          </ul>
        </div>
        <div class="history-graph">
          <HistoryChart
            :chartData="chartData"
            :options="chartOptions"
            :height="400"
            :width="500"
          />
        </div>
      </div>
    </div>
  </modal>
</template>
<script>
import {
  OK,
  UNPROCESSABLE_ENTITY,
  INTERNAL_SERVER_ERROR,
  END_SYMBOL,
} from "../util.js";
import { checkInputKey } from "../key.js";
import HistoryChart from "./HistoryChart.vue";
export default {
  components: {
    HistoryChart,
  },
  props: {
    categoryId: "",
    questions: [],
    questionCount: "",
  },
  data() {
    return {
      phase: 1,
      currentCount: 0,
      currentQuestion: [],
      roman: [],
      romanIndex: 0,
      displayText: "",
      displayKana: "",
      displayRoman: "",
      displayInputedRoman: "",
      correctTypeCount: 0,
      missTypeCount: 0,
      typeTime: 0,
      wpm: 0,
      correctPercentage: 0,
      missTypeKeyHash: {},
      missTypeKeyStyle: {},
      histories: {},
      perPage: 5,
      currentPage: 1,
      lastPage: "",
      range: 5, // 奇数
      startDot: false,
      endDot: false,
      chartData: {},
      chartOptions: {},
    };
  },
  mounted() {
    window.addEventListener("keydown", this.keyAction);
  },
  beforeDestroy() {
    window.removeEventListener("keydown", this.keyAction);
  },
  computed: {
    isLogin() {
      return this.$store.getters["auth/isLogin"];
    },
    userId() {
      return this.$store.getters["auth/userId"];
    },
    isLeftLittle() {
      var leftLittle = ["1", "q", "a", "z"];
      var char = this.roman[this.romanIndex];
      return leftLittle.includes(char);
    },
    isLeftRing() {
      var leftRing = ["2", "w", "s", "x"];
      var char = this.roman[this.romanIndex];
      return leftRing.includes(char);
    },
    isLeftMiddle() {
      var leftMiddle = ["3", "e", "d", "c"];
      var char = this.roman[this.romanIndex];
      return leftMiddle.includes(char);
    },
    isLeftIndex() {
      var leftIndex = ["4", "5", "r", "t", "f", "g", "v", "b"];
      var char = this.roman[this.romanIndex];
      return leftIndex.includes(char);
    },
    isRightIndex() {
      var rightIndex = ["6", "7", "y", "u", "h", "j", "n", "m"];
      var char = this.roman[this.romanIndex];
      return rightIndex.includes(char);
    },
    isRightMiddle() {
      var rightMiddle = ["8", "i", "k", ","];
      var char = this.roman[this.romanIndex];
      return rightMiddle.includes(char);
    },
    isRightRing() {
      var rightRing = ["9", "o", "l", "."];
      var char = this.roman[this.romanIndex];
      return rightRing.includes(char);
    },
    isRightLittle() {
      var rightLittle = ["0", "p"];
      var char = this.roman[this.romanIndex];
      return rightLittle.includes(char);
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
  methods: {
    hide() {
      this.clear();
      this.$modal.hide("typing-modal");
    },
    start() {
      this.initQuestion();
      this.typeTime = performance.now();
      this.phase = 2;
    },
    next() {
      if (this.questionCount > this.currentCount + 1) {
        this.currentCount++;
      } else {
        this.showResult();
      }
    },
    showResult() {
      // 時間測定終了
      this.typeTime = performance.now() - this.typeTime;

      // 結果集計
      this.wpm = Math.floor(
        (this.correctTypeCount / this.typeTime) * 1000 * 60
      );
      this.correctPercentage = Math.floor(
        (1 -
          this.missTypeCount / (this.correctTypeCount + this.missTypeCount)) *
          100
      );

      // ログイン時、データ更新と履歴データ作成
      if (this.isLogin) {
        this.updateUserInfo();
        this.createHistory();
        this.getHistory();
      }

      // ミスタイプキーのスタイル設定
      this.setMissTypeKeyStyle();

      // 結果画面表示
      this.phase = 3;
    },
    clear() {
      this.roman = [];
      this.currentCount = 0;
      this.phase = 1;
      this.correctTypeCount = 0;
      this.missTypeCount = 0;
      this.wpm = 0;
      this.correctPercentage = 0;
      this.missTypeKeyHash = {};
      this.missTypeKeyStyle = {};
      this.histories = {};
      this.currentPage = 1;
      this.lastPage = "";
      this.startDot = false;
      this.endDot = false;
      this.chartData = {};
      this.chartOptions = {};
    },
    initQuestion() {
      this.roman = [];
      this.romanIndex = 0;
      this.currentQuestion = this.questions[this.currentCount];

      this.roman = this.currentQuestion.roman.split("");
      this.roman.push(END_SYMBOL);
      this.displayText = this.currentQuestion.text;
      this.displayKana = this.currentQuestion.kana;
      this.displayRoman = this.currentQuestion.roman;
      this.displayInputedRoman = "";
    },
    setMissTypeKeyStyle() {
      for (let key in this.missTypeKeyHash) {
        const percentage =
          Math.ceil((this.missTypeKeyHash[key] / this.missTypeCount) * 10) / 10;
        this.missTypeKeyStyle[key] = {
          "background-color": "rgba(255,0,0," + percentage + ")",
        };
      }
    },
    createHistoryChartData() {
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
    async updateUserInfo() {
      const response = await axios
        .put("/api/user/" + this.userId, { typeCount: this.typeCount })
        .catch((error) => error.response || error);

      if (response.status === OK) {
      } else if (response.status === UNPROCESSABLE_ENTITY) {
      } else {
        this.$store.commit("error/setCode", response.status);
      }
    },
    async createHistory() {
      const missKey =
        Object.keys(this.missTypeKeyHash).length > 0
          ? Object.keys(this.missTypeKeyHash).join(",")
          : "";
      const paramsCreate = {
        userId: this.userId,
        categoryId: this.categoryId,
        wpm: this.wpm,
        correctPercentage: this.correctPercentage,
        missKey: missKey,
      };
      const responseCreate = await axios
        .post("/api/history", paramsCreate)
        .catch((error) => error.response || error);
      if (responseCreate.status === INTERNAL_SERVER_ERROR) {
        this.$store.commit("error/setCode", responseCreate.status);
      }
    },
    async getHistory() {
      const params = {
        userId: this.userId,
        categoryId: this.categoryId,
        perPage: this.perPage,
        page: this.currentPage,
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
    keyAction(e) {
      if (this.phase === 2) {
        e.preventDefault();
        switch (checkInputKey(e.code, this.roman, this.romanIndex)) {
          case 1:
          case 2:
            this.correctTypeCount++;
            this.romanIndex++;
            if (this.roman[this.romanIndex] === END_SYMBOL) {
              this.next();
              if (this.phase === 3) break;
              this.initQuestion();
            } else {
              this.displayRoman = "";
              this.displayInputedRoman = "";
              for (var i = this.romanIndex; i < this.roman.length - 1; i++) {
                this.displayRoman += this.roman[i];
              }
              for (var i = 0; i < this.romanIndex; i++) {
                this.displayInputedRoman += this.roman[i];
              }
            }
            break;
          case 0:
          case 3:
            //タイプミス時
            // ミス回数カウント
            this.missTypeCount++;

            // ミスタイプキーカウント
            const missTypeKey = this.roman[this.romanIndex];
            if (this.missTypeKeyHash[missTypeKey]) {
              this.missTypeKeyHash[missTypeKey]++;
            } else {
              this.missTypeKeyHash[missTypeKey] = 1;
            }

            break;
          default:
            break;
        }
      }
    },
  },
};
</script>