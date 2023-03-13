<script setup lang="ts">
import type { Post } from '@shared/types/models'
import AddPostToSeries from '@admin/views/Series/Posts/AddPostToSeries.vue'

type Props = {
    seriesTitle: string
    posts: Post[]
}

const { posts, seriesTitle } = defineProps<Props>()

function addPostToSeries(post: Post): void {
    posts.push(post)
}
</script>

<template>
    <h2 class="text-3xl mb-5">Related posts</h2>

    <h3 v-if="posts.length === 0" class="text-xl">
        🙅🏻‍♂️ No related posts yet
    </h3>

    <div v-else class="space-y-3">
        <article
            v-for="(post, index) in posts"
            :key="post.id"
            class="bg-page-second p-3 rounded-lg flex gap-6"
        >
            <input type="hidden" name="posts[]" :value="post.id" />

            <img
                :src="`/${post.image_sm}`"
                class="w-56 rounded-md shadow-md"
                width="550"
                height="275"
            />

            <div class="flex flex-col justify-center">
                <h2 class="text-2xl">{{ seriesTitle }}: {{ post.title }}</h2>
                <h3 class="text-lg opacity-80">Part {{ ++index }}</h3>
                <p class="text-md">{{ post.intro }}</p>
            </div>

            <button
                type="button"
                class="text-xl text-red-500 mx-2"
            >
                <i class="fas fa-times" />
            </button>
        </article>
    </div>

    <AddPostToSeries @postAdded="addPostToSeries" />
</template>
