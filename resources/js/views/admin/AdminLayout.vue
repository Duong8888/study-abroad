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
      ...mapActions('auth',['getUser']),
      ...mapActions('request',['fetchStats']),
    },
    computed: {
        ...mapGetters('auth', ['isAuthenticated','userInfo'])
    },
    created() {
        if (!this.isAuthenticated) {
            this.$router.push({name:'Login'});
        }
        this.getUser();
        // Số yêu cầu tư vấn mới cho badge ở sidebar
        if (this.isAuthenticated) this.fetchStats();
    },
    watch:{
        userInfo: function (value){
            this.userName = value.name
        }
    }
}
</script>

<style>
/* Header admin và sidebar đứng yên khi cuộn trang.
   sb-admin đặt overflow-x: hidden cho #content-wrapper, làm position: sticky bám vào khung này
   (không bao giờ cuộn) thay vì cửa sổ. clip vẫn chặn cuộn ngang nhưng không tạo vùng cuộn riêng.
   Thêm body phía trước để thắng rule gốc của sb-admin (file đó được nạp sau). */
body #wrapper #content-wrapper {
    overflow-x: visible;
    overflow-x: clip;
    /* cho phép khung nội dung co lại, để bảng rộng không ép sidebar bị hẹp đi */
    min-width: 0;
}
#content > .topbar {
    position: sticky;
    top: 0;
    z-index: 1020;
}
#wrapper > #accordionSidebar {
    flex-shrink: 0;
    position: sticky;
    top: 0;
    align-self: flex-start;
    height: 100vh;
    overflow-y: auto;
    overflow-x: hidden;
    scrollbar-width: thin;
    scrollbar-color: rgba(255, 255, 255, .25) transparent;
}
</style>
