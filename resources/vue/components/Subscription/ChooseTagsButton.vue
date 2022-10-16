<script setup lang="ts">
import ChevronDown from '@/components/Icons/ChevronDownIcon.vue'

type Emits = {
    (e: 'clicked'): void
}

const emit = defineEmits<Emits>()
</script>

<template>
    <button
        @click="emit('clicked')"
        type="button"
        class="inline-flex items-center justify-center gap-1 bg-gray-700 text-gray-100 h-full px-4 rounded-full min-w-[150px] transition-shadow shadow-md hover:shadow-none"
    >
        <span>All</span> <chevron-down class="w-5 h-5" />
    </button>
</template>
