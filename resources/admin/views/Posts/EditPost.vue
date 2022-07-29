<script setup lang="ts">
import type { Post, Tag } from '../../../types/models'
import type { EditPostFormElements } from '../../../types/types'
import axios from 'axios'
import handleError from '../../modules/handleError'
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import { init } from '../../modules/tinymce'
import SavePost from '../../modules/SavePost'
import PostContentImages from '../../components/Post/PostContentImages.vue'
import FormTextarea from '../../components/Form/FormTextarea.vue'
import MainButton from '../../components/Buttons/MainButton.vue'
import FormInput from '../../components/Form/FormInput.vue'
import TagItem from '../../components/TagItem.vue'
import TagSuggestions from '../../components/Post/TagSuggestions.vue'
import PostImage from '../../components/Post/PostImage.vue'
import DeletePost from '../../components/Post/DeletePost.vue'

onMounted(() => {
    fetchPost()
    setTimeout(() => init(), 500)
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
        .save()
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
