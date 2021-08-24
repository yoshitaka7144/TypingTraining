import Vue from "vue";
import VueRouter from "vue-router";
import store from './store';
import IndexComponent from "./components/IndexComponent";
import LoginComponent from "./components/LoginComponent";
import QuestionComponent from "./components/QuestionComponent";
import QuestionCreateComponent from "./components/QuestionCreateComponent";
import NotFoundComponent from "./components/NotFoundComponent";

Vue.use(VueRouter);

const router = new VueRouter({
  mode: "history",
  routes: [
    {
      path: "/",
      name: "index",
      component: IndexComponent
    },
    {
      path: "/login",
      name: "login",
      component: LoginComponent,
      beforeEnter(to, from, next) {
        if (store.getters["auth/isLogined"]) {
          next("/");
        } else {
          next();
        }
      }
    },
    {
      path: "/question",
      name: "question",
      component: QuestionComponent,
      beforeEnter(to, from, next) {
        if (store.getters["auth/isLogined"]) {
          next();
        } else {
          next("/");
        }
      }
    },
    {
      path: "/question/create",
      name: "question.create",
      component: QuestionCreateComponent,
      beforeEnter(to, from, next) {
        if (store.getters["auth/isLogined"]) {
          next();
        } else {
          next("/");
        }
      }
    },
    {
      path: "*",
      name: "notFound",
      component: NotFoundComponent
    },
  ]
});

export default router