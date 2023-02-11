<script setup lang="ts">
import PageTitle from '@admin/components/PageTitle.vue'
import Spinner from '@shared/components/Icons/Spinner.vue'
import useComment from '@admin/composables/useComment'
import MainButton from '@admin/components/Buttons/MainButton.vue'
import useToggleApprove from '@admin/composables/useToggleApprove'

const { comment, loading, fetchComment } = useComment()
const { toggleApproved } = useToggleApprove()

function toggleApprovingComment(): void {
    if (!comment.value)
        return

    toggleApproved(comment.value)
    fetchComment()
}
</script>

<template>
    <Spinner v-if="loading || !comment" />

    <div v-else class="container">
        <PageTitle>Comment <b>#{{ comment.id }}</b></PageTitle>

        <div class="flex flex-col lg:flex-row gap-10">
            <div class="w-full">
                <h2>{{ comment.comment }}</h2>
            </div>

            <div class="w-full max-w-[200px] flex flex-col gap-3 items-start justify-center">
                <MainButton
                    v-if="comment.is_approved"
                    @click="toggleApprovingComment"
                    class="bg-red-700 hover:bg-red-800 w-full"
                >
                    <i class="fas fa-times mr-2"></i>
                    Disapprove
                </MainButton>
                <MainButton
                    v-else
                    @click="toggleApprovingComment"
                    class="bg-green-700 hover:bg-green-800 w-full"
                >
                    <i class="fas fa-check mr-2"></i>
                    Approve
                </MainButton>

                <MainButton class="bg-red-700 hover:bg-red-800 w-full">
                    <i class="fas fa-trash mr-2"></i>
                    Delete
                </MainButton>
            </div>
        </div>
    </div>
</template>
