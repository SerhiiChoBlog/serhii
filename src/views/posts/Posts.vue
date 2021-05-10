<template>
    <section class="hero is-dark">
        <div class="hero-head"><Navbar /></div>

        <div class="hero-body">
            <div class="container has-text-centered">
                <p class="title">Blog</p>
                <p class="subtitle">I'm mostly writing about productivity tips and technical related articles.</p>
            </div>
        </div>
    </section>


    <div class="container mt-6">
        <div v-if="processingPosts" class="has-text-centered"><Spinner /></div>

        <transition name="show-projects" mode="out-in">
            <div v-if="processingPosts"></div>
            <h4 v-else-if="postsError" class="is-size-4 has-text-centered">{{ postsError }}</h4>
            <div v-else class="posts">
                <router-link class="post is-flex is-flex-direction-row is-align-items-center mb-4"
                    :to="`/posts/${post.id}`"
                    v-for="post in posts"
                    :key="post.id"
                >
                    <img class="post-image" :src="post.image_url">

                    <div class="post-content">
                        <h2 class="post-title">{{ post.title }}</h2>
                        <p class="post-intro">{{ post.intro }}</p>
                    </div>
                </router-link>
            </div>
        </transition>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import Navbar from "@/components/Navbar.vue"
import Spinner from "@/components/Spinner.vue"
import useFetchPosts from '@/composables/posts/useFetchPosts'

export default defineComponent({
    setup() {
        return {
            ...useFetchPosts(),
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
    background: url(../../assets/images/heros/blog-hero.jpg) no-repeat center center
    background-size: cover

.posts
    .post
        &-image
            width: 260px
            height: 130px
            border-radius: 10px
            box-shadow: 2px 2px 5px rgba(0, 0, 0, .2)
            object-fit: cover
            object-position: center

        &-content
            margin-left: 30px

            .post-title
                font-size: 1.3em
                font-weight: bold

            .post-intro
                color: #555
</style>