<script setup lang="ts">
import type { Post } from '../../../types/models'
import MainButton from '../../components/Buttons/MainButton.vue'

type Props = {
    post: Post
}

const { post } = defineProps<Props>()
</script>

<template>
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
                            <input
                                type="text"
                                :value="image.uri"
                                class="bg-gray-200 rounded-md p-2 w-full"
                                disabled
                            />
                        </td>

                        <td class="px-3 py-1 text-right">
                            <form
                                action="route('admin.post-content-images.delete', $image)"
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

        <form
            action="route('admin.post-content-images.store', $post)"
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
</template>
