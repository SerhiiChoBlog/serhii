<script setup lang="ts">
import links from '@admin/router/links'

const linkStyles = 'relative w-[180px] m-auto transition-colors flex items-center border-collapse text-white text-md leading-10 hover:bg-main-hover py-0.5'
const iconStyles = 'fas w-[27px] text-2xl text-center ml-[7px] mr-3'
</script>

<template>
    <nav class="bg-gray-800 opacity-75 fixed top-[64px] bottom-0 w-[44px] overflow-hidden transition-all translate-z-0 scale-x-1 scale-y-1 z-10 hover:overflow-visible hover:w-[180px] hover:h-full hover:overflow-y-auto hover:opacity-95">
        <ul>
            <li v-for="link in links" :key="link.title">
                <router-link
                    v-if="link.routeName"
                    :to="{ name: link.routeName }"
                    :class="linkStyles"
                >
                    <i :class="link.icon + ' ' + iconStyles"></i>
                    <span>{{ link.title }}</span>
                </router-link>

                <a
                    v-if="link.href"
                    :href="link.href"
                    :class="linkStyles"
                    @click="link.action ? link.action() : null"
                >
                    <i :class="link.icon + ' ' + iconStyles"></i>
                    <span>{{ link.title }}</span>
                </a>
            </li>
        </ul>
    </nav>
</template>
