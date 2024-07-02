<template>
    <!-- Banner Section Start -->
    <div class="banner-section style5 h-50 gray-bg2">
        <div :class="{'custom-box': form}">
            <swiper
                :spaceBetween="30"
                :centeredSlides="true"
                :autoplay="{
                    delay: 2500,
                    disableOnInteraction: false,
                }"
                :navigation="isNavigationEnabled"
                :modules="modules"
                class="mySwiper"
            >
                <swiper-slide class="ct-swiper-slide" v-if="!defaultImg" v-for="(image, index) in images"
                              :key="image.id"
                              :style="{
                                'background-image': 'url(' + image.image_path + ')'
                              }">
                    <a :href="image.link" target="_blank" class="full-link">

                    </a>
                </swiper-slide>
                <swiper-slide v-if="defaultImg">
                    <img class="w-100 h-100 banner-img" src="@/assets/images/common/banner-2.jpg" alt="logo">
                </swiper-slide>
                <swiper-slide v-if="defaultImg">
                    <img class="w-100 h-100 banner-img" src="@/assets/images/common/banner-3.jpg" alt="logo">
                </swiper-slide>
            </swiper>
            <FormRequest v-if="form" style="z-index: 10;" @send-request="sendData" :statusBtn="statusBtn"></FormRequest>
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
import { ref, onMounted, onUnmounted, watch } from 'vue';

export default {
    name: "Banner",
    components: {
        FormRequest,
        Swiper,
        SwiperSlide,
    },
    setup() {
        const modules = [Autoplay, Navigation];
        const isNavigationEnabled = ref(true);

        const updateNavigation = () => {
            if (window.innerWidth <= 576) {
                isNavigationEnabled.value = false;
            } else {
                isNavigationEnabled.value = true;
            }
        };

        onMounted(() => {
            updateNavigation();
            window.addEventListener('resize', updateNavigation);
        });

        onUnmounted(() => {
            window.removeEventListener('resize', updateNavigation);
        });

        return {
            modules,
            isNavigationEnabled,
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
            default: () => [
                {
                    id: 1,
                    title: "Banner 1",
                    image_path: "#",
                    link: "#",
                },
            ],
        },
        defaultImg: {
            type: Boolean,
            default: true,
        }
    },
    methods: {
        sendData(data) {
            this.$emit('send-request', data);
        }
    }
};
</script>

<style scoped>
.carousel-control-prev, .carousel-control-next {
    background: rgba(255, 255, 255, 0);
    border: none;
    height: 400px;
}

.carousel-item {
    height: 450px;
}

#app {
    height: 100%;
}

html,
body {
    position: relative;
    height: 100%;
}

body {
    background: #eee;
    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
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
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    line-height: 300px;
    text-align: center;
}

.banner-img {
    object-fit: contain;
}
.ct-swiper-slide{
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-size: contain;
    background-position: top;
}
.full-link {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
    text-indent: -9999px;
}
@media screen and (max-width: 991px) {
    .swiper {
        height: 35vh;
    }
    .ct-swiper-slide{
        background-size: auto 100%;
    }
    .swiper-slide {
        line-height: 200px;
    }
    .custom-box {
        padding-top: 70px;
    }
}

@media screen and (max-width: 768px) {
    .swiper {
        height: 35vh;
    }
    .ct-swiper-slide{
        background-size: auto 100%;
    }
    .swiper-slide {
        line-height: 150px;
    }
    .custom-box {
        padding-top: 70px;
    }
}

@media screen and (max-width: 576px) {
    .swiper {
        height: 40vh;
    }
    .ct-swiper-slide{
        background-size: auto 100%;
    }
    .swiper-slide {
        line-height: 100px;
    }
    .banner-img {
        width: 100%;
        height: auto;
    }
    .custom-box {
        padding-top: 70px;
    }
}

@media screen and (min-width: 992px) {
    .custom-box {
        padding-top: 100px;
    }
}
/*.banner-img{*/
/*    width: 100% !important;*/
/*    height: 100% !important;*/
/*    object-fit: cover;*/
/*}*/
</style>
