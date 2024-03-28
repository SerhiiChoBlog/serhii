<script setup lang="ts">
import type { Post } from '@shared/types/models'

type Props = {
    post: Post | null
}

const props = defineProps<Props>()
</script>

<template>
    <div v-if="props.post" class="w-full">
        <a
            :href="`/posts/${props.post.slug}`"
            class="px-3 py-4 block w-full h-full rounded-xl text-main-hover select-none hover:bg-page-second transition-colors"
        >
            <span class="text-2xl">
                <slot />
            </span>

            <p class="text-font-second text-sm">
                {{ props.post.title }}
            </p>
        </a>
    </div>

    <span v-else></span>
</template>