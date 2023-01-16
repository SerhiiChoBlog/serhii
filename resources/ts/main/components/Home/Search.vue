<script setup lang="ts">
import useSearch from '@/composables/useSearch'
import SearchIcon from '@shared/components/Icons/SearchIcon.vue'
import Dropdown from '@/components/Home/Dropdown.vue'
import AppearTransition from '@shared/components/Transitions/AppearTransition.vue'

const { search, input, fetchSearchSuggestions } = useSearch()
</script>

<template>
    <appear-transition>
        <div class="max-w-[85%] md:max-w-[600px] mx-auto">
            <label for="search-input" class="relative flex items-center justify-center mt-5 shadow-lg rounded-lg bg-page mx-auto dark:border dark:border-border">
                <form @submit.prevent class="w-full m-0">
                    <search-icon
                        :class="{ 'animate-blink': search.loading }"
                        class="w-4 md:w-5 h-4 md:h-6 text-gray-400 absolute top-1/2 -translate-y-1/2 left-4 lg:left-5"
                    />

                    <input
                        type="search"
                        class="pl-10 pr-7 md:pl-14 py-3 md:py-4 text-sm md:text-xl w-full text-gray-500 rounded-lg outline-none bg-page dark:bg-page-second"
                        placeholder="Search blog posts"
                        v-model="search.query"
                        id="search-input"
                        @input="(e: Event) => {
                            search.query = (e.target as HTMLInputElement).value
                            fetchSearchSuggestions(e as KeyboardEvent)
                        }"
                        ref="input"
                        autocomplete="off"
                    />
                </form>

                <dropdown v-if="search.query !== ''" :search="search" />
            </label>
        </div>
    </appear-transition>
</template>
