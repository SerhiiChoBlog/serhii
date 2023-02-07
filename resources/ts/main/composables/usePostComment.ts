import type { Comment as CommentType } from '@shared/types/models'
import handleServerError from '@shared/modules/handleServerError'
import axios from 'axios'
import { ref } from 'vue'

export default (postId: number, commentId?: number) => {
    const isLoading = ref<boolean>(false)
    const comment = ref<string>('')

    async function postComment(): Promise<void> {
        if (isLoading.value) {
            return
        }

        if (!Auth) {
            window.location.href = '/login'
            return
        }

        isLoading.value = true

        const params = {
            comment: comment.value,
            comment_id: commentId || null,
            secret: Auth.secret,
            post_id: postId,
        }

        try {
            await axios.post<CommentType[]>('/api/comments', params)
            comment.value = ''
        } catch (err) {
            handleServerError(err)
        }

        isLoading.value = false
    }

    return {
        comment,
        postComment,
        isLoading,
    }
}
