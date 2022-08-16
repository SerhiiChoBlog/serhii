<script setup lang="ts">
import type { PostPublication } from '../../types/models'
import { onMounted, ref } from 'vue'
import axios from 'axios'
import handleError from '../modules/handleError'
import PageTitle from '../components/PageTitle.vue'
import Spinner from '../components/Spinner.vue'

const publications = ref<PostPublication[]>([])
const loading = ref(false)

onMounted(() => fetchVisitors())

function fetchVisitors(): void {
    axios.get<PostPublication[]>('/admin/ajax/post-publications')
        .then(resp => publications.value = resp.data)
        .catch(handleError)
        .finally(() => loading.value = false)
}
</script>

<template>
    <div class="container max-w-3xl">
        <page-title>Post publications</page-title>

        <spinner v-if="loading" />

        <div v-else-if="publications.length === 0">
            <h2 class="text-center text-xl">There are no post publications yet</h2>
        </div>

        <div v-else class="overflow-x-auto shadow-md rounded-lg mx-auto mt-7">
            <table class="table-auto w-full">
                <thead class="bg-gray-500 text-white text-left">
                    <tr>
                        <th
                            v-for="title in ['#', 'People', 'Post', 'Created']"
                            :key="title"
                            class="p-3"
                        >
                            {{ title }}
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                        v-for="publication in publications"
                        :key="publication.id"
                        class="border-b odd:bg-gray-50 transition-colors hover:bg-gray-100"
                    >
                        <td class="px-3 py-1">{{ publication.id }}</td>
                        <td class="px-3 py-1">{{ publication.people_notified }}</td>
                        <td class="px-3 py-1">{{ publication.post ? publication.post.title : '-no-' }}</td>
                        <td class="px-3 py-1">{{ publication.created_at }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
