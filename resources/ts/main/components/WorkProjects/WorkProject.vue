<script setup lang="ts">
import type { WorkProject } from '@shared/types'

type Props = {
    project: WorkProject
}

const { project } = defineProps<Props>()
</script>

<template>
    <div>
        <div class="relative">
            <div class="absolute top-1 left-1/2 -translate-x-1/2 w-8 h-[6px] bg-gray-300 group-only:bg-gray-600 rounded-b-[2px]"></div>

            <img
                :src="project.image_uri"
                :alt="project.title"
                class="rounded-lg border-[5px] border-gray-300 group-only:border-gray-600"
                width="350"
                height="251"
            />
        </div>

        <div class="text-center">
            <div class="w-5 h-4 bg-gray-300 group-only:bg-gray-600 mx-auto"></div>
            <div class="w-20 h-1 bg-gray-300 group-only:bg-gray-600 mx-auto"></div>
        </div>

        <h2 class="text-xl text-font-second text-center mt-2">
            {{ project.title }}
        </h2>
    </div>
</template>
