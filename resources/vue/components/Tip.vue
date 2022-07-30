<script lang="ts" setup>
import Popper from 'vue3-popper'

interface Props {
    content: string
}

const { content } = defineProps<Props>()
</script>

<template>
    <popper hover :content="content">
        <slot/>

        <template #content>
            <div
                class="bg-font dark:bg-page-second opacity-90 dark:text-white dark:border dark:border-gray-800 px-3 py-1 text-white rounded-md text-sm shadow-md"
                v-html="content"
            ></div>
        </template>
    </popper>
</template>
