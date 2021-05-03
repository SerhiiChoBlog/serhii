<template>
    <section class="hero is-light">
        <div class="hero-head"><Navbar :isLight="false" /></div>

        <div class="hero-body">
            <div v-if="projectLoading" class="container has-text-centered">
                <Spinner />
            </div>
            <div v-else class="container has-text-centered">
                <p class="title">{{ project.title }}</p>
                <p class="subtitle has-text-left">{{ project.description }}</p>
                <a :href="project.url" target="_blank" class="button is-rounded is-dark">
                    <img src="../../assets/images/icons/github.png" width="20" />
                    <span class="ml-2">Open on Github</span>
                </a>
            </div>
        </div>
    </section>

    <div class="container mt-6 pb-6">
        <div v-if="contentLoading" class="has-text-centered"><Spinner /></div>
        <div v-else-if="contentError"><h3 class="is-size-4 has-text-centered">{{ contentError }}</h3></div>
        <div v-else class="content" v-html="content"></div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import Navbar from '@/components/Navbar.vue'
import Spinner from '@/components/Spinner.vue'
import useFetchProjectContent from '@/composables/projects/useFetchProjectContent'
import useFetchProject from '@/composables/projects/useFetchProject'

export default defineComponent({
    setup() {
        return {
            ...useFetchProjectContent(),
            ...useFetchProject(),
        }
    },

    components: {
        Navbar,
        Spinner,
    },
})
</script>

<style lang="sass" scoped>
.hero
    min-height: 19em

.title
    text-transform: capitalize
    margin-bottom: 40px
    font-size: 2.2em

.subtitle
    font-size: 1.4em

.content
    font-size: 1.2em

@media (max-width: 991px)
    .title
        font-size: 1.7em

    .subtitle
        font-size: 1.2em

    .content
        font-size: 1.1em
</style>