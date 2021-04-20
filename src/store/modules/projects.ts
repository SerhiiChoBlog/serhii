import { Module } from 'vuex'
import RootState from '@/store/interfaces/RootState'
import ProjectsState from '../interfaces/ProjectsState'
import Project from '@/interfaces/projects/Project'
import { getProjectsUrl } from '@/static/urls'
import { GITHUB_AUTH_TOKEN } from '@/config'
import GithubApiReposResponse from '@/interfaces/projects/GithubApiProjectsResponse'
import remapGithubRepoIntoProject from '@/modules/projects/remapGithubRepoIntoProject'
import keepOnlyProjectsWithMitLicence from '@/modules/projects/keepOnlyProjectsWithMitLicence'

const projects: Module<ProjectsState, RootState> = {
    state: {
        processingProjects: false,
        projectsError: null,
        projects: [],
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
    },

    actions: {
        fetchProjects({ commit }): void {
            commit('SET_PROJECTS_PROCESSING', true)

            fetch(getProjectsUrl(), {
                headers: { Authorization: GITHUB_AUTH_TOKEN }
            })
                .then(resp => resp.json())
                .then((resp: GithubApiReposResponse[]) => {
                    if (resp && resp instanceof Array) {
                        const repos = resp.map(item => remapGithubRepoIntoProject(item))
                        commit('SET_PROJECTS', keepOnlyProjectsWithMitLicence(repos))
                    } else {
                        commit('SET_PROJECTS_ERROR', 'Sorry, but there is an error from Github')
                    }
                })
                .catch(err => {
                    console.error(err)
                    commit('SET_PROJECTS_ERROR', 'Sorry, but there is an error from Github')
                })
                .finally(() => commit('SET_PROJECTS_PROCESSING', false))
        },
    },
}

export default projects