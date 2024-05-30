<template>
    <div style="height: 100vh" class="container rounded">
        <div v-if="!formShow" class="sec-title text-center mb-60 md-mb-40">
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
        <hr>
        <section class="photo-gallery">
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
                <!--                <button type="button" class="btn-close" @click="closeModal" data-bs-dismiss="modal" aria-label="Close">-->
                <!--                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="m16.192 6.344-4.243 4.242-4.242-4.242-1.414 1.414L10.535 12l-4.242 4.242 1.414 1.414 4.242-4.242 4.243 4.242 1.414-1.414L13.364 12l4.242-4.242z"></path></svg>-->
                <!--                </button>-->
                <div class=" modal-dialog modal-xl modal-content overflow-hidden m-0">
                    <div class="modal-body d-flex align-items-center justify-content-center">
                        <div class="w-100">
                            <div id="lightboxCarousel" class="carousel slide carousel-fade d-flex justify-content-between" data-bs-ride="true">
                                <div class="carousel-indicators">
                                    <button
                                        class="mx-2"
                                        v-for="(image, index) in images"
                                        :key="index"
                                        type="button"
                                        data-bs-target="#lightboxCarousel"
                                        :data-bs-slide-to="index"
                                        :class="{ active: index === currentIndex }"
                                        :aria-current="index === currentIndex ? 'true' : ''"
                                        :aria-label="`Slide ${index + 1}`">
                                    </button>
                                </div>
                                <div class="carousel-inner justify-content-center align-items-center mx-auto" style="width: 80%">
                                    <div
                                        v-for="(image, index) in images"
                                        :key="index"
                                        class="carousel-item"
                                        :class="{ active: index === currentIndex }">
                                        <img class="d-block img-fluid w-100" style="height: 70vh; width: 100%;object-fit: cover" :src="image.image_path" :alt="image.title">
                                        <div v-if="image.title" class="carousel-caption d-none d-md-block">
                                            <h4 class="m-0 text-white">{{ image.title }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <button class="carousel-control-prev btn-custom" style="width: 10%" @click="prevSlide" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8z"></path><path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path></svg>
                                </button>
                                <button class="carousel-control-next btn-custom" style="width: 10%" @click="nextSlide" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8z"></path><path d="M9.293 7.707 13.586 12l-4.293 4.293 1.414 1.414L16.414 12l-5.707-5.707z"></path></svg>
                                </button>
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
        nextSlide() {
            this.currentIndex = (this.currentIndex + 1) % this.images.length;
        },
        prevSlide() {
            this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
        },
        enterFS() {
            const elem = document.querySelector('.lightbox-content');
            if (elem.requestFullscreen) {
                elem.requestFullscreen();
            } else if (elem.webkitRequestFullscreen) {
                elem.webkitRequestFullscreen();
            } else if (elem.msRequestFullscreen) {
                elem.msRequestFullscreen();
            }
            document.querySelector('.btn-fullscreen-enlarge').classList.add('d-none');
            document.querySelector('.btn-fullscreen-exit').classList.remove('d-none');
        },
        exitFS() {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            }
            document.querySelector('.btn-fullscreen-enlarge').classList.remove('d-none');
            document.querySelector('.btn-fullscreen-exit').classList.add('d-none');
        }
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
