import { computed } from 'vue'
import { useStore } from 'vuex'

export default () => {
    const store = useStore()
    const isAuth = computed<boolean>(() => store.state.auth.isAuth)

    return { isAuth }
}