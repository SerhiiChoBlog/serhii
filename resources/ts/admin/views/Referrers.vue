<script setup lang="ts">
import type { Referrer } from '@shared/types/models'
import { onMounted, ref } from 'vue'
import axios from 'axios'
import handleError from '@admin/modules/handleError'
import PageTitle from '@admin/components/PageTitle.vue'
import Spinner from '@shared/components/Icons/Spinner.vue'

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
        <PageTitle>Referrers</PageTitle>

        <Spinner v-if="loading" />

        <h2 v-else-if="referrers.length === 0" class="text-2xl text-center">
            There are not referrers
        </h2>

        <div v-else>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg max-w-[1100px] mx-auto">
                <table class="w-full">
                    <thead class="bg-gray-500 text-left">
                        <tr>
                            <th
                                v-for="title in ['#', 'Site', 'Hits', 'Last update']"
                                class="text-white p-3 font-light"
                            >
                                {{ title }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="referrer in referrers"
                            :key="referrer.id"
                            class="odd:bg-gray-50 border-b transition-colors hover:bg-gray-100"
                        >
                            <td class="p-2">{{ referrer.id }}</td>
                            <td class="p-2">
                                <a :href="referrer.site" target="_blank" class="underline">
                                    {{ referrer.site }}
                                </a>
                            </td>
                            <td class="p-2 text-lg font-black text-main font-code">
                                {{ referrer.hits }}
                            </td>
                            <td class="p-2">{{ referrer.pretty_updated_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
