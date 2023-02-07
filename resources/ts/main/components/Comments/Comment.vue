<script setup lang="ts">
import { ref } from 'vue'
import type { Comment as CommentType } from '@shared/types/models'
import Comment from '@/components/Comments/Comment.vue'
import CommentForm from '@/components/Comments/CommentForm.vue'
import CommentsWrapper from '@/components/Comments/CommentsWrapper.vue'
import SignedInMethodLogo from '@shared/components/SignedInMethodLogo.vue'

type Props = {
    comment: CommentType
    postId: number
}

type Emits = {
    (e: 'posted'): void
}

const emit = defineEmits<Emits>()
const { comment, postId } = defineProps<Props>()

const reply = ref<boolean>(false)

function replyToComment(): void {
    reply.value = !reply.value
}

function postReply(): void {
    emit('posted')
    reply.value = false
}
</script>

<template>
    <article
        v-if="comment.user"
        class="py-2 flex gap-4 lg:gap-4"
    >
        <a :href="`/user/${comment.user.slug}`" class="relative min-w-[43px]">
            <img
                :src="`/storage/avatars/${comment.user.avatar}`"
                :alt="comment.user.name"
                width="70"
                height="70"
                class="rounded-full drop-shadow-md w-[40px] h-[40px] mt-1"
            />

            <signed-in-method-logo
                v-if="comment.user.sign_in_method !== 'email'"
                :method="comment.user.sign_in_method"
                class="absolute top-8 -right-1.5 w-5 h-5"
            />
        </a>

        <div class="flex flex-col gap-1">
            <h2 class="text-lg font-bold">
                {{ comment.user.name }}
            </h2>

            <p class="text-font-second dark:text-gray-300">
                {{ comment.comment }}
            </p>

            <div class="flex gap-1 items-center">
                <button
                    v-if="Auth && comment.user_id !== Auth.id"
                    @click="replyToComment"
                    class="inline-flex gap-1 items-center text-sm text-main hover:underline"
                >
                    <span v-if="reply">Cancel ·</span>
                    <span v-else>Reply ·</span>
                </button>

                <small class="text-gray-400">
                    {{ comment.pretty_created_at }}
                </small>
            </div>
        </div>
    </article>

    <comment-form
        v-if="reply"
        :comment-id="comment.comment_id || comment.id"
        @posted="postReply"
        :post-id="postId"
    />

    <comments-wrapper
        v-if="comment.comments && comment.comments.length > 0"
        class="pl-7 ml-4 lg:ml-5 border-l-2 border-border border-dashed"
    >
        <comment
            v-for="comment in comment.comments"
            :key="comment.id"
            :comment="comment"
            :post-id="postId"
            @posted="postReply"
        />
    </comments-wrapper>
</template>
