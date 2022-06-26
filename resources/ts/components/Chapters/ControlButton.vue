<script setup lang="ts">
import Tip from '../Tip.vue'

interface Props {
    tipContent: string
}

const { tipContent } = defineProps<Props>()
</script>

<template>
    <tip :content="tipContent">
        <button type="button" class="flex items-center">
            <slot />
        </button>
    </tip>
</template>
