<template>
  <modal
    class="modal-typing"
    name="modal-typing"
    :clickToClose="false"
    :maxWidth="1000"
    :width="'95%'"
    :height="'auto'"
    :scrollable="true"
    :adaptive="true"
  >
    <div class="modal-header">
      <font-awesome-icon :icon="['fas', 'times']" class="icon" @click="hide" />
    </div>
    <div class="modal-main">
      <div v-if="phase === 1">
        <div class="question-setting">
          <div>
            <label for="questionCount">問題数：</label>
            <select
              id="questionCount"
              class="form-select"
              v-model="questionCount"
            >
              <option :value="n" v-for="n in questions.length" :key="n">
                {{ n }}
              </option>
            </select>
          </div>
          <div>
            <input
              type="checkbox"
              class="form-checkbox"
              id="audio"
              v-model="audioCheaked"
            />
            <label for="audio" class="">音声の有無</label>
          </div>
          <div>
            <input
              type="checkbox"
              class="form-checkbox"
              id="limit"
              v-model="limitCheaked"
            />
            <label for="limit" class="">制限時間の有無</label>
          </div>
          <div v-if="limitCheaked">
            <label for="wpm-select">WPM目標値：</label>
            <select id="wpm-select" class="form-select" v-model="targetWpm">
              <option :value="n" v-for="n in wpmSelectOptions" :key="n">
                {{ n }}
              </option>
            </select>
          </div>
        </div>
        <p v-if="questionCount > 0" class="message missed">
          スペースキーを押すとスタートします。
        </p>
        <p v-else class="message error">問題が登録されていません。</p>
      </div>

      <div class="count-wrapper" v-if="phase === 1.5">
        <div class="count">
          <p>3</p>
          <p>2</p>
          <p>1</p>
        </div>
      </div>

      <div class="display-question" v-if="phase === 2">
        <p class="display-text">{{ displayText }}</p>
        <p class="display-kana">{{ displayKana }}</p>
        <p class="display-roman">
          <span class="inputed">{{ displayInputedRoman }}</span
          >{{ displayRoman }}
        </p>
        <div v-if="limitCheaked" class="progress">
          <div
            class="progress-bar"
            :style="{ width: progress + '%', backgroundColor: progressColor }"
          ></div>
        </div>
      </div>

      <div class="result" v-if="phase === 3">
        <p class="title">タイピング結果</p>
        <table class="result-table">
          <tr>
            <th>WPM</th>
            <th>ミスタイプ数</th>
            <th>正答率（%）</th>
            <th>ミスキー（キー：回数）</th>
          </tr>
          <tr>
            <td>{{ wpm }}</td>
            <td>{{ missTypeCount }}</td>
            <td>{{ correctPercentage }}</td>
            <td>{{ missKeyResult }}</td>
          </tr>
        </table>
      </div>

      <div id="keyboard-container">
        <div id="keyboard">
          <div class="row">
            <div class="key"></div>
            <div
              id="key-1"
              class="key"
              :class="{
                'target-key': '1' === roman[romanIndex],
                missed: '1' === missTypeKey,
              }"
              :style="missTypeKeyStyle['1']"
            >
              1
            </div>
            <div
              id="key-2"
              class="key"
              :class="{
                'target-key': '2' === roman[romanIndex],
                missed: '2' === missTypeKey,
              }"
              :style="missTypeKeyStyle['2']"
            >
              2
            </div>
            <div
              id="key-3"
              class="key"
              :class="{
                'target-key': '3' === roman[romanIndex],
                missed: '3' === missTypeKey,
              }"
              :style="missTypeKeyStyle['3']"
            >
              3
            </div>
            <div
              id="key-4"
              class="key"
              :class="{
                'target-key': '4' === roman[romanIndex],
                missed: '4' === missTypeKey,
              }"
              :style="missTypeKeyStyle['4']"
            >
              4
            </div>
            <div
              id="key-5"
              class="key"
              :class="{
                'target-key': '5' === roman[romanIndex],
                missed: '5' === missTypeKey,
              }"
              :style="missTypeKeyStyle['5']"
            >
              5
            </div>
            <div
              id="key-6"
              class="key"
              :class="{
                'target-key': '6' === roman[romanIndex],
                missed: '6' === missTypeKey,
              }"
              :style="missTypeKeyStyle['6']"
            >
              6
            </div>
            <div
              id="key-7"
              class="key"
              :class="{
                'target-key': '7' === roman[romanIndex],
                missed: '7' === missTypeKey,
              }"
              :style="missTypeKeyStyle['7']"
            >
              7
            </div>
            <div
              id="key-8"
              class="key"
              :class="{
                'target-key': '8' === roman[romanIndex],
                missed: '8' === missTypeKey,
              }"
              :style="missTypeKeyStyle['8']"
            >
              8
            </div>
            <div
              id="key-9"
              class="key"
              :class="{
                'target-key': '9' === roman[romanIndex],
                missed: '9' === missTypeKey,
              }"
              :style="missTypeKeyStyle['9']"
            >
              9
            </div>
            <div
              id="key-0"
              class="key"
              :class="{
                'target-key': '0' === roman[romanIndex],
                missed: '0' === missTypeKey,
              }"
              :style="missTypeKeyStyle['0']"
            >
              0
            </div>
            <div
              id="key--"
              class="key"
              :class="{
                'target-key': '-' === roman[romanIndex],
                missed: '-' === missTypeKey,
              }"
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
              :class="{
                'target-key': 'q' === roman[romanIndex],
                missed: 'q' === missTypeKey,
              }"
              :style="missTypeKeyStyle['q']"
            >
              Q
            </div>
            <div
              id="key-w"
              class="key"
              :class="{
                'target-key': 'w' === roman[romanIndex],
                missed: 'w' === missTypeKey,
              }"
              :style="missTypeKeyStyle['w']"
            >
              W
            </div>
            <div
              id="key-e"
              class="key"
              :class="{
                'target-key': 'e' === roman[romanIndex],
                missed: 'e' === missTypeKey,
              }"
              :style="missTypeKeyStyle['e']"
            >
              E
            </div>
            <div
              id="key-r"
              class="key"
              :class="{
                'target-key': 'r' === roman[romanIndex],
                missed: 'r' === missTypeKey,
              }"
              :style="missTypeKeyStyle['r']"
            >
              R
            </div>
            <div
              id="key-t"
              class="key"
              :class="{
                'target-key': 't' === roman[romanIndex],
                missed: 't' === missTypeKey,
              }"
              :style="missTypeKeyStyle['t']"
            >
              T
            </div>
            <div
              id="key-y"
              class="key"
              :class="{
                'target-key': 'y' === roman[romanIndex],
                missed: 'y' === missTypeKey,
              }"
              :style="missTypeKeyStyle['y']"
            >
              Y
            </div>
            <div
              id="key-u"
              class="key"
              :class="{
                'target-key': 'u' === roman[romanIndex],
                missed: 'u' === missTypeKey,
              }"
              :style="missTypeKeyStyle['u']"
            >
              U
            </div>
            <div
              id="key-i"
              class="key"
              :class="{
                'target-key': 'i' === roman[romanIndex],
                missed: 'i' === missTypeKey,
              }"
              :style="missTypeKeyStyle['i']"
            >
              I
            </div>
            <div
              id="key-o"
              class="key"
              :class="{
                'target-key': 'o' === roman[romanIndex],
                missed: 'o' === missTypeKey,
              }"
              :style="missTypeKeyStyle['o']"
            >
              O
            </div>
            <div
              id="key-p"
              class="key"
              :class="{
                'target-key': 'p' === roman[romanIndex],
                missed: 'p' === missTypeKey,
              }"
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
              :class="{
                'target-key': 'a' === roman[romanIndex],
                missed: 'a' === missTypeKey,
              }"
              :style="missTypeKeyStyle['a']"
            >
              A
            </div>
            <div
              id="key-s"
              class="key"
              :class="{
                'target-key': 's' === roman[romanIndex],
                missed: 's' === missTypeKey,
              }"
              :style="missTypeKeyStyle['s']"
            >
              S
            </div>
            <div
              id="key-d"
              class="key"
              :class="{
                'target-key': 'd' === roman[romanIndex],
                missed: 'd' === missTypeKey,
              }"
              :style="missTypeKeyStyle['d']"
            >
              D
            </div>
            <div
              id="key-f"
              class="key"
              :class="{
                'target-key': 'f' === roman[romanIndex],
                missed: 'f' === missTypeKey,
              }"
              :style="missTypeKeyStyle['f']"
            >
              F
            </div>
            <div
              id="key-g"
              class="key"
              :class="{
                'target-key': 'g' === roman[romanIndex],
                missed: 'g' === missTypeKey,
              }"
              :style="missTypeKeyStyle['g']"
            >
              G
            </div>
            <div
              id="key-h"
              class="key"
              :class="{
                'target-key': 'h' === roman[romanIndex],
                missed: 'h' === missTypeKey,
              }"
              :style="missTypeKeyStyle['h']"
            >
              H
            </div>
            <div
              id="key-j"
              class="key"
              :class="{
                'target-key': 'j' === roman[romanIndex],
                missed: 'j' === missTypeKey,
              }"
              :style="missTypeKeyStyle['j']"
            >
              J
            </div>
            <div
              id="key-k"
              class="key"
              :class="{
                'target-key': 'k' === roman[romanIndex],
                missed: 'k' === missTypeKey,
              }"
              :style="missTypeKeyStyle['k']"
            >
              K
            </div>
            <div
              id="key-l"
              class="key"
              :class="{
                'target-key': 'l' === roman[romanIndex],
                missed: 'l' === missTypeKey,
              }"
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
              :class="{
                'target-key': 'z' === roman[romanIndex],
                missed: 'z' === missTypeKey,
              }"
              :style="missTypeKeyStyle['z']"
            >
              Z
            </div>
            <div
              id="key-x"
              class="key"
              :class="{
                'target-key': 'x' === roman[romanIndex],
                missed: 'x' === missTypeKey,
              }"
              :style="missTypeKeyStyle['x']"
            >
              X
            </div>
            <div
              id="key-c"
              class="key"
              :class="{
                'target-key': 'c' === roman[romanIndex],
                missed: 'c' === missTypeKey,
              }"
              :style="missTypeKeyStyle['c']"
            >
              C
            </div>
            <div
              id="key-v"
              class="key"
              :class="{
                'target-key': 'v' === roman[romanIndex],
                missed: 'v' === missTypeKey,
              }"
              :style="missTypeKeyStyle['v']"
            >
              V
            </div>
            <div
              id="key-b"
              class="key"
              :class="{
                'target-key': 'b' === roman[romanIndex],
                missed: 'b' === missTypeKey,
              }"
              :style="missTypeKeyStyle['b']"
            >
              B
            </div>
            <div
              id="key-n"
              class="key"
              :class="{
                'target-key': 'n' === roman[romanIndex],
                missed: 'n' === missTypeKey,
              }"
              :style="missTypeKeyStyle['n']"
            >
              N
            </div>
            <div
              id="key-m"
              class="key"
              :class="{
                'target-key': 'm' === roman[romanIndex],
                missed: 'm' === missTypeKey,
              }"
              :style="missTypeKeyStyle['m']"
            >
              M
            </div>
            <div
              id="key-,"
              class="key"
              :class="{
                'target-key': ',' === roman[romanIndex],
                missed: ',' === missTypeKey,
              }"
              :style="missTypeKeyStyle[',']"
            >
              ,
            </div>
            <div
              id="key-."
              class="key"
              :class="{
                'target-key': '.' === roman[romanIndex],
                missed: '.' === missTypeKey,
              }"
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

      <div id="hand-container" v-if="phase !== 3">
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

      <div v-if="isLogin && phase === 3 && !canShowHistory" class="history-btn">
        <button class="btn btn-blue" @click="canShowHistory = true">
          履歴データ表示
        </button>
      </div>
      <div
        class="history-container"
        v-if="isLogin && phase === 3 && canShowHistory"
      >
        <p class="title">履歴データ</p>
        <div class="history-data">
          <table class="history-table">
            <thead>
              <tr>
                <th>WPM</th>
                <th>正答率</th>
                <th>ミスキー</th>
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
          <div class="history-graph">
            <HistoryChart
              :chartData="chartData"
              :options="chartOptions"
              :height="300"
            />
          </div>
        </div>
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
      </div>

      <div v-if="phase === 3" class="btn-wrapper">
        <button class="btn btn-green" @click="retry">もう一度</button>
        <button class="btn btn-gray" @click="hide">戻る</button>
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
  DEFAULT_QUESTION_COUNT,
} from "../util.js";
import { checkInputKey } from "../key.js";
import HistoryChart from "./HistoryChart.vue";
export default {
  components: {
    HistoryChart,
  },
  props: {
    categoryId: "",
    updateParentPage: null,
    initCategoryId: Function,
  },
  data() {
    return {
      questions: [],
      questionCount: "",
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
      missTypeKey: "",
      missTypeKeyHash: {},
      missTypeKeyStyle: {},
      histories: {},
      wpmStepSize: 50,
      perPage: 4,
      currentPage: 1,
      lastPage: "",
      range: 5, // 奇数
      startDot: false,
      endDot: false,
      chartData: {},
      chartOptions: {},
      audio: new Audio("/audio/beep.wav"),
      audioCheaked: false,
      canShowHistory: false,
      targetWpm: 200,
      limitTime: 0,
      remainingTime: 0,
      progress: 100,
      progressColor: "",
      intervalId: "",
      timeOutId: "",
      limitCheaked: false,
      wpmSelectOptions: [
        100, 125, 150, 175, 200, 225, 250, 275, 300, 325, 350, 375, 400, 425,
        500, 525, 550, 575, 600,
      ],
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
      const leftLittle = ["1", "q", "a", "z"];
      const char = this.roman[this.romanIndex];
      return leftLittle.includes(char);
    },
    isLeftRing() {
      const leftRing = ["2", "w", "s", "x"];
      const char = this.roman[this.romanIndex];
      return leftRing.includes(char);
    },
    isLeftMiddle() {
      const leftMiddle = ["3", "e", "d", "c"];
      const char = this.roman[this.romanIndex];
      return leftMiddle.includes(char);
    },
    isLeftIndex() {
      const leftIndex = ["4", "5", "r", "t", "f", "g", "v", "b"];
      const char = this.roman[this.romanIndex];
      return leftIndex.includes(char);
    },
    isRightIndex() {
      const rightIndex = ["6", "7", "y", "u", "h", "j", "n", "m"];
      const char = this.roman[this.romanIndex];
      return rightIndex.includes(char);
    },
    isRightMiddle() {
      const rightMiddle = ["8", "i", "k", ","];
      const char = this.roman[this.romanIndex];
      return rightMiddle.includes(char);
    },
    isRightRing() {
      const rightRing = ["9", "o", "l", "."];
      const char = this.roman[this.romanIndex];
      return rightRing.includes(char);
    },
    isRightLittle() {
      const rightLittle = ["0", "p"];
      const char = this.roman[this.romanIndex];
      return rightLittle.includes(char);
    },
    canPlayAudio() {
      return this.audioCheaked;
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
    missKeyResult() {
      let result = "";
      Object.keys(this.missTypeKeyHash).forEach(
        (key) => (result += key + "：" + this.missTypeKeyHash[key] + "　")
      );
      return result;
    },
  },
  methods: {
    hide() {
      this.clear();
      this.initCategoryId();
      this.$modal.hide("modal-typing");
    },
    start() {
      this.initQuestion();
      if (this.limitCheaked) {
        this.limitTimerStart();
      }
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
    retry() {
      this.getQuestions();
      this.clear();
    },
    showResult() {
      // 時間測定終了
      this.typeTime = performance.now() - this.typeTime;

      // ミスタイプキーの並び替え
      if (Object.keys(this.missTypeKeyHash).length > 0) {
        const pairs = Object.entries(this.missTypeKeyHash);
        pairs.sort((a, b) => {
          const aKey = a[0];
          const bKey = b[0];
          if (aKey < bKey) return -1;
          if (aKey > bKey) return 1;
          return 0;
        });
        this.missTypeKeyHash = Object.fromEntries(pairs);
      }

      // 結果集計
      this.wpm = Math.floor(
        (this.correctTypeCount / this.typeTime) * 1000 * 60
      );
      this.correctPercentage = Math.floor(
        (1 -
          this.missTypeCount / (this.correctTypeCount + this.missTypeCount)) *
          100
      );
      if (Number.isNaN(this.correctPercentage)) {
        this.correctPercentage = 0;
      }

      // ログイン時、データ更新と履歴データ作成
      if (this.isLogin) {
        this.updateUserInfo();
        this.createHistory();
        this.getHistory();
        // トップページの更新
        this.updateParentPage(1);
      }

      // 時間切れ終了時用クリア処理
      this.missTypeKey = "";
      this.roman[this.romanIndex] = "";

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
      this.missTypeKey = "";
      this.missTypeKeyHash = {};
      this.missTypeKeyStyle = {};
      this.histories = {};
      this.currentPage = 1;
      this.lastPage = "";
      this.startDot = false;
      this.endDot = false;
      this.chartData = {};
      this.chartOptions = {};
      this.canShowHistory = false;
      clearInterval(this.intervalId);
      clearTimeout(this.timeOutId);
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
          color: "#525151",
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
      let maxWpm = wpmData.reduce((a, b) => {
        return a > b ? a : b;
      });
      let minWpm = wpmData.reduce((a, b) => {
        return a < b ? a : b;
      });
      const maxWpmScale =
        Math.ceil(maxWpm / this.wpmStepSize) * this.wpmStepSize;
      const minWpmScale =
        (Math.ceil(minWpm / this.wpmStepSize) - 1) * this.wpmStepSize;
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
    async updateUserInfo() {
      const response = await axios
        .put("/api/user/" + this.userId, { typeCount: this.correctTypeCount })
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
          ? Object.keys(this.missTypeKeyHash).join(" ")
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
    async getQuestions() {
      const response = await axios
        .get("/api/question/category/" + this.categoryId)
        .catch((error) => error.response || error);

      if (response.status === INTERNAL_SERVER_ERROR) {
        this.$store.commit("error/setCode", response.status);
      } else {
        this.questions = response.data;
        if (Object.keys(this.questions).length < DEFAULT_QUESTION_COUNT) {
          this.questionCount = Object.keys(this.questions).length;
        } else {
          this.questionCount = DEFAULT_QUESTION_COUNT;
        }
      }
    },
    createRange(start, end) {
      const range = [];
      for (let i = start; i <= end; i++) {
        range.push(i);
      }
      return range;
    },
    createProgressBarColor(progressPercentage) {
      const rInitVal = 0;
      const gInitVal = 230;
      const bInitVal = 100;
      const r =
        (100 - progressPercentage) * 5 > 255
          ? 255
          : (100 - progressPercentage) * 5;
      const g =
        progressPercentage < 50
          ? gInitVal - (50 - progressPercentage) * 4
          : gInitVal;
      const b = bInitVal - (100 - progressPercentage);
      this.progressColor = "rgb(" + r + ", " + g + ", " + b + ")";
    },
    changeHistoryPage(page) {
      if (1 <= page && page <= this.lastPage) {
        this.currentPage = page;
        this.getHistory();
      }
    },
    limitTimerStart() {
      let typeCount = 0;
      for (let i = 0; i < this.questionCount; i++) {
        typeCount += this.questions[i].roman.length;
      }
      this.limitTime = ((60 * typeCount) / this.targetWpm) * 1000;
      this.remainingTime = this.limitTime;
      this.intervalId = setInterval(this.remainingTimeCountDown, 10, 10);
    },
    remainingTimeCountDown(n) {
      this.remainingTime -= n;
    },
    isActive(page) {
      return this.currentPage === page;
    },
    keyAction(e) {
      if (this.phase === 1) {
        if (e.code === "Space" && this.questionCount > 0) {
          // 3秒カウントhtml表示
          this.phase = 1.5;

          // 3秒後にスタート
          this.timeOutId = setTimeout(this.start, 3000);
        }
      } else if (this.phase === 2) {
        e.preventDefault();
        switch (checkInputKey(e.code, this.roman, this.romanIndex)) {
          case 1:
          case 2:
            this.missTypeKey = "";
            this.correctTypeCount++;
            this.romanIndex++;
            if (this.roman[this.romanIndex] === END_SYMBOL) {
              this.next();
              if (this.phase === 3) break;
              this.initQuestion();
            } else {
              this.displayRoman = "";
              this.displayInputedRoman = "";
              for (let i = this.romanIndex; i < this.roman.length - 1; i++) {
                this.displayRoman += this.roman[i];
              }
              for (let i = 0; i < this.romanIndex; i++) {
                this.displayInputedRoman += this.roman[i];
              }
            }
            break;
          case 0:
          case 3:
            //タイプミス時

            // ミス音声再生
            if (this.canPlayAudio) {
              this.audio.play();
            }

            // ミス回数カウント
            this.missTypeCount++;

            // ミスキーをセット
            this.missTypeKey = this.roman[this.romanIndex];

            // ミスタイプキーカウント
            if (this.missTypeKeyHash[this.missTypeKey]) {
              this.missTypeKeyHash[this.missTypeKey]++;
            } else {
              this.missTypeKeyHash[this.missTypeKey] = 1;
            }

            break;
          default:
            break;
        }
      }
    },
  },
  watch: {
    categoryId(val) {
      if (val !== "") {
        this.getQuestions();
      }
    },
    remainingTime(val) {
      if (this.phase === 3) {
        clearInterval(this.intervalId);
        return;
      }
      if (val < 0) {
        clearInterval(this.intervalId);
        this.showResult();
      } else {
        this.progress = Math.floor((this.remainingTime / this.limitTime) * 100);
        this.createProgressBarColor(this.progress);
      }
    },
  },
};
</script>