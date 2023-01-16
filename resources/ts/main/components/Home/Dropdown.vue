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
    <div class="bg-page dark:bg-page-second shadow-xl p-2 top-[calc(100%+10px)] absolute left-0 right-0 z-50 rounded-lg dark:border-2 dark:border-border min-h-[50px]">
        <div>
            <reload-icon v-if="search.loading" class="animate-spin w-6 h-6 absolute left-1/2 -ml-3 top-[13px]" />
            <not-found v-else-if="!search.loading && search.posts.length === 0" />

            <div v-else>
                <dropdown-items
                    v-if="search.posts.length > 0"
                    :items="search.posts"
                />
            </div>
        </div>
    </div>
</template>
