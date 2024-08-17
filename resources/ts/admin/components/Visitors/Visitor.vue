<script setup lang="ts">
import type { Visitor } from '@shared/types/models'
import BodyDetail from '@admin/components/DataTable/BodyDetail.vue'
import BodyRow from '@admin/components/DataTable/BodyRow.vue'
import useBlockVisitor from '@admin/composables/useBlockVisitor'

type Props = {
    visitor: Visitor
}

type Emits = {
    (e: 'refreshVisitors'): void
}

const emit = defineEmits<Emits>()
const props = defineProps<Props>()
const { blockVisitor } = useBlockVisitor()

function blockVisitorHandler(): void {
    const message = props.visitor.is_blocked
        ? 'Are you sure you want to unblock this visitor?'
        : 'Are you sure you want to block this visitor?'

    if (!confirm(message)) return

    blockVisitor(props.visitor.id, !props.visitor.is_blocked)
    emit('refreshVisitors')
}
</script>

<template>
    <BodyRow>
        <BodyDetail>{{ props.visitor.id }}</BodyDetail>
        <BodyDetail class="text-center">
            <span v-if="props.visitor.is_robot">🤖</span>
            <span v-else>👦🏻</span>
        </BodyDetail>
        <BodyDetail>{{ props.visitor.ip }}</BodyDetail>
        <BodyDetail>
            <img
                v-if="props.visitor.code"
                :src="`/storage/admin/flags/${props.visitor.code.toLowerCase()}.png`"
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
        </BodyDetail>
        <BodyDetail>{{ props.visitor.country || '-' }}</BodyDetail>
        <BodyDetail>{{ props.visitor.city || '-' }}</BodyDetail>
        <BodyDetail>{{ props.visitor.post_views_count }}</BodyDetail>
        <BodyDetail>
            <button @click="blockVisitorHandler" type="button">
                <span v-if="props.visitor.is_blocked"
                    ><i class="fas fa-check text-green-700"></i
                ></span>
                <span v-else><i class="fas fa-ban text-red-700"></i></span>
            </button>
        </BodyDetail>
    </BodyRow>
</template>
