<script setup lang="ts">
import { onMounted, ref } from 'vue'
import isElementInViewport from '../../modules/isElementInViewport'
import { Chapter as ChapterType } from '../../types/types'
import screenSizeIs from '../../modules/screenSizeIs'
import Chapter from './Chapter.vue'
import ChevronDown from '../Icons/ChevronDown.vue'
import ChevronUp from '../Icons/ChevronUp.vue'

interface Props {
    slug: string
}

const { slug } = defineProps<Props>()
const headers = ref<NodeListOf<HTMLElement> | null>(null)
const chapters = ref<ChapterType[]>([])
const currentChapter = ref<ChapterType | null>(null)
const showChapters = ref(false)

onMounted(() => {
    if (!screenSizeIs('lg')) {
        showChapters.value = true
    }

    headers.value = document.querySelectorAll<HTMLElement>('#post-content h2')

    headers.value.forEach(elem => {
        handleChapters(elem)
        window.addEventListener('scroll', () => markVisibleChapters(elem))
    })

    markSavedChapter()
    detectCurrentChapter()
})

function detectCurrentChapter(): void {
    const activeChapter = chapters.value.find(chapter => chapter.isActive)
    currentChapter.value = activeChapter || null
}

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

    chapters.value.map(chapter => {
        chapter.isActive = chapter.title === elem.innerText
        return chapter
    })

    detectCurrentChapter()

    if (currentChapter.value) {
        localStorage.setItem(`chapter:${slug}`, currentChapter.value.title)
    }
}

function handleChapters(elem: HTMLElement): void {
    chapters.value.push({
        title: elem.innerText,
        isActive: false,
        isSaved: false,
    })
}

function handleChapterClick(): void {
    if (screenSizeIs('lg')) {
        showChapters.value = false
    }
}
</script>

<template>
    <button v-if="currentChapter"
        class="flex lg:hidden items-center shadow-md gap-x-1 justify-center fixed border top-1 bg-white w-full py-1 px-4 rounded-full z-40 max-w-sm left-1/2 -translate-x-1/2"
        @click="showChapters = !showChapters"
    >
        <ChevronUp v-if="showChapters" class="w-6 h-6 inline-block" />
        <ChevronDown v-else class="w-6 h-6 inline-block" />
        <span class="tracking-wide">{{ currentChapter.title }}</span>
    </button>

    <transition
        enter-active-class="duration-300 ease-out"
        enter-from-class="transform opacity-0 -translate-y-5"
        enter-to-class="opacity-100 translate-y-0"
        leave-active-class="duration-300 ease-in"
        leave-from-class="opacity-100 translate-y-0"
        leave-to-class="transform -translate-y-5"
    >
        <div v-if="showChapters"
           class="h-[94%] lg:h-full fixed bg-page w-full max-w-sm left-1/2 -translate-x-1/2 border lg:border-none top-[3%] lg:top-0 bottom-[3%] p-4 lg:p-0 rounded-2xl shadow-xl lg:shadow-none lg:relative z-30"
        >
            <nav class="sticky h-screen overflow-y-scroll top-3 mt-7 text-center lg:text-left">
                <p class="mb-5">
                    <span class="text-font-second text-2xl font-bold font-arizona font-bold">
                        Chapters
                    </span>
                </p>

                <div class="space-y-2">
                    <Chapter v-for="chapter in chapters"
                        :key="chapter"
                        :chapter="chapter"
                        :headers="headers"
                        @clicked="handleChapterClick"
                    />
                </div>
            </nav>
        </div>
    </transition>
</template>
