<template>
    <div class="row pt-5">
        <div class="col s12 m6 l4" v-for="project in projects" :key="project.id">
            <router-link :to="`/project/${project.id}`">
                <div class="card hoverable">
                    <div class="card-image waves-effect waves-block waves-light">
                        <img :src="project.imageUrl" :alt="project.title">
                    </div>
                    <div class="card-content">
                        <span class="card-title" v-html="project.title"></span>
                    </div>
                </div>
            </router-link>
        </div>

        <div class="fixed-action-btn">
            <router-link to="add-project" class="btn-floating btn-large green darken-2">
                <i class="fas fa-plus"></i>
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    computed: {
        projects() {
            return this.$store.getters.getProjects
        },
    },

    filters: {
        textLimit(string) {
            return string.substr(0, 170) + '...'
        }
    },
}
</script>

<style lang="sass" scoped>

.card-title
    font-size: 22px
    line-height: 26px !important
    color: #333

</style>