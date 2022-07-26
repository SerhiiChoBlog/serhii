<script setup lang="ts">
import type { Post, Tag } from '../../../types/models'
import axios from 'axios'
import handleError from '../../modules/handleError'
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import { init } from '../../modules/tinymce'
import MainButton from '../../components/Buttons/MainButton.vue'
import FormInput from '../../components/Form/FormInput.vue'
import FormTextarea from '../../components/Form/FormTextarea.vue'
import TagItem from '../../components/TagItem.vue'
import { EditPostFormElements } from '../../../types/types'
import SavePost from '../../modules/SavePost'
import TagSuggestions from './TagSuggestions.vue'
import PostImage from './PostImage.vue'

onMounted(() => {
    fetchPost()
    setTimeout(() => init(), 200)
})

const route = useRoute()
const loading = ref(true)
const post = ref<Post | null>(null)
const tagInputValue = ref<string>('')
const form = ref<HTMLFormElement | null>(null)

function fetchPost(): void {
    loading.value = true

    axios.get<Post>(`/admin/ajax/posts/${route.params.id}/edit`)
        .then(resp => post.value = resp.data)
        .catch(handleError)
        .finally(() => loading.value = false)
}

function savePost(form: HTMLFormElement): void {
    if (!post.value)
        return

    loading.value = true

    const elements = form.elements as EditPostFormElements

    new SavePost(elements, post.value.id)
        .save()
        .then(postUrl => console.log(postUrl))
        .finally(() => loading.value = false)
}

function deleteTag(id: number): void {
    if (!post.value || !post.value.tags)
        return

    post.value.tags = post.value.tags.filter(tag => tag.id !== id)

    setTimeout(() => form.value ? savePost(form.value) : null, 200)
}

function addTag(tag: Tag): void {
    if (!post.value || !post.value.tags)
        return

    post.value.tags.push(tag)
    tagInputValue.value = ''

    setTimeout(() => form.value ? savePost(form.value) : null, 200)
}
</script>

<template>
    <div class="container pb-6">
        <div v-if="post">
            <h1 class="text-4xl text-font-second">{{ post.title }}</h1>

            <div class="container">
                <form
                    @submit.prevent="savePost(form)"
                    enctype="multipart/form-data"
                    ref="form"
                >
                    <div class="flex flex-col lg:flex-row gap-6 mt-10">
                        <div class="flex-1">
                            <div>
                                <form-input
                                    type="text"
                                    id="title"
                                    placeholder="Enter the title"
                                    name="title"
                                    :length="190"
                                    :value="post.title"
                                >
                                    Title
                                </form-input>
                            </div>

                            <div class="mt-5">
                                <form-input
                                    type="text"
                                    id="post-tags"
                                    name="post-tags"
                                    placeholder="Choose tags"
                                    @changed="(val: string) => tagInputValue = val"
                                >
                                    Tags

                                    <div class="ml-1 inline-block space-x-1">
                                        <tag-item
                                            v-if="post.tags"
                                            v-for="tag in post.tags"
                                            :key="tag.id"
                                            :tag="tag"
                                            @deleteTag="deleteTag"
                                        />
                                    </div>
                                </form-input>

                                <tag-suggestions @addTag="addTag" :value="tagInputValue" />
                            </div>

                            <div class="mt-5">
                                <form-textarea
                                    id="intro"
                                    placeholder="Enter a short intro"
                                    classes="min-h-[100px]"
                                    :value="post.intro"
                                    :length="190"
                                    name="intro"
                                />
                            </div>
                        </div>

                        <div class="flex-1">
                            <post-image :post="post" />
                        </div>
                    </div>

                    <div class="mt-5">
                        <textarea
                            id="content"
                            name="content"
                            aria-hidden="true"
                            class="hidden"
                        >{{ post.content }}</textarea>
                    </div>

                    <div>
                        <div class="flex flex-col justify-center fixed right-[20px] top-8 z-[9999] space-y-2">
                            <main-button class="bg-green-500 hover:bg-green-600">
                                <i v-if="loading" class="fas fa-spinner animate-spin mr-2"></i>
                                <i v-else class="fas fa-save mr-2"></i>
                                Save
                            </main-button>

                            <main-button :href="`/posts/${post.slug}`">
                                <i class="fas fa-eye mr-2"></i>
                                Preview
                            </main-button>
                        </div>

                        <div class="mt-7">
                            <main-button class="bg-red-500 hover:bg-red-600" type="button">
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
                    </div>
                </form>
            </div>

            <div class="mt-6 pt-4">
                <h3 class="text-center text-2xl mb-10">
                    Attached images for this post
                </h3>

                <div class="overflow-x-auto shadow-md rounded-lg mx-auto mt-7">
                    <table class="table-auto w-full">
                        <thead class="bg-gray-500 text-white text-left">
                        <tr>
                            <th
                                v-for="title in ['Image', 'URI', 'Delete']"
                                :key="title"
                                class="p-3 font-light"
                            >
                                {{ title }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-if="post.images"
                                v-for="image in post.images"
                                :key="image.id"
                                class="border-b odd:bg-gray-50 transition-colors hover:bg-gray-100"
                            >
                                <td class="px-3 py-1">
                                    <a :href="image.uri" target="_blank">
                                        <img
                                            :src="image.uri"
                                            alt="Post image"
                                            width="100"
                                            class="rounded-md shadow-sm"
                                        />
                                    </a>
                                </td>
                                <td class="px-3 py-1">
                                    <input type="text"
                                       :value="image.uri"
                                       class="bg-gray-200 rounded-md p-2 w-full"
                                       disabled
                                    />
                                </td>
                                <td class="px-3 py-1 text-right">
                                    <form action="route('admin.post-content-images.delete', $image)"
                                        method="post"
                                        onsubmit="return confirm('Sure you want to delete this content image?')"
                                    >

                                        <main-button class="bg-red-500 hover:bg-red-600">
                                            <i class="fas fa-trash mr-2"></i>
                                            Delete
                                        </main-button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <form action="route('admin.post-content-images.store', $post)"
                      method="post"
                      enctype="multipart/form-data"
                      class="mt-6"
                >
                    <div class="inline-block mr-2">
                        <label class="border-4 text-gray-400 hover:text-gray-500 cursor-pointer border-dashed px-5 py-3 min-w-[250px] uppercase block text-center hover:border-gray-300 transition-colors">
                            <input class="hidden" type="file" name="image" required>
                            <span>Choose an image...</span>
                        </label>
                    </div>

                    <main-button class="ml-3">
                        <i class="fas fa-upload mr-2"></i>
                        Upload
                    </main-button>
                </form>
            </div>
        </div>
    </div>
</template>
