import { computed } from 'vue'
import { useStore } from 'vuex'

export default () => {
    const store = useStore()
    const processingLogout = computed<boolean>(() => store.state.auth.processingLogout)

    function logout(): void {
        store.dispatch('logout')
    }

    return {
        processingLogout,
        logout,
    }
}