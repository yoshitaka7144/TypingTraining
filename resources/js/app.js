import Vue from "vue";
import store from "./store";
import router from "./router";
import App from "./components/App.vue"

require('./bootstrap');
window.Vue = require('vue');

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
