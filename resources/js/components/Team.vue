<template>
    <div id="rs-about" class="rs-about main-home pt-120 pb-120 md-pt-80 md-pb-80">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="sec-title2 mb-40">
                        <h2 class="title pb-25">
                            Đôi ngũ cán bộ
                        </h2>
                        <div class="desc">
                            Những người có kiến thức sâu rộng về luật pháp và quy trình liên quan đến visa và thủ tục nhập cư, giúp sinh viên xử lý các vấn đề liên quan đến visa một cách thuận lợi nhất.
                        </div>
                    </div>
                </div>
            </div>
            <swiper :watchSlidesProgress="true" :slidesPerView="3" class="mySwiper">
                <swiper-slide>
                    <div class="team-wrap">
                        <div class="image-wrap">
                            <a href="#"><img src="@/assets/images/team/6.jpg" alt="Images"></a>
                        </div>
                        <div class="team-content">
                            <h3 class="team-name">
                                Mincin Funo
                            </h3>
                        </div>
                    </div>
                </swiper-slide>

                <swiper-slide>
                    <div class="team-wrap">
                        <div class="image-wrap">
                            <a href="#"><img src="@/assets/images/team/7.jpg" alt="Images"></a>
                        </div>
                        <div class="team-content">
                            <h3 class="team-name">
                                Mincin Funo
                            </h3>
                        </div>
                    </div>
                </swiper-slide>

                <swiper-slide>
                    <div class="team-wrap">
                        <div class="image-wrap">
                            <a href="#"><img src="@/assets/images/team/8.jpg" alt="Images"></a>
                        </div>
                        <div class="team-content">
                            <h3 class="team-name">
                                Mincin Funo
                            </h3>
                        </div>
                    </div>
                </swiper-slide>

                <swiper-slide>
                    <div class="team-wrap">
                        <div class="image-wrap">
                            <a href="#"><img src="@/assets/images/team/9.jpg" alt="Images"></a>
                        </div>
                        <div class="team-content">
                            <h3 class="team-name">
                                Mincin Funo
                            </h3>
                        </div>
                    </div>
                </swiper-slide>

                <swiper-slide>
                    <div class="team-wrap">
                        <div class="image-wrap">
                            <a href="#"><img src="@/assets/images/team/5.jpg" alt="Images"></a>
                        </div>
                        <div class="team-content">
                            <h3 class="team-name">
                                Mincin Funo
                            </h3>
                        </div>
                    </div>
                </swiper-slide>

                <swiper-slide>
                    <div class="team-wrap">
                        <div class="image-wrap">
                            <a href="#"><img src="@/assets/images/team/4.jpg" alt="Images"></a>
                        </div>
                        <div class="team-content">
                            <h3 class="team-name">
                                Mincin Funo
                            </h3>
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

<style>
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
    width: 800px;
    height: 350px;
    background: white !important;
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
    height: 100%;
}
.image-wrap img{
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.team-content{
    width: 100%;
    height: 30%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255);
}
.team-name{
    font-size:20px;
    margin: 0;
}

</style>
