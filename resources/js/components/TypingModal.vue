<template>
  <modal
    class="modal"
    name="typing-modal"
    :resizable="true"
    :clickToClose="false"
    :width="'80%'"
    :height="'70%'"
  >
    <button class="btn btn-red" @click="hide">close</button>

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

    <div id="keyboard-container" v-if="phase === 1 || phase === 2">
      <div id="keyboard">
        <div class="row">
          <div class="key"></div>
          <div
            id="key-1"
            class="key"
            :class="{ 'target-key': '1' === roman[romanIndex] }"
          >
            1
          </div>
          <div
            id="key-2"
            class="key"
            :class="{ 'target-key': '2' === roman[romanIndex] }"
          >
            2
          </div>
          <div
            id="key-3"
            class="key"
            :class="{ 'target-key': '3' === roman[romanIndex] }"
          >
            3
          </div>
          <div
            id="key-4"
            class="key"
            :class="{ 'target-key': '4' === roman[romanIndex] }"
          >
            4
          </div>
          <div
            id="key-5"
            class="key"
            :class="{ 'target-key': '5' === roman[romanIndex] }"
          >
            5
          </div>
          <div
            id="key-6"
            class="key"
            :class="{ 'target-key': '6' === roman[romanIndex] }"
          >
            6
          </div>
          <div
            id="key-7"
            class="key"
            :class="{ 'target-key': '7' === roman[romanIndex] }"
          >
            7
          </div>
          <div
            id="key-8"
            class="key"
            :class="{ 'target-key': '8' === roman[romanIndex] }"
          >
            8
          </div>
          <div
            id="key-9"
            class="key"
            :class="{ 'target-key': '9' === roman[romanIndex] }"
          >
            9
          </div>
          <div
            id="key-0"
            class="key"
            :class="{ 'target-key': '0' === roman[romanIndex] }"
          >
            0
          </div>
          <div class="key"></div>
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
          >
            Q
          </div>
          <div
            id="key-w"
            class="key"
            :class="{ 'target-key': 'w' === roman[romanIndex] }"
          >
            W
          </div>
          <div
            id="key-e"
            class="key"
            :class="{ 'target-key': 'e' === roman[romanIndex] }"
          >
            E
          </div>
          <div
            id="key-r"
            class="key"
            :class="{ 'target-key': 'r' === roman[romanIndex] }"
          >
            R
          </div>
          <div
            id="key-t"
            class="key"
            :class="{ 'target-key': 't' === roman[romanIndex] }"
          >
            T
          </div>
          <div
            id="key-y"
            class="key"
            :class="{ 'target-key': 'y' === roman[romanIndex] }"
          >
            Y
          </div>
          <div
            id="key-u"
            class="key"
            :class="{ 'target-key': 'u' === roman[romanIndex] }"
          >
            U
          </div>
          <div
            id="key-i"
            class="key"
            :class="{ 'target-key': 'i' === roman[romanIndex] }"
          >
            I
          </div>
          <div
            id="key-o"
            class="key"
            :class="{ 'target-key': 'o' === roman[romanIndex] }"
          >
            O
          </div>
          <div
            id="key-p"
            class="key"
            :class="{ 'target-key': 'p' === roman[romanIndex] }"
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
          >
            A
          </div>
          <div
            id="key-s"
            class="key"
            :class="{ 'target-key': 's' === roman[romanIndex] }"
          >
            S
          </div>
          <div
            id="key-d"
            class="key"
            :class="{ 'target-key': 'd' === roman[romanIndex] }"
          >
            D
          </div>
          <div
            id="key-f"
            class="key"
            :class="{ 'target-key': 'f' === roman[romanIndex] }"
          >
            F
          </div>
          <div
            id="key-g"
            class="key"
            :class="{ 'target-key': 'g' === roman[romanIndex] }"
          >
            G
          </div>
          <div
            id="key-h"
            class="key"
            :class="{ 'target-key': 'h' === roman[romanIndex] }"
          >
            H
          </div>
          <div
            id="key-j"
            class="key"
            :class="{ 'target-key': 'j' === roman[romanIndex] }"
          >
            J
          </div>
          <div
            id="key-k"
            class="key"
            :class="{ 'target-key': 'k' === roman[romanIndex] }"
          >
            K
          </div>
          <div
            id="key-l"
            class="key"
            :class="{ 'target-key': 'l' === roman[romanIndex] }"
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
          >
            Z
          </div>
          <div
            id="key-x"
            class="key"
            :class="{ 'target-key': 'x' === roman[romanIndex] }"
          >
            X
          </div>
          <div
            id="key-c"
            class="key"
            :class="{ 'target-key': 'c' === roman[romanIndex] }"
          >
            C
          </div>
          <div
            id="key-v"
            class="key"
            :class="{ 'target-key': 'v' === roman[romanIndex] }"
          >
            V
          </div>
          <div
            id="key-b"
            class="key"
            :class="{ 'target-key': 'b' === roman[romanIndex] }"
          >
            B
          </div>
          <div
            id="key-n"
            class="key"
            :class="{ 'target-key': 'n' === roman[romanIndex] }"
          >
            N
          </div>
          <div
            id="key-m"
            class="key"
            :class="{ 'target-key': 'm' === roman[romanIndex] }"
          >
            M
          </div>
          <div
            id="key-,"
            class="key"
            :class="{ 'target-key': ',' === roman[romanIndex] }"
          >
            ,
          </div>
          <div
            id="key-."
            class="key"
            :class="{ 'target-key': '.' === roman[romanIndex] }"
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

    <div class="" v-if="phase === 3">
      <p>結果画面</p>
      <p>{{ typeCount }}</p>
      <p>{{ missTypeCount }}</p>
      <p>{{ typeTime }}</p>
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
export default {
  props: {
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
      typeCount: 0,
      missTypeCount: 0,
      typeTime: 0,
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

      // 色々結果集計処理

      // ログイン時、データ更新と履歴データ作成
      if (this.isLogin) {
        this.updateUserInfo();
        //this.createHistory();
      }

      // 結果画面表示
      this.phase = 3;
    },
    clear() {
      this.roman = [];
      this.currentCount = 0;
      this.phase = 1;
      this.typeCount = 0;
      this.missTypeCount = 0;
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
    async updateUserInfo() {
      var response = await axios
        .put("/api/user/" + this.userId, { typeCount: this.typeCount })
        .catch((error) => error.response || error);

      if (response.status === OK) {
      } else if (response.status === UNPROCESSABLE_ENTITY) {
      } else {
        this.$store.commit("error/setCode", response.status);
      }
    },
    async createHistory() {
      var params = {};
      var response = await axios
        .post("/api/history", params)
        .catch((error) => error.response || error);

      if (response.status === OK) {
      } else if (response.status === UNPROCESSABLE_ENTITY) {
      } else {
        this.$store.commit("error/setCode", response.status);
      }
    },
    keyAction(e) {
      if (this.phase === 2) {
        e.preventDefault();
        switch (checkInputKey(e.code, this.roman, this.romanIndex)) {
          case 1:
          case 2:
            this.typeCount++;
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
            this.missTypeCount++;

            break;
          default:
            break;
        }
      }
    },
  },
};
</script>