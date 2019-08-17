<template>
    <div>
        <h5 class="py-4">Add project</h5>

        <form action="" @submit.prevent="saveTheProject" class="row">

            <!-- Title -->
            <div class="input-field col s12 m4">
                <input id="title" type="text" class="validate" required>
                <label for="title" class="active">Title</label>
            </div>

            <!-- Client -->
            <div class="input-field col s12 m4">
                <input id="client" type="text" class="validate" required>
                <label for="client" class="active">Client name</label>
            </div>

            <!-- Date -->
            <div class="input-field col s12 m4">
                <input id="date" type="date" class="validate" required>
                <label for="date" class="active">Project date</label>
            </div>

            <!-- Git repo -->
            <div class="input-field col s12 m4">
                <input id="git-repo" type="text" class="validate" required>
                <label for="git-repo" class="active">Git repo url</label>
            </div>

            <!-- Site url -->
            <div class="input-field col s12 m4">
                <input id="site-url" type="text" class="validate" required>
                <label for="site-url" class="active">Site url</label>
            </div>

            <!-- Tags -->
            <div class="input-field col s12 m4">
                <input id="tags" type="text" class="validate">
                <label for="tags" class="active">Tags</label>
            </div>

            <!-- Content -->
            <Tinymce></Tinymce>
            <div class="input-field col s12">
                <textarea id="content" class="materialize-textarea"></textarea>
                <label for="content" class="active">Content</label>
            </div>

            <div class="input-field col s12 pt-3">
                <button type="submit" class="btn blue-grey darken-4">Save project</button>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            //
        }
    },

    methods: {
        saveTheProject() {
            //
        },
    },
}
</script>