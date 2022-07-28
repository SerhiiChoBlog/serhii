<script setup lang="ts">
import type { Post } from '../../../types/models'

type Props = {
    post: Post
}

const { post } = defineProps<Props>()
</script>

<template>
    <div class="opacity-70 flex items-center gap-2">
        <time :datetime="post.created_at">
            {{ post.pretty_created_at }}
        </time>

        <span>&#8226;</span>

        <template v-if="post.page_views_count && post.page_views_count > 99">
            <span>{{ post.page_views_count }} views</span>
            <span>&#8226;</span>
        </template>

        <template v-if="post.read_time && post.read_time > 0">
            <span>{{ post.read_time }} minutes read</span>
        </template>
    </div>
</template>
