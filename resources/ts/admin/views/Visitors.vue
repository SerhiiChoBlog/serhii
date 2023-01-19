<script setup lang="ts">
import type { Visitor } from '@shared/types/models'
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
        <PageTitle>Unique visitors</PageTitle>

        <Spinner v-if="loading" />

        <DataTable v-else>
            <HeadDetail
                v-for="title in ['Views', 'IP', 'Country', 'City', 'Flag']"
                :key="title"
            >
                {{ title }}
            </HeadDetail>

            <BodyRow v-for="visitor in visitors" :key="visitor.id">
                <BodyDetail>{{ visitor.post_views_count }}</BodyDetail>
                <BodyDetail>{{ visitor.ip }}</BodyDetail>
                <BodyDetail>{{ visitor.country || '-' }}</BodyDetail>
                <BodyDetail>{{ visitor.city || '-' }}</BodyDetail>
                <BodyDetail>
                    <img
                        v-if="visitor.code"
                        :src="`/storage/admin/flags/${visitor.code}.png`"
                        width="30"
                    />
                    <img v-else src="/storage/admin/flags/unknown.png" width="30" />
                </BodyDetail>
            </BodyRow>
        </DataTable>
    </div>
</template>
