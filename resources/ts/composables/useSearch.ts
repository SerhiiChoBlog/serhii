import type { Search, SearchServerResponse, SearchSuggestion } from '../types/types'
import { onMounted, reactive, ref } from 'vue'
import { debounce } from 'lodash'
import axios from 'axios'
import Cache from '../modules/Cache'
import SuggestionControls from '../modules/SuggestionControls'

export default () => {
    const input = ref<HTMLInputElement | null>(null)
    const search = reactive<Search>({
        query: '',
        posts: [],
        projects: [],
        loading: false,
        history: [],
        index: -1,
    })

    onMounted(() => {
        window.addEventListener('keyup', (e: KeyboardEvent) => {
            if (search.query === '') {
                return
            }

            new SuggestionControls(search).handle(e.key)

            if (e.key === '/') {
                e.preventDefault()
                input.value ? input.value.focus() : null
            }
        })
    })

    const makeRequestToFetchItems = debounce<(q: string) => void>(q => {
        if (q === '') {
            search.posts = []
            search.projects = []
            search.loading = false
            return
        }

        axios.get<SearchServerResponse>(`/api/search/${q}`)
            .then(resp => {
                search.posts = resp.data.posts
                search.projects = resp.data.projects
            })
            .catch(err => console.error(err))
            .finally(() => search.loading = false)
    }, 300)

    function fetchSearchSuggestions(e: KeyboardEvent): void {
        if (['ArrowDown', 'ArrowUp', 'ArrowLeft', 'ArrowRight'].includes(e.key)) {
            return
        }

        search.loading = true

        makeRequestToFetchItems(search.query)
    }

    function saveItemToHistory(title: string, url: string): void {
        Cache.add<SearchSuggestion>('search-history', { title, url, selected: false })
    }

    return {
        input,
        search,
        saveItemToHistory,
        fetchSearchSuggestions,
    }
}
