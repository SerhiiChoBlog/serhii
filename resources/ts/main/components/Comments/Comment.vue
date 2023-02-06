<script setup lang="ts">
import type { Comment } from '@shared/types/models'
import CommentIcon from '@shared/components/Icons/CommentIcon.vue'

type Props = {
    comment: Comment
}

const { comment } = defineProps<Props>()

function replyToComment(): void {
    console.log('reply to comment')
}
</script>

<template>
    <article v-if="comment.user" class="border border-border p-4 rounded-lg flex gap-5">
        <img
            :src="`/storage/avatars/${comment.user.avatar}`"
            :alt="comment.user.name"
            width="70"
            height="70"
            class="rounded-full drop-shadow-md"
        />

        <div class="flex flex-col gap-0.5">
            <h2 class="text-lg font-bold">
                {{ comment.user.name }}
            </h2>

            <p class="text-font-second dark:text-gray-300">
                {{ comment.comment }}
            </p>

            <div class="flex gap-1.5 items-center">
                <button
                    @click="replyToComment"
                    class="inline-flex gap-1 items-center text-sm text-main hover:underline"
                >
                    <comment-icon class="w-4 h-4" />
                    <span>Reply</span>
                </button>
                ·
                <small class="text-gray-400">
                    {{ comment.pretty_created_at }}
                </small>
            </div>
        </div>
    </article>
</template>
