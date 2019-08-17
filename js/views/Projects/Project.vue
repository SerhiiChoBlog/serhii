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
import ProjectInfo from '../inc/ProjectInfo'

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

[main-title]
    font-size: 30px
    color: #444

.fa-angle-left
    font-size: 13px

.collection
    margin-top: 18px
    background-color: white
    border-radius: 4px

</style>