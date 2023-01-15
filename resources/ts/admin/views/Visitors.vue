<script setup lang="ts">
import type { Visitor } from '@shared/types/models'
import { onMounted, ref } from 'vue'
import axios from 'axios'
import handleError from '@admin/modules/handleError'
import PageTitle from '@admin/components/PageTitle.vue'
import Spinner from '@admin/components/Spinner.vue'

const visitors = ref<Visitor[]>([])
const loading = ref(false)

onMounted(() => fetchVisitors())

function fetchVisitors(): void {
    loading.value = true

    axios.get<Visitor[]>('/admin/ajax/visitors')
        .then(resp => visitors.value = resp.data)
        .catch(handleError)
        .finally(() => loading.value = false)
}
</script>

<template>
    <div class="container max-w-3xl">
        <page-title>Unique visitors</page-title>

        <spinner v-if="loading" />

        <div v-else class="overflow-x-auto shadow-md rounded-lg mx-auto mt-7">
            <table class="table-auto w-full">
                <thead class="bg-gray-500 text-white text-left">
                    <tr>
                        <th
                            v-for="title in ['Views', 'IP', 'Country', 'City', 'Flag']"
                            :key="title"
                            class="p-3"
                        >
                            {{ title }}
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                        v-for="visitor in visitors"
                        :key="visitor.id"
                        class="border-b odd:bg-gray-50 transition-colors hover:bg-gray-100"
                    >
                        <td class="px-3 py-1">{{ visitor.post_views_count }}</td>
                        <td class="px-3 py-1">{{ visitor.ip }}</td>
                        <td class="px-3 py-1">{{ visitor.country || '-' }}</td>
                        <td class="px-3 py-1">{{ visitor.city || '-' }}</td>
                        <td class="px-3 py-1">
                            <img
                                v-if="visitor.code"
                                :src="`/storage/admin/flags/${visitor.code}.png`"
                                width="30"
                            />
                            <img v-else src="/storage/admin/flags/unknown.png" width="30" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
