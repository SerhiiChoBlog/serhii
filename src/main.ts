import { createApp } from 'vue'
import App from './App.vue'
import './registerServiceWorker'
import router from './router'
import store from './store'
import 'highlight.js'
import 'highlight.js/styles/github-gist.css'

createApp(App).use(store).use(router).mount('#app')
