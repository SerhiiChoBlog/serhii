<template>
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

<style scoped>

</style>
