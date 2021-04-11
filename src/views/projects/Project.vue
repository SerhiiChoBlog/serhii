<template>
    <section class="hero is-medium is-dark" hero>
        <div class="hero-head"><Navbar/></div>

        <div class="hero-body">
            <div class="container has-text-centered">
                <p class="title">Project</p>
                <p class="subtitle">Lorem ipsum dolor sit amet consectetur adipisicing elit</p>
            </div>
        </div>
    </section>

    <div class="container mt-6 pb-6">
        <div class="content" v-html="content"></div>
    </div>
</template>

<script>
import { defineComponent, ref } from 'vue'
import { useRoute } from 'vue-router'
import Navbar from '@/components/Navbar'
import showdown from 'showdown'

export default defineComponent({
    setup() {
        const { params } = useRoute()
        let content = ref('')

        fetch(`https://raw.githubusercontent.com/SerhiiCho/${params.projectName}/master/README.md`)
            .then(res => res.text())
            .then(res => {
                var converter = new showdown.Converter()
                content.value = converter.makeHtml(res)
            })
            .catch(err => console.error(err))

        return { content }
    },

    components: {
        Navbar,
    },
})
</script>
