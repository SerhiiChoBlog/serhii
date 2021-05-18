import { createApp } from 'vue'
import Typewriter from './components/Typewriter.vue'
import ContactModal from './components/ContactModal.vue'
import Hamburger from './components/Hamburger.vue'
import smoothLoader from 'smooth-loader'

const app = createApp({
    components: {
        Typewriter,
        ContactModal,
        Hamburger,
    },
})

app.mount("#app")

smoothLoader()
