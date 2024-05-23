<template>
    <div id="rs-about" class="rs-about main-home pt-50 pb-100 md-pt-80 md-pb-80 gray-bg2">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="sec-title2 mb-40">
                        <h2 class="title pb-25">
                            Tin Tức và Sự Kiện
                        </h2>
                    </div>
                </div>
            </div>
            <swiper :watchSlidesProgress="true" :slidesPerView="4" class="mySwiper">
                <swiper-slide>
                    <div class="team-wrap">
                        <div class="image-wrap">
                            <a href="#"><img src="@/assets/images/team/6.jpg" alt="Images"></a>
                        </div>
                        <div class="team-content">
                            <h3 class="team-name">
                                Đây là Tiếng nói Việt Nam, phát thanh từ Hà Nội, thủ đô nước Cộng hòa Xã
                            </h3>
                            <p class="description">Đây là Tiếng nói Việt Nam, phát thanh từ Hà Nội, thủ đô nước Cộng hòa Xã hội chủ nghĩa Việt Nam.</p>
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
                                Posts 2
                            </h3>
                            <p class="description">Đây là Tiếng nói Việt Nam, phát thanh từ Hà Nội, thủ đô nước Cộng hòa Xã hội chủ nghĩa Việt Nam.</p>
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
                                Posts 3
                            </h3>
                            <p class="description">Đây là Tiếng nói Việt Nam, phát thanh từ Hà Nội, thủ đô nước Cộng hòa Xã hội chủ nghĩa Việt Nam.</p>
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
                                Posts 4
                            </h3>
                            <p class="description">Đây là Tiếng nói Việt Nam, phát thanh từ Hà Nội, thủ đô nước Cộng hòa Xã hội chủ nghĩa Việt Nam.</p>
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
                                Posts 5
                            </h3>
                            <p class="description">Đây là Tiếng nói Việt Nam, phát thanh từ Hà Nội, thủ đô nước Cộng hòa Xã hội chủ nghĩa Việt Nam.</p>
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
                                Posts 6
                            </h3>
                            <p class="description">Đây là Tiếng nói Việt Nam, phát thanh từ Hà Nội, thủ đô nước Cộng hòa Xã hội chủ nghĩa Việt Nam.</p>
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
    height: 65%;
}
.image-wrap img{
    width: 100%;
    height: 100%;
    object-fit: cover;
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

</style>
