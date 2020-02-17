<template>
    <div>
        <div class="row">
            <div class="col s12 m6 l4" v-for="project in projects" :key="project.id">
                <router-link :to="`/project/${project.id}`">
                    <div class="card hoverable">
                        <div language-logo>
                            <section v-for="tag in project.tags" :key="tag.id">
                                <img :src="`${iconUri}${tag.name}.png`">
                            </section>
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
    </div>
</template>

<script>
export default {
    data() {
        return {
            cardsInRow: 3,
            iconUri: `${portfolio_globals.assets_uri}images/techs/`,
        }
    },

    props: {
        projects: {
            required: true,
        },
    },
}
</script>