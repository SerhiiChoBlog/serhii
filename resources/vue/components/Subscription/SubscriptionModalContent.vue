<script setup lang="ts">
import type { SubscriptionTagsModal } from '@/../types'
import type { Tag } from '@/../types/models'
import Spinner from '@/components/Spinner.vue'
import { computed, ref, watch } from 'vue'
import CheckIcon from '@/components/Icons/CheckIcon.vue'
import CloseIcon from '@/components/Icons/CloseIcon.vue'

type Props = {
    tags: SubscriptionTagsModal
}

const props = defineProps<Props>()
const subjects = ref<number[]>(props.tags.items.map(tag => tag.id))

watch(props, (props: Props) => {
    if (subjects.value.length === 0) {
        selectAllSubjects()
    }
})

const allTagsAreChosen = computed(() => {
    return props.tags.items.length === subjects.value.length
})

function selectAllSubjects(): void {
    subjects.value = props.tags.items.map(tag => tag.id)
}

function toggleAll(): void {
    if (allTagsAreChosen.value) {
        subjects.value = []
        return
    }

    selectAllSubjects()
}

function chooseSubject(tag: Tag): void {
    if (!subjects.value.includes(tag.id)) {
        subjects.value.push(tag.id)
        return
    }

    const index = subjects.value.indexOf(tag.id)

    subjects.value.splice(index, 1)
}
</script>

<template>
    <div>
        <div class="mb-5 text-center">
            <h2 class="text-2xl">Choose subjects to subscribe</h2>
            <p class="text-xl">
                Subjects chosen:
                <b class="text-green-700 font-sans">
                    {{ allTagsAreChosen ? 'everything' : `${subjects.length} out of ${props.tags.items.length}` }}
                </b>
            </p>

            <button
                type="button"
                class="px-7 py-0.5 border border-gray-400 rounded-full mt-3"
                @click="toggleAll"
            >
                <span class="flex items-center gap-2">
                    <template v-if="allTagsAreChosen" >
                        <close-icon class="w-5 h-5 text-red-800" />
                        Remove all
                    </template>
                    <template v-else>
                        <check-icon class="w-5 h-5 text-green-700" />
                        Select all
                    </template>
                </span>
            </button>
        </div>

        <spinner v-if="props.tags.loading" />

        <ul v-else class="grid grid-cols-1 lg:grid-cols-2 gap-3">
            <li
                v-for="tag in props.tags.items"
                :key="tag.id"
                class="flex items-center gap-7 border rounded-lg py-2 px-3 relative"
                :class="subjects.includes(tag.id) ? 'border-green-500 bg-green-50' : 'border-border'"
                aria-label="Subscription subject"
                @click="chooseSubject(tag)"
            >
                <check-icon
                    v-if="subjects.includes(tag.id)"
                    class="w-6 h-6 absolute top-1 right-1 text-green-700"
                />

                <img
                    :src="`/storage/tags/${tag.name}.webp`"
                    :alt="`The logo of ${tag.name}`"
                    width="200"
                    height="200"
                    class="w-[50px] rounded-md drop-shadow-md"
                />

                <div>
                    <h3 class="font-semibold font-sans text-lg">{{ tag.title }}</h3>
                    <p class="text-font-second text-md">{{ tag.description }}</p>
                </div>
            </li>
        </ul>
    </div>
</template>
