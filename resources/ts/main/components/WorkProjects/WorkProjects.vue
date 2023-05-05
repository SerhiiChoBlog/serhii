<script setup lang="ts">
import type { WorkProject as WorkProjectType } from '@shared/types'
import { ref, onMounted } from 'vue'
import handleServerError from '@shared/modules/handleServerError'
import axios from 'axios'
import { Carousel, Navigation, Pagination, Slide } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'
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

    <div v-else class="py-7">
        <carousel :itemsToShow="3.95" :wrapAround="true" :transition="500">
            <slide v-for="project in workProjects" :key="project.title" class="min-h-[400px]">
                <work-project :project="project" />
            </slide>

            <template #addons>
                <navigation class="!h-full [&>svg]:scale-150" />
                <pagination />
            </template>
        </carousel>
    </div>
</template>

<style>
.carousel__slide {
  padding: 5px;
}

.carousel__viewport {
  perspective: 2000px;
}

.carousel__track {
  transform-style: preserve-3d;
}

.carousel__slide--sliding {
  transition: 0.5s;
}

.carousel__slide {
  opacity: .5;
  transform: rotateY(-20deg) scale(0.9);
}

.carousel__slide--active ~ .carousel__slide {
  transform: rotateY(20deg) scale(0.9);
}

.carousel__slide--prev {
  opacity: .8;
  transform: rotateY(-10deg) scale(0.9);
}

.carousel__slide--next {
  opacity: .8;
  transform: rotateY(10deg) scale(0.9);
}

.carousel__slide--active {
  opacity: 1;
  transform: rotateY(0) scale(1.1);
}
</style>