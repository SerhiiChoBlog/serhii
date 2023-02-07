<script setup lang="ts">
import type { Badge } from '@shared/types'
import Tip from '@shared/components/Tip.vue'

type Props = {
    badge: Badge
    tip: string
}

const { badge, tip } = defineProps<Props>()
</script>

<template>
    <Tip :content="tip">
        <img
            :src="`/storage/badges/${badge}.png`"
            :alt="`Badge for ${badge}`"
            width="270"
            height="270"
            class="drop-shadow-md"
        />
    </Tip>
</template>
