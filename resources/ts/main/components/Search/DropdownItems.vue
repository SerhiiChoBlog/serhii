<script setup lang="ts">
import type { SearchSuggestion } from '@shared/types'

interface Props {
    items: SearchSuggestion[]
}

const { items } = defineProps<Props>()

function getAllKeywords(item: SearchSuggestion): string[] {
    return [...item.tags, ...item.keywords]
}
</script>

<template>
    <div class="flex-1">
        <ul class="text-md leading-5">
            <li v-for="item in items" :key="item.slug" class="text-left">
                <a
                    :href="`/posts/${item.slug}`"
                    class="py-1.5 text-font px-3 flex items-center gap-4 hover:bg-page-second dark:hover:bg-border transition-colors"
                    :class="{ 'bg-black/10 dark:bg-white/10!': item.selected }"
                >
                    <img
                        :src="`/${item.image_xs}`"
                        :alt="item.title"
                        width="90"
                        height="49"
                        class="rounded-md w-16 lg:w-24"
                    />

                    <div>
                        <span class="font-bold">{{ item.title }}</span>

                        <div
                            class="flex flex-wrap gap-x-1 text-font-second opacity-70"
                        >
                            <div v-for="(tag, i) in getAllKeywords(item)" :key="tag">
                                {{ tag }}
                                <span v-if="i !== getAllKeywords(item).length - 1">,</span>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</template>
