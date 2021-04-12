<template>
    <section class="hero is-dark" hero>
        <div class="hero-head"><Navbar/></div>

        <div class="hero-body">
            <div class="container has-text-centered">
                <p class="title">Open source</p>
                <p class="subtitle">I want to share with you some of my open source package from Github</p>
            </div>
        </div>
    </section>

    <div class="container mt-6">
        <div v-if="loading" class="has-text-centered"><Spinner /></div>
        <div v-else class="row">
            <div class="col-md-6 col-lg-4 col-xl-3" v-for="repo of list" :key="repo.name">
                <div class="card">
                    <div class="card-image">
                        <figure class="image is-4by3">
                            <img src="https://bulma.io/images/placeholders/1280x960.png" alt="Placeholder image">
                        </figure>
                    </div>

                    <div class="card-content">
                        <div class="content">
                            <h5 card-title>{{ repo.title }} <span class="tag is-link is-normal">{{ repo.language }}</span></h5>
                            <p>{{ repo.description }}</p>

                            <router-link :to="'/project/' + repo.name" view-button class="button is-rounded is-info is-block">View</router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import Navbar from '@/components/Navbar.vue'
import useFetchRepos from '@/composables/useFetchRepos'
import Spinner from '@/components/Spinner.vue'

export default defineComponent({
    setup() {
        return {
            ...useFetchRepos(),
        }
    },

    components: {
        Navbar,
        Spinner,
    },
})
</script>

<style lang="sass" scoped>
[hero]
    background: url(../../assets/images/heros/open-source-hero.jpg) no-repeat center center
    background-size: cover

.card
    margin-bottom: 25px

.content
    min-height: 270px
    position: relative
    padding-bottom: 40px

[view-button]
    position: absolute
    bottom: 0
    left: 0
    width: 100%

[card-title]
    text-transform: capitalize
</style>