import { ref } from 'vue'

const langs = ref([
    {
        imageName: 'laravel',
        title: 'Laravel',
        content: `Laravel is my primary technology. I like to use all the features of the framework along with the repository pattern and TDD. It helps to organize and structure code in very simple and readable way.`,
    },
    {
        imageName: 'vue',
        title: 'Vue',
        content: `I've been using Vue along with the VueRouter and Vuex mostly for building Single Page Applications. This site is also written with Vue 3 as an SPA with TypeScript.`,
    },
    {
        imageName: 'wordpress',
        title: 'WordPress',
        content: `As I'm working from home, I do a lot of WordPress development for a company from Netherlands. Mostly we are building plugins for syncing database, data collection and web hooks.`,
    },
])

export default langs