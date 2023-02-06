<script setup lang="ts">
import usePostComment from '@/composables/usePostComment'

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

async function submitForm(): Promise<void> {
    await postComment()
    emit('posted')
}
</script>

<template>
    <form @submit.prevent="submitForm" class="w-full mb-8">
        <textarea
            v-model="comment"
            placeholder="Write a comment..."
            class="py-2 px-4 mb-4 bg-page focus:outline-none dark:bg-page-second rounded-lg border border-border w-full min-h-[135px]"
            maxlength="1000"
            minlength="4"
        ></textarea>

        <button
            type="submit"
            class="px-7 py-2.5 bg-main text-white rounded-md hover:bg-main-hover"
            :disabled="isLoading"
            :class="{ 'opacity-50': isLoading }"
        >
            <span v-if="isLoading">Processing ...</span>
            <span v-else>Post comment</span>
        </button>
    </form>
</template>
