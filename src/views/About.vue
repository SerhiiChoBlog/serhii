<template>
    <section class="hero is-large is-dark">
        <div class="hero-head"><Navbar /></div>

        <div class="hero-body">
            <div class="container has-text-centered" v-if="mounted">
                <p class="title">SERHII<span class="has-text-info">CHO</span></p>
                <p class="subtitle">
                    Professional<span class="professional">{{ typewriter }}<span class="cursor"></span></span>
                </p>
            </div>
        </div>
    </section>

    <section class="section is-medium">
        <transition name="enter-from-top" mode="out-in">
            <div class="container" v-if="mounted">
                <h2 class="is-size-3 mb-4 has-text-centered">Nice to meet you</h2>
                <p class="subtitle is-size-4">
                    I’m a fullstack developer with <b :title="fullExperience" class="experience">{{ roundYears }} years</b> experience
                    creating web applications. I was fortunate to have challenging projects that helped me to try lots of
                    <b>different technologies</b>. Since the beginning of my journey as a freelancer, I've done remote work for
                    companies based in Netherlands and Ukraine.
                </p>
            </div>
        </transition>
    </section>

    <CardsSection :techs="langs" :bg-dark="true" header="Languages" />
    <CardsSection :techs="frameworks" :bg-dark="false" header="Frameworks" />
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from 'vue'
import Navbar from '@/components/Navbar.vue'
import langs from '@/static/langs'
import frameworks from '@/static/frameworks'
import CardsSection from '@/components/CardsSection.vue'
import useExperienceCounter from '@/composables/about/useExperienceCounter'
import useTypewriter from '@/composables/about/useTypewriter'

export default defineComponent({
    setup() {
        const mounted = ref(false)

        onMounted(() => mounted.value = true)

        return {
            langs,
            frameworks,
            mounted,
            ...useTypewriter(),
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

.experience
    cursor: help
    transition: color 200ms

    &:hover
        color: #3298dc

.subtitle
    line-height: 1.7

.professional
    font-family: JetBrainsMono, monospace
    margin-left: 12px

.cursor
    border-right: 12px solid #999
    margin-left: 4px
    animation: blink 1100ms linear infinite
    animation-timing-function: step-end

</style>