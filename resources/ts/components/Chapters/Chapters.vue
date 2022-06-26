<script setup lang="ts">
import { onMounted, ref } from 'vue'
import isElementInViewport from '../../modules/isElementInViewport'
import type { Chapter as ChapterType, SavedChapter } from '../../types/types'
import screenSizeIs from '../../modules/screenSizeIs'
import Chapter from './Chapter.vue'
import ChevronDownIcon from '../Icons/ChevronDownIcon.vue'
import ChevronUpIcon from '../Icons/ChevronUpIcon.vue'
import SaveIcon from '../Icons/SaveIcon.vue'
import Download from '../Icons/Download.vue'
import sweetAlert from 'sweetalert2'

interface Props {
    slug: string
}

const { slug } = defineProps<Props>()
const headers = ref<NodeListOf<HTMLElement> | null>(null)
const chapters = ref<ChapterType[]>([])
const savedChapter = ref<SavedChapter | null>(null)
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

    setSavedChapter()
    showAlertIfHasSavedChapter()
    detectCurrentChapter()
})

function setSavedChapter(): void {
    const saved = localStorage.getItem(`chapter:${slug}`) as string | null

    if (!saved) {
        return
    }

    savedChapter.value = JSON.parse(saved) as SavedChapter
}

async function showAlertIfHasSavedChapter(): Promise<void> {
    if (!savedChapter.value) {
        return
    }

    const response = await sweetAlert.fire({
        title: 'Welcome back',
        html: `You have a saved chapter<br><b>"${savedChapter.value.chapter.title}"</b>`,
        showCancelButton: true,
        confirmButtonText: 'Load save',
        cancelButtonText: 'Delete save',
    })

    const wantsLoadSave = response.isConfirmed
    const wantsDeleteSave = response.isDismissed

    if (wantsDeleteSave) {
        deleteSave()
    }

    if (wantsLoadSave) {
        goToSavedChapter()
    }
}

function deleteSave(): void {
    localStorage.removeItem(`chapter:${slug}`)
    savedChapter.value = null

    sweetAlert.fire({
        title: 'Done',
        html: `Your saved chapter has been deleted!`,
    })
}

function goToSavedChapter(): void {
    if (!savedChapter.value) {
        return
    }

    window.scrollTo({ top: savedChapter.value.top, behavior: 'smooth' })
}

function detectCurrentChapter(): void {
    const activeChapter = chapters.value.find(chapter => chapter.isActive)
    currentChapter.value = activeChapter || null
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
}

function saveCurrentChapter(): void {
    if (currentChapter.value) {
        savedChapter.value = {
            chapter: currentChapter.value,
            top: window.scrollY,
        }

        localStorage.setItem(`chapter:${slug}`, JSON.stringify(savedChapter.value))

        sweetAlert.fire({
            title: 'Saved',
            html: `You've saved current position in the post. You'll be able to go back to it any time`,
        })
    }
}

function handleChapters(elem: HTMLElement): void {
    chapters.value.push({
        title: elem.innerText,
        isActive: false,
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
        <ChevronUpIcon v-if="showChapters" class="w-6 h-6 inline-block" />
        <ChevronDownIcon v-else class="w-6 h-6 inline-block" />
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
                <div class="mb-5">
                    <div class="flex justify-between items-center">
                        <span class="text-font-second text-2xl font-bold font-arizona font-bold">Chapters</span>

                        <div class="flex gap-x-2 text-font-second hover:text-font-second-hover transition-colors">
                            <button type="button"
                                class="border border-border py-1 px-3 rounded-lg flex items-center"
                                :class="{'opacity-50 cursor-not-allowed': !savedChapter}"
                                @click="goToSavedChapter"
                            >
                                <Download class="w-4" />
                                <span class="ml-2 text-sm font-bold">LOAD</span>
                            </button>

                            <button type="button"
                                 class="border border-border py-1 px-3 rounded-lg flex items-center"
                                 @click="saveCurrentChapter"
                            >
                                <SaveIcon class="w-4" />
                                <span class="ml-2 text-sm font-bold">SAVE</span>
                            </button>
                        </div>
                    </div>
                </div>

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
