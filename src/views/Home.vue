<template>
    <section class="hero is-large is-dark" hero>
        <div class="hero-head"><Navbar /></div>

        <div class="hero-body">
            <div class="container has-text-centered">
                <p class="title">Software developer ❤️</p>
                <p class="subtitle">
                    I’m a fullstack software developer who is mostly focusing on the backend.<br />
                    I was fortunate to have challenging projects that helped me to try lots of different technologies
                </p>
            </div>
        </div>
    </section>

    <CardsSection :techs="langs" :bg-dark="false" header="My languages of choice"/>
    <CardsSection :techs="frameworks" :bg-dark="true" header="I'm working with"/>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import Navbar from "@/components/Navbar.vue";
import langs from '@/composables/langs'
import frameworks from '@/composables/frameworks'
import CardsSection from "@/components/CardsSection.vue"

export default defineComponent({
    setup() {
        return {
            langs,
            frameworks,
        }
    },

    components: {
        Navbar,
        CardsSection,
    },
});
</script>

<style lang="sass" scoped>
[hero]
    background: url(../assets/images/heros/home-hero.jpg) no-repeat top center
    background-size: cover
</style>