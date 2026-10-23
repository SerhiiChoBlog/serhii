<script setup lang="ts">
import type { User } from '@shared/types/models'

type Props = {
    user: User | null
}

defineProps<Props>()
</script>

<template>
    <div class="w-[38px] lg:w-[43px] mt-2">
        <img
            :src="`/storage/avatars/${user ? user.avatar : 'default.svg'}`"
            :alt="`${user ? user.name : 'Default'} avatar`"
            class="w-8 lg:w-10 aspect-square rounded-full shadow-md"
            width="400"
            height="400"
        />
    </div>
</template>
