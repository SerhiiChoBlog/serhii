<script setup lang="ts">
import { Tag } from '../../types/models'

type Props = {
    tag: Tag
}

const { tag } = defineProps<Props>()
</script>

<template>
    <span
        class="text-white py-1 px-2 rounded-md font-light shadow-md text-xs"
        :style="{ backgroundColor: tag.color }"
    >
        {{ tag.name }}

        <button type="button">
            <i class="fas fa-times ml-1 transition-transform hover:scale-125"></i>
        </button>
    </span>
</template>
