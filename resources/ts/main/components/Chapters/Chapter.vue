<script setup lang="ts">
import type { Chapter as ChapterType } from '@shared/types'
import { computed } from 'vue'

interface Props {
    headers: NodeListOf<HTMLElement>
    chapter: ChapterType
}

type Emits = {
    (e: 'clicked', title: string): void
}

const { headers, chapter } = defineProps<Props>()
const emit = defineEmits<Emits>()

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
        :href="`#${chapter.slug}`"
        class="leading-5 border border-border rounded-lg cursor-pointer relative flex justify-start text-font-second px-3 hover:bg-page-second select-none gap-2 items-center"
        :class="{
            'bg-main !text-white !border-main hover:!bg-main-hover': chapter.isActive,
            'py-2': chapter.tag === 'H2',
            'ml-5 py-1': chapter.tag === 'H3',
        }"
        @click="emit('clicked', chapter.title)"
    >
        <span
            :class="chapter.isActive ? 'text-white' : 'text-main'"
            aria-hidden="true"
        >
            <span v-if="number">{{ number }}</span>
            <span v-else>{{ '&#xb7;' }}</span>
        </span>


        <span>{{ title }}</span>
    </a>
</template>
