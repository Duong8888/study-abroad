<template>
    <!-- Banner Section Start -->
    <div class=" style5 h-50 gray-bg2">
        <div :class="{'custom-box': form}">
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
                <swiper-slide v-if="!defaultImg" v-for="(image,index) in images" :key="image">
                    <a :href="image.link" target="_blank">
                        <img class="w-100 h-100 banner-img" :src="image.image_path" :alt="image.title">
                    </a>
                </swiper-slide>
                <swiper-slide v-if="defaultImg"><img class="w-100 h-100 banner-img" src="@/assets/images/common/banner-2.jpg" alt="logo">
                </swiper-slide>
                <swiper-slide v-if="defaultImg"><img class="w-100 h-100 banner-img" src="@/assets/images/common/banner-3.jpg" alt="logo">
                </swiper-slide>
            </swiper>
            <FormRequest v-if="form" style="z-index: 10;" @send-request="senData" :statusBtn="statusBtn"></FormRequest>
        </div>
    </div>
    <!-- Banner Section End -->

</template>

<script>
import {Swiper, SwiperSlide} from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import {Autoplay, Navigation} from 'swiper/modules';
import FormRequest from "@/components/FormRequest.vue";

export default {
    name: "Banner",
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
    props: {
        statusBtn: Boolean,
        form: {
            type: Boolean,
            default: true,
        },
        images: {
            type: Array,
            default: [
                {
                    id: 1,
                    title: "Banner 1",
                    image_path: "#",
                    link: "#",
                },
            ],
        },
        defaultImg:{
            type: Boolean,
            default: true,
        }
    },
    methods: {
        senData(data) {
            this.$emit('send-request', data);
        }
    }
};
</script>

<style scoped>
.carousel-control-prev, .carousel-control-next {
    background: rgb(255, 255, 255, 0);
    border: none;
    height: 400px;
}

.carousel-item {
    height: 450px;
}

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
    height: 80vh;
}

.swiper-slide {
    height: 100%;
    line-height: 300px;
    text-align: center;
}

.banner-img {
    object-fit: contain;
}

@media screen and (min-width: 992px) {
    .custom-box {
        padding-top: 100px;
    }
}
</style>
