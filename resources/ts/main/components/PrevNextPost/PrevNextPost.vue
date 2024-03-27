<script setup lang="ts">
import { onMounted, ref } from 'vue'
import Spinner from '@shared/components/Icons/Spinner.vue'
import Btn from '@/components/PrevNextPost/Btn.vue'

type Props = {
    postId: number
}

onMounted(() => {
    loading.value = true
    fetchPrevNextPosts()
})

const { postId } = defineProps<Props>()
const loading = ref(false)
const prevURL = ref<string | null>(null)
const nextURL = ref<string | null>(null)

function fetchPrevNextPosts() {
    // Fetch prev and next post ids
    loading.value = false
}
</script>

<template>
    <div v-if="loading" class="text-center pt-5">
        <spinner />
    </div>

    <div v-else class="flex items-center justify-center gap-2 mt-4">
        <btn :url="prevURL">Previous article</btn>
        <btn :url="nextURL">Next article</btn>
    </div>
</template>