<script setup lang="ts">
import type { WorkProject as WorkProjectType } from '@shared/types'
import { ref, onMounted } from 'vue'
import handleServerError from '@shared/modules/handleServerError'
import axios from 'axios'
import WorkProject from '@/components/WorkProjects/WorkProject.vue'
import Spinner from '@shared/components/Icons/Spinner.vue'

const workProjects = ref<WorkProjectType[]>([])
const loading = ref<boolean>(false)

onMounted(() => fetchWorkProjects())

function fetchWorkProjects(): void {
    if (loading.value) {
        return
    }

    loading.value = true

    axios.get<WorkProjectType[]>('/api/about-me/work-projects')
        .then(resp => workProjects.value = resp.data)
        .catch(handleServerError)
        .finally(() => loading.value = false)

}
</script>

<template>
    <spinner v-if="loading" />

    <div v-else class="flex flex-col lg:flex-row items-center justify-center py-7">
        <work-project
            v-for="project in workProjects"
            :key="project.title"
            :project="project"
        />
    </div>
</template>