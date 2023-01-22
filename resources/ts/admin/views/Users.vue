<script setup lang="ts">
import type { User } from '@shared/types/models'
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

const users = ref<User[]>([])
const loading = ref(false)

onMounted(() => fetchUsers())

function fetchUsers(): void {
    loading.value = true

    axios.get<User[]>('/admin/ajax/users')
        .then(resp => users.value = resp.data)
        .catch(handleError)
        .finally(() => loading.value = false)
}
</script>

<template>
    <div class="container max-w-5xl">
        <PageTitle>Users</PageTitle>

        <Spinner v-if="loading" />

        <DataTable v-else>
            <template v-slot:head>
                <HeadDetail class="w-12">ID</HeadDetail>
                <HeadDetail class="w-12">Avatar</HeadDetail>
                <HeadDetail>Name</HeadDetail>
                <HeadDetail>Confirmed</HeadDetail>
                <HeadDetail>Created</HeadDetail>
            </template>

            <BodyRow v-for="user in users" :key="user.id">
                <BodyDetail>{{ user.id }}</BodyDetail>
                <BodyDetail>
                    <a :href="`/storage/avatars/${user.avatar}`" target="_blank">
                        <img
                            :src="`/storage/avatars/${user.avatar}`"
                            width="200"
                            height="200"
                            class="w-8 h-8 rounded-full"
                        />
                    </a>
                </BodyDetail>
                <BodyDetail>{{ user.name }}</BodyDetail>
                <BodyDetail :class="user.email_verified_at ? 'text-green-600' : 'text-red-700'">
                    {{ user.email_verified_at ? 'Yes' : 'No' }}
                </BodyDetail>
                <BodyDetail>
                    {{ moment(user.created_at).format('DD MMM YYYY hh:mm') }}
                </BodyDetail>
            </BodyRow>
        </DataTable>
    </div>
</template>
