<template>
  <div class="header-container">
    <div class="header">
      <div id="logo">
        <router-link v-bind:to="{ name: 'index' }">
          TypingTraining
        </router-link>
      </div>
      <nav id="pc-nav">
        <ul>
          <li v-if="isLogin">
            <router-link v-bind:to="{ name: 'question' }">
              問題編集
            </router-link>
          </li>
          <li v-if="!isLogin">
            <router-link v-bind:to="{ name: 'login' }">
              ログイン/新規登録
            </router-link>
          </li>
          <li v-if="isLogin" @click="logout"><a>ログアウト</a></li>
        </ul>
      </nav>
      <nav id="sp-nav" v-show="isShownSpNav">
        <ul>
          <li @click="toggleSpNav">
            <router-link v-bind:to="{ name: 'index' }">
              トップページ
            </router-link>
          </li>
          <li v-if="isLogin" @click="toggleSpNav">
            <router-link v-bind:to="{ name: 'question' }">
              問題編集
            </router-link>
          </li>
          <li v-if="!isLogin" @click="toggleSpNav">
            <router-link v-bind:to="{ name: 'login' }">
              ログイン/新規登録
            </router-link>
          </li>
          <li
            v-if="isLogin"
            @click="
              toggleSpNav();
              logout();
            "
          >
            <a>ログアウト</a>
          </li>
          <li @click="toggleSpNav">
            <span>閉じる</span>
          </li>
        </ul>
      </nav>
      <div id="hamburger" @click="toggleSpNav">
        <span></span>
      </div>
    </div>
  </div>
</template>
 
<script>
export default {
  data() {
    return {
      isShownSpNav: false, // スマホ用ナビ表示フラグ
    };
  },
  methods: {
    // ナビ表示
    toggleSpNav() {
      this.isShownSpNav = !this.isShownSpNav;
    },
    // ログアウト
    async logout() {
      await this.$store.dispatch("auth/logout");

      if (this.apiStatus) {
        this.$router.push("/", function () {});
      }
    },
  },
  computed: {
    // apiステータス
    apiStatus() {
      return this.$store.state.auth.apiStatus;
    },
    // ログイン状態
    isLogin() {
      return this.$store.getters["auth/isLogin"];
    },
    // ユーザー名
    username() {
      return this.$store.getters["auth/username"];
    },
  },
};
</script>