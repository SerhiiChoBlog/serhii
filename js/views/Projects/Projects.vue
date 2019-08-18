<template>
    <div class="row pt-5">
        <!-- Spinner -->
        <div class="col s12 center pt-4" v-if="$store.getters.getProcessing">
            <div class="spinner"></div>
        </div>

        <Tabs v-else>
            <Tab v-for="tab in tabs"
                :key="tab.hash"
                :name="tab.title"
                :hash="tab.hash"
                :selected="tab.hash == '#tab-1'"
            >
                <ProjectsList :projects="getProjectsWithCategory(projects, tab.title)"></ProjectsList>
            </Tab>
        </Tabs>

        <!-- Add new project button -->
        <div class="fixed-action-btn" v-if="$root.isAuth()">
            <a :href="addNewPostUrl" class="btn-floating btn-large green darken-3" title="Add new project">
                <i class="fas fa-plus"></i>
            </a>
        </div>
    </div>
</template>

<script>
import ProjectsList from '../inc/ProjectsList'
import Tabs from '../../components/Tabs'
import Tab from '../../components/Tab'

export default {
    data() {
        return {
            tabs: [
                { title: 'Paid projects', hash: '#tab-1' },
                { title: 'Personal projects', hash: '#tab-2' },
                { title: 'Open source projects', hash: '#tab-3' },
            ],
        }
    },

    computed: {
        projects() {
            return this.$store.getters.getProjects
        },

        addNewPostUrl() {
            return portfolio_globals.admin_url + 'post-new.php'
        },
    },

    methods: {
        getProjectsWithCategory(projects, category) {
            return projects.filter(project => project.categories.indexOf(category) === 0)
        }
    },

    filters: {
        textLimit(string) {
            return string.substr(0, 170) + '...'
        }
    },

    components: {
        ProjectsList,
        Tabs,
        Tab,
    },
}
</script>

