import Vue from "vue";
import Vuex from "vuex";
import projectsModule from "./store/projects";
import aboutMeModule from "./store/aboutMe";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        projectsModule,
        aboutMeModule,
    }
});