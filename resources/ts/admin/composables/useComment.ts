import type { Comment } from '@shared/types/models'
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import handleError from '@admin/modules/handleError'

export default () => {
    const router = useRouter()
    const comment = ref<Comment | null>(null)
    const commentId = Number(router.currentRoute.value.params.id as string)
    const loading = ref(false)

    onMounted(() => {
        loading.value = true
        fetchComment()
    })

    function fetchComment(): void {
        axios.get<Comment>(`/admin/ajax/comments/${commentId}`)
            .then(resp => {
                comment.value = resp.data
            })
            .catch(handleError)
            .finally(() => loading.value = false)
    }

    return {
        comment,
        loading,
    }
}
