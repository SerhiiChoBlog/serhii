<script setup lang="ts">
import type { SubscriptionTagsModal } from '@/../types'
import type { Tag } from '@/../types/models'
import { computed, onMounted, ref } from 'vue'
import CheckIcon from '@/components/Icons/CheckIcon.vue'
import CloseIcon from '@/components/Icons/CloseIcon.vue'
import SubscriptionButton from '@/modules/Subscription/SubscriptionButton'
import SubscriptionCache from '@/modules/Subscription/SubscriptionCache'

type Props = {
    tags: SubscriptionTagsModal
}

const props = defineProps<Props>()
const subjects = ref<Tag[]>([])

const allTagsAreChosen = computed(() => {
    return props.tags.items.length === subjects.value.length
})

onMounted(() => {
    const cachedTags = SubscriptionCache.get()
    subjects.value = cachedTags ? cachedTags : props.tags.items
})

function selectAllSubjects(): void {
    subjects.value = props.tags.items

    SubscriptionCache.set(props.tags.items)
    SubscriptionButton.setAllTags()
}

function toggleAll(): void {
    if (allTagsAreChosen.value) {
        subjects.value = []

        SubscriptionCache.set([])
        SubscriptionButton.setNoTags()
        return
    }

    selectAllSubjects()
}

function chooseSubject(tag: Tag): void {
    if (subjectsHaveTag(tag)) {
        subjects.value = subjects.value.filter(subject => {
            return subject.id !== tag.id
        })
    } else {
        subjects.value.push(tag)
    }

    SubscriptionCache.set(subjects.value)
    SubscriptionButton.setTagsAmount(subjects.value.length)
}

function subjectsHaveTag(tag: Tag): boolean {
    return !!subjects.value.find(subject => subject.id === tag.id)
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

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <button
                type="button"
                v-for="tag in props.tags.items"
                :key="tag.id"
                class="flex items-center gap-7 border rounded-lg py-2 px-3 relative pointer outline outline-2 outline-transparent transition-all hover:outline-gray-400 dark:hover:outline-gray-600"
                :class="subjectsHaveTag(tag) ? 'border-green-500 dark:border-green-900 bg-green-50 dark:bg-page-second' : 'border-border'"
                aria-label="Subscription subject"
                @click="chooseSubject(tag)"
            >
                <check-icon
                    v-if="subjectsHaveTag(tag)"
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
            </button>
        </div>
    </div>
</template>
