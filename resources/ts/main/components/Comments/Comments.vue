<script setup lang="ts">
import { computed } from 'vue'
import Spinner from '@shared/components/Icons/Spinner.vue'
import Comment from '@/components/Comments/Comment.vue'
import CommentForm from '@/components/Comments/CommentForm.vue'
import useComments from '@/composables/useComments'
import CommentsWrapper from '@/components/Comments/CommentsWrapper.vue'

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
    <div class="mb-12 max-w-[700px] mx-auto">
        <h2 class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white">
            Discussion ({{ commentsCount }})
        </h2>

        <comment-form
            @posted="fetchComments(false)"
            :post-id="postId"
        />

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

        <h2 v-else class="text-xl text-center text-font-second mb-8">
            🙏 Be the first to leave a comment
        </h2>
    </div>
</template>
