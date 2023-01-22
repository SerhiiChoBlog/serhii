<script setup lang="ts">
import type { User } from '@shared/types/models'
import moment from 'moment'
import { onMounted, ref } from 'vue'
import axios from 'axios'
import { useRoute } from 'vue-router'
import ErrorMessage from '@shared/components/ErrorMessage.vue'
import TableRow from '@user/components/Profile/TableRow.vue'
import Spinner from '@shared/components/Icons/Spinner.vue'
import Badge from '@shared/components/Badge.vue'

const user = ref<User | null>()
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

    <div v-else-if="user" class="grid grid-cols-1 md:grid-cols-[300px_auto] gap-16 max-w-[900px] mx-auto">
        <div>
            <img
                :src="`/storage/avatars/${user.avatar}`"
                :alt="`${user.name}'s avatar`"
                width="200"
                height="200"
                class="w-full max-w-[250px] mx-auto lg:mx-0 rounded-full shadow-lg pointer-events-none"
            />

            <div class="mt-7 text-center md:text-left">
                <h1 class="text-3xl font-black">{{ user.name }}</h1>
                <h2 class="text-lg text-font-second">@{{ user.slug }}</h2>
            </div>

            <div class="mt-4 pt-4 border-t border-border">
                <h2 class="text-xl font-bold">Achievements</h2>

                <div class="mt-2">
                    <Badge
                        badge="verified"
                        v-if="user.email_verified_at"
                        class="w-14"
                    />
                </div>
            </div>
        </div>

        <div>
            <div class="space-y-2">
                <TableRow title="Joined">
                    {{ moment(user.created_at).format('MMMM Do YYYY') }}
                </TableRow>
            </div>
        </div>
    </div>

    <ErrorMessage v-else />
</template>
