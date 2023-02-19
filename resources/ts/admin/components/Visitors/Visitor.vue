<script setup lang="ts">
import type { Visitor } from '@shared/types/models'
import BodyDetail from '@admin/components/DataTable/BodyDetail.vue'
import BodyRow from '@admin/components/DataTable/BodyRow.vue'

type Props = {
    visitor: Visitor
}

const { visitor } = defineProps<Props>()
</script>

<template>
    <BodyRow>
        <BodyDetail>{{ visitor.id }}</BodyDetail>
        <BodyDetail>{{ visitor.post_views_count }}</BodyDetail>
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
        <BodyDetail>
            <button type="button">
                <span v-if="visitor.is_blocked"><i class="fas fa-check text-green-700"></i></span>
                <span v-else><i class="fas fa-ban text-red-700"></i></span>
            </button>
        </BodyDetail>
    </BodyRow>
</template>
