<script setup lang="ts">
import type { Visitor } from '@shared/types/models'
import type { Pagination } from '@shared/types/response'
import { onMounted, ref } from 'vue'
import axios from 'axios'
import handleError from '@admin/modules/handleError'
import PageTitle from '@admin/components/PageTitle.vue'
import Spinner from '@shared/components/Icons/Spinner.vue'
import DataTable from '@admin/components/DataTable/DataTable.vue'
import BodyDetail from '@admin/components/DataTable/BodyDetail.vue'
import BodyRow from '@admin/components/DataTable/BodyRow.vue'
import HeadDetail from '@admin/components/DataTable/HeadDetail.vue'

const visitors = ref<Visitor[]>([])
const loading = ref(false)
const requestParams = ref<{ search: string|null }>({
    search: null,
})

onMounted(() => {
    loading.value = true
    fetchVisitors()
})

function fetchVisitors(): void {
    axios.get<Pagination<Visitor[]>>('/admin/ajax/visitors', {
        params: requestParams.value,
    })
        .then(resp => {
            const data = resp.data

            visitors.value = data.data
        })
        .catch(handleError)
        .finally(() => loading.value = false)
}

function searchVisitors(): void {
    fetchVisitors()
}
</script>

<template>
    <div class="container max-w-3xl">
        <PageTitle>Unique visitors</PageTitle>

        <div class="text-center mb-4">
            <input
                type="search"
                class="px-5 py-2 border border-border rounded-md w-full mx-auto max-w-[500px]"
                placeholder="Enter you search query..."
                v-model="requestParams.search"
                @keyup="searchVisitors"
            />
        </div>

        <Spinner v-if="loading" />

        <DataTable v-else>
            <template #head>
                <HeadDetail class="w-16">Views</HeadDetail>
                <HeadDetail class="w-20">ID</HeadDetail>
                <HeadDetail class="w-36">IP</HeadDetail>
                <HeadDetail>Country, City, Code</HeadDetail>
            </template>

            <BodyRow v-for="visitor in visitors" :key="visitor.id">
                <BodyDetail>{{ visitor.post_views_count }}</BodyDetail>
                <BodyDetail>{{ visitor.id }}</BodyDetail>
                <BodyDetail>{{ visitor.ip }}</BodyDetail>
                <BodyDetail>
                    <div class="flex gap-2 items-center">
                        <img
                            v-if="visitor.code"
                            :src="`/storage/admin/flags/${visitor.code}.png`"
                            width="80"
                            height="42"
                            class="w-9 h-5 rounded-sm shadow-sm border border-border"
                        />
                        <img
                            v-else
                            src="/storage/admin/flags/unknown.png"
                            width="80"
                            height="56"
                        />

                        <div>
                            <span class="font-bold">{{ visitor.country || '-' }}</span>,
                            <span class="text-font-second">{{ visitor.city || '-' }}</span>,
                            <small>{{ visitor.code || '-' }}</small>
                        </div>
                    </div>
                </BodyDetail>
            </BodyRow>
        </DataTable>

        <button
            type="button"
            class="block mx-auto mt-4 px-7 py-2 border border-border rounded-md hover:bg-page-second"
        >
            Load more
        </button>
    </div>
</template>
