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


    <div class="container mt-5">
        <div v-if="processingPosts" class="has-text-centered"><Spinner /></div>

        <transition name="show-projects" mode="out-in">
            <div v-if="processingPosts"></div>
            <h4 v-else-if="postsError" class="is-size-4 has-text-centered">{{ postsError }}</h4>
            <div v-else class="posts">
                <router-link class="post"
                    :to="`/posts/${post.id}`"
                    v-for="post in posts"
                    :key="post.id"
                >
                    <img class="post-image" :src="host + post.image_sm">

                    <div class="post-content">
                        <h2 class="post-title has-text-black">{{ post.title }}</h2>
                        <p class="post-intro">{{ post.intro }}</p>
                        <div class="tags mt-2">
                            <span class="tag my-0 is-small is-normal is-dark"
                                v-for="tag in post.tags"
                                :key="tag.id"
                                :style="{ backgroundColor: tag.color }"
                            >{{ tag.name }}</span>
                            <span class="has-text-grey ml-2">{{ post.pretty_created_at }}</span>
                        </div>
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
import { host } from '@/config'

export default defineComponent({
    setup() {
        return {
            host,
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
        display: flex
        flex-direction: row
        align-items: center
        padding: 7px 15px
        border-radius: 10px
        transition: background-color 300ms

        &:hover
            background-color: #eee

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

@media (max-width: 767px)
    .posts
        .post
            flex-direction: column
            margin-bottom: 30px

            .post-content
                margin: 0

            .post-image
                width: 100%
                height: auto
                margin-bottom: 10px
</style>