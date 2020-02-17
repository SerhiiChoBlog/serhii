<template>
    <div style="background:white">
        <div class="container">
            <div class="row">
                <div class="col s12 l4" v-for="language in languagesInfo" :key="language.name">
                    <div class="card">
                        <div class="card-image">
                            <img :src="language.img">
                            <span class="card-title">{{ language.name }}</span>
                        </div>

                        <div class="card-content">
                            <p>{{ language.desc }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import languages from '../../staticStore/languages'

export default {
    data() {
        return {
            languagesInfo: [],
        }
    },

    created() {
        this.languagesInfo = languages
    },
}
</script>