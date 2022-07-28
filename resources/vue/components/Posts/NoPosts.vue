<script setup lang="ts">
const linkClasses = 'px-10 py-2 border border-border rounded-full uppercase hover:border-main hover:text-main transition-colors'

type Emits = {
    (e: 'clearFilters'): void,
}

const emit = defineEmits<Emits>()
</script>

<template>
    <h2 class="text-center text-xl mt-5">
        There are no posts found
    </h2>

    <div class="flex gap-3 justify-center mt-5">
        <a href="/" :class="linkClasses">Go home</a>

        <button
            @click="emit('clearFilters')"
            type="button"
            :class="linkClasses"
        >
            Clear filters
        </button>
    </div>
</template>
