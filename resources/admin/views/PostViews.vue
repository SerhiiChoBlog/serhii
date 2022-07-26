<script setup lang="ts">
import PageTitle from '../components/PageTitle.vue'
import { reactive } from 'vue'
import type { PageView } from '../../types/models'

type Views = {
    unique: PageView[] | null
    daily: PageView[] | null
}

const views = reactive<Views>({
    unique: null,
    daily: null,
})
</script>

<template>
    <div class="container max-w-3xl">
        <page-title>Post views</page-title>

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
    </div>
</template>
