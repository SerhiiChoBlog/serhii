<script setup lang="ts">
import { ref } from 'vue'
import axios from 'axios'
import MainButton from '@admin/components/Buttons/MainButton.vue'
import FormInput from '@admin/components/Form/FormInput.vue'
import handleError from '@admin/modules/handleError'
import { useRouter } from 'vue-router'

const loading = ref(false)
const router = useRouter()
const title = ref<string>('')

function createPost(): void {
    loading.value = true

    axios.post<number>('/admin/ajax/posts', {
        title: title.value,
    })
        .then(resp => {
            router.push({
                name: 'posts-edit',
                params: { id: resp.data },
            })
        })
        .catch(handleError)
        .finally(() => loading.value = false)
}
</script>

<template>
    <div class="container">
        <h1 class="text-3xl font-bold text-font-second">Basic information</h1>
        <h2 class="text-xl">Enter title for the future blog post.</h2>

        <form @submit.prevent="createPost" class="mt-5">
            <div class="grid grid-cols-1 lg:grid-cols-[3fr_1fr] gap-5 max-w-3xl">
                <form-input
                    type="text"
                    placeholder="Enter the title"
                    :length="190"
                    id="title"
                    @changed="(value: string) => (title = value)"
                >
                </form-input>

                <main-button>
                    <i
                        class="fas mr-2"
                        :class="loading ? 'fa-spinner animate-spin' : 'fa-plus'"
                    ></i>
                    <span>Create post</span>
                </main-button>
            </div>
        </form>
    </div>
</template>
