import Vue from "vue";
import VModal from 'vue-js-modal';
import store from "./store";
import router from "./router";
import App from "./components/App.vue";
import { library } from '@fortawesome/fontawesome-svg-core';
import { faCaretUp, faCaretDown, faAngleDoubleLeft, faAngleDoubleRight, faTimes } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

require('./bootstrap');
window.Vue = require('vue');
Vue.use(VModal);

library.add(faCaretUp, faCaretDown, faAngleDoubleLeft, faAngleDoubleRight, faTimes);
Vue.component('font-awesome-icon', FontAwesomeIcon);

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
