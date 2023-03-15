<script setup lang="ts">
import type { Referrer } from '@shared/types/models'
import { onMounted, ref } from 'vue'
import axios from 'axios'
import handleError from '@admin/modules/handleError'
import PageTitle from '@admin/components/PageTitle.vue'
import Spinner from '@shared/components/Icons/Spinner.vue'
import DataTable from '@admin/components/DataTable/DataTable.vue'
import BodyDetail from '@admin/components/DataTable/BodyDetail.vue'
import BodyRow from '@admin/components/DataTable/BodyRow.vue'
import HeadDetail from '@admin/components/DataTable/HeadDetail.vue'

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

        <DataTable v-else class="max-w-[700px] mx-auto">
            <template #head>
                <HeadDetail
                    v-for="title in ['#', 'ID   ', 'Site', 'Hits', 'Last update']"
                    :key="title"
                >
                    {{ title }}
                </HeadDetail>
            </template>

            <BodyRow v-for="(referrer, index) in referrers" :key="referrer.id">
                <BodyDetail>{{ ++index }}</BodyDetail>
                <BodyDetail>{{ referrer.id }}</BodyDetail>
                <BodyDetail>
                    <a :href="`https://${referrer.site}`" target="_blank" class="underline">
                        {{ referrer.site }}
                    </a>
                </BodyDetail>
                <BodyDetail class="text-lg font-black text-main font-code">
                    {{ referrer.hits }}
                </BodyDetail>
                <BodyDetail>{{ referrer.pretty_updated_at }}</BodyDetail>
            </BodyRow>
        </DataTable>
    </div>
</template>
