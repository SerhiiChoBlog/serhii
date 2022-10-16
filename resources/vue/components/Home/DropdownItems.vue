<script setup lang="ts">
import type { SearchSuggestion } from '@/../types/types'
import useSearch from '@/composables/useSearch'

interface Props {
    items: SearchSuggestion[]
}

const { items } = defineProps<Props>()
const { saveItemToHistory } = useSearch()
</script>

<template>
    <div class="flex-1 pr-2">
        <ul class="text-md leading-5 divide-y divide-border">
            <li v-for="item in items" :key="item.slug" class="text-left">
                <a
                    v-if="item.slug"
                    :href="`/posts/${item.slug}`"
                    class="rounded-lg my-1 py-2 px-3 flex items-center gap-4 hover:bg-page-second dark:hover:bg-border transition-colors"
                    @click="saveItemToHistory(item.title, `/posts/${item.slug}`)"
                    :class="{ '!bg-main-light text-black': item.selected }"
                >
                    <div class="hidden md:block">
                        <img
                            v-if="item.image_sm"
                            :src="item.image_sm"
                            :alt="item.title"
                            width="90"
                            height="49"
                            class="rounded-md"
                        />
                    </div>
                    <div>
                        <span class="font-bold">{{ item.title }}</span>

                        <div class="flex flex-wrap gap-1 mt-2">
                            <span
                                v-if="item.tags"
                                v-for="tag in item.tags"
                                :key="tag.name"
                                class="inline-flex items-center px-1 lg:px-2 py-0 lg:py-[1px] rounded-md text-[.7em] lg:text-xs font-bold leading-5 text-white bg-brand-500"
                                :style="{ backgroundColor: tag.color }"
                            >
                                {{ tag.name }}
                            </span>
                        </div>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</template>
