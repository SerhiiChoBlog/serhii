<script setup lang="ts">
import type { Section } from '../types/types'
import { onMounted, ref } from 'vue'
import PageTitle from '../components/PageTitle.vue'
import axios from 'axios'

const sections = ref<Section[]>([])

onMounted(() => fetchSections())

function fetchSections(): void {
    axios.get<Section[]>('/ajax/dashboard/sections')
        .then(resp => sections.value = resp.data)
        .catch(err => console.error(err))
}
</script>

<template>
    <div class="container">
        <page-title>Statistics</page-title>

    <nav class="flex items-center flex-col lg:flex-row justify-between max-w-[800px] mx-auto gap-9">
        <div
            v-for="section in sections"
            :key="section.title"
            class="flex flex-col justify-between"
        >
            <div class="text-font-second text-center uppercase text-sm text-font-second tracking-widest">
                {{ section.title }}
            </div>

            <div class="drop-shadow-md text-2xl text-center font-semibold text-main-dark drop-shadow-md">
                {{ section.value }}
            </div>
        </div>
    </nav>
</div>
</template>
