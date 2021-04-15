<template>
    <section class="hero is-large is-dark">
        <div class="hero-head"><Navbar /></div>

        <div class="hero-body">
            <div class="container has-text-centered">
                <p class="title">SERHII<span class="has-text-info">CHO</span></p>
                <p class="subtitle">Professional software developer️ 💙</p>
            </div>
        </div>
    </section>

    <section class="section is-medium">
        <div class="container">
            <h2 class="is-size-2 mb-6">Hi, I’m Serhii. Nice to meet you.</h2>
            <p class="subtitle is-size-4">
                I’m a fullstack developer with <b :title="fullExperience" class="has-text-info">{{ experience.roundYears }}</b> years experience
                creating web applications. I was fortunate to have challenging projects that helped me to try lots of
                different technologies. Since the beginning of my journey as a freelancer, I've done remote work for
                companies based in Netherlands and Ukraine.
            </p>
        </div>
    </section>

    <CardsSection :techs="langs" :bg-dark="true" header="My languages of choice" />
    <CardsSection :techs="frameworks" :bg-dark="false" header="I'm working with" />
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import Navbar from '@/components/Navbar.vue'
import langs from '@/static/langs'
import frameworks from '@/static/frameworks'
import CardsSection from '@/components/CardsSection.vue'
import useExperienceCounter from '@/composables/about/useExperienceCounter'

export default defineComponent({
    setup() {
        return {
            langs,
            frameworks,
            ...useExperienceCounter(),
        }
    },

    components: {
        Navbar,
        CardsSection,
    },
})
</script>

<style lang="sass" scoped>
.hero
    background: url(../assets/images/heros/home-hero.jpg) no-repeat top center
    background-size: cover
</style>