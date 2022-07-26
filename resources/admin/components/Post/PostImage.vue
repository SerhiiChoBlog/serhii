<script setup lang="ts">
import type { Post } from '../../../types/models'
import { ref } from 'vue'

type Props = {
    post: Post
}

const { post } = defineProps<Props>()
const defaultImagePath = '/storage/posts/placeholder.jpg'
const imageSrc = ref<string>(post.image_lg ? `/${post.image_lg}` : defaultImagePath)

function updateImagePreview(e: InputEvent): void {
    const fileReader = new FileReader()
    const src = e.target as HTMLInputElement

    if (src.files && src.files.length !== 0) {
        fileReader.readAsDataURL(src.files[0])

        fileReader.onload = function () {
            imageSrc.value = this.result as string
        }

        return
    }

    imageSrc.value = defaultImagePath
}
</script>

<template>
    <div class="relative">
        <img
            :src="imageSrc"
            alt="image"
            class="rounded-md shadow-lg w-full"
        />

        <label
            for="post-image-input"
            class="opacity-0 flex items-center hover:opacity-100 transition-opacity border-[6px] border-dashed text-center rounded-lg cursor-pointer border-gray-300 absolute right-6 top-6 left-6 bottom-6"
        >
            <b class="text-gray-600 px-4 py-2 rounded-xl bg-gray-300 text-3xl drop-shadow-sm mx-auto shadow-lg opacity-90">Choose image</b>
        </label>

        <input
            @change="updateImagePreview"
            type="file"
            id="post-image-input"
            name="image"
            class="hidden"
        />
    </div>
</template>
