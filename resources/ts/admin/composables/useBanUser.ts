import type { User } from '@shared/types/models'
import axios from 'axios'
import handleError from '@admin/modules/handleError'
import { useRouter } from 'vue-router'
import { onMounted, ref } from 'vue'

export default () => {
    const user = ref<User | null>(null)
    const loading = ref(false)
    const router = useRouter()
    const userSlug = router.currentRoute.value.params.slug as string

    onMounted(fetchUser)

    function fetchUser(): void {
        if (!userSlug)
            return

        loading.value = true

        axios.get<User>(`/admin/ajax/users/${userSlug}`)
            .then(response => {
                user.value = response.data
            })
            .catch(handleError)
            .finally(() => loading.value = false)
    }

    function ban(): void {
        axios.put('')
            .catch(handleError)
    }

    return {
        user,
        loading,
        ban,
    }
}
