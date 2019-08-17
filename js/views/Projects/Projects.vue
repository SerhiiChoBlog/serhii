<template>
    <div class="row pt-5">
        <div class="col s12 m6 l4" v-for="project in projects" :key="project.id">
            <router-link :to="`/project/${project.id}`">
                <div class="card hoverable">
                    <div language-logo>
                        <span v-for="tag in project.tags" v-html="getTagIcon(tag.name)" :title="tag.name"></span>
                    </div>
                    <div class="card-image waves-effect waves-block waves-light position-relative">
                        <img :src="project.imageUrl" :alt="project.title" main-image>
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
    methods: {
        getTagIcon(tagName) {
            if (tagName === 'database') {
                return '<i class="fas fa-database"></i>'
            }
            return `<i class="fab fa-${tagName}"></i>`
        }
    },

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

[main-image]
    height: 210px
    object-fit: cover
    object-position: center

.card-title
    font-size: 20px
    line-height: 26px !important
    color: #333
    text-align: center

.card-content
    min-height: 110px

</style>