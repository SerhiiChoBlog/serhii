<script setup lang="ts">
type Props = {
    headline: string
    subHeadline: string
}

const { headline, subHeadline } = defineProps<Props>()
</script>

<template>
    <h2 class="text-2xl lg:text-4xl text-main">{{ headline }}</h2>
    <h3 class="text-font-second max-w-[430px]">{{ subHeadline }}</h3>
</template>
