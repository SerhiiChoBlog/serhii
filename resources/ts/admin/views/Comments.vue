<script setup lang="ts">
import moment from 'moment'
import PageTitle from '@admin/components/PageTitle.vue'
import Spinner from '@shared/components/Icons/Spinner.vue'
import DataTable from '@admin/components/DataTable/DataTable.vue'
import BodyDetail from '@admin/components/DataTable/BodyDetail.vue'
import BodyRow from '@admin/components/DataTable/BodyRow.vue'
import HeadDetail from '@admin/components/DataTable/HeadDetail.vue'
import useComments from '@admin/composables/useComments'

const {
    comments,
    totalComments,
    loading,
    nextPageUrl,
    loadMoreComments,
    toggleApproved,
} = useComments()
</script>

<template>
    <div class="container max-w-7xl">
        <PageTitle>Comments <b v-if="totalComments">{{ totalComments }}</b></PageTitle>

        <Spinner v-if="loading" />

        <DataTable v-else>
            <template v-slot:head>
                <HeadDetail class="w-12">#</HeadDetail>
                <HeadDetail><i class="fas fa-check"></i></HeadDetail>
                <HeadDetail class="w-56">Post name</HeadDetail>
                <HeadDetail>User</HeadDetail>
                <HeadDetail>Reply to</HeadDetail>
                <HeadDetail>Comment</HeadDetail>
                <HeadDetail class="w-44">Created</HeadDetail>
            </template>

            <BodyRow v-for="comment in comments" :key="comment.id">
                <BodyDetail>{{ comment.id }}</BodyDetail>
                <BodyDetail>
                    <button @click="toggleApproved">
                        <i
                            class="fas text-md lg:text-2xl"
                            :class="comment.is_approved ? 'fa-toggle-on text-green-600' : 'fa-toggle-off text-red-600'"
                        ></i>
                    </button>
                </BodyDetail>
                <BodyDetail>
                    <a :href="`/posts/${comment.post.slug}`" target="_blank">
                        {{ comment.post.title }}
                    </a>
                </BodyDetail>
                <BodyDetail>
                    <a
                        :href="`/@${comment.user.slug}`"
                        target="_blank"
                        class="flex flex-col lg:flex-row items-center gap-3 rounded-full hover:bg-main hover:text-white transition-colors"
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
                    <span v-if="comment.parent">{{ comment.parent.comment }}</span>
                </BodyDetail>
                <BodyDetail>
                    {{ comment.comment }}
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
