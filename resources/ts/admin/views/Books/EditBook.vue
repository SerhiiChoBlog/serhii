<script setup lang="ts">
import type { Book } from '@shared/types/models'
import axios from 'axios'
import handleError from '@admin/modules/handleError'
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import MainButton from '@admin/components/Buttons/MainButton.vue'
import FormInput from '@admin/components/Form/FormInput.vue'
import FormImage from '@admin/components/FormImage.vue'

onMounted(() => fetchBook())

const route = useRoute()
const loading = ref<boolean>(true)
const book = ref<Book | null>(null)

function fetchBook(): void {
    loading.value = true

    axios.get<Book>(`/admin/ajax/books/${route.params.slug}/edit`)
        .then(resp => book.value = resp.data)
        .catch(handleError)
        .finally(() => loading.value = false)
}

function saveBook(): void {
    if (!book.value)
        return

    loading.value = true

    // todo: save here
}
</script>

<template>
    <div class="container pb-6">
        <div v-if="book">
            <h1 class="text-4xl text-font-second">{{ book.title }}</h1>

            <div class="container">
                <form
                    @submit.prevent="saveBook"
                    enctype="multipart/form-data"
                >
                    <input type="hidden" name="tag_id">

                    <div class="flex flex-col lg:flex-row gap-10 mt-10">
                        <div class="flex-1">
                            <div>
                                <FormInput
                                    type="text"
                                    id="title"
                                    placeholder="Enter the title"
                                    name="title"
                                    :length="190"
                                    :value="book.title"
                                >
                                    Title
                                </FormInput>
                            </div>
                        </div>

                        <FormImage
                            :uri="`storage/books/${book.image}`"
                            defaultUri="/storage/books/default.jpg"
                        />
                    </div>

                    <div>
                        <div class="flex gap-2 fixed right-[20px] top-14 z-[9999] opacity-90">
                            <MainButton class="bg-green-500 hover:bg-green-600">
                                <i v-if="loading" class="fas fa-spinner animate-spin mr-2"></i>
                                <i v-else class="fas fa-save mr-2"></i>
                                Save
                            </MainButton>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
