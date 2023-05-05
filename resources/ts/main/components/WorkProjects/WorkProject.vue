<script setup lang="ts">
import type { WorkProject } from '@shared/types'

type Props = {
    project: WorkProject
}

const { project } = defineProps<Props>()
</script>

<template>
    <div class="
        lg:skew-y-[-3deg] mb-12 first:ml-0 hover:translate-y-[-20px] duration-300 relative lg:transition-transform
        lg:ml-[-100px] lg:mb-0 before:left-0 before:absolute before:right-0 before:h-3 before:bg-[#282829]
        before:top-[-11px] before:rounded-t-lg
    ">
        <a :href="project" target="_blank" class="max-w-[350px] block" rel="noreferrer">
            <img
                src="/storage/tools/mac-buttons.webp"
                class="absolute top-[-8px] left-2"
                width="18"
                alt="mac buttons"
            />

            <img
                :src="project.image_uri"
                :alt="project.title"
                class="rounded-b-lg shadow-[-10px_10px_5px_rgba(0,0,0,.05)]"
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
        </a>
    </div>
</template>