import { createApp } from 'vue'
import Typewriter from './components/Typewriter.vue'
import ContactModal from './components/ContactModal.vue'
import Hamburger from './components/Hamburger.vue'

const app = createApp({
    components: {
        Typewriter,
        ContactModal,
        Hamburger,
    },
})

app.mount("#app")
