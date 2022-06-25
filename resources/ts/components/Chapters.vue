<script setup lang="ts">
import { onMounted, ref } from 'vue'
import isElementInViewport from '../modules/isElementInViewport'

interface Chapter {
    title: string
    isActive: boolean
}

const headers = ref<NodeListOf<HTMLElement> | null>(null)
const chapters = ref<Chapter[]>([])

onMounted(() => {
    headers.value = document.querySelectorAll<HTMLElement>('#post-content h2')

    headers.value.forEach(elem => {
        handleChapters(elem)
        window.addEventListener('scroll', () => markVisibleChapters(elem))
    })
})

function markVisibleChapters(elem: HTMLElement): void {
    const elemIsVisible = isElementInViewport(elem)

    if (elemIsVisible) {
        chapters.value.map(chapter => {
            chapter.isActive = chapter.title === elem.innerText
            return chapter
        })
    }
}

function handleChapters(elem: HTMLElement): void {
    chapters.value.push({
        title: elem.innerText,
        isActive: false,
    })
}

function scrollToChapter(selectedChapter: Chapter): void {
    if (!headers.value) {
        return
    }

    const neededElement = Array.from(headers.value).find(header => {
        return selectedChapter.title === header.innerText
    })!

    neededElement.scrollIntoView({ behavior: 'smooth' })
}
</script>

<template>
    <div class="space-y-2">
        <a v-for="chapter in chapters"
           :key="chapter"
           class="shadow-sm border rounded-full cursor-pointer relative block flex justify-start text-font-second px-5 py-2 transition-colors hover:shadow-md select-none transition-all"
           :class="{'!bg-main !text-white ': chapter.isActive}"
           @click="scrollToChapter(chapter)"
        >
            <span class="${numberClasses}"></span> <span>{{ chapter.title }}</span>
        </a>
    </div>
</template>
