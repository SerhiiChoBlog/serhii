<script setup lang="ts">
import type { Post } from '@shared/types/models'
import { onMounted, ref } from 'vue'
import handleError from '@admin/modules/handleError'
import PageTitle from '@admin/components/PageTitle.vue'
import MainButton from '@admin/components/Buttons/MainButton.vue'
import PostItem from '@admin/components/Post/PostItem.vue'
import axios from 'axios'
import Spinner from '@shared/components/Icons/Spinner.vue'
import DataTable from '@admin/components/DataTable/DataTable.vue'
import HeadDetail from '@admin/components/DataTable/HeadDetail.vue'

const posts = ref<Post[]>([])
const loading = ref(true)

onMounted(() => fetchPosts())

function fetchPosts(): void {
    axios.get<Post[]>('/admin/ajax/posts')
        .then(resp => posts.value = resp.data)
        .catch(handleError)
        .finally(() => loading.value = false)
}
</script>

<template>
    <div class="container">
        <page-title>
            <div class="flex items-center justify-center gap-3">
                <span>Posts</span>

                <main-button :route="{ name: 'posts-create' }">
                    <i class="fas fa-plus"></i>
                </main-button>
            </div>
        </page-title>

        <spinner v-if="loading" />

        <DataTable v-else-if="posts.length > 0">
            <template v-slot:head>
                <HeadDetail></HeadDetail>
                <HeadDetail>Image</HeadDetail>
                <HeadDetail class="min-w-[300px]">Title</HeadDetail>
                <HeadDetail>Intro</HeadDetail>
                <HeadDetail>Shares</HeadDetail>
                <HeadDetail>Views</HeadDetail>
                <HeadDetail>View</HeadDetail>
                <HeadDetail>Edit</HeadDetail>
            </template>

            <post-item
                v-for="post in posts"
                :key="post.id"
                :post="post"
            />
        </DataTable>

        <h2 v-else class="text-xl text-center pt-4">There are no posts</h2>
    </div>
</template>
