<template>
    <div class="container">
        <Table :data="userAll" @update="updateData"></Table>
    </div>
</template>

<script>

import Table from '../../components/admin/Table.vue'
import {mapActions, mapGetters} from 'vuex';

export default {
    name: "Posts",
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
.custom-img {
    width: 100%;
    height: 200px;
}

.box-img img {
    width: 100%;
    height: 100%;
    object-fit: contain !important;
}

.box-img {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 200px;
    border: 4px dashed #cccc;
    border-radius: 10px;
}
</style>
