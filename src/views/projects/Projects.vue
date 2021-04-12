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
        <div v-else class="columns is-multiline">
            <div class="column is-one-third" v-for="repo of list" :key="repo.name">
                <div class="card">
                    <div class="card-content">
                        <div class="content">
                            <h5>{{ repo.name }} ({{ repo.language }})</h5>
                            <p>{{ repo.description }}</p>
                        </div>

                        <router-link
                            :to="'/project/' + repo.name"
                            class="button"
                        >View</router-link>
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
</style>