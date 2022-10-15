<script setup lang="ts">
type Props = {
    tagName: string
}

const { tagName } = defineProps<Props>()
</script>

<template>
    <img
        :src="`/storage/tags/${tagName}.webp`"
        width="200"
        height="200"
        class="w-[20px] h-[20px]"
        :alt="`Logo of ${tagName}`"
    />
</template>
