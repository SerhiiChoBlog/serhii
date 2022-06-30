<script setup lang="ts">
import { onMounted, ref } from 'vue'

onMounted(() => {
    if (!btn) {
        console.error('Go to top button not found')
        return
    }

    showHideButton()

    window.addEventListener('scroll', e => showHideButton())
})

const btn = ref<HTMLButtonElement | null>(null)

function goToTopHandler(): void {
    document.body.scrollIntoView({
        behavior: 'smooth',
        block: 'start',
    })
}

function showHideButton(): void {
    if (!btn.value) {
        console.error('Go to top button not found')
        return
    }

    if (window.scrollY > 1000) {
        btn.value.classList.remove('opacity-0')
        btn.value.classList.remove('pointer-events-none')
        btn.value.classList.add('opacity-70')
        console.log('show')
    } else {
        console.log('hide')
        btn.value.classList.add('opacity-0')
        btn.value.classList.add('pointer-events-none')
        btn.value.classList.remove('opacity-70')
    }
}
</script>

<template>
    <button
        type="button"
        aria-label="Go to the top"
        @click="goToTopHandler"
        class="pointer-events-none opacity-0 fixed bottom-2 right-2 md:bottom-6 md:right-6 z-30 bg-main p-2 rounded-full shadow-md transition-all duration-500 hover:scale-110"
        ref="btn"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="white">
            <path
                fill="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"
                clip="evenodd"
            />
        </svg>
    </button>
</template>
