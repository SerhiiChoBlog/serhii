<template>
    <div v-if="title && image && image !== 'storage/posts/placeholder.jpg'" class="next-post">
        <img :src="image" :alt="title">
        <div>
            <h2>next post is coming soon...</h2>
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
                        title.value = resp.title
                        image.value = resp.image_sm
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
