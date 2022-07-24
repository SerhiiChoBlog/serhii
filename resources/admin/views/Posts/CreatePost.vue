<script setup lang="ts">
import { ref } from 'vue'
import axios from 'axios'
import MainButton from '../../components/Buttons/MainButton.vue'
import FormInput from '../../components/Form/FormInput.vue'
import handleError from '../../modules/handleError'

const loading = ref(false)

function createPost(): void {
    loading.value = true

    axios.post<number>('/admin/ajax/posts')
        .then(resp => {
            console.log(resp.data)
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
                >
                </form-input>

                <main-button>
                    <i
                        class="fas mr-2"
                        :class="loading ? 'fa-spinner fa-spin' : 'fa-plus'"
                    ></i>
                    <span>Create post</span>
                </main-button>
            </div>
        </form>
    </div>
</template>
