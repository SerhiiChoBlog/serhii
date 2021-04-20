import User from '@/interfaces/auth/User'
import { computed } from 'vue'
import { useStore } from 'vuex'

export default () => {
    const store = useStore()
    const user = computed<User | null>(() => store.state.auth.user)

    return { user }
}