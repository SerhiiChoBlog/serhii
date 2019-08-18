<template>
    <div class="row pt-5">
        <div class="col s12 center mb-3">
            <h4 class="page-title">Paid projects</h4>
        </div>

        <!-- Spinner -->
        <div class="col s12 center pt-5" v-if="$store.getters.getProcessing">
            <div class="spinner"></div>
        </div>

        <PaidProjects :projects="projects"></PaidProjects>

        <!-- Add new project button -->
        <div class="fixed-action-btn" v-if="$root.isAuth()">
            <a :href="addNewPostUrl" class="btn-floating btn-large green darken-3" title="Add new project">
                <i class="fas fa-plus"></i>
            </a>
        </div>
    </div>
</template>

<script>
import PaidProjects from '../inc/PaidProjects'

export default {
    computed: {
        projects() {
            return this.$store.getters.getProjects
        },

        addNewPostUrl() {
            return portfolio_globals.admin_url + 'post-new.php'
        }
    },

    filters: {
        textLimit(string) {
            return string.substr(0, 170) + '...'
        }
    },

    components: {
        PaidProjects,
    },
}
</script>

