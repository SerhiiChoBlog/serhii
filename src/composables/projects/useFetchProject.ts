import { useRoute } from 'vue-router'
import { ref, onMounted, Ref, computed } from 'vue'
import Project from '@/interfaces/projects/Project'
import { useStore } from 'vuex'

export default () => {
    const store = useStore()
    const { params: { projectName } } = useRoute()

    const project = computed<Project>(() => store.state.projects.project)
    const projectLoading = computed<boolean>(() => store.state.projects.processingProject)

    onMounted(() => {
        store.dispatch('fetchProject', projectName)
    })

    return { project, projectLoading }
}