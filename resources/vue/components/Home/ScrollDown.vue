<script setup lang="ts">
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
        class="absolute left-1/2 ml-[-15px] bottom-14 lg:bottom-18 text-white animate-bounce w-8 lg:w-10 ratio-square shadow-lg rounded-full flex items-center justify-center transition-colors duration-500 hover:border-main hover:text-main"
        @click="scrollDown"
    >
        <img
            src="/storage/icons/arrow-down.webp"
            alt="Arrow down"
            aria-hidden="true"
            width="124"
            height="124"
        />
    </button>
</template>
