import { createApp, onMounted } from 'vue'
import Typewriter from './components/Typewriter.vue'
import ContactModal from './components/ContactModal.vue'
import Hamburger from './components/Hamburger.vue'
import SharePostButtons from './components/SharePostButtons.vue'
import Chapters from './components/Chapters.vue'
import smoothLoader from 'smooth-loader'
import insertTagsForHighlightJs from './modules/insertTagsForHighlightJs'

const app = createApp({
    components: {
        Typewriter,
        ContactModal,
        Hamburger,
        SharePostButtons,
        Chapters,
    },

    setup() {
        onMounted(() => {
            insertTagsForHighlightJs()
        })
    },
})

app.mount("#app")

smoothLoader()
