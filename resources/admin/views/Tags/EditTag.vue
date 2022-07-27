<script setup lang="ts">
import type { Tag } from '../../../types/models'
import { useRoute, useRouter } from 'vue-router'
import { onMounted, reactive, ref } from 'vue'
import handleError from '../../modules/handleError'
import showToast from '../../modules/showToast'
import axios from 'axios'
import PageTitle from '../../components/PageTitle.vue'
import FormInput from '../../components/Form/FormInput.vue'
import FormTextarea from '../../components/Form/FormTextarea.vue'
import MainButton from '../../components/Buttons/MainButton.vue'
import Spinner from '../../components/Spinner.vue'

const loading = ref(true)
const route = useRoute()
const router = useRouter()
const form = reactive({
    title: '',
    name: '',
    color: '',
    description: '',
})

onMounted(() => fetchTag())

function fetchTag(): void {
    loading.value = true

    axios.get<Tag>(`/admin/ajax/tags/${route.params.id}/edit`)
        .then(resp => {
            const tag = resp.data

            form.title = tag.title
            form.name = tag.name
            form.color = tag.color
            form.description = tag.description
        })
        .catch(handleError)
        .finally(() => loading.value = false)
}

function updateTag(): void {
    loading.value = true

    axios.put(`/admin/ajax/tags/${route.params.id}`, form)
        .then(resp => {
            showToast({ text: `Tag "${form.name}" has been updated` })
        })
        .catch(handleError)
        .finally(() => loading.value = false)
}

function deleteTag(): void {
    if (!confirm(`Delete tag "${form.name}"?`))
        return

    loading.value = true

    axios.delete(`/admin/ajax/tags/${route.params.id}`)
        .then(resp => {
            showToast({ text: `Tag "${form.name}" has been deleted` })
            router.push({ name: 'tags' })
        })
        .catch(handleError)
        .finally(() => loading.value = false)
}
</script>


<template>
    <div class="container">
        <spinner v-if="loading" />

        <div v-else>
            <page-title>{{ form.title }}</page-title>

            <form @submit="updateTag" class="max-w-[1000px] mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <form-input
                        @changed="title => form.title = title"
                        id="title"
                        type="text"
                        :value="form.title"
                        placeholder="Enter the title"
                    >
                        Full title
                    </form-input>

                    <form-input
                        @changed="name => form.name = name"
                        id="name"
                        :value="form.name"
                        type="text"
                        placeholder="Enter the slug"
                    >
                        Short name (slug)
                    </form-input>

                    <form-input
                        @changed="color => form.color = color"
                        :value="form.color"
                        id="color"
                        type="color"
                        classes="min-h-[50px]"
                    >
                        Choose the color
                    </form-input>
                </div>

                <div class="mt-4">
                    <form-textarea
                        type="text"
                        placeholder="Enter the description"
                        :value="form.description"
                        :length="190"
                        id="description"
                        @changed="desc => form.description = desc"
                    >
                        Enter the description
                    </form-textarea>
                </div>

                <div class="mt-7 flex gap-3">
                    <main-button>
                        <i class="fas fa-save mr-2"></i>
                        Update
                    </main-button>

                    <main-button
                        type="button"
                        class="bg-green-600 hover:bg-green-700"
                        :route="{ name: 'tags' }"
                    >
                        <i class="fas fa-tag mr-2"></i>
                        Go to tags
                    </main-button>

                    <main-button
                        type="button"
                        class="bg-red-600 hover:bg-red-700"
                        @click="deleteTag"
                    >
                        <i class="fas fa-trash mr-2"></i>
                        Delete
                    </main-button>
                </div>
            </form>
        </div>
    </div>
</template>
