<script setup lang="ts">
import type { Post } from '../../../types/models'

type Props = {
    post: Post
}

const { post } = defineProps<Props>()
</script>

<template>
    <article>
        <div class="flex flex-col lg:flex-row items-center gap-6 border-md p-3 rounded-xl max-w-[550px] lg:max-w-full mx-auto transition-colors hover:bg-page-second">
            <a :href="`/posts/${post.slug}`" class="block w-full max-w-max lg:max-w-[260px]">
                <img
                    :src="`/${post.image_sm}`"
                    class="rounded-lg shadow-[rgba(0,0,0,.2)] w-full"
                    width="260"
                    height="141"
                    :alt="post.title"
                />
            </a>

            <div>
                <a :href="`/posts/${post.slug}`">
                    <h2 class="text-2xl text-font">{{ post.title }}</h2>
                    <p class="mt-2 text-lg font-light text-font-second font-post">{{ post.intro }}</p>
                </a>

                <div>
<!--                    <x-post.tags :tags="post.tags" class="text-[.8em] mt-3" />-->
<!--                    <x-post.details :post="post" class="mt-3" />-->
                </div>
            </div>
        </div>
    </article>
</template>
