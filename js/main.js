import Vue from 'vue';
import App from './App.vue'
import store from './store'
import { router } from './router'
import axios from 'axios'
import 'materialize-css/dist/css/materialize.min.css'

Vue.prototype.$axios = axios
Vue.config.productionTip = false

new Vue({
    router,
    store,
    el: '#app',
    render: h => h(App),

    created() {
        this.$store.dispatch('loadProjects')
        this.$store.dispatch('getAboutMePageContent')
    },

    methods: {
        isAuth() {
            return portfolio_globals.is_auth == 1
        }
    },
});