import { createApp } from "vue/dist/vue.esm-bundler"
import App from './App.vue'
import router from './router'
import Pusher from 'pusher-js'

window.Pusher = Pusher

createApp(App)
    .use(router)
    .mount('#admin-main')
