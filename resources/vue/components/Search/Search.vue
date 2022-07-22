<script setup lang="ts">
import type { Tag } from '../../types/types'
import useSearch from '../../composables/useSearch'
import SearchIcon from '../Icons/SearchIcon.vue'
import Dropdown from './Dropdown.vue'
import ArrowDownIcon from '../Icons/ArrowDownIcon.vue'
import { onMounted, ref } from 'vue'
import axios from 'axios'

const { search, input, fetchSearchSuggestions } = useSearch()
const popularTags = ref<Tag[]>([])

onMounted(fetchPopularTags)

function fetchPopularTags(): void {
    axios.get<Tag[]>('/api/tags/popular')
        .then(resp => popularTags.value = resp.data)
        .catch(err => console.error(err))
}

function scrollDown(): void {
    const elem = document.getElementById('home-decoration-lines')

    if (elem) {
        elem.scrollIntoView({ behavior: 'smooth', block: 'start' })
    }
}
</script>

<template>
    <div class="z-10 absolute top-1/2 -translate-y-1/2 -translate-x-1/2 left-1/2 text-center w-full">
        <h1 class="text-2xl lg:text-4xl relative">
            <span class="text-white drop-shadow-md">SERHII</span>
            <span class="text-main drop-shadow-md">CHO</span>
        </h1>

        <h2 class="text-white text-md lg:text-2xl mt-2 mx-4 leading-5">
            Blog about software development and productivity
        </h2>

        <div class="max-w-[85%] md:max-w-[600px] mx-auto">
            <div class="relative flex items-center justify-center mt-5 shadow-lg rounded-lg bg-page mx-auto dark:border dark:border-border">
                <form @submit.prevent class="w-full">
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

            <div class="min-h-[36px] mt-4 lg:mt-6 text-white inline-flex flex-wrap ml-2 gap-1 lg:gap-3">
                <a
                    v-for="tag in popularTags"
                    :key="tag.id"
                    :href="`/posts?tag=${tag.name}`"
                    class="text-[.8em] lg:text-lg inline-flex items-center p-1 transition-transform hover:scale-110"
                >
                    <b :style="{ color: tag.color }">&#x25C9;</b>
                    <span class="ml-1 lg:ml-2">{{ tag.name }}</span>
                </a>
            </div>

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
    </div>

    <button
        type="button"
        aria-label="Scroll down to the next section"
        class="absolute border border-white left-1/2 bottom-14 lg:bottom-20 text-white animate-bounce p-2 w-8 lg:w-10 ratio-square shadow-lg rounded-full flex items-center justify-center transition-colors duration-500 hover:border-main hover:text-main"
        @click="scrollDown"
    >
        <arrow-down-icon />
    </button>
</template>
