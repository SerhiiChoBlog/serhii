import { useRoute } from 'vue-router'
import { ref, onMounted, Ref } from 'vue'
import { getProjectUrl } from '@/static/urls'
import GithubApiProjectsResponse from '@/interfaces/projects/GithubApiProjectsResponse'
import remapGithubResponseIntoProjectsArray from '@/modules/remapGithubRepoIntoProject'
import Project from '@/interfaces/projects/Project'
import { GITHUB_AUTH_TOKEN } from '@/config'

export default () => {
    const { params: { projectName } } = useRoute()

    let project = ref<Project>({
        title: '',
        name: '',
        htmlUrl: '',
        description: '',
        language: '',
        license: '',
    })

    let projectLoading = ref(false)

    onMounted(() => {
        projectLoading.value = true

        fetch(getProjectUrl(projectName as string), {
            headers: { Authorization: GITHUB_AUTH_TOKEN }
        })
            .then(resp => resp.json())
            .then((resp: GithubApiProjectsResponse) => {
                project.value = remapGithubResponseIntoProjectsArray(resp)
            })
            .catch(err => console.error(err))
            .finally(() => projectLoading.value = false)
    })

    return { project, projectLoading }
}