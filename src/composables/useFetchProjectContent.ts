import { useRoute } from 'vue-router'
import { ref, onMounted } from 'vue'
import showdown from 'showdown'
import { getProjectContentUrl } from '@/static/urls'

export default () => {
    const { params } = useRoute()
    let content = ref('')
    let loading = ref(false)

    onMounted(() => {
        loading.value = true

        fetch(getProjectContentUrl(params.projectName as string))
            .then(res => res.text())
            .then(res => {
                var converter = new showdown.Converter()
                content.value = converter.makeHtml(res)
            })
            .catch(err => console.error(err))
            .finally(() => loading.value = false)
    })

    return { content, loading }
}