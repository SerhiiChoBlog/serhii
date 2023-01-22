import { createApp } from "vue/dist/vue.esm-bundler"
import App from './App.vue'
import router from './router'
import Pusher from 'pusher-js'

window.Pusher = Pusher

const app = createApp(App)

app.config.globalProperties.Auth = Auth

app.use(router)
    .mount('#admin-main')
