<template>
    <!-- Banner Section Start -->
    <div class=" style5 h-50 gray-bg2">
        <div class="custom-box">
            <swiper
                :spaceBetween="30"
                :centeredSlides="true"
                :autoplay="{
          delay: 2500,
          disableOnInteraction: false,
        }"
                :navigation="true"
                :modules="modules"
                class="mySwiper"
            >
                <swiper-slide><img class="w-100 h-100 banner-img" src="@/assets/images/common/banner-3.jpg" alt="logo"></swiper-slide>
                <swiper-slide><img class="w-100 h-100 banner-img" src="@/assets/images/common/banner-2.jpg" alt="logo"></swiper-slide>
                <swiper-slide><img class="w-100 h-100 banner-img" src="@/assets/images/common/banner-3.jpg" alt="logo"></swiper-slide>
            </swiper>
            <FormRequest style="z-index: 10;"></FormRequest>
        </div>
    </div>
    <!-- Banner Section End -->

</template>

<script>
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import { Autoplay, Navigation } from 'swiper/modules';
import FormRequest from "@/components/FormRequest.vue";
export default {
    components: {
        FormRequest,
        Swiper,
        SwiperSlide,
    },
    setup() {
        return {
            modules: [Autoplay, Navigation],
        };
    },
};
</script>

<style scoped>
.carousel-control-prev, .carousel-control-next{
    background: rgb(255, 255, 255,0);
    border: none;
    height: 400px;
}
.carousel-item{
    height: 450px;
}
#app { height: 100% }
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
}
.swiper-slide {
    height: 350px;
    line-height: 300px;
    text-align: center;
}
.banner-img{
    object-fit: contain;
}

@media screen and (min-width: 992px) {
    .custom-box {
        padding-top: 100px;
    }
}
</style>
