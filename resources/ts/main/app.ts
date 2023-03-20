import { onMounted } from 'vue'
import { createApp } from "vue/dist/vue.esm-bundler"
import ContactModal from '@/components/ContactModal.vue'
import Navbar from '@/components/Navbar/Navbar.vue'
import SharePostButtons from '@/components/SharePostButtons.vue'
import Chapters from '@/components/Chapters/Chapters.vue'
import smoothLoader from 'smooth-loader'
import insertTagsForHighlightJs from '@/modules/insertTagsForHighlightJs'
import Tip from '@shared/components/Tip.vue'
import Search from '@/components/Search/Search.vue'
import Filters from '@/components/Filters/Filters.vue'
import Subscription from '@/components/Subscription/Subscription.vue'
import ShowPasswordButton from '@/components/ShowPasswordButton.vue'
import Comments from '@/components/Comments/Comments.vue'
import LazyLoading from '@shared/components/LazyLoading.vue'
import FirebaseSignInButton from '@/components/FirebaseSignInButton.vue'
import RelatedPosts from '@/components/RelatedPosts/RelatedPosts.vue'
import LikePostButton from '@/components/LikePostButton.vue'

const app = createApp({
    components: {
        ContactModal,
        Navbar,
        SharePostButtons,
        Chapters,
        Search,
        Tip,
        Filters,
        Subscription,
        ShowPasswordButton,
        Comments,
        LazyLoading,
        FirebaseSignInButton,
        RelatedPosts,
        LikePostButton,
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
