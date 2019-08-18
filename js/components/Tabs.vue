<template>
    <div>
        <ul class="_tabs row">
            <li v-for="(tab, i) in tabs" :key="i" class="col s12 m4">
                <a :href="'#tab-' + (i + 1)"
                   v-html="`${tab.name} <b>${tab.count}</b>`"
                   :class="{ 'active': tab.active }"
                   @click="selectedTab(tab)"
                >
                </a>
            </li>
        </ul>
        <div class="px-3">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            tabs: [],
        };
    },

    created() {
        this.tabs = this.$children;
        this.selectedTab()
    },

    methods: {
        selectedTab(selectedTab = null) {
            setTimeout(() => {
                let hash = window.location.hash.substring(0);

                this.tabs.forEach(tab => {
                    if (!selectedTab && hash) {
                        tab.active = tab.$attrs.hash == hash;
                    } else if (!hash && !selectedTab) {
                        tab.active = tab.$attrs.hash == '#tab-1';
                    } else {
                        tab.active = tab.name == selectedTab.name;
                    }
                });
            }, 20);
        },
    },
};
</script>

<style lang="sass">

    ._tabs
        list-style: none
        text-align: center
        margin-bottom: 1.4em
        padding-left: 0

        li
            margin: 5px 0

            a
                width: 90%
                margin: 0 auto
                color: #878787
                max-width: 200px
                letter-spacing: 1px
                text-transform: uppercase
                font-size: .7em
                padding: 7px 18px
                display: block
                transition: border-bottom-color .2s,color .2s
                position: relative
                font-weight: bold
                border-bottom: 2px solid #00000030
                outline: none
                user-select: none

                b
                    font-size: 12px
                    color: brown

                &:hover
                    border-color: #333

                &.active
                    border-color: #777
                    color: #333


</style>
