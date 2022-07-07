<script setup lang="ts">
import SearchIcon from '../Icons/SearchIcon.vue'</script>

<template>
    <div class="z-10 absolute top-1/2 -translate-y-1/2 -translate-x-1/2 left-1/2 text-center">
        <h1 class="text-xl lg:text-4xl relative">
            <span class="text-gray-300 drop-shadow-md">SERHII</span>
            <span class="text-main drop-shadow-md">CHO</span>
        </h1>

        <h2 class="text-white text-md lg:text-2xl">
            Professional Full Stack developer
        </h2>

        <div class="flex items-center justify-center mt-5">
            <form class="flex shadow-lg rounded-md overflow-hidden focus-within:ring-2 focus-within:ring-main">
                <input
                    type="text"
                    class="px-6 py-4 text-xl w-[500px]"
                    placeholder="Enter post title, project or anything else"
                />

                <button class="flex items-center justify-center px-4 bg-white">
                    <search-icon class="w-6 h-6 text-gray-600 stroke-gray-400" />
                </button>
            </form>
        </div>
    </div>
</template>
