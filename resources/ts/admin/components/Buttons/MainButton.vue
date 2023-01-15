<script setup lang="ts">
import type { RouteLocationNormalized } from 'vue-router'

type Props = {
    route?: RouteLocationNormalized
    type?: string
    href?: string
}

const { route, type = 'button', href } = defineProps<Props>()

const classes = 'inline-block uppercase text-white text-sm px-6 py-2 rounded-full transition-all bg-main hover:bg-main-hover shadow-md hover:shadow-lg';
</script>

<template>
    <a v-if="href" :href="href" :class="classes">
        <slot />
    </a>

    <router-link v-else-if="route" :class="classes" :to="route">
        <slot />
    </router-link>

    <button v-else :type="type" :class="classes">
        <slot />
    </button>
</template>

