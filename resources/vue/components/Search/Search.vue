<script setup lang="ts">
import useSearch from '../../composables/useSearch'
import SearchIcon from '../Icons/SearchIcon.vue'
import Dropdown from './Dropdown.vue'
import ArrowDownIcon from '../Icons/ArrowDownIcon.vue'

const { search, input, fetchSearchSuggestions } = useSearch()

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

        <div class="relative max-w-[85%] sm:max-w-[300px] md:max-w-[600px] mx-auto">
            <div class="flex items-center justify-center mt-5 shadow-lg rounded-full overflow-hidden bg-white mx-auto">
                <form @submit.prevent class="w-full">
                    <search-icon
                        :class="{ 'animate-blink': search.loading }"
                        class="w-4 md:w-5 h-4 md:h-6 text-gray-400 absolute top-1/2 -translate-y-1/2 left-4 lg:left-5"
                    />

                    <input
                        type="search"
                        class="pl-10 pr-7 md:pl-14 py-3 md:py-4 text-sm md:text-xl w-full text-gray-500 rounded-lg outline-none"
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
            </div>

            <div class="absolute mt-7 md:mt-10 left-0 right-0 text-center">
                <a
                    href="/posts"
                    class="px-7 md:px-10 py-2 md:py-4 text-white rounded-full text-md md:text-lg border uppercase transition-colors hover:text-main hover:border-main duration-500 border-r-2 border-l-2"
                >
                    Read blog
                </a>
            </div>

            <dropdown v-if="search.query !== ''" :search="search" />
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
