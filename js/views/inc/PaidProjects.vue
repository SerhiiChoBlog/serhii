<template>
    <div>
        <div class="col s12 m6 l4" v-for="project in paidProjects" :key="project.id">
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
    </div>
</template>

<script>
import getTagIcon from '../../modules/getTagIcon'

export default {
    methods: {
        getTagIcon(tagName) {
            return getTagIcon(tagName)
        },
    },

    props: {
        projects: {
            required: true,
        },
    },

    computed: {
        paidProjects() {
            return this.projects.filter(project => project.categories.indexOf('Paid projects') === 0)
        }
    }
}
</script>
