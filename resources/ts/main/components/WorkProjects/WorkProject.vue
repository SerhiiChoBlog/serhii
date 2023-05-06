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
            class="rounded-lg shadow-[0_0_10px_rgba(0,0,0,.2)]"
            width="350"
            height="251"
        />

        <div>
            <h2 class="block text-font-second text-xl text-center mt-3 font-light">
                {{ project.title }}
            </h2>

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
