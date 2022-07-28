<script setup lang="ts">
import type { Post } from '../../types/models'
import { ref } from 'vue'
import Filters from '../components/Posts/Filters.vue'
import NoPosts from '../components/Posts/NoPosts.vue'
import PostItem from '../components/Posts/PostItem.vue'

const posts = ref<Post[]>([])
</script>

<template>
    <div class="container">
        <div class="bg-page max-w-[1100px] mx-auto -translate-y-6 rounded-xl px-3 pt-3">
            <filters />

            <no-posts v-if="posts.length === 0" />

            <div v-else >
                <div class="flex flex-col gap-y-2">
                    <post-item
                        v-for="post in posts"
                        :key="post.id"
                        :post="post"
                    />
                </div>

                <div class="my-6 mx-4">
                    <!-- todo: Pagination here-->
                </div>
            </div>
        </div>
    </div>
</template>
