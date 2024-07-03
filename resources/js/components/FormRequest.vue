<template>
    <div
        class="col-lg-8 rs-seo-website style1 pt-20 pb-30 md-pt-70 md-pb-80 border rounded mx-auto box-request custom-size">
        <div class="container flex-column d-flex align-items-center">
            <div class="title-form">
                <p class="font-weight-bold fs-6 text-form">{{ displayText }} <span class="text-cursor" :class="{run:cursor}"></span></p>
                <p class="d-flex align-items-center font-weight-bold fs-6 text-form hotline">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                         style="fill: #FFFFFF;transform: ;msFilter:;">
                        <path
                            d="M16.57 22a2 2 0 0 0 1.43-.59l2.71-2.71a1 1 0 0 0 0-1.41l-4-4a1 1 0 0 0-1.41 0l-1.6 1.59a7.55 7.55 0 0 1-3-1.59 7.62 7.62 0 0 1-1.59-3l1.59-1.6a1 1 0 0 0 0-1.41l-4-4a1 1 0 0 0-1.41 0L2.59 6A2 2 0 0 0 2 7.43 15.28 15.28 0 0 0 6.3 17.7 15.28 15.28 0 0 0 16.57 22zM6 5.41 8.59 8 7.3 9.29a1 1 0 0 0-.3.91 10.12 10.12 0 0 0 2.3 4.5 10.08 10.08 0 0 0 4.5 2.3 1 1 0 0 0 .91-.27L16 15.41 18.59 18l-2 2a13.28 13.28 0 0 1-8.87-3.71A13.28 13.28 0 0 1 4 7.41zM20 11h2a8.81 8.81 0 0 0-9-9v2a6.77 6.77 0 0 1 7 7z"></path>
                        <path d="M13 8c2.1 0 3 .9 3 3h2c0-3.22-1.78-5-5-5z"></path>
                    </svg>
                    <span> 0329.155.366</span>
                </p>
            </div>
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
            texts: [
                "Đăng ký nhận tư vấn",
                "Đăng ký học thử miễn phí",
                "Nhận thông tin khóa học mới nhất"
            ],
            currentIndex: 0,
            currentText: "",
            caretVisible: true,
            typingDelay: 50,
            switchDelay: 4000,
            intervalId: null,
            cursor:false,
            name:'',
            phone:'',
        }
    },
    props:{
        statusBtn:Boolean,
    },
    computed: {
        displayText() {
            return this.currentText;
        }
    },
    created() {
        this.startTyping();
    },
    methods:{
        sendRequest(){
            const data = {
                name: this.name,
                phone: this.phone,
            };
            this.$emit('send-request',data);
        },
        startTyping() {
            this.intervalId = setInterval(() => {
                if (this.currentText.length < this.texts[this.currentIndex].length) {
                    this.currentText = this.texts[this.currentIndex].slice(0, this.currentText.length + 1);
                    this.cursor = false;
                } else {
                    this.cursor = true;
                    clearInterval(this.intervalId);
                    setTimeout(() => {
                        this.currentIndex = (this.currentIndex + 1) % this.texts.length;
                        this.currentText = "";
                        this.startTyping();
                    }, this.switchDelay);
                }
            }, this.typingDelay);
        }
    },
}
</script>

<style scoped>
.box-request {
    transform: translateY(-50%);
    background: #B21818 !important;
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
.text-form{
    color: white !important;
}

@media (min-width: 992px) {
    .custom-size {
        display: flex;
        align-items: center;
        width: 800px;
        height: 250px;
        background: white;
        box-shadow: 0px 0px 15px #11005833;
    }
    .newsletter-form{
        max-width:100% !important;
    }
    .text-form{
        font-size: 20px;
        font-weight: 900 !important;
    }

    input {
        height: 40px;
        width: 40%;
    }
    input[name="phone"] {
        border-right: 28px solid #B21818 !important;
    }
    input[name="phone"] {
        border-left: 1px solid #B21818 !important;
    }
    .btn-custom{
        width: 20%;
    }
    .title-form{
        display: flex;
        width: 100%;
        justify-content: space-between;
    }
}
@media (max-width: 991px) {
    .box-request {
        transform: none;
        margin-top: 20px;
    }
    .custom-size {
        width: 90%;
        height: auto;
        padding: 10px 10px 30px 10px;
        box-shadow: 0px 0px 15px #11005833;
        background: white;
    }
    .title-form{
        display: flex;
        width: 100%;
        justify-content: space-between;
    }
}

@media (max-width: 576px) {
    .box-request {
        transform: none;
        margin-top: 20px;
    }
    .rs-seo-website.style1 .newsletter-form {
        background: #B21818;
    }
    .custom-size {
        width: 90%;
        height: auto;
        padding: 10px 10px 30px 10px;
        box-shadow: 0px 0px 15px #11005833;
    }

    input[name="phone"] {
        border-left: none;
        border-right: none;
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
    .text-form{
        margin: 0;
    }
    .title-form{
        display: block;
        width: 100%;
        margin-bottom: 20px;
    }
}

.btn-custom {
    display: flex;
    justify-content: center;
    align-items: center;
    background: #FFFFFF !important;
    color: #B21818 !important;
    font-weight: 900 !important;
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

@keyframes blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0; }
}

.text-cursor {
    display: inline-block;
    vertical-align: middle;
    width: 4px;
    height: 1em;
    background-color: rgba(0, 0, 0, 0);
}
.text-cursor.run{
    animation: blink 1s infinite;
}
.rs-seo-website.style1 .newsletter-form button:hover{
    opacity: 1;
}
</style>


<!--#B21818-->
<!--AA1B17-->
