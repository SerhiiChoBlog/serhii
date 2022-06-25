<script setup lang="ts">
import { Chapter as ChapterType } from '../../types/types'

interface Props {
    headers: NodeListOf<HTMLElement>
    chapter: ChapterType
}

const { headers, chapter } = defineProps<Props>()
const emit = defineEmits(['clicked'])

function scrollToChapter(title: string): void {
    if (!headers) {
        return
    }

    const neededElement = Array.from(headers).find(header => {
        return title === header.innerText
    })!

    emit('clicked')

    neededElement.scrollIntoView({ behavior: 'smooth' })
}

function getChapterStyles(chapter: ChapterType): string {
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
    <a class="border border-border rounded-full cursor-pointer relative block flex justify-start text-font-second px-5 py-2 transition-colors hover:bg-page-second select-none transition-colors"
       :class="getChapterStyles(chapter)"
       @click="scrollToChapter(chapter.title)"
    >
        <span>{{ chapter.title }}</span>
    </a>
</template>
