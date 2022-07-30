import { createApp, onMounted } from 'vue'
import ContactModal from './components/ContactModal.vue'
import Hamburger from './components/Hamburger.vue'
import SharePostButtons from './components/SharePostButtons.vue'
import Chapters from './components/Chapters/Chapters.vue'
import smoothLoader from 'smooth-loader'
import insertTagsForHighlightJs from './modules/insertTagsForHighlightJs'
import ThemeSwitch from './components/ThemeSwitch.vue'
import Avatar from './components/Avatar.vue'
import ToTop from './components/ToTop.vue'
import Popper from "vue3-popper"
import Tip from './components/Tip.vue'
import Search from './components/Search/Search.vue'
import Filters from './components/Filters/Filters.vue'
import ScrollDown from './components/ScrollDown.vue'

const app = createApp({
    components: {
        ContactModal,
        Hamburger,
        SharePostButtons,
        Chapters,
        ThemeSwitch,
        Avatar,
        ToTop,
        Popper,
        Search,
        Tip,
        Filters,
        ScrollDown,
    },

    setup() {
        onMounted(() => {
            insertTagsForHighlightJs()
        })
    },
})

app.mount("#app")

smoothLoader('[data-src]')
