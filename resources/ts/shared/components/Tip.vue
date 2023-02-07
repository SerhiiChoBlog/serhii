<script lang="ts" setup>
import Popper from 'vue3-popper'

interface Props {
    content: string | null
    icon?: boolean
}

const { content, icon = false } = defineProps<Props>()
</script>

<template>
    <div v-if="content" class="inline-flex">
        <popper hover :content="content" class="!border-none !m-0">
            <div>
                <i
                    v-if="icon"
                    class="not-italic border border-amber-600 font-bold text-[13px] rounded-full text-amber-600 flex items-center justify-center w-[18px] h-[18px]"
                >?</i>

                <slot />
            </div>

            <template #content>
                <div class="bg-gray-800/90 px-4 py-2 text-white rounded-md text-sm lg:text-md shadow-md tracking-normal font-normal min-w-[170px] max-w-[300px]">
                    {{ content }}
                </div>
            </template>
        </popper>
    </div>

    <slot v-else />
</template>
