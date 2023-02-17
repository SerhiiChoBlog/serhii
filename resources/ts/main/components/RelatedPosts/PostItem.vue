<script setup lang="ts">
import { Post } from '@shared/types/models'

type Props = {
    post: Post
}

const { post } = defineProps<Props>()
</script>

<template>
    <a
        :href="`/posts/${post.slug}`"
        class="p-2 transition-opacity hover:opacity-80 min-h-[160px]"
        :aria-label="`Go to a post ${post.title}`"
    >
        <img
            :src="`/${post.image_sm}`"
            :alt="`Photo of the post '${post.title}'`"
            class="rounded-lg shadow-lg mx-auto w-full"
            width="260"
            height="141"
        />

        <h2 class="text-lg leading-6 my-3">{{ post.title }}</h2>
    </a>
</template>
