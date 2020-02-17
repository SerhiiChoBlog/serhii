<template>
    <table class="mt-2">
        <tr v-for="info in contactInfo" :key="info.type">
            <td><b>{{ info.type }}:</b></td>
            <td>{{ info.value }}</td>
        </tr>
    </table>
</template>

<script>
import contact from '../../staticStore/contacts'

export default {
    data() {
        return {
            contactInfo: [],
        }
    },

    created() {
        this.contactInfo = contact
    },
}
</script>