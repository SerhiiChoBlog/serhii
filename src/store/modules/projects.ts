import { Module } from 'vuex'
import RootState from '@/store/interfaces/RootState'
import ProjectsState from '../interfaces/ProjectsState'
import Project from '@/interfaces/projects/Project'
import { getProjectsUrl } from '@/config'
import { GITHUB_AUTH_TOKEN } from '@/config'
import GithubApiReposResponse from '@/interfaces/projects/GithubApiProjectsResponse'
import remapGithubRepoIntoProject from '@/modules/projects/remapGithubRepoIntoProject'
import keepOnlyProjectsWithMitLicence from '@/modules/projects/keepOnlyProjectsWithMitLicence'

const projects: Module<ProjectsState, RootState> = {
    state: {
        processingProjects: false,
        projectsError: null,
        projects: [],
        project: {
            title: '',
            name: '',
            htmlUrl: '',
            description: '',
            language: '',
            license: '',
        },
        processingProject: false,
    },

    mutations: {
        SET_PROJECTS_PROCESSING(state, payload: boolean): void {
            state.processingProjects = payload
        },
        SET_PROJECTS_ERROR(state, payload: string): void {
            state.projectsError = payload
        },
        SET_PROJECTS(state, payload: Project[]): void {
            state.projects = payload
        },
        SET_PROJECT(state, payload: Project): void {
            state.project = payload
        },
        SET_PROJECT_PROCESSING(state, payload: boolean): void {
            state.processingProject = payload
        },
    },

    actions: {
        async fetchProjects({ commit }): Promise<Project[]> {
            commit('SET_PROJECTS_PROCESSING', true)

            let projects: Project[] = []

            try {
                const response = await fetch(getProjectsUrl())

                const json = await response.json() as GithubApiReposResponse[]

                if (json && json instanceof Array) {
                    const repos = json.map(item => remapGithubRepoIntoProject(item))
                    projects = keepOnlyProjectsWithMitLicence(repos)

                    commit('SET_PROJECTS', projects)
                } else {
                    commit('SET_PROJECTS_ERROR', 'Sorry, but there is an error from Github')
                }
            } catch (error) {
                console.error(error)
                commit('SET_PROJECTS_ERROR', 'Sorry, but there is an error from Github')
                projects = []
            }

            commit('SET_PROJECTS_PROCESSING', false)

            return projects
        },
        async fetchProject({ commit, state, dispatch }, projectName: string): Promise<void> {
            commit('SET_PROJECT_PROCESSING', true)

            let neededProject = state.projects.filter(project => project.name === projectName)[0] || null

            if (neededProject) {
                commit('SET_PROJECT', neededProject)
                commit('SET_PROJECT_PROCESSING', false)
                return
            }

            const projects = await dispatch('fetchProjects') as Project[]
            neededProject = projects.filter(project => project.name === projectName)[0] || null

            commit('SET_PROJECT', neededProject)
            commit('SET_PROJECT_PROCESSING', false)
        },
    },
}

export default projects