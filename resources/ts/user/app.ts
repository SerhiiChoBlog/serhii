import { createApp } from "vue/dist/vue.esm-bundler"
import Avatar from '@user/components/Profile/Avatar.vue'
import Tip from '@shared/components/Tip.vue'

const app = createApp({
    components: {
        Avatar,
        Tip,
    }
})

app.config.globalProperties.Auth = Auth

app.mount('#user-main')
