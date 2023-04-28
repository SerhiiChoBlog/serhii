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
        This person hasn't done any activity yet
    </p>

    <div v-else class="space-y-3">
        <div v-for="item in feed" :key="item.id">
            <feed-item
                v-if="item.type === 'post-like'"
                :title="`likes the article “${item.post!.title}”`"
                :content="item.post!.intro"
                :image="`/${item.post!.image_xs}`"
                :url="`/posts/${item.post!.slug}`"
                :user-name="item.user.name"
            />

            <feed-item
                v-else-if="item.type === 'comment-like'"
                :title="`likes the comment of ${item.comment!.user!.name}`"
                :content="item.comment!.comment"
                :image="`/storage/avatars/${item.comment!.user!.avatar}`"
                :url="`/@${item.comment!.user!.slug}`"
                :user-name="item.user.name"
            />

            <feed-item
                v-else-if="item.type === 'comment'"
                :title="`wrote a comment for “${item.post!.title}” article`"
                :content="item.comment!.comment"
                :image="`/${item.post!.image_xs}`"
                :url="`/posts/${item.post!.slug}`"
                :user-name="item.user.name"
            />

            <feed-item
                v-else-if="item.type === 'badge'"
                :title="`received the “${item.badge!.name}” badge`"
                :content="item.comment!.comment"
                :image="`/storage/badges/${item.badge!.name}`"
                :url="`User receives a badge: ${item.badge!.name} because ${item.badge!.description}`"
                :user-name="item.user.name"
            />
        </div>
    </div>
</template>
