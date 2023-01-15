<script setup lang="ts">
import type { RouteLocationNormalized } from 'vue-router'

type Props = {
    icon: string
    title: string
    href?: string
    route?: RouteLocationNormalized
}

const { icon, href, title, route } = defineProps<Props>()
const classes = 'text-sm border rounded-sm w-10 h-10 flex justify-center items-center transition-colors hover:bg-gray-100'
</script>

<template>
    <a
        v-if="href"
        :href="href"
        :class="classes"
        target="_blank"
        :title="title"
    >
        <i class="fas" :class="icon"></i>
    </a>

    <router-link
        v-if="route"
        :to="route"
        :class="classes"
        :title="title"
    >
        <i class="fas" :class="icon"></i>
    </router-link>
</template>
