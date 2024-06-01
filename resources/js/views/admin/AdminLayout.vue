<template>
    <div id="wrapper">
        <SideBar></SideBar>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <TopBar></TopBar>
                <router-view></router-view>
            </div>
            <Footer></Footer>
        </div>
    </div>
</template>

<script>
import SideBar from '../../components/admin/SideBar.vue'
import TopBar from "../../components/admin/TopBar.vue";
import Footer from "../../components/admin/Footer.vue";
import {mapGetters} from "vuex";
export default {
    name: "AdminLayout",
    components: {
        SideBar,
        TopBar,
        Footer
    },
    computed: {
        ...mapGetters('auth', ['isAuthenticated'])
    },
    created() {
        if (!this.isAuthenticated) {
            this.$router.push({name:'Login'});
        }
    },
}
</script>

<style scoped>

</style>
