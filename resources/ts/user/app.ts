import { createApp } from "vue/dist/vue.esm-bundler"
import App from './App.vue'
import router from './router'

const app = createApp(App)

app.config.globalProperties.Auth = Auth

app.use(router)
    .mount('#user-main')
