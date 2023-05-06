<script setup lang="ts">
import type { WorkProject } from '@shared/types'

type Props = {
    project: WorkProject
}

const { project } = defineProps<Props>()
</script>

<template>
    <div>
        <img
            :src="project.image_uri"
            :alt="project.title"
            class="rounded-lg border-2 border-border"
            width="350"
            height="251"
        />

        <h2 class="text-xl text-font-second text-center mt-3">
            {{ project.title }}
        </h2>
    </div>
</template>
