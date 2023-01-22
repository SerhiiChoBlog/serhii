<script setup lang="ts">
import type { Badge } from '@shared/types'
import Tip from '@/components/Tip.vue'

type Props = {
    badge: Badge
}

const { badge } = defineProps<Props>()
</script>

<template>
    <Tip content="User verified achievement">
        <img
            :src="`/storage/badges/${badge}.png`"
            :alt="`Badge for ${badge}`"
            width="270"
            height="270"
            class="drop-shadow-md"
        />
    </Tip>
</template>
