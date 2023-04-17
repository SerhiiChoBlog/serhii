<script setup lang="ts">
import type { Comment } from '@shared/types/models'
import LikeCommentButton from '@/components/Comments/LikeCommentButton.vue'
import Control from '@/components/Comments/Controls/Control.vue'

type Props = {
    comment: Comment
    reply: boolean
}

type Emits = {
    (e: 'reply'): void
}

const emit = defineEmits<Emits>()
const props = defineProps<Props>()
</script>

<template>
    <div class="flex gap-2 items-center">
        <like-comment-button :comment="props.comment" />

        <span v-if="Auth && props.comment.user_id !== Auth.id">·</span>

        <control
            v-if="Auth && props.comment.user_id !== Auth.id"
            @click="emit('reply')"
        >
            <span v-if="props.reply">Cancel</span>
            <span v-else>Reply</span>
        </control>

        <span>·</span>

        <small class="text-gray-400">
            {{ props.comment.pretty_created_at }}
        </small>
    </div>
</template>
