<template>
    <section class="hero is-large is-dark">
        <div class="hero-head"><Navbar /></div>

        <div class="hero-body">
            <div class="container has-text-centered">
                <transition name="show-main-logo" mode="out-in">
                    <p class="title main-logo" v-if="mounted">SERHII<span class="has-text-info">CHO</span></p>
                </transition>
                <p class="subtitle professional">
                    Professional {{ typewriter }}
                    <span class="cursor"></span>
                </p>
            </div>
        </div>
    </section>

    <section class="section is-medium">
        <transition name="enter-from-top" mode="out-in">
            <div class="container" v-if="mounted">
                <h2 class="title mb-6 has-text-centered">Nice to meet you</h2>
                <p class="subtitle">
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

.main-logo
    font-size: 2em

.experience
    cursor: help
    transition: color 200ms

    &:hover
        color: #3298dc

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