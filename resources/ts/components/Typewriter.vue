<template>
    <h2 class="title main-logo">SERHII<span class="has-text-info">CHO</span></h2>
    <p class="subtitle professional">
        Professional {{ typewriter }}
        <span class="cursor"></span>
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

<style lang="sass" scoped>
.main-logo
    font-size: 2em

.professional
    font-family: JetBrainsMono, monospace
    font-size: 1.3em

.cursor
    border-right: 12px solid #999
    margin-left: 4px
    animation: blink 1100ms linear infinite
    animation-timing-function: step-end

@media (max-width: 768px)
    .professional
        font-size: 1em

    .main-logo
        font-size: 1.5em
</style>
