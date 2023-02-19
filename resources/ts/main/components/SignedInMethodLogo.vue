<script setup lang="ts">
import type { User } from '@shared/types/models'

type Props = {
    method: User['sign_in_method']
}

const { method } = defineProps<Props>()
</script>

<template>
    <img
        v-if="method !== 'email'"
        :src="`/storage/icons/${method}.webp`"
        :alt="`${method}'s logo`"
        width="100"
        height="100"
        class="bg-page rounded-full shadow-md p-0.5"
    />
</template>
