import GithubApiReposResponse from '@/interfaces/projects/GithubApiProjectsResponse'
import Project from '@/interfaces/projects/Project'
import { ref, onMounted } from 'vue'

export default () => {
    let list = ref<Project[]>([])
    let loading = ref(false)

    onMounted(() => {
        loading.value = true

        fetch('https://api.github.com/users/SerhiiCho/repos')
            .then(resp => resp.json())
            .then((resp: GithubApiReposResponse[]) => {
                const projects = remapGithubResponseIntoProjectsArray(resp)
                list.value = keepOnlyProjectsWithMitLicence(projects)
            })
            .catch(err => console.error(err))
            .finally(() => loading.value = false)
    })

    return { list, loading }
}

function remapGithubResponseIntoProjectsArray(response: GithubApiReposResponse[]): Project[] {
    return response.map(project => {
        return {
            name: project.name,
            title: project.name.replace('-', ' '),
            htmlUrl: project.html_url,
            description: project.description,
            language: project.language,
            stars: project.stars,
            license: project.license ? project.license.key : null,
        }
    })
}

function keepOnlyProjectsWithMitLicence(projects: Project[]): Project[] {
    return projects.filter(project => project.license === 'mit')
}