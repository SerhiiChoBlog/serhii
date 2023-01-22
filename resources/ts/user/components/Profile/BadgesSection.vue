<script setup lang="ts">
import Badge from '@shared/components/Badge.vue'
import { User } from '@shared/types/models'

type Props = {
    user: User
}

const { user } = defineProps<Props>()
</script>

<template>
    <div class="mt-4 pt-4 border-t border-border">
        <h2 class="text-xl font-bold">Achievements</h2>

        <div class="flex flex-wrap gap-0.5 mt-3">
            <Badge
                v-if="user.email_verified_at"
                badge="verified"
                class="w-16"
            />
        </div>
    </div>
</template>
