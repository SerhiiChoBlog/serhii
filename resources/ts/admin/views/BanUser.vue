<script setup lang="ts">
import useBanUser from '@admin/composables/useBanUser'
import Spinner from '@shared/components/Icons/Spinner.vue'
import PageTitle from '@admin/components/PageTitle.vue'
import MainButton from '@admin/components/Buttons/MainButton.vue'

const { user, loading, ban, comment } = useBanUser()
</script>

<template>
    <Spinner v-if="loading || !user" />

    <div v-else class="container max-w-[700px] m-auto px-5">
        <PageTitle>{{ user.name }}</PageTitle>

        <form @submit.prevent="ban">
            <div>
                <label for="comment" class="text-lg">
                    <span v-if="user.ban">
                        <b class="text-main">{{ user.name }}</b> is already banned!
                    </span>
                    <span v-else>
                        Explain why you want to ban <b class="text-main">{{ user.name }}</b> ({{ comment.length }}/190)
                    </span>
                </label>
                <textarea
                    id="comment"
                    v-model="comment"
                    class="border border-border rounded-lg w-full p-2 bg-page"
                    minlength="5"
                    maxlength="190"
                    :disabled="user.ban"
                />
            </div>

            <MainButton
                type="submit"
                class="mt-4"
                :class="user.ban ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700'"
            >
                <i class="fas fa-ban mr-2"></i>
                {{ user.ban ? 'Unban' : 'Ban' }} {{ user.name }}
            </MainButton>
        </form>
    </div>
</template>
