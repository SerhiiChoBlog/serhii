<script setup lang="ts">
import type { Post, Tag } from '../../types/models'
import type { Pagination } from '../../types/response'
import { onMounted, ref } from 'vue'
import replaceQueryParam from '../modules/replaceQueryParam'
import NoPosts from '../components/Posts/NoPosts.vue'
import PostItem from '../components/Posts/PostItem.vue'
import axios from 'axios'
import Spinner from '../components/Spinner.vue'
import SlideUpTransition from '../components/Transitions/SlideUpTransition.vue'
import TagsFilter from '../components/Posts/Filters/TagsFilter.vue'

type Props = {
    tagSlug: string
}

const { tagSlug } = defineProps<Props>()

const posts = ref<Post[]>([])
const loading = ref(true)
const nextPageUrl = ref<string | null>(null)

onMounted(() => {
    fetchPosts('/api/posts' + window.location.search)
    window.addEventListener('scroll', () => onScroll())
})

function fetchPosts(url: string, refresh = false): void {
    loading.value = true

    axios.get<Pagination<Post[]>>(url)
        .then(resp => {
            refresh
                ? posts.value = resp.data.data
                : posts.value.push(...resp.data.data)

            nextPageUrl.value = resp.data.next_page_url
        })
        .catch(err => console.error(err))
        .finally(() => {
            loading.value = false
            onScroll()
        })
}

function filterPosts(tag: Tag): void {
    const query = replaceQueryParam('tag', tag.name)

    if (window.location.search != query) {
        const newUrl = `/posts${query}`
        window.history.replaceState(null, '', newUrl)
    }

    fetchPosts(`/api/posts${query}`, true)
}

function clearFilters(): void {
    // todo: here
}

function onScroll(): void {
    let wrap = document.querySelector('#app')! as HTMLElement
    let contentHeight = wrap.offsetHeight
    let yOffset = window.scrollY
    let currentPosition = yOffset + window.innerHeight

    if ((currentPosition >= contentHeight) && !loading.value && nextPageUrl.value) {
        fetchPosts(nextPageUrl.value)
    }
}
</script>

<template>
    <div class="container">
        <div class="bg-page max-w-[1100px] mx-auto -translate-y-6 rounded-xl px-3 pt-3">
            <div class="mb-2 flex items-center">
                <div class="w-full max-w-[360px]">
                    <tags-filter :tagSlug="tagSlug" @filterPosts="filterPosts" />
                </div>
            </div>

            <no-posts
                v-if="!loading && posts.length === 0"
                @clearFilters="clearFilters"
            />

            <div v-else>
                <div class="flex flex-col gap-y-2">
                    <slide-up-transition>
                        <post-item
                            v-for="post in posts"
                            :key="post.id"
                            :post="post"
                        />
                    </slide-up-transition>
                </div>

                <spinner v-if="loading" class="mt-10" />
            </div>
        </div>
    </div>
</template>
