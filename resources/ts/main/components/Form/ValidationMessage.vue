<script setup lang="ts">
type Props = {
    message?: string | null
}

const props = defineProps<Props>()
</script>

<template>
    <span
        v-if="message"
        class="text-sm text-red-600 leading-4 block mt-1 ml-1"
        role="alert"
    >
        {{ props.message }}
    </span>
</template>
