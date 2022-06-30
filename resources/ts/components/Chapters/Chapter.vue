<script setup lang="ts">
import type { Chapter as ChapterType } from '../../types/types'

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
</script>

<template>
    <a
        class="border border-border rounded-full cursor-pointer relative block flex justify-start text-font-second px-5 py-2 transition-colors hover:bg-page-second select-none transition-colors"
        :class="{'bg-main !text-white !border-main hover:!bg-main-hover': chapter.isActive}"
        @click="scrollToChapter(chapter.title)"
    >
        <span>{{ chapter.title }}</span>
    </a>
</template>
