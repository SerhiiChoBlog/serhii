import axios from 'axios'

export default {
    state: {
        projects: []
    },

    mutations: {
        setProjects(state, payload) {
            state.projects = payload
        },
    },

    actions: {
        loadProjects({commit}) {
            axios.get(`${portfolio_globals.api}posts`)
                .then(res => {
                    let projects = []

                    res.data.forEach(data => {
                        let project = {
                            id: data.id,
                            title: data.title.rendered,
                            content: data.content.rendered,
                            imageUrl: data.image,
                            tags: data.tags,
                            date: data.date,
                        }
                        projects.push(project)
                    })

                    commit('setProjects', projects)
                })
                .catch(err => console.error(err))
        }
    },

    getters: {
        getProjects(state) {
            return state.projects
        }
    },
}