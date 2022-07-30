<script setup lang="ts">
import TagsFilter from './TagsFilter.vue'
import AppearTransition from '../Transitions/AppearTransition.vue'

type Props = {
    tagSlug: string
}

const { tagSlug } = defineProps<Props>()
</script>

<template>
    <appear-transition>
        <div class="mb-2 flex items-center">
            <div class="w-full max-w-[360px]">
                <tags-filter :tagSlug="tagSlug" />
            </div>
        </div>
    </appear-transition>
</template>
