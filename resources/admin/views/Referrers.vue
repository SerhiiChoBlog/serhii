<script setup lang="ts">
import type { Referrer } from '../../types/models'
import { onMounted, ref } from 'vue'
import axios from 'axios'
import handleError from '../modules/handleError'
import PageTitle from '../components/PageTitle.vue'
import Spinner from '../components/Spinner.vue'

const referrers = ref<Referrer[]>([])
const loading = ref(true)

onMounted(() => fetchReferrers())

function fetchReferrers(): void {
    axios.get<Referrer[]>('/admin/ajax/referrers')
        .then(resp => referrers.value = resp.data)
        .catch(handleError)
        .finally(() => loading.value = false)
}
</script>

<template>
    <div class="container">
        <page-title>Referrers</page-title>

        <spinner v-if="loading" />

        <h2 v-else-if="referrers.length === 0" class="text-2xl text-center">
            There are not referrers
        </h2>

        <div v-else>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg max-w-[1100px] mx-auto">
                <table class="w-full">
                    <thead class="bg-gray-500 text-left">
                        <tr>
                            <th
                                v-for="title in ['#', 'Name', 'Site', 'Hits', 'Hash', 'Last update']"
                                class="text-white p-3 font-light"
                            >
                                {{ title }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="referrer in referrers"
                            :key="referrer"
                            class="odd:bg-gray-50 border-b transition-colors hover:bg-gray-100"
                        >
                            <td class="p-2">{{ referrer.id }}</td>
                            <td class="p-2">{{ referrer.name }}</td>
                            <td class="p-2">
                                <a :href="referrer.site" target="_blank" class="underline">
                                    {{ referrer.site }}
                                </a>
                            </td>
                            <td class="p-2 text-lg font-black text-main font-code">
                                {{ referrer.hits }}
                            </td>
                            <td class="p-2">
                                <code class="bg-gray-200 py-1 px-3 rounded-md font-code">
                                    {{ referrer.hash }}
                                </code>
                            </td>
                            <td class="p-2">{{ referrer.pretty_updated_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
