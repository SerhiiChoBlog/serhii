<template>
    <section class="hero is-light" hero>
        <div class="hero-head"><Navbar /></div>

        <div class="hero-body">
            <div class="container has-text-centered">
                <p class="title">Project</p>
                <p class="subtitle">Lorem ipsum dolor sit amet consectetur adipisicing elit</p>
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

export default defineComponent({
    setup() {
        return {
            ...useFetchProjectContent(),
        }
    },

    components: {
        Navbar,
        Spinner,
    },
})
</script>
