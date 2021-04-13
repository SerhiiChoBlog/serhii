import { useRoute } from 'vue-router'
import { ref, onMounted } from 'vue'
import { getProjectUrl } from '@/static/urls'

export default () => {
    const { params } = useRoute()
    let project = ref('')
    let projectLoading = ref(false)

    onMounted(() => {
        projectLoading.value = true

        fetch(getProjectUrl(params.projectName as string))
            .then(res => res.json())
            .then(res => {
                project.value = res
            })
            .catch(err => console.error(err))
            .finally(() => projectLoading.value = false)
    })

    return { project, projectLoading }
}