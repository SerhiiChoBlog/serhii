<script setup lang="ts">
import type { Comment } from '@shared/types/models'
import { computed } from 'vue'
import LikeIcon from '@shared/components/Icons/LikeIcon.vue'

type Props = {
    comment: Comment
}

const props = defineProps<Props>()
const isLiked = computed(() => props.comment.likes!.length > 0)
</script>

<template>
    <button
        type="button"
        class="flex w-5 h-5 group"
    >
        <like-icon
            :fill="isLiked ? 'currentColor' : 'none'"
            :class="{
                'text-red-500 dark:text-red-400': isLiked,
                'text-gray-700 dark:text-gray-400': !isLiked,
            }"
            class="transition-transform group-hover:scale-110"
        />

        <span
            class="text-xs inline-block opacity-80"
        >
            {{ props.comment.likes_count }}
        </span>
    </button>
</template>
