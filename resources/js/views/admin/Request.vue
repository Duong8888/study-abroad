<template>
    <Table :data="userAll" @update="updateData"></Table>
</template>

<script>
import Table from '../../components/admin/Table.vue'
import {mapActions, mapGetters} from 'vuex';

export default {
    name: "Request",
    components: {
        Table,
    },
    computed: {
        ...mapGetters('request', ['userAll']),
    },
    methods: {
        ...mapActions('request', ['fetchRequest', "updateStatus"]),
        updateData(id) {
            this.updateStatus({id, toast: this.$toast});
            this.fetchRequest();
        }
    },
    created() {
        this.fetchRequest();
    },
}
</script>

<style scoped>

</style>
