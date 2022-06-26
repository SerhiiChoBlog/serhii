<script lang="ts" setup>
import Popper from 'vue3-popper'

interface Props {
    content: string
}

const { content } = defineProps<Props>()
</script>

<template>
    <popper arrow hover :content="content">
        <slot/>
    </popper>
</template>
