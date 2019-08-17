<template>
    <div class="pt-3">
        <div v-if="project">
            <div class="center">
                <h4 main-title v-html="project.title"></h4>
                <div class="row pt-3">
                    <div class="col s12 m8">
                        <img :src="project.imageUrl" :alt="project.title" main-image />
                    </div>
                    <div class="col s12 m4">
                        <ProjectInfo :project="project"></ProjectInfo>
                    </div>
                </div>
            </div>

            <div class="row pt-2">
                <div class="col s12 m8">
                    <p v-html="project.content" main-text></p>
                </div>
                <div class="col s12 m4">
                    nice
                </div>
            </div>
            <router-link to="/" exact class="btn btn-small transparent grey-text text-darken-4 z-depth-0">
                    <i class="fas fa-angle-left left"></i> Go back to home page
            </router-link>
        </div>
    </div>
</template>

<script>
import ProjectInfo from '../inc/ProjectInfo'

export default {
    props: ['id'],

    computed: {
        project() {
            return this.$store.getters.getProjects.find(b => b.id == this.id)
        }
    },

    components: {
        ProjectInfo,
    },
}
</script>

<style lang="sass" scoped>

[main-image]
    width: 100%

[main-title]
    font-size: 27px
    color: #444

[main-text]
    font-size: 20px
    margin-top: 0

.fa-angle-left
    font-size: 13px

</style>