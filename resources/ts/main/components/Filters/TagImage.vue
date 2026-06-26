<script setup lang="ts">
defineProps<{ tagName: string }>()
</script>

<template>
    <img
        :src="`/img/tags/${tagName}.webp`"
        width="200"
        height="200"
        class="w-5 h-5"
        :alt="`Logo of ${tagName}`"
    />
</template>
