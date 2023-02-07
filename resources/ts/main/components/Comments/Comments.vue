<script setup lang="ts">
import { computed } from 'vue'
import useComments from '@/composables/useComments'
import Spinner from '@shared/components/Icons/Spinner.vue'
import Comment from '@/components/Comments/Comment.vue'
import CommentForm from '@/components/Comments/CommentForm.vue'
import CommentsWrapper from '@/components/Comments/CommentsWrapper.vue'
import SignedInMethodLogo from '@shared/components/SignedInMethodLogo.vue'

type Props = {
    postId: number
}

const { postId } = defineProps<Props>()
const { comments, commentsLoading, fetchComments } = useComments(postId)

const commentsCount = computed(() => {
    return comments.value.reduce((a, c) => a + c.comments!.length + 1, 0)
})
</script>

<template>
    <div class="mb-12 mx-auto">
        <div class="flex gap-4">
            <div>
                <div class="relative w-18">
                    <img
                        :src="`/storage/avatars/${Auth ? Auth.avatar : 'default.svg'}`"
                        :alt="`${Auth ? Auth.name : 'Default'} avatar`"
                        class="w-10 lg:w-14 aspect-square rounded-full shadow-md mt-10"
                        width="400"
                        height="400"
                    />

                    <signed-in-method-logo
                        v-if="Auth"
                        :method="Auth.sign_in_method"
                        class="absolute w-4 lg:w-7 aspect-square -right-2 lg:-right-2 top-10 lg:top-9"
                    />
                </div>
            </div>
            <div class="w-full">
                <h2 class="text-lg mb-1 lg:text-2xl font-bold text-gray-900 dark:text-white">
                    Discussion ({{ commentsCount }})
                </h2>

                <comment-form
                    @posted="fetchComments(false)"
                    :post-id="postId"
                />
            </div>
        </div>

        <div v-if="commentsLoading" class="flex gap-6 items-center justify-center">
            <spinner class="mx-0" />
            <h2 class="text-2xl">Loading comments...</h2>
        </div>

        <comments-wrapper v-else-if="comments.length > 0">
            <comment
                v-for="comment in comments"
                :key="comment.id"
                :comment="comment"
                :post-id="postId"
                @posted="fetchComments(false)"
            />
        </comments-wrapper>

        <h2 v-else class="text-xl text-center text-font-second mb-8 mt-5">
            🙏 Be the first to leave a comment
        </h2>
    </div>
</template>
