<template>
    <h2 class="home-hero__logo">SERHII<span class="has-text-info">CHO</span></h2>
    <p class="home-hero__professional">
        Professional {{ typewriter }}
        <span class="home-hero__cursor"></span>
    </p>
</template>

<script>
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
