import GithubApiReposResponse from '@/interfaces/projects/GithubApiProjectsResponse'
import Project from '@/interfaces/projects/Project'
import { ref, onMounted } from 'vue'
import { getProjectsUrl } from '@/static/urls'
import remapGithubRepoIntoProject from '@/modules/remapGithubRepoIntoProject'

export default () => {
    let projects = ref<Project[]>([])
    let loading = ref(false)
    let projectsError = ref<string | null>(null)

    onMounted(() => {
        loading.value = true

        fetch(getProjectsUrl())
            .then(resp => resp.json())
            .then((resp: GithubApiReposResponse[]) => {
                if (resp && resp instanceof Array) {
                    const repos = resp.map(item => remapGithubRepoIntoProject(item))
                    projects.value = keepOnlyProjectsWithMitLicence(repos)
                } else {
                    projectsError.value = 'Sorry, but there is an error from Github'
                }
            })
            .catch(err => {
                console.error(err)
                projectsError.value = 'Sorry, but there is an error from Github'
            })
            .finally(() => loading.value = false)
    })

    return { projects, loading, projectsError }
}

function keepOnlyProjectsWithMitLicence(projects: Project[]): Project[] {
    return projects.filter(project => project.license === 'mit')
}