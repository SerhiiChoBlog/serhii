<script setup lang="ts">
import type { FeedItem } from '@shared/types'
import { onMounted, ref } from 'vue'
import axios from 'axios'
import handleServerError from '@shared/modules/handleServerError'
import FeedItemComponent from '@user/components/Profile/FeedItem.vue'
import Spinner from '@shared/components/Icons/Spinner.vue'

type Props = {
    slug: string
}

const { slug } = defineProps<Props>()

const feed = ref<FeedItem[]>([])
const loading = ref<boolean>(false)

onMounted(() => fetchFeed())

function fetchFeed(): void {
    if (loading.value) {
        return
    }

    loading.value = true

    axios.get(`/api/users/feed/${slug}`)
        .then(resp => console.log(resp.data))
        .catch(handleServerError)
        .finally(() => loading.value = false)
}
</script>

<template>
    <spinner v-if="loading" />

    <p v-else-if="feed.length === 0" class="text-xl">
        This person hasn't done anything yet 🙁
    </p>

    <ul v-else>
        <feed-item-component
            v-for="item in feed"
            :key="item.id"
            :item="item"
        />
    </ul>
</template>
