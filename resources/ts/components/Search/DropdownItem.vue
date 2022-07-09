<script setup lang="ts">
import NotFound from './NotFound.vue'
import useSearch from '../../composables/useSearch'

interface Props {
    heading: string
    items: Specialist[] | Service[]
    linkUrl: string
}

const { heading, items, linkUrl } = defineProps<Props>()

const { saveItemToHistory } = useSearch()
</script>

<template>
    <div class="flex-1">
        <h2 class="mx-2 mb-4 text-md text-main-dark font-bold">{{ heading }}</h2>

        <ul v-if="items.length > 0" class="text-xs leading-5 divide-y divide-border">
            <li v-for="item in items" :key="item.id">
                <a
                    :href="linkUrl.replace('{id}', item.id)"
                    class="flex justify-between gap-x-3 items-center hover:bg-page-hover transition-colors rounded-md py-2 px-3"
                    @click="() => saveItemToHistory(item.name || item.title, linkUrl.replace('{id}', item.id))"
                >
                    <span>{{ item.name || item.title }}</span>

                    <span class="flex-none font-bold text-main-dark bg-main-extra-light px-2 py-1 rounded-md">
                        {{ item.pretty_price }}
                    </span>
                </a>
            </li>
        </ul>

        <NotFound v-else class="text-sm" />

        <a href="#" class="block bg-main-dark text-white rounded-lg px-5 py-2 text-center text-sm mt-4 hover:bg-main-dark-hover transition-colors">
            {{ $trans.get('common.show_all') }}
        </a>
    </div>
</template>
