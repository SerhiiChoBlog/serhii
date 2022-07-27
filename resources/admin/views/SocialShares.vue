<script setup lang="ts">
import type { Post } from '../../types/models'
import { onMounted, ref } from 'vue'
import handleError from '../modules/handleError'
import axios from 'axios'
import PageTitle from '../components/PageTitle.vue'
import Spinner from '../components/Spinner.vue'

const posts = ref<Post[]>([])
const loading = ref(true)

onMounted(() => fetchPosts())

function fetchPosts(): void {
    axios.get<Post[]>('/admin/ajax/social-shares')
        .then(resp => posts.value = resp.data)
        .catch(handleError)
        .finally(() => loading.value = false)
}
</script>

<template>
    <div class="container">
        <page-title>Visitors</page-title>

        <spinner v-if="loading" />

        <h2 v-else-if="posts.length === 0" class="text-2xl text-center">There are no posts</h2>

        <div v-else class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full">
                <thead class="bg-gray-500 text-left">
                    <tr>
                        <th
                            v-for="title in ['Article', '', '', '', '']"
                            :key="title"
                            class="text-white p-3 font-light"
                        >
                            {{ title }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="post in posts"
                        :key="post.id"
                        class="odd:bg-gray-50 border-b transition-colors hover:bg-gray-100"
                    >
                        <td class="p-2">{{ post.title }}</td>

                        <td
                            v-if="post.social"
                            v-for="(items, social) in post.social"
                            :key="social"
                            class="p-1"
                        >
                            <div class="flex flex-col lg:flex-row gap-x-2 items-center">
                                <img
                                    :src="`/storage/icons/${social.toString()}.png`"
                                    :alt="social"
                                    width="20"
                                />

                                <span class="text-md font-bold text-font-second">
                                    {{ items.length }}
                                </span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
