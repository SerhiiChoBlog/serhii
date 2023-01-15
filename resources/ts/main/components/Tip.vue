<script lang="ts" setup>
import Popper from 'vue3-popper'

interface Props {
    content: string
    icon?: boolean
}

const { content, icon = false } = defineProps<Props>()
</script>

<template>
    <popper hover :content="content" class="!border-none !m-0">
        <div>
            <i v-if="icon" class="bg-main font-bold text-[12px] rounded-full text-white font-main not-italic flex items-center justify-center w-[18px] h-[18px]">?</i>
            <slot />
        </div>

        <template #content>
            <div class="bg-font dark:bg-page-second opacity-90 dark:text-white dark:border dark:border-gray-800 px-3 py-1 text-white rounded-md text-sm shadow-md">
                {{ content }}
            </div>
        </template>
    </popper>
</template>
