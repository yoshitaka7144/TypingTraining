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
        <input
          type="password"
          id="login-password"
          v-model="loginForm.password"
        />
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
        <input
          type="password"
          id="register-password"
          v-model="registerForm.password"
        />
        <input
          type="password"
          id="register-password-confirm"
          v-model="registerForm.password_confirmation"
        />
        <button type="submit">登録</button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      tab: 1,
      loginForm: {
        name: "",
        password: "",
      },
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
};
</script>
