<script setup lang="ts">
import type { Post } from '@shared/types/models'
import AddPostToSeries from '@admin/views/Series/AddPostToSeries.vue'

type Props = {
    posts: Post[]
}

const { posts } = defineProps<Props>()

function addPostToSeries(post: Post): void {
    posts.push(post)
}
</script>

<template>
    <h2 class="text-3xl mb-5">Related posts</h2>

    <h3 v-if="posts.length === 0" class="text-xl">
        🙅🏻‍♂️ No related posts yet
    </h3>

    <ul v-else>
        <li v-for="post in posts" :key="post.id">
            <input type="hidden" name="posts[]" :value="post.id" />

            {{ post.title }}
        </li>
    </ul>

    <AddPostToSeries @postAdded="addPostToSeries" />
</template>
