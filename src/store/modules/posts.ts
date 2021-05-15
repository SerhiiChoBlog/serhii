import { Module } from 'vuex'
import RootState from '@/store/interfaces/RootState'
import PostsState from '../interfaces/PostsState'
import Post from '@/interfaces/posts/Post'
import Posts from '@/interfaces/posts/Posts'
import { getPostsUrl, getPostUrl } from '@/config'
import loadHighlightJs from '@/modules/loadHighlightJs'

const emptyPost: Post = {
    title: '',
    intro: '',
    slug: '',
    content: '',
    tags: [],
    image_lg: '',
    created_at: '',
    pretty_created_at: '',
}

const posts: Module<PostsState, RootState> = {
    state: {
        processingPosts: false,
        postsError: null,
        posts: [],
        post: emptyPost,
        processingPost: false,
        postError: null,
    },

    mutations: {
        SET_POSTS_PROCESSING(state, payload: boolean): void {
            state.processingPosts = payload
        },
        SET_POSTS_ERROR(state, payload: string): void {
            state.postsError = payload
        },
        SET_POSTS(state, payload: Posts): void {
            state.posts = payload
        },
        SET_POST(state, payload: Post): void {
            state.post = payload
            loadHighlightJs()
        },
        SET_POST_ERROR(state, payload: string): void {
            state.postError = payload
        },
        SET_POST_PROCESSING(state, payload: boolean): void {
            state.processingPost = payload
        },
    },

    actions: {
        fetchPosts({ commit }): void {
            commit('SET_POSTS_PROCESSING', true)

            fetch(getPostsUrl())
                .then(res => res.json())
                .then(res => {
                    res && res instanceof Array
                        ? commit('SET_POSTS', res)
                        : commit('SET_POSTS_ERROR', 'Sorry, but there is an error 🥺')
                })
                .catch(err => {
                    console.error(err)
                    commit('SET_POSTS_ERROR', 'Sorry, but there is an error 🥺')
                })
                .finally(() => commit('SET_POSTS_PROCESSING', false))
        },
        fetchPost({ commit }, slug: string): void {
            commit('SET_POST_PROCESSING', true)

            fetch(getPostUrl(slug))
                .then(res => res.json())
                .then((res: Post) => commit('SET_POST', res))
                .catch(err => {
                    console.error(err)
                    commit('SET_POST_ERROR', 'Sorry, but there is an error 🥺')
                })
                .finally(() => commit('SET_POST_PROCESSING', false))
        },
        resetPost({ commit }): void {
            commit('SET_POSTS_ERROR', null)
            commit('SET_POST', emptyPost)
        },
    },
}

export default posts