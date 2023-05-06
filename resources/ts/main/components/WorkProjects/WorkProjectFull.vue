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
            class="rounded-2xl border-2 border-border max-w-lg mt-2"
            width="800"
            height="476"
        />

        <div class="text-left">
            <div class="space-y-1">
                <h2 class="text-4xl">
                    {{ project.title }}
                </h2>

                <h3 class="text-font-second text-xl">
                    {{ project.subtitle }}
                </h3>

                <hr class="border-border" />

                <p v-html="project.content" class="text-font-second text-[.9em] [&>p]:mb-3 [&>p:last-child]:mb-0"></p>

                <div class="flex gap-5 pt-4">
                    <img
                        v-for="tech in project.technologies"
                        :key="tech"
                        :src="`/storage/languages/${tech}.webp`"
                        :alt="tech"
                        width="80"
                        height="80"
                        class="w-8 h-8 filter"
                    />

                    <a
                        v-if="project.link"
                        :href="project.link"
                        target="_blank"
                        class="border border-border px-3 py-0.5 rounded-lg inline-block text-[.8em]"
                    >
                        Visit Website
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>
