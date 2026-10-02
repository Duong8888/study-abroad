<template>
    <footer id="rs-footer" class="rs-footer style1 modify3">
        <!--        <div class="subscribe-bg">-->
        <!--            <div class="container">-->
        <!--                <div class="subscribe-top">-->
        <!--                    <div class="footer-logo md-mb-30">-->
        <!--                        <a href="index.html"><img style="transform: scale(2)" src="@/assets/images/common/logo-footer.png" alt=""></a>-->
        <!--                    </div>-->
        <!--                    <div class="footer-contact">-->
        <!--                        <div class="address-widget">-->
        <!--                            <div class="address-item pr-50 xs-mb-30">-->
        <!--                                <div class="icon-part">-->
        <!--                                    <i class="flaticon-location"></i>-->
        <!--                                </div>-->
        <!--                                <div class="text-part">-->
        <!--                                    <p class="desc">-->
        <!--                                        503 Old Buffalo Street Northwest<br>-->
        <!--                                        #205 New York-3087-->
        <!--                                    </p>-->
        <!--                                </div>-->
        <!--                            </div>-->
        <!--                            <div class="address-item">-->
        <!--                                <div class="icon-part">-->
        <!--                                    <i class="flaticon-email"></i>-->
        <!--                                </div>-->
        <!--                                <div class="text-part">-->
        <!--                                    <p class="desc">-->
        <!--                                        <a href="tel%2b1234567890.html">(+84) 328-021-619</a>-->
        <!--                                        <a href="milto:infoname@gmail.com">visakrinfo@gmail.com</a>-->
        <!--                                    </p>-->
        <!--                                </div>-->
        <!--                            </div>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <!-- Toàn bộ nội dung footer sửa trong admin: /admin/settings -->
                    <div class="col-lg-4 col-md-12 col-sm-12 footer-widget">
                        <div class="footer-logo md-mb-30 mb-lg-4">
                            <a href="/"><img :src="logoFooter" alt="logo"></a>
                        </div>
                        <div class="textwidget" v-if="settings.footer_intro"><p>{{ settings.footer_intro }}</p></div>
                        <ul class="footer-social md-mb-30">
                            <li v-if="settings.footer_tiktok">
                                <a :href="settings.footer_tiktok" target="_blank">
                                    <img src="@/assets/images/common/tiktok_logo.png">
                                </a>
                            </li>
                            <li v-if="settings.footer_facebook">
                                <a :href="settings.footer_facebook" target="_blank">
                                    <img src="@/assets/images/common/Facebook.png">
                                </a>
                            </li>
                            <li v-if="settings.footer_zalo">
                                <a :href="settings.footer_zalo" target="_blank">
                                    <img src="@/assets/images/common/Logo-zalo.svg">
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-4 col-md-12 col-sm-12 md-mb-30">
                        <template v-if="services.length">
                            <h3 class="widget-title mb-10">Dịch vụ</h3>
                            <div v-for="(item, index) in services" :key="item"
                                 class="textwidget" :class="{ 'mb-40': index === services.length - 1 }"><p>{{ item }}</p></div>
                        </template>

                        <template v-if="officesVn.length">
                            <h3 class="widget-title">Văn Phòng Việt Nam</h3>
                            <div v-for="(item, index) in officesVn" :key="item"
                                 class="textwidget" :class="{ 'mb-40': index === officesVn.length - 1 }">
                                <p><svg-icon :paths="icons.location"></svg-icon>{{ item }}</p>
                            </div>
                        </template>

                        <template v-if="officesKr.length">
                            <h3 class="widget-title">Văn Phòng Hàn Quốc</h3>
                            <div v-for="item in officesKr" :key="item" class="textwidget">
                                <p><svg-icon :paths="icons.location"></svg-icon>{{ item }}</p>
                            </div>
                        </template>
                    </div>

                    <div class="col-lg-4 col-md-12 col-sm-12 footer-widget">
                        <template v-if="contacts.length">
                            <h3 class="widget-title">Liên hệ</h3>
                            <div v-for="(item, index) in contacts" :key="item.label"
                                 class="textwidget" :class="{ 'mb-40': index === contacts.length - 1 }">
                                <p>
                                    <svg-icon :paths="item.icon"></svg-icon>
                                    <a :href="item.href">{{ item.label }}</a>
                                </p>
                            </div>
                        </template>

                        <template v-if="settings.footer_map">
                            <h3 class="widget-title">Vị trí</h3>
                            <div class="w-100">
                                <iframe
                                    :src="settings.footer_map"
                                    width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom" v-if="settings.footer_copyright">
            <div class="copyright text-center">
                <p style="color: white !important;">COPYRIGHT &copy; <a style="color: white !important;" href="/">{{ settings.footer_copyright }}</a></p>
            </div>
        </div>
    </footer>
</template>

<script>
import {h} from 'vue';
import {mapGetters} from "vuex";

const ICONS = {
    location: [
        'M12 2C7.589 2 4 5.589 4 9.995 3.971 16.44 11.696 21.784 12 22c0 0 8.029-5.56 8-12 0-4.411-3.589-8-8-8zm0 12c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z',
    ],
    phone: [
        'M16.57 22a2 2 0 0 0 1.43-.59l2.71-2.71a1 1 0 0 0 0-1.41l-4-4a1 1 0 0 0-1.41 0l-1.6 1.59a7.55 7.55 0 0 1-3-1.59 7.62 7.62 0 0 1-1.59-3l1.59-1.6a1 1 0 0 0 0-1.41l-4-4a1 1 0 0 0-1.41 0L2.59 6A2 2 0 0 0 2 7.43 15.28 15.28 0 0 0 6.3 17.7 15.28 15.28 0 0 0 16.57 22zM6 5.41 8.59 8 7.3 9.29a1 1 0 0 0-.3.91 10.12 10.12 0 0 0 2.3 4.5 10.08 10.08 0 0 0 4.5 2.3 1 1 0 0 0 .91-.27L16 15.41 18.59 18l-2 2a13.28 13.28 0 0 1-8.87-3.71A13.28 13.28 0 0 1 4 7.41zM20 11h2a8.81 8.81 0 0 0-9-9v2a6.77 6.77 0 0 1 7 7z',
        'M13 8c2.1 0 3 .9 3 3h2c0-3.22-1.78-5-5-5z',
    ],
    email: [
        'M20 4H4c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2zm0 2v.511l-8 6.223-8-6.222V6h16zM4 18V9.044l7.386 5.745a.994.994 0 0 0 1.228 0L20 9.044 20.002 18H4z',
    ],
};

// Icon đỏ 24x24 dùng chung cho địa chỉ, điện thoại, email
const SvgIcon = (props) => h('svg', {
    xmlns: 'http://www.w3.org/2000/svg', width: 24, height: 24, viewBox: '0 0 24 24', style: 'fill: #B21818;',
}, props.paths.map(d => h('path', {d})));
SvgIcon.props = ['paths'];

// Tách ô nhiều dòng thành mảng, bỏ dòng trống
const lines = (text) => (text || '').split('\n').map(line => line.trim()).filter(Boolean);

export default {
    name: "Footer",
    components: {SvgIcon},
    data() {
        return {icons: ICONS};
    },
    computed: {
        ...mapGetters('settings', {settings: 'settingsAll', logoFooter: 'logoFooter'}),
        services() {
            return lines(this.settings.footer_services);
        },
        officesVn() {
            return lines(this.settings.footer_office_vn);
        },
        officesKr() {
            return lines(this.settings.footer_office_kr);
        },
        contacts() {
            const s = this.settings;
            const tel = (phone) => 'tel:' + phone.replace(/[^\d+]/g, '');
            return [
                s.contact_phone_kr && {icon: ICONS.phone, label: 'SĐT Hàn Quốc: ' + s.contact_phone_kr, href: tel(s.contact_phone_kr)},
                s.contact_phone_vn && {icon: ICONS.phone, label: 'SĐT Việt Nam: ' + s.contact_phone_vn, href: tel(s.contact_phone_vn)},
                s.contact_zalo && {icon: ICONS.phone, label: 'Zalo: ' + s.contact_zalo, href: 'https://zalo.me/' + s.contact_zalo.replace(/\D/g, '')},
                s.contact_email && {icon: ICONS.email, label: s.contact_email, href: 'mailto:' + s.contact_email},
            ].filter(Boolean);
        },
    },
}
</script>
<style scoped>
footer {
    background-image: url("../assets/images/bg/footer-bg4.jpg") !important;
}

p, a, .widget-title {
    color: #101010 !important;
    font-weight: bold;
    margin-bottom: 5px !important;
}

.widget-title {
    color: #B21818 !important;
    text-transform: uppercase;
    margin-bottom: 60px !important;
    font-weight: 900 !important;
}

.footer-social li a:hover {
    background: white !important;
    border: 1px solid white !important;
    transform: scale(1.2);
}

.footer-bottom {
    background: #B21818;
}

</style>
