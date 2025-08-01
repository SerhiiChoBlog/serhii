<script setup lang="ts">
import type { Post } from '@shared/types/models'
import { ref } from 'vue'
import axios from 'axios'
import handleError from '@admin/modules/handleError'
import copy from 'copy-to-clipboard'
import showToast from '@shared/modules/showToast'
import MainButton from '@admin/components/Buttons/MainButton.vue'
import DataTable from '@admin/components/DataTable/DataTable.vue'
import BodyDetail from '@admin/components/DataTable/BodyDetail.vue'
import BodyRow from '@admin/components/DataTable/BodyRow.vue'
import HeadDetail from '@admin/components/DataTable/HeadDetail.vue'
import useExportPostImages from '@admin/composables/useExportPostImages'
import FileInput from '@admin/components/Form/FileInput.vue'

const emit = defineEmits<{
    (e: 'uploaded'): void
    (e: 'removed'): void
}>()

const { post } = defineProps<{ post: Post }>()
const { downloadImages, exportLoading } = useExportPostImages(post.id)
const loading = ref<boolean>(false)

function submitImage(e: Event): void {
    loading.value = true

    const form = e.target! as HTMLFormElement
    const formData = new FormData()
    const files = form.elements['image']!.files as FileList
    const params = { headers: { 'content-type': 'multipart/form-data' } }

    if (files.length === 0) return

    formData.append('image', files[0])

    axios
        .post<string>(`/admin/ajax/post-content-images/${post.id}`, formData, params)
        .then(resp => {
            showToast({ text: 'Image has been uploaded and copied into a buffer' })
            copy(resp.data)
            emit('uploaded')
        })
        .catch(handleError)
        .finally(() => (loading.value = false))
}

function deleteImage(id: number): void {
    if (!confirm('Sure you want to delete this content image?')) return

    loading.value = true

    axios
        .delete(`/admin/ajax/post-content-images/${id}`)
        .then(_ => {
            showToast({ text: 'Image has been removed' })
            emit('removed')
        })
        .catch(handleError)
        .finally(() => (loading.value = false))
}
</script>

<template>
    <div class="mt-6 pt-4">
        <h3 class="text-center text-2xl mb-10">Attached images for this post</h3>

        <DataTable>
            <template #head>
                <HeadDetail class="w-40">Image</HeadDetail>
                <HeadDetail>URI</HeadDetail>
                <HeadDetail class="w-40">Delete</HeadDetail>
            </template>

            <BodyRow v-if="post.images" v-for="image in post.images" :key="image.id">
                <BodyDetail>
                    <a :href="image.uri" target="_blank" rel="noreferrer">
                        <img
                            :src="image.uri"
                            alt="Post image"
                            width="100"
                            class="rounded-md shadow-sm"
                        />
                    </a>
                </BodyDetail>

                <BodyDetail>
                    <input
                        type="text"
                        :value="'https://serhii.io' + image.uri"
                        class="border border-border bg-transparent text-font rounded-md p-2 w-full"
                        disabled
                    />
                </BodyDetail>

                <BodyDetail>
                    <form @submit.prevent="deleteImage(image.id)">
                        <MainButton
                            type="submit"
                            class="bg-red-500 hover:bg-red-600"
                        >
                            <i class="fas fa-trash mr-2"></i>
                            Delete
                        </MainButton>
                    </form>
                </BodyDetail>
            </BodyRow>
        </DataTable>

        <form
            @submit.prevent="submitImage"
            enctype="multipart/form-data"
            class="mt-6 flex justify-between gap-3"
        >
            <div>
                <div class="inline-block mr-2">
                    <FileInput name="image" :required="true">
                        {{ loading ? 'Uploading image...' : 'Choose an image...' }}
                    </FileInput>
                </div>

                <MainButton class="ml-3" :disabled="loading">
                    Upload
                </MainButton>
            </div>

            <div class="space-y-3">
                <MainButton
                    @click="downloadImages"
                    class="ml-3 !bg-gray-500 hover:!bg-gray-600"
                    :disabled="exportLoading"
                >
                    <i
                        :class="
                            exportLoading
                                ? 'fa-spinner animate-spin'
                                : 'fa-arrow-down'
                        "
                        class="fas mr-2"
                    ></i>
                    Export Images
                </MainButton>

                <MainButton class="ml-3 !bg-gray-500 hover:!bg-gray-600">
                    <i
                        :class="loading ? 'fa-spinner animate-spin' : 'fa-arrow-up'"
                        class="fas mr-2"
                    ></i>
                    Import Images
                </MainButton>
            </div>
        </form>
    </div>
</template>
