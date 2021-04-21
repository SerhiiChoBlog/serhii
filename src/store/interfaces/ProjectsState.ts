import Project from '@/interfaces/projects/Project'

export default interface ProjectsState {
    processingProjects: boolean
    projectsError: string | null
    projects: Project[]
    project: Project
    processingProject: boolean
}