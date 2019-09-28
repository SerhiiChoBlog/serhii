import axios from 'axios'

export default {
    state: {
        isVisible: false,
        pageContent: {
            title: '',
            content: '',
        },
    },

    mutations: {
        setVisibility(state, payload) {
            state.isVisible = payload
        },
        setContent(state, payload) {
            state.pageContent = payload
        },
    },

    actions: {
        showAboutMeModal({commit}) {
            commit('setVisibility', true)
        },

        hideAboutMeModal({commit}) {
            commit('setVisibility', false)
        },

        getAboutMePageContent({commit}) {
            const handleNoPageFound = () => {
                console.error("Page with title About is not found")
                commit('setContent', {title: 'Sorry. The page is not found', content: ''})
            }

            const handlePageFound = result => {
                commit('setContent', {
                    title: result[0].title.rendered,
                    content: result[0].content.rendered,
                })
            }

            axios.get(`${portfolio_globals.api}pages`)
                .then(res => {
                    let filterPagesWithAbout = res.data.filter(page => page.title.rendered == 'About')
                    filterPagesWithAbout.length === 1 ? handlePageFound(filterPagesWithAbout) : handleNoPageFound()
                })
                .catch(err => console.error(err))
        }
    },

    getters: {
        isVisibleModal: state => state.isVisible,
        getPageContent: state => state.pageContent,
    },
}