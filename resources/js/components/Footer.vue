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
                    <div class="col-lg-3 col-md-12 col-sm-12 footer-widget">
                        <div class="footer-logo md-mb-30 mb-lg-4">
                            <a href="index.html"><img src="@/assets/images/common/logo-footer.png" alt=""></a>
                        </div>
                        <div class="textwidget"><p>Du học SMARTEDU có 4 năm kinh nghiệm trong lĩnh vực du học cả ở thị trường Việt Nam và Hàn Quốc</p>
                        </div>
                        <ul class="footer-social md-mb-30">
                            <li>
                                <a href="#" target="_blank"><span><i class="fa fa-facebook"></i></span></a>
                            </li>
                            <li>
                                <a href="# " target="_blank"><span><i class="fa fa-twitter"></i></span></a>
                            </li>
                            <li>
                                <a href="# " target="_blank"><span><i class="fa fa-pinterest-p"></i></span></a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-12 col-sm-12 pl-45 md-pl-15 md-mb-30">
                        <h3 class="widget-title">Liên hệ</h3>
                        <div class="textwidget"><p>SDT Hàn Quốc: 010 7621 1292</p></div>
                        <div class="textwidget"><p>SDT Việt Nam: 032 915 5366</p></div>
                        <div class="textwidget"><p>Zalo: +840328021619</p></div>
                        <div class="textwidget"><p>Email: duhochanquoc.smartedu@gmail.com</p></div>
                    </div>

                    <div class="col-lg-3 col-md-12 col-sm-12 md-mb-30">
                        <h3 class="widget-title">Dịch vụ</h3>
                        <div class="textwidget"><p>Du học Hàn Quốc</p></div>
                        <div class="textwidget"><p>Lên chuyên ngành</p></div>
                        <div class="textwidget"><p>Tìm việc và đổi visa</p></div>
                    </div>

                    <div class="col-lg-3 col-md-12 col-sm-12 footer-widget">
                        <h3 class="widget-title">Địa chỉ</h3>
<!--                        <div class="textwidget"><p>Văn Phòng Hàn Quốc: 서울시 종로구 창신동 572-1, 2층</p>-->
<!--                        </div>-->
<!--                        <div class="textwidget"><p>Văn Phòng Việt Nam: B9/D6 ngõ 56 Trương Công Giai, Dịch Vọng, Cầu Giấy, Hà Nội</p>-->
<!--                        </div>-->
                        <div class="w-100">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.2802340463045!2d105.79750437343355!3d21.021470288032482!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab5c841661ef%3A0x50d07b06ce1fd6fe!2zNDggxJAuIE5ndXnhu4VuIEtoYW5nLCBZw6puIEhvw6AsIEPhuqd1IEdp4bqleSwgSMOgIE7hu5lpLCBWaWV0bmFt!5e0!3m2!1sen!2s!4v1717644148353!5m2!1sen!2s" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="copyright text-center">
                <p>COPYRIGHT &copy; <a href="#">DU HỌC HÀN QUỐC SMARTEDU</a></p>
            </div>
        </div>
    </footer>
</template>

<script>
export default {
    name: "Footer"
}
</script>
<style scoped>
footer{
    background-image: url("../assets/images/bg/footer-bg4.jpg") !important;
}
p, a, .widget-title{
    color: #101010 !important;
    font-weight: bold;
    margin-bottom: 5px !important;
}
.widget-title{
    color: #ed1e24 !important;
    text-transform: uppercase;
    margin-bottom: 60px !important;
}
.footer-social li a:hover{
    color: white!important;
}
</style>
