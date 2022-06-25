<script setup lang="ts">
import { onMounted, ref } from 'vue'
import isElementInViewport from '../modules/isElementInViewport'
import { Chapter } from '../types/types'
import FloppyIcon from './Icons/Floppy.vue'

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

    markSavedChapter()
})

function markSavedChapter(): void {
    const header = localStorage.getItem(`chapter:${slug}`) as string | null

    if (!header) {
        return
    }

    chapters.value.map(chapter => {
        chapter.isSaved = chapter.title === header
        return chapter
    })
}

function markVisibleChapters(elem: HTMLElement): void {
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
        isSaved: false,
    })
}

function scrollToChapter(title: string): void {
    if (!headers.value) {
        return
    }

    const neededElement = Array.from(headers.value).find(header => {
        return title === header.innerText
    })!

    neededElement.scrollIntoView({ behavior: 'smooth' })
}

function getChapterStyles(chapter: Chapter): string {
    if (chapter.isActive) {
        return 'bg-main !text-white !border-main hover:!bg-main-hover'
    }

    if (chapter.isSaved) {
        return 'bg-green-100 hover:!bg-green-200 pr-12'
    }

    return ''
}
</script>

<template>
    <div class="h-[94%] lg:h-full fixed bg-page w-full max-w-sm left-1/2 -translate-x-1/2 border lg:border-none top-[3%] lg:top-0 bottom-[3%] p-4 lg:p-0 rounded-2xl shadow-xl lg:shadow-none lg:relative">
        <nav class="sticky h-screen overflow-y-scroll top-3">
            <p class="mb-5">
                <span class="text-font-second text-2xl font-bold font-arizona font-bold">
                    Chapters
                </span>
            </p>

            <div class="space-y-2">
                <a v-for="chapter in chapters"
                   :key="chapter"
                   class="border border-border rounded-full cursor-pointer relative block flex justify-start text-font-second px-5 py-2 transition-colors hover:bg-page-second select-none transition-colors"
                   :class="getChapterStyles(chapter)"
                   @click="scrollToChapter(chapter.title)"
                >
                    <span>{{ chapter.title }}</span>

                    <div v-if="chapter.isSaved" class="absolute right-4 top-1/2 -translate-y-1/2">
                        <FloppyIcon class="w-4 h-4"  />
                    </div>
                </a>
            </div>
        </nav>
    </div>
</template>
