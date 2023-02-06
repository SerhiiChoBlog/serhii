<script setup lang="ts">
import type { Comment as CommentType } from '@shared/types/models'
import Comment from '@/components/Comments/Comment.vue'
import { events } from '@shared/appConfig'
import dispatchEvent from '@shared/modules/dispatchEvent'

type Props = {
    comment: CommentType
}

const { comment } = defineProps<Props>()

function replyToComment(): void {
    dispatchEvent(events.replayToComment)
}
</script>

<template>
    <article
        v-if="comment.user"
        class="border border-border p-2 lg:p-4 rounded-xl flex items-center gap-4 lg:gap-5"
    >
        <img
            :src="`/storage/avatars/${comment.user.avatar}`"
            :alt="comment.user.name"
            width="70"
            height="70"
            class="rounded-full drop-shadow-md w-[40px] lg:w-[70px] aspect-square"
        />

        <div class="flex flex-col gap-1">
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
                    <span>Reply</span>
                </button>
                ·
                <small class="text-gray-400">
                    {{ comment.pretty_created_at }}
                </small>
            </div>
        </div>
    </article>

    <div v-if="comment.comments && comment.comments.length > 0" class="pl-12">
        <comment
            v-for="comment in comment.comments"
            :key="comment.id"
            :comment="comment"
        />
    </div>
</template>
