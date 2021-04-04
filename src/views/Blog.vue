<template>
    <section class="hero is-dark" style="background: url(https://medicainstitute.com/wp-content/uploads/2017/10/blue-gradient-background-6517.jpeg); background-size: cover">
        <div class="hero-head">
            <Navbar/>
        </div>

        <div class="hero-body">
            <div class="container has-text-centered">
                <p class="title">Blog</p>
                <p class="subtitle">Lorem ipsum dolor sit amet consectetur adipisicing elit</p>
            </div>
        </div>
    </section>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import Navbar from "@/inc/Navbar.vue"

export default defineComponent({
    components: {
        Navbar,
    },
})
</script>

