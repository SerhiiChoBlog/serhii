<template>
    <div class="next-post-countdown">
        <img src="/storage/posts/sm/how-custom-events-in-javascript-can-decouple-your-code.jpg" alt="">
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

        onMounted(() => {
            fetch('/api/new-post')
                .then(resp => resp.json())
                .then((resp: NewPostResponse | null) => {
                    if (resp) {
                        countdown.value = resp.countdown
                        title.value = resp.title
                    }
                })
                .catch(err => console.error(err))
        })

        return {
            countdown,
            title,
        }
    },
})
</script>

<style scoped>

</style>
