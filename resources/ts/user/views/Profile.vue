<script setup lang="ts">
import type { User } from '@shared/types/models'
import { ref } from 'vue'
import moment from 'moment'
import TableRow from '@user/components/Profile/TableRow.vue'

const user = ref<User>(Auth)

function fetchUser(): void {
    console.log('nice')
}
</script>

<template>
    <div class="flex flex-col items-center md:flex-row gap-14 justify-center">
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
</template>
