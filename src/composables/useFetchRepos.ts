import GithubApiReposResponse from '@/interfaces/openSource/GithubApiReposResponse'
import RepoItem from '@/interfaces/openSource/RepoItem'
import { ref, onMounted } from 'vue'

export default () => {
    let list = ref<RepoItem[]>([])
    let loading = ref<boolean>(false)

    onMounted(() => {
        loading.value = true

        fetch('https://api.github.com/users/SerhiiCho/repos')
            .then(res => res.json())
            .then((res: GithubApiReposResponse[]) => {
                const result: RepoItem[] = res.map(repo => {
                    return {
                        name: repo.name,
                        htmlUrl: repo.html_url,
                        description: repo.description,
                        language: repo.language,
                        stars: repo.stars,
                        license: repo.license ? repo.license.key : null,
                    }
                })

                list.value = result
            })
            .catch(err => console.error(err))
            .finally(() => loading.value = false)
    })

    return { list, loading }
}