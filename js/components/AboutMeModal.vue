<template>
    <div class="modal open" :style="showModalStyles">
        <div class="modal-content">
            <h4>Modal Header</h4>
            <p>A bunch of text</p>
        </div>
        <div class="modal-footer">
            <a href="javascript:" class="modal-close waves-effect waves-green btn-flat">Agree</a>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {

            }
        },

        props: ['display'],

        computed: {
            showModalStyles() {
                return this.display ? 'z-index: 1003; display: block; opacity: 1; top: 10%; transform: scaleX(1) scaleY(1);' : null
            }
        }
    }
</script>
