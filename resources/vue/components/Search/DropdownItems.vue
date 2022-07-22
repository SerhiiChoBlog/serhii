<script setup lang="ts">
import type { SearchSuggestion } from '../../types/types'
import useSearch from '../../composables/useSearch'

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
                    class="hover:bg-page-hover transition-colors rounded-lg my-1 py-2 px-3 block hover:bg-page-second dark:hover:bg-border transition-colors"
                    @click="saveItemToHistory(item.title, `/posts/${item.slug}`)"
                    :class="{'!bg-main-light': item.selected}"
                >
                    {{ item.title }}
                </a>
            </li>
        </ul>
    </div>
</template>
