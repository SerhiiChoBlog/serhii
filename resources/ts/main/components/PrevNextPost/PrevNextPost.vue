<script setup lang="ts">
import { onMounted, ref } from 'vue'
import Spinner from '@shared/components/Icons/Spinner.vue'

type Props = {
    postId: number
}

onMounted(() => {
    loading.value = true
})

const { postId } = defineProps<Props>()
const loading = ref(false)
</script>

<template>
    <div v-if="loading" class="text-center pt-5">
        <spinner />
    </div>
</template>