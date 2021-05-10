import { Module } from 'vuex'
import RootState from '@/store/interfaces/RootState'
import PostsState from '../interfaces/PostsState'
import Post from '@/interfaces/posts/Post'
import Posts from '@/interfaces/posts/Posts'
import { getPostsUrl, getPostUrl } from '@/config'
import loadHighlightJs from '@/modules/loadHighlightJs'

const posts: Module<PostsState, RootState> = {
    state: {
        processingPosts: false,
        postsError: null,
        posts: [],
        post: {
            title: '',
            intro: '',
            content: '',
            tags: '',
            image_url: '',
            read_time: null,
            created_at: '',
        },
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
        fetchPost({ commit }, postId: number): void {
            commit('SET_POST_PROCESSING', true)

            fetch(getPostUrl(postId))
                .then(res => res.json())
                .then((res: Post) => commit('SET_POST', res))
                .catch(err => {
                    console.error(err)
                    commit('SET_POST_ERROR', 'Sorry, but there is an error 🥺')
                })
                .finally(() => commit('SET_POST_PROCESSING', false))
        },
    },
}

export default posts