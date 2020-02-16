import axios from 'axios'

export default {
    state: {
        pageContent: {
            title: '',
            content: '',
        },
    },

    mutations: {
        setContent(state, payload) {
            state.pageContent = payload
        },
    },

    actions: {
        getAboutMePageContent({commit}) {
            const handleNoPageFound = () => {
                console.error("Page with title \"About me\" is not found")
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
                    let filterPagesWithAbout = res.data.filter(page => page.title.rendered === 'About me')
                    filterPagesWithAbout.length === 1 ? handlePageFound(filterPagesWithAbout) : handleNoPageFound()
                })
                .catch(err => console.error(err))
        }
    },

    getters: {
        getPageContent: state => state.pageContent
    },
}