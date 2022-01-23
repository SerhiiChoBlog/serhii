<template>
    <p class="home-hero__professional">
        Professional {{ typewriter }}
        <span class="home-hero__cursor"></span>
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
