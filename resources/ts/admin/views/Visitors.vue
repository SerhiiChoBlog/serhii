<script setup lang="ts">
import type { Visitor } from '@shared/types/models'
import type { Pagination } from '@shared/types/response'
import { onMounted, ref } from 'vue'
import axios from 'axios'
import handleError from '@admin/modules/handleError'
import PageTitle from '@admin/components/PageTitle.vue'
import Spinner from '@shared/components/Icons/Spinner.vue'
import DataTable from '@admin/components/DataTable/DataTable.vue'
import HeadDetail from '@admin/components/DataTable/HeadDetail.vue'
import LoadMoreButton from '@shared/components/LoadMoreButton.vue'
import VisitorComponent from '@admin/components/Visitors/Visitor.vue'
import SortBtn from '@admin/components/Visitors/SortBtn.vue'

type RequestParams = {
    search: string|null
    order: keyof Visitor
}

const visitors = ref<Visitor[]>([])
const nextPageUrl = ref<string | null>(null)
const loading = ref(false)
const defaultUri = '/admin/ajax/visitors'
const requestParams = ref<RequestParams>({
    search: null,
    order: 'id',
})

onMounted(() => {
    loading.value = true
    fetchVisitors(defaultUri, true)
})

function fetchVisitors(url: string, refresh = true): void {
    axios.get<Pagination<Visitor[]>>(url, {
        params: requestParams.value,
    })
        .then(resp => {
            const data = resp.data

            nextPageUrl.value = data.next_page_url

            refresh
                ? visitors.value = data.data
                : visitors.value.push(...data.data)
        })
        .catch(handleError)
        .finally(() => loading.value = false)
}

function searchVisitors(): void {
    fetchVisitors(defaultUri, true)
}

function loadMoreVisitors(): void {
    if (nextPageUrl.value) {
        fetchVisitors(nextPageUrl.value, false)
    }
}

function sortVisitors(orderBy: keyof Visitor): void {
    requestParams.value.order = orderBy
    fetchVisitors(defaultUri, true)
}
</script>

<template>
    <div class="container max-w-3xl">
        <PageTitle>Visitors</PageTitle>

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
                <HeadDetail class="w-20">
                    <SortBtn @click="sortVisitors('id')">ID</SortBtn>
                </HeadDetail>
                <HeadDetail class="w-36">
                    <SortBtn @click="sortVisitors('ip')">IP</SortBtn>
                </HeadDetail>
                <HeadDetail class="w-14">
                    <SortBtn @click="sortVisitors('code')">Flag</SortBtn>
                </HeadDetail>
                <HeadDetail>
                    <SortBtn @click="sortVisitors('country')">Country</SortBtn>
                </HeadDetail>
                <HeadDetail>
                    <SortBtn @click="sortVisitors('city')">City</SortBtn>
                </HeadDetail>
                <HeadDetail class="w-16">
                    <SortBtn @click="sortVisitors('post_views_count')">Views</SortBtn>
                </HeadDetail>
                <HeadDetail>
                    <SortBtn @click="sortVisitors('is_blocked')">Ban</SortBtn>
                </HeadDetail>
            </template>

            <VisitorComponent
                v-for="visitor in visitors"
                :key="visitor.id"
                :visitor="visitor"
                @refreshVisitors="fetchVisitors(defaultUri, true)"
            />
        </DataTable>

        <LoadMoreButton
            v-if="nextPageUrl"
            :nextPageUrl="nextPageUrl"
            @clicked="loadMoreVisitors"
        />
    </div>
</template>
