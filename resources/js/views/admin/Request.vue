<template>
    <div id="wrapper">
        <SideBar></SideBar>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <TopBar></TopBar>
                <Table :data="userAll" @update="updateData"></Table>
            </div>
            <Footer></Footer>
        </div>
    </div>
</template>

<script>
import SideBar from '../../components/admin/SideBar.vue'
import TopBar from "../../components/admin/TopBar.vue";
import Table from '../../components/admin/Table.vue'
import Footer from "../../components/admin/Footer.vue";
import  {mapActions,mapGetters} from 'vuex';
export default {
    name: "Request",
    components: {
        SideBar,
        TopBar,
        Table,
        Footer
    },
    computed: {
        ...mapGetters('request', ['userAll']),
    },
    methods: {
        ...mapActions('request', ['fetchRequest',"updateStatus"]),
        updateData(id){
            this.updateStatus({ id, toast: this.$toast });
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
