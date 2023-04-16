<script setup lang="ts">
import { ref } from 'vue'
import LikeIcon from '@shared/components/Icons/LikeIcon.vue'

const isLiked = ref<boolean>(true)
const likes = ref<number>(2)
</script>

<template>
    <button
        type="button"
        class="w-5 h-5 mt-2.5 mx-auto group"
    >
        <like-icon
            :fill="isLiked ? 'currentColor' : 'none'"
            :class="{
                'text-red-500 dark:text-red-400': isLiked,
                'text-gray-700 dark:text-gray-400': !isLiked,
            }"
            class="transition-transform group-hover:scale-110"
        />

        <span class="text-sm -translate-y-1 inline-block opacity-80">
            {{ likes }}
        </span>
    </button>
</template>
