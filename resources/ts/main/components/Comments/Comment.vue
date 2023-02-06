<script setup lang="ts">
import type { Comment } from '@shared/types/models'

type Props = {
    comment: Comment
}

const { comment } = defineProps<Props>()
</script>

<template>
    <article v-if="comment.user" class="border border-border p-5 rounded-lg">
        <div>
            <h2 class="flex items-center gap-3">
                <img
                    :src="`/storage/avatars/${comment.user.avatar}`"
                    :alt="comment.user.name"
                    width="30"
                    height="30"
                />

                <span>{{ comment.user.name }}</span>
                <span>{{ comment.pretty_created_at }}</span>
            </h2>
        </div>
    </article>
</template>
