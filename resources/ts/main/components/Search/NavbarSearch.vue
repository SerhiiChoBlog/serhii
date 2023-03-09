<script setup lang="ts">
import { computed, ref } from 'vue'
import useSearch from '@/composables/useSearch'
import SearchIcon from '@shared/components/Icons/SearchIcon.vue'
import Dropdown from '@/components/Search/Dropdown.vue'
import AppearTransition from '@shared/components/Transitions/AppearTransition.vue'
import DropdownTransition from '@shared/components/Transitions/DropdownTransition.vue'

const { search, input, changedInput } = useSearch()
const isSmall = ref<boolean>(true)

const hideInput = computed<boolean>(() => {
    return isSmall.value && search.query === ''
})

function handleBlur(): void {
    setTimeout(() => {
        search.query = ''
        isSmall.value = true
        console.log('test')
    }, 200)
}
</script>

<template>
    <appear-transition>
        <div
            @click="isSmall = false"
            :class="hideInput ? 'w-[40px] overflow-hidden' : 'w-[280px] md:w-[380px]'"
            class="absolute right-0 top-0 -translate-y-1/2 transition-all duration-300 ease-in-out z-50"
        >
            <label
                for="navbar-search-input"
                class="relative flex items-center justify-center rounded-full mx-auto"
                :class="hideInput ? '' : 'bg-gray-900'"
            >
                <form @submit.prevent class="w-full m-0">
                    <input
                        ref="input"
                        :type="hideInput ? 'button' : 'search'"
                        placeholder="Search blog posts"
                        v-model="search.query"
                        @input="changedInput"
                        @blur="handleBlur"
                        autocomplete="off"
                        class="pl-7 pr-12 w-full text-gray-400 rounded-full outline-none py-1 text-lg bg-transparent"
                        id="navbar-search-input"
                    />

                    <search-icon
                        :class="{
                            'animate-blink': search.loading,
                            'text-white right-3': hideInput,
                            'text-gray-400 right-4': !hideInput,
                        }"
                        class="w-5 h-5 absolute top-1/2 -translate-y-1/2 cursor-pointer"
                    />
                </form>

                <dropdown-transition>
                    <dropdown
                        v-if="search.query !== ''"
                        :search="search"
                        class="dark"
                    />
                </dropdown-transition>
            </label>
        </div>
    </appear-transition>
</template>
