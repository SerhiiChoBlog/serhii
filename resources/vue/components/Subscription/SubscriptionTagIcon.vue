<script setup lang="ts">
import type { Tag } from '@/../types/models'

type Props = {
    tag: Tag
}

const { tag } = defineProps<Props>()
</script>

<template>
    <img
        :src="`/storage/tags/${tag.name}.webp`"
        :alt="`The ${tag.name} logo`"
        class="w-[25px] h-[25px]"
        width="200"
        height="200"
    />
</template>
