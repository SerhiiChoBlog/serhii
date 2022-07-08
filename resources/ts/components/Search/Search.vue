<script setup lang="ts">
import SearchIcon from '../Icons/SearchIcon.vue'
import { reactive } from 'vue'
import { debounce } from 'lodash'
import { Search, SearchServerResponse } from '../../types/types'
import axios from 'axios'
import Dropdown from './Dropdown.vue'

const search = reactive<Search>({
    query: '',
    posts: [],
    projects: [],
})

const makeRequestToFetchItems = debounce<(q: string) => void>(q => {
    if (q === '') {
        search.posts = []
        search.projects = []
        return
    }

    axios.get<SearchServerResponse>(`/api/search/${q}`)
        .then(resp => {
            console.log(resp.data)
            search.posts = resp.data.posts
            search.projects = resp.data.projects
        })
        .catch(err => console.error(err))
}, 300)
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

        <div class="relative max-w-[300px] md:max-w-[600px] mx-auto">
            <div class="flex items-center justify-center mt-5 shadow-lg rounded-full overflow-hidden focus-within:ring-2 focus-within:ring-main bg-white mx-auto">
                <form @submit.prevent class="w-full">
                    <search-icon class="w-5 md:w-6 h-5 md:h-6 text-gray-400 absolute top-1/2 -translate-y-1/2 left-8" />

                    <input
                        type="text"
                        class="pl-3 md:pl-20 py-3 md:py-4 text-sm md:text-xl w-full"
                        placeholder="Enter a query to find post or project"
                        v-model="search.query"
                        @keyup="makeRequestToFetchItems(search.query)"
                    />
                </form>
            </div>

            <dropdown
                v-if="search.query !== '' && search.posts.length > 0 && search.projects.length > 0"
                :search="search"
            />
        </div>
    </div>
</template>
