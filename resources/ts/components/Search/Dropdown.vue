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
    <div class="bg-white shadow-xl p-6 top-[45px] lg:top-[calc(100%+5px)] border-t bg-white absolute left-0 right-0 z-50 lg:rounded-3xl rounded-none">
        <history v-if="search.history.length > 0" :history="search.history" />

        <div v-else>
            <not-found v-if="search.posts.length === 0 && search.projects.length === 0" />

            <div v-else>
                <div class="flex justify-between relative after:content-'' after:w-[1px] after:absolute after:h-full after:top-0 after:bg-red-500 after:left-1/2 after:bg-border">
                    <dropdown-items
                        heading="Posts"
                        :items="search.posts"
                        class="pr-2"
                        link-url="/posts/{slug}"
                    />

                    <dropdown-items
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
