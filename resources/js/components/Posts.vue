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
            <swiper :watchSlidesProgress="true" :slidesPerView="getSlidesPerView()" class="mySwiper">
                <swiper-slide v-for="(item, index) in items" :key="index">
                    <router-link :to="{name: 'PostsDetail', params: {slug: item?.slug}}">
                        <div class="team-wrap">
                            <div class="image-wrap">
                                <a href="#"><img :src="item.thumbnail" alt="Images" class="team-image"></a>
                            </div>
                            <div class="team-content">
                                <h3 class="team-name">
                                    {{ item.title }}
                                </h3>
                                <p class="description text-black-50">{{ item.description }}</p>
                            </div>
                        </div>
                    </router-link>
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
    props: {
        items: {
            type: Array,
            default: [
                {title: 'Bài viết 1', description: 'Nội dung bài viết 1', avatar: '/assets/images/team/6.jpg'},
                {title: 'Bài viết 2', description: 'Nội dung bài viết 2', avatar: '/assets/images/team/7.jpg'},
                {title: 'Bài viết 3', description: 'Nội dung bài viết 3', avatar: '/assets/images/team/8.jpg'},
                {title: 'Bài viết 4', description: 'Nội dung bài viết 4', avatar: '/assets/images/team/9.jpg'},
                {title: 'Bài viết 5', description: 'Nội dung bài viết 5', avatar: '/assets/images/team/5.jpg'},
                {title: 'Bài viết 6', description: 'Nội dung bài viết 6', avatar: '/assets/images/team/4.jpg'},
            ]
        }
    },
    methods: {
        getSlidesPerView() {
            if (window.innerWidth < 576) {
                return 1;
            } else if (window.innerWidth < 992) {
                return 2;
            } else {
                return 3;
            }
        },
    },
};
</script>

<style scoped>
#app {
    height: 100%;
}

html, body {
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
}

.team-wrap {
    overflow: hidden;
    margin: 0 5px;
    height: 100%;
    display: flex;
    flex-direction: column;
    border: 1px solid #CCCCCC;
    border-radius: 10px;
}

.image-wrap {
    width: 100%;
    height: 65%;
}

.image-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.team-content {
    width: 100%;
    height: 35%;
    background: rgba(255, 255, 255);
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

@media (max-width: 768px) {
    .swiper {
        height: auto;
    }
}

@media (min-width: 992px) {
    .swiper-slide {
        width: calc(100% / 3);
    }
}

</style>
