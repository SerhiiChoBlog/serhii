<template>
    <div>
        <a v-for="chapter in chapters"
           :key="chapter"
           class="panel-block"
           v-html="chapter"
           @click="scrollToChapter(chapter)"
        ></a>
    </div>
</template>

<script lang="ts">
import { defineComponent, onMounted, ref } from 'vue'

export default defineComponent({
    setup() {
        const chapters = ref<string[]>([])
        const chaptersElements: Element[] = []

        onMounted(() => {
            const postContentElements = document.querySelectorAll('#post-content h2')!

            postContentElements.forEach(elem => {
                chaptersElements.push(elem)
                let chapterText = elem.innerHTML
                const numberRegex = /^\d+/

                if (numberRegex.test(chapterText)) {
                    const chapterNum = chapterText.match(numberRegex)!
                    chapterText = chapterText.replace(/^\d+\. /, '')

                    chapterText = chapterNum[0].length === 1
                        ? `<b>${chapterNum[0]}</b> ${chapterText}`
                        : `<b class="long-number">${chapterNum[0]}</b> ${chapterText}`
                } else {
                    chapterText = `<span></span> ${chapterText}`
                }

                chapters.value.push(chapterText)
            })
        })

        function scrollToChapter(chapter: string): void {
            const neededElement = chaptersElements.find((el) => {
                const elementHtml = el.innerHTML.replace(/^\d+\. /, '')
                return chapter.includes(elementHtml)
            })!
            neededElement.scrollIntoView({ behavior: 'smooth' })
        }

        return {
            chapters,
            scrollToChapter,
        }
    },
})
</script>
