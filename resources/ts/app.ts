import { createApp } from 'vue'
import Typewriter from './components/Typewriter.vue'
import ContactModal from './components/ContactModal.vue'

const app = createApp({
    components: {
        Typewriter,
        ContactModal,
    },
})

app.mount("#app")
