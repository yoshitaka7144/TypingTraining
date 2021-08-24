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

      // トップページへ
      this.$router.push("/");
    },
    async register() {
      await this.$store.dispatch("auth/register", this.registerForm);

      // トップページへ
      this.$router.push("/");
    },
  },
};
</script>
