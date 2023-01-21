<script setup lang="ts">
import type { User } from '@shared/types/models'
import moment from 'moment'
import { onMounted, ref } from 'vue'
import axios from 'axios'
import { useRoute } from 'vue-router'
import ErrorMessage from '@shared/components/ErrorMessage.vue'
import TableRow from '@user/components/Profile/TableRow.vue'
import Spinner from '@shared/components/Icons/Spinner.vue'

const user = ref<User | null>()
const loading = ref<boolean>(false)
const route = useRoute()

onMounted(() => fetchUser())

function fetchUser() {
    loading.value = true

    axios.get(`/user/ajax/users/${route.params.slug}`)
        .then(resp => {
            user.value = resp.data
        })
        .catch(err => console.error(err))
        .finally(() => loading.value = false)
}
</script>

<template>
    <Spinner v-if="loading" />

    <div v-else-if="user" class="flex flex-col items-center md:flex-row gap-14 justify-center">
        <div>
            <img
                :src="`/storage/avatars/${user.avatar}`"
                :alt="`${user.name}'s avatar`"
                width="200"
                height="200"
                class="w-36 rounded-full shadow-lg"
            />
        </div>

        <div class="w-full md:w-auto">
            <div class="space-y-2">
                <TableRow title="Name"> {{ user.name }}</TableRow>
                <TableRow title="Joined">
                    {{ moment(user.created_at).format('MMMM Do YYYY') }}
                </TableRow>
            </div>
        </div>
    </div>

    <ErrorMessage v-else />
</template>
