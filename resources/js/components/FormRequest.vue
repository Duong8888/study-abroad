<template>
    <div
        class="col-lg-8 rs-seo-website style1 pt-20 pb-30 md-pt-70 md-pb-80 border rounded mx-auto box-request custom-size">
        <div class="container flex-column d-flex align-items-center">
            <p class="font-weight-bold fs-6">Đăng ký nhận tư vấn</p>
            <form class="newsletter-form mx-0 row w-100">
                <input type="text" id="name" v-model="name" name="name" placeholder="Họ và tên" required="" autocomplete="off">
                <input type="text" id="phone" v-model="phone" name="phone" placeholder="Số điện thoại" required="" autocomplete="off">
                <button type="button" class="rounded relative h-100" @click="sendRequest()">Đăng ký</button>
            </form>
        </div>
    </div>
</template>

<script>
import { toast } from 'solid-toast';
export default {
    name: "FormRequest",
    data(){
        return{
            name:'',
            phone:'',
        }
    },
    methods:{
        async sendRequest(){
            toast('Here is your toast.');
            console.log("Here is your toast");
            try {
                const data = await axios.post('api/consultation-request', {
                    name: this.name,
                    phone: this.phone
                })
                if(data.status){

                }
            }catch (e) {
                console.log(e);
            }
        },

    }
}
</script>

<style scoped>
.box-request {
    transform: translateY(-50%);
}
input{
    padding-left: 20px;
}
input[name="phone"]{
    border-left: 1px solid #cccc !important;
}
form{
    border: 1px solid #cccc;
}

@media (min-width: 992px) {
    .custom-size {
        width: 800px;
        height: 190px;
        background: white;
        box-shadow: 0px 0px 15px #11005833;
    }
}
</style>
