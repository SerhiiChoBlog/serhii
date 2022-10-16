<script setup lang="ts">
import type { Post, Tag } from '../../../types/models'
import type { EditPostFormElements } from '@/../types'
import axios from 'axios'
import handleError from '../../modules/handleError'
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import SavePost from '../../modules/SavePost'
import PostContentImages from '../../components/Post/PostContentImages.vue'
import FormTextarea from '../../components/Form/FormTextarea.vue'
import MainButton from '../../components/Buttons/MainButton.vue'
import FormInput from '../../components/Form/FormInput.vue'
import TagItem from '../../components/TagItem.vue'
import TagSuggestions from '../../components/Post/TagSuggestions.vue'
import PostImage from '../../components/Post/PostImage.vue'
import DeletePost from '../../components/Post/DeletePost.vue'
import Editor from '@tinymce/tinymce-vue'
import { tinymceConfig } from '../../modules/tinymce'

onMounted(() => {
    fetchPost()
    document.addEventListener('keydown', savePostWithCorrectKeyBinds)
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

function savePost(form: HTMLFormElement | null): void {
    if (!post.value || !form)
        return

    loading.value = true

    const elements = form.elements as EditPostFormElements

    new SavePost(elements, post.value.id)
        .save(post.value.content || '')
        .then(handleSavePostResponse)
        .finally(() => loading.value = false)
}

function handleSavePostResponse(postSlug: string | null): void {
    if (!post.value || !postSlug) {
        return
    }

    post.value.slug = postSlug
}

function deleteTag(id: number): void {
    if (!post.value || !post.value.tags)
        return

    post.value.tags = post.value.tags.filter(tag => tag.id !== id)
}

function addTag(tag: Tag): void {
    if (!post.value || !post.value.tags)
        return

    post.value.tags.push(tag)
    tagInputValue.value = ''
}

function savePostWithCorrectKeyBinds(e: KeyboardEvent): void {
    if ((e.ctrlKey || e.metaKey) && e.code === 'KeyS') {
        e.preventDefault()
        savePost(form.value)
    }
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
                                    :value="tagInputValue"
                                >
                                    Tags

                                    <div class="ml-1 inline-block space-x-1">
                                        <template v-if="post && post.tags">
                                            <tag-item
                                                v-for="tag in post.tags"
                                                :key="tag.id"
                                                :tag="tag"
                                                @deleteTag="deleteTag"
                                            />
                                        </template>
                                    </div>
                                </form-input>

                                <tag-suggestions @addTag="addTag" :value="tagInputValue" />
                            </div>

                            <div class="flex items-center justify-between gap-8 mt-5">
                                <div class="w-full">
                                    <form-input
                                        type="text"
                                        id="video"
                                        placeholder="Enter a YouTube video ID"
                                        classes=""
                                        :value="post.video ? post.video.id : null"
                                        :length="190"
                                        name="video"
                                    >YouTube video ID</form-input>
                                </div>

                                <a v-if="post.video" :href="post.video.url" target="_blank">
                                    <img
                                        :src="post.video.image"
                                        :alt="post.video.title"
                                        width="480"
                                        height="360"
                                        class="max-w-[140px] rounded-md shadow-md"
                                    />
                                </a>
                            </div>
                        </div>

                        <div class="flex-1">
                            <post-image :post="post" />
                        </div>
                    </div>

                    <div class="mt-5">
                        <form-textarea
                            id="intro"
                            placeholder="Enter a short intro"
                            classes="min-h-[70px]"
                            :value="post.intro"
                            :length="190"
                            name="intro"
                        >Short intro</form-textarea>
                    </div>

                    <div class="mt-5">
                        <editor
                            api-key="jmzusr7d7slf7c7crr4p3uv10uxzm18be4w8njz8qxsewhdn"
                            :initialValue="post.content"
                            :init="tinymceConfig"
                            v-model="post!.content"
                            @keydown="savePostWithCorrectKeyBinds"
                        />
                    </div>

                    <div>
                        <div class="flex flex-col justify-center fixed right-[20px] top-8 z-[9999] space-y-2">
                            <main-button class="bg-green-500 hover:bg-green-600">
                                <i v-if="loading" class="fas fa-spinner animate-spin mr-2"></i>
                                <i v-else class="fas fa-save mr-2"></i>
                                Save
                            </main-button>

                            <main-button :href="`/posts/${post.slug}`" target="_blank">
                                <i class="fas fa-eye mr-2"></i>
                                Preview
                            </main-button>
                        </div>

                        <delete-post :post="post" />
                    </div>
                </form>
            </div>

            <post-content-images
                :post="post"
                @uploaded="fetchPost"
                @removed="fetchPost"
            />
        </div>
    </div>
</template>
