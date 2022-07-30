<script setup lang="ts">
import type { Tag } from '../../../types/models'
import { onMounted, ref } from 'vue'
import axios from 'axios'

const popularTags = ref<Tag[]>([])

onMounted(fetchPopularTags)

function fetchPopularTags(): void {
    axios.get<Tag[]>('/api/tags/popular')
        .then(resp => popularTags.value = resp.data)
        .catch(err => console.error(err))
}
</script>

<template>
    <div class="min-h-[36px] mt-4 lg:mt-6 text-white inline-flex flex-wrap gap-1 lg:gap-3">
        <a
            v-for="tag in popularTags"
            :key="tag.id"
            :href="`/posts?tag=${tag.name}`"
            class="text-[.8em] lg:text-lg inline-flex items-center p-1 transition-transform hover:scale-110"
        >
            <b :style="{ color: tag.color }">&#x25C9;</b>
            <span class="ml-1 lg:ml-2">{{ tag.name }}</span>
        </a>
    </div>
</template>
