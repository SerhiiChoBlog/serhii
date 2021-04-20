import { ref, computed } from 'vue'
import { useStore } from 'vuex'

export default () => {
    const store = useStore()
    const email = ref('')
    const password = ref('')
    const processingAuth = computed<boolean>(() => store.state.auth.processingAuth)
    const errorAuth = computed<string | null>(() => store.state.auth.errorAuth)

    function login(): void {
        store.dispatch('login', {
            email: email.value,
            password: password.value,
        })
    }

    function clearAuthError(): void {
        store.dispatch('clearAuthError')
    }

    return {
        email,
        password,
        processingAuth,
        errorAuth,
        login,
        clearAuthError,
    }
}