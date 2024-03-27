<script setup lang="ts">
type Props = {
    url: string | null
}

const { url } = defineProps<Props>()
</script>

<template>
    <a
        href="#"
        class="bg-main text-white px-12 py-5 w-full text-center rounded-lg text-lg"
    >
        <slot />
    </a>
</template>