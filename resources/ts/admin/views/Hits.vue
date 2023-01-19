<script setup lang="ts">
import { Hit } from '@shared/types/models'
import { onMounted, ref } from 'vue'
import axios from 'axios'
import handleError from '@admin/modules/handleError'
import PageTitle from '@admin/components/PageTitle.vue'
import Spinner from '@shared/components/Icons/Spinner.vue'
import DataTable from '@admin/components/DataTable/DataTable.vue'
import BodyDetail from '@admin/components/DataTable/BodyDetail.vue'
import BodyRow from '@admin/components/DataTable/BodyRow.vue'
import HeadDetail from '@admin/components/DataTable/HeadDetail.vue'

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
        <PageTitle>Request hits</PageTitle>

        <Spinner v-if="loading" />

        <DataTable v-else>
            <template v-slot:head>
                <HeadDetail
                    v-for="title in ['Date', 'Hits']"
                    :key="title"
                >
                    {{ title }}
                </HeadDetail>
            </template>

            <BodyRow v-for="hit in hits" :key="hit.id">
                <BodyDetail>{{ hit.created_at }}</BodyDetail>
                <BodyDetail>{{ hit.amount }}</BodyDetail>
            </BodyRow>
        </DataTable>
    </div>
</template>
