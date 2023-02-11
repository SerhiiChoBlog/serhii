<script setup lang="ts">
import PageTitle from '@admin/components/PageTitle.vue'
import Spinner from '@shared/components/Icons/Spinner.vue'
import useComment from '@admin/composables/useComment'

const { comment, loading } = useComment()
</script>

<template>
    <Spinner v-if="loading || !comment" />

    <div v-else class="container">
        <PageTitle>Comment <b>#{{ comment.id }}</b></PageTitle>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            <div class="border rounded-lg p-5">
                <h2>{{ comment.comment }}</h2>
            </div>

            <div class="border rounded-lg p-5">
                //
            </div>
        </div>
    </div>
</template>
