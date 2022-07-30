<script setup lang="ts">
import ArrowDownIcon from '../Icons/ArrowDownIcon.vue'

function scrollDown(): void {
    const elem = document.getElementById('home-decoration-lines')

    if (elem) {
        elem.scrollIntoView({ behavior: 'smooth', block: 'start' })
    }
}
</script>

<template>
    <button
        type="button"
        aria-label="Scroll down to the next section"
        class="absolute border border-white left-1/2 bottom-14 lg:bottom-18 text-white animate-bounce p-2 w-8 lg:w-10 ratio-square shadow-lg rounded-full flex items-center justify-center transition-colors duration-500 hover:border-main hover:text-main"
        @click="scrollDown"
    >
        <arrow-down-icon />
    </button>
</template>
