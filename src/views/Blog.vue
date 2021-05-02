<template>
    <section class="hero is-dark">
        <div class="hero-head"><Navbar /></div>

        <div class="hero-body">
            <div class="container has-text-centered">
                <p class="title">Blog</p>
                <p class="subtitle">Some blog text will be here in this p tag</p>
            </div>
        </div>
    </section>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import Navbar from "@/components/Navbar.vue"

export default defineComponent({
    components: {
        Navbar,
    },
})
</script>

<style lang="sass" scoped>
.hero
    background: url(../assets/images/heros/blog-hero.jpg) no-repeat center center
    background-size: cover
</style>