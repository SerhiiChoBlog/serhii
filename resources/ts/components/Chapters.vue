<template>
    <a v-for="chapter in chapters"
       :key="chapter"
       class="panel-block"
       v-html="chapter"
       @click="scrollToChapter(chapter)"
    ></a>
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
                chapters.value.push(elem.innerHTML)
            })
        })

        function scrollToChapter(chapter: string): void {
            const neededElement = chaptersElements.find((el) => el.innerHTML === chapter)!
            neededElement.scrollIntoView({ behavior: 'smooth' })
        }

        return {
            chapters,
            scrollToChapter,
        }
    },
})
</script>

<style scoped>

</style>
