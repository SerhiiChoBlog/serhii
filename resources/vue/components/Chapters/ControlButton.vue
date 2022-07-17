<script setup lang="ts">
import Tip from '../Tip.vue'

interface Props {
    tipContent: string
    disabled: boolean
}

const { tipContent, disabled } = defineProps<Props>()
</script>

<template>
    <tip :content="tipContent">
        <button
            type="button"
            class="flex items-center transition-transform"
            :class="{
                'opacity-40 cursor-not-allowed': disabled,
                'hover:scale-125': !disabled,
            }"
        >
            <slot />
        </button>
    </tip>
</template>
