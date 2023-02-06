import type { Comment as CommentType } from '@shared/types/models'
import axios from 'axios'
import { ref } from 'vue'

export default (postId: number, commentId?: number) => {
    const isLoading = ref<boolean>(false)
    const comment = ref<string>('')

    async function postComment(): Promise<void> {
        if (isLoading.value || !Auth) {
            return
        }

        isLoading.value = true

        const params = {
            comment: comment.value,
            comment_id: commentId || null,
            user_id: Auth.id,
            post_id: postId,
        }

        try {
            await axios.post<CommentType[]>('/api/comments', params)
        } catch (err) {
            console.error(err)
        }

        comment.value = ''
        isLoading.value = false
    }

    return {
        comment,
        postComment,
        isLoading,
    }
}
