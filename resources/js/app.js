import Vue from "vue";
import VModal from 'vue-js-modal';
import store from "./store";
import router from "./router";
import App from "./components/App.vue"

require('./bootstrap');
require("./fontawesome");
window.Vue = require('vue');
Vue.use(VModal);

async function createApp() {
    await store.dispatch('auth/currentUser')

    new Vue({
        el: '#app',
        router,
        store,
        components: {
            App
        },
        template: "<App />"
    })
}

createApp();
