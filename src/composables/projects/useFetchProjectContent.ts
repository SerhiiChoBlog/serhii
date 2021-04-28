import { useRoute } from 'vue-router'
import { ref, onMounted } from 'vue'
import showdown from 'showdown'
import { getProjectContentUrl } from '@/config'
import loadHighlightJs from '@/modules/loadHighlightJs'

export default () => {
    const { params } = useRoute()
    let content = ref('')
    let contentLoading = ref(false)
    let contentError = ref<string | null>('')

    onMounted(() => {
        contentLoading.value = true

        fetch(getProjectContentUrl(params.projectName as string))
            .then(res => res.text())
            .then(res => {
                var converter = new showdown.Converter()
                content.value = converter.makeHtml(res)
                loadHighlightJs()
            })
            .catch(err => {
                console.error(err)
                contentError.value = 'Error fetching readme content from Github 🥺'
            })
            .finally(() => contentLoading.value = false)
    })

    return { content, contentLoading, contentError }
}