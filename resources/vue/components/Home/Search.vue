<script setup lang="ts">
import useSearch from '../../composables/useSearch'
import SearchIcon from '../Icons/SearchIcon.vue'
import Dropdown from './Dropdown.vue'
import ArrowDownIcon from '../Icons/ArrowDownIcon.vue'
import TagSuggestions from './TagSuggestions.vue'

const { search, input, fetchSearchSuggestions } = useSearch()
</script>

<template>
    <div class="max-w-[85%] md:max-w-[600px] mx-auto">
        <div class="relative flex items-center justify-center mt-5 shadow-lg rounded-lg bg-page mx-auto dark:border dark:border-border">
            <form @submit.prevent class="w-full m-0">
                <search-icon
                    :class="{ 'animate-blink': search.loading }"
                    class="w-4 md:w-5 h-4 md:h-6 text-gray-400 absolute top-1/2 -translate-y-1/2 left-4 lg:left-5"
                />

                <input
                    type="search"
                    class="pl-10 pr-7 md:pl-14 py-3 md:py-4 text-sm md:text-xl w-full text-gray-500 rounded-lg outline-none bg-page"
                    placeholder="Search blog posts"
                    v-model="search.query"
                    @input="e => {
                        search.query = e.target.value
                        fetchSearchSuggestions(e)
                    }"
                    ref="input"
                    autocomplete="off"
                />
            </form>

            <dropdown v-if="search.query !== ''" :search="search" />
        </div>

        <tag-suggestions />

        <div class="mt-4 lg:mt-6 left-0 right-0 text-center">
            <a
                href="/posts"
                class="inline-flex items-center px-7 lg:px-10 py-2 lg:py-3 text-white rounded-full text-md lg:text-lg border uppercase transition-colors hover:text-main hover:border-main duration-500"
            >
                <span>Read blog</span>
                <arrow-down-icon class="w-5 h-5 inline-block -rotate-90 ml-2" />
            </a>
        </div>
    </div>
</template>
