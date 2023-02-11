import type { User } from '@shared/types/models'
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import handleError from '@admin/modules/handleError'

export default () => {
    const router = useRouter()
    const user = ref<User | null>(null)
    const userSlug = router.currentRoute.value.params.slug as string
    const loading = ref(false)

    onMounted(() => {
        loading.value = true
        fetchUser()
    })

    function fetchUser(): void {
        axios.get<User>(`/admin/ajax/users/${userSlug}`)
            .then(resp => {
                user.value = resp.data
            })
            .catch(handleError)
            .finally(() => loading.value = false)
    }

    return {
        user,
        loading,
    }
}
