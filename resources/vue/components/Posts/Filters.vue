<script setup lang="ts">
import { ref } from 'vue'
import { Listbox, ListboxButton, ListboxOption, ListboxOptions, } from '@headlessui/vue'
import SelectorIcon from '../Icons/SelectorIcon.vue'

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
    <div class="mb-3">
        <div>
            <div class="max-w-[300px]">
                <listbox v-model="selectedTag">
                    <div class="relative">
                        <listbox-button
                            class="relative w-full cursor-default rounded-lg bg-white py-2 pl-3 pr-10 text-left focus:outline-none border border-border sm:text-sm"
                        >
                            <span class="block truncate">{{ selectedTag.name }}</span>
                            <span
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2"
                            >
                                <selector-icon class="h-5 w-5 text-gray-400" aria-hidden="true"/>
                            </span>
                        </listbox-button>

                        <transition
                            leave-active-class="transition duration-100 ease-in"
                            leave-from-class="opacity-100"
                            leave-to-class="opacity-0"
                        >
                            <listbox-options
                                class="absolute mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
                            >
                                <listbox-option
                                    v-slot="{ active, selected }"
                                    v-for="person in tags"
                                    :key="person.name"
                                    :value="person"
                                    as="template"
                                >
                                    <li
                                        :class="[
                                          active ? 'bg-amber-100 text-amber-900' : 'text-gray-900',
                                          'relative cursor-default select-none py-2 pl-10 pr-4',
                                        ]"
                                    >
                                        <span
                                            :class="[
                                            selected ? 'font-medium' : 'font-normal',
                                            'block truncate',
                                          ]"
                                        >
                                            {{ person.name }}
                                        </span>

                                        <span
                                            v-if="selected"
                                            class="absolute inset-y-0 left-0 flex items-center pl-3 text-amber-600"
                                        ></span>
                                    </li>
                                </listbox-option>
                            </listbox-options>
                        </transition>
                    </div>
                </listbox>
            </div>
        </div>
    </div>
</template>
