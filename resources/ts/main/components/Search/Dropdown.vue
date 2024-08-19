<script setup lang="ts">
import { Search } from '@shared/types'
import NotFound from './NotFound.vue'
import DropdownItems from './DropdownItems.vue'
import ReloadIcon from '@shared/components/Icons/ReloadIcon.vue'

interface Props {
    search: Search
}

const { search } = defineProps<Props>()
</script>

<template>
    <div
        class="bg-page dark:bg-page-second shadow-xl top-[calc(100%+9px)] absolute left-0 right-0 z-50 rounded-lg dark:border-2 dark:border-border min-h-[50px] max-h-[600px] overflow-y-auto"
    >
        <div>
            <div v-if="search.loading" class="py-8 flex items-center justify-center">
                <reload-icon class="animate-spin w-6 h-6" />
            </div>

            <div
                v-else-if="!search.loading && search.posts.length === 0"
                class="py-8 flex items-center justify-center"
            >
                <not-found />
            </div>

            <div v-else>
                <dropdown-items
                    v-if="search.posts.length > 0"
                    :items="search.posts"
                />
            </div>
        </div>
    </div>
</template>
