<script setup lang="ts">
import type { Tag } from '../../types/models'

type Props = {
    tags: Tag[]
}

type Emits = {
    (e: 'chosen', id: number): void
}

const emit = defineEmits<Emits>()
const { tags } = defineProps<Props>()
</script>

<template>
    <div class="flex gap-1 flex-wrap">
        <button
            v-for="tag in tags"
            :key="tag.id"
            aria-label="Post tag"
            @click="emit('chosen', tag.id)"
        >
            <span
                class="cursor-pointer inline-flex items-center px-3 py-0.5 rounded-md text-xs font-bold leading-5 text-white bg-brand-500 transition-transform hover:scale-105 duration-300"
                :style="{ backgroundColor: tag.color }"
            >
                {{ tag.name }}
            </span>
        </button>
    </div>
</template>
