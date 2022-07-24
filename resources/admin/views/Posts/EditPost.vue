<script setup lang="ts">
import type { Post } from '../../../types/models'
import axios from 'axios'
import handleError from '../../modules/handleError'
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import MainButton from '../../components/Buttons/MainButton.vue'
import FormInput from '../../components/Form/FormInput.vue'
import Spinner from '../../components/Spinner.vue'
import { init } from '../../modules/tinymce'

onMounted(() => {
    fetchPost()

    setTimeout(() => {
        init()
    }, 200)
})

const route = useRoute()
const loading = ref(true)
const post = ref<Post | null>(null)

function fetchPost(): void {
    loading.value = true

    axios.get<Post>(`/admin/ajax/posts/${route.params.id}/edit`)
        .then(resp => post.value = resp.data)
        .catch(handleError)
        .finally(() => loading.value = false)
}

function savePost(): void {
    //
}
</script>

<template>
    <div class="container pb-6">
        <div v-if="post">
            <h1 class="text-4xl text-font-second">{{ post.title }}</h1>

            <div class="container">
                <form
                    @submit.prevent="savePost"
                    enctype="multipart/form-data"
                >
                    <div class="flex flex-col lg:flex-row gap-6 mt-10">
                        <div class="flex-1">
                            <div>
                                <form-input
                                    type="text"
                                    id="title"
                                    placeholder="Enter the title"
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
                                    placeholder="Choose tags"
                                    :length="190"
                                >
                                    Tags
                                    <div class="ml-1 inline-block space-x-1"></div>
                                </form-input>

                                <ul class="bg-white shadow-md mt-2 rounded-lg overflow-hidden hidden"></ul>
                            </div>

                            <!--                        <div class="mt-5">-->
                            <!--                            <x-admin.input-->
                            <!--                                :textarea="true"-->
                            <!--                                placeholder="Enter a short intro"-->
                            <!--                                name="intro"-->
                            <!--                                class="_letter-counter min-h-[100px]"-->
                            <!--                                :value="$post->intro"-->
                            <!--                                maxlength="190"-->
                            <!--                            >-->
                            <!--                            </x-admin.input>-->
                            <!--                        </div>-->
                        </div>

                        <div class="flex-1">
                            <div class="relative">
                                <img
                                    :src="`/${post.image_sm || 'storage/posts/placeholder.jpg'}`"
                                    alt="image"
                                    id="post-image"
                                    class="rounded-md shadow-lg w-full"
                                />

                                <label
                                    for="post-image-input"
                                    class="opacity-0 flex items-center hover:opacity-100 transition-opacity border-[6px] border-dashed text-center rounded-lg cursor-pointer border-gray-300 absolute right-6 top-6 left-6 bottom-6"
                                >
                                    <b class="text-gray-600 px-4 py-2 rounded-xl bg-gray-300 text-3xl drop-shadow-sm mx-auto shadow-lg opacity-90">Choose image</b>
                                </label>

                                <input type="file" id="post-image-input" name="image" class="hidden">
                            </div>
                        </div>
                    </div>

                    <div class="mt-5">
                        <textarea id="content" name="content" aria-hidden="true">{{ post.content }}</textarea>
                    </div>

                    <div>
                        <div class="flex flex-col justify-center fixed right-[20px] top-[70px] z-[9999] space-y-2">
                            <main-button class="bg-green-500 hover:bg-green-600">
                                <i class="fas fa-save mr-2"></i>
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

                        <!--                        @foreach ($post->images as $image)-->
                        <!--                        <tr class="border-b odd:bg-gray-50 transition-colors hover:bg-gray-100">-->
                        <!--                            <td class="px-3 py-1">-->
                        <!--                                <a href="{{ $image->uri }}" target="_blank">-->
                        <!--                                    <img data-src="{{ asset($image->uri) }}"-->
                        <!--                                         alt="Post image"-->
                        <!--                                         width="100"-->
                        <!--                                         class="rounded-md shadow-sm"-->
                        <!--                                    />-->
                        <!--                                </a>-->
                        <!--                            </td>-->
                        <!--                            <td class="px-3 py-1">-->
                        <!--                                <input type="text"-->
                        <!--                                   value="{{ $image->uri }}"-->
                        <!--                                   class="bg-gray-200 rounded-md p-2 w-full"-->
                        <!--                                   disabled-->
                        <!--                                />-->
                        <!--                            </td>-->
                        <!--                            <td class="px-3 py-1 text-right">-->
                        <!--                                <form action="route('admin.post-content-images.delete', $image)"-->
                        <!--                                    method="post"-->
                        <!--                                    onsubmit="return confirm('Sure you want to delete this content image?')"-->
                        <!--                                >-->

                        <!--                                    <main-button class="bg-red-500 hover:bg-red-600">-->
                        <!--                                        <i class="fas fa-trash mr-2"></i> Delete-->
                        <!--                                    </main-button>-->
                        <!--                                </form>-->
                        <!--                            </td>-->
                        <!--                        </tr>-->
                        <!--                        @endforeach-->

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

        <spinner v-else />
    </div>
</template>
