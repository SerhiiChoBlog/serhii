<script setup lang="ts">
import type { Comment } from '@shared/types/models'
import type { Pagination } from '@shared/types/response'
import { onMounted, ref } from 'vue'
import axios from 'axios'
import moment from 'moment'
import handleError from '@admin/modules/handleError'
import PageTitle from '@admin/components/PageTitle.vue'
import Spinner from '@shared/components/Icons/Spinner.vue'
import DataTable from '@admin/components/DataTable/DataTable.vue'
import BodyDetail from '@admin/components/DataTable/BodyDetail.vue'
import BodyRow from '@admin/components/DataTable/BodyRow.vue'
import HeadDetail from '@admin/components/DataTable/HeadDetail.vue'

const comments = ref<Comment[]>([])
const totalComments = ref<number | null>(null)
const loading = ref(false)
const nextPageUrl = ref<string | null>(null)

onMounted(() => fetchComments('/admin/ajax/comments', true))

function fetchComments(url: string, refresh = true): void {
    if (refresh) {
        loading.value = true
    }

    axios.get<{ comments: Pagination<Comment[]>, total: number }>(url)
        .then(resp => {
            const data = resp.data

            nextPageUrl.value = data.comments.next_page_url
            totalComments.value = data.total

            refresh
                ? comments.value = data.comments.data
                : comments.value.push(...data.comments.data)
        })
        .catch(handleError)
        .finally(() => loading.value = false)
}

function loadMoreComments(): void {
    if (nextPageUrl.value) {
        fetchComments(nextPageUrl.value, false)
    }
}
</script>

<template>
    <div class="container max-w-7xl">
        <PageTitle>Comments <b v-if="totalComments">{{ totalComments }}</b></PageTitle>

        <Spinner v-if="loading" />

        <DataTable v-else>
            <template v-slot:head>
                <HeadDetail class="w-12">ID</HeadDetail>
                <HeadDetail class="w-56">Post name</HeadDetail>
                <HeadDetail>User</HeadDetail>
                <HeadDetail>Comment</HeadDetail>
                <HeadDetail>Reply to</HeadDetail>
                <HeadDetail class="w-44">Created</HeadDetail>
            </template>

            <BodyRow v-for="comment in comments" :key="comment.id">
                <BodyDetail>{{ comment.id }}</BodyDetail>
                <BodyDetail>
                    <a :href="`/posts/${comment.post.slug}`" target="_blank">
                        {{ comment.post.title }}
                    </a>
                </BodyDetail>
                <BodyDetail>
                    <a
                        :href="`/@${comment.user.slug}`"
                        target="_blank"
                        class="flex items-center gap-3 rounded-full hover:bg-main hover:text-white transition-colors"
                    >
                        <img
                            class="inline-block w-10 h-10 rounded-full shadow-md"
                            :src="`/storage/avatars/${comment.user.avatar}`"
                            :alt="comment.user.name"
                        />
                        <span>{{ comment.user.name }}</span>
                    </a>
                </BodyDetail>
                <BodyDetail>
                    {{ comment.comment }}
                </BodyDetail>
                <BodyDetail>
                    <span v-if="comment.parent">{{ comment.parent.comment }}</span>
                    <i v-else class="fas fa-times text-font-second opacity-50"></i>
                </BodyDetail>
                <BodyDetail>
                    {{ moment(comment.created_at).format('d MMM YYYY H:mm') }}
                </BodyDetail>
            </BodyRow>
        </DataTable>

        <!-- Load more button -->
        <div class="text-center mt-7">
            <button
                v-if="nextPageUrl"
                class="border border-border px-7 py-2 rounded-full uppercase"
                @click="loadMoreComments"
            >
                Load more
            </button>
        </div>
    </div>
</template>
