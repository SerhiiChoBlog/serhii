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
        markVisibleChapters(elem)
    })
})

function markVisibleChapters(elem: HTMLElement): void {
    window.addEventListener('scroll', () => {
        const elemIsVisible = isElementInViewport(elem)

        if (elemIsVisible) {
            const res = chapters.value.find(chapter => console.log(chapter))
        }
    })
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

    chapters.value.map(chapter => {
        chapter.isActive = chapter.title === selectedChapter.title
        return chapter
    })

    const neededElement = Array.from(headers.value).find(header => {
        return selectedChapter.title === header.innerText
    })!

    neededElement.scrollIntoView({ behavior: 'smooth' })
}
</script>

<template>
    <div>
        <a v-for="chapter in chapters"
           :key="chapter"
           class="border-b border-border cursor-pointer relative block flex justify-start text-font-second pl-7 pr-5 py-2 transition-colors hover:bg-page-second select-none last:border-none"
           :class="chapter.isActive ? '!text-main font-bold' : ''"
           @click="scrollToChapter(chapter)"
        >
            <span class="${numberClasses}"></span> <span>{{ chapter.title }}</span>
        </a>
    </div>
</template>
