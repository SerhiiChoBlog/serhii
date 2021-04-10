<template>
    <section class="hero is-dark" hero>
        <div class="hero-head"><Navbar/></div>

        <div class="hero-body">
            <div class="container has-text-centered">
                <p class="title">Open source</p>
                <p class="subtitle">Lorem ipsum dolor sit amet consectetur adipisicing elit</p>
            </div>
        </div>
    </section>

    <div class="content">
        <p v-if="loading">Loading...</p>
        <ul v-else>
            <li v-for="item of list" :key="item">{{ item.name }}</li>
        </ul>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import Navbar from '@/components/Navbar.vue'
import useFetchRepos from '@/composables/useFetchRepos'

export default defineComponent({
    setup() {
        return {
            ...useFetchRepos(),
        }
    },

    components: {
        Navbar,
    },
})
</script>

<style lang="sass" scoped>
[hero]
    background: url(../assets/images/heros/open-source-hero.jpg) no-repeat center center
    background-size: cover
</style>