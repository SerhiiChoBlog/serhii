<script setup lang="ts">
import ChevronDown from '@/components/Icons/ChevronDownIcon.vue'
import { ref } from 'vue'
import listenEvent from '@shared/modules/listenEvent'
import appConfig from '@/appConfig'

type Emits = {
    (e: 'clicked'): void
}

const emit = defineEmits<Emits>()
const heading = ref<string>('All tags')

listenEvent<string>(appConfig.events.subscribeTagsButtonTitle, title => {
    heading.value = title
})
</script>

<template>
    <button
        @click="emit('clicked')"
        type="button"
        class="inline-flex items-center justify-center gap-1 bg-gray-700 text-gray-100 h-full px-4 rounded-full min-w-[150px] transition-shadow shadow-md hover:shadow-none"
    >
        <span>{{ heading }}</span>
        <chevron-down class="w-5 h-5" />
    </button>
</template>
