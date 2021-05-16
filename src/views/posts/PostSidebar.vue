<template>
    <div class="sidebar-content">
        <nav class="panel is-shadowless">
            <p class="panel-heading mb-4">
                <img src="../../assets/images/icons/github-dark.png" class="mr-2" width="22" />
                <span class="has-text-weight-normal">Open source projects</span>
            </p>
            <router-link :to="`/projects/${project.name}`"
                class="panel-block"
                v-for="project in projects"
                :key="project.name"
            >{{ project.title }}</router-link>
        </nav>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import useFetchProjects from '@/composables/projects/useFetchRrojects'

export default defineComponent({
    setup() {
        return {
            ...useFetchProjects(),
        }
    },
})
</script>

<style lang="sass" scoped>
.panel-heading
    padding: 0
    background-color: transparent
    display: flex
    align-items: center
</style>