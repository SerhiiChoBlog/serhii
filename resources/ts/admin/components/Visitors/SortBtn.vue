<script setup lang="ts">
type Emits = {
    (e: 'order'): void
    (e: 'direction'): void
}

const emit = defineEmits<Emits>()
</script>

<template>
    <div class="flex gap-1">
        <button
            @click="emit('direction')"
            type="button"
            aria-label="Set order direction"
            class="hover:text-gray-200"
        >
            x
        </button>

        <button
            @click="emit('order')"
            type="button"
            class="hover:text-gray-200"
            aria-label="Sort visitors"
        >
            <slot />
        </button>
    </div>
</template>
