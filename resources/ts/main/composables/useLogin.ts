import type { ServerError } from '@shared/types/response'
import { ref } from 'vue'
import axios from 'axios'
import handleServerError from '@shared/modules/handleServerError'

export default () => {
    const loading = ref<boolean>(false)
    const errors = ref<ServerError['errors'] | null>(null)
    const formData = ref({
        email: '',
        password: '',
    })

    const redirectToReset = () => window.location.href = '/password/reset'

    function login(): void {
        if (loading.value) {
            return
        }

        loading.value = true

        axios.post<ServerError|null>('/login', formData.value, {
            headers: { 'Content-Type': 'application/json' }
        })
            .then(resp => document.location.reload())
            .catch(async e => {
                const err = await handleServerError(e)
                errors.value = err ? err.errors : null
            })
            .finally(() => loading.value = false)
    }

    return {
        loading,
        formData,
        errors,
        login,
        redirectToReset,
    }
}
