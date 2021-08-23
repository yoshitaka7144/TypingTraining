<template>
  <div class="header-container">
    <div class="header">
      <div id="logo">
        <a href="./">TypingTraining</a>
      </div>
      <nav id="pc-nav">
        <ul>
          <li>
            <router-link v-bind:to="{ name: 'question' }">
              問題編集
            </router-link>
          </li>
          <li>
            <router-link v-bind:to="{ name: 'login' }">
              ログイン/新規登録
            </router-link>
          </li>
          <li @click="logout">ログアウト</li>
        </ul>
      </nav>
      <nav id="sp-nav" v-show="isShownSpNav">
        <ul>
          <li @click="toggleSpNav">
            <router-link v-bind:to="{ name: 'question' }">
              問題編集
            </router-link>
          </li>
          <li @click="toggleSpNav">
            <router-link v-bind:to="{ name: 'login' }">
              ログイン/新規登録
            </router-link>
          </li>
          <li @click="toggleSpNav(); logout()">ログアウト</li>
          <li @click="toggleSpNav">
            <span><i class="fas fa-times"></i>閉じる</span>
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
      isShownSpNav: false
    };
  },
  methods: {
    toggleSpNav() {
      this.isShownSpNav = !this.isShownSpNav;
    },
    logout() {
      axios.post("/api/logout")
        .then((res) => {
          console.log(res);
          this.$router.push("/");
        })
        .catch(function (error) {
          console.log(error);
        });
    },
  },
};
</script>