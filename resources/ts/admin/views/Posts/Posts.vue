<script setup lang="ts">
import type { Post } from '@shared/types/models'
import { onMounted, ref } from 'vue'
import PageTitle from '@admin/components/PageTitle.vue'
import MainButton from '@admin/components/Buttons/MainButton.vue'
import PostItem from '@admin/components/Post/PostItem.vue'
import axios from 'axios'
import Spinner from '@shared/components/Icons/Spinner.vue'
import handleError from '@admin/modules/handleError'

const posts = ref<Post[]>([])
const loading = ref(true)

onMounted(() => fetchPosts())

function fetchPosts(): void {
    axios.get<Post[]>('/admin/ajax/posts')
        .then(resp => posts.value = resp.data)
        .catch(handleError)
        .finally(() => loading.value = false)
}
</script>

<template>
    <div class="container">
        <page-title>
            <div class="flex items-center justify-center gap-3">
                <span>Posts</span>

                <main-button :route="{ name: 'posts-create' }">
                    <i class="fas fa-plus"></i>
                </main-button>
            </div>
        </page-title>

        <spinner v-if="loading" />

        <div v-else-if="posts.length > 0" class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="table-auto">
                <thead class="bg-gray-700 text-white text-left">
                    <tr>
                        <th></th>
                        <th class="p-3 font-light">Image</th>
                        <th class="p-3 font-light min-w-[300px]">Title</th>
                        <th class="p-3 font-light">Intro</th>
                        <th class="p-3 font-light">Shares</th>
                        <th class="p-3 font-light">Views</th>
                        <th class="p-3 font-light">View</th>
                        <th class="p-3 font-light">Edit</th>
                    </tr>
                </thead>

                <tbody>
                    <post-item
                        v-for="post in posts"
                        :key="post.id"
                        :post="post"
                    />
                </tbody>
            </table>
        </div>

        <h2 v-else class="text-xl text-center pt-4">There are no posts</h2>
    </div>
</template>
