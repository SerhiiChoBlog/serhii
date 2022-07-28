<script setup lang="ts">
import type { Tag } from '../../../../types/models'

type Props = {
    tag: Tag
}

const { tag } = defineProps<Props>()
</script>

<template>
    <div
        class="py-[3px] inline-block font-white px-2 rounded-md text-white text-xs flex-shrink-0"
        :style="{ backgroundColor: tag.color }"
    >
        {{ tag.name }}
    </div>
</template>
