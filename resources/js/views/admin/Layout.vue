<template>
    <div class="offwrap"></div>
    <!--Preloader area start here-->
    <!--    <div id="loader" class="loader">-->
    <!--        <div class="loader-container"></div>-->
    <!--    </div>-->
    <!--Preloader area End here-->
    <div class="main-content">
        <Header></Header>
    </div>
    <router-view></router-view>
    <FormRequest @send-request="sendRequest" :statusBtn="statusBtn"></FormRequest>
    <Footer></Footer>
    <div class="social-icon">
        <a href="https://www.tiktok.com/@smarteduchuyn.du?_t=8mkQxX6ywT4&_r=1" target="_blank">
            <img src="@/assets/images/common/tiktok_logo.png">
        </a>
        <a href="https://www.facebook.com/profile.php?id=61555208818668" target="_blank">
            <img src="@/assets/images/common/Facebook.png">
        </a>
        <a href="https://zalo.me/0328021619" target="_blank">
            <img src="@/assets/images/common/Logo-zalo.svg">
        </a>
    </div>
</template>

<script>
import Footer from '@/components/Footer.vue';
import Header from '@/components/Header.vue';
import FormRequest from '@/components/FormRequestFull.vue';
import {API_ENDPOINT} from "@/store/api-endpoint.js";


export default {
    name: "Layout",
    data() {
        return {
            statusBtn: false,
        }
    },
    methods:{
        async sendRequest(value) {
            this.statusBtn = true;
            try {
                const data = await axios.post(API_ENDPOINT.API_USER.SEND_REQUEST, value)
                if (data.data.success) {
                    this.showToast(data.data.message, 'success');
                    this.statusBtn = false;
                }
            } catch (e) {
                if (e.response) {
                    const statusCode = e.response.status;
                    console.log(statusCode);
                    if (statusCode == 429) {
                        this.showToast('Gửi lại yêu cầu său 1 phút', 'error');
                        this.statusBtn = false;
                    }
                    if (statusCode == 422) {
                        this.showToast('Thông tin không hợp lệ', 'error');
                        this.statusBtn = false;
                    }

                }
            }
        },

        showToast(message, type) {
            this.$toast.open({
                message: message,
                type: type,
                position: 'top',
            });
        }
    },
    components: {
        Header,
        Footer,
        FormRequest,
    },
}
</script>

<style scoped>
.social-icon{
    position: fixed;
    bottom: 40px;
    right: 40px;
    z-index: 10;
    cursor: pointer;
    display: flex;
    flex-direction: column;
}
.social-icon img{
    width: 50px;
    height: 50px;
    margin: 10px 0px;
}
@media (max-width: 767px) {
    .social-icon {
        bottom: 20px;
        right: 20px;
    }
}
</style>
