<template>

    <div id="rs-about" class="rs-about main-home pt-50 pb-100 md-pt-80 md-pb-80 gray-bg2">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="sec-title2 mb-40">
                        <h2 class="title pb-25">
                            Cảm nhận học viên
                        </h2>
                    </div>
                </div>
            </div>
            <swiper :watchSlidesProgress="true" :slidesPerView="1" class="mySwiper">
                <swiper-slide>
                    <div class="test-item">
                        <div class="author-desc">
                            <div class="desc"><img width="40px" class="quote" src="@/assets/images/testimonial/main-home/quote.png" alt=""><p style="padding: 0 20px">Cảm nhận của em về trung tâm SMARTEDU là có chương trình du học rõ ràng về học phí, phí Visa, hỗ trợ học sinh cả bên Việt Nam và Hàn Quốc (gồm cả Lên chuyên ngành và chuyển trường)</p></div>
                        </div>
                        <div class="author-part">
                            <div class="author-img">
                                <img src="@/assets/images/testimonial/main-home/avatar/1.jpg" alt="">
                            </div>
                            <a class="name" href="#">Ánh Dương</a>
                        </div>
                    </div>
                </swiper-slide>

                <swiper-slide>
                    <div class="test-item">
                        <div class="author-desc">
                            <div class="desc"><img width="40px" class="quote" src="@/assets/images/testimonial/main-home/quote.png" alt=""><p style="padding: 0 20px">Mục tiêu của em là sau 3 tháng có thể giao tiếp cơ bản tiếng Hàn và sang Hàn để học tiếp, em thấy mình đã chọn đúng trung tâm SMARTEDU</p></div>
                        </div>
                        <div class="author-part">
                            <div class="author-img">
                                <img src="@/assets/images/testimonial/main-home/avatar/1.jpg" alt="">
                            </div>
                            <a class="name" href="#">An</a>
                        </div>
                    </div>
                </swiper-slide>

                <swiper-slide>
                    <div class="test-item">
                        <div class="author-desc">
                            <div class="desc"><img width="40px" class="quote" src="@/assets/images/testimonial/main-home/quote.png" alt=""><p style="padding: 0 20px">Mục tiêu của em là sau 3 tháng có thể giao tiếp cơ bản tiếng Hàn và sang Hàn để học tiếp, em thấy mình đã chọn đúng trung tâm SMARTEDU</p></div>
                        </div>
                        <div class="author-part">
                            <div class="author-img">
                                <img src="@/assets/images/testimonial/main-home/avatar/1.jpg" alt="">
                            </div>
                            <a class="name" href="#">Thịnh</a>
                        </div>
                    </div>
                </swiper-slide>
            </swiper>
        </div>
    </div>
</template>
<script>
import {Swiper, SwiperSlide} from 'swiper/vue';
import 'swiper/css';

export default {
    components: {
        Swiper,
        SwiperSlide,
    },
    setup() {
        return {};
    },
};
</script>

<style scoped>
#app {
    height: 100%
}

html,
body {
    position: relative;
    height: 100%;
}

body {
    background: #eee;
    font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
    font-size: 14px;
    color: #000;
    margin: 0;
    padding: 0;
}

.swiper {
    width: 100%;
    height: auto;
    background: rgba(255,255,255,0) !important;
}
.team-wrap{
    overflow: hidden;
    margin: 0 5px;
    height: 100%;
    display: flex;
    flex-direction: column;
    border: 1px solid #CCCCCC;
    border-radius: 10px;
}
.image-wrap{
    width: 100%;
    height: 65%;
}
.team-content{
    width: 100%;
    height: 35%;
    background: rgba(255,255,255);
    display: flex;
    flex-direction: column;
    justify-content: start;
    align-items: self-start;
    padding: 10px;
}

.team-name {
    font-size: 20px;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    width: 100%;
}

.description {
    font-size: 14px;
    margin: 0;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    white-space: normal;
    text-overflow: ellipsis;
    width: 100%;
}

.team-name{
    font-size:20px;
    margin: 0;
}
.test-item{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    border-radius: 10px;
    background: white;
    padding: 30px;
    margin: 0 10px;
}
.author-desc{
    width: 100%;
}
.desc{
    text-align: center;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
.author-part{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
.author-img{
    width: 50px;
    height: 50px;
    border-radius: 50%;
    overflow: hidden;
}
.author-img img{
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>
