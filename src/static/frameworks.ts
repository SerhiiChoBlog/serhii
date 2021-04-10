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
        content: `I've been using Vue.js along with the VueRouter and Vuex mostly for building Single Page Applications.`,
    },
    {
        imageName: 'wordpress',
        title: 'WordPress',
        content: `As I'm working from home, I do a lot of WordPress development.`,
    },
])

export default langs