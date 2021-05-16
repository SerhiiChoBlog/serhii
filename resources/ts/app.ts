import { createApp } from 'vue'
import Typewriter from './components/Typewriter.vue'

const app = createApp({
    components: {
        Typewriter,
    },
})

app.mount("#app")
