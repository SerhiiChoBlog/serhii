<script setup lang="ts">
type Props = {
    nextPageUrl: string
}

type Emits = {
    (e: 'clicked'): void
}

const emit = defineEmits<Emits>()
const props = defineProps<Props>()
</script>

<template>
    <div class="text-center mt-7">
        <button
            class="border border-border px-10 py-3 rounded-full uppercase font-bold text-sm text-font-second hover:border-main transition-colors hover:text-main"
            @click="emit('clicked')"
        >
            <i class="fas fa-sync mr-3"></i>
            Load more
        </button>
    </div>
</template>
