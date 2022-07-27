<script setup lang="ts">
import { Hit } from '../../types/models'
import { onMounted, ref } from 'vue'
import axios from 'axios'
import handleError from '../modules/handleError'
import PageTitle from '../components/PageTitle.vue'
import Spinner from '../components/Spinner.vue'

const hits = ref<Hit[]>([])
const loading = ref(true)

onMounted(() => fetchHits())

function fetchHits(): void {
    axios.get<Hit[]>('/admin/ajax/hits')
        .then(resp => hits.value = resp.data)
        .catch(handleError)
        .finally(() => loading.value = false)
}
</script>

<template>
    <div class="container max-w-xs">
        <page-title>Request hits</page-title>

        <spinner v-if="loading" />

        <div v-else class="overflow-x-auto shadow-md rounded-lg mx-auto">
            <table class="table-auto w-full">
                <thead class="bg-gray-500 text-white text-left">
                    <tr>
                        <th
                            v-for="title in ['Date', 'Hits']"
                            :key="title"
                            class="p-3 font-light"
                        >
                            {{ title }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="hit in hits"
                        :key="hit.id"
                        class="border-b odd:bg-gray-50 first:!bg-yellow-200 transition-colors hover:bg-gray-100"
                    >
                        <td class="px-3 py-1">{{ hit.created_at }}</td>
                        <td class="px-3 py-1">{{ hit.amount }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
