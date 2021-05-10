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

    <div class="container mt-6">
        <div class="content" v-html="content"></div>
    </div>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue'
import Navbar from "@/components/Navbar.vue"
import { getPostsUrl } from '@/config'
import loadHighlightJs from '@/modules/loadHighlightJs'

export default defineComponent({
    setup() {
        const content = ref('')

        fetch(getPostsUrl())
            .then(res => res.json())
            .then(res => {
                content.value = res[0].content
                loadHighlightJs()
            })

        return { content }
    },

    components: {
        Navbar,
    },
})
</script>

<style lang="sass" scoped>
.hero
    background: url(../../assets/images/heros/blog-hero.jpg) no-repeat center center
    background-size: cover
</style>