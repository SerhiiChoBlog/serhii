<script setup lang="ts">
import { onMounted, ref } from 'vue'
import isElementInViewport from '../modules/isElementInViewport'

const chapters = ref<string[]>([])
const chaptersElements: Element[] = []

onMounted(() => {
    const headers = document.querySelectorAll<HTMLElement>('#post-content h2')!

    headers.forEach(elem => {
        handleChapters(elem)
        markVisibleChapters(elem)
    })
})

function markVisibleChapters(elem: HTMLElement): void {
    window.addEventListener('scroll', () => {
        const elemIsVisible = isElementInViewport(elem)
    })
}

function handleChapters(elem: HTMLElement): void {
    chaptersElements.push(elem)

    let chapterText = elem.innerHTML
    const numberRegex = /^\d+/

    const commonClasses = 'absolute left-[8px] top-1/2 -translate-y-1/2 rounded-full'
    const numberClasses = `${commonClasses} text-gray-400 text-lg -translate-y-1/2`
    const pointClasses = `${commonClasses} bg-gray-400 w-[4px] h-[4px]`

    if (numberRegex.test(chapterText)) {
        const chapterNum = chapterText.match(numberRegex)!
        chapterText = chapterText.replace(/^\d+\. /, '')

        chapterText = chapterNum[0].length === 1
            ? `<span class="${numberClasses}">${chapterNum[0]}</span> <span>${chapterText}</span>`
            : `<span class="-ml-1 ${numberClasses}">${chapterNum[0]}</span> <span>${chapterText}</span>`
    } else {
        chapterText = `
            <span class="${pointClasses}"></span>
            <span>${chapterText}</span>
        `
    }

    chapters.value.push(chapterText)
}

function scrollToChapter(chapter: string): void {
    const neededElement = chaptersElements.find((el) => {
        const elementHtml = el.innerHTML.replace(/^\d+\. /, '')
        return chapter.includes(elementHtml)
    })!

    neededElement.scrollIntoView({ behavior: 'smooth' })
}
</script>

<template>
    <div>
        <a v-for="chapter in chapters"
           :key="chapter"
           class="border-b border-border cursor-pointer relative block flex justify-start text-font-second pl-7 pr-5 py-2 transition-colors hover:bg-page-second select-none last:border-none"
           v-html="chapter"
           @click="scrollToChapter(chapter)"
        ></a>
    </div>
</template>
