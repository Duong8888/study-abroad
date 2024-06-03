<template>
    <div
        class="col-lg-8 rs-seo-website style1 pt-20 pb-30 md-pt-70 md-pb-80 border rounded mx-auto box-request custom-size">
        <div class="container flex-column d-flex align-items-center">
            <p class="font-weight-bold fs-6">Đăng ký nhận tư vấn</p>
            <form class="newsletter-form mx-0 row w-100">
                <input type="text" id="name" v-model="name" name="name" placeholder="Họ và tên" required="" autocomplete="off">
                <input type="text" id="phone" v-model="phone" name="phone" placeholder="Số điện thoại" required="" autocomplete="off">
                <button type="button" class="rounded relative h-100 btn-custom" :class="{'btn-custom-disabled':statusBtn}" :disabled="statusBtn" @click="sendRequest()">
                    Đăng ký
                    <div v-if="statusBtn" class="spinner-border text-white spinner-custom" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: "FormRequest",
    data(){
        return{
            name:'',
            phone:'',
        }
    },
    props:{
        statusBtn:Boolean,
    },
    methods:{
        sendRequest(){
            const data = {
                name: this.name,
                phone: this.phone,
            };
            this.$emit('send-request',data);
        }
    },
}
</script>

<style scoped>
.box-request {
    transform: translateY(-50%);
}

input {
    padding-left: 20px;
}

input[name="phone"] {
    border-left: 1px solid #cccc !important;
}

form {
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
@media (max-width: 991px) {
    .box-request {
        transform: none;
    }
    .custom-size {
        width: 90%;
        height: auto;
        padding: 10px 10px 30px 10px;
        box-shadow: 0px 0px 15px #11005833;
        background: white;
    }
}

@media (max-width: 576px) {
    .box-request {
        transform: none;
    }
    .custom-size {
        width: 90%;
        height: auto;
        padding: 10px 10px 30px 10px;
        box-shadow: 0px 0px 15px #11005833;
        background: white;
    }

    input[name="phone"] {
        border-left: none;
    }

    input {
        padding-left: 10px;
        margin-bottom: 10px;
        border-radius: 2px;
        border: 1px solid #cccc !important;
    }
    form {
        border: none;
    }
}

.btn-custom {
    display: flex;
    justify-content: center;
    align-items: center;
}

.spinner-custom {
    width: 20px;
    height: 20px;
    margin-left: 10px;
}

.btn-custom-disabled {
    opacity: 0.5;
    user-select: none;
}

.btn-custom-disabled:hover {
    opacity: 0.5 !important;
}
</style>
