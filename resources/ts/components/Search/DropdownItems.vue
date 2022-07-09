<script setup lang="ts">
import type { SearchSuggestion } from '../../types/types'
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
        <h2 class="mx-2 mb-2 text-lg text-main-dark font-bold">{{ heading }}</h2>

        <ul class="text-md leading-5 divide-y divide-border">
            <li v-for="item in items" :key="item.slug" class="text-left">
                <a
                    v-if="item.slug"
                    :href="linkUrl.replace('{slug}', item.slug)"
                    class="hover:bg-page-hover transition-colors py-2 px-3 block hover:bg-page-second dark:hover:bg-border transition-colors"
                    @click="saveItemToHistory(item.title, linkUrl.replace('{slug}', item.slug))"
                    :class="{'bg-main': item.selected}"
                >
                    {{ item.title }}
                </a>
            </li>
        </ul>
    </div>
</template>
