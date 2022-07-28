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
                class="bg-font dark:bg-page-second dark:text-white dark:border dark:border-gray-800 px-4 py-2 text-white rounded-lg text-sm shadow-md"
                v-html="content"
            ></div>
        </template>
    </popper>
</template>
