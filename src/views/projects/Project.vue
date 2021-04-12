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
        <div v-if="loading" class="has-text-centered"><Spinner /></div>
        <div v-else class="content" v-html="content"></div>
    </div>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import Navbar from '@/components/Navbar.vue'
import Spinner from '@/components/Spinner.vue'
import showdown from 'showdown'

export default defineComponent({
    setup() {
        const { params } = useRoute()
        let content = ref('')
        let loading = ref(false)

        onMounted(() => {
            loading.value = true

            fetch(`https://raw.githubusercontent.com/SerhiiCho/${params.projectName}/master/README.md`)
                .then(res => res.text())
                .then(res => {
                    var converter = new showdown.Converter()
                    content.value = converter.makeHtml(res)
                })
                .catch(err => console.error(err))
                .finally(() => loading.value = false)
        })

        return { content, loading }
    },

    components: {
        Navbar,
        Spinner,
    },
})
</script>
