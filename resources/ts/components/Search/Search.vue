<script setup lang="ts">
import useSearch from '../../composables/useSearch'
import SearchIcon from '../Icons/SearchIcon.vue'
import Dropdown from './Dropdown.vue'

const { search, input, fetchSearchSuggestions } = useSearch()
</script>

<template>
    <div class="z-10 absolute top-1/2 -translate-y-1/2 -translate-x-1/2 left-1/2 text-center w-full">
        <h1 class="text-xl lg:text-4xl relative">
            <span class="text-gray-300 drop-shadow-md">SERHII</span>
            <span class="text-main drop-shadow-md">CHO</span>
        </h1>

        <h2 class="text-white text-md lg:text-2xl">
            Professional Full Stack developer
        </h2>

        <div class="relative max-w-[300px] md:max-w-[700px] mx-auto">
            <div class="flex items-center justify-center mt-5 shadow-lg rounded-lg overflow-hidden bg-white mx-auto">
                <form @submit.prevent class="w-full">
                    <search-icon
                        :class="{'animate-blink': search.loading}"
                        class="w-4 md:w-5 h-4 md:h-6 text-gray-400 absolute top-1/2 -translate-y-1/2 left-4 lg:left-5"
                    />

                    <input
                        type="search"
                        class="pl-10 pr-7 md:pl-14 py-3 md:py-4 text-sm md:text-xl w-full text-gray-500 rounded-lg outline-none"
                        placeholder="Search posts and projects"
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

            <dropdown v-if="search.query !== ''" :search="search" />
        </div>
    </div>
</template>
