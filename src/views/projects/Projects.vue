<template>
    <section class="hero is-dark">
        <div class="hero-head"><Navbar /></div>

        <div class="hero-body">
            <div class="container has-text-centered">
                <p class="title">Open source</p>
                <p class="subtitle">I want to share with you some of my open source package from Github</p>
            </div>
        </div>
    </section>

    <div class="container mt-6">
        <div v-if="processingProjects" class="has-text-centered"><Spinner /></div>
        <h4 v-else-if="projectsError" class="is-size-4 has-text-centered">😔 {{ projectsError }}</h4>
        <div v-else class="row">
            <div class="col-md-12 col-lg-6 col-xl-4" v-for="project in projects" :key="project.name">
                <router-link :to="`/projects/${project.name}`">
                    <div class="card">
                        <img class="language-image" :src="getLanguagesImages(project.language.toLowerCase())">

                        <div class="card-content">
                            <div class="content">
                                <h4 class="card-title">{{ project.title }}</h4>
                                <p>{{ project.description }}</p>

                                <div class="button is-rounded is-info is-block view-button">View</div>
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
import useFetchProjects from '@/composables/projects/useFetchRrojects'
import Spinner from '@/components/Spinner.vue'
import { getLanguagesImages } from '@/modules/getImageUrl'

export default defineComponent({
    setup() {
        return {
            ...useFetchProjects(),
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
.hero
    background: url(../../assets/images/heros/open-source-hero.jpg) no-repeat center center
    background-size: cover

.card
    margin-bottom: 25px
    position: relative
    font-size: 1.1em

    .content
        min-height: 300px
        position: relative
        padding-bottom: 40px
        padding-top: 10px

        .view-button
            position: absolute
            bottom: 0
            left: 0
            width: 100%

        .card-title
            font-size: 1.4em
            color: #444

.language-image
    width: 40px
    height: 40px
    position: absolute
    top: 12px
    right: 12px

@media (max-width: 991px)
    .card
        .content
            min-height: auto
</style>