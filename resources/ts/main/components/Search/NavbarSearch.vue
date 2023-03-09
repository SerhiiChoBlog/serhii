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
    search.query = ''
    isSmall.value = true
}
</script>

<template>
    <appear-transition>
        <div
            @click="isSmall = false"
            :class="hideInput ? 'w-[40px]' : 'w-[350px]'"
            class="transition-all duration-300 ease-in-out"
        >
            <label
                for="navbar-search-input"
                class="relative flex items-center justify-center rounded-full mx-auto"
                :class="hideInput ? '' : 'bg-black/50'"
            >
                <form @submit.prevent class="w-full m-0">
                    <search-icon
                        :class="{
                            'animate-blink': search.loading,
                            'text-white left-3': hideInput,
                            'text-gray-400 left-4': !hideInput,
                        }"
                        class="w-5 h-5 absolute top-1/2 -translate-y-1/2 cursor-pointer"
                    />

                    <input
                        ref="input"
                        :type="hideInput ? 'button' : 'search'"
                        placeholder="Search blog posts"
                        v-model="search.query"
                        @input="changedInput"
                        @blur="handleBlur"
                        autocomplete="off"
                        class="pr-7 pl-12 w-full text-gray-400 rounded-full outline-none py-1 text-lg bg-transparent"
                        id="navbar-search-input"
                    />
                </form>

                <dropdown-transition>
                    <dropdown v-if="search.query !== ''" :search="search" />
                </dropdown-transition>
            </label>
        </div>
    </appear-transition>
</template>
