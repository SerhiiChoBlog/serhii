<script setup lang="ts">
import type { Chapter as ChapterType } from '@/../types'
import { computed } from 'vue'

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

const title = computed(() => {
    return chapter.title.replace(/\d+\. ?/, '')
})

const number = computed<string>(() => {
    const match = /\d+\./.exec(chapter.title)
    return match && match[0] ? match[0].replace('.', '') : ''
})
</script>

<template>
    <a
        class="leading-5 border border-border rounded-full cursor-pointer relative block flex justify-start text-font-second px-5 py-1.5 hover:bg-page-second select-none gap-3 items-center"
        :class="{'bg-main !text-white !border-main hover:!bg-main-hover': chapter.isActive}"
        @click="scrollToChapter(chapter.title)"
    >
        <span
            class="font-bold text-lg"
            :class="chapter.isActive ? 'text-white' : 'text-main'"
            aria-hidden="true"
        >
            {{ number || '&#xb7;' }}
        </span>


        <span>{{ title }}</span>
    </a>
</template>
