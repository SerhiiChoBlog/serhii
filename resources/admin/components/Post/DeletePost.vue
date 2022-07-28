<script setup lang="ts">
import type { Post } from '../../../types/models'
import MainButton from '../Buttons/MainButton.vue'
import handleError from '../../modules/handleError'
import axios from 'axios'
import { useRouter } from 'vue-router'
import { ref } from 'vue'
import showToast from '../../modules/showToast'

type Props = {
    post: Post
}

const { post } = defineProps<Props>()
const router = useRouter()
const loading = ref(false)

function deletePost(): void {
    if (!confirm(`STEP 1/3. Are you sure you want to delete post "${post.title}"`))
        return

    if (!confirm(`STEP 2/3. You will not be able to restore this post. Are you sure you want to remove it forever?`))
        return

    if (!confirm(`STEP 3/3. Last confirmation. Are you sure?`))
        return

    loading.value = true

    axios.delete(`/admin/ajax/posts/${post.id}`)
        .then(resp => {
            router.push({ name: 'posts' })
            showToast({ text: `The post "${post.title}" has been removed` })
        })
        .catch(handleError)
        .finally(() => loading.value = false)
}
</script>

<template>
    <div class="mt-7">
        <main-button
            @click="deletePost"
            class="bg-red-500 hover:bg-red-600"
            type="button"
        >
            <i class="fas fa-trash mr-2"></i>
            Delete
        </main-button>

        <label class="checkbox">
            <input
                type="checkbox"
                name="is-published"
                class="ml-3 mr-1"
                :checked="post.is_published"
            />

            <span>publish this post</span>
        </label>
    </div>
</template>
