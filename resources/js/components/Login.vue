<template>
  <div class="auth-form">
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
        <div v-if="loginErrors" class="errors">
          <ul v-if="loginErrors.name">
            <li v-for="msg in loginErrors.name" :key="msg">{{ msg }}</li>
          </ul>
          <ul v-if="loginErrors.password">
            <li v-for="msg in loginErrors.password" :key="msg">{{ msg }}</li>
          </ul>
        </div>
        <input type="text" id="login-name" v-model="loginForm.name" />
        <p class="error" v-if="loginNameError">{{ loginNameError }}</p>
        <input
          type="password"
          id="login-password"
          v-model="loginForm.password"
        />
        <p class="error" v-if="loginPasswordError">{{ loginPasswordError }}</p>
        <button type="submit">ログイン</button>
      </form>
    </div>
    <div class="panel" v-show="tab === 2">
      <form @submit.prevent="register">
        <div v-if="registerErrors" class="errors">
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
        <input type="text" id="register-name" v-model="registerForm.name" />
        <p class="error" v-if="registerNameError">{{ registerNameError }}</p>
        <input
          type="password"
          id="register-password"
          v-model="registerForm.password"
        />
        <p class="error" v-if="registerPasswordError">
          {{ registerPasswordError }}
        </p>
        <input
          type="password"
          id="register-password-confirm"
          v-model="registerForm.password_confirmation"
        />
        <p class="error" v-if="registerPasswordConfirmationError">
          {{ registerPasswordConfirmationError }}
        </p>
        <button type="submit">登録</button>
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
      tab: 1,
      loginNameError: "",
      loginPasswordError: "",
      loginForm: {
        name: "",
        password: "",
      },
      registerNameError: "",
      registerPasswordError: "",
      registerPasswordConfirmationError: "",
      registerForm: {
        name: "",
        password: "",
        password_confirmation: "",
      },
    };
  },
  methods: {
    async login() {
      await this.$store.dispatch("auth/login", this.loginForm);

      if (this.apiStatus) {
        // トップページへ
        this.$router.push("/");
      }
    },
    async register() {
      await this.$store.dispatch("auth/register", this.registerForm);

      if (this.apiStatus) {
        // トップページへ
        this.$router.push("/");
      }
    },
    clearError() {
      this.$store.commit("auth/setLoginErrorMessages", null);
      this.$store.commit("auth/setRegisterErrorMessages", null);
    },
  },
  computed: {
    apiStatus() {
      return this.$store.state.auth.apiStatus;
    },
    loginErrors() {
      return this.$store.state.auth.loginErrorMessages;
    },
    registerErrors() {
      return this.$store.state.auth.registerErrorMessages;
    },
  },
  created() {
    this.clearError();
  },
  watch: {
    "loginForm.name": function (val) {
      if (val.length < 1) {
        this.loginNameError = LOGIN_NAME_ERROR_REQUIRE;
      } else {
        this.loginNameError = "";
      }
    },
    "loginForm.password": function (val) {
      if (val.length < 1) {
        this.loginPasswordError = LOGIN_PASSWORD_ERROR_REQUIRE;
      } else {
        this.loginPasswordError = "";
      }
    },
    "registerForm.name": function (val) {
      if (val.length < 1) {
        this.registerNameError = REGISTER_NAME_ERROR_REQUIRE;
      } else if (val.length > REGISTER_NAME_MAX_NUMBER) {
        this.registerNameError = REGISTER_NAME_ERROR_LIMIT;
      } else {
        this.registerNameError = "";
      }
    },
    "registerForm.password": function (val) {
      var regexp = new RegExp(
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
