import Project from '@/interfaces/projects/Project'

export default (projects: Project[]): Project[] => {
    return projects.filter(project => project.license === 'mit')
}