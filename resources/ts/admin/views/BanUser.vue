<script setup lang="ts">
import useBanUser from '@admin/composables/useBanUser'
import Spinner from '@shared/components/Icons/Spinner.vue'
import PageTitle from '@admin/components/PageTitle.vue'
import MainButton from '@admin/components/Buttons/MainButton.vue'

const { user, loading, ban, comment } = useBanUser()
</script>

<template>
    <Spinner v-if="loading || !user" />

    <div v-else class="container max-w-[700px] m-auto">
        <PageTitle>{{ user.name }}</PageTitle>

        <form @submit.prevent="ban">
            <div>
                <label for="comment">
                    Explain why user is banner ({{ comment.length }}/190)
                </label>
                <textarea
                    id="comment"
                    v-model="comment"
                    class="border border-border rounded-lg w-full p-2"
                    minlength="5"
                    maxlength="190"
                />
            </div>

            <MainButton
                type="submit"
                class="mt-5 bg-red-600 hover:bg-red-700"
            >
                <i class="fas fa-ban mr-2"></i>
                Ban {{ user.name }}
            </MainButton>
        </form>
    </div>
</template>
