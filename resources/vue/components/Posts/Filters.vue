<script setup lang="ts">
import { ref } from 'vue'
import { Listbox } from '@headlessui/vue'
import ListboxButton from '../Listbox/ListboxButton.vue'
import ListboxOptions from '../Listbox/ListboxOptions.vue'
import ListboxOption from '../Listbox/ListboxOption.vue'

const tags = [
    {id: 1, name: 'Durward Reynolds', unavailable: false},
    {id: 2, name: 'Kenton Towne', unavailable: false},
    {id: 3, name: 'Therese Wunsch', unavailable: false},
    {id: 4, name: 'Benedict Kessler', unavailable: true},
    {id: 5, name: 'Katelyn Rohan', unavailable: false},
]

const selectedTag = ref(tags[0])
</script>

<template>
    <div class="mb-2">
        <div>
            <div class="max-w-[300px]">
                <listbox v-model="selectedTag">
                    <div class="relative">
                        <listbox-button>
                            {{ selectedTag.name }}
                        </listbox-button>

                        <listbox-options>
                            <listbox-option
                                v-for="person in tags"
                                :key="person.name"
                                :value="person"
                            >
                                {{ person.name }}
                            </listbox-option>
                        </listbox-options>
                    </div>
                </listbox>
            </div>
        </div>
    </div>
</template>
