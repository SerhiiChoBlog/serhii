<script setup lang="ts">
import type { Comment } from '@shared/types/models'
import { computed } from 'vue'
import LikeIcon from '@shared/components/Icons/LikeIcon.vue'
import Control from '@/components/Comments/Controls/Control.vue'

type Props = {
    comment: Comment
}

const props = defineProps<Props>()
const isLiked = computed(() => props.comment.likes!.length > 0)
</script>

<template>
    <control>
        <like-icon
            :fill="isLiked ? 'currentColor' : 'none'"
            :class="{
                'text-red-500 dark:text-red-400': isLiked,
                'text-gray-700 dark:text-gray-400': !isLiked,
            }"
            class="w-5 h-5 translate-y-[1px]"
        />

        <span>{{ props.comment.likes_count }} likes</span>
    </control>
</template>
