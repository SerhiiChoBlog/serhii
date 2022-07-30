<script setup lang="ts">
import type { Tag } from '../../../types/models'
import { ref } from 'vue'
import showEverythingTag from '../../modules/showEverythingTag'
import TagsFilter from './TagsFilter.vue'
import AppearTransition from '../Transitions/AppearTransition.vue'

type Props = {
    tagSlug: string
}

const { tagSlug } = defineProps<Props>()
const tag = ref<Tag>(showEverythingTag)

function setTag(newTag: Tag): void {
    tag.value = newTag
}
</script>

<template>
    <appear-transition>
        <div class="mb-2 flex flex-col md:flex-row items-center gap-4">
            <div class="w-full max-w-[300px]">
                <tags-filter :tagSlug="tagSlug" @tagIsLoaded="setTag" />
            </div>

            <div class="text-md leading-5">
                <h2>
                    <b :style="{ color: tag.color }">{{ tag.title }}.</b>
                    <span class="ml-2 text-font-second">{{ tag.description }}</span>
                </h2>
            </div>
        </div>
    </appear-transition>
</template>
