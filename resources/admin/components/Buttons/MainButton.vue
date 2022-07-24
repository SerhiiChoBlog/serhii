<script setup lang="ts">
import type { RouteLocationNormalized } from 'vue-router'

type Props = {
    route?: RouteLocationNormalized
}

const { route } = defineProps<Props>()

const classes = 'inline-block uppercase text-white text-sm px-6 py-2 rounded-full transition-all bg-main hover:bg-main-hover shadow-md hover:shadow-lg';
</script>

<template>
    <router-link v-if="route" :class="classes" :to="route">
        <slot />
    </router-link>

    <button type="submit" v-else :class="classes">
        <slot />
    </button>
</template>

