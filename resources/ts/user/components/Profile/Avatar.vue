<script setup lang="ts">
import { User } from '@shared/types/models'

type Props = {
    user: User
}

const { user } = defineProps<Props>()
</script>

<template>
    <img
        :src="`/storage/avatars/${user.avatar}`"
        :alt="`${user.name}'s avatar`"
        width="200"
        height="200"
        class="w-full max-w-[250px] mx-auto lg:mx-0 rounded-full shadow-lg pointer-events-none"
    />
</template>
