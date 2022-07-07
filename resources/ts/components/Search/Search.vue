<script setup lang="ts">
import SearchIcon from '../Icons/SearchIcon.vue'</script>

<template>
    <div class="z-10 absolute top-1/2 -translate-y-1/2 -translate-x-1/2 left-1/2 text-center w-full">
        <h1 class="text-xl lg:text-4xl relative">
            <span class="text-gray-300 drop-shadow-md">SERHII</span>
            <span class="text-main drop-shadow-md">CHO</span>
        </h1>

        <h2 class="text-white text-md lg:text-2xl">
            Professional Full Stack developer
        </h2>

        <div class="flex items-center justify-center mt-5 shadow-lg rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-main bg-white max-w-[300px] md:max-w-[600px] mx-auto">
            <form class="flex w-full">
                <input
                    type="text"
                    class="pl-3 md:pl-6 py-3 md:py-4 text-sm md:text-xl w-full"
                    placeholder="Enter post title, project or anything else"
                />

                <button class="flex items-center justify-center px-3 md:px-5 bg-white">
                    <search-icon class="w-5 md:w-6 h-5 md:h-6 text-gray-600 stroke-gray-400" />
                </button>
            </form>
        </div>
    </div>
</template>
