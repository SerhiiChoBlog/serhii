<script setup lang="ts">
import links from '../router/links'</script>

<template>
    <nav class="bg-gray-800 opacity-75 fixed top-0 bottom-0 w-[43px] overflow-hidden transition-all translate-z-0 scale-x-1 scale-y-1 z-10 pt-[50px] hover:overflow-visible hover:w-[180px] hover:h-full hover:overflow-y-scroll hover:opacity-95">
        <ul class="my-4">
            <li v-for="link in links" :key="link.routeName">
                <router-link
                    :to="{ name: link.routeName }"
                    class="relative w-[180px] m-auto transition-colors block border-collapse text-white text-sm leading-10 hover:bg-main-hover"
                >
                    <i :class="link.icon" class="fas w-[25px] text-2xl text-center ml-[7px] mr-2 align-middle"></i>
                    <span>{{ link.title }}</span>
                </router-link>
            </li>
        </ul>
    </nav>
</template>
