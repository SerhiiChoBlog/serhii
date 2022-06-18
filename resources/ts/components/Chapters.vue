<script setup lang="ts">
import { onMounted, ref } from 'vue'

const chapters = ref<string[]>([])
const chaptersElements: Element[] = []

onMounted(handleChapters)

function handleChapters(): void {
    const postContentElements = document.querySelectorAll('#post-content h2')!

    postContentElements.forEach(elem => {
        chaptersElements.push(elem)
        let chapterText = elem.innerHTML
        const numberRegex = /^\d+/

        if (numberRegex.test(chapterText)) {
            const chapterNum = chapterText.match(numberRegex)!
            chapterText = chapterText.replace(/^\d+\. /, '')

            chapterText = chapterNum[0].length === 1
                ? `<span class="list-number-style">${chapterNum[0]}</span> <span>${chapterText}</span>`
                : `<span class="list-number-style long-number">${chapterNum[0]}</span> <span>${chapterText}</span>`
        } else {
            chapterText = `
                <span class="bg-gray-400 w-[4px] h-[4px] rounded-full absolute left-[8px] top-1/2 -translate-y-1/2"></span>
                <span>${chapterText}</span>
            `
        }

        chapters.value.push(chapterText)
    })
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
