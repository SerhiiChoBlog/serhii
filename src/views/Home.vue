<template>
    <section class="hero is-large is-dark" hero>
        <div class="hero-head"><Navbar/></div>

        <div class="hero-body">
            <div class="container has-text-centered">
                <p class="title">Serhii Cho</p>
                <p class="subtitle">Professional software developer ❤️</p>
            </div>
        </div>
    </section>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import Navbar from '@/inc/Navbar.vue'

export default defineComponent({
    setup() {
        //
    },
    components: {
        Navbar,
    },
})
</script>

<style lang="sass" scoped>
[hero]
    background: url(../assets/images/heros/home-hero.jpg) no-repeat top center
    background-size: cover
</style>