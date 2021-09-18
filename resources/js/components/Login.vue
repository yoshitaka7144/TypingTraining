<template>
  <div id="auth" class="contents">
    <ul class="tab">
      <li
        class="tab-item"
        :class="{ 'tab-item-active': tab === 1 }"
        @click="tab = 1"
      >
        ログイン
      </li>
      <li
        class="tab-item"
        :class="{ 'tab-item-active': tab === 2 }"
        @click="tab = 2"
      >
        新規登録
      </li>
    </ul>
    <div class="panel" v-show="tab === 1">
      <form @submit.prevent="login">
        <div v-if="loginErrors" class="errors-area">
          <ul v-if="loginErrors.name">
            <li v-for="msg in loginErrors.name" :key="msg">{{ msg }}</li>
          </ul>
          <ul v-if="loginErrors.password">
            <li v-for="msg in loginErrors.password" :key="msg">{{ msg }}</li>
          </ul>
        </div>
        <label for="login-name">ユーザー名</label>
        <input type="text" id="login-name" v-model="loginForm.name" />
        <p class="error" v-if="loginNameError">{{ loginNameError }}</p>
        <label for="login-password">パスワード</label>
        <input
          type="password"
          id="login-password"
          v-model="loginForm.password"
        />
        <p class="error" v-if="loginPasswordError">{{ loginPasswordError }}</p>
        <div class="btn-wrapper">
          <button type="submit" class="btn btn-green">ログイン</button>
        </div>
      </form>
    </div>
    <div class="panel" v-show="tab === 2">
      <form @submit.prevent="register">
        <div v-if="registerErrors" class="errors-area">
          <ul v-if="registerErrors.name">
            <li v-for="msg in registerErrors.name" :key="msg">{{ msg }}</li>
          </ul>
          <ul v-if="registerErrors.password">
            <li v-for="msg in registerErrors.password" :key="msg">{{ msg }}</li>
          </ul>
          <ul v-if="registerErrors.password_confirmation">
            <li v-for="msg in registerErrors.password_confirmation" :key="msg">
              {{ msg }}
            </li>
          </ul>
        </div>
        <label for="register-name">ユーザー名</label>
        <input
          type="text"
          id="register-name"
          v-model="registerForm.name"
          :placeholder="registerNamePlaceholder"
        />
        <p class="error" v-if="registerNameError">{{ registerNameError }}</p>
        <label for="register-password">パスワード</label>
        <input
          type="password"
          id="register-password"
          v-model="registerForm.password"
          :placeholder="registerPasswordPlaceholder"
        />
        <p class="error" v-if="registerPasswordError">
          {{ registerPasswordError }}
        </p>
        <label for="register-password-confirmation">パスワード確認</label>
        <input
          type="password"
          id="register-password-confirmation"
          v-model="registerForm.password_confirmation"
          :placeholder="registerPasswordConfirmationPlaceholder"
        />
        <p class="error" v-if="registerPasswordConfirmationError">
          {{ registerPasswordConfirmationError }}
        </p>
        <div class="btn-wrapper">
          <button type="submit" class="btn btn-blue">登録</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import {
  LOGIN_NAME_ERROR_REQUIRE,
  LOGIN_PASSWORD_ERROR_REQUIRE,
  REGISTER_NAME_MAX_NUMBER,
  REGISTER_NAME_ERROR_REQUIRE,
  REGISTER_NAME_ERROR_LIMIT,
  REGISTER_PASSWORD_MIN_NUMBER,
  REGISTER_PASSWORD_ERROR_REQUIRE,
  REGISTER_PASSWORD_ERROR_LIMIT,
  REGISTER_PASSWORD_CONFIRMATION_ERROR_REQUIRE,
  REGISTER_PASSWORD_CONFIRMATION_ERROR_INCORRECT,
} from "../util";

export default {
  data() {
    return {
      // ページタブ切替
      tab: 1,
      // ログインユーザー名エラーメッセージ
      loginNameError: "",
      // ログインパスワードエラーメッセージ
      loginPasswordError: "",
      // ログインフォーム
      loginForm: {
        // ユーザー名
        name: "",
        // パスワード
        password: "",
      },
      // 登録ユーザー名入力フォーム用プレースホルダ
      registerNamePlaceholder:
        REGISTER_NAME_MAX_NUMBER + "文字以内で入力して下さい。",
      // 登録ユーザー名エラーメッセージ
      registerNameError: "",
      // 登録パスワード用プレースホルダ
      registerPasswordPlaceholder:
        "半角英数字" +
        REGISTER_PASSWORD_MIN_NUMBER +
        "文字以上で入力して下さい。",
      // 登録パスワードエラーメッセージ
      registerPasswordError: "",
      // 登録パスワード確認用プレースホルダ
      registerPasswordConfirmationPlaceholder: "パスワードを入力して下さい。",
      // 登録パスワード確認エラーメッセージ
      registerPasswordConfirmationError: "",
      // 登録フォーム
      registerForm: {
        // ユーザー名
        name: "",
        // パスワード
        password: "",
        // パスワード確認
        password_confirmation: "",
      },
    };
  },
  methods: {
    // ログイン
    async login() {
      await this.$store.dispatch("auth/login", this.loginForm);

      if (this.apiStatus) {
        // トップページへ
        this.$router.push("/");
      }
    },
    // ユーザ新規登録
    async register() {
      await this.$store.dispatch("auth/register", this.registerForm);

      if (this.apiStatus) {
        // トップページへ
        this.$router.push("/");
      }
    },
    // エラーメッセージクリア
    clearError() {
      this.$store.commit("auth/setLoginErrorMessages", null);
      this.$store.commit("auth/setRegisterErrorMessages", null);
    },
  },
  computed: {
    // api可否
    apiStatus() {
      return this.$store.state.auth.apiStatus;
    },
    // ログイン時のエラーメッセージ
    loginErrors() {
      return this.$store.state.auth.loginErrorMessages;
    },
    // 登録時のエラーメッセージ
    registerErrors() {
      return this.$store.state.auth.registerErrorMessages;
    },
  },
  created() {
    this.clearError();
  },
  watch: {
    // ログイン：ユーザー名入力時
    "loginForm.name": function (val) {
      if (val.length < 1) {
        this.loginNameError = LOGIN_NAME_ERROR_REQUIRE;
      } else {
        this.loginNameError = "";
      }
    },
    // ログイン：パスワード入力時
    "loginForm.password": function (val) {
      if (val.length < 1) {
        this.loginPasswordError = LOGIN_PASSWORD_ERROR_REQUIRE;
      } else {
        this.loginPasswordError = "";
      }
    },
    // ユーザー新規登録：ユーザー名入力時
    "registerForm.name": function (val) {
      if (val.length < 1) {
        this.registerNameError = REGISTER_NAME_ERROR_REQUIRE;
      } else if (val.length > REGISTER_NAME_MAX_NUMBER) {
        this.registerNameError = REGISTER_NAME_ERROR_LIMIT;
      } else {
        this.registerNameError = "";
      }
    },
    // ユーザー新規登録：パスワード入力時
    "registerForm.password": function (val) {
      const regexp = new RegExp(
        "^[a-zA-Z0-9]{" + REGISTER_PASSWORD_MIN_NUMBER + ",}$"
      );
      if (val.length < 1) {
        this.registerPasswordError = REGISTER_PASSWORD_ERROR_REQUIRE;
      } else if (!val.match(regexp)) {
        this.registerPasswordError = REGISTER_PASSWORD_ERROR_LIMIT;
      } else {
        this.registerPasswordError = "";
      }

      if (val == this.registerForm.password_confirmation) {
        this.registerPasswordConfirmationError = "";
      } else {
        this.registerPasswordConfirmationError =
          REGISTER_PASSWORD_CONFIRMATION_ERROR_INCORRECT;
      }
    },
    // ユーザー新規登録：パスワード確認入力時
    "registerForm.password_confirmation": function (val) {
      if (val.length < 1) {
        this.registerPasswordConfirmationError =
          REGISTER_PASSWORD_CONFIRMATION_ERROR_REQUIRE;
      } else if (val !== this.registerForm.password) {
        this.registerPasswordConfirmationError =
          REGISTER_PASSWORD_CONFIRMATION_ERROR_INCORRECT;
      } else {
        this.registerPasswordConfirmationError = "";
      }
    },
  },
};
</script>
