<script setup lang="ts">
import type { User } from '@shared/types/models'
import moment from 'moment'
import { onMounted, ref } from 'vue'
import axios from 'axios'
import { useRoute } from 'vue-router'
import ErrorMessage from '@shared/components/ErrorMessage.vue'
import TableRow from '@user/components/Profile/TableRow.vue'
import Spinner from '@shared/components/Icons/Spinner.vue'
import Avatar from '@user/components/Profile/Avatar.vue'
import BadgesSection from '@user/components/Profile/BadgesSection.vue'

const user = ref<User | null>(null)
const loading = ref<boolean>(false)
const route = useRoute()

onMounted(() => fetchUser())

function fetchUser() {
    loading.value = true

    const userSlug = route.params.slug as string | undefined

    axios.get<User | null>(`/user/ajax/users/${userSlug || Auth.slug}`)
        .then(resp => user.value = resp.data)
        .catch(err => console.error(err))
        .finally(() => loading.value = false)
}
</script>

<template>
    <Spinner v-if="loading" />

    <div v-else-if="user" class="grid grid-cols-1 md:grid-cols-[300px_auto] gap-8 md:gap-12 max-w-[900px] mx-auto">
        <div>
            <Avatar :user="user" />

            <div class="mt-7 text-center md:text-left">
                <h1 class="text-3xl font-black">{{ user.name }}</h1>
                <h2 class="text-lg text-font-second">@{{ user.slug }}</h2>
            </div>

            <BadgesSection :user="user" />
        </div>

        <div>
            <div class="space-y-3">
                <TableRow title="Joined">
                    {{ moment(user.created_at).format('MMMM Do YYYY') }}
                </TableRow>
                <TableRow title="Posts liked">
                    <span class="text-yellow-600">coming soon</span>
                </TableRow>
                <TableRow title="Comments">
                    <span class="text-yellow-600">coming soon</span>
                </TableRow>
            </div>
        </div>
    </div>

    <ErrorMessage v-else />
</template>
