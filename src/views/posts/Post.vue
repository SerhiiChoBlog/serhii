<template>
    <section class="hero is-dark is-medium">
        <div class="hero-head"><Navbar :isLight="false" /></div>

        <div class="hero-body">
            <div v-if="postLoading" class="container has-text-centered">
                <Spinner />
            </div>
            <div v-else class="container">
                <p class="title">{{ post.title }}</p>
            </div>
        </div>
    </section>

    <div class="container mt-6 pb-6">
        <div class="row">
            <div class="col-lg-9">
                <div v-if="postLoading" class="has-text-centered"><Spinner /></div>
                <div v-else-if="postError"><h3 class="is-size-4 has-text-centered">{{ postError }}</h3></div>
                <div v-else class="content" v-html="post.content"></div>
            </div>
            <div class="col-lg-3">
                sidebar is here... and here...and here more text...
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import Navbar from "@/components/Navbar.vue"
import Spinner from "@/components/Spinner.vue"
import useFetchPost, { } from '@/composables/posts/useFetchPost'

export default defineComponent({
    setup() {
        return {
            ...useFetchPost(),
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
    background-color: #141618
</style>