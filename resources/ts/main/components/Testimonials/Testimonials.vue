<script setup lang="ts">
import type { Testimonial as TestimonialType } from '@shared/types'
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import handleError from '@admin/modules/handleError'
import Spinner from '@shared/components/Icons/Spinner.vue'
import Testimonial from '@/components/Testimonials/Testimonial.vue'

const loading = ref<boolean>(false)
const testimonials = ref<TestimonialType[]>([])

onMounted(() => fetchTestimonials())

function fetchTestimonials(): void {
    if (loading.value) {
        return
    }

    loading.value = true

    axios.get<TestimonialType[]>('/api/testimonials')
        .then(rep => testimonials.value = rep.data)
        .catch(handleError)
        .finally(() => loading.value = false)
}

const groupedTestimonials = computed<TestimonialType[][]>(() => {
    if (testimonials.value.length === 0) {
        return []
    }

    const total = testimonials.value.length
    const testimonialsPerRow = Math.round(total / 3)

    return [
        testimonials.value.slice(0, testimonialsPerRow),
        testimonials.value.slice(testimonialsPerRow, testimonialsPerRow * 2),
        testimonials.value.slice(testimonialsPerRow * 2, total),
    ]
})
</script>

<template>
    <spinner v-if="loading" />

    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-7">
        <div
            v-for="(groupedTestimonial, i) in groupedTestimonials"
            :key="i"
            class="space-y-4 lg:space-y-7"
        >
            <testimonial
                :testimonial="testimonial"
                v-for="testimonial in groupedTestimonial"
                :key="testimonial.name"
                :show-full="false"
            />
        </div>
    </div>
</template>