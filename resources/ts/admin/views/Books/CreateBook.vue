<script setup lang="ts">
import type { CreateBookFormElements } from '@shared/types'
import axios from 'axios'
import handleError from '@admin/modules/handleError'
import { ref } from 'vue'
import MainButton from '@admin/components/Buttons/MainButton.vue'
import FormInput from '@admin/components/Form/FormInput.vue'
import FormImage from '@admin/components/FormImage.vue'
import BookAuthorSuggestions from '@admin/components/Books/BookAuthorSuggestions.vue'

const loading = ref<boolean>(false)
const form = ref<CreateBookFormElements | null>(null)

function saveBook(): void {
    if (!form.value) {
        return
    }

    loading.value = true

    const data = new FormData()

    data.append('title', form.value.title.value)
    data.append('book_author_id', form.value.book_author_id.value)

    if (form.value.image.value) {
        data.append('image', form.value.image.value)
    }

    const params = {
        headers: { 'Content-Type': 'multipart/form-data' },
    }

    axios.post(`/admin/ajax/books`, data, params)
        .catch(handleError)
        .finally(() => loading.value = false)
}
</script>

<template>
    <div class="container pb-6">
        <div>
            <h1 class="text-4xl text-font-second">
                Create a new book
            </h1>

            <div class="container">
                <form
                    ref="form"
                    @submit.prevent="saveBook"
                    enctype="multipart/form-data"
                >
                    <input type="hidden" name="book_author_id">

                    <div class="flex flex-col lg:flex-row gap-10 mt-10">
                        <div class="flex-1 space-y-7">
                            <div class="flex flex-col xl:flex-row gap-4 xl:gap-8">
                                <FormInput
                                    type="text"
                                    id="title"
                                    placeholder="Enter the title"
                                    name="title"
                                    :length="190"
                                >
                                    Title
                                </FormInput>

                                <BookAuthorSuggestions
                                    @changed=""
                                />
                            </div>

                            <div class="flex gap-3">
                                <MainButton>
                                    <i v-if="loading" class="fas fa-spinner animate-spin mr-2"></i>
                                    <i v-else class="fas fa-save mr-2"></i>
                                    Save
                                </MainButton>

                                <MainButton
                                    type="button"
                                    class="bg-red-500 hover:bg-red-600"
                                >
                                    <i class="fas fa-trash mr-2"></i>
                                    Delete
                                </MainButton>

                                <MainButton
                                    href="/admin/books"
                                    class="!bg-gray-600 hover:!bg-gray-700"
                                >
                                    <i class="fas fa-arrow-left mr-2"></i>
                                    Back
                                </MainButton>
                            </div>
                        </div>

                        <div class="w-[376px]">
                            <FormImage
                                uri="storage/books/default.jpg"
                                defaultUri="/storage/books/default.jpg"
                            />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
