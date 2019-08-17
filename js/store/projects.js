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
            commit('setProjects', [{
                id: 1,
                title: 'Nice title',
                content: 'Some content',
                imageUrl: 'https://serhii.shobar.com.ua/wp-content/uploads/2019/08/Screenshot-from-2018-10-09-00-35-48.png',
                tags: 'nice, ti, works',
                date: '2019-06-05',
                client: 'Nice client',
                siteUrl: 'http://nice.com',
                gitRepo: 'https://serhii.shobar.com.ua/wp-content/uploads/2019/08/Screenshot-from-2018-10-09-00-35-48.png',
            }])
            // Vue.$db.collection('projects').get()
            //     .then(querySnap => {
            //         let projects = []
            //         querySnap.forEach(s => {
            //             const data = s.data()
            //
            //             let project = {
            //                 id: s.id,
            //                 title: data.title,
            //                 content: data.content,
            //                 imageUrl: data.imageUrl,
            //                 tags: data.tags,
            //                 date: data.date,
            //                 client: data.client,
            //                 siteUrl: data.siteUrl,
            //                 gitRepo: data.gitRepo,
            //             }
            //             projects.push(project)
            //         })
            //         commit('setProjects', projects)
            //     })
            //     .catch(err => console.error(err))
        }
    },

    getters: {
        getProjects(state) {
            return state.projects
        }
    },
}