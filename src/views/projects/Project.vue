<template>
    <section class="hero is-light">
        <div class="hero-head"><Navbar /></div>

        <div class="hero-body">
            <div v-if="projectLoading" class="container has-text-centered">
                <Spinner />
            </div>
            <div v-else class="container has-text-centered">
                <p class="title">{{ project.title }}</p>
                <p class="subtitle">{{ project.description }}</p>
            </div>
        </div>
    </section>

    <div class="container mt-6 pb-6">
        <div v-if="contentLoading" class="has-text-centered"><Spinner /></div>
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
.title
    text-transform: capitalize
</style>