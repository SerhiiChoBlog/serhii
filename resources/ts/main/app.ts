import { onMounted } from 'vue'
import { createApp } from "vue/dist/vue.esm-bundler"
import ContactModal from '@/components/ContactModal.vue'
import Hamburger from '@/components/Hamburger.vue'
import SharePostButtons from '@/components/SharePostButtons.vue'
import Chapters from '@/components/Chapters/Chapters.vue'
import smoothLoader from 'smooth-loader'
import insertTagsForHighlightJs from '@/modules/insertTagsForHighlightJs'
import ThemeSwitch from '@/components/ThemeSwitch.vue'
import ToTop from '@/components/ToTop.vue'
import Popper from "vue3-popper"
import Tip from '@/components/Tip.vue'
import Search from '@/components/Home/Search.vue'
import Filters from '@/components/Filters/Filters.vue'
import Subscription from '@/components/Subscription/Subscription.vue'
import ShowPasswordButton from '@/components/ShowPasswordButton.vue'
import UserDropdown from '@/components/UserDropdown.vue'
import Comments from '@/components/Comments/Comments.vue'
import LazyLoading from '@shared/components/LazyLoading.vue'
import GoogleSignInButton from '@/components/GoogleSignInButton.vue'

const app = createApp({
    components: {
        ContactModal,
        Hamburger,
        SharePostButtons,
        Chapters,
        ThemeSwitch,
        ToTop,
        Popper,
        Search,
        Tip,
        Filters,
        Subscription,
        ShowPasswordButton,
        UserDropdown,
        Comments,
        LazyLoading,
        GoogleSignInButton,
    },

    setup() {
        onMounted(() => {
            insertTagsForHighlightJs()
        })
    },
})

app.config.globalProperties.Auth = Auth

app.mount("#main")

smoothLoader('[data-src]')
