<script setup lang="ts">
import type { BadgesSection } from '@shared/types'
import Badge from '@shared/components/Badge.vue'
import { User } from '@shared/types/models'
import { ref } from 'vue'

type Props = {
    user: User
}

const { user } = defineProps<Props>()

const badges = ref<BadgesSection[]>([
    {
        tip: 'User verified achievement',
        badge: 'verified',
        show: !!user.email_verified_at,
    },
    {
        tip: 'User submitted 5 comments',
        badge: 'commentator',
        show: user.comments_count! >= 5,
    },
])
</script>

<template>
    <div class="mt-4 pt-4 border-t border-border">
        <h2 class="text-xl font-bold">Achievements</h2>

        <div class="flex flex-wrap gap-0.5 mt-3">
            <Badge
                v-for="badge in badges.filter(b => b.show)"
                :key="badge.badge"
                :badge="badge.badge"
                class="w-16"
                :tip="badge.tip"
            />

            <span
                v-if="badges.filter(b => b.show).length === 0"
                class="text-lg text-font-second"
            >
                😔 No badges yet
            </span>
        </div>
    </div>
</template>
