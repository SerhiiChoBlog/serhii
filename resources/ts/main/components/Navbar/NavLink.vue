<script setup lang="ts">
type Props = {
    href: string
    classes?: string
}

const { href, classes } = defineProps<Props>()
</script>

<template>
    <a
        :href="href"
        class="relative tracking-wider w-full lg:w-max border-b border-border lg:border-none text-md before:content-none px-7 py-5 lg:p-0 lg:before:content-[''] navbar-link uppercase lg:drop-shadow-md"
        :class="classes"
        rel="noreferrer"
    >
        <slot />
    </a>
</template>
