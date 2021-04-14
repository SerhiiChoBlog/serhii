import GithubApiProjectsResponse from "@/interfaces/projects/GithubApiProjectsResponse"
import Project from "@/interfaces/projects/Project"

export default (project: GithubApiProjectsResponse): Project => {
    return {
        name: project.name,
        title: project.name.replace('-', ' '),
        htmlUrl: project.html_url,
        description: project.description,
        language: project.language,
        license: project.license ? project.license.key : null,
    }
}
