<script setup lang="ts">
import type { Testimonial } from '@shared/types'
import { ref, onMounted } from 'vue'
import Spinner from '@shared/components/Icons/Spinner.vue'

const loading = ref<boolean>(false)
const testimonials = ref<Testimonial[]>([])

onMounted(() => fetchTestimonials())

function fetchTestimonials(): void {
    if (loading.value) {
        return
    }

    loading.value = true
}
</script>

<template>
    <spinner v-if="loading" />

    <div v-else>
        <div v-for="item in testimonials" :key="item.name">
            <h3>{{ item.name }}</h3>
            <p>{{ item.content }}</p>
        </div>
    </div>
</template>