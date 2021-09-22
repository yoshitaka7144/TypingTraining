<template>
  <modal
    class="modal-typing-test"
    name="modal-typing-test"
    :clickToClose="false"
    :maxWidth="1000"
    :width="'95%'"
    :height="'auto'"
    :scrollable="true"
    :adaptive="true"
    @before-open="beforeOpen"
  >
    <div class="modal-header">
      <font-awesome-icon :icon="['fas', 'times']" class="icon" @click="hide" />
    </div>
    <div class="modal-main">
      <div class="display-question">
        <p class="display-text">{{ displayText }}</p>
        <p class="display-kana">{{ displayKana }}</p>
        <p class="display-roman">
          <span class="inputed">{{ displayInputedRoman }}</span
          >{{ displayRoman }}
        </p>
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
            <div id="key-space" class="key"></div>
            <div class="key"></div>
            <div class="key"></div>
            <div class="key"></div>
            <div class="key"></div>
            <div class="key"></div>
            <div class="key"></div>
          </div>
        </div>
      </div>

      <div id="hand-container">
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
    </div>
  </modal>
</template>
<script>
import { END_SYMBOL, INTERNAL_SERVER_ERROR } from "../util.js";
import { checkInputKey } from "../key.js";
export default {
  props: {
    testModalOptions: {
      questionId: "",
    },
  },
  data() {
    return {
      // 現在の問題データ
      currentQuestion: [],
      // タイピング文字データ
      roman: [],
      romanIndex: 0,
      // 問題表示用テキスト
      displayText: "",
      // かな表示用テキスト
      displayKana: "",
      // タイピング文字表示用テキスト
      displayRoman: "",
      // 入力済みタイピング文字テキスト
      displayInputedRoman: "",
      // ミスタイプキー
      missTypeKey: "",
    };
  },
  computed: {
    // キータイプが左手小指
    isLeftLittle() {
      const leftLittle = ["1", "q", "a", "z"];
      const char = this.roman[this.romanIndex];
      return leftLittle.includes(char);
    },
    // キータイプが左手薬指
    isLeftRing() {
      const leftRing = ["2", "w", "s", "x"];
      const char = this.roman[this.romanIndex];
      return leftRing.includes(char);
    },
    // キータイプが左手中指
    isLeftMiddle() {
      const leftMiddle = ["3", "e", "d", "c"];
      const char = this.roman[this.romanIndex];
      return leftMiddle.includes(char);
    },
    // キータイプが左手人差し指
    isLeftIndex() {
      const leftIndex = ["4", "5", "r", "t", "f", "g", "v", "b"];
      const char = this.roman[this.romanIndex];
      return leftIndex.includes(char);
    },
    // キータイプが右手人差し指
    isRightIndex() {
      const rightIndex = ["6", "7", "y", "u", "h", "j", "n", "m"];
      const char = this.roman[this.romanIndex];
      return rightIndex.includes(char);
    },
    // キータイプが右手中指
    isRightMiddle() {
      const rightMiddle = ["8", "i", "k", ","];
      const char = this.roman[this.romanIndex];
      return rightMiddle.includes(char);
    },
    // キータイプが右手薬指
    isRightRing() {
      const rightRing = ["9", "o", "l", "."];
      const char = this.roman[this.romanIndex];
      return rightRing.includes(char);
    },
    // キータイプが右手小指
    isRightLittle() {
      const rightLittle = ["0", "p"];
      const char = this.roman[this.romanIndex];
      return rightLittle.includes(char);
    },
  },
  methods: {
    // モーダル開く前の処理
    async beforeOpen() {
      // keydownイベントに処理を設定
      window.addEventListener("keydown", this.keyAction);
      await this.getQuestion();
      this.initQuestion();
    },
    // モーダルウィンドウ閉じる
    hide() {
      // keydownイベントに設定した処理を削除
      window.removeEventListener("keydown", this.keyAction);
      this.clear();
      this.$modal.hide("modal-typing-test");
    },
    // クリア
    clear() {
      this.roman = [];
      this.currentQuestion = [];
      this.missTypeKey = "";
      this.romanIndex = 0;
      this.displayText = "";
      this.displayKana = "";
      this.displayRoman = "";
      this.displayInputedRoman = "";
    },
    // 問題表示初期化
    initQuestion() {
      this.roman = [];
      this.romanIndex = 0;
      this.roman = this.currentQuestion.roman.split("");
      this.roman.push(END_SYMBOL);
      this.displayText = this.currentQuestion.text;
      this.displayKana = this.currentQuestion.kana;
      this.displayRoman = this.currentQuestion.roman;
      this.displayInputedRoman = "";
    },
    // 問題取得
    async getQuestion() {
      const response = await axios
        .get("/api/question/" + this.testModalOptions.questionId)
        .catch((error) => error.response || error);

      if (response.status === INTERNAL_SERVER_ERROR) {
        this.$store.commit("error/setCode", response.status);
      } else {
        this.currentQuestion = response.data;
      }
    },
    // キータイプ処理
    keyAction(e) {
      // キーの処理をキャンセル
      e.preventDefault();

      // 入力キー判定処理
      switch (checkInputKey(e.code, this.roman, this.romanIndex)) {
        case 1:
        case 2:
          // 正解のタイプ時
          this.missTypeKey = "";
          // 次のタイピング文字へ進める
          this.romanIndex++;
          if (this.roman[this.romanIndex] === END_SYMBOL) {
            // 設定された最終文字に達したとき
            // 閉じる
            this.hide();
          } else {
            this.displayRoman = "";
            this.displayInputedRoman = "";
            // 表示文字列
            for (let i = this.romanIndex; i < this.roman.length - 1; i++) {
              this.displayRoman += this.roman[i];
            }
            // 入力済み表示文字列
            for (let i = 0; i < this.romanIndex; i++) {
              this.displayInputedRoman += this.roman[i];
            }
          }
          break;
        case 0:
        case 3:
          //タイプミス時
          // ミスキーをセット
          this.missTypeKey = this.roman[this.romanIndex];
          break;
        default:
          break;
      }
    },
  },
};
</script>