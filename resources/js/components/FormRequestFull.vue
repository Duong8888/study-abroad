<template>
    <!-- Contact Section Start -->
    <div id="form" style="height:100px;background:#f6f7f9"></div>
    <div class="rs-contact main-home gray-bg2 pb-80 md-pt-80 md-pb-80 index-form">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 pr-60 md-pr-15">
                    <div class="sec-title2 mb-60 md-mb-40">
                        <h2 class="title pb-25 md-pb-15">
                            <span style="color: #B21818">SMART EDU</span> du học quốc tế
                        </h2>
                    </div>
                    <div class="row">
                        <div class="col-md-6 pr-40 md-pr-15 md-mb-40">
                            <!-- Bản đồ, email, SĐT, văn phòng lấy từ Cài đặt chung (giống footer) -->
                            <div class="images-map" v-if="settings.footer_map">
                                <div class="w-100">
                                    <iframe :src="settings.footer_map" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
<!--                                <img src="@/assets/images/contact/map.jpg" alt="images">-->
                            </div>
                        </div>
                        <div class="col-md-6 md-pl-30 sm-pl-15">
                            <div class="address-box mb-25" v-if="settings.contact_email">
                                <div class="address-icon">
                                    <img src="@/assets/images/contact/style1/1.png" alt="images">
                                </div>
                                <div class="address-text">
                                    <h3 class="title">Email</h3>
                                    <p class="desc"><a :href="'mailto:' + settings.contact_email">{{ settings.contact_email }}</a></p>
                                </div>
                            </div>
                            <div class="address-box mb-25" v-if="settings.contact_phone_vn">
                                <div class="address-icon">
                                    <img src="@/assets/images/contact/style1/2.png" alt="images">
                                </div>
                                <div class="address-text">
                                    <h3 class="title">Liên hệ</h3>
                                    <p class="desc"><a :href="'tel:' + settings.contact_phone_vn.replace(/[^\d+]/g, '')">{{ settings.contact_phone_vn }}</a></p>
                                </div>
                            </div>
                            <div class="address-box mb-25" v-if="office">
                                <div class="address-icon">
                                    <img src="@/assets/images/contact/style1/3.png" alt="images">
                                </div>
                                <div class="address-text">
                                    <h3 class="title">Văn Phòng</h3>
                                    <p class="desc">{{ office }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="contact-wrap">
                        <div class="content-part text-center mb-25">
                            <h5 class="mb-15 text-white" >ĐĂNG KÝ TƯ VẤN MIỄN PHÍ</h5>
                        </div>
                        <div id="form-messages"></div>
                        <form id="contact-form" method="post"
                              action="">
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

                                    <div class="col-lg-12 mb-15">
                                        <textarea name="content" class="from-control" placeholder="Nội dung tư vấn" id="" cols="30" v-model="content" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <button type="button" class="readon submit btn-custom" :class="{'btn-custom-disabled':statusBtn}" :disabled="statusBtn"  @click="sendRequest()">
                                        Đăng ký
                                        <div v-if="statusBtn" class="spinner-border spinner-custom" role="status">
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
import {mapGetters} from "vuex";

export default {
    name: "FormRequestFull",
    data(){
        return {
            name: '',
            email: '',
            phone: '',
            content: '',
        }
    },
    props:{
        statusBtn:Boolean,
    },
    computed: {
        ...mapGetters('settings', {settings: 'settingsAll'}),
        // Dòng đầu của "Văn phòng Việt Nam", bỏ tiền tố kiểu "CN1: "
        office() {
            const firstLine = (this.settings.footer_office_vn || '').split('\n').map(line => line.trim()).find(Boolean);
            return firstLine ? firstLine.replace(/^CN\s*\d+\s*:\s*/i, '') : '';
        },
    },
    methods:{
        sendRequest(){
            const data = {
                name: this.name,
                email: this.email,
                phone: this.phone,
                content: this.content,
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
    background: white !important;
    color: #B21818 !important;
    font-weight: bold;
}
.spinner-custom{
    width: 20px;
    height: 20px;
    margin-left: 10px;
    color: #B21818 !important;
}
.btn-custom-disabled{
    opacity: 0.5;
    user-select: none;
}
.btn-custom-disabled:hover {
    opacity: 0.5 !important;
}
@media (max-width: 768px) {
    #form {
        height: 0px !important;
    }
}

.contact-wrap{
    background: #B21818 !important;
}
input, textarea{
    background: white !important;
}
</style>
