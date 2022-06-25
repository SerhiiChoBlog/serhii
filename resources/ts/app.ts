import { createApp, onMounted } from 'vue'
import Typewriter from './components/Typewriter.vue'
import ContactModal from './components/ContactModal.vue'
import Hamburger from './components/Hamburger.vue'
import SharePostButtons from './components/SharePostButtons.vue'
import Chapters from './components/Chapters/Chapters.vue'
import smoothLoader from 'smooth-loader'
import insertTagsForHighlightJs from './modules/insertTagsForHighlightJs'
import ThemeSwitch from './components/ThemeSwitch.vue'
import Avatar from './components/Avatar.vue'
import ToTop from './components/ToTop.vue'

const app = createApp({
    components: {
        Typewriter,
        ContactModal,
        Hamburger,
        SharePostButtons,
        Chapters,
        ThemeSwitch,
        Avatar,
        ToTop,
    },

    setup() {
        onMounted(() => {
            insertTagsForHighlightJs()
        })
    },
})

app.mount("#app")

smoothLoader()
