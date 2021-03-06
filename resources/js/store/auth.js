import { OK, CREATED, UNPROCESSABLE_ENTITY } from "../util";

const state = {
  user: null,
  apiStatus: null,
  loginErrorMessages: null,
  registerErrorMessages: null
}

const getters = {
  isLogin: state => !!state.user,
  userId: state => state.user ? state.user.id : "",
  userName: state => state.user ? state.user.name : "",
  userRole: state => state.user ? state.user.role : "",
}

const mutations = {
  setUser(state, user) {
    state.user = user;
  },
  setApiStatus(state, status) {
    state.apiStatus = status;
  },
  setLoginErrorMessages(state, messages) {
    state.loginErrorMessages = messages;
  },
  setRegisterErrorMessages(state, messages) {
    state.registerErrorMessages = messages;
  }
}

const actions = {

  // ユーザー登録
  async register(context, data) {
    context.commit("setApiStatus", null);
    const response = await axios.post("/api/register", data).catch(error => error.response || error);

    if (response.status === CREATED) {
      context.commit("setApiStatus", true);
      context.commit("setUser", response.data);
    } else {
      context.commit("setApiStatus", false);
      if (response.status === UNPROCESSABLE_ENTITY) {
        context.commit("setRegisterErrorMessages", response.data.errors);
      } else {
        context.commit("error/setCode", response.status, { root: true });
      }
    }
  },

  // ログイン
  async login(context, data) {
    context.commit("setApiStatus", null);
    const response = await axios.post("/api/login", data).catch(error => error.response || error);

    if (response.status === OK) {
      context.commit("setApiStatus", true);
      context.commit("setUser", response.data);
    } else {
      context.commit("setApiStatus", false);
      if (response.status === UNPROCESSABLE_ENTITY) {
        context.commit("setLoginErrorMessages", response.data.errors);
      } else {
        context.commit("error/setCode", response.status, { root: true });
      }
    }
  },

  // ログアウト
  async logout(context) {
    context.commit("setApiStatus", null);
    const response = await axios.post("/api/logout").catch(error => error.response || error);

    if (response.status === OK) {
      context.commit("setApiStatus", true);
      context.commit("setUser", null);
    } else {
      context.commit("setApiStatus", false);
      context.commit("error/setCode", response.status, { root: true });
    }

  },

  // ログインユーザー確認
  async currentUser(context) {
    context.commit("setApiStatus", null);
    const response = await axios.get("/api/user").catch(error => error.response || error);
    const user = response.data || null;

    if (response.status === OK) {
      context.commit("setApiStatus", true);
      context.commit("setUser", user);
    } else {
      context.commit("setApiStatus", false);
      context.commit("error/setCode", response.status, { root: true });
    }
  }

}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}