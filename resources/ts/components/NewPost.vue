<template>
    <div v-if="countdown && title && image" class="next-post-countdown">
        <img :src="image" :alt="title">
        <div>
            <h2>new post in <b>{{ countdown }}</b></h2>
            <h3>{{ title }}</h3>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, onMounted, ref } from 'vue'
import NewPostResponse from '../admin/interfaces/NewPostResponse'

export default defineComponent({
    setup() {
        const countdown = ref<string | null>(null)
        const title = ref<string | null>(null)
        const image = ref<string | null>(null)

        onMounted(() => {
            fetch('/api/new-post')
                .then(resp => resp.json())
                .then((resp: NewPostResponse | null) => {
                    if (resp) {
                        countdown.value = resp.countdown
                        title.value = resp.title
                        image.value = resp.image
                    }
                })
                .catch(err => console.error(err))
        })

        return {
            countdown,
            title,
            image,
        }
    },
})
</script>

<style scoped>

</style>
