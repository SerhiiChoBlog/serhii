<script setup lang="ts">
type Props = {
    href?: string
}

const { href } = defineProps<Props>()

const styles =
    'px-7 py-1.5 lg:py-2.5 bg-main text-white rounded-md hover:bg-main-hover'
</script>

<template>
    <a v-if="href" :href="href" :class="styles">
        <slot />
    </a>
    <button v-else :class="styles">
        <slot />
    </button>
</template>
