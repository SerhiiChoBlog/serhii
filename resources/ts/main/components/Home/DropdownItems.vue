<script setup lang="ts">
import type { SearchSuggestion } from '@shared/types'

interface Props {
    items: SearchSuggestion[]
}

const { items } = defineProps<Props>()
</script>

<template>
    <div class="flex-1">
        <ul class="text-md leading-5 divide-y divide-border">
            <li v-for="item in items" :key="item.slug" class="text-left">
                <a
                    :href="`/posts/${item.slug}`"
                    class="rounded-lg my-1 py-1 px-3 flex items-center gap-4 hover:bg-page-second dark:hover:bg-border transition-colors"
                    :class="{ '!bg-main-light text-black': item.selected }"
                >
                    <img
                        :src="item.image_xs"
                        :alt="item.title"
                        width="90"
                        height="49"
                        class="rounded-md w-16"
                    />

                    <span class="font-bold">{{ item.title }}</span>
                </a>
            </li>
        </ul>
    </div>
</template>
