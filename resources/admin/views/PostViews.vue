<script setup lang="ts">
import type { PageView } from '../../types/models'
import { onMounted, reactive, ref } from 'vue'
import { Tab, TabGroup, TabList, TabPanel, TabPanels } from '@headlessui/vue'
import axios from 'axios'
import handleError from '../modules/handleError'
import PageTitle from '../components/PageTitle.vue'
import Spinner from '../components/Spinner.vue'

type Views = {
    unique: PageView[] | null
    daily: PageView[] | null
}

const loading = ref(true)
const views = reactive<Views>({
    unique: null,
    daily: null,
})

onMounted(() => fetchViews())

function fetchViews(): void {
    axios.get<Views>('/admin/ajax/page-views')
        .then(resp => {
            views.unique = resp.data.unique
            views.daily = resp.data.daily
        })
        .catch(handleError)
        .finally(() => loading.value = false)
}
</script>

<template>
    <div class="container max-w-3xl">
        <page-title>Post views</page-title>

        <spinner v-if="loading" />

        <tab-group v-else>
            <tab-list class="flex space-x-1 rounded-xl bg-gray-200 p-1">
                <tab
                    v-for="title in ['Unique views', 'Daily views']"
                    as="template"
                    v-slot="{ selected }"
                >
                    <button
                        :class="[
                          'w-full rounded-lg py-3 text-md font-medium leading-5',
                          'ring-white ring-opacity-60 ring-offset-2 ring-offset-gray-400 focus:outline-none focus:ring-2',
                          selected ? 'bg-white shadow' : 'hover:bg-white/50',
                        ]"
                      >
                          {{ title }}
                    </button>
                </tab>
            </tab-list>

            <tab-panels class="mt-5">
                <tab-panel>
                    <div>
                        <div class="overflow-x-auto shadow-md rounded-lg mx-auto">
                            <table class="table-auto w-full">
                                <thead class="bg-gray-500 text-white text-left">
                                <tr>
                                    <th
                                        v-for="title in ['Views', 'Page slug']"
                                        class="p-3 font-light"
                                    >
                                        {{ title }}
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr
                                    v-if="views.unique"
                                    v-for="view in views.unique"
                                    :key="view.id"
                                    class="border-b odd:bg-gray-50 transition-colors hover:bg-gray-100"
                                >
                                    <td class="px-3 py-1">{{ view.amount }}</td>
                                    <td class="px-3 py-1">{{ view.slug }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </tab-panel>

                <tab-panel>
                    <div>
                        <div class="overflow-x-auto shadow-md rounded-lg mx-auto">
                            <table class="table-auto w-full">
                                <thead class="bg-gray-500 text-white text-left">
                                <tr>
                                    <th
                                        v-for="title in ['Date', 'Views']"
                                        :key="title"
                                        class="p-3 font-light"
                                    >
                                        {{ title }}
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr
                                    v-for="view in views.daily"
                                    class="border-b odd:bg-gray-50 transition-colors hover:bg-gray-100"
                                >
                                    <td class="px-3 py-1">{{ view.date }}</td>
                                    <td class="px-3 py-1">{{ view.amount }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </tab-panel>
            </tab-panels>
      </tab-group>
    </div>
</template>
