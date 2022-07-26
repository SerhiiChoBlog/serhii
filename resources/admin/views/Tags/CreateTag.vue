<script setup lang="ts">
import { reactive, ref } from 'vue'
import handleError from '../../modules/handleError'
import showToast from '../../modules/showToast'
import axios from 'axios'
import PageTitle from '../../components/PageTitle.vue'
import FormInput from '../../components/Form/FormInput.vue'
import FormTextarea from '../../components/Form/FormTextarea.vue'
import MainButton from '../../components/Buttons/MainButton.vue'
import Spinner from '../../components/Spinner.vue'
import { useRouter } from 'vue-router'

const loading = ref(false)
const router = useRouter()
const form = reactive({
    title: '',
    name: '',
    color: '',
    description: '',
})

function createTag(): void {
    loading.value = true

    axios.post('/admin/ajax/tags', form)
        .then(resp => {
            showToast({ text: `Tag "${form.name}" has been created` })
            router.push({ name: 'tags' })
        })
        .catch(handleError)
        .finally(() => loading.value = false)
}
</script>

<template>
    <div class="container">
        <page-title>Create a new tag</page-title>

        <spinner v-if="loading" />

        <form v-else @submit="createTag" class="max-w-[1000px] mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                <form-input
                    @changed="title => form.title = title"
                    id="title"
                    type="text"
                    placeholder="Enter the title"
                >
                    Full title
                </form-input>

                <form-input
                    @changed="name => form.name = name"
                    id="name"
                    type="text"
                    placeholder="Enter the slug"
                >
                    Short name (slug)
                </form-input>

                <form-input
                    @changed="color => form.color = color"
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
                    :length="190"
                    id="description"
                    @changed="desc => form.description = desc"
                >
                    Enter the description
                </form-textarea>
            </div>

            <div class="mt-7">
                <main-button>
                    <i class="fas fa-plus mr-2"></i>
                    Create tag
                </main-button>
            </div>
        </form>
    </div>
</template>
