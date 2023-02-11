import type { User } from '@shared/types/models'
import axios from 'axios'
import handleError from '@admin/modules/handleError'
import { useRouter } from 'vue-router'
import { onMounted, ref } from 'vue'
import showToast from '@shared/modules/showToast'

export default () => {
    const user = ref<User | null>(null)
    const loading = ref(false)
    const comment = ref('')

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
        if (!confirm('Are you sure you want to ban this user?')) {
            return
        }

        if (comment.value === '') {
            showToast({ text: 'Please enter a comment', success: false })
            return
        }

        axios.post('')
            .catch(handleError)
    }

    return {
        user,
        loading,
        comment,
        ban,
    }
}
