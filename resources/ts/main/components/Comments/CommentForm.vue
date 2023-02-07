<script setup lang="ts">
import { onMounted } from 'vue'
import usePostComment from '@/composables/usePostComment'
import CommentButton from '@/components/Comments/CommentButton.vue'
import useCachedComment from '@/composables/useCachedComment'

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
        <div class="relative mb-4">
            <textarea
                v-model="comment"
                :placeholder="`${Auth ? 'Write a' : 'Login to'} comment ...`"
                class="p-3 bg-page focus:outline-none dark:bg-page-second rounded-lg border border-border w-full min-h-[90px]"
                maxlength="1000"
                @blur="saveCommentToCache(comment)"
                minlength="4"
            ></textarea>
            <span class="absolute right-1 -bottom-6 opacity-60">
                Letters: {{ comment.length }}/1000
            </span>
        </div>

        <comment-button
            v-if="Auth"
            type="submit"
            :disabled="isLoading"
            :class="{ 'opacity-50': isLoading }"
        >
            <span v-if="isLoading">Processing...</span>
            <span v-else>Comment</span>
        </comment-button>

        <comment-button v-else href="/login">
            Login to comment
        </comment-button>


    </form>
</template>
