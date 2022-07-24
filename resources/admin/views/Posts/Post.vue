<script setup lang="ts">
import type { Post } from '../../../types/models'
import axios from 'axios'
import handleError from '../../modules/handleError'
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'

onMounted(() => fetchPost())

const route = useRoute()
const loading = ref(true)
const post = ref<Post | null>(null)

function fetchPost(): void {
    loading.value = true

    axios.get<Post>(`/admin/ajax/posts/${route.params.id}/edit`)
        .then(resp => post.value = resp.data)
        .catch(handleError)
        .finally(() => loading.value = false)
}
</script>

<template>

</template>
