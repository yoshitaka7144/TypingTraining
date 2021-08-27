import Vue from "vue";
import VueRouter from "vue-router";
import store from './store';
import Index from "./components/Index";
import Login from "./components/Login";
import Question from "./components/Question";
import QuestionCreate from "./components/QuestionCreate";
import QuestionEdit from "./components/QuestionEdit";
import SystemError from "./components/SystemError";
import NotFound from "./components/NotFound";

Vue.use(VueRouter);

const router = new VueRouter({
  mode: "history",
  routes: [
    {
      path: "/",
      name: "index",
      component: Index
    },
    {
      path: "/login",
      name: "login",
      component: Login,
      beforeEnter(to, from, next) {
        if (store.getters["auth/isLogin"]) {
          next("/");
        } else {
          next();
        }
      }
    },
    {
      path: "/question",
      name: "question",
      component: Question,
      beforeEnter(to, from, next) {
        if (store.getters["auth/isLogin"]) {
          next();
        } else {
          next("/");
        }
      }
    },
    {
      path: "/question/create",
      name: "question.create",
      component: QuestionCreate,
      beforeEnter(to, from, next) {
        if (store.getters["auth/isLogin"]) {
          next();
        } else {
          next("/");
        }
      }
    },
    {
      path: "/question/:questionId/edit",
      name: "question.edit",
      component: QuestionEdit,
      props: true,
      beforeEnter(to, from, next) {
        if (store.getters["auth/isLogin"]) {
          next();
        } else {
          next("/");
        }
      }
    },
    {
      path: "/500",
      name: "systemError",
      component: SystemError
    },
    {
      path: "*",
      name: "notFound",
      component: NotFound
    },
  ]
});

export default router