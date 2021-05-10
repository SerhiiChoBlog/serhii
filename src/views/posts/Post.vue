<template>
    <section class="hero is-dark is-medium" >
        <div class="hero-head"><Navbar :isLight="false" /></div>

        <div class="hero-body">
            <div v-if="postLoading" class="container has-text-centered">
                <Spinner />
            </div>
            <div v-else class="container">
                <div class="columns">
                    <div class="column is-flex is-align-items-center">
                        <p class="title" :style="{ fontSize: titleFontSize }">
                            {{ post.title }}
                        </p>
                    </div>
                    <div class="column">
                        <img :src="post.image_url" :alt="post.title" class="post-image">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div v-if="postLoading" class="has-text-centered"><Spinner /></div>
                <div v-else-if="postError"><h3 class="is-size-4 has-text-centered">{{ postError }}</h3></div>
                <div v-else class="content post-content is-medium px-3" v-html="post.content"></div>
            </div>
            <div class="col-lg-3">
                <div class="sidebar-content">
                    sidebar is here... and here...and here more text...
                </div>
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

    .post-image
        position: absolute
        height: 300px
        border-radius: 10px
        box-shadow: 2px 2px 5px rgba(0, 0, 0, .2)
        object-fit: cover
        object-position: center
        bottom: -160px
        right: 15px

.post-content,
.sidebar-content
    margin-top: 70px

@media (max-width: 1407px)
    .hero
        .post-image
            position: static
            width: 100%
            height: auto

    .post-content,
    .sidebar-content
        margin-top: 30px

@media (max-width: 992px)
    .hero .hero-body
        font-size: .9em

@media (max-width: 768px)
    .hero .hero-body
        font-size: .7em
        text-align: center

    .post-content
        font-size: 1.1em
</style>