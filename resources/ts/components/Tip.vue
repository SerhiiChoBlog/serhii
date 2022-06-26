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
            <div class="bg-font px-4 py-2 text-white rounded-lg text-sm shadow-md">
                {{ content }}
            </div>
        </template>
    </popper>
</template>
