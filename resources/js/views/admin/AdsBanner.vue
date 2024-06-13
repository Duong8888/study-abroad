<template>
    <div class="container rounded">
        <div v-if="!formShow && images.length > 0" class="sec-title text-center mb-60 md-mb-40">
            <h2 class="title title2 pb-13">
                Một số hình ảnh của <span style="color: #ed1e24">SMARTEDU</span>
            </h2>
            <div class="heading-border-line"></div>
        </div>
        <div v-if="formShow" class="d-flex justify-content-end">
            <router-link :to="{name:'EditBanner',query: { type: 'ads' }}">
                <button class="btn btn-outline-secondary float-right mr-2">Chỉnh sửa banner banner</button>
            </router-link>
            <router-link :to="{name:'AddBanner',query: { type: 'ads' }}">
                <button class="btn btn-outline-primary float-right">Thêm mới banner</button>
            </router-link>
        </div>
        <hr v-if="formShow">
        <section v-if="images.length > 0" class="photo-gallery">
            <div class="container">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 gallery-grid">
                    <div v-for="(image, index) in images" :key="index" class="col p-4" style="width: 100%; height: 250px; overflow: hidden">
                        <a class="gallery-item" style="width: 100%; height: 100%; overflow: hidden" :href="image.image_path" @click.prevent="showLightbox(index)">
                            <img :src="image.image_path" style="width: 100%; height: 100%" class="img-fluid" :alt="image.title">
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <div class="modal fade lightbox-modal" id="lightbox-modal" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class=" modal-dialog modal-xl modal-content overflow-hidden m-0">
                    <div class="modal-body d-flex align-items-center justify-content-center p-0">
                        <div class="w-100">
                            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item" v-for="(image, index) in images" :key="index" :class="{ active: index === currentIndex }">
                                        <img class="d-block w-100" style="height: 70vh; width: 100%;object-fit: cover" :src="image.image_path" :alt="image.title" alt="First slide">
                                    </div>
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    data() {
        return {
            images: [],
            currentIndex: 0,
        };
    },
    computed:{
        ...mapGetters('banner',['bannerAll']),
    },
    created() {
        this.fetchBanner(1);
    },
    props:{
        formShow:{
            type: Boolean,
            default: true
        }
    },
    watch:{
        bannerAll: function (newTitle) {
            this.images = newTitle;
        },
    },
    methods: {
        ...mapActions('banner',['fetchBanner']),
        showLightbox(index) {
            this.currentIndex = index;
            const lightboxModal = new bootstrap.Modal(document.getElementById('lightbox-modal'));
            lightboxModal.show();
        },
    }
};
</script>

<style scoped>
.photo-gallery {
    color: #313437;
    background-color: #fff;
}
.photo-gallery p {
    color: #7d8285;
}
.photo-gallery h2 {
    font-weight: bold;
    margin-bottom: 40px;
    padding-top: 40px;
    color: inherit;
}
@media (max-width: 767px) {
    .photo-gallery h2 {
        margin-bottom: 25px;
        padding-top: 25px;
        font-size: 24px;
    }
}
.photo-gallery .intro {
    font-size: 16px;
    max-width: 500px;
    margin: 0 auto 40px;
}
.photo-gallery .intro p {
    margin-bottom: 0;
}
.photo-gallery .photos {
    padding-bottom: 20px;
}
.photo-gallery .gallery-grid img {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: .15s ease;
}
.photo-gallery .gallery-grid a {
    display: block;
    overflow: hidden;
    border-radius: 4px;
}
.photo-gallery .gallery-grid a:hover img {
    transform: scale(1.05);
}
.lightbox-content {
    width: 100%;
    max-width: 900px;
    min-height: 400px;
    aspect-ratio: 3/2;
}
.lightbox-modal .btn-close {
    z-index: 1;
    width: 3rem;
    height: 3rem;
}
.lightbox-modal .btn-fullscreen-enlarge,
.lightbox-modal .btn-fullscreen-exit {
    position: absolute;
    z-index: 1;
    top: 1rem;
    right: 4.5rem;
    padding: 0.5rem 0.7rem;
    color: #fff;
    background: rgba(0,0,0,.5);
    border: none;
    font-size: 2rem;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    transition: opacity .15s ease;
}
.lightbox-modal .btn-fullscreen-enlarge:hover,
.lightbox-modal .btn-fullscreen-exit:hover {
    color: #fff;
    background: rgba(0,0,0,.8);
}
.carousel-indicators button {
    background-color: rgba(0,0,0,.5);
    border: none;
}
.carousel-indicators .active {
    background-color: #fff;
}
.btn-custom{
    border: none;
    background: rgba(0,0,0,0);
}

.btn-custom span{
    color: red;
}
.btn-close{
    float: right;
    border: none;
}
</style>
