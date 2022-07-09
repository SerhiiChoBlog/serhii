import type { Search, SearchServerResponse, SearchSuggestion } from '../types/types'
import { reactive } from 'vue'
import { debounce } from 'lodash'
import axios from 'axios'
import Cache from '../modules/Cache'

export default () => {
    const search = reactive<Search>({
        query: '',
        posts: [],
        projects: [],
        loading: false,
        history: [],
    })

    const makeRequestToFetchItems = debounce<(q: string) => void>(q => {
        if (q === '') {
            search.posts = []
            search.projects = []
            return
        }

        axios.get<SearchServerResponse>(`/api/search/${q}`)
            .then(resp => {
                search.posts = resp.data.posts
                search.projects = resp.data.projects
            })
            .catch(err => console.error(err))
    }, 300)

    function fetchSearchSuggestions(e: KeyboardEvent): void {
        if (['ArrowDown', 'ArrowUp', 'ArrowLeft', 'ArrowRight'].includes(e.key)) {
            return
        }

        makeRequestToFetchItems(search.query)
    }

    function saveItemToHistory(title: string, url: string): void {
        Cache.add<SearchSuggestion>('search-history', { title, url, selected: false })
    }

    return {
        search,
        saveItemToHistory,
        fetchSearchSuggestions,
    }
}
