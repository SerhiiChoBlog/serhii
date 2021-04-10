<template>
    <section class="hero is-dark" hero>
        <div class="hero-head"><Navbar/></div>

        <div class="hero-body">
            <div class="container has-text-centered">
                <p class="title">Open source</p>
                <p class="subtitle">Lorem ipsum dolor sit amet consectetur adipisicing elit</p>
            </div>
        </div>
    </section>

    <div class="content">
        <ul>
            <li>first one</li>
            <li v-for="item of list" :key="item">{{ item.full_name }}</li>
        </ul>
    </div>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from 'vue'
import Navbar from "@/components/Navbar.vue"

export default defineComponent({
    setup() {
        const list = ref(null)
        const loading = ref(false)

        onMounted(() => {
            loading.value = true

            fetch('https://api.github.com/users/SerhiiCho/repos')
                .then(res => res.json())
                .then(res => list.value = res)
                .catch(err => console.error(err))
                .finally(() => loading.value = false)
        })

        return {
            list,
            loading,
        }
    },

    components: {
        Navbar,
    },
})
</script>

<style lang="sass" scoped>
[hero]
    background: url(../assets/images/heros/open-source-hero.jpg) no-repeat center center
    background-size: cover
</style>