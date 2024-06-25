<template>
    <div id="rs-about" class="rs-about main-home pb-20 md-pt-80 md-pb-80 gray-bg2 pt-20" style="background: red">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="sec-title2 mb-40">
                        <h2 class="title">
                            {{title}}
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

<!--                    <router-link :to="{name: 'PostsDetail', params: {slug: item?.slug}}">-->
<!--                        <div class="card p-3 h-100 overflow-hidden item-posts" style="margin: 0 5px">-->
<!--                            <div class="position-relative rounded-2 overflow-hidden" style="height: 200px;">-->
<!--                                <img class="card-img-top rounded-0" :src="item?.thumbnail"-->
<!--                                     alt="...">-->
<!--                            </div>-->
<!--                            <div class="card-body d-flex flex-column align-items-start mw-xs">-->
<!--                                <h6 class="card-title mb-3">{{ item?.title }}</h6>-->
<!--                                <p class="card-text small text-light-dark mb-6 description">-->
<!--                                    {{ item?.description }}</p>-->
<!--&lt;!&ndash;                                <div class="mt-auto">&ndash;&gt;-->
<!--&lt;!&ndash;                                    <svg width="4" height="4" viewbox="0 0 4 4" fill="none"&ndash;&gt;-->
<!--&lt;!&ndash;                                         xmlns="http://www.w3.org/2000/svg">&ndash;&gt;-->
<!--&lt;!&ndash;                                        <circle cx="2" cy="2" r="2" fill="#D1D1D1"></circle>&ndash;&gt;-->
<!--&lt;!&ndash;                                    </svg>&ndash;&gt;-->
<!--&lt;!&ndash;                                    <span v-for="category in JSON.parse(item?.post_type_id)" :key="category"&ndash;&gt;-->
<!--&lt;!&ndash;                                          class="badge ms-3 small fw-medium text-light-dark border mr-2 category">{{&ndash;&gt;-->
<!--&lt;!&ndash;                                            category.name&ndash;&gt;-->
<!--&lt;!&ndash;                                        }}</span>&ndash;&gt;-->
<!--&lt;!&ndash;                                </div>&ndash;&gt;-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </router-link>-->
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
            ]
        },
        title:{
            type: String,
            default: "Tin Tức và Sự Kiện",
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
    height: 400px;
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
    transition: 0.5s;
}

.team-wrap:hover .team-content{
    background: #ed1e24;
}

.team-wrap:hover .team-name{
    color: white;
    text-decoration: underline;
}

.team-wrap:hover .description{
    color: white !important;
}

.team-name {
    font-size: 20px;
    margin: 0;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    white-space: normal;
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
    color: #4a5568;
}

@media (max-width: 768px) {
    .swiper {
        height: auto;
        padding: 0 10px;
        display: none;
    }
    .image-wrap img {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }
}

@media (min-width: 992px) {
    .swiper-slide {
        width: calc(100% / 3);
    }
}

.card-img-top {
    height: 100%;
    object-fit: cover;
    border-radius: 3px !important;
}

.description {
    font-size: 14px;
    margin: 0;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    white-space: normal;
    text-overflow: ellipsis;
    width: 100%;
}
.item-posts{
    transition: 0.5s;
}
.item-posts:hover{
    background: #ed1e24 !important;
}

.item-posts:hover .card-text{
    color: white !important;
}

.item-posts:hover .card-title{
    color: white !important;
    text-decoration: underline;
}

.item-posts:hover .category{
    color: white !important;
}

</style>
