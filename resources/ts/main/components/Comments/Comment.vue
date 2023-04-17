<script setup lang="ts">
import { ref } from 'vue'
import type { Comment as CommentType } from '@shared/types/models'
import CommentComponent from '@/components/Comments/Comment.vue'
import CommentForm from '@/components/Comments/CommentForm.vue'
import CommentsWrapper from '@/components/Comments/CommentsWrapper.vue'
import CommentAvatar from '@/components/Comments/CommentAvatar.vue'
import Controls from '@/components/Comments/Controls/Controls.vue'

type Props = {
    comment: CommentType
    postId: number
}

type Emits = {
    (e: 'posted'): void
    (e: 'likedComment'): void
}

const emit = defineEmits<Emits>()
const { comment, postId } = defineProps<Props>()

const reply = ref<boolean>(false)

function postReply(): void {
    emit('posted')
    reply.value = false
}
</script>

<template>
    <article
        v-if="comment.user"
        class="py-2 flex gap-3 lg:gap-4"
    >
        <a :href="`/@${comment.user.slug}`" class="relative">
            <comment-avatar :user="comment.user" />
        </a>

        <div class="flex flex-col gap-1">
            <h2 class="text-lg font-bold">
                {{ comment.user.name }}
            </h2>

            <p
                v-html="comment.comment"
                class="text-font-second dark:text-gray-300 prose-a:text-link prose-a:underline"
            ></p>

            <controls
                @reply="reply = !reply"
                @likedComment="emit('likedComment')"
                :reply="reply"
                :comment="comment"
            />
        </div>
    </article>

    <comment-form
        v-if="reply"
        :comment-id="comment.comment_id || comment.id"
        @posted="postReply"
        :post-id="postId"
    />

    <comments-wrapper
        v-if="comment.comments && comment.comments.length > 0"
        class="pl-7 ml-4 lg:ml-5 border-l-2 border-border border-dashed"
    >
        <comment-component
            v-for="c in comment.comments"
            :key="c.id"
            :comment="c"
            :post-id="postId"
            @posted="postReply"
            @likedComment="emit('likedComment')"
        />
    </comments-wrapper>
</template>
