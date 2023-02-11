<script setup lang="ts">
import PageTitle from '@admin/components/PageTitle.vue'
import Spinner from '@shared/components/Icons/Spinner.vue'
import useUser from '@admin/composables/useUser'

const { user, loading } = useUser()
</script>

<template>
    <Spinner v-if="loading || !user" />

    <div v-else class="container">
        <PageTitle>{{ user.name }}</PageTitle>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            <div class="border rounded-lg p-5">
                <h2>{{ user.name }}</h2>
            </div>

            <div class="border rounded-lg p-5">
                //
            </div>
        </div>
    </div>
</template>
