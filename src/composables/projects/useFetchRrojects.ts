import Project from '@/interfaces/projects/Project'
import { computed, onMounted } from 'vue'
import { useStore } from 'vuex'

export default () => {
    const store = useStore()
    const projects = computed<Project[]>(() => store.state.projects.projects)
    const processingProjects = computed<boolean>(() => store.state.projects.processingProjects)
    const projectsError = computed<string | null>(() => store.state.projects.projectsError)

    onMounted(() => {
        if (projects.value.length === 0)
            store.dispatch('fetchProjects')
    })

    return { projects, processingProjects, projectsError }
}