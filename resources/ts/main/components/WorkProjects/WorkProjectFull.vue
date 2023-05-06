<script setup lang="ts">
import type { WorkProject } from '@shared/types'

type Props = {
    project: WorkProject
}

const { project } = defineProps<Props>()
</script>

<template>
    <div class="flex items-center justify-center gap-8">
        <img
            :src="project.image_uri"
            :alt="project.title"
            class="rounded-2xl border-2 border-border max-w-xl"
            width="800"
            height="476"
        />

        <div class="text-left">
            <div class="space-y-0.5">
                <h2 class="text-4xl">
                    {{ project.title }}
                </h2>

                <h3 class="text-font-second text-xl">
                    {{ project.subtitle }}
                </h3>

                <hr />

                <p class="text-font-second text-lg">
                    {{ project.content }}
                </p>
            </div>

            <div class="flex gap-3 mt-5">
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

            <div class="text-left">
                <a
                    v-if="project.link"
                    :href="project.link"
                    target="_blank"
                    class="border border-border px-6 py-2 rounded-lg mt-6 inline-block"
                >
                    Visit website
                </a>
            </div>
        </div>
    </div>
</template>
