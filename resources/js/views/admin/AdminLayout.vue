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
export default {
    name: "AdminLayout",
    components: {
        SideBar,
        TopBar,
        Footer
    },
}
</script>

<style scoped>

</style>
