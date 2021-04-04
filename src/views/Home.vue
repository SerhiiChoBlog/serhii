<template>
    <section class="hero is-large is-dark" style="background: url(https://www.howtopython.org/wp-content/uploads/2020/04/laptops_python-1170x780.jpg); background-size: cover">
        <div class="hero-head">
            <Navbar/>
        </div>

        <div class="hero-body">
            <div class="container has-text-centered">
                <p class="title">
                    Serhii Cho
                </p>
                <p class="subtitle">
                    Software developer
                </p>
            </div>
        </div>
    </section>
</template>

<script lang="ts">
import {defineComponent} from 'vue'
import Navbar from "@/inc/Navbar.vue"

export default defineComponent({
    components: {
        Navbar,
    },
})
</script>
