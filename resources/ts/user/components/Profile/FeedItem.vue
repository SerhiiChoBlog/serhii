<script setup lang="ts">
import type { Feed } from '@shared/types/models'
import moment from 'moment'

type Props = {
    feed: Feed
}

const { feed } = defineProps<Props>()
</script>

<template>
    <li class="bg-page-second rounded-md px-5 py-3 space-y-3">
        <h2 class="text-xl">{{ feed.title }}</h2>
        <h3>{{ feed.content }}</h3>
        <h4 class="opacity-80">
            {{ moment(feed.date).format('MMMM Do YYYY, HH:mm') }}
        </h4>
    </li>
</template>
