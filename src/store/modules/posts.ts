import { Module } from 'vuex'
import RootState from '@/store/interfaces/RootState'
import PostsState from '../interfaces/PostsState'
import Post from '@/interfaces/posts/Post'
import Posts from '@/interfaces/posts/Posts'
import { getPostsUrl } from '@/config'

const posts: Module<PostsState, RootState> = {
    state: {
        processingPosts: false,
        postsError: null,
        posts: [],
        post: {
            title: '',
            content: '',
            tags: '',
            image_url: '',
            read_time: null,
            created_at: '',
        },
        processingPost: false,
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
        SET_PROJECT(state, payload: Post): void {
            state.post = payload
        },
        SET_POST_PROCESSING(state, payload: boolean): void {
            state.processingPost = payload
        },
    },

    actions: {
        async fetchPosts({ commit }): Promise<Posts> {
            commit('SET_POSTS_PROCESSING', true)

            let posts: Posts = []

            try {
                const response = await fetch(getPostsUrl())

                const json = await response.json() as Posts

                if (json && json instanceof Array) {
                    commit('SET_POSTS', json)
                    posts = json
                } else {
                    commit('SET_POSTS_ERROR', 'Sorry, but there is an error 🥺')
                }
            } catch (error) {
                console.error(error)
                commit('SET_POSTS_ERROR', 'Sorry, but there is an error 🥺')
                posts = []
            }

            commit('SET_POSTS_PROCESSING', false)

            return posts
        },
        async fetchPost({ commit, state, dispatch }, postId: number): Promise<void> {
            commit('SET_POST_PROCESSING', true)

            //
        },
    },
}

export default posts