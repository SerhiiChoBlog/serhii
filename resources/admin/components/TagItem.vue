<script setup lang="ts">
import { Tag } from '../../types/models'

type Props = {
    tag: Tag
}

type Emits = {
    (e: 'deleteTag', id: number): void
}

const { tag } = defineProps<Props>()
const emit = defineEmits<Emits>()
</script>

<template>
    <span
        class="text-white py-1 px-2 rounded-md font-light shadow-md text-xs"
        :style="{ backgroundColor: tag.color }"
    >
        {{ tag.name }}

        <button type="button" @click="emit('deleteTag', tag.id)">
            <i class="fas fa-times ml-1 transition-transform hover:scale-125"></i>
        </button>

        <input type="hidden" name="tags[]" :value="tag.id">
    </span>
</template>
