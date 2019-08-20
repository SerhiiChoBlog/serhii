<template>
    <div class="pt-3">
        <div v-if="project">
            <div class="row pt-2">
                <div class="col s12 center">
                    <h4 main-title v-html="project.title"></h4>
                </div>
                <div class="col s12 m8">
                    <div class="center">
                        <img :src="project.fullImageUrl" :alt="project.title" main-image />
                    </div>
                    <div v-html="project.content" main-text></div>
                </div>

                <div class="col s12 m4">
                    <ProjectInfo :project="project"></ProjectInfo>
                    <TechnologiesSection :techs="project.tags"></TechnologiesSection>
                    <ProjectsSection category="Paid projects" icon-name="coins"></ProjectsSection>
                    <ProjectsSection category="Personal projects" icon-name="user-alt"></ProjectsSection>
                    <ProjectsSection category="Open source projects" icon-name="users"></ProjectsSection>
                </div>
            </div>
            <router-link to="/" exact class="btn btn-small transparent grey-text text-darken-4 z-depth-0">
                <i class="fas fa-angle-left left"></i> Go back to home page
            </router-link>
        </div>

        <!-- Edit project button -->
        <div class="fixed-action-btn" v-if="$root.isAuth()">
            <a :href="editProjectUrl" class="btn-floating btn-large green darken-3" title="Edit this project">
                <i class="fas fa-pen"></i>
            </a>
        </div>
    </div>
</template>

<script>
import ProjectInfo from '../sidebar/ProjectInfo'
import ProjectsSection from '../sidebar/ProjectsSection'
import TechnologiesSection from '../sidebar/TechnologiesSection'

export default {
    props: ['id'],

    computed: {
        project() {
            return this.$store.getters.getProjects.find(b => b.id == this.id)
        },

        editProjectUrl() {
            return `${portfolio_globals.admin_url}post.php?post=${this.id}&action=edit`
        }
    },

    components: {
        ProjectInfo,
        ProjectsSection,
        TechnologiesSection,
    },
}
</script>

<style lang="sass" scoped>
[main-text]
    font-size: 20px
    margin-top: 0

[main-image]
    width: 100%
    margin-top: 15px
    box-shadow: 2px 2px 10px rgba(0,0,0,.15)

[main-title]
    font-size: 30px
    color: #444

.fa-angle-left
    font-size: 13px
</style>