import Vue from "vue";
import Vuex from "vuex";
import projectsModule from "./store/projects";
import generalModule from "./store/general";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        generalModule,
        projectsModule,
    }
});