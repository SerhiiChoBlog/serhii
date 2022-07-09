<script setup lang="ts">
import type { SearchSuggestion } from '../../types/types'
import NotFound from './NotFound.vue'
import useSearch from '../../composables/useSearch'

interface Props {
    heading: string
    items: SearchSuggestion[]
    linkUrl: string
}

const { heading, items, linkUrl } = defineProps<Props>()
const { saveItemToHistory } = useSearch()
</script>

<template>
    <div class="flex-1">
        <h2 class="mx-2 mb-4 text-md text-main-dark font-bold">{{ heading }}</h2>

        <ul v-if="items.length > 0" class="text-xs leading-5 divide-y divide-border">
            <li v-for="item in items" :key="item.slug">
                <a
                    v-if="item.slug"
                    :href="linkUrl.replace('{slug}', item.slug)"
                    class="hover:bg-page-hover transition-colors rounded-md py-2 px-3"
                    @click="saveItemToHistory(item.title, linkUrl.replace('{slug}', item.slug))"
                >
                    <span>{{ item.title }}</span>
                </a>
            </li>
        </ul>

        <not-found v-else class="text-sm" />

        <a
            href="#"
            class="block bg-main text-white rounded-lg px-5 py-2 text-center text-sm mt-4 hover:bg-main-hover transition-colors"
        >
            Показать все
        </a>
    </div>
</template>
