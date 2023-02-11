import type { Pagination } from '@shared/types/response'
import type { Comment } from '@shared/types/models'
import { onMounted, ref } from 'vue'
import axios from 'axios'
import handleError from '@admin/modules/handleError'

export default () => {
    const comments = ref<Comment[]>([])
    const totalComments = ref<number | null>(null)
    const loading = ref(false)
    const nextPageUrl = ref<string | null>(null)

    onMounted(() => fetchComments('/admin/ajax/comments', true))

    function fetchComments(url: string, refresh = true): void {
        if (refresh) {
            loading.value = true
        }

        axios.get<{ comments: Pagination<Comment[]>, total: number }>(url)
            .then(resp => {
                const data = resp.data

                nextPageUrl.value = data.comments.next_page_url
                totalComments.value = data.total

                refresh
                    ? comments.value = data.comments.data
                    : comments.value.push(...data.comments.data)
            })
            .catch(handleError)
            .finally(() => loading.value = false)
    }

    function toggleApproved(commentId: number): void {
        //
    }

    function loadMoreComments(): void {
        if (nextPageUrl.value) {
            fetchComments(nextPageUrl.value, false)
        }
    }

    return {
        comments,
        totalComments,
        loading,
        nextPageUrl,
        loadMoreComments,
        toggleApproved,
    }
}
