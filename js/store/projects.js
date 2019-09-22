import axios from 'axios'

export default {
    state: {
        projects: [],
        processing: false,
    },

    mutations: {
        setProjects(state, payload) {
            state.projects = payload
        },

        setProcessing(state, payload) {
            state.processing = payload
        },
    },

    actions: {
        loadProjects({commit}) {
            commit('setProcessing', true)

            axios.get(`${portfolio_globals.api}posts&per_page=100`)
                .then(res => {
                    let projects = []

                    res.data.forEach(data => {
                        let project = {
                            id: data.id,
                            title: data.title.rendered,
                            content: data.content.rendered,
                            imageUrl: data.image,
                            fullImageUrl: data.fullImage,
                            tags: data.tagNames,
                            categories: data.categoryNames.map(cat => cat.cat_name),
                            date: data.date,
                            client: data.client,
                            github: data.github,
                            site: data.site,
                        }
                        projects.push(project)
                    })

                    commit('setProjects', projects)
                    commit('setProcessing', false)
                })
                .catch(err => {
                    console.error(err)
                    commit('setProcessing', false)
                })
        }
    },

    getters: {
        getProjects: state => state.projects,
        getProcessing: state => state.processing
    },
}