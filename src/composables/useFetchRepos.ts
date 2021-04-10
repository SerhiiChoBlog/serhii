import { ref, onMounted } from 'vue'

export default () => {
    const list = ref(null)
    const loading = ref(false)

    onMounted(() => {
        loading.value = true

        fetch('https://api.github.com/users/SerhiiCho/repos')
            .then(res => res.json())
            .then(res => list.value = res)
            .catch(err => console.error(err))
            .finally(() => loading.value = false)
    })

    return { list, loading }
}