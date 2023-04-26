<script setup lang="ts">
import type { Feed } from '@shared/types/models'
import { onMounted, ref } from 'vue'
import axios from 'axios'
import handleServerError from '@shared/modules/handleServerError'
import FeedItem from '@user/components/Profile/FeedItem.vue'
import Spinner from '@shared/components/Icons/Spinner.vue'

type Props = {
    slug: string
}

const { slug } = defineProps<Props>()

const feed = ref<Feed[]>([])
const loading = ref<boolean>(false)

onMounted(() => fetchFeed())

function fetchFeed(): void {
    if (loading.value) {
        return
    }

    loading.value = true

    axios.get<Feed[]>(`/api/users/feed/${slug}`)
        .then(resp => feed.value = resp.data)
        .catch(handleServerError)
        .finally(() => loading.value = false)
}
</script>

<template>
    <spinner v-if="loading" />

    <p v-else-if="feed.length === 0" class="text-xl">
        This person hasn't done anything yet 🙁
    </p>

    <ul v-else class="space-y-3">
        <feed-item
            v-for="item in feed"
            :key="item.id"
            :feed="item"
        />
    </ul>
</template>
