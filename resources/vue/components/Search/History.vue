<script setup lang="ts">
import type { SearchSuggestion } from '../../../types/types'

interface Props {
    history: SearchSuggestion[]
}

const { history } = defineProps<Props>()
</script>

<template>
    <div>
        <h3 class="mb-2 text-md text-font-second">
            Search History
        </h3>

        <div v-if="history.length > 0" class="flex flex-col">
            <a
                v-for="item in history.slice().reverse()"
               :key="item.title"
               :href="item.url"
               class="flex items-center gap-x-4 py-3 px-5 hover:bg-page-hover transition-colors rounded-lg text-sm"
            >
                <i class="lni lni-timer text-xl text-font-second font-bold"></i>
                <span>{{ item.title }}</span>
            </a>
        </div>
    </div>
</template>
