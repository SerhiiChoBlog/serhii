<script setup lang="ts">
import type { SearchResult } from '@shared/types'

defineProps<{ items: SearchResult[] }>()
</script>

<template>
    <div class="flex-1">
        <ul class="text-md leading-5">
            <li v-for="item in items" :key="item.url" class="text-left">
                <a
                    :href="item.url"
                    class="py-1.5 text-font px-3 flex items-center gap-4 hover:bg-page-second dark:hover:bg-border transition-colors"
                    :class="{ 'bg-black/10 dark:bg-white/10!': item.selected }"
                >
                    <img
                        v-if="item.image_url"
                        :src="`/${item.image_url}`"
                        :alt="item.title"
                        width="90"
                        height="49"
                        class="rounded-md w-16 lg:w-24"
                    />

                    <div v-else class="rounded-md bg-page-second w-16 lg:w-24 h-[49px]"></div>

                    <div>
                        <span class="font-bold">{{ item.title }}</span>

                        <div class="flex flex-wrap gap-x-1 text-font-second opacity-70">
                            <div v-for="(keyword, i) in item.keywords" :key="item.url">
                                {{ keyword }}
                                <span v-if="i !== item.keywords.length - 1">,</span>
                            </div>
                        </div>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</template>
