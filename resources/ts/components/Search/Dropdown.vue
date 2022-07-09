<script setup lang="ts">
import { Search } from '../../types/types'
import History from './History.vue'
import NotFound from './NotFound.vue'
import DropdownItems from './DropdownItems.vue'

interface Props {
    search: Search
}

const { search } = defineProps<Props>()
</script>

<template>
    <div class="bg-page dark:bg-page-second shadow-xl p-6 top-[calc(100%+10px)] absolute left-0 right-0 z-50 rounded-3xl dark:border-2 dark:border-border">
        <history v-if="search.history.length > 0" :history="search.history" />

        <div v-else>
            <not-found v-if="search.posts.length === 0 && search.projects.length === 0" />

            <div v-else>
                <div class="flex flex-col md:flex-row justify-between relative" >
                    <dropdown-items
                        v-if="search.posts.length > 0"
                        heading="Posts"
                        :items="search.posts"
                        class="pr-2"
                        link-url="/posts/{slug}"
                    />

                    <dropdown-items
                        v-if="search.projects.length > 0"
                       heading="Projects"
                       :items="search.projects"
                       class="pl-2"
                       link-url="/projects/{slug}"
                    />
                </div>
            </div>
        </div>
    </div>
</template>
