<script setup lang="ts">
import { onMounted } from 'vue'
import usePostComment from '@/composables/usePostComment'
import CommentButton from '@/components/Comments/CommentButton.vue'
import useCachedComment from '@/composables/useCachedComment'
import GoogleSignInButton from '@/components/GoogleSignInButton.vue'

type Emits = {
    (e: 'posted'): void
}

type Props = {
    postId: number
    commentId?: number
}

const emit = defineEmits<Emits>()
const { postId, commentId } = defineProps<Props>()
const { comment, postComment, isLoading } = usePostComment(postId, commentId)

const {
    getCommentFromCache,
    saveCommentToCache,
    deleteCommentFromCache,
} = useCachedComment(postId, commentId)

onMounted(() => {
    comment.value = getCommentFromCache()
})

async function submitForm(): Promise<void> {
    await postComment()
    emit('posted')
    deleteCommentFromCache()
}
</script>

<template>
    <form @submit.prevent="submitForm" class="w-full mb-8">
        <div>
            <div class="mb-2">
                <textarea
                    v-model="comment"
                    :placeholder="`${Auth ? 'Write a' : 'Login to'} comment ...`"
                    class="p-3 bg-page focus:outline-none dark:bg-page-second rounded-lg border border-border w-full min-h-[90px]"
                    @blur="saveCommentToCache(comment)"
                    minlength="4"
                    maxlength="1000"
                ></textarea>

                <span class="absolute right-1 bottom-4 lg:bottom-6 opacity-60">
                    Letters: {{ comment.length }}/1000
                </span>
            </div>

            <div class="flex gap-4 items-center">
                <comment-button
                    type="submit"
                    :disabled="isLoading"
                    :class="{ 'opacity-50': isLoading }"
                >
                    <span v-if="isLoading">Processing...</span>
                    <span v-else-if="!Auth">Sign in</span>
                    <span v-else>Comment</span>
                </comment-button>

                <div v-if="!Auth" class="inline-flex">
                    <google-sign-in-button />
                </div>
            </div>
        </div>
    </form>
</template>
