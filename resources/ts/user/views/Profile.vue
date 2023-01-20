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
    <div class="flex flex-col md:flex-row gap-14 justify-center">
        <div>
            <img
                :src="`/storage/avatars/${user.avatar}`"
                :alt="`${user.name}'s avatar`"
                width="200"
                height="200"
                class="w-36 rounded-full shadow-lg"
            />
        </div>

        <div>
            <div class="space-y-2">
                <TableRow title="Joined">
                    <span class="inline-block w-[160px]">
                        {{ moment(user.created_at).format('MMMM Do YYYY') }}
                    </span>
                </TableRow>
                <TableRow title="Comments">
                    {{ 0 }}
                </TableRow>
                <TableRow title="Liked">
                    {{ 0 }}
                </TableRow>
            </div>
        </div>
    </div>
</template>
