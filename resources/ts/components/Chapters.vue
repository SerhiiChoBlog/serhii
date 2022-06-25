<script setup lang="ts">
import { onMounted, ref } from 'vue'
import isElementInViewport from '../modules/isElementInViewport'
import { Chapter } from '../types/types'
import screenIs from '../modules/screenIs'

interface Props {
    slug: string
}

const { slug } = defineProps<Props>()
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
    if (screenIs('lg')) {
        return
    }

    const elemIsVisible = isElementInViewport(elem)

    if (!elemIsVisible) {
        return
    }

    const currentChapter = chapters.value.find(chap => chap.title === elem.innerText)

    if (!currentChapter) {
        console.error(`Can't find chapter with title ${elem.innerText}`)
        return
    }

    chapters.value.map(chapter => {
        chapter.isActive = chapter.title === elem.innerText
        return chapter
    })

    localStorage.setItem(`chapter:${slug}`, currentChapter.title)
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
           class="border border-border rounded-full cursor-pointer relative block flex justify-start text-font-second px-5 py-2 transition-colors hover:bg-page-second select-none transition-colors"
           :class="{'!bg-main !text-white !border-main': chapter.isActive}"
           @click="scrollToChapter(chapter)"
        >
            <span class="${numberClasses}"></span> <span>{{ chapter.title }}</span>
        </a>
    </div>
</template>
