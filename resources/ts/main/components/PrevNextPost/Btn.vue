<script setup lang="ts">
import type { Post } from '@shared/types/models'
import { computed } from 'vue'

type Props = {
    post: Post | null
}

const props = defineProps<Props>()

const styles = computed(() => {
    let res = "px-7 py-4 border-4 border-dashed block w-full text-center rounded-xl text-xl text-main-hover select-none"

    if (props.post) {
        return res + " border-main hover:text-main-dark hover:border-main-dark transition-colors"
    }

    return res + " bg-main-light cursor-not-allowed"
})
</script>

<template>
    <div v-if="props.post" class="w-full">
        <a :href="`/posts/${props.post.slug}`" :class="styles">
            <slot />
        </a>

        <p class="text-font-second mt-1 mx-2">{{ props.post.title }}</p>
    </div>

    <span v-else :class="styles">
        <slot />
    </span>
</template>