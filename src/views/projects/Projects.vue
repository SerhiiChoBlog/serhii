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

                <router-link :to="`/project/${repo.name}`">
                    <div class="card">
                        <img language-image :src="getLanguagesImages(repo.language.toLowerCase())">

                        <div class="card-content">
                            <div class="content">
                                <h4 card-title>{{ repo.title }}</h4>
                                <p>{{ repo.description }}</p>

                                <div view-button class="button is-rounded is-info is-block">View</div>
                            </div>
                        </div>
                    </div>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import Navbar from '@/components/Navbar.vue'
import useFetchRepos from '@/composables/useFetchRepos'
import Spinner from '@/components/Spinner.vue'
import { getLanguagesImages } from '@/modules/getImageUrl'

export default defineComponent({
    setup() {
        return {
            ...useFetchRepos(),
            getLanguagesImages,
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
    position: relative

.content
    min-height: 270px
    position: relative
    padding-bottom: 40px
    padding-top: 20px

    [view-button]
        position: absolute
        bottom: 0
        left: 0
        width: 100%

    [card-title]
        text-transform: capitalize

[language-image]
    width: 40px
    height: 40px
    position: absolute
    top: 12px
    right: 12px
</style>