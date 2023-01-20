<script setup lang="ts">
type Props = {
    title: string
}

const { title } = defineProps<Props>()
</script>

<template>
    <div class="flex justify-between items-center min-w-[500px] text-lg">
        <span>{{ title }}:</span>

        <div class="border-b border-dashed mx-3 w-full"></div>

        <div class="text-right">
            <slot />
        </div>
    </div>
</template>