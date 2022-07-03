<script setup lang="ts">
import { onMounted, ref } from 'vue'
import AppearTransition from './Transitions/AppearTransition.vue'

const typewriter = ref('')
const words = ['software developer️ 😎', 'programmer 💻', 'Laravel developer 🐘']
const wait = 3000
let text = ''
let isDeleting = false
let typingSpeed = 50
let wordIndex = 0

function initTypewriter(): void {
    const current = wordIndex % words.length
    const fullText = words[current]

    text = isDeleting
        ? fullText.substring(0, text.length - 1)
        : fullText.substring(0, text.length + 1)

    typewriter.value = text

    if (isDeleting) {
        typingSpeed = 30
    }

    if (!isDeleting && text === fullText) {
        typingSpeed = wait
        isDeleting = true
    } else if (isDeleting && text === '') {
        typingSpeed = 100
        isDeleting = false
        wordIndex++
    }

    window.setTimeout(() => initTypewriter(), typingSpeed)
}

onMounted(() => initTypewriter())
</script>

<template>
    <appear-transition>
        <p class="text-gray-300 font-code text-xs sm:text-sm lg:text-xl">
             Professional {{ typewriter }}
            <span class="border-r-[12px] border-r-gray-800 animate-blink"></span>
        </p>
    </appear-transition>
</template>
