<script setup lang="ts">
import { computed } from 'vue'

type Props = {
    url: string | null
}

const { url } = defineProps<Props>()
const commonStyles = computed(() => {
    let res = "px-7 py-4 w-full text-center rounded-xl text-lg text-white"

    if (url) {
        return res + " bg-main"
    }

    return res + " bg-main-light cursor-not-allowed"
})
</script>

<template>
    <a
        href="#"
        :class="commonStyles"
    >
        <slot />
    </a>

</template>