import { Module } from 'vuex'
import RootState from '@/store/interfaces/RootState'
import ProjectsState from '../interfaces/ProjectsState'
import Project from '@/interfaces/projects/Project'
import { getProjectsUrl } from '@/config'

const projects: Module<ProjectsState, RootState> = {
    state: {
        processingProjects: false,
        projectsError: null,
        projects: [],
        project: {
            name: '',
            title: '',
            description: '',
            url: '',
            language: '',
            stars: 0,
            created_at: '',
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

                const json = await response.json() as Project[]

                if (json && json instanceof Array) {
                    commit('SET_PROJECTS', json)
                    projects = json
                } else {
                    commit('SET_PROJECTS_ERROR', 'Sorry, but there is an error 🥺')
                }
            } catch (error) {
                console.error(error)
                commit('SET_PROJECTS_ERROR', 'Sorry, but there is an error 🥺')
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
            } else {
                const projects = await dispatch('fetchProjects') as Project[]
                const project = projects.filter(project => project.name === projectName)[0] || null

                commit('SET_PROJECT', project)
                commit('SET_PROJECT_PROCESSING', false)
            }
        },
    },
}

export default projects