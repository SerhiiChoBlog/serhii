<script setup lang="ts">
import type { Tag } from '@shared/types/models'

type Props = {
    tag: Tag
}

type Emits = {
    (e: 'deleteTag', id: number): void
    (e: 'updateTagId', id: number): void
}

const props = defineProps<Props>()
const emit = defineEmits<Emits>()
</script>

<template>
    <span
        @click="emit('updateTagId', props.tag.id)"
        class="text-white py-1.5 px-3 rounded-lg font-light shadow-md text-xs border-2 border-transparent"
        :class="{
            '!border-page outline outline-black dark:outline-white': props.tag.pivot
                ? props.tag.pivot.is_main
                : false,
        }"
        :style="{ backgroundColor: props.tag.color }"
    >
        {{ props.tag.name }}

        <button @click="emit('deleteTag', props.tag.id)" type="button">
            <i class="fas fa-times ml-1 transition-transform hover:scale-125"></i>
        </button>

        <input type="hidden" name="tags[]" :value="props.tag.id" />
    </span>
</template>
