<script setup lang="ts">
import useSearch from '@/composables/useSearch'
import SearchIcon from '@shared/components/Icons/SearchIcon.vue'
import Dropdown from '@/components/Search/Dropdown.vue'
import AppearTransition from '@shared/components/Transitions/AppearTransition.vue'

const { search, input, changedInput } = useSearch()
</script>

<template>
    <appear-transition>
        <div class="w-full mx-auto max-w-[85%] md:max-w-[550px] min-w-[400px]">
            <label
                for="navbar-search-input"
                class="relative flex items-center justify-center rounded-full mx-auto bg-black/25"
            >
                <form @submit.prevent class="w-full m-0">
                    <search-icon
                        :class="{ 'animate-blink': search.loading }"
                        class="w-4 md:w-5 h-4 md:h-6 text-gray-400 absolute top-1/2 -translate-y-1/2 left-4 lg:left-5"
                    />

                    <input
                        ref="input"
                        type="search"
                        placeholder="Search blog posts"
                        @input="changedInput"
                        autocomplete="off"
                        class="pl-12 pr-7 md:pl-14 w-full text-gray-500 rounded-full outline-none py-1 text-xs md:text-lg bg-transparent"
                        id="navbar-search-input"
                    />
                </form>

                <dropdown v-if="search.query !== ''" :search="search" />
            </label>
        </div>
    </appear-transition>
</template>
