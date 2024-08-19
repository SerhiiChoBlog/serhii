<script setup lang="ts">
import type { WorkProject } from '@shared/types'
import Tip from '@shared/components/Tip.vue'

type Props = {
    project: WorkProject
}

const { project } = defineProps<Props>()
</script>

<template>
    <div
        class="flex flex-col lg:flex-row items-center justify-center gap-4 px-2 md:px-20"
    >
        <img
            :src="project.image_uri"
            :alt="project.title"
            class="rounded-2xl border-2 border-border w-full lg:max-w-[400px]"
            width="800"
            height="476"
        />

        <h3
            class="md:hidden text-center text-font-second opacity-80 uppercase text-sm"
        >
            Swipe to see more
        </h3>

        <div class="text-left">
            <div class="space-y-1">
                <h2 class="text-2xl md:text-4xl">
                    {{ project.title }}
                </h2>

                <h3 class="text-font-second text-lg md:text-xl">
                    {{ project.subtitle }}
                </h3>

                <hr class="border-border" />

                <p
                    v-html="project.content"
                    class="text-font-second text-[.9em] [&>p]:mb-3 [&>p:last-child]:mb-0"
                ></p>

                <div class="flex flex-wrap gap-4 pt-4">
                    <tip
                        v-for="tech in project.technologies"
                        :key="tech"
                        :content="tech"
                    >
                        <img
                            :src="`/storage/languages/${tech}.webp`"
                            :alt="tech"
                            width="80"
                            height="80"
                            class="w-8 h-8 filter"
                        />
                    </tip>

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
