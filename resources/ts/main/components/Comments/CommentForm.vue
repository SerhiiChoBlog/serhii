<script setup lang="ts">
import { onMounted } from 'vue'
import usePostComment from '@/composables/usePostComment'
import CommentButton from '@/components/Comments/CommentButton.vue'
import useCachedComment from '@/composables/useCachedComment'
import SignedInMethodLogo from '@shared/components/SignedInMethodLogo.vue'

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
        <div class="flex gap-4 lg:gap-6">
            <div class="relative w-18">
                <img
                    :src="`/storage/avatars/${Auth.avatar}`"
                    :alt="`${Auth.name} avatar`"
                    class="w-10 lg:w-14 aspect-square rounded-full shadow-md mt-4"
                    width="400"
                    height="400"
                />

                <signed-in-method-logo
                    :method="Auth.sign_in_method"
                    class="absolute w-4 lg:w-7 aspect-square -right-2 lg:-right-3 top-10 lg:top-12"
                />
            </div>

            <div class="relative w-full">
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
            </div>
        </div>
    </form>
</template>
