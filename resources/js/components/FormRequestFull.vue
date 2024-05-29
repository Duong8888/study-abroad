<template>
    <!-- Contact Section Start -->
    <div class="rs-contact main-home gray-bg2 pb-80 md-pt-80 md-pb-80 index-form">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 pr-60 md-pr-15">
                    <div class="sec-title2 mb-60 md-mb-40">
                        <h2 class="title pb-25 md-pb-15">
                            <span style="color: #ed1e24">SMART EDU</span> du học quốc tế
                        </h2>
                    </div>
                    <div class="row">
                        <div class="col-md-6 pr-40 md-pr-15 md-mb-40">
                            <div class="images-map">
                                <img src="@/assets/images/contact/map.jpg" alt="images">
                            </div>
                        </div>
                        <div class="col-md-6 md-pl-30 sm-pl-15">
                            <div class="address-box mb-25">
                                <div class="address-icon">
                                    <img src="@/assets/images/contact/style1/1.png" alt="images">
                                </div>
                                <div class="address-text">
                                    <h3 class="title">Email</h3>
                                    <p class="desc"><a href="visakrinfo@gmail.com">Duhochanquoc.smartedu@gmail.com</a></p>
                                </div>
                            </div>
                            <div class="address-box mb-25">
                                <div class="address-icon">
                                    <img src="@/assets/images/contact/style1/2.png" alt="images">
                                </div>
                                <div class="address-text">
                                    <h3 class="title">Liên hệ</h3>
                                    <p class="desc"><a href="tel%2b5559811444.html">(+84) 329 - 155 - 366</a></p>
                                </div>
                            </div>
                            <div class="address-box mb-25">
                                <div class="address-icon">
                                    <img src="@/assets/images/contact/style1/3.png" alt="images">
                                </div>
                                <div class="address-text">
                                    <h3 class="title">Văn Phòng</h3>
                                    <p class="desc">Trương Công Giai, Dịch Vọng, Cầu Giấy, Hà Nội</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="contact-wrap">
                        <div class="content-part text-center mb-25">
                            <h5 class="mb-15" >ĐĂNG KÝ TƯ VẤN MIỄN PHÍ</h5>
                        </div>
                        <div id="form-messages"></div>
                        <form id="contact-form" method="post"
                              action="https://rstheme.com/products/html/topkie/mailer.php">
                            <fieldset>
                                <div class="row">
                                    <div class="col-lg-12 mb-15">
                                        <input class="from-control" v-model="name" type="text" id="name" name="name" placeholder="Họ tên"
                                               required="">
                                    </div>
                                    <div class="col-lg-12 mb-15">
                                        <input class="from-control" v-model="email" type="text" id="email" name="email"
                                               placeholder="E-Mail" required="">
                                    </div>
                                    <div class="col-lg-12 mb-15">
                                        <input class="from-control" v-model="phone" type="text" id="phone" name="phone"
                                               placeholder="Số điện thoại" required="">
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <button type="button" class="readon submit btn-custom" :class="{'btn-custom-disabled':statusBtn}" :disabled="statusBtn"  @click="sendRequest()">
                                        Đăng ký
                                        <div v-if="statusBtn" class="spinner-border text-white spinner-custom" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact Section End -->
</template>

<script>
export default {
    name: "FormRequestFull",
    data(){
        return {
            name: '',
            email: '',
            phone: '',
        }
    },
    props:{
        statusBtn:Boolean,
    },
    methods:{
        sendRequest(){
            const data = {
                name: this.name,
                email: this.email,
                phone: this.phone,
            };
            this.$emit('send-request',data);
        }
    }
}
</script>

<style scoped>
.btn-custom{
    display: flex;
    justify-content: center;
    align-items: center;
}
.spinner-custom{
    width: 20px;
    height: 20px;
    margin-left: 10px;
}
.btn-custom-disabled{
    opacity: 0.5;
    user-select: none;
}
.btn-custom-disabled:hover {
    opacity: 0.5 !important;
}

</style>
