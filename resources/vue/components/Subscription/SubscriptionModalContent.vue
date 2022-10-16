<script setup lang="ts">
import type { Tag } from '@/../types/models'

type Props = {
    tags: Tag[]
}

const { tags } = defineProps<Props>()
</script>

<template>
    <ul>
        <li v-for="tag in tags" :key="tag.id">
            <span>{{ tag.name }}</span>
        </li>
    </ul>
</template>
