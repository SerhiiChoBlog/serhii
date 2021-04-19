import GithubApiReposResponse from '@/interfaces/projects/GithubApiProjectsResponse'
import Project from '@/interfaces/projects/Project'
import { ref, onMounted } from 'vue'
import { getProjectsUrl } from '@/static/urls'
import remapGithubRepoIntoProject from '@/modules/remapGithubRepoIntoProject'

export default () => {
    let list = ref<Project[]>([])
    let loading = ref(false)

    onMounted(() => {
        loading.value = true

        fetch(getProjectsUrl())
            .then(resp => resp.json())
            .then((resp: GithubApiReposResponse[]) => {
                if (resp) {
                    const projects = resp.map(item => remapGithubRepoIntoProject(item))
                    list.value = keepOnlyProjectsWithMitLicence(projects)
                }
            })
            .catch(err => console.error(err))
            .finally(() => loading.value = false)
    })

    return { list, loading }
}

function keepOnlyProjectsWithMitLicence(projects: Project[]): Project[] {
    return projects.filter(project => project.license === 'mit')
}