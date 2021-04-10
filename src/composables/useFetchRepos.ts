import { reactive, onMounted } from 'vue'

export default () => {
    const repos = reactive({
        list: [],
        loading: false,
    })

    onMounted(() => {
        repos.loading = true

        fetch('https://api.github.com/users/SerhiiCho/repos')
            .then(res => res.json())
            .then(res => repos.list = res)
            .catch(err => console.error(err))
            .finally(() => repos.loading = false)
    })

    return { repos }
}