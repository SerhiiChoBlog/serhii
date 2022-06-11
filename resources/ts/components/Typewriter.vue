<template>
    <p class="font-code text-md">
         Professional {{ typewriter }}
        <span class="border-r-[12px] ml-2 animate-blink"></span>
    </p>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import useTypewriter from '../composables/about/useTypewriter'

export default defineComponent({
    setup() {
        return {
            ...useTypewriter(),
        }
    },
})
</script>
