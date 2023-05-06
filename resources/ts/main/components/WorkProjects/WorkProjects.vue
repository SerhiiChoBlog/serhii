<script setup lang="ts">
import type { WorkProject as WorkProjectType } from '@shared/types'
import { onMounted, ref } from 'vue'
import handleServerError from '@shared/modules/handleServerError'
import axios from 'axios'
import { Carousel, Slide } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'
import WorkProject from '@/components/WorkProjects/WorkProject.vue'
import Spinner from '@shared/components/Icons/Spinner.vue'

const workProjects = ref<WorkProjectType[]>([])
const loading = ref<boolean>(false)
const currSlide = ref<number>(0)

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

    <div v-else class="py-7">
        <carousel id="gallery" :items-to-show="1" :wrap-around="false" v-model="currSlide">
              <slide v-for="project in workProjects" :key="project.title">
                  <work-project :project="project" />
              </slide>
          </carousel>

          <carousel
              id="thumbnails"
              :items-to-show="4"
              :wrap-around="true"
              v-model="currSlide"
              ref="carousel"
              class="mt-5"
          >
            <slide v-for="(project, i) in workProjects" :key="project.title" class="min-h-[300px]">
                <div
                    class="mx-2"
                    @click="currSlide = i"
                >
                    <work-project :project="project" />
                </div>
            </slide>
        </carousel>
    </div>
</template>
