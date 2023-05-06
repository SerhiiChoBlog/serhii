<script setup lang="ts">
import type { WorkProject } from '@shared/types'

type Props = {
    project: WorkProject
}

const { project } = defineProps<Props>()
</script>

<template>
    <div class="flex items-center justify-center gap-10">
        <img
            :src="project.image_uri"
            :alt="project.title"
            class="rounded-lg shadow-lg"
            width="800"
            height="476"
        />

        <div>
            <h2 class="text-left text-3xl">
                {{ project.title }}
            </h2>

            <h3 class="text-left text-font-second text-xl">
                {{ project.content }}
            </h3>

            <div class="flex gap-3 justify-center mt-3">
                <img
                    v-for="tech in project.technologies"
                    :key="tech"
                    :src="`/storage/languages/${tech}.webp`"
                    :alt="tech"
                    width="80"
                    height="80"
                    class="w-8 h-8 filter"
                />
            </div>
        </div>
    </div>
</template>
