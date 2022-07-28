<script setup lang="ts">
import type { Tag } from '../../../types/models'
import Tip from '../Tip.vue'

type Props = {
    tags: Tag[]
}

type Emits = {
    (e: 'tagChosen', tag: Tag): void
}

const { tags } = defineProps<Props>()
const emit = defineEmits<Emits>()
</script>

<template>
    <div class="flex gap-1 flex-wrap">
        <tip
            v-for="tag in tags"
            :key="tag.id"
            :content="tag.title"
        >
            <a
                :href="`/posts?tag=${tag.name}`"
                aria-label="Post tag"
                @click="emit('tagChosen', tag)"
            >
                <span
                    class="cursor-pointer inline-flex items-center px-3 py-0.5 rounded-md text-xs font-bold leading-5 text-white bg-brand-500 transition-transform hover:scale-105 duration-300"
                    :style="{ backgroundColor: tag.color }"
                >
                    {{ tag.name }}
                </span>
            </a>
        </tip>
    </div>
</template>
