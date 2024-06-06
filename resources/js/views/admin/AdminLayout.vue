<template>
    <div id="wrapper">
        <SideBar></SideBar>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <TopBar :name="userName"></TopBar>
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
import {mapActions, mapGetters} from "vuex";
export default {
    name: "AdminLayout",
    data(){
        return {
            userName: "Admin1",
        }
    },
    components: {
        SideBar,
        TopBar,
        Footer
    },
    methods:{
      ...mapActions('auth',['getUser'])
    },
    computed: {
        ...mapGetters('auth', ['isAuthenticated','userInfo'])
    },
    created() {
        if (!this.isAuthenticated) {
            this.$router.push({name:'Login'});
        }
        this.getUser();
    },
    watch:{
        userInfo: function (value){
            this.userName = value.name
        }
    }
}
</script>

<style scoped>

</style>
