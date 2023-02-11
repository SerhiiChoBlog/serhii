<script setup lang="ts">
import useBanUser from '@admin/composables/useBanUser'
import Spinner from '@shared/components/Icons/Spinner.vue'
import PageTitle from '@admin/components/PageTitle.vue'

const { user, loading, ban } = useBanUser()
</script>

<template>
    <Spinner v-if="loading || !user" />

    <div v-else class="container">
        <PageTitle>{{ user.name }}</PageTitle>

        //
    </div>
</template>
