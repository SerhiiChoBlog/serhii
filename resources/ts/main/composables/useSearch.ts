import type { Search, SearchSuggestion } from '@shared/types'
import { onMounted, reactive, ref } from 'vue'
import { debounce } from 'lodash'
import axios from 'axios'
import SuggestionControls from '@/modules/SuggestionControls'

export default () => {
    const input = ref<HTMLInputElement | null>(null)
    const search = reactive<Search>({
        query: '',
        posts: [],
        loading: false,
        suggestionsIndex: -1,
    })

    onMounted(() => {
        window.addEventListener('keydown', (e: KeyboardEvent) => {
            if (e.key === 'Escape') {
                search.posts = []
                search.query = ''
            }
        })

        window.addEventListener('keyup', (e: KeyboardEvent) => {
            if (search.query !== '') {
                new SuggestionControls(search).handle(e.key)
            }
        })
    })

    const makeRequestToFetchItems = debounce<(q: string) => void>(q => {
        if (q === '') {
            search.posts = []
            search.loading = false
            return
        }

        axios
            .get<SearchSuggestion[]>(`/api/search/${q}`)
            .then(resp => {
                const posts = resp.data

                if (posts[0]) {
                    posts[0].selected = true
                }

                search.posts = posts
                search.suggestionsIndex = 0
            })
            .catch(err => console.error(err))
            .finally(() => (search.loading = false))
    }, 100)

    function fetchSearchSuggestions(e: KeyboardEvent): void {
        if (['ArrowDown', 'ArrowUp'].includes(e.key)) {
            return
        }

        search.loading = true
        search.query = search.query.trimStart()

        makeRequestToFetchItems(search.query)
    }

    function changedInput(e: Event): void {
        search.query = (e.target as HTMLInputElement).value
        fetchSearchSuggestions(e as KeyboardEvent)
    }

    return {
        input,
        search,
        changedInput,
    }
}
