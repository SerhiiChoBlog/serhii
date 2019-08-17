import Vue from "vue";
import Vuex from "vuex";
import projectsModule from "./store/projects";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        projectsModule,
    }
});