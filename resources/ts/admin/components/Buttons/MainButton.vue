<script setup lang="ts">
import type { RouteLocationRaw } from 'vue-router'

type Props = {
    route?: RouteLocationRaw
    type?: 'button' | 'submit' | 'reset'
    href?: string
}

const { route, type = 'button', href } = defineProps<Props>()

const classes = 'inline-block uppercase text-white text-sm px-6 py-2 rounded-full transition-all bg-main hover:bg-main-hover shadow-md hover:shadow-lg';
</script>

<template>
    <a v-if="href" :href="href" :class="classes">
        <slot />
    </a>

    <RouterLink v-else-if="route" :class="classes" :to="route">
        <slot />
    </RouterLink>

    <button v-else :type="type" :class="classes">
        <slot />
    </button>
</template>

